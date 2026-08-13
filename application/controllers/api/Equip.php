<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Equip extends BaseApi
{
    // idkelas => [idkelas prasyarat, pesan kalau belum lulus]
    private $prasyarat = array(
        'KL003' => array('KL001', 'Anda harus mengikuti kelas Membership terlebih dahulu!'),
        'KL004' => array('KL001', 'Anda harus mengikuti kelas Membership terlebih dahulu!'),
        'KL005' => array('KL004', 'Anda harus mengikuti Foundation Class 3 terlebih dahulu!'),
        'KL006' => array('KL005', 'Anda harus mengikuti Grade 1 terlebih dahulu!'),
        'KL007' => array('KL006', 'Anda harus mengikuti Grade 2 terlebih dahulu!'),
        'KL008' => array('KL007', 'Anda harus mengikuti Grade 3 terlebih dahulu!'),
    );

    public function list()
    {
        $idjemaat = $this->requireAuth();

        $rsKelas = $this->db->query('
            SELECT kelas.idkelas, kelas.namakelas, kelas.kelas_slug, kelas.urlsertifikat,
                registrasikelas.statuslulus, tglsertifikat, idregistrasikelas
            FROM kelas 
            LEFT JOIN registrasikelas ON registrasikelas.idkelas = kelas.idkelas 
                AND idjemaat = ? AND statuslulus = 1
            WHERE kelas.statusaktif = 1
            GROUP BY kelas.idkelas, kelas.namakelas, kelas.kelas_slug, kelas.urlsertifikat,
                registrasikelas.statuslulus, tglsertifikat, idregistrasikelas
        ', array($idjemaat));

        $kelasArr = array();
        foreach ($rsKelas->result() as $row) {
            $kelasArr[] = array(
                'idkelas' => $row->idkelas,
                'namakelas' => $row->namakelas,
                'kelas_slug' => $row->kelas_slug,
                'sudahlulus' => !empty($row->statuslulus),
                'tglsertifikat' => $row->tglsertifikat,
                'idregistrasikelas' => $row->idregistrasikelas,
            );
        }

        $this->jsonSuccess(array('kelas' => $kelasArr));
    }

    // GET /api/equip/kelas/{slug} — detail kelas + jadwal yang bisa didaftar
    public function kelas($kelas_slug = '')
    {
        $idjemaat = $this->requireAuth();

        if (empty($kelas_slug)) {
            $this->jsonError('Kelas tidak ditemukan.');
            return;
        }

        $rowKelas = $this->db->query('
            SELECT * FROM kelas WHERE kelas_slug = ? LIMIT 1
        ', array($kelas_slug))->row();

        if (!$rowKelas) {
            $this->jsonError('Kelas tidak ditemukan.');
            return;
        }

        $idkelas = $rowKelas->idkelas;
        $tglsekarang = date('Y-m-d H:i:00');

        if ($idkelas == 'KL004') {
            $rsJadwal = $this->db->query("
                SELECT * FROM v_jadwalevent 
                WHERE jenisjadwal = 'Kelas Next Step' AND idkelas = ? 
                    AND DATE_SUB(tglmulai, INTERVAL 14 DAY) > ? AND statuskonfirmasi = 'Disetujui'
            ", array($idkelas, $tglsekarang));
        } else {
            $rsJadwal = $this->db->query("
                SELECT * FROM v_jadwalevent 
                WHERE jenisjadwal = 'Kelas Next Step' AND idkelas = ? 
                    AND DATE_SUB(tglmulai, INTERVAL 7 DAY) > ? AND statuskonfirmasi = 'Disetujui'
            ", array($idkelas, $tglsekarang));
        }

        $jadwalArr = array();
        foreach ($rsJadwal->result() as $row) {
            $maxJemaat = (int) $row->jumlahjemaat;

            $jumlahDaftar = (int) $this->db->query('
                SELECT COUNT(*) as jlh FROM jadwaleventregistrasi 
                WHERE idjadwalevent = ? AND statuskonfirmasi <> "Ditolak"
            ', array($row->idjadwalevent))->row()->jlh;

            $rowLokasi = $this->db->query('
                SELECT lokasievent FROM jadwaleventdetailtanggal WHERE idjadwalevent = ? LIMIT 1
            ', array($row->idjadwalevent))->row();

            $rowRegistrasiSaya = $this->db->query('
                SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent = ? AND idjemaat = ?
            ', array($row->idjadwalevent, $idjemaat))->row();

            $jadwalArr[] = array(
                'idjadwalevent' => $row->idjadwalevent,
                'namaevent' => $row->namaevent,
                'tglmulai' => $row->tglmulai,
                'tglselesai' => $row->tglselesai,
                'lokasievent' => $rowLokasi ? $rowLokasi->lokasievent : '',
                'maxjemaat' => $maxJemaat,
                'jumlahdaftar' => $jumlahDaftar,
                'penuh' => $maxJemaat > 0 && $jumlahDaftar >= $maxJemaat,
                'sudahdaftar' => !empty($rowRegistrasiSaya),
                'statuskonfirmasi' => $rowRegistrasiSaya ? $rowRegistrasiSaya->statuskonfirmasi : null,
                'keterangankonfirmasi' => $rowRegistrasiSaya ? $rowRegistrasiSaya->keterangankonfirmasi : null,
            );
        }

        $rowJemaat = $this->db->query('
            SELECT statusverifikasiwa FROM jemaat WHERE idjemaat = ?
        ', array($idjemaat))->row();

        $this->jsonSuccess(array(
            'kelas' => array(
                'idkelas' => $rowKelas->idkelas,
                'namakelas' => $rowKelas->namakelas,
                'kelas_slug' => $rowKelas->kelas_slug,
            ),
            'jadwal' => $jadwalArr,
            'statusverifikasiwa' => !empty($rowJemaat->statusverifikasiwa),
        ));
    }

    // POST /api/equip/daftar — body: idjadwalevent
    public function daftar()
    {
        $idjemaat = $this->requireAuth();
        $idjadwalevent = trim($this->input->post('idjadwalevent'));

        if (empty($idjadwalevent)) {
            $this->jsonError('Jadwal tidak valid.');
            return;
        }

        $rowJemaat = $this->db->query('SELECT * FROM jemaat WHERE idjemaat = ?', array($idjemaat))->row();
        if (!$rowJemaat) {
            $this->jsonError('Data jemaat tidak ditemukan.');
            return;
        }

        if (empty($rowJemaat->statusverifikasiwa)) {
            $this->jsonError('Silakan verifikasi nomor whatsapp anda terlebih dahulu.');
            return;
        }

        $sudahDaftar = $this->db->query('
            SELECT * FROM jadwaleventregistrasi 
            WHERE idjadwalevent = ? AND idjemaat = ? AND statuskonfirmasi <> "Ditolak"
        ', array($idjadwalevent, $idjemaat))->num_rows() > 0;

        if ($sudahDaftar) {
            $this->jsonError('Anda sudah pernah mendaftar di jadwal kelas ini.');
            return;
        }

        $rowJadwal = $this->db->query('
            SELECT jadwalevent.idkelas, kelas.namakelas, kelas.kelas_slug
            FROM jadwalevent JOIN kelas ON kelas.idkelas = jadwalevent.idkelas
            WHERE idjadwalevent = ?
        ', array($idjadwalevent))->row();

        if (!$rowJadwal) {
            $this->jsonError('Data jadwal tidak ditemukan.');
            return;
        }

        $idkelas = $rowJadwal->idkelas;

        if (isset($this->prasyarat[$idkelas])) {
            list($idkelasPrasyarat, $pesanPrasyarat) = $this->prasyarat[$idkelas];

            $sudahLulus = $this->db->query('
                SELECT * FROM registrasikelas WHERE idjemaat = ? AND idkelas = ? AND statuslulus = 1
            ', array($idjemaat, $idkelasPrasyarat))->num_rows() > 0;

            if (!$sudahLulus) {
                $this->jsonError($pesanPrasyarat);
                return;
            }
        }

        $tglregistrasi = date('Y-m-d H:i:s');
        $idregistrasi = $this->db->query("SELECT create_idregistrasievent('" . date('Y-m-d') . "') as idregistrasi")->row()->idregistrasi;

        $data = array(
            'idregistrasi' => $idregistrasi,
            'idjadwalevent' => $idjadwalevent,
            'tglregistrasi' => $tglregistrasi,
            'idjemaat' => $idjemaat,
            'statuskonfirmasi' => 'Menunggu',
        );

        $simpan = $this->db->insert('jadwaleventregistrasi', $data);

        if ($simpan) {
            $pesanWA = 'Shalom ' . ucwords(strtolower($rowJemaat->namalengkap)) . '! Pengajuan pendaftaran ' . $rowJadwal->namakelas . ' anda telah kami terima. Akan segera kami konfirmasi 1x24 jam. Terimakasih.!'
                . "\nID Registrasi: " . $idregistrasi
                . "\nTgl Registrasi: " . $tglregistrasi;

            try {
                $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);
            } catch (\Throwable $e) {
                log_message('error', 'Gagal kirim WA pendaftaran kelas: ' . $e->getMessage());
            }

            $this->jsonSuccess(array(
                'idregistrasi' => $idregistrasi,
                'kelas_slug' => $rowJadwal->kelas_slug,
            ));
        } else {
            $this->jsonError('Gagal mendaftar kelas. Silakan coba lagi.');
        }
    }
}

/* End of file Equip.php */
/* Location: ./application/controllers/api/Equip.php */
