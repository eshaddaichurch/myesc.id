<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Akun extends BaseApi
{
    // Hanya status ini yang boleh mengubah data identitas (sama seperti web)
    const STATUS_BOLEH_IDENTITAS = array('Registered', 'Simpatisan');

    // Kolom yang boleh diubah oleh semua status jemaat
    const KOLOM_UMUM = array(
        'notelp', 'facebook', 'instagram', 'alamatrumah', 'rtrw', 'kodepos',
        'namadarurat', 'hubungan', 'notelpdarurat',
        'pendidikanterakhir', 'namasekolah', 'pekerjaan', 'namaperusahaan',
        'sektorindustri', 'alamatkantor', 'notelpkantor',
    );

    // Kolom identitas (hanya untuk status Registered / Simpatisan)
    const KOLOM_IDENTITAS = array(
        'nik', 'kewarganegaraan', 'namalengkap', 'namapanggilan', 'tempatlahir',
        'tanggallahir', 'jeniskelamin', 'statuspernikahan', 'golongandarah',
    );

    // Kolom identitas yang tidak boleh kosong bila ikut dikirim
    const KOLOM_IDENTITAS_WAJIB = array(
        'nik', 'kewarganegaraan', 'namalengkap', 'namapanggilan', 'tempatlahir',
        'tanggallahir', 'jeniskelamin', 'statuspernikahan',
    );

    // Daftar wilayah jarang berubah, boleh disimpan di perangkat selama 1 hari
    const CACHE_WILAYAH = 'private, max-age=86400';

    // GET /api/akun/profil
    public function profil()
    {
        $idjemaat = $this->requireAuth();

        $row = $this->db->query('SELECT * FROM v_jemaat WHERE idjemaat = ?', array($idjemaat))->row();
        if (!$row) {
            $this->jsonError('Data jemaat tidak ditemukan.');
            return;
        }

        $this->jsonSuccess(array('profil' => $this->_formatProfil($row)));
    }

    // POST /api/akun/update
    // Hanya kolom yang dikirim yang diubah. Kolom lain dibiarkan seperti semula.
    // Nomor WhatsApp TIDAK disimpan di sini. Harus lewat otpKirim lalu otpVerifikasi.
    public function update()
    {
        $idjemaat = $this->requireAuth();

        $rowJemaat = $this->db->query(
            'SELECT statusjemaat FROM jemaat WHERE idjemaat = ?',
            array($idjemaat)
        )->row();
        if (!$rowJemaat) {
            $this->jsonError('Data jemaat tidak ditemukan.');
            return;
        }

        $data = array();

        foreach (self::KOLOM_UMUM as $kolom) {
            if ($this->_dikirim($kolom)) {
                $data[$kolom] = $this->_post($kolom);
            }
        }

        // Wilayah: web menyimpan nama, bukan kode
        if ($this->_dikirim('propinsi')) {
            $data['propinsi'] = $this->_namaWilayah('provinsi', 'idprovinsi', 'namaprovinsi', $this->_post('propinsi'));
        }
        if ($this->_dikirim('kotakabupaten')) {
            $data['kotakabupaten'] = $this->_namaWilayah('kabupaten', 'idkabupaten', 'namakabupaten', $this->_post('kotakabupaten'));
        }
        if ($this->_dikirim('kecamatan')) {
            $data['kecamatan'] = $this->_namaWilayah('kecamatan', 'idkecamatan', 'namakecamatan', $this->_post('kecamatan'));
        }
        if ($this->_dikirim('kelurahan')) {
            $data['kelurahan'] = $this->_namaWilayah('desa', 'iddesa', 'namadesa', $this->_post('kelurahan'));
        }

        if (in_array($rowJemaat->statusjemaat, self::STATUS_BOLEH_IDENTITAS, true)) {
            foreach (self::KOLOM_IDENTITAS as $kolom) {
                if ($this->_dikirim($kolom)) {
                    $data[$kolom] = $this->_post($kolom);
                }
            }

            foreach (self::KOLOM_IDENTITAS_WAJIB as $kolom) {
                if (array_key_exists($kolom, $data) && $data[$kolom] === null) {
                    $this->jsonError('Mohon lengkapi data identitas.');
                    return;
                }
            }

            if (array_key_exists('tanggallahir', $data) && $data['tanggallahir'] !== null
                && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['tanggallahir'])) {
                $this->jsonError('Format tanggal lahir harus YYYY-MM-DD.');
                return;
            }
        }

        if (empty($data)) {
            $this->jsonSuccess(array('msg' => 'Tidak ada perubahan.'));
            return;
        }

        $data['tanggalupdate'] = date('Y-m-d H:i:s');

        $this->db->where('idjemaat', $idjemaat);
        $simpan = $this->db->update('jemaat', $data);

        if (!$simpan) {
            log_message('error', 'Akun::update gagal untuk idjemaat=' . $idjemaat . ' - ' . json_encode($this->db->error()));
            $this->jsonError('Data profil gagal disimpan. Silakan coba lagi.');
            return;
        }

        $this->jsonSuccess(array('msg' => 'Data profil berhasil disimpan.'));
    }

    // GET /api/akun/provinsi
    public function provinsi()
    {
        $this->requireAuth();
        $this->_kirimDaftar(
            'SELECT idprovinsi AS id, namaprovinsi AS nama FROM provinsi ORDER BY namaprovinsi',
            array()
        );
    }

    // GET /api/akun/kabupaten?idprovinsi=
    public function kabupaten()
    {
        $this->requireAuth();
        $this->_kirimDaftar(
            'SELECT idkabupaten AS id, namakabupaten AS nama FROM kabupaten WHERE idprovinsi = ? ORDER BY namakabupaten',
            array($this->input->get('idprovinsi', true))
        );
    }

    // GET /api/akun/kecamatan?idkabupaten=
    public function kecamatan()
    {
        $this->requireAuth();
        $this->_kirimDaftar(
            'SELECT idkecamatan AS id, namakecamatan AS nama FROM kecamatan WHERE idkabupaten = ? ORDER BY namakecamatan',
            array($this->input->get('idkabupaten', true))
        );
    }

    // GET /api/akun/kelurahan?idkecamatan=
    public function kelurahan()
    {
        $this->requireAuth();
        $this->_kirimDaftar(
            'SELECT iddesa AS id, namadesa AS nama FROM desa WHERE idkecamatan = ? ORDER BY namadesa',
            array($this->input->get('idkecamatan', true))
        );
    }

    // POST /api/akun/otpKirim  (body: nohp)
    public function otpKirim()
    {
        $idjemaat = $this->requireAuth();
        $nohp = $this->_post('nohp');
        $ip = $this->input->ip_address();

        if ($nohp === null || !preg_match('/^0[0-9]{9,14}$/', $nohp)) {
            $this->jsonError('Format nomor WhatsApp tidak valid.');
            return;
        }

        $dipakai = $this->db->query(
            'SELECT idjemaat FROM jemaat WHERE nohp = ? AND idjemaat <> ? LIMIT 1',
            array($nohp, $idjemaat)
        )->row();
        if ($dipakai) {
            $this->jsonError('Nomor WhatsApp ' . $nohp . ' sudah terdaftar di akun lain. Hubungi hotline gereja 085550001187 untuk bantuan.');
            return;
        }

        // Rate limit 1: nomor yang sama, jeda minimal 60 detik
        $lastByNomor = $this->db->query(
            "SELECT created_at FROM otp_log WHERE tipe = 'wa' AND tujuan = ? ORDER BY created_at DESC LIMIT 1",
            array($nohp)
        )->row();
        if ($lastByNomor && (time() - strtotime($lastByNomor->created_at)) < 60) {
            $this->jsonError('Mohon tunggu sebentar sebelum meminta kode baru.');
            return;
        }

        // Rate limit 2: dari IP ini, maksimal 5 kali per jam
        $countIp = $this->db->query(
            "SELECT COUNT(*) AS jumlah FROM otp_log WHERE tipe = 'wa' AND ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)",
            array($ip)
        )->row()->jumlah;
        if ($countIp >= 5) {
            $this->jsonError('Terlalu banyak percobaan verifikasi WhatsApp. Silakan coba lagi nanti.');
            return;
        }

        $rowJemaat = $this->db->query('SELECT namalengkap FROM jemaat WHERE idjemaat = ?', array($idjemaat))->row();
        $namaJemaat = $rowJemaat ? ucwords(strtolower($rowJemaat->namalengkap)) : '';

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => 'wa',
            'tujuan' => $nohp,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'verified' => 0,
            'percobaan_salah' => 0,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ));
        $idOtpLog = $this->db->insert_id();

        $pesanWA = 'Shalom ' . $namaJemaat . "! Kode verifikasi WhatsApp untuk profil MyESC kamu: *{$otp}*\n\n"
            . 'Masukkan kode ini di aplikasi untuk menyelesaikan verifikasi. Kode berlaku 10 menit.';

        $terkirim = $this->whatsapp->send_message(formatNomorWhatsapp($nohp), $pesanWA);
        if (!$terkirim) {
            // Hapus catatan OTP supaya jeda 60 detik tidak menghalangi percobaan ulang
            $this->db->delete('otp_log', array('id' => $idOtpLog));
            log_message('error', 'Gagal kirim OTP WA (API) untuk idjemaat=' . $idjemaat);
            $this->jsonError('Gagal mengirim kode ke WhatsApp. Silakan coba lagi beberapa saat lagi.');
            return;
        }

        // Nomor baru disimpan setelah kode benar-benar terkirim
        $this->db->where('idjemaat', $idjemaat);
        $this->db->update('jemaat', array('nohp' => $nohp));

        $this->jsonSuccess(array('msg' => 'Kode verifikasi telah dikirim ke WhatsApp kamu.'));
    }

    // POST /api/akun/otpVerifikasi  (body: otp)
    public function otpVerifikasi()
    {
        $idjemaat = $this->requireAuth();
        $otpInput = $this->_post('otp');

        if ($otpInput === null || !preg_match('/^[0-9]{6}$/', $otpInput)) {
            $this->jsonError('Masukkan 6 digit kode OTP.');
            return;
        }

        $row = $this->db->query("
            SELECT * FROM otp_log
            WHERE idjemaat = ? AND tipe = 'wa' AND verified = 0
            ORDER BY created_at DESC LIMIT 1
        ", array($idjemaat))->row();

        if (!$row) {
            $this->jsonError('Kode OTP tidak ditemukan. Silakan minta kode baru.');
            return;
        }

        if (strtotime($row->expired_at) < time()) {
            $this->jsonError('Kode OTP sudah kadaluarsa. Silakan minta kode baru.');
            return;
        }

        if ((int) $row->percobaan_salah >= 5) {
            $this->jsonError('Terlalu banyak percobaan salah. Silakan minta kode baru.');
            return;
        }

        if (!password_verify($otpInput, $row->otp_hash)) {
            $this->db->query('UPDATE otp_log SET percobaan_salah = percobaan_salah + 1 WHERE id = ?', array($row->id));
            $this->jsonError('Kode OTP salah. Silakan periksa kembali.');
            return;
        }

        $this->db->query('UPDATE otp_log SET verified = 1 WHERE id = ?', array($row->id));
        $this->db->where('idjemaat', $idjemaat);
        $this->db->update('jemaat', array('statusverifikasiwa' => '1'));

        $this->jsonSuccess(array('msg' => 'Nomor WhatsApp berhasil diverifikasi.'));
    }

    // POST /api/akun/password  (body: passwordlama, passwordbaru1, passwordbaru2)
    public function password()
    {
        $idjemaat = $this->requireAuth();

        // Password diambil apa adanya (tanpa trim), sama seperti web
        $lama = (string) $this->input->post('passwordlama');
        $baru1 = (string) $this->input->post('passwordbaru1');
        $baru2 = (string) $this->input->post('passwordbaru2');

        if ($lama === '' || $baru1 === '' || $baru2 === '') {
            $this->jsonError('Semua kolom password wajib diisi.');
            return;
        }

        $cek = $this->db->query(
            'SELECT idjemaat FROM jemaat WHERE idjemaat = ? AND password = ?',
            array($idjemaat, md5($lama))
        )->row();
        if (!$cek) {
            $this->jsonError('Password lama salah!');
            return;
        }

        if ($baru1 !== $baru2) {
            $this->jsonError('Ulangi password baru tidak sama!');
            return;
        }

        if (strlen($baru1) < 6) {
            $this->jsonError('Password baru minimal 6 karakter!');
            return;
        }

        $this->db->where('idjemaat', $idjemaat);
        $simpan = $this->db->update('jemaat', array('password' => md5($baru1)));

        if (!$simpan) {
            $this->jsonError('Password gagal disimpan. Silakan coba lagi.');
            return;
        }

        $this->jsonSuccess(array('msg' => 'Password berhasil diubah.'));
    }

    // ============================================================
    // Helper
    // ============================================================

    // Kolom dianggap dikirim kalau ada di request, walaupun nilainya kosong
    private function _dikirim($key)
    {
        return $this->input->post($key) !== null;
    }

    private function _post($key)
    {
        $nilai = trim((string) $this->input->post($key));
        return $nilai === '' ? null : $nilai;
    }

    // Web menyimpan nama wilayah, bukan kode. Kalau kode tidak ditemukan,
    // nilai asli dipakai lagi supaya nilai lama tidak hilang.
    private function _namaWilayah($tabel, $kolomId, $kolomNama, $nilai)
    {
        if ($nilai === null) {
            return null;
        }

        $row = $this->db->query(
            "SELECT {$kolomNama} AS nama FROM {$tabel} WHERE {$kolomId} = ?",
            array($nilai)
        )->row();

        return $row ? $row->nama : $nilai;
    }

    private function _kirimDaftar($sql, $params)
    {
        header('Cache-Control: ' . self::CACHE_WILAYAH);

        $rows = $this->db->query($sql, $params)->result();
        $this->jsonSuccess(array('data' => $rows));
    }

    private function _formatProfil($row)
    {
        $a = (array) $row;
        $g = function ($k) use ($a) {
            return isset($a[$k]) ? $a[$k] : null;
        };

        $statusjemaat = $g('statusjemaat');
        $qrcontent = ($statusjemaat === 'Jemaat' && !empty($g('noaj')))
            ? $g('idjemaat') . '-' . $g('noaj')
            : $g('idjemaat');

        return array(
            'idjemaat' => $g('idjemaat'),
            'noaj' => $g('noaj'),
            'statusjemaat' => $statusjemaat,
            'bisaUbahIdentitas' => in_array($statusjemaat, self::STATUS_BOLEH_IDENTITAS, true),
            'qrcontent' => $qrcontent,
            'foto' => !empty($g('foto')) ? base_url('myesc.id/admin/uploads/jemaat/' . $g('foto')) : null,
            'nik' => $g('nik'),
            'kewarganegaraan' => $g('kewarganegaraan'),
            'namalengkap' => $g('namalengkap'),
            'namapanggilan' => $g('namapanggilan'),
            'tempatlahir' => $g('tempatlahir'),
            'tanggallahir' => $g('tanggallahir'),
            'jeniskelamin' => $g('jeniskelamin'),
            'statuspernikahan' => $g('statuspernikahan'),
            'golongandarah' => $g('golongandarah'),
            'notelp' => $g('notelp'),
            'nohp' => $g('nohp'),
            'email' => $g('email'),
            'facebook' => $g('facebook'),
            'instagram' => $g('instagram'),
            'alamatrumah' => $g('alamatrumah'),
            'rtrw' => $g('rtrw'),
            'kodepos' => $g('kodepos'),
            'propinsi' => $g('propinsi'),
            'kotakabupaten' => $g('kotakabupaten'),
            'kecamatan' => $g('kecamatan'),
            'kelurahan' => $g('kelurahan'),
            'namadarurat' => $g('namadarurat'),
            'hubungan' => $g('hubungan'),
            'notelpdarurat' => $g('notelpdarurat'),
            'pendidikanterakhir' => $g('pendidikanterakhir'),
            'namasekolah' => $g('namasekolah'),
            'pekerjaan' => $g('pekerjaan'),
            'namaperusahaan' => $g('namaperusahaan'),
            'sektorindustri' => $g('sektorindustri'),
            'alamatkantor' => $g('alamatkantor'),
            'notelpkantor' => $g('notelpkantor'),
            'statusverifikasiwa' => (string) $g('statusverifikasiwa') === '1',
            'statusverifikasiemail' => (string) $g('statusverifikasiemail') === '1',
        );
    }
}

/* End of file Akun.php */
/* Location: ./application/controllers/api/Akun.php */