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
            echo json_encode([
                'status' => false,
                'message' => 'Header iddc wajib'
            ]);
            return;
        }

    }

    public function member()
    {
        $iddc = $this->input->get('iddc');

        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib diisi',
                'data' => []
            ]);
            return;
        }

        $data = $this->db
            ->where('iddc', $iddc)
            ->order_by('namalengkap', 'ASC')
            ->get('v_dcmember')
            ->result();

        echo json_encode([
            'status' => true,
            'total'  => count($data),
            'data'   => $data
        ]);
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
        try {
            $iddc = $this->input->get_request_header('iddc', TRUE);
            $idpengguna = $this->input->get_request_header('idjemaat', TRUE);

            $raw = json_decode($this->input->raw_input_stream, true);

            if (!$raw) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Payload JSON kosong'
                ]);
                return;
            }

            if (!$iddc || !$idpengguna) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Header iddc atau idpengguna tidak ditemukan',
                    'debug' => [
                        'iddc' => $iddc,
                        'idpengguna' => $idpengguna
                    ]
                ]);
                return;
            }

            // ================= INSERT =================
            $data = [
                'iddc'         => $iddc,
                'idpengguna'  => $idpengguna,
                'keterangan'  => $raw['keterangan'] ?? '',
                'totalpeserta'=> count($raw['idjemaat'] ?? [])
            ];

            $insert = $this->db->insert('absen_dc', $data);

            if (!$insert) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Gagal insert absen'
                ]);
                return;
            }

            echo json_encode([
                'status' => true,
                'message' => 'Absensi berhasil disimpan'
            ]);
        } catch (Throwable $e) {
            echo json_encode([
                'status' => false,
                'message' => 'Exception server',
                'error' => $e->getMessage()
            ]);
        }
    }

    

}