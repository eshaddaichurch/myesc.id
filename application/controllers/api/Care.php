<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Care extends BaseApi
{
    const STATUS_AWAL = 'Permohonan';
    const OTORISASI_ADMIN = '0005';
    const KODE_FC1 = 'KL002';
    const PATTERN_HP = '/^0[0-9]{9,14}$/';
    const PATTERN_TGL = '/^\d{4}-\d{2}-\d{2}$/';

    // GET /api/care/form?layanan=
    public function form()
    {
        $idjemaat = $this->requireAuth();
        $cfg = $this->_layananDariInput();
        if ($cfg === null) {
            $this->jsonError('Layanan tidak ditemukan.', 404);
            return;
        }

        $jemaat = $this->db->query('SELECT nohp FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
        if (!$jemaat) {
            $this->jsonError('Data jemaat tidak ditemukan.');
            return;
        }

        $opsi = array();
        if (isset($cfg['lookup'])) {
            $l = $cfg['lookup'];
            $opsi = $this->db->query(
                "SELECT {$l['id']} AS id, {$l['nama']} AS nama FROM {$l['tabel']} WHERE statusaktif = 'Aktif' ORDER BY {$l['nama']}",
                array()
            )->result();
        }

        $alasan = $this->_cekSyarat($cfg, $idjemaat);

        $this->jsonSuccess(array(
            'nama' => $cfg['nama'],
            'nohp' => $jemaat->nohp,
            'bisaAjukan' => $alasan === null,
            'alasan' => $alasan,
            'opsi' => $opsi,
            'field' => $this->_daftarField($cfg),
        ));
    }

    // GET /api/care/riwayat?layanan=
    public function riwayat()
    {
        $idjemaat = $this->requireAuth();
        $cfg = $this->_layananDariInput();
        if ($cfg === null) {
            $this->jsonError('Layanan tidak ditemukan.', 404);
            return;
        }

        $rows = $this->db->query(
            "SELECT {$cfg['pk']} AS id, status, tglinsert FROM {$cfg['tabel']} WHERE idjemaat = ? ORDER BY tglinsert DESC LIMIT 20",
            array($idjemaat)
        )->result();

        $data = array();
        foreach ($rows as $r) {
            $data[] = array(
                'id' => $r->id,
                'status' => $r->status,
                'tglinsert' => $r->tglinsert,
                'bisaBatal' => $r->status === self::STATUS_AWAL,
            );
        }

        $this->jsonSuccess(array('data' => $data));
    }

    // POST /api/care/ajukan
    public function ajukan()
    {
        $idjemaat = $this->requireAuth();
        $cfg = $this->_layananDariInput();
        if ($cfg === null) {
            $this->jsonError('Layanan tidak ditemukan.', 404);
            return;
        }

        $alasan = $this->_cekSyarat($cfg, $idjemaat);
        if ($alasan !== null) {
            $this->jsonError($alasan);
            return;
        }

        $jemaat = $this->db->query('SELECT nohp FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
        $nohpJemaat = $jemaat ? $jemaat->nohp : '';

        $input = array();   // nilai mentah, untuk pesan WhatsApp
        $kolom = array(     // nilai yang disimpan ke database
            'tglinsert' => date('Y-m-d H:i:s'),
            'idjemaat' => $idjemaat,
            'status' => self::STATUS_AWAL,
        );

        foreach ($cfg['field'] as $nama => $aturan) {
            $raw = $this->input->post($nama);
            if ($raw === null && $nama === 'nohpyangbisadihubungi') {
                $raw = $nohpJemaat;
            }

            $err = null;
            $nilai = $this->_validasi($aturan, $cfg, $raw, $err);
            if ($err !== null) {
                $this->jsonError($err);
                return;
            }

            $input[$nama] = $nilai;
            $kolom[$aturan['kolom']] = $aturan['tipe'] === 'teks'
                ? htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8')
                : $nilai;
        }

        if (isset($cfg['auto'])) {
            foreach ($cfg['auto'] as $kolomAuto => $nilaiAuto) {
                if ($nilaiAuto === 'now') {
                    $kolom[$kolomAuto] = date('Y-m-d H:i:s');
                }
            }
        }

        $this->db->trans_start();
        $this->db->insert($cfg['tabel'], $kolom);
        $idBaru = $this->db->insert_id();

        if (!empty($cfg['notif'])) {
            $this->_buatNotifAdmin($cfg, $idjemaat, $idBaru);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'Care::ajukan gagal untuk ' . $cfg['tabel'] . ' idjemaat=' . $idjemaat . ' - ' . json_encode($this->db->error()));
            $this->jsonError('Permohonan gagal disimpan. Silakan coba lagi.');
            return;
        }

        if (!empty($cfg['wa_admin'])) {
            $this->_kirimWaAdmin($cfg, $idjemaat, $input);
        }

        $this->jsonSuccess(array('msg' => 'Permohonan berhasil diajukan.'));
    }

    // POST /api/care/batal  (body: layanan, id)
    public function batal()
    {
        $idjemaat = $this->requireAuth();
        $cfg = $this->_layananDariInput();
        if ($cfg === null) {
            $this->jsonError('Layanan tidak ditemukan.', 404);
            return;
        }

        $id = trim((string) $this->input->post('id'));
        if (!preg_match('/^[0-9]{1,15}$/', $id)) {
            $this->jsonError('Permohonan tidak valid.');
            return;
        }

        $row = $this->db->query(
            "SELECT status FROM {$cfg['tabel']} WHERE {$cfg['pk']} = ? AND idjemaat = ? LIMIT 1",
            array($id, $idjemaat)
        )->row();

        if (!$row) {
            $this->jsonError('Permohonan tidak ditemukan.', 404);
            return;
        }

        if ($row->status !== self::STATUS_AWAL) {
            $this->jsonError('Permohonan yang sudah diproses tidak dapat dibatalkan.');
            return;
        }

        $this->db->trans_start();
        $this->db->query(
            "DELETE FROM {$cfg['tabel']} WHERE {$cfg['pk']} = ? AND idjemaat = ? AND status = ?",
            array($id, $idjemaat, self::STATUS_AWAL)
        );
        if (!empty($cfg['notif'])) {
            $this->db->query(
                'DELETE FROM notifikasi WHERE idlinknotifikasi = ? AND jenisnotifikasi = ?',
                array($id, $cfg['notif']['jenis'])
            );
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'Care::batal gagal untuk ' . $cfg['tabel'] . ' id=' . $id . ' - ' . json_encode($this->db->error()));
            $this->jsonError('Permohonan gagal dibatalkan. Silakan coba lagi.');
            return;
        }

        $this->jsonSuccess(array('msg' => 'Permohonan berhasil dibatalkan.'));
    }

    // ============================================================
    // Konfigurasi layanan. Nama tabel dan kolom hanya diambil dari sini.
    // ============================================================

    private static function daftarLayanan()
    {
        return array(
            'permohonan-doa' => array(
                'nama' => 'Permohonan Doa',
                'tabel' => 'carepermohonandoa',
                'pk' => 'idpermohonan',
                'lookup' => array('tabel' => 'carepermohonandoa_jenis', 'id' => 'idjenispermohonandoa', 'nama' => 'namajenispermohonandoa'),
                'field' => array(
                    'idjenispermohonandoa' => array('label' => 'Jenis permohonan', 'kolom' => 'idjenispermohonandoa', 'tipe' => 'lookup', 'wajib' => true),
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'keteranganpermohonan' => array('label' => 'Pokok doa', 'kolom' => 'perihaldoa', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => true),
                ),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'notif' => array('jenis' => 'Permohonan Doa', 'deskripsi' => 'mengajukan permohonan doa.', 'link' => 'permohonandoa/proses/'),
            ),

            'konseling-kerohanian' => array(
                'nama' => 'Pelayanan Konseling Kerohanian',
                'tabel' => 'carekonseling',
                'pk' => 'idcarekonseling',
                'field' => array(
                    'tglpermohonan' => array('label' => 'Tanggal permohonan', 'kolom' => 'tglpermohonan', 'tipe' => 'tgl', 'wajib' => true),
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'keteranganpermohonan' => array('label' => 'Keterangan', 'kolom' => 'keteranganpermohonan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => true),
                ),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'notif' => array('jenis' => 'Konseling', 'deskripsi' => 'mengajukan permohonan konseling.', 'link' => 'konseling/proses/'),
            ),

            'kunjungan' => array(
                'nama' => 'Pelayanan Kunjungan',
                'tabel' => 'carekunjunganjemaat',
                'pk' => 'idkunjunganjemaat',
                'lookup' => array('tabel' => 'carekunjunganjemaatjenis', 'id' => 'idjeniskunjunganjemaat', 'nama' => 'namajeniskunjunganjemaat'),
                'field' => array(
                    'idjeniskunjunganjemaat' => array('label' => 'Jenis kunjungan', 'kolom' => 'idjeniskunjunganjemaat', 'tipe' => 'lookup', 'wajib' => true),
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'alamatjemaat' => array('label' => 'Alamat', 'kolom' => 'alamatjemaat', 'tipe' => 'teks', 'maks' => 255, 'wajib' => true),
                    'keterangankunjungan' => array('label' => 'Keterangan', 'kolom' => 'keterangankunjungan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => true),
                ),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'notif' => array('jenis' => 'Kunjungan Jemaat', 'deskripsi' => 'mengajukan permohonan kunjungan jemaat.', 'link' => 'kunjunganjemaat/proses/'),
            ),

            'penyerahan-anak' => array(
                'nama' => 'Penyerahan Anak',
                'tabel' => 'carepenyerahananak',
                'pk' => 'idpenyerahananak',
                'field' => array(
                    'namaanak' => array('label' => 'Nama anak', 'kolom' => 'namaanak', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'tempatlahir' => array('label' => 'Tempat lahir', 'kolom' => 'tempatlahir', 'tipe' => 'teks', 'maks' => 100, 'wajib' => true),
                    'tgllahir' => array('label' => 'Tanggal lahir', 'kolom' => 'tgllahir', 'tipe' => 'tgl', 'wajib' => true),
                    'namaayah' => array('label' => 'Nama ayah', 'kolom' => 'namaayah', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'namaibu' => array('label' => 'Nama ibu', 'kolom' => 'namaibu', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'keteranganpermohonan' => array('label' => 'Keterangan', 'kolom' => 'keteranganpermohonan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => false),
                ),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'notif' => array('jenis' => 'Penyerahan Anak', 'deskripsi' => 'mengajukan penyerahan anak.', 'link' => 'penyerahananak/proses/'),
            ),

            'pemberkatan-pernikahan' => array(
                'nama' => 'Pemberkatan Pernikahan',
                'tabel' => 'carepernikahan',
                'pk' => 'idpernikahan',
                'field' => array(
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'namamempelaipria' => array('label' => 'Nama mempelai pria', 'kolom' => 'namamempelaipria', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'namaayahpria' => array('label' => 'Nama ayah mempelai pria', 'kolom' => 'namaayahpria', 'tipe' => 'teks', 'maks' => 150, 'wajib' => false),
                    'namaibupria' => array('label' => 'Nama ibu mempelai pria', 'kolom' => 'namaibupria', 'tipe' => 'teks', 'maks' => 150, 'wajib' => false),
                    'namamempelaiwanita' => array('label' => 'Nama mempelai wanita', 'kolom' => 'namamempelaiwanita', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'namaayahwanita' => array('label' => 'Nama ayah mempelai wanita', 'kolom' => 'namaayahwanita', 'tipe' => 'teks', 'maks' => 150, 'wajib' => false),
                    'namaibuwanita' => array('label' => 'Nama ibu mempelai wanita', 'kolom' => 'namaibuwanita', 'tipe' => 'teks', 'maks' => 150, 'wajib' => false),
                    'keterangan' => array('label' => 'Keterangan', 'kolom' => 'keterangan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => false),
                ),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'notif' => array('jenis' => 'Permohonan Pernikahan', 'deskripsi' => 'mengajukan permohonan pernikahan.', 'link' => 'pernikahan/proses/'),
                'wa_admin' => array(
                    'kunci' => 'fonnte_admin_pernikahan',
                    'judul' => 'Permohonan Pernikahan Baru',
                    'baris' => array('Mempelai Pria' => 'namamempelaipria', 'Mempelai Wanita' => 'namamempelaiwanita', 'Keterangan' => 'keterangan'),
                ),
            ),

            'kedukaan' => array(
                'nama' => 'Pelayanan Kedukaan',
                'tabel' => 'carekematian',
                'pk' => 'idkematian',
                'field' => array(
                    'namayangmeninggal' => array('label' => 'Nama almarhum/almarhumah', 'kolom' => 'namayangmeninggal', 'tipe' => 'teks', 'maks' => 150, 'wajib' => true),
                    'tglmeninggal' => array('label' => 'Tanggal meninggal', 'kolom' => 'tglmeninggal', 'tipe' => 'tgl', 'wajib' => true),
                    'umuryangmeninggal' => array('label' => 'Umur', 'kolom' => 'umuryangmeninggal', 'tipe' => 'teks', 'maks' => 3, 'wajib' => false),
                    'jeniskelaminyangmeninggal' => array('label' => 'Jenis kelamin', 'kolom' => 'jeniskelaminyangmeninggal', 'tipe' => 'teks', 'maks' => 20, 'wajib' => false),
                    'hubungankeluarga' => array('label' => 'Hubungan keluarga', 'kolom' => 'hubungankeluarga', 'tipe' => 'teks', 'maks' => 100, 'wajib' => true),
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'keteranganpermohonan' => array('label' => 'Keterangan', 'kolom' => 'keterangan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => false),
                ),
                'wa_wajib' => false,
                'satu_terbuka' => false,
                'notif' => null,
            ),

            'baptisan' => array(
                'nama' => 'Pelayanan Baptisan',
                'tabel' => 'carebaptisan',
                'pk' => 'idcarebaptisan',
                'field' => array(
                    'nohpyangbisadihubungi' => array('label' => 'Nomor HP', 'kolom' => 'nohpyangbisadihubungi', 'tipe' => 'hp', 'wajib' => true),
                    'keteranganpermohonan' => array('label' => 'Keterangan', 'kolom' => 'keteranganpermohonan', 'tipe' => 'teks', 'maks' => 1000, 'wajib' => false),
                ),
                'auto' => array('tglpermohonan' => 'now'),
                'wa_wajib' => true,
                'satu_terbuka' => true,
                'syarat_baptis' => true,
                'notif' => array('jenis' => 'Permohonan Baptisan', 'deskripsi' => 'mengajukan permohonan baptisan.', 'link' => 'baptisan/proses/'),
                'wa_admin' => array(
                    'kunci' => 'fonnte_admin_baptisan',
                    'judul' => 'Shalom, Ada Permohonan Baptisan Baru',
                    'baris' => array('Keterangan' => 'keteranganpermohonan'),
                ),
            ),
        );
    }

    private function _layananDariInput()
    {
        $slug = trim((string) $this->input->get_post('layanan'));
        $daftar = self::daftarLayanan();
        return isset($daftar[$slug]) ? $daftar[$slug] : null;
    }

    // Syarat sebelum formulir boleh diisi. Null berarti boleh mengajukan.
    private function _cekSyarat($cfg, $idjemaat)
    {
        if (!empty($cfg['wa_wajib'])) {
            $v = $this->db->query('SELECT statusverifikasiwa FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
            if (!$v || (string) $v->statusverifikasiwa !== '1') {
                return 'Verifikasi nomor WhatsApp terlebih dahulu di menu Profil.';
            }
        }

        if (!empty($cfg['satu_terbuka'])) {
            $n = $this->db->query(
                "SELECT COUNT(*) AS jml FROM {$cfg['tabel']} WHERE idjemaat = ? AND status = ?",
                array($idjemaat, self::STATUS_AWAL)
            )->row();
            if ((int) $n->jml > 0) {
                return 'Anda masih memiliki permohonan yang belum dikonfirmasi gereja. Silakan tunggu maksimal 2 x 24 jam.';
            }
        }

        if (!empty($cfg['syarat_baptis'])) {
            $sudahBaptis = $this->db->query('SELECT idakta FROM v_aktabaptisan WHERE idjemaat = ? LIMIT 1', array($idjemaat))->num_rows();
            if ($sudahBaptis > 0) {
                return 'Anda sudah memiliki akta baptis, sehingga tidak dapat mengajukan permohonan baptisan lagi.';
            }

            $punyaFC1 = $this->db->query(
                'SELECT idregistrasikelas FROM registrasikelas WHERE idjemaat = ? AND idkelas = ? LIMIT 1',
                array($idjemaat, self::KODE_FC1)
            )->num_rows();
            if ($punyaFC1 === 0) {
                return 'Untuk mengajukan baptisan, Anda harus sudah memiliki sertifikat Foundation Class 1.';
            }
        }

        return null;
    }

    private function _daftarField($cfg)
    {
        $out = array();
        foreach ($cfg['field'] as $nama => $aturan) {
            $out[] = array(
                'nama' => $nama,
                'label' => $aturan['label'],
                'tipe' => $aturan['tipe'],
                'wajib' => !empty($aturan['wajib']),
                'maks' => isset($aturan['maks']) ? $aturan['maks'] : null,
            );
        }
        return $out;
    }

    private function _validasi($aturan, $cfg, $raw, &$err)
    {
        $nilai = $raw === null ? '' : trim((string) $raw);
        // Buang karakter kontrol yang tidak wajar
        $nilai = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $nilai);

        if ($nilai === '') {
            if (!empty($aturan['wajib'])) {
                $err = $aturan['label'] . ' wajib diisi.';
                return null;
            }
            return '';
        }

        switch ($aturan['tipe']) {
            case 'hp':
                if (!preg_match(self::PATTERN_HP, $nilai)) {
                    $err = 'Format nomor WhatsApp tidak valid.';
                    return null;
                }
                break;

            case 'tgl':
                if (!preg_match(self::PATTERN_TGL, $nilai)) {
                    $err = $aturan['label'] . ' tidak valid.';
                    return null;
                }
                list($y, $m, $d) = explode('-', $nilai);
                if (!checkdate((int) $m, (int) $d, (int) $y)) {
                    $err = $aturan['label'] . ' tidak valid.';
                    return null;
                }
                break;

            case 'lookup':
                $l = $cfg['lookup'];
                $ada = $this->db->query(
                    "SELECT 1 FROM {$l['tabel']} WHERE {$l['id']} = ? AND statusaktif = 'Aktif' LIMIT 1",
                    array($nilai)
                )->num_rows();
                if ($ada === 0) {
                    $err = $aturan['label'] . ' tidak valid.';
                    return null;
                }
                break;

            default:
                $maks = isset($aturan['maks']) ? (int) $aturan['maks'] : 255;
                if (mb_strlen($nilai) > $maks) {
                    $err = $aturan['label'] . ' maksimal ' . $maks . ' karakter.';
                    return null;
                }
        }

        return $nilai;
    }

    private function _buatNotifAdmin($cfg, $idjemaat, $idBaru)
    {
        $jemaat = $this->db->query('SELECT namalengkap FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
        $nama = $jemaat ? $jemaat->namalengkap : '';
        $n = $cfg['notif'];

        $admin = $this->db->query(
            'SELECT idjemaat FROM otorisasiuser WHERE idotorisasi = ?',
            array(self::OTORISASI_ADMIN)
        )->result();

        foreach ($admin as $a) {
            $this->db->insert('notifikasi', array(
                'tglnotifikasi' => date('Y-m-d H:i:s'),
                'deskripsi' => ucwords(strtolower($nama)) . ', ' . $n['deskripsi'],
                'linknotifikasi' => $n['link'] . $this->encrypt->encode($idBaru),
                'idlinknotifikasi' => $idBaru,
                'namajemaatpembuat' => $nama,
                'idjemaatpembuat' => $idjemaat,
                'jenisnotifikasi' => $n['jenis'],
                'idjemaatpenerima' => $a->idjemaat,
            ));
        }
    }

    // Pesan WhatsApp ke admin. Gagal kirim tidak membatalkan permohonan, sama seperti web.
    private function _kirimWaAdmin($cfg, $idjemaat, $input)
    {
        $w = $cfg['wa_admin'];

        $this->config->load('fonnte', true);
        $token = $this->config->item('fonnte_token', 'fonnte');
        $target = $this->config->item($w['kunci'], 'fonnte');

        if (empty($token) || empty($target)) {
            log_message('error', 'Care: konfigurasi Fonnte belum lengkap untuk ' . $w['kunci']);
            return;
        }

        $jemaat = $this->db->query('SELECT namalengkap FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
        $nama = $jemaat ? $jemaat->namalengkap : '-';

        $pesan = '*' . $w['judul'] . "*\n\n"
            . 'Nama Pemohon: ' . $nama . "\n"
            . 'No HP: ' . $input['nohpyangbisadihubungi'] . "\n";
        foreach ($w['baris'] as $label => $field) {
            $nilai = isset($input[$field]) && $input[$field] !== '' ? $input[$field] : '-';
            $pesan .= $label . ': ' . $nilai . "\n";
        }
        $pesan .= "\nSilakan konfirmasi permohonan ini di halaman admin.";

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $pesan,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array('Authorization: ' . $token),
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
        ));
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Care: curl Fonnte gagal - ' . $error);
            return;
        }

        $hasil = json_decode($response, true);
        if (empty($hasil['status'])) {
            log_message('error', 'Care: Fonnte menolak pesan untuk ' . $w['kunci']);
        }
    }
}

/* End of file Care.php */
/* Location: ./application/controllers/api/Care.php */