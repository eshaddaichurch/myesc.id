<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Konfirmasidc_model');
        $this->load->library('encrypt');
    }

    /* ================= LIST ================= */
    public function index()
    {
        $rs = $this->Konfirmasidc_model->getPermohonan();

        $data = [];
        foreach ($rs->result() as $row) {
            $data[] = [
                'idpermohonan' => $this->encrypt->encode($row->idpermohonan),
                'idjemaat'     => $row->idjemaat,
                'nama'         => $row->namalengkap,
                'tanggal'      => tglindonesia($row->tglpermohonan),
                'status'       => $row->statuskonfirmasi,
                'jeniskelamin' => $row->jeniskelamin,
                'umur'         => $row->umur,
                'foto'         => $row->foto
            ];
        }

        echo json_encode([
            'status' => true,
            'data'   => $data
        ]);
    }

    /* ================= DETAIL ================= */
    public function detail($idpermohonan)
    {
        $id = $this->encrypt->decode($idpermohonan);
        $rs = $this->Konfirmasidc_model->getPermohonanID($id);

        if ($rs->num_rows() == 0) {
            echo json_encode(['status' => false, 'msg' => 'Data tidak ditemukan']);
            return;
        }

        $row = $rs->row();

        echo json_encode([
            'status' => true,
            'data' => [
                'jemaat' => $row,
                'keluarga' => $this->App->getJemaatFamily($row->idjemaat),
                'nextstep' => $this->App->getKelasJemaat($row->idjemaat)->result()
            ]
        ]);
    }

    /* ================= TOLAK ================= */
    public function tolak()
    {
        $id = $this->encrypt->decode($this->input->post('idpermohonan'));
        $alasan = $this->input->post('alasan');

        $simpan = $this->Konfirmasidc_model->tolak($id, $alasan);

        echo json_encode([
            'status' => $simpan
        ]);
    }

    /* ================= SETUJU ================= */
    public function setuju()
    {
        $id = $this->encrypt->decode($this->input->post('idpermohonan'));

        $simpan = $this->Konfirmasidc_model->setujuMobile($id);

        echo json_encode([
            'status' => $simpan
        ]);
    }
}
