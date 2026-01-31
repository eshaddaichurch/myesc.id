<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function index()
    {
        // iddc dikirim dari mobile (hasil login)
        $iddc = $this->input->get('iddc');

        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib dikirim'
            ]);
            return;
        }

        $jumlahdm = $this->db
            ->where('iddc', $iddc)
            ->where('statuskeanggotaan', 'Disciples maker')
            ->count_all_results('v_dcmember');

        $jumlahcore = $this->db
            ->where('iddc', $iddc)
            ->where('statuskeanggotaan', 'Core Team')
            ->count_all_results('v_dcmember');

        $jumlahmember = $this->db
            ->where('iddc', $iddc)
            ->where('statuskeanggotaan', 'Anggota')
            ->count_all_results('v_dcmember');

        echo json_encode([
            'status' => true,
            'data' => [
                'dm'      => $jumlahdm,
                'core'   => $jumlahcore,
                'member' => $jumlahmember,
                'total'  => $jumlahdm + $jumlahcore + $jumlahmember
            ]
        ]);
    }
}
