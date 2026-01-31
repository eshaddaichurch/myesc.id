<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dcmember extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('App'); // untuk getKelasJemaat
    }

    /**
     * LIST MEMBER BY DC
     * /api/dcmember?iddc=DGX01
     */
    public function index()
    {
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
            'total'  => count($data),
            'data'   => $data
        ]);
    }

    /**
     * DETAIL MEMBER + KELAS
     * /api/dcmember/detail?id=2401170016
     */
    public function detail()
    {
        $idjemaat = $this->input->get('id');

        if (!$idjemaat) {
            echo json_encode([
                'status' => false,
                'message' => 'id jemaat wajib diisi'
            ]);
            return;
        }

        // === DATA MEMBER ===
        $member = $this->db
            ->where('idjemaat', $idjemaat)
            ->get('v_dcmember')
            ->row();

        if (!$member) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        // === KELAS YANG DIIKUTI ===
        $kelas = [];
        $rsKelas = $this->App->getKelasJemaat($idjemaat);

        if ($rsKelas && $rsKelas->num_rows() > 0) {
            foreach ($rsKelas->result() as $row) {
                $kelas[] = [
                    'namakelas' => $row->namakelas
                ];
            }
        }

        echo json_encode([
            'status' => true,
            'data'   => $member,
            'kelas'  => $kelas
        ]);
    }
}
