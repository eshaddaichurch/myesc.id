<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Give extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
	}

	// halaman utama GIVE
	public function index()
	{
		$data['title'] = 'GIVE';
		$data["rowinfogereja"] = $this->Home_model->get_infogereja();
		$this->load->view('give/giving', $data);
	}

	// halaman detail dinamis
	public function page($slug = null)
	{
		if (!$slug) {
			show_404();
		}

		$data['title'] = strtoupper($slug);
		$data["rowinfogereja"] = $this->Home_model->get_infogereja();

		$view_path = 'give/' . $slug;

		if (file_exists(APPPATH . 'views/' . $view_path . '.php')) {
			$this->load->view($view_path, $data);
		} else {
			show_404();
		}
	}
}