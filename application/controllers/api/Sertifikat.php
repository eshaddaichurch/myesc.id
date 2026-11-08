<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Sertifikat extends BaseApi
{
    // Sama seperti Akun::sertifikat() di web
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

    // GET /api/sertifikat/list
    public function list()
    {
        $idjemaat = $this->requireAuth();

        $rows = $this->db->query("
            SELECT rk.idregistrasikelas, rk.idkelas, rk.statuslulus, rk.tglsertifikat,
                   k.namakelas, k.kelas_slug
            FROM registrasikelas rk
            JOIN kelas k ON k.idkelas = rk.idkelas
            WHERE rk.idjemaat = ?
            ORDER BY rk.statuslulus DESC, rk.tglsertifikat DESC, k.namakelas ASC
        ", array($idjemaat))->result();

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

    // GET /api/sertifikat/lihat?id=  -> mengembalikan HTML sertifikat
    public function lihat()
    {
        $idjemaat = $this->requireAuth();
        $id = trim((string) $this->input->get('id', true));

        if ($id === '') {
            $this->jsonError('Sertifikat tidak ditemukan.');
            return;
        }

        // Cek kepemilikan dan status lulus langsung dari tabel
        $reg = $this->db->query(
            'SELECT idkelas, statuslulus FROM registrasikelas WHERE idregistrasikelas = ? AND idjemaat = ? LIMIT 1',
            array($id, $idjemaat)
        )->row();

        if (!$reg || (string) $reg->statuslulus !== '1') {
            $this->jsonError('Sertifikat belum tersedia.');
            return;
        }

        if (!isset(self::VIEW_SERTIFIKAT[$reg->idkelas])) {
            $this->jsonError('Format sertifikat untuk kelas ini belum tersedia.');
            return;
        }

        $rsregistrasi = $this->db->query(
            'SELECT * FROM v_registrasikelas WHERE idregistrasikelas = ? AND idjemaat = ? LIMIT 1',
            array($id, $idjemaat)
        )->row();

        if (!$rsregistrasi) {
            $this->jsonError('Sertifikat tidak ditemukan.');
            return;
        }

        $view = 'akun/' . self::VIEW_SERTIFIKAT[$reg->idkelas];
        $html = $this->load->view($view, array(
            'rsregistrasi' => $rsregistrasi,
            'idregistrasikelas' => $id,
        ), TRUE);

        $this->jsonSuccess(array('html' => $html));
    }
}

/* End of file Sertifikat.php */
/* Location: ./application/controllers/api/Sertifikat.php */