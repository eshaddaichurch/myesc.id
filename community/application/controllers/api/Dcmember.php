<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dcmember extends CI_Controller {

    public function index()
    {
        header('Content-Type: application/json');

        $iddc = $this->input->get('iddc');
        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib diisi'
            ]);
            return;
        }

        $data = $this->db
            ->where('iddc', $iddc)
            ->order_by('namalengkap', 'ASC')
            ->get('v_dcmember')
            ->result();

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detail()
    {
        header('Content-Type: application/json');

        $idjemaat = $this->input->get('id');

        if (!$idjemaat) {
            echo json_encode([
                'status' => false,
                'message' => 'id jemaat wajib diisi'
            ]);
            return;
        }

        $data = $this->db
            ->where('idjemaat', $idjemaat)
            ->get('v_dcmember')
            ->row();

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
