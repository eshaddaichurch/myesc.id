<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D004');
        $this->load->model('Notifikasi_model');
    }

    public function index()
    {
        $data["menu"] = "notifikasi";
        $this->load->view("notifikasi/listdata", $data);
    }


    public function datatablesource()
    {
        $RsData = $this->Notifikasi_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $link = site_url().$rowdata->linknotifikasi;
                if ($rowdata->statusnotifikasi == '0') {
                    $status = '<span class="badge badge-danger pull-right">New</span>';
                }else{
                    $status = '';
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<a href="'.$link.'">'.$rowdata->deskripsi.'</a>'.$status;
                $row[] = since($rowdata->tglnotifikasi);
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Notifikasi_model->count_all(),
                        "recordsFiltered" => $this->Notifikasi_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

}