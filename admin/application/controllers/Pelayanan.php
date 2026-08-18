<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Pelayanan_model');
        $this->session->set_userdata( 'IDMENUSELECTED', 'M910' );
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'pelayanan';
        $this->load->view('pelayanan/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idpelayanan'] = '';        
        $data['menu'] = 'pelayanan';  
        $this->load->view('pelayanan/form', $data);
    }

    public function edit($idpelayanan)
    {       
        $idpelayanan = $this->encrypt->decode($idpelayanan);

        if ($this->Pelayanan_model->get_by_id($idpelayanan)->num_rows()<1) {
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Ilegal!</strong> Data tidak ditemukan! </div></div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pelayanan');
            exit();
        };
        $data['idpelayanan'] = $idpelayanan;        
        $data['menu'] = 'pelayanan';
        $this->load->view('pelayanan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pelayanan_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idpelayanan;
                $row[] = $rowdata->namapelayanan;
                if (!empty($rowdata->namadepartement)) {
                    $row[] = $rowdata->namadepartement . '<br><small class="text-muted">' . $rowdata->namagroup . '</small>';
                } else {
                    $row[] = '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Belum diatur</span>';
                }
                if ($rowdata->statusaktif == 'Aktif') {
                    $row[] = '<span class="badge badge-success">Aktif</span>';
                }else{
                    $row[] = '<span class="badge badge-secondary">Tidak Aktif</span>';
                }
                $row[] = '<a href="'.site_url( 'pelayanan/edit/'.$this->encrypt->encode($rowdata->idpelayanan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('pelayanan/delete/'.$this->encrypt->encode($rowdata->idpelayanan) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Pelayanan_model->count_all(),
                        "recordsFiltered" => $this->Pelayanan_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idpelayanan)
    {
        $idpelayanan = $this->encrypt->decode($idpelayanan);  
        $rsdata = $this->Pelayanan_model->get_by_id($idpelayanan);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Ilegal!</strong> Data tidak ditemukan! </div></div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pelayanan');
            exit();
        };

        $cekdipakai = $this->Pelayanan_model->cek_dipakai($idpelayanan);
        if ($cekdipakai['dipakai']) {
            $rincian = array();
            if ($cekdipakai['jml_volunteer'] > 0) {
                $rincian[] = $cekdipakai['jml_volunteer'].' data volunteer';
            }
            if ($cekdipakai['jml_jadwal'] > 0) {
                $rincian[] = $cekdipakai['jml_jadwal'].' pengajuan jadwal event';
            }
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Gagal!</strong> Pelayanan ini masih dipakai oleh '.implode(' dan ', $rincian).'. Nonaktifkan saja jika tidak dipakai lagi.</div></div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pelayanan');
            exit();
        }

        $hapus = $this->Pelayanan_model->hapus($idpelayanan);
        if ($hapus) {       
            $pesan = '<div><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Berhasil!</strong> Data berhasil dihapus!</div></div>';
        }else{
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Gagal!</strong> Data gagal dihapus!</div></div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pelayanan');        
    }

    public function simpan()
    {       
        $idpelayanan    = $this->input->post('idpelayanan');
        $iddepartement  = $this->input->post('iddepartement');
        $namapelayanan  = $this->input->post('namapelayanan');
        $statusaktif    = $this->input->post('statusaktif');

        $cek = $this->Pelayanan_model->cek_nama_sudah_ada($namapelayanan, $idpelayanan);
        if ($cek->num_rows() > 0) {
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Gagal!</strong> Nama pelayanan ini sudah ada!</div></div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pelayanan');
            exit();
        }

        if ( $idpelayanan=='' ) {  
            $idpelayanan = $this->Pelayanan_model->generate_id();
            $data = array(
                            'idpelayanan'   => $idpelayanan, 
                            'iddepartement' => $iddepartement,
                            'namapelayanan' => $namapelayanan, 
                            'statusaktif'   => $statusaktif, 
                        );
            $simpan = $this->Pelayanan_model->simpan($data);      
        }else{ 
            $data = array(
                            'iddepartement' => $iddepartement,
                            'namapelayanan' => $namapelayanan, 
                            'statusaktif'   => $statusaktif, 
                        );
            $simpan = $this->Pelayanan_model->update($data, $idpelayanan);
        }

        if ($simpan) {
            $pesan = '<div><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Berhasil!</strong> Data berhasil disimpan!</div></div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><strong>Gagal!</strong> Data gagal disimpan! Pesan Error : '.$eror['code'].' '.$eror['message'].'</div></div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pelayanan');   
    }
    
    public function get_edit_data()
    {
        $idpelayanan = $this->input->post('idpelayanan');
        $RsData = $this->Pelayanan_model->get_by_id($idpelayanan)->row();

        $data = array( 
                            'idpelayanan'   =>  $RsData->idpelayanan,  
                            'iddepartement' =>  $RsData->iddepartement,  
                            'namapelayanan' =>  $RsData->namapelayanan,  
                            'statusaktif'   =>  $RsData->statusaktif,  
                        );

        echo(json_encode($data));
    }

    // -------------------------> Endpoint cascading dropdown, dipakai oleh form Volunteer
    public function get_by_departement()
    {
        $iddepartement = $this->input->get('iddepartement');
        $rs = $this->Pelayanan_model->get_by_departement($iddepartement);
        echo json_encode($rs->result());
    }

}

/* End of file Pelayanan.php */
/* Location: ./application/controllers/Pelayanan.php */