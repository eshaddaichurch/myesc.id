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

    public function member()
    {
        $iddc = $this->validateIddcHeader();

        $rs = $this->AbsendcModel->get_member_dc($iddc);

        if (!$rs) {
            $this->response(false, [], 'Query member gagal');
        }

        if ($rs->num_rows() === 0) {
            $this->response(true, []);
        }

        $data = [];
        foreach ($rs->result() as $row) {
            $data[] = [
                'idjemaat' => $row->idjemaat,
                'namalengkap' => $row->namalengkap,
                'statuskeanggotaan' => $row->statuskeanggotaan,
            ];
        }

        $this->response(true, $data);
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

    public function simpan()
    {
        $iddc = $this->validateIddcHeader();

        $raw = json_decode(file_get_contents("php://input"), true);

        if (!$raw) {
            $this->response(false, [], "Payload tidak valid");
        }

        $keterangan = $raw['keterangan'] ?? 'Tanpa keterangan';
        $idjemaat   = $raw['idjemaat'] ?? [];
        $fotoBase64 = $raw['foto'] ?? null;

        if (count($idjemaat) == 0) {
            $this->response(false, [], "Minimal 1 jemaat harus hadir");
        }

        /* ================= SIMPAN FOTO ================= */
        $fotoName = null;
        if ($fotoBase64) {
            if (preg_match('/^image\/(\w+);base64,/', $fotoBase64, $type)) {
                $fotoBase64 = substr($fotoBase64, strpos($fotoBase64, ',') + 1);
                $ext = strtolower($type[1]);

                $fotoBase64 = base64_decode($fotoBase64);

                if ($fotoBase64 === false) {
                    $this->response(false, [], "Foto tidak valid");
                }

                $fotoName = uniqid('absen_') . '.' . $ext;
                file_put_contents(FCPATH . 'uploads/absensi/' . $fotoName, $fotoBase64);
            }
        }

        /* ================= SIMPAN DB ================= */
        $dataHeader = [
            'tglabsen'      => date('Y-m-d H:i:s'),
            'iddc'          => $iddc,
            'keterangan'    => $keterangan,
            'totalpeserta'  => count($idjemaat),
            'foto'          => $fotoName,
        ];

        $simpan = $this->AbsendcModel->simpan($dataHeader, $idjemaat);

        if ($simpan) {
            $this->response(true, [], "Absensi berhasil disimpan");
        }

        $this->response(false, [], "Gagal menyimpan absensi");
    }

    

}