<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsappblast extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Whatsappblast_model');
        $this->session->set_userdata('IDMENUSELECTED', 'WA02');
        $this->cekOtorisasi();
    }

    public function index()
    {
        // $rsDC = $this->App->getDisciplesCommunity();
        // var_dump($rsDC->result());
        // exit();

        $data['rsDc'] = $this->App->getDisciplesCommunity();
        $data['menu'] = 'whatsappblast';
        $this->load->view('whatsappblast/index', $data);
    }

    public function getJumlahJemaat()
    {
        $statuspernikahan = $this->input->get('statuspernikahan');
        $statusjemaat = $this->input->get('statusjemaat');
        $jeniskelamin = $this->input->get('jeniskelamin');
        $dcoption = $this->input->get('dcoption');
        $iddc = $this->input->get('iddc');
        $usiaoption = $this->input->get('usiaoption');
        $usiaawal = $this->input->get('usiaawal');
        $usiasampai = $this->input->get('usiasampai');

        $jumlahJemaat = $this->Whatsappblast_model->getJumlahJemaat($statuspernikahan, $statusjemaat, $jeniskelamin, $dcoption, $iddc, $usiaoption, $usiaawal, $usiasampai);
        
        echo json_encode($jumlahJemaat);        
    }

}