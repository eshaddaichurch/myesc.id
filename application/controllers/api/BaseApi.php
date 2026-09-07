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
     * Cek token dari header custom X-Auth-Token (bukan Authorization,
     * karena beberapa hosting/proxy membuang header Authorization
     * sebelum sampai ke PHP).
     */
    protected function requireAuth()
    {
        $token = $this->input->get_request_header('X-Auth-Token', true);

        if (empty($token) && isset($_SERVER['HTTP_X_AUTH_TOKEN'])) {
            $token = $_SERVER['HTTP_X_AUTH_TOKEN'];
        }

        $token = trim((string) $token);

        if (empty($token)) {
            $this->jsonError('Token tidak ditemukan. Silakan login ulang.', 401);
            exit();
        }

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