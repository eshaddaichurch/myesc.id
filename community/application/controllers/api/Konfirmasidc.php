<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('api/Konfirmasidc_api_model', 'model');
    }

    public function index()
    {
        $iddc = $this->input->get('iddc');

        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib'
            ]);
            return;
        }

        $data = $this->db
            ->where('iddc', $iddc)
            ->get('v_dcmember_permohonan')
            ->result();

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detail()
    {
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

    public function setuju()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['idpermohonan'] ?? null;

        if (!$id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'idpermohonan wajib'
                ]));
        }

        $this->db->where('idpermohonan', $id);
        $this->db->update('dcmember_permohonan', [
            'statuskonfirmasi' => 'Disetujui',
            'tglkonfirmasi' => date('Y-m-d H:i:s')
        ]);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true
            ]));
    }


}
