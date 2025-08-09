<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kematian extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Kematian_model');
        $this->load->model('Jemaat_model');
        $this->session->set_userdata('IDMENUSELECTED', 'C107');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'kematian';
        $this->load->view('kematian/listdata', $data);
    }


    public function tambah()
    {
        $data['idkematian'] = '';
        $data['menu'] = 'kematian';
        $this->load->view('kematian/form', $data);
    }

    public function edit($idkematian)
    {
        $idkematian = $this->encrypt->decode($idkematian);

        $data['idkematian'] = $idkematian;
        $data['menu'] = 'kematian';
        $this->load->view('kematian/form', $data);
    }

    public function proses($idkematian)
    {
        $idkematian = $this->encrypt->decode($idkematian);
        $rsKonseling = $this->Kematian_model->get_by_id($idkematian);

        if ($rsKonseling->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('kematian');
            exit();
        };
        $data['rowKonseling'] = $rsKonseling->row();
        $data['idkematian'] = $idkematian;
        $data['menu'] = 'kematian';
        $this->load->view('kematian/konfirmasi', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Kematian_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                switch ($rowdata->status) {
                    case 'Disetujui':
                        $status = '<span class="badge badge-success">' . $rowdata->status . '</span>';
                        break;
                    case 'Ditolak':
                        $status = '<span class="badge badge-danger">' . $rowdata->status . '</span>';
                        break;
                    default:
                        $status = '<span class="badge badge-warning">' . $rowdata->status . '</span>';
                        break;
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<strong>' . $rowdata->namapemohon . '</strong>' .
                    '<br>Jenis Kelamin: ' . $rowdata->jeniskelaminpemohon .
                    '<br>HP: ' . $rowdata->nohppemohon . '</strong>';
                $row[] = $rowdata->tglpermohonan;
                $row[] = 'Nama: ' . $rowdata->namayangmeninggal .
                    '<br>Umur: ' . $rowdata->umuryangmeninggal .
                    '<br>Hubungan: ' . $rowdata->hubungankeluarga;
                $row[] = $rowdata->namapenanggungjawab;
                $row[] = $status;
                $row[] = '
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . site_url('kematian/delete/' . $this->encrypt->encode($rowdata->idkematian)) . '" id="hapus">Hapus</a>
                            </div>
                            <a href="' . site_url('kematian/edit/' . $this->encrypt->encode($rowdata->idkematian)) . '" class="btn btn-warning">Edit</a>
                        </div>
                    ';

                // $row[] = '<a href="' . site_url('kematian/proses/' . $this->encrypt->encode($rowdata->idkematian)) . '" class="btn btn-sm btn-primary btn-circle"><i class="fas fa-check-double"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Kematian_model->count_all(),
            "recordsFiltered" => $this->Kematian_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $idkematian             = $this->input->post('idkematian');
        $tglpermohonan             = $this->input->post('tglpermohonan');
        $namapemohon             = $this->input->post('namapemohon');
        $jeniskelaminpemohon             = $this->input->post('jeniskelaminpemohon');
        $nohppemohon             = $this->input->post('nohppemohon');
        $namayangmeninggal             = $this->input->post('namayangmeninggal');
        $tglmeninggal             = $this->input->post('tglmeninggal');
        $jeniskelaminyangmeninggal             = $this->input->post('jeniskelaminyangmeninggal');
        $hubungankeluarga             = $this->input->post('hubungankeluarga');
        $umuryangmeninggal             = $this->input->post('umuryangmeninggal');
        
        $idpenanggungjawab             = $this->input->post('idpenanggungjawab');
        $keteranganadmin             = $this->input->post('keterangan');


        if (empty($idpenanggungjawab)) {
            $idpenanggungjawab = null;
        }
        
        if (empty($idkematian)) {
                        
            $data = array(
                'tglpermohonan'   => $tglpermohonan,
                'namapemohon'   => $namapemohon,
                'jeniskelaminpemohon'   => $jeniskelaminpemohon,
                'nohppemohon'   => $nohppemohon,
                'namayangmeninggal'   => $namayangmeninggal,
                'tglmeninggal'   => $tglmeninggal,
                'jeniskelaminyangmeninggal'   => $jeniskelaminyangmeninggal,
                'hubungankeluarga'   => $hubungankeluarga,
                'idpenanggungjawab'   => $idpenanggungjawab,
                'keteranganadmin'   => $keteranganadmin,
                'umuryangmeninggal'   => $umuryangmeninggal,
                'status'   => 'Disetujui',
                'tglstatus'   => date('Y-m-d H:i:s'),
                'idadmin'   => $this->session->userdata('idjemaat'),
            );
            $simpan = $this->Kematian_model->simpan($data);

        }else{

            $data = array(
                'tglpermohonan'   => $tglpermohonan,
                'namapemohon'   => $namapemohon,
                'jeniskelaminpemohon'   => $jeniskelaminpemohon,
                'nohppemohon'   => $nohppemohon,
                'namayangmeninggal'   => $namayangmeninggal,
                'tglmeninggal'   => $tglmeninggal,
                'jeniskelaminyangmeninggal'   => $jeniskelaminyangmeninggal,
                'hubungankeluarga'   => $hubungankeluarga,
                'idpenanggungjawab'   => $idpenanggungjawab,
                'keteranganadmin'   => $keteranganadmin,
                'umuryangmeninggal'   => $umuryangmeninggal,
                'idadmin'   => $this->session->userdata('idjemaat'),
            );
            $simpan = $this->Kematian_model->update($data, $idkematian);
            
        }


        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
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
        redirect('kematian');
    }


    public function delete($idkematian)
    {
        $idkematian = $this->encrypt->decode($idkematian);
        $rsdata = $this->Kematian_model->get_by_id($idkematian);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('aktanikah');
            exit();
        };

        $hapus = $this->Kematian_model->hapus($idkematian);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $eror = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('kematian');
    }

    public function get_edit_data()
    {
        $idkematian = $this->input->post('idkematian');
        $RsData = $this->Kematian_model->get_by_id($idkematian)->row();

        echo (json_encode($RsData));
    }
}
