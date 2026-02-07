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
    * 📌 SIMPAN ABSENSI (MOBILE)
    * =============================== */
    public function simpan()
    {
        $iddc = $this->validateIddcHeader();
        
        // Baca raw JSON body (mobile kirim JSON, bukan form-data)
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || !$input) {
            $this->response(false, [], 'Invalid JSON payload');
            return;
        }

        $keterangan = $input['keterangan'] ?? '';
        $idjemaat = $input['idjemaat'] ?? []; // array ID member yang hadir
        
        // ✅ HANDLE FOTO BASE64 (dari mobile app)
        $foto_name = null;
        if (!empty($input['foto'])) {
            // Format: "image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQ..."
            $parts = explode(',', $input['foto']);
            if (count($parts) === 2) {
                $base64 = $parts[1];
                $binary = base64_decode($base64);
                
                // Validasi gambar
                if ($binary === false) {
                    $this->response(false, [], 'Invalid base64 image');
                    return;
                }
                
                // Simpan file
                $filename = 'absensi_' . time() . '_' . bin2hex(random_bytes(4)) . '.jpg';
                $filepath = FCPATH . 'uploads/absensi/' . $filename;
                
                // Pastikan folder ada
                if (!is_dir(FCPATH . 'uploads/absensi')) {
                    mkdir(FCPATH . 'uploads/absensi', 0777, true);
                }
                
                if (file_put_contents($filepath, $binary)) {
                    $foto_name = $filename;
                }
            }
        }

        // ✅ SIAPKAN DATA HEADER
        $dataHeader = [
            'tglabsen' => date('Y-m-d H:i:s'),
            'foto' => $foto_name,
            'iddc' => $iddc,
            'keterangan' => $keterangan,
            'totalpeserta' => count($idjemaat),
            'idpengguna' => $iddc, // ✅ Mobile tidak kirim idpengguna, gunakan iddc sebagai fallback
        ];

        // ✅ SIMPAN KE DATABASE
        try {
            $this->db->trans_start();
            
            // Insert header absensi
            $this->db->insert('absendc', $dataHeader);
            $idabsen = $this->db->insert_id();
            
            // Insert detail peserta
            $batch = [];
            foreach ($idjemaat as $id) {
                $batch[] = [
                    'idabsen' => $idabsen,
                    'idjemaat' => $id,
                    'hadir' => 1,
                    'tglinput' => date('Y-m-d H:i:s'),
                ];
            }
            
            if (!empty($batch)) {
                $this->db->insert_batch('absendcdetail', $batch);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === false) {
                throw new Exception('Database transaction failed');
            }
            
            $this->response(true, ['idabsen' => $idabsen], 'Absensi berhasil disimpan');
            
        } catch (Exception $e) {
            // Hapus foto jika gagal
            if ($foto_name && file_exists(FCPATH . 'uploads/absensi/' . $foto_name)) {
                unlink(FCPATH . 'uploads/absensi/' . $foto_name);
            }
            
            $this->response(false, [], 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }
}