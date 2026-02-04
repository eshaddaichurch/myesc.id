<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfirmasidcApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        error_reporting(0);
        ini_set('display_errors', 0);

        header('Content-Type: application/json');

        $this->load->model('Konfirmasidc_model');
        $this->load->model('App');
        $this->load->library('encryption');
        $this->load->library('whatsapp');
    }

    /* ===============================
     * HELPER
     * =============================== */

    private function response($status, $data = [], $message = '')
    {
        echo json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ]);
        exit;
    }

    /** URL-safe encrypt */
    private function encryptId($id)
    {
        if ($id === null || $id === '') {
            return null;
        }

        return rtrim(strtr(
            $this->encryption->encrypt((string)$id),
            '+/', '-_'
        ), '=');
    }

    /** URL-safe decrypt - ✅ DIPERBAIKI DENGAN PENAMBAHAN PADDING */
    private function decryptId($hash)
    {
        // ✅ Tambahkan padding Base64 yang hilang (KRUSIAL!)
        $remainder = strlen($hash) % 4;
        if ($remainder) {
            $hash .= str_repeat('=', 4 - $remainder);
        }

        $data = strtr($hash, '-_', '+/');
        $decrypted = $this->encryption->decrypt($data);

        // ✅ Debugging: log untuk troubleshooting
        if ($decrypted === false) {
            log_message('error', 'Decryption failed for hash: ' . $hash);
        }

        return $decrypted;
    }

    /** Validasi header iddc */
    private function validateIddcHeader()
    {
        $iddc = $this->input->get_request_header('iddc');
        if (!$iddc) {
            $this->response(false, [], 'ID DC tidak ditemukan');
        }
        return $iddc;
    }

    /* ===============================
     * 📌 LIST
     * =============================== */
    public function list()
    {
        $iddc = $this->validateIddcHeader();
        $this->session->set_userdata('iddc', $iddc);

        $rs = $this->Konfirmasidc_model->getPermohonan();

        $data = [];
        foreach ($rs->result() as $row) {
            if ($row->idpermohonan === null) {
                continue;
            }
            $row->idpermohonan = $this->encryptId($row->idpermohonan);
            $data[] = $row;
        }

        $this->response(true, $data);
    }

    /* ===============================
     * 📌 DETAIL
     * =============================== */
    public function detail($encryptedId = null)
    {
        $this->validateIddcHeader();

        // ✅ Terima ID dari parameter URL atau POST
        if (empty($encryptedId)) {
            $encryptedId = $this->input->post('idpermohonan');
        }

        if (empty($encryptedId)) {
            $this->response(false, [], 'ID tidak valid');
        }

        $idpermohonan = $this->decryptId($encryptedId);
        if (!$idpermohonan) {
            // ✅ Debugging: kirim pesan error yang lebih informatif
            $this->response(false, [], 'Gagal decode ID: Format tidak valid');
        }

        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data tidak ditemukan');
        }

        $row = $rs->row();
        $idjemaat = $row->idjemaat;

        $this->response(true, [
            'permohonan' => $row,
            'nextStep'   => $this->App->getKelasJemaat($idjemaat)->result(),
            'family'     => $this->App->getJemaatFamily($idjemaat)
        ]);
    }

    /* ===============================
     * ❌ TOLAK
     * =============================== */
    public function tolak()
    {
        $this->validateIddcHeader();

        $encryptedId = $this->input->post('idpermohonan');
        $alasan      = $this->input->post('alasan');

        if (!$encryptedId || !$alasan) {
            $this->response(false, [], 'Data tidak lengkap');
        }

        $idpermohonan = $this->decryptId($encryptedId);
        if (!$idpermohonan) {
            $this->response(false, [], 'Gagal decode ID: Format tidak valid');
        }

        if ($this->Konfirmasidc_model->tolak($idpermohonan, $alasan)) {
            $this->response(true, [], 'Permohonan ditolak');
        }

        $this->response(false, [], 'Gagal menolak permohonan');
    }

    /* ===============================
     * ✅ SETUJU
     * =============================== */
    public function setuju()
    {
        $this->validateIddcHeader();

        $encryptedId = $this->input->post('idpermohonan');
        if (!$encryptedId) {
            $this->response(false, [], 'ID tidak ditemukan');
        }

        $idpermohonan = $this->decryptId($encryptedId);
        if (!$idpermohonan) {
            $this->response(false, [], 'Gagal decode ID: Format tidak valid');
        }

        $rs = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data tidak ditemukan');
        }

        $row = $rs->row();
        $idjemaat = $row->idjemaat;

        if ($this->Konfirmasidc_model->getDcMemberAktif($idjemaat)->num_rows() > 0) {
            $this->response(false, [], 'Jemaat sudah menjadi anggota DC');
        }

        if ($this->Konfirmasidc_model->setuju($idjemaat, $idpermohonan, $row)) {

            $rowJemaat = $this->App->getInfoJemaat($idjemaat);
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