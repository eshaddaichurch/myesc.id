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
        $this->load->helper('mdata_helper');
    }

    /* ===============================
     * RESPONSE HELPER
     * =============================== */
    private function response($status, $data = [], $message = '')
    {
        http_response_code(200);
        echo json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }
    

    /* ===============================
     * VALIDASI HEADER DC
     * =============================== */
    private function validateIddcHeader()
    {
        $iddc = $this->input->get_request_header('iddc', TRUE)
        ?: $this->input->get_request_header('IDDC', TRUE);

        if (!$iddc) {
            $this->response(false, [], 'ID DC tidak ditemukan');
        }

    }

    /* ===============================
     * 📌 LIST ABSENSI
     * =============================== */
    public function list()
    {
        $iddc = $this->validateIddcHeader();
        $rs   = $this->AbsendcModel->get_all($iddc);

        $data = [];
        foreach ($rs->result() as $row) {
            $data[] = [
                'idabsen'        => $row->idabsen,
                'tglabsen'       => $row->tglabsen,
                'totalpeserta'   => (int) $row->totalpeserta,
                'keterangan'     => $row->keterangan,
                'formatted_date' => formatHariTanggalJam($row->tglabsen),
                'foto'           => $row->foto,
                'foto_url'       => buildFotoAbsensiUrl($row->foto),
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

        $rs = $this->AbsendcModel->get_detail_absensi($idabsen);
        if ($rs->num_rows() === 0) {
            $this->response(false, [], 'Data absensi tidak ditemukan');
        }

        $row = $rs->row();

        if ($row->iddc !== $iddc) {
            $this->response(false, [], 'Akses ditolak');
        }

        $peserta = $this->AbsendcModel->get_peserta_absensi($idabsen);

        $this->response(true, [
            'absensi' => [
                'idabsen'        => $row->idabsen,
                'tglabsen'       => $row->tglabsen,
                'keterangan'     => $row->keterangan,
                'totalpeserta'   => (int) $row->totalpeserta,
                'formatted_date' => formatHariTanggalJam($row->tglabsen),
                'foto'           => $row->foto,
                'foto_url'       => buildFotoAbsensiUrl($row->foto),
            ],
            'peserta' => $peserta->result_array()
        ]);
    }
}
