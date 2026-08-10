<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppVersion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function index()
    {
        echo json_encode([
            'status' => true,
            'data' => [
                'versi_minimum' => '1.0.17',
                'versi_terbaru' => '1.0.17',
                'pesan' => 'Shalom DM. versi baru mydc+ tersedia, silakan update aplikasi untuk mendapatkan fitur terbaru.',
                'url_playstore' => 'https://play.google.com/store/apps/details?id=com.escIntech.mydcplus',
            ]
        ]);
    }
}
