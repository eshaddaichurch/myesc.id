<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Dokumen_model');
        // Kode menu 'C110' = "Review Dokumen", didaftarkan di bawah
        // menu Care (C000), khusus otorisasi Administrator (0000).
        $this->session->set_userdata('IDMENUSELECTED', 'C110');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'dokumen';
        $data['jumlahMenunggu'] = $this->Dokumen_model->count_by_status('Menunggu Review');
        $data['jumlahDisetujui'] = $this->Dokumen_model->count_by_status('Disetujui');
        $data['jumlahDitolak'] = $this->Dokumen_model->count_by_status('Ditolak');
        $data['rsJenisDokumen'] = $this->Dokumen_model->getJenisDokumenAktif();
        $this->load->view('dokumen/listdata', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Dokumen_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                if ($rowdata->statusdokumen == 'Menunggu Review') {
                    $badge = '<span class="badge badge-warning">Menunggu Review</span>';
                } elseif ($rowdata->statusdokumen == 'Disetujui') {
                    $badge = '<span class="badge badge-success">Disetujui</span>';
                } else {
                    $badge = '<span class="badge badge-danger">Ditolak</span>';
                }

                // Kunci gabungan (idjemaat + kodedokumen) di-encode jadi satu
                // token, karena PK tabel jemaatdokumen sekarang komposit.
                $token = $this->encrypt->encode($rowdata->idjemaat . '||' . $rowdata->kodedokumen);

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->namalengkap;
                $row[] = $rowdata->namadokumen ?: $rowdata->kodedokumen;
                $row[] = formatHariTanggalJam($rowdata->tglupload);
                $row[] = $badge;
                $row[] = '<a href="' . site_url('dokumen/review/' . $token) . '" class="btn btn-sm btn-info btn-circle" title="Review"><i class="fas fa-eye"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Dokumen_model->count_all(),
            'recordsFiltered' => $this->Dokumen_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function review($token)
    {
        $decoded = $this->encrypt->decode($token);
        $parts = explode('||', $decoded);

        if (count($parts) != 2) {
            show_404();
            return;
        }

        list($idjemaat, $kodedokumen) = $parts;

        $rowDokumen = $this->Dokumen_model->get_by_idjemaat_kodedokumen($idjemaat, $kodedokumen);

        if (!$rowDokumen) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dokumen');
            exit();
        }

        $data['rowDokumen'] = $rowDokumen;
        $data['idjemaat'] = $idjemaat;
        $data['kodedokumen'] = $kodedokumen;
        $data['menu'] = 'dokumen';
        $this->load->view('dokumen/review', $data);
    }

    public function proses()
    {
        $idjemaat = $this->input->post('idjemaat');
        $kodedokumen = $this->input->post('kodedokumen');
        $aksi = $this->input->post('aksi');  // 'setuju' atau 'tolak'
        $catatan = $this->input->post('catatan');

        $token = $this->encrypt->encode($idjemaat . '||' . $kodedokumen);

        if ($aksi == 'tolak' && empty(trim($catatan))) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Catatan alasan penolakan wajib diisi.
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dokumen/review/' . $token);
            exit();
        }

        $statusdokumen = ($aksi == 'setuju') ? 'Disetujui' : 'Ditolak';

        $dataUpdate = array(
            'statusdokumen' => $statusdokumen,
            'catatanreview' => $catatan,
            'tglreview' => date('Y-m-d H:i:s'),
            'idadminreview' => $this->session->userdata('idjemaat'),
        );

        $simpan = $this->Dokumen_model->updateStatus($idjemaat, $kodedokumen, $dataUpdate);

        if ($simpan) {
            $labelStatus = ($statusdokumen == 'Disetujui') ? 'disetujui' : 'ditolak, jemaat akan diminta upload ulang';
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Dokumen ' . $labelStatus . '.
                        </div>
                    </div>';
        } else {
            $eror = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('dokumen');
    }
}

/* End of file Dokumen.php */
/* Location: ./application/controllers/Dokumen.php */
