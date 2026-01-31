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
        $iddc = $this->input->get('iddc');

        $dm = $this->db->query("
            SELECT COUNT(*) AS jumlah
            FROM v_dcmember
            WHERE iddc = '$iddc'
            AND statuskeanggotaan = 'Disciples maker'
        ")->row()->jumlah;

        $core = $this->db->query("
            SELECT COUNT(*) AS jumlah
            FROM v_dcmember
            WHERE iddc = '$iddc'
            AND statuskeanggotaan = 'Core Team'
        ")->row()->jumlah;

        $member = $this->db->query("
            SELECT COUNT(*) AS jumlah
            FROM v_dcmember
            WHERE iddc = '$iddc'
            AND statuskeanggotaan = 'Anggota'
        ")->row()->jumlah;

        echo json_encode([
            'status' => true,
            'data' => [
                'dm'     => (int)$dm,
                'core'   => (int)$core,
                'member' => (int)$member,
                'total'  => (int)($core + $member) // ✅ FIX
            ]
        ]);
    }

}
