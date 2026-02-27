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

        $rowDCM = $this->DcmemberprogressModel->get_by_id($iddcmember);

        if ($rowDCM->num_rows() < 1) {
            echo json_encode([
                "status" => false,
                "message" => "Data tidak ditemukan"
            ]);
            return;
        }

        $member = $rowDCM->row();
        $pertanyaan = $this->DcmemberprogressModel
                            ->get_pertanyaan()
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

        $progress = $this->db
            ->where('iddcmember', $iddcmember)
            ->order_by('idprogress', 'DESC')
            ->get('dcmember_progress')
            ->result();

        $result = [];

        foreach ($progress as $row) {

            // ambil detail penilaian
            $detail = $this->db
                ->select('k.namakategori, p.pertanyaan, d.nilai')
                ->from('dcmember_progress_det d')
                ->join('pertanyaanprogressdcm p', 'p.idpertanyaan = d.idpertanyaan')
                ->join('pertanyaanprogresskategori k', 'k.idkategori = p.idkategori')
                ->where('d.idprogress', $row->idprogress)
                ->order_by('k.idkategori ASC, p.idpertanyaan ASC')
                ->get()
                ->result();

            $result[] = [
                "idprogress"      => $row->idprogress,
                "tglprogress"     => $row->tglprogress,
                "nilairatarata"   => floatval($row->nilairatarata),
                "detail"          => $detail
            ];
        }

        echo json_encode([
            "status" => true,
            "total"  => count($result),
            "data"   => $result
        ]);
    }

    // =========================================
    // 4️⃣ SIMPAN PROGRESS
    // =========================================
    public function simpan()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $iddcmember    = $input['iddcmember'] ?? null;
        $iddc          = $input['iddc'] ?? null;
        $idjemaatdm    = $input['idjemaatdm'] ?? null;
        $nilairatarata = $input['nilairatarata'] ?? null;
        $detail        = $input['detail'] ?? [];

        if (!$iddcmember || !$iddc || !$idjemaatdm || !$nilairatarata) {
            echo json_encode([
                "status" => false,
                "message" => "Data tidak lengkap"
            ]);
            return;
        }

        $this->db->trans_start();

        // 1️⃣ Insert master progress
        $data = [
            "iddcmember"    => $iddcmember,
            "iddc"          => $iddc,
            "idjemaatdm"    => $idjemaatdm,
            "nilairatarata" => $nilairatarata,
            "tglprogress"   => date('Y-m-d H:i:s'),
            "tglinsert"     => date('Y-m-d H:i:s')
        ];

        $this->db->insert('dcmember_progress', $data);
        $idprogress = $this->db->insert_id();

        // 2️⃣ Insert detail pertanyaan
        foreach ($detail as $row) {
            $this->db->insert('dcmember_progress_det', [
                "idprogress"   => $idprogress,
                "idpertanyaan" => $row['idpertanyaan'],
                "nilai"        => $row['nilai']
            ]);
        }

        $this->db->trans_complete();

        echo json_encode([
            "status" => $this->db->trans_status()
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