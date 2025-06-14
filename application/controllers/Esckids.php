<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Esckids extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->wajibLogin();
        $this->load->model('Home_model');
        // $this->load->model('Permohonandoa_model');
    }

    public function index($idmenu = "")
    {
        // $rsPermohonanDoa = $this->Permohonandoa_model->getAll();
        $idmenu = $this->encrypt->decode($idmenu);
        // $data['rsPermohonanDoa'] = $rsPermohonanDoa;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('community/kids/elshaddaikids', $data);
    }


}

/* End of file Permohonandoa.php */
/* Location: ./application/controllers/Permohonandoa.php */