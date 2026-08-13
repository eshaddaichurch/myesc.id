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
}

/* End of file BaseApi.php */
/* Location: ./application/controllers/api/BaseApi.php */
