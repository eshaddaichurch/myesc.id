<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		$this->Home_model->loadsessiongereja();
	}


	public function is_login()
    {
        $idjemaat = $this->session->userdata('idjemaat');
        if (empty($idjemaat)) {
            $pesan = '<div class="alert alert-danger">Sesi telah berakhir. Silahkan login kembali!</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('login'); 
            exit();
        }
    }   

	public function index()
	{
		
		$data["rowinfogereja"] = $this->Home_model->get_infogereja();	
		$data["menu"] = "";	
		$this->load->view("home", $data);
	}

	public function getNotifikasi()
	{
		$idjemaat = $this->session->userdata('idjemaat');
		if (!empty($idjemaat)) {			
			$jumlahNotif = $this->Home_model->getNotifikasi($idjemaat);
			echo json_encode($jumlahNotif);
		}else{
			echo json_encode("0");
		}
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */