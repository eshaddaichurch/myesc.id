<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function isLogin()
    {
        if (empty($this->session->userdata('idjemaat'))) {
            redirect(site_url());
        }
    }

    public function wajibLogin()
    {
        if (empty($this->session->userdata('idjemaat'))) {
            $pesan = "<script>
                            swal('Belum Login', 'Silahkan login terlebih dahulu untuk melanjutkan!', 'warning')
                            .then(function(){
                                $('#loginModal').modal('show');
                            });
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('home');
        }
        return true;
    }

    public function cekStatusWhatsApp()
    {
        $rowJemaat = $this->App->getInfoJemaat($this->session->userdata('idjemaat'));
        if ($rowJemaat->statusverifikasiwa != '1') {
            $pesan = "<script>
                            swal('Nomor WhatsApp Belum Terverifikasi', 'Silahkan verifikasi nomor whatsapp terlebih dahulu!', 'warning')
                            .then(function(){
                                $('#nohpprofil').focus();
                            });
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/ubahprofil');
        }
        return true;
    }


    public function ajaxCeStatusWhatsAPP()
    {
        $rowJemaat = $this->App->getInfoJemaat($this->session->userdata('idjemaat'));
        if ($rowJemaat->statusverifikasiwa != '1') {
            echo json_encode(array('statusverifikasiwa' => false));
        }else{
            echo json_encode(array('statusverifikasiwa' => true));
        }
    }
}

/* End of file MY_controller.php */
/* Location: ./application/core/MY_controller.php */