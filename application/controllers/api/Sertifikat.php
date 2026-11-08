<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Sertifikat extends BaseApi
{
    // Whitelist view sertifikat, sama dengan Akun::sertifikat() di web.
    // Nama view tidak pernah diambil dari input user.
    const VIEW_SERTIFIKAT = array(
        'KL002' => 'sertifikatfc1',
        'KL003' => 'sertifikatfc2',
        'KL004' => 'sertifikatfc3',
        'KL005' => 'sertifikatgrade1',
        'KL006' => 'sertifikatgrade2',
        'KL007' => 'sertifikatgrade3',
        'KL008' => 'sertifikatvc',
        'KL101' => 'sertifikatpmc',
    );

    const PATTERN_ID = '/^[A-Za-z0-9_-]{1,64}$/';
    const MAKS_BYTES = 10485760; // 10 MB

    // GET /api/sertifikat/list
    public function list()
    {
        $idjemaat = $this->requireAuth();

        $rows = $this->db->query('
            SELECT rk.idregistrasikelas, rk.idkelas, rk.statuslulus, rk.tglsertifikat,
                   k.namakelas, k.kelas_slug
            FROM registrasikelas rk
            JOIN kelas k ON k.idkelas = rk.idkelas
            WHERE rk.idjemaat = ?
            ORDER BY rk.statuslulus DESC, rk.tglsertifikat DESC, k.namakelas ASC
        ', array($idjemaat))->result();

        $data = array();
        foreach ($rows as $r) {
            $lulus = (string) $r->statuslulus === '1';
            $data[] = array(
                'idregistrasikelas' => $r->idregistrasikelas,
                'namakelas' => $r->namakelas,
                'kelas_slug' => $r->kelas_slug,
                'lulus' => $lulus,
                'tglsertifikat' => $r->tglsertifikat,
                'bisaLihat' => $lulus && isset(self::VIEW_SERTIFIKAT[$r->idkelas]),
            );
        }

        $this->jsonSuccess(array('data' => $data));
    }

    // GET /api/sertifikat/pdf?id=  -> file PDF sertifikat milik jemaat yang login
    public function pdf()
    {
        $idjemaat = $this->requireAuth();
        $id = trim((string) $this->input->get('id', true));

        if (!preg_match(self::PATTERN_ID, $id)) {
            $this->_errorJson('Sertifikat tidak ditemukan.', 404);
            return;
        }

        // Kepemilikan dicek di query: sertifikat orang lain tidak pernah terbaca
        $reg = $this->db->query(
            'SELECT idkelas, statuslulus FROM registrasikelas WHERE idregistrasikelas = ? AND idjemaat = ? LIMIT 1',
            array($id, $idjemaat)
        )->row();

        if (!$reg) {
            $this->_errorJson('Sertifikat tidak ditemukan.', 404);
            return;
        }

        if ((string) $reg->statuslulus !== '1') {
            $this->_errorJson('Sertifikat belum tersedia.', 403);
            return;
        }

        if (!isset(self::VIEW_SERTIFIKAT[$reg->idkelas])) {
            $this->_errorJson('Sertifikat tidak ditemukan.', 404);
            return;
        }

        $rsregistrasi = $this->db->query(
            'SELECT * FROM v_registrasikelas WHERE idregistrasikelas = ? AND idjemaat = ? LIMIT 1',
            array($id, $idjemaat)
        )->row();

        if (!$rsregistrasi) {
            $this->_errorJson('Sertifikat tidak ditemukan.', 404);
            return;
        }

        $this->load->library('Pdf');

        // View memanggil Output('I') dari TCPDF yang langsung mencetak ke output.
        // Output ditangkap dulu agar bisa diperiksa sebelum dikirim ke klien.
        $levelAwal = ob_get_level();
        ob_start();

        try {
            $this->load->view('akun/' . self::VIEW_SERTIFIKAT[$reg->idkelas], array(
                'rsregistrasi' => $rsregistrasi,
                'idregistrasikelas' => $id,
            ));
            $isi = ob_get_clean();
        } catch (\Throwable $e) {
            while (ob_get_level() > $levelAwal) {
                ob_end_clean();
            }
            log_message('error', 'Sertifikat: gagal render untuk idregistrasikelas=' . $id . ' - ' . $e->getMessage());
            $this->_errorJson('Sertifikat tidak dapat dibuat saat ini.', 500);
            return;
        }

        if (!is_string($isi) || strncmp($isi, '%PDF-', 5) !== 0 || strlen($isi) > self::MAKS_BYTES) {
            log_message('error', 'Sertifikat: output bukan PDF valid untuk idregistrasikelas=' . $id);
            $this->_errorJson('Sertifikat tidak dapat dibuat saat ini.', 500);
            return;
        }

        header_remove('Content-Type');
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="sertifikat.pdf"');
        header('Content-Length: ' . strlen($isi));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, no-store');

        echo $isi;
        exit;
    }

    // ============================================================
    // Helper
    // ============================================================

    // Balasan error selalu JSON. Header PDF yang mungkin sudah dibuat TCPDF harus dihapus dulu.
    private function _errorJson($msg, $status)
    {
        header_remove('Content-Type');
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: private, no-store');
        $this->jsonError($msg, $status);
    }
}

/* End of file Sertifikat.php */
/* Location: ./application/controllers/api/Sertifikat.php */