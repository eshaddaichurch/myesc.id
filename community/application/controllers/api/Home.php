<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
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

        // Ambil data user berdasarkan iddc (DM nya)
        $user = $this->db->query("
        SELECT j.foto, j.namalengkap
        FROM v_dcmember v
        JOIN jemaat j ON j.idjemaat = v.idjemaat
        WHERE v.iddc = '$iddc'
        AND v.statuskeanggotaan = 'Disciples maker'
        LIMIT 1
        ")->row();

        echo json_encode([
            'status' => true,
            'data' => [
                'dm' => (int) $dm,
                'core' => (int) $core,
                'member' => (int) $member,
                'total' => (int) ($core + $member),
                'foto' => 'https://myesc.id/myesc.id/admin/uploads/jemaat/' . $user->foto,
            ]
        ]);
    }
}
