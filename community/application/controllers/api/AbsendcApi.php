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
     * HELPER RESPONSE
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

    /* ===============================
     * VALIDASI HEADER IDDC
     * =============================== */
    private function validateIddcHeader()
    {
        $headers = $this->input->request_headers();

        // debug kalau perlu
        // file_put_contents('headers.log', json_encode($headers));

        $iddc = null;

        if (isset($headers['iddc'])) {
            $iddc = $headers['iddc'];
        } elseif (isset($headers['IDDC'])) {
            $iddc = $headers['IDDC'];
        } elseif (isset($headers['Http-Iddc'])) {
            $iddc = $headers['Http-Iddc'];
        } elseif (isset($_SERVER['HTTP_IDDC'])) {
            $iddc = $_SERVER['HTTP_IDDC'];
        }

        if (!$iddc) {
            $this->response(false, [], 'Header iddc wajib');
        }

        return $iddc;
    }


    /* ===============================
     * 📌 MEMBER DC
     * =============================== */
    public function member()
    {
        $iddc = $this->validateIddcHeader();

        $data = $this->db
            ->where('iddc', $iddc)
            ->order_by('namalengkap', 'ASC')
            ->get('v_dcmember')
            ->result();

        $this->response(true, [
            'total' => count($data),
            'data'  => $data
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
            $data[] = [
                'idabsen'        => $row->idabsen,
                'tglabsen'       => $row->tglabsen,
                'totalpeserta'   => (int) $row->totalpeserta,
                'keterangan'     => $row->keterangan,
                'formatted_date' => formatHariTanggalJam($row->tglabsen),
                'foto'           => $row->foto
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

        // Proteksi DC
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
                'foto'           => $row->foto
            ],
            'peserta' => $peserta->result_array()
        ]);
    }

    /* ===============================
     * 📌 SIMPAN ABSENSI
     * =============================== */
    public function simpan()
    {
        $this->db->insert('absen_dc', $data);

        if ($this->db->trans_status() === FALSE) {
            $error = $this->db->error();
            $this->db->trans_rollback();

            $this->response(false, [
                'db_error' => $error,
                'payload'  => $data
            ], 'Gagal menyimpan absensi');
        }

    }


}
