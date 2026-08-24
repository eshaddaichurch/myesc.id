<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Settings');
        $this->session->set_userdata( 'IDMENUSELECTED', 'M800' );
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'pengaturan';
        $this->load->view('pengaturan/listdata', $data);
    }   

    public function tambah()
    {       
        $data['ltambah'] = '1';
        $data['prefix'] = '';        
        $data['menu'] = 'pengaturan';  
        $this->load->view('pengaturan/form', $data);
    }

    public function edit($prefix)
    {       
        $prefix = $this->encrypt->decode($prefix);

        if ($this->Settings->get_by_id($prefix)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengaturan');
            exit();
        };
        $data['ltambah'] = '0';
        $data['prefix'] =$prefix;        
        $data['menu'] = 'pengaturan';
        $this->load->view('pengaturan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Settings->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->prefix;
                $row[] = $rowdata->deskripsi;
                $row[] = $rowdata->values;
                $row[] = '<a href="'.site_url( 'pengaturan/edit/'.$this->encrypt->encode($rowdata->prefix) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Settings->count_all(),
                        "recordsFiltered" => $this->Settings->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($prefix)
    {
        $prefix = $this->encrypt->decode($prefix);  
        $rsdata = $this->Settings->get_by_id($prefix);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengaturan');
            exit();
        };

        $hapus = $this->Settings->hapus($prefix);
        if ($hapus) {       
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pengaturan');        

    }

    public function simpan()
    {       
        $ltambah             = $this->input->post('ltambah');
        $prefix             = $this->input->post('prefix');
        $values        = $this->input->post('values');
        $deskripsi        = $this->input->post('deskripsi');
        $tanggalinsert        = date('Y-m-d H:i:s');
        $tanggalupdate        = date('Y-m-d H:i:s');


        if ( $ltambah=='1' ) {  
            $data = array(
                            'prefix'   => $prefix, 
                            'deskripsi'   => $deskripsi, 
                            'values'   => $values, 
                            'tglinsert'   => $tanggalinsert, 
                            'tglupdate'   => $tanggalupdate,
                            'issystem'   => 0,
                        );
            $simpan = $this->Settings->simpan($data);      
        }else{ 

            $data = array(
                            'prefix'   => $prefix, 
                            'deskripsi'   => $deskripsi, 
                            'values'   => $values,  
                            'tglupdate'   => $tanggalupdate,
                        );
            $simpan = $this->Settings->simpan($data, $prefix);
        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : '.$eror['code'].' '.$eror['message'].'
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pengaturan');   
    }
    
    public function get_edit_data()
    {
        $prefix = $this->input->post('prefix');
        $RsData = $this->Settings->get_by_id($prefix)->row();

        $data = array( 
                            'prefix'     =>  $RsData->prefix,  
                            'deskripsi'     =>  $RsData->deskripsi,  
                            'values'     =>  $RsData->values,  
                        );

        echo(json_encode($data));
    }

}

/* End of file Group.php */
/* Location: ./application/controllers/Group.php */