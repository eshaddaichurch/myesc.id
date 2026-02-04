<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfirmasidcApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Konfirmasidc_model');
        $this->load->library('encrypt');

        header('Content-Type: application/json');
    }

    // 🔐 contoh: pakai token nanti
    private function response($status, $data = [], $message = '')
    {
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    // 📌 LIST PERMOHONAN
    public function list()
    {
        // nanti iddc dari token
        $iddc = $this->input->get_request_header('iddc');

        if (!$iddc) {
            $this->response(false, [], 'ID DC tidak ditemukan');
        }

        $this->session->set_userdata('iddc', $iddc);
        $rs = $this->Konfirmasidc_model->getPermohonan();

        $this->response(true, $rs->result());
    }

    // 📌 DETAIL PERMOHONAN
    public function detail($encryptedId)
    {
        $idpermohonan = $this->encrypt->decode($encryptedId);

        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);

        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data tidak ditemukan');
        }

        $row = $rs->row();
        $idjemaat = $row->idjemaat;

        $nextStep = $this->App->getKelasJemaat($idjemaat)->result();
        $family   = $this->App->getJemaatFamily($idjemaat);

        $this->response(true, [
            'permohonan' => $row,
            'nextStep' => $nextStep,
            'family' => $family
        ]);
    }

    // ❌ TOLAK
    public function tolak()
    {
        $idpermohonan = $this->encrypt->decode($this->input->post('idpermohonan'));
        $alasan = $this->input->post('alasan');

        $ok = $this->Konfirmasidc_model->tolak($idpermohonan, $alasan);

        if ($ok) {
            $this->response(true, [], 'Permohonan ditolak');
        }

        $this->response(false, [], 'Gagal menolak permohonan');
    }

    // ✅ SETUJU
    public function setuju()
    {
        $idpermohonan = $this->encrypt->decode($this->input->post('idpermohonan'));

        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data tidak ditemukan');
        }

        $row = $rs->row();
        $idjemaat = $row->idjemaat;

        // cek sudah anggota
        if ($this->Konfirmasidc_model->getDcMemberAktif($idjemaat)->num_rows() > 0) {
            $this->response(false, [], 'Jemaat sudah menjadi anggota DC');
        }

        $ok = $this->Konfirmasidc_model->setuju($idjemaat, $idpermohonan, $row);

        if ($ok) {
            // kirim WA tetap di backend
            $rowJemaat = $this->App->getInfoJemaat($idjemaat);
            $rowDc = $this->Konfirmasidc_model->getDC($row->iddc)->row();

            $pesanWA = "Shalom {$rowJemaat->namalengkap}, pendaftaran DC Anda disetujui...";
            $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);

            $this->response(true, [], 'Permohonan disetujui');
        }

        $this->response(false, [], 'Gagal menyetujui permohonan');
    }
}
