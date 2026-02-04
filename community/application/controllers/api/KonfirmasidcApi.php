<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfirmasidcApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // model & library wajib
        $this->load->model('Konfirmasidc_model');
        $this->load->model('App');
        $this->load->library('encrypt');
        $this->load->library('whatsapp');

        // response JSON
        header('Content-Type: application/json');
    }

    /**
     * Helper response JSON
     */
    private function response($status, $data = [], $message = '')
    {
        echo json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ]);
        exit;
    }

    /**
     * ===============================
     * 📌 LIST PERMOHONAN
     * GET /KonfirmasidcApi/list
     * Header: iddc
     * ===============================
     */
    public function list()
    {
        $iddc = $this->input->get_request_header('iddc');

        if (!$iddc) {
            $this->response(false, [], 'ID DC tidak ditemukan');
        }

        // simulasi auth (nanti dari token)
        $this->session->set_userdata('iddc', $iddc);

        $rs = $this->Konfirmasidc_model->getPermohonan();

        $this->response(true, $rs->result());
    }

    /**
     * ===============================
     * 📌 DETAIL PERMOHONAN
     * GET /KonfirmasidcApi/detail/{encryptedId}
     * ===============================
     */
    public function detail($encryptedId = null)
    {
        if (!$encryptedId) {
            $this->response(false, [], 'ID tidak valid');
        }

        $idpermohonan = $this->encrypt->decode($encryptedId);
        if (!$idpermohonan) {
            $this->response(false, [], 'Gagal decode ID');
        }

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
            'nextStep'   => $nextStep,
            'family'     => $family
        ]);
    }

    /**
     * ===============================
     * ❌ TOLAK PERMOHONAN
     * POST /KonfirmasidcApi/tolak
     * body: idpermohonan, alasan
     * ===============================
     */
    public function tolak()
    {
        $encryptedId = $this->input->post('idpermohonan');
        $alasan      = $this->input->post('alasan');

        if (!$encryptedId || !$alasan) {
            $this->response(false, [], 'Data tidak lengkap');
        }

        $idpermohonan = $this->encrypt->decode($encryptedId);
        if (!$idpermohonan) {
            $this->response(false, [], 'Gagal decode ID');
        }

        $ok = $this->Konfirmasidc_model->tolak($idpermohonan, $alasan);

        if ($ok) {
            $this->response(true, [], 'Permohonan ditolak');
        }

        $this->response(false, [], 'Gagal menolak permohonan');
    }

    /**
     * ===============================
     * ✅ SETUJU PERMOHONAN
     * POST /KonfirmasidcApi/setuju
     * body: idpermohonan
     * ===============================
     */
    public function setuju()
    {
        $encryptedId = $this->input->post('idpermohonan');

        if (!$encryptedId) {
            $this->response(false, [], 'ID tidak ditemukan');
        }

        $idpermohonan = $this->encrypt->decode($encryptedId);
        if (!$idpermohonan) {
            $this->response(false, [], 'Gagal decode ID');
        }

        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data tidak ditemukan');
        }

        $row = $rs->row();
        $idjemaat = $row->idjemaat;

        // cek apakah sudah anggota DC
        if ($this->Konfirmasidc_model->getDcMemberAktif($idjemaat)->num_rows() > 0) {
            $this->response(false, [], 'Jemaat sudah menjadi anggota DC');
        }

        $ok = $this->Konfirmasidc_model->setuju($idjemaat, $idpermohonan, $row);

        if ($ok) {
            // kirim WA tetap di backend
            $rowJemaat = $this->App->getInfoJemaat($idjemaat);
            $rowDc     = $this->Konfirmasidc_model->getDC($row->iddc)->row();

            $pesanWA = "Shalom {$rowJemaat->namalengkap}, pendaftaran DC Anda disetujui.";
            $this->whatsapp->send_message(
                formatNomorWhatsapp($rowJemaat->nohp),
                $pesanWA
            );

            $this->response(true, [], 'Permohonan disetujui');
        }

        $this->response(false, [], 'Gagal menyetujui permohonan');
    }
}
