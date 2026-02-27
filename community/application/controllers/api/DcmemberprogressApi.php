<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DcmemberprogressApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");
    }

    // =========================================
    // 1️⃣ LIST MEMBER (SUDAH BENAR - TIDAK DIUBAH)
    // =========================================
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

        $members = $this->db
            ->where('iddc', $iddc)
            ->where("statuskeanggotaan !=", "Disciples Maker")
            ->order_by('namalengkap', 'ASC')
            ->get('v_dcmember')
            ->result();

        $result = [];

        foreach ($members as $row) {

            $foto = !empty($row->foto)
                ? base_url('../admin/uploads/jemaat/' . $row->foto)
                : base_url('images/user-01.png');

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

    // =========================================
    // 2️⃣ DETAIL MEMBER + PERTANYAAN
    // =========================================
    public function detail()
    {
        $iddcmember = $this->input->get('iddcmember');

        if (!$iddcmember) {
            echo json_encode([
                "status" => false,
                "message" => "iddcmember wajib diisi"
            ]);
            return;
        }

        $member = $this->db
            ->where('iddcmember', $iddcmember)
            ->get('v_dcmember')
            ->row();

        if (!$member) {
            echo json_encode([
                "status" => false,
                "message" => "Data tidak ditemukan"
            ]);
            return;
        }

        $pertanyaan = $this->db
            ->order_by('urutan', 'ASC')
            ->get('dcmember_pertanyaan')
            ->result();

        echo json_encode([
            "status" => true,
            "member" => $member,
            "pertanyaan" => $pertanyaan
        ]);
    }

    // =========================================
    // 3️⃣ RIWAYAT PROGRESS
    // =========================================
    public function riwayat()
    {
        $iddcmember = $this->input->get('iddcmember');

        if (!$iddcmember) {
            echo json_encode([
                "status" => false,
                "message" => "iddcmember wajib diisi"
            ]);
            return;
        }

        $riwayat = $this->db
            ->where('iddcmember', $iddcmember)
            ->order_by('tglprogress', 'DESC')
            ->get('dcmember_progress')
            ->result();

        echo json_encode([
            "status" => true,
            "total"  => count($riwayat),
            "data"   => $riwayat
        ]);
    }

    // =========================================
    // 4️⃣ SIMPAN PROGRESS
    // =========================================
    public function simpan()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $iddcmember   = $input['iddcmember'] ?? null;
        $iddc         = $input['iddc'] ?? null;
        $idjemaatdm   = $input['idjemaatdm'] ?? null;
        $nilairatarata= $input['nilairatarata'] ?? null;

        if (!$iddcmember || !$iddc || !$idjemaatdm || !$nilairatarata) {
            echo json_encode([
                "status" => false,
                "message" => "Data tidak lengkap"
            ]);
            return;
        }

        $data = [
            "iddcmember"     => $iddcmember,
            "iddc"           => $iddc,
            "idjemaatdm"     => $idjemaatdm,
            "nilairatarata"  => $nilairatarata,
            "tglprogress"    => date('Y-m-d H:i:s'),
            "tglinsert"      => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert('dcmember_progress', $data);

        echo json_encode([
            "status" => $insert ? true : false
        ]);
    }

    // =========================================
    // 5️⃣ DELETE PROGRESS
    // =========================================
    public function delete()
    {
        $iddcmember = $this->input->post('iddcmember');

        if (!$iddcmember) {
            echo json_encode([
                "status" => false,
                "message" => "iddcmember wajib diisi"
            ]);
            return;
        }

        $delete = $this->db
            ->where('iddcmember', $iddcmember)
            ->delete('dcmember_progress');

        echo json_encode([
            "status" => $delete ? true : false
        ]);
    }
}