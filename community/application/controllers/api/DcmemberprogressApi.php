<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DcmemberprogressApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        header("Content-Type: application/json");
        $this->load->model('DcmemberprogressModel');
    }

    public function index()
    {
        $iddc = $this->input->get('iddc');

        if (empty($iddc)) {
            echo json_encode([
                "status" => false,
                "message" => "IDDC tidak ditemukan"
            ]);
            return;
        }

        $members = $this->DcmemberprogressModel->get_member_only($iddc);

        $result = [];

        foreach ($members->result() as $row) {

            // FOTO
            if (!empty($row->foto)) {
                $foto = base_url('../admin/uploads/jemaat/' . $row->foto);
            } else {
                $foto = base_url('images/user-01.png');
            }

            // Ambil rating terakhir
            $rating = $this->db->select('nilairatarata')
                ->from('dcmember_progress')
                ->where('iddcmember', $row->iddcmember)
                ->order_by('tglprogress', 'desc')
                ->limit(1)
                ->get()
                ->row();

            $avg = !empty($rating->nilairatarata)
                ? floatval($rating->nilairatarata)
                : 0;

            $percentage = ($avg / 4) * 100;

            $result[] = [
                "iddcmember" => $row->iddcmember,
                "namalengkap" => $row->namalengkap,
                "statuskeanggotaan" => $row->statuskeanggotaan,
                "jeniskelamin" => $row->jeniskelamin,
                "umur" => $row->umur,
                "foto" => $foto,
                "avg_rating" => round($avg, 1),
                "percentage" => round($percentage, 1),
                "has_rating" => $avg > 0 ? true : false
            ];
        }

        echo json_encode([
            "status" => true,
            "data" => $result
        ]);
    }
}