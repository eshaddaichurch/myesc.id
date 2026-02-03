<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Konfirmasidc_api_model', 'model');
    }

    public function detail()
    {
        header('Content-Type: application/json');

        $id = $this->input->get('idpermohonan');

        if (!$id) {
            echo json_encode([
                'status' => false,
                'message' => 'idpermohonan wajib'
            ]);
            return;
        }

        $data = $this->model->getDetail($id);

        if (!$data) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }
}
