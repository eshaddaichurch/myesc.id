<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasiwa extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'M800');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'konfigurasiwa';
        $this->load->view('konfigurasiwa/form', $data);
    }

    public function simpanWaCare()
    {
        $textwacare = $this->input->post('textwacare');

        $phone = '6281254691909'; // Nomor tujuan
        $pesan = 'Halo, ini pesan uji coba dari CodeIgniter!';

        $response = $this->whatsapp->send_message($phone, $pesan);

        if ($response === false) {
            echo "Gagal mengirim pesan.";
        } else {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
    }
}