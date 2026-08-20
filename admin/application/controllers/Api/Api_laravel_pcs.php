<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller ini KHUSUS untuk diakses aplikasi luar (Laravel absensi),
 * BUKAN untuk dipakai browser/session admin. Makanya sengaja tidak
 * extends MY_Controller (biar tidak kena cek login/session admin).
 * Proteksinya pakai API key di header.
 */
class Api_laravel_pcs extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->config->load('api');
        header('Content-Type: application/json');
        $this->cekApiKey();
    }

    private function cekApiKey()
    {
        // -------------------------> Ambil API key dari header "X-API-KEY"
        $key = $this->input->get_request_header('X-API-KEY', TRUE);

        if (empty($key) || $key !== $this->config->item('api_key')) {
            http_response_code(401);
            echo json_encode(array(
                'success' => false,
                'message' => 'Unauthorized: API key salah atau tidak dikirim'
            ));
            exit();
        }
    }

    /**
     * Endpoint UTAMA yang paling praktis dipakai Laravel.
     * Tinggal lempar hasil scan QR code mentah-mentah ke sini,
     * langsung dapat identitas + semua data volunteer orang itu.
     *
     * GET /admin/api/scan/2310310025-0000142
     * GET /admin/api/scan/2310310025            (untuk yang belum jadi Jemaat)
     */
    public function scan($qrstring = null)
    {
        if (empty($qrstring)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'Kode QR kosong'));
            exit();
        }

        // -------------------------> idjemaat selalu bagian SEBELUM tanda strip pertama
        // (kalau statusnya Simpatisan/Umum, memang tidak ada strip sama sekali, aman)
        $parts = explode('-', $qrstring);
        $idjemaat = $parts[0];

        $rowjemaat = $this->db->query(
            "SELECT idjemaat, namalengkap, foto, statusjemaat, noaj, jeniskelamin FROM jemaat WHERE idjemaat = ?",
            array($idjemaat)
        )->row();

        if (!$rowjemaat) {
            http_response_code(404);
            echo json_encode(array('success' => false, 'message' => 'QR tidak dikenali, jemaat tidak ditemukan'));
            exit();
        }

        $rsvolunteer = $this->db->query(
            "SELECT iddepartement, namadepartement, idpelayanan, namapelayanan, statusaktif 
             FROM v_jemaatvolunteer WHERE idjemaat = ? AND statusaktif = 'Aktif'",
            array($idjemaat)
        )->result();

        echo json_encode(array(
            'success' => true,
            'data' => array(
                'idjemaat'     => $rowjemaat->idjemaat,
                'namalengkap'  => $rowjemaat->namalengkap,
                'foto_url'     => !empty($rowjemaat->foto) ? base_url('admin/uploads/jemaat/' . $rowjemaat->foto) : null,
                'statusjemaat' => $rowjemaat->statusjemaat,
                'noaj'         => !empty($rowjemaat->noaj) ? $rowjemaat->noaj : null,
                'jeniskelamin' => $rowjemaat->jeniskelamin,
                'volunteer'    => $rsvolunteer, // array kosong kalau bukan volunteer, bukan error
            )
        ));
    }

    /**
     * Endpoint identitas saja (tanpa data volunteer), kalau Laravel cuma butuh ini.
     * GET /admin/api/jemaat/2310310025
     */
    public function jemaat($idjemaat = null)
    {
        if (empty($idjemaat)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'idjemaat wajib diisi'));
            exit();
        }

        $row = $this->db->query(
            "SELECT idjemaat, namalengkap, foto, statusjemaat, noaj, jeniskelamin FROM jemaat WHERE idjemaat = ?",
            array($idjemaat)
        )->row();

        if (!$row) {
            http_response_code(404);
            echo json_encode(array('success' => false, 'message' => 'Jemaat tidak ditemukan'));
            exit();
        }

        echo json_encode(array(
            'success' => true,
            'data' => array(
                'idjemaat'     => $row->idjemaat,
                'namalengkap'  => $row->namalengkap,
                'foto_url'     => !empty($row->foto) ? base_url('admin/uploads/jemaat/' . $row->foto) : null,
                'statusjemaat' => $row->statusjemaat,
                'noaj'         => !empty($row->noaj) ? $row->noaj : null,
                'jeniskelamin' => $row->jeniskelamin,
            )
        ));
    }

    /**
     * Endpoint data volunteer saja.
     * GET /admin/api/volunteer/2310310025
     */
    public function volunteer($idjemaat = null)
    {
        if (empty($idjemaat)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'idjemaat wajib diisi'));
            exit();
        }

        $rows = $this->db->query(
            "SELECT iddepartement, namadepartement, idpelayanan, namapelayanan, statusaktif 
             FROM v_jemaatvolunteer WHERE idjemaat = ?",
            array($idjemaat)
        )->result();

        echo json_encode(array('success' => true, 'data' => $rows));
    }

}

/* End of file Api_laravel_pcs.php */
/* Location: ./application/controllers/Api/Api_laravel_pcs.php */