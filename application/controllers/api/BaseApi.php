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
    protected function requireAuth()
    {
        $header = $this->input->get_request_header('Authorization', true);

        if (empty($header) || stripos($header, 'Bearer ') !== 0) {
            $this->jsonError('Token tidak ditemukan. Silakan login ulang.', 401);
            exit();
        }

        $token = trim(substr($header, 7));

        $row = $this->db->query('
            SELECT idjemaat, expired_at FROM apptoken WHERE token = ?
        ', array($token))->row();

        if (!$row) {
            $this->jsonError('Token tidak valid. Silakan login ulang.', 401);
            exit();
        }

        if (strtotime($row->expired_at) < time()) {
            $this->jsonError('Sesi anda sudah berakhir. Silakan login ulang.', 401);
            exit();
        }

        return $row->idjemaat;
    }
}

/* End of file BaseApi.php */
/* Location: ./application/controllers/api/BaseApi.php */
