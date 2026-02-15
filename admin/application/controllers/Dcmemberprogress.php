<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dcmemberprogress extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Dcmemberprogress_model');
        $this->load->library('image_lib');
        $this->session->set_userdata('IDMENUSELECTED', 'M505');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/listdata_dcmember', $data);
    }

    public function tambah()
    {
        $data['iddcmember'] = '';
        $data['menu'] = 'ddcmember';
        $this->load->view('dcmemberprogress/form_dcm', $data);
    }

    public function edit($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);

        if ($this->Dcmemberprogress_model->get_by_id($iddcmember)->num_rows() < 1) {
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
        $data['iddcmember'] = $iddcmember;
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/form_dcm', $data);
    }


    public function riwayat($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);
        $rsRiwayat = $this->Dcmemberprogress_model->getRiwayat($iddcmember);
        if ($rsRiwayat->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upps!</strong> Belum Ada Riwayat! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('dcmemberprogress');
            exit();
        };
        $rowDCM = $this->Dcmemberprogress_model->get_by_id($iddcmember)->row();
        $data['iddcmember'] = $iddcmember;
        $data['rowDCM'] = $rowDCM;
        $data['rsRiwayat'] = $rsRiwayat;
        $data['menu'] = 'dcmemberprogress';
        $this->load->view('dcmemberprogress/riwayat', $data);
    }

    public function datatablesource()
{
    $RsData = $this->Dcmemberprogress_model->get_datatables();
    $no = $_POST['start'];
    $data = array();

    if ($RsData->num_rows() > 0) {
        foreach ($RsData->result() as $rowdata) {

            if (!empty($rowdata->foto)) {
                $foto = base_url('uploads/jemaat/' . $rowdata->foto);
            } else {
                $foto = base_url('images/user-01.png');
            }
            
            $rating = $rowdata->nilairatarata;
            
            // Buat fungsi untuk generate bintang
            $bintang = $this->generate_rating_stars($rating);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img src="' . $foto . '" width="50px" height="50px" class="img-circle">';
            $row[] = $rowdata->namalengkap;
            $row[] = $rowdata->namadc . '<br><small>DM: ' . $rowdata->namadm . '</small>';
            $row[] = $bintang; // Menampilkan bintang rating
            $row[] = '<a href="' . site_url('dcmemberprogress/riwayat/' . $this->encrypt->encode($rowdata->iddcmember)) . '" class="btn btn-sm btn-info btn-circle"><i class="fa fa-history"></i> Riwayat</a>';
            $data[] = $row;
        }
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->Dcmemberprogress_model->count_all(),
        "recordsFiltered" => $this->Dcmemberprogress_model->count_filtered(),
        "data" => $data,
    );
    echo json_encode($output);
}

/**
 * Fungsi untuk generate bintang rating dengan FontAwesome
 * @param float $rating Nilai rating (0-4)
 * @return string HTML bintang
 */
private function generate_rating_stars($rating)
{
    $rating = floatval($rating);
    
    if ($rating == 0) {
        return '<span class="text-muted"><i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <small class="ml-1">Belum ada rating</small></span>';
    }
    
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5 ? 1 : 0;
    $empty_stars = 4 - $full_stars - $half_star;
    
    $html = '<span class="rating-stars" style="white-space: nowrap;">';
    
    // Bintang penuh
    for ($i = 1; $i <= $full_stars; $i++) {
        $html .= '<i class="fa fa-star text-warning"></i>';
    }
    
    // Bintang setengah
    if ($half_star) {
        $html .= '<i class="fa fa-star-half-o text-warning"></i>';
    }
    
    // Bintang kosong
    for ($i = 1; $i <= $empty_stars; $i++) {
        $html .= '<i class="fa fa-star-o text-warning"></i>';
    }
    
    // Tambah nilai numerik
    $html .= ' <small class="ml-1 text-muted">(' . number_format($rating, 1) . ')</small>';
    
    $html .= '</span>';
    
    return $html;
}

    public function delete($iddcmember)
    {
        $iddcmember = $this->encrypt->decode($iddcmember);
        $rsdata = $this->Dcmemberprogress_model->get_by_id($iddcmember);
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

        $hapus = $this->Dcmemberprogress_model->hapus($iddcmember);
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
        $iddc             = $this->input->post('iddc');
        $idjemaat             = $this->input->post('idjemaat');
        $statuskeanggotaan             = $this->input->post('statuskeanggotaan');
        $keterangan             = $this->input->post('keterangan');
        $tanggalinsert             = date('Y-m-d H:i:s');
        $tanggalupdate             = date('Y-m-d H:i:s');
        $statusaktif         = $this->input->post('statusaktif');


        if ($iddcmember == '') {

            $iddcmember = $this->db->query("select create_iddcmember('" . $iddc . "') as iddcmember")->row()->iddcmember;

            $data = array(
                'iddcmember'   => $iddcmember,
                'iddc'   => $iddc,
                'idjemaat'   => $idjemaat,
                'statuskeanggotaan'   => $statuskeanggotaan,
                'keterangan'   => $keterangan,
                'tanggalinsert'   => $tanggalinsert,
                'tanggalupdate'   => $tanggalupdate,
                'statusaktif'   => $statusaktif,
            );

            $simpan = $this->Dcmemberprogress_model->simpan($data);
        } else {

            $data = array(
                'iddcmember'   => $iddcmember,
                'iddc'   => $iddc,
                'idjemaat'   => $idjemaat,
                'statuskeanggotaan'   => $statuskeanggotaan,
                'keterangan'   => $keterangan,
                'tanggalinsert'   => $tanggalinsert,
                'tanggalupdate'   => $tanggalupdate,
                'statusaktif'   => $statusaktif,
            );
            $simpan = $this->Dcmemberprogress_model->update($data, $iddcmember);
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
        redirect('dcmemberprogress');
    }


    public function get_edit_data()
    {

        $iddcmember = $this->input->post('iddcmember');
        $RsData = $this->Dcmemberprogress_model->get_by_id($iddcmember)->row();

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

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = 'uploads/dc/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']             = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = "";
            }
        } else {
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = 'uploads/dc/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']            = '2000KB';


            $this->load->library('upload', $config);
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = $file_lama;
            }
        } else {
            $foto = $file_lama;
        }

        return $foto;
    }
}
