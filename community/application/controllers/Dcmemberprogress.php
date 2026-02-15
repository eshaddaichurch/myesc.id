<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dcmemberprogress extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->hakAksesDM();
        $this->load->model('DcmemberprogressModel');
        $this->load->library('image_lib');
    }

    public function index()
    {
        $data['rsDcmember'] = $this->DcmemberprogressModel->get_member_only();
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/index', $data);
    }


    public function form($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);
        $rowDCM = $this->DcmemberprogressModel->get_by_id($iddcmember);
        if ($rowDCM->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dcmemberprogress');
            exit();
        };
        $rowDCM = $rowDCM->row();
        $data['iddcmember'] = $iddcmember;
        $data['rowDCM'] = $rowDCM;
        $data['rsPertanyaan'] = $this->DcmemberprogressModel->get_pertanyaan();
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/form', $data);
    }


    public function riwayat($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);
        $rsRiwayat = $this->DcmemberprogressModel->getRiwayat($iddcmember);
        if ($rsRiwayat->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dcmemberprogress');
            exit();
        };
        $rowDCM = $this->DcmemberprogressModel->get_by_id($iddcmember)->row();
        $data['iddcmember'] = $iddcmember;
        $data['rowDCM'] = $rowDCM;
        $data['rsRiwayat'] = $rsRiwayat;
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/riwayat', $data);
    }

    public function delete($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);
        $rsdata = $this->DcmemberprogressModel->get_by_id($iddcmember);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                                                <div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                                    <strong>Ilegal!</strong> Data tidak ditemukan! 
                                                </div>
                                            </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dcmemberprogress ');
            exit();
        };

        $hapus = $this->DcmemberprogressModel->hapus($iddcmember);
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
        redirect('dcmemberprogress');
    }




    public function simpan()
    {
        $iddcmember             = $this->input->post('iddcmember');        
        $iddc                   = $this->session->userdata('iddc');
        $tanggalinsert          = date('Y-m-d H:i:s');
        $tanggalupdate          = date('Y-m-d H:i:s');

        $progress = array(
            'iddcmember' => $iddcmember,
            'tglprogress' => $tanggalinsert,
            'iddc' => $iddc,
            'idjemaatdm' => $this->session->userdata('idjemaat'),
            'tglinsert' => $tanggalinsert,
            
        );

        $simpan = $this->DcmemberprogressModel->simpan($progress);

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
        redirect('dcmemberprogress');
    }


    public function get_edit_data()
    {

        $iddcmember = $this->input->post('iddcmember');
        $RsData = $this->DcmemberprogressModel->get_by_id($iddcmember)->row();

        $data = array(
            'iddcmember'   => $RsData->iddcmember,
            'iddc'   => $RsData->iddc,
            'idjemaat'   => $RsData->idjemaat,
            'statuskeanggotaan'   => $RsData->statuskeanggotaan,
            'keterangan'   => $RsData->keterangan,
            'statusaktif'   => $RsData->statusaktif,
        );
        echo json_encode($data);
    }
}
