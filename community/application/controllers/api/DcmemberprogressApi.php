<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DcmemberprogressApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");
    }

    public function index()
    {
        $iddc = $this->input->get('iddc');

        if (!$iddc) {
            echo json_encode([
                "status" => false,
                "message" => "iddc wajib diisi"
            ]);
            return;
        }

        // 🔥 Ambil langsung dari view seperti API daftar member
        $members = $this->db
            ->where('iddc', $iddc)
            ->where("statuskeanggotaan !=", "Disciples Maker") // samakan persis dengan isi DB
            ->order_by('namalengkap', 'ASC')
            ->get('v_dcmember')
            ->result();

        $result = [];

        foreach ($members as $row) {

            // FOTO
            $foto = !empty($row->foto)
                ? base_url('../admin/uploads/jemaat/' . $row->foto)
                : base_url('images/user-01.png');

            // 🔥 Ambil rating terakhir
            $rating = $this->db
                ->select('nilairatarata')
                ->where('iddcmember', $row->iddcmember)
                ->order_by('idprogress', 'DESC')
                ->limit(1)
                ->get('dcmember_progress')
                ->row();

            $avg = ($rating && $rating->nilairatarata)
                ? floatval($rating->nilairatarata)
                : 0;

            $percentage = ($avg / 4) * 100;

            $result[] = [
                "iddcmember"       => $row->iddcmember,
                "namalengkap"      => $row->namalengkap,
                "statuskeanggotaan"=> $row->statuskeanggotaan,
                "jeniskelamin"     => $row->jeniskelamin,
                "umur"             => $row->umur,
                "foto"             => $foto,
                "avg_rating"       => round($avg, 1),
                "percentage"       => round($percentage, 1),
                "has_rating"       => $avg > 0
            ];
        }

        echo json_encode([
            "status" => true,
            "total"  => count($result),
            "data"   => $result
        ]);
    }
}