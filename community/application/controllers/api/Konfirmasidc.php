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
    
        $idpermohonan = $input['idpermohonan'] ?? null;
        $idadmin = $input['idadmin'] ?? null;
    
        if (!$idpermohonan || !$idadmin) {
            echo json_encode([
                'status' => false,
                'message' => 'idpermohonan & idadmin wajib'
            ]);
            return;
        }
    
        $this->load->model('Konfirmasidc_model');
    
        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Data permohonan tidak ditemukan'
            ]);
            return;
        }
    
        $rowPermohonan = $rs->row();
        $idjemaat = $rowPermohonan->idjemaat;
    
        // Cek apakah sudah DC member
        $rsDcMember = $this->Konfirmasidc_model->getDcMemberAktif($idjemaat);
        if ($rsDcMember->num_rows() > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Jemaat sudah menjadi anggota DC'
            ]);
            return;
        }
    
        // Ambil DC
        $rowDc = $this->Konfirmasidc_model->getDC($rowPermohonan->iddc)->row();
    
        // Simpan persetujuan (LOGIC INTI)
        $simpan = $this->Konfirmasidc_model
            ->setuju($idjemaat, $idpermohonan, $rowPermohonan);
    
        if (!$simpan) {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal menyetujui permohonan'
            ]);
            return;
        }
    
        // Ambil data jemaat
        $rowJemaat = $this->App->getInfoJemaat($idjemaat);
    
        // 🔥 PESAN WA IDENTIK DENGAN WEBSITE
        $pesanWA = "Shalom " . ucwords(strtolower($rowJemaat->namalengkap))  . "! 
    Selamat! Pendaftaran Saudara telah *disetujui*, dan Saudara kini bergabung di *" . $rowDc->namadc ."*.
    Saudara akan didampingi oleh DM: *" . ucwords(strtolower($rowDc->namadm)) . "*.
    DM akan menghubungi Saudara secara langsung melalui WhatsApp *dalam waktu maksimal 2×24 jam* untuk berkenalan dan mulai terhubung.
    Terima kasih atas kerinduan Saudara untuk bertumbuh bersama.
    Tuhan Yesus memberkati";
    
        $this->whatsapp->send_message(
            formatNomorWhatsapp($rowJemaat->nohp),
            $pesanWA
        );
    
        echo json_encode([
            'status' => true
        ]);
    }
    


}
