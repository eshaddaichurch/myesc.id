<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Konfirmasidc_api_model', 'model');
    }

    public function index()
    {
        $iddc = $this->input->get('iddc'); // atau post

        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib'
            ]);
            return;
        }

        $data = $this->model->getPermohonan($iddc);

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }
}
