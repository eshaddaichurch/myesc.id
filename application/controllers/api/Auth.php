<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Auth extends BaseApi
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function login()
    {
        $email = trim($this->input->post('email'));  // isi bisa email ATAU nomor WA
        $password = trim($this->input->post('password'));

        if (empty($email) || empty($password)) {
            $this->jsonError('Email atau password tidak boleh kosong');
            return;
        }

        $kirim = $this->Login_model->cekLoginAjax($email, md5($password));

        if ($kirim->num_rows() > 0) {
            $result = $kirim->row();

            // cek status verifikasi, persis seperti alur cekLoginAjax() di web
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($result->statusverifikasiemail == 0) {
                    $this->jsonError('Email anda belum di verifikasi.');
                    return;
                }
            } else {
                if ($result->statusverifikasiwa == 0) {
                    $this->jsonError('Nomor whatsapp anda belum di verifikasi.');
                    return;
                }
            }

            $token = bin2hex(random_bytes(32));
            $this->db->insert('apptoken', array(
                'idjemaat' => $result->idjemaat,
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s'),
                'expired_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            ));

            $foto = empty($result->foto)
                ? base_url('images/user-01.png')
                : base_url('uploads/jemaat/' . $result->foto);

            $this->jsonSuccess(array(
                'token' => $token,
                'user' => array(
                    'idjemaat' => $result->idjemaat,
                    'namalengkap' => $result->namalengkap,
                    'foto' => $foto,
                    'email' => $result->email,
                    'nohp' => $result->nohp,
                ),
            ));
        } else {
            $this->jsonError('Password atau Email anda salah. harap periksa lagi');
        }
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/api/Auth.php */
