<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsendcApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        error_reporting(0);
        ini_set('display_errors', 0);

        header('Content-Type: application/json');

        $this->load->model('AbsendcModel');
        $this->load->helper('mdata_helper'); // ✅ Gunakan helper yang sudah ada
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
     * 📌 LIST ABSENSI
     * =============================== */
    public function list()
    {
        $iddc = $this->validateIddcHeader();

        $rs = $this->AbsendcModel->get_all($iddc);

        $data = [];
        foreach ($rs->result() as $row) {
            $formattedDate = formatHariTanggalJam($row->tglabsen);
            
            $data[] = [
                'idabsen' => $row->idabsen,
                'tglabsen' => $row->tglabsen,
                'totalpeserta' => (int)$row->totalpeserta,
                'keterangan' => $row->keterangan,
                'formatted_date' => $formattedDate,
                'foto' => $row->foto, // ✅ TAMBAHKAN FOTO DI LIST
            ];
        }

        $this->response(true, $data);
    }

    /* ===============================
     * 📌 DETAIL ABSENSI
     * =============================== */
    public function detail($idabsen)
    {
        $iddc = $this->validateIddcHeader();

        // ✅ Ambil detail absensi
        $rs = $this->AbsendcModel->get_detail_absensi($idabsen);
        if ($rs->num_rows() == 0) {
            $this->response(false, [], 'Data absensi tidak ditemukan');
        }

        $row = $rs->row();

        // ✅ Cek apakah absensi milik DC yang sedang login
        if ($row->iddc != $iddc) {
            $this->response(false, [], 'Akses ditolak');
        }

        // ✅ Ambil detail peserta
        $peserta = $this->AbsendcModel->get_peserta_absensi($idabsen);

        $this->response(true, [
            'absensi' => [
                'idabsen' => $row->idabsen,
                'tglabsen' => $row->tglabsen,
                'keterangan' => $row->keterangan,
                'totalpeserta' => (int)$row->totalpeserta,
                'formatted_date' => formatHariTanggalJam($row->tglabsen),
                'foto' => $row->foto, // ✅ TAMBAHKAN FOTO DI DETAIL
            ],
            'peserta' => $peserta->result_array()
        ]);
    }

    /* ===============================
    * 📌 SIMPAN ABSENSI (MOBILE API)
    * =============================== */
    public function simpan()
    {
        // Validasi header iddc
        $iddc = $this->input->get_request_header('iddc');
        if (!$iddc) {
            $this->response(false, [], 'ID DC tidak ditemukan di header');
            return;
        }

        // Baca raw JSON body
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || !$input) {
            $this->response(false, [], 'Payload JSON tidak valid: ' . json_last_error_msg());
            return;
        }

        $keterangan = trim($input['keterangan'] ?? 'Tanpa keterangan');
        $idjemaat_arr = $input['idjemaat'] ?? [];
        
        if (empty($idjemaat_arr) || !is_array($idjemaat_arr)) {
            $this->response(false, [], 'Minimal 1 member harus dipilih');
            return;
        }

        // ✅ HANDLE FOTO BASE64
        $foto_name = null;
        if (!empty($input['foto'])) {
            $foto_raw = $input['foto'];
            // Format yang diterima: "image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQ..."
            $parts = explode(',', $foto_raw);
            if (count($parts) === 2) {
                $base64 = $parts[1];
                $binary = base64_decode($base64);
                
                if ($binary === false || strlen($binary) < 100) { // Validasi minimal size
                    $this->response(false, [], 'Data gambar tidak valid');
                    return;
                }
                
                // Generate filename unik
                $ext = 'jpg';
                if (strpos($parts[0], 'png') !== false) $ext = 'png';
                $filename = 'absensi_' . date('YmdHis') . '_' . substr(md5(microtime()), 0, 8) . '.' . $ext;
                $upload_dir = FCPATH . 'uploads/absensi/';
                
                // Buat folder jika belum ada
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $filepath = $upload_dir . $filename;
                if (file_put_contents($filepath, $binary)) {
                    $foto_name = $filename;
                } else {
                    $this->response(false, [], 'Gagal menyimpan file foto ke server');
                    return;
                }
            }
        }

        // ✅ SIMPAN KE DATABASE
        $this->db->trans_start();
        
        // Insert header absensi
        $header_data = [
            'tglabsen' => date('Y-m-d H:i:s'),
            'foto' => $foto_name,
            'iddc' => $iddc,
            'keterangan' => $keterangan,
            'totalpeserta' => count($idjemaat_arr),
            'idpengguna' => $iddc, // Gunakan iddc sebagai idpengguna untuk mobile
        ];
        $this->db->insert('absendc', $header_data);
        $idabsen = $this->db->insert_id();
        
        // Insert detail peserta
        $detail_batch = [];
        foreach ($idjemaat_arr as $idj) {
            $detail_batch[] = [
                'idabsen' => $idabsen,
                'idjemaat' => $idj,
                'hadir' => 1,
                'tglinput' => date('Y-m-d H:i:s'),
            ];
        }
        
        if (!empty($detail_batch)) {
            $this->db->insert_batch('absendcdetail', $detail_batch);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === false) {
            // Rollback: hapus foto jika gagal
            if ($foto_name && file_exists($upload_dir . $foto_name)) {
                unlink($upload_dir . $foto_name);
            }
            $this->response(false, [], 'Gagal menyimpan ke database');
            return;
        }
        
        $this->response(true, ['idabsen' => $idabsen], 'Absensi berhasil disimpan');
    }

}