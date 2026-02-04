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

        // ✅ Ambil idjemaat dari header
        $idjemaatKonfirmasi = $this->input->get_request_header('idjemaat') ?? 'API_DEFAULT';

        if ($this->Konfirmasidc_model->tolak($idpermohonan, $alasan, $idjemaatKonfirmasi)) {
            $this->response(true, [], 'Permohonan ditolak');
        }

        $this->response(false, [], 'Gagal menolak permohonan');
    }

    /* ===============================
     * ✅ SETUJU - DIPERBAIKI DENGAN idjemaatkonfirmasi
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

        // ✅ Ambil idjemaat dari header
        $idjemaatKonfirmasi = $this->input->get_request_header('idjemaat') ?? 'API_DEFAULT';
        
        // ✅ LOG untuk debugging
        log_message('info', 'idjemaatkonfirmasi: ' . $idjemaatKonfirmasi);

        // ✅ Ambil data DC untuk pesan WhatsApp (seperti di website)
        $rowDc = $this->Konfirmasidc_model->getDC($row->iddc)->row();

        if ($this->Konfirmasidc_model->setuju($idjemaat, $idpermohonan, $row, $idjemaatKonfirmasi)) {

            $rowJemaat = $this->App->getInfoJemaat($idjemaat);
            
            // ✅ LOG untuk debugging
            log_message('info', 'Mengirim WhatsApp ke: ' . $rowJemaat->nohp);
            
            // ✅ Format nomor dengan validasi
            $formattedPhone = $this->formatNomorWhatsapp($rowJemaat->nohp);
            log_message('info', 'Nomor terformat: ' . $formattedPhone);
            
            // ✅ Pesan WhatsApp detail seperti website
            $pesanWA = "Shalom " . ucwords(strtolower($rowJemaat->namalengkap))  . "! 
    Selamat! Pendaftaran Saudara telah *disetujui*, dan Saudara kini bergabung di *" . $rowDc->namadc ."*.
    Saudara akan didampingi oleh DM: *" . ucwords(strtolower($rowDc->namadm)) . "*.
    DM akan menghubungi Saudara secara langsung melalui WhatsApp *dalam waktu maksimal 2×24 jam* untuk berkenalan dan mulai terhubung.
    Terima kasih atas kerinduan Saudara untuk bertumbuh bersama.
    Tuhan Yesus memberkati";

            // ✅ Tambahkan error handling
            try {
                $result = $this->whatsapp->send_message($formattedPhone, $pesanWA);
                
                if ($result === false) {
                    log_message('error', 'Gagal kirim WhatsApp ke ' . $formattedPhone);
                    // Tetap kembalikan success, tapi log error
                    $this->response(true, [], 'Permohonan disetujui (WhatsApp gagal terkirim)');
                } else {
                    log_message('info', 'WhatsApp berhasil terkirim ke ' . $formattedPhone);
                    $this->response(true, [], 'Permohonan disetujui');
                }
            } catch (\Exception $e) {
                log_message('error', 'Exception WhatsApp: ' . $e->getMessage());
                $this->response(true, [], 'Permohonan disetujui (WhatsApp gagal terkirim)');
            }
        }

        $this->response(false, [], 'Gagal menyetujui permohonan');
    }

    // ✅ Tambahkan helper format nomor
    private function formatNomorWhatsapp($nohp)
    {
        // Hapus karakter non-digit
        $nohp = preg_replace('/[^0-9]/', '', $nohp);
        
        // Jika dimulai dengan 0, ganti dengan +62
        if (strpos($nohp, '0') === 0) {
            $nohp = '+62' . substr($nohp, 1);
        }
        // Jika tidak ada kode negara, tambahkan
        else if (strpos($nohp, '62') === 0) {
            $nohp = '+' . $nohp;
        }
        
        return $nohp;
    }
}