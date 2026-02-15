<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function islogin()
    {
        $idjemaat = $this->session->userdata('idjemaat');
        if (empty($idjemaat)) {
            $pesan = '<div class="alert alert-danger">Sesi telah berakhir. Silahkan login kembali!</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('login');
            exit();
        }
    }

    public function hakAksesDM()
    {
        $idjemaat = $this->session->userdata('idjemaat');
        $iddc = $this->session->userdata('iddc');
        $statuskeanggotaan = $this->session->userdata('statuskeanggotaan');

        if (empty($idjemaat) || empty($iddc)) {
            $pesan = '<div class="alert alert-danger">Sesi telah berakhir. Silahkan login kembali!</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('login');
            exit();
        }

        if ($statuskeanggotaan != 'Disciples maker') {
            $pesan = '<div class="alert alert-danger">Halaman ini hanya untuk Disciples Maker!</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('/');
            exit();
        }
    }


    
}
