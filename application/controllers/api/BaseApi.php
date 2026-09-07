<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    protected function jsonSuccess($data = array())
    {
        echo json_encode(array_merge(array('success' => true), $data));
    }

    protected function jsonError($msg, $statusCode = 200)
    {
        if ($statusCode !== 200) {
            $this->output->set_status_header($statusCode);
        }
        echo json_encode(array('success' => false, 'msg' => $msg));
    }

    /**
     * Cek token dari header Authorization: Bearer xxxxx
     * Return idjemaat kalau valid, atau kirim error JSON + exit kalau tidak valid.
     */
    // protected function requireAuth()
    // {
    //     $header = '';
        
    //     // Cek dari fungsi apache_request_headers jika tersedia
    //     if (function_exists('apache_request_headers')) {
    //         $requestHeaders = apache_request_headers();
    //         $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
    //         if (isset($requestHeaders['Authorization'])) {
    //             $header = trim($requestHeaders['Authorization']);
    //         }
    //     }
        
    //     // Cek dari input bawaan CI
    //     if (empty($header)) {
    //         $header = $this->input->get_request_header('Authorization', true);
    //     }
        
    //     // Cek dari server global variabel (hasil rewrite .htaccess)
    //     if (empty($header) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    //         $header = trim($_SERVER['HTTP_AUTHORIZATION']);
    //     }
        
    //     if (empty($header) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    //         $header = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    //     }

    //     if (empty($header) || stripos($header, 'Bearer ') !== 0) {
    //         $this->jsonError('Token tidak ditemukan. Silakan login ulang.', 401);
    //         exit();
    //     }

    //     $token = trim(substr($header, 7));

    //     $row = $this->db->query('
    //         SELECT idjemaat, expired_at FROM apptoken WHERE token = ?
    //     ', array($token))->row();

    //     if (!$row) {
    //         $this->jsonError('Token tidak valid. Silakan login ulang.', 401);
    //         exit();
    //     }

    //     if (strtotime($row->expired_at) < time()) {
    //         $this->jsonError('Sesi anda sudah berakhir. Silakan login ulang.', 401);
    //         exit();
    //     }

    //     return $row->idjemaat;
    // }


    protected function requireAuth()
    {
        // DEBUG: Cek semua data server dan header yang masuk
        $all_headers = [];
        if (function_exists('apache_request_headers')) {
            $all_headers = apache_request_headers();
        }
        
        // Paksa cetak ke JSON untuk melihat apa yang ditangkap server
        echo json_encode([
            'success' => false,
            'debug_server_auth' => $_SERVER['HTTP_AUTHORIZATION'] ?? 'TIDAK ADA HTTP_AUTHORIZATION',
            'debug_redirect_auth' => $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? 'TIDAK ADA REDIRECT',
            'debug_apache_headers' => $all_headers
        ]);
        exit();
    }
}

/* End of file BaseApi.php */
/* Location: ./application/controllers/api/BaseApi.php */
