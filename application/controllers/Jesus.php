<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jesus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		// $this->load->model('Ourlocation_model');
	}

	public function index($idmenu = null)
{
	$data['title']= 'JESUS';
	if ($idmenu !== null) {
		$idmenu = $this->encrypt->decode($idmenu);
		$data['menu'] = $idmenu;
	} else {
		$data['menu'] = 'Jesus';
	}
	$data["rowinfogereja"] = $this->Home_model->get_infogereja();	
	$this->load->view('jesus/aboutjesus',$data);
}
	

}

/* End of file Ourlocation.php */
/* Location: ./application/controllers/Ourlocation.php */