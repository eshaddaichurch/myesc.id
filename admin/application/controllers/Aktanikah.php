<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktanikah extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Aktanikah_model');
        $this->load->model('Jemaat_model');
        $this->session->set_userdata('IDMENUSELECTED', 'T300');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'aktanikah';
        $this->load->view('aktanikah/listdata', $data);
    }

    public function tambah()
    {
        $data['idakta'] = '';
        $data['menu'] = 'aktanikah';
        $this->load->view('aktanikah/form', $data);
    }

    public function edit($idakta)
    {
        $idakta = $this->encrypt->decode($idakta);

        if ($this->Aktanikah_model->get_by_id($idakta)->num_rows() < 1) {
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
        $data['idakta'] = $idakta;
        $data['menu'] = 'aktanikah';
        $this->load->view('aktanikah/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Aktanikah_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->noakta;
                $row[] = tglindonesialengkap($rowdata->tglakta);
                $row[] = $rowdata->namajemaatpria;
                $row[] = $rowdata->namajemaatwanita;
                $row[] = $rowdata->dilakukanoleh;
                $row[] = $rowdata->namadaerahakta;
                $row[] = '
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . site_url('aktanikah/cetak/' . $this->encrypt->encode($rowdata->idakta)) . '" target="_blank">Cetak Akta</a>
                            <a class="dropdown-item" href="' . site_url('aktanikah/delete/' . $this->encrypt->encode($rowdata->idakta)) . '" id="hapus">Hapus</a>
                            </div>
                            <a href="' . site_url('aktanikah/edit/' . $this->encrypt->encode($rowdata->idakta)) . '" class="btn btn-warning">Edit</a>
                        </div>
                    ';
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Aktanikah_model->count_all(),
            "recordsFiltered" => $this->Aktanikah_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function delete($idakta)
    {
        $idakta = $this->encrypt->decode($idakta);
        $rsdata = $this->Aktanikah_model->get_by_id($idakta);
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

        $hapus = $this->Aktanikah_model->hapus($idakta);
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
        redirect('aktanikah');
    }

    public function simpan()
    {
        $idakta             = $this->input->post('idakta');
        $tglakta        = $this->input->post('tglakta');
        $jenisakta        = $this->input->post('jenisakta');
        $dilakukanoleh        = $this->input->post('dilakukanoleh');
        $namaayahpria        = $this->input->post('namaayahpria');
        $namaibupria        = $this->input->post('namaibupria');
        $idjemaatpria        = $this->input->post('idjemaatpria');
        $namaayahwanita        = $this->input->post('namaayahwanita');
        $namaibuwanita        = $this->input->post('namaibuwanita');
        $idjemaatwanita        = $this->input->post('idjemaatwanita');
        $iddaerahakta        = $this->input->post('iddaerahakta');
        $idcabangakta        = $this->input->post('idcabangakta');

        $statusaktif        = $this->input->post('statusaktif');

        if ($idakta == '') {

            $idakta = $this->db->query("select create_idaktanikah('" . date('Y-m-d') . "') as idakta")->row()->idakta;
            $noakta = $this->db->query("select create_nomoraktanikah('" . date('m') . "', '" . date('y') . "') as noakta")->row()->noakta;

            $data = array(
                'idakta'   => $idakta,
                'noakta'   => $noakta,
                'tglakta'   => $tglakta,
                'jenisakta'   => $jenisakta,
                'dilakukanoleh'   => $dilakukanoleh,
                'idjemaatpria'   => $idjemaatpria,
                'namaayahpria'   => $namaayahpria,
                'namaibupria'   => $namaibupria,
                'idjemaatwanita'   => $idjemaatwanita,
                'namaayahwanita'   => $namaayahwanita,
                'namaibuwanita'   => $namaibuwanita,
                'iddaerahakta'   => $iddaerahakta,
                'idcabangakta'   => $idcabangakta,
            );
            // var_dump($data);
            // exit();
            $simpan = $this->Aktanikah_model->simpan($data);
        } else {

            $data = array(
                'idakta'   => $idakta,
                'tglakta'   => $tglakta,
                'jenisakta'   => $jenisakta,
                'dilakukanoleh'   => $dilakukanoleh,
                'idjemaatpria'   => $idjemaatpria,
                'namaayahpria'   => $namaayahpria,
                'namaibupria'   => $namaibupria,
                'idjemaatwanita'   => $idjemaatwanita,
                'namaayahwanita'   => $namaayahwanita,
                'namaibuwanita'   => $namaibuwanita,
                'iddaerahakta'   => $iddaerahakta,
                'idcabangakta'   => $idcabangakta,
            );
            $simpan = $this->Aktanikah_model->update($data, $idakta);
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
        redirect('aktanikah');
    }

    public function get_edit_data()
    {
        $idakta = $this->input->post('idakta');
        $RsData = $this->Aktanikah_model->get_by_id($idakta)->row();



        $data = array(
            'idakta'     =>  $RsData->idakta,
            'noakta'     =>  $RsData->noakta,
            'tglakta'     =>  $RsData->tglakta,
            'jenisakta'     =>  $RsData->jenisakta,
            'tglcetak'     =>  $RsData->tglcetak,
            'dilakukanoleh'     =>  $RsData->dilakukanoleh,
            'idjemaatpria'     =>  $RsData->idjemaatpria,
            'namaayahpria'     =>  $RsData->namaayahpria,
            'namaibupria'     =>  $RsData->namaibupria,
            'idjemaatwanita'     =>  $RsData->idjemaatwanita,
            'namaayahwanita'     =>  $RsData->namaayahwanita,
            'namaibuwanita'     =>  $RsData->namaibuwanita,
            'iddaerahakta'     =>  $RsData->iddaerahakta,
            'idcabangakta'     =>  $RsData->idcabangakta,
        );

        echo (json_encode($data));
    }

    public function simpandaerah()
    {
        $namadaerah = $this->input->post('namadaerah');
        $iddaerahakta = $this->db->query("SELECT create_iddaerahakta('" . $namadaerah . "') as iddaerahakta")->row()->iddaerahakta;
        $dataDaerah = array(
            'iddaerahakta' => $iddaerahakta,
            'namadaerahakta' => $namadaerah,
            'statusaktif' => 'Aktif',
        );
        $simpan = $this->Aktanikah_model->simpandaerah($dataDaerah);
        if ($simpan) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => "Data gagal disimpan."));
        }
    }

    public function simpancabang()
    {
        $namacabang = $this->input->post('namacabang');
        $formatnomorakta = $this->input->post('formatnomorakta');

        $idcabangakta = $this->db->query("SELECT create_idcabangakta('" . $namacabang . "') as idcabangakta")->row()->idcabangakta;

        $dataCabang = array(
            'idcabangakta' => $idcabangakta,
            'namacabangakta' => $namacabang,
            'formatnomorakta' => $formatnomorakta,
            'statusaktif' => 'Aktif',
        );
        $simpan = $this->Aktanikah_model->simpancabang($dataCabang);
        if ($simpan) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => "Data gagal disimpan."));
        }
    }

    public function cetak($idakta)
    {
        // error_reporting(0);
        $idakta = $this->encrypt->decode($idakta);
        $this->load->library('Pdf');

        $rsakta         = $this->db->query("
                                        select * from v_aktanikah where idakta='" . $idakta . "'
                                    ")->row();

        $data['rsakta'] = $rsakta;
        $data['idakta'] = $idakta;
        $this->load->view('aktanikah/cetak', $data);
    }
}

/* End of file Aktanikah.php */
/* Location: ./application/controllers/Aktanikah.php */