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
        $email    = trim($this->input->post('email'));  // email ATAU no. WA
        $password = trim($this->input->post('password'));

        if (empty($email) || empty($password)) {
            $this->jsonError('Email atau password tidak boleh kosong');
            return;
        }

        $kirim = $this->Login_model->cekLoginAjax($email, md5($password));

        if ($kirim->num_rows() == 0) {
            $this->jsonError('Password atau Email anda salah. harap periksa lagi');
            return;
        }

        $result = $kirim->row();

        // cek status verifikasi, sama seperti cekLoginAjax() di web
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
            'idjemaat'   => $result->idjemaat,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
        ));

        // ================================================
        // FOTO — samakan path dengan halaman web (Akun::profil)
        // ================================================
        $foto = !empty($result->foto)
            ? base_url('myesc.id/admin/uploads/jemaat/' . $result->foto)
            : null;

        // ================================================
        // QR CONTENT — logika sama dengan Home API & web
        // - Jemaat (+ noaj)  -> "idjemaat-noaj"
        // - Umum/Simpatisan  -> "idjemaat"
        // ================================================
        $qrContent = $result->idjemaat;
        if ($result->statusjemaat == 'Jemaat' && !empty($result->noaj)) {
            $qrContent = $result->idjemaat . '-' . $result->noaj;
        }

        $this->jsonSuccess(array(
            'token' => $token,
            'user' => array(
                'idjemaat'      => $result->idjemaat,
                'namalengkap'   => $result->namalengkap,
                'namapanggilan' => isset($result->namapanggilan) ? $result->namapanggilan : null,
                'foto'          => $foto,
                'email'         => $result->email,
                'nohp'          => $result->nohp,

                // === field tambahan untuk kartu profil beranda ===
                'noaj'          => !empty($result->noaj) ? $result->noaj : null,
                'statusjemaat'  => $result->statusjemaat,
                'qrcontent'     => $qrContent,
            ),
        ));
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/api/Auth.php */