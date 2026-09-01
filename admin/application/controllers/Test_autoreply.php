<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_autoreply extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('whatsapp');
        $this->load->library('Whatsapp_sender_resmi');
    }

    public function index() {
        $nomor_tujuan = '628992885301'; // GANTI dengan nomor HP Anda, format 62xxx tanpa +
        $keyword = $this->input->get('keyword') ?? 'default';

        $result = $this->whatsapp_sender_resmi->send_auto_reply($nomor_tujuan, $keyword);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}