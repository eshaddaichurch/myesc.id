<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Give extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		// $this->load->model('Ourlocation_model');
	}

	public function index($idmenu = null)
{
	$data['title']= 'GIVE';
	if ($idmenu !== null) {
		$idmenu = $this->encrypt->decode($idmenu);
		$data['menu'] = $idmenu;
	} else {
		$data['menu'] = '';
	}
	$data["rowinfogereja"] = $this->Home_model->get_infogereja();	
	$this->load->view('give/persembahan',$data);
}
	

}

/* End of file Ourlocation.php */
/* Location: ./application/controllers/Ourlocation.php */