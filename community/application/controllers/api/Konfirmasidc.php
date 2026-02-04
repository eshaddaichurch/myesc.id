<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');

        // MODEL ASLI WEBSITE
        $this->load->model('Konfirmasidc_model');

        // DEPENDENCY WEBSITE
        $this->load->library('whatsapp');
        $this->load->helper('whatsapp');
        $this->load->model('App');
    }

    public function setuju()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $idpermohonan   = $input['idpermohonan'] ?? null;
        $idjemaatAdmin  = $input['idjemaat_admin'] ?? null;

        if (!$idpermohonan || !$idjemaatAdmin) {
            echo json_encode([
                'status' => false,
                'message' => 'idpermohonan & idjemaat_admin wajib'
            ]);
            return;
        }

        // 🔐 PENTING: SET SESSION ADMIN (MENYAMAI WEBSITE)
        $this->session->set_userdata('idjemaat', $idjemaatAdmin);

        // 🔁 AMBIL DATA PERMOHONAN
        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Data permohonan tidak ditemukan'
            ]);
            return;
        }

        $rowPermohonan = $rs->row();
        $idjemaat      = $rowPermohonan->idjemaat;

        // 🔒 CEK SUDAH JADI MEMBER?
        if ($this->Konfirmasidc_model->getDcMemberAktif($idjemaat)->num_rows() > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Jemaat sudah menjadi anggota DC'
            ]);
            return;
        }

        // 🔥 PANGGIL LOGIC ASLI WEBSITE (TANPA MODIFIKASI)
        $simpan = $this->Konfirmasidc_model->setuju(
            $idjemaat,
            $idpermohonan,
            $rowPermohonan
        );

        if (!$simpan) {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal menyetujui permohonan'
            ]);
            return;
        }

        echo json_encode([
            'status' => true
        ]);
    }
}
