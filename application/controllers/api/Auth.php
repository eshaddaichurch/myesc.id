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
        $email    = trim((string) $this->input->post('email'));  // email ATAU no. WA
        $password = trim((string) $this->input->post('password'));

        if ($email === '' || $password === '') {
            $this->jsonError('Email atau password tidak boleh kosong');
            return;
        }

        $kirim = $this->Login_model->cekLoginAjax($email, md5($password));

        // Pesan password/akun salah sengaja dibuat umum, supaya tidak bisa dipakai menebak akun terdaftar
        if ($kirim->num_rows() == 0) {
            $this->jsonError('Password atau Email anda salah. harap periksa lagi');
            return;
        }

        $result = $kirim->row();

        $adalahEmail = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
        $verifEmail  = (string) $result->statusverifikasiemail === '1';
        $verifWa     = (string) $result->statusverifikasiwa === '1';

        // Aturan sama dengan website:
        // - Hanya email terverifikasi    -> wajib login dengan email
        // - Hanya WA terverifikasi       -> wajib login dengan no. WA
        // - Keduanya terverifikasi       -> bebas (email atau WA)
        // - Tidak ada yang terverifikasi -> ditolak
        if (!$verifEmail && !$verifWa) {
            $this->jsonError('Akun anda belum terverifikasi. Silakan selesaikan verifikasi email atau nomor WhatsApp terlebih dahulu.');
            return;
        }

        if ($adalahEmail && !$verifEmail) {
            $this->jsonError(
                'Email ini belum terverifikasi. Akun Anda terverifikasi melalui nomor WhatsApp ' .
                $this->_samarkanNohp($result->nohp) . ', silakan masuk menggunakan nomor tersebut.'
            );
            return;
        }

        if (!$adalahEmail && !$verifWa) {
            $this->jsonError(
                'Nomor WhatsApp ini belum terverifikasi. Akun Anda terverifikasi melalui email ' .
                $this->_samarkanEmail($result->email) . ', silakan masuk menggunakan email tersebut.'
            );
            return;
        }

        $token = bin2hex(random_bytes(32));
        $this->db->insert('apptoken', array(
            'idjemaat'   => $result->idjemaat,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
        ));

        // FOTO — samakan path dengan halaman web (Akun::profil)
        $foto = !empty($result->foto)
            ? base_url('myesc.id/admin/uploads/jemaat/' . $result->foto)
            : null;

        // QR CONTENT — logika sama dengan Home API & web
        // - Jemaat (+ noaj)  -> "idjemaat-noaj"
        // - Umum/Simpatisan  -> "idjemaat"
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

                // field tambahan untuk kartu profil beranda
                'noaj'          => !empty($result->noaj) ? $result->noaj : null,
                'statusjemaat'  => $result->statusjemaat,
                'qrcontent'     => $qrContent,
            ),
        ));
    }

    // Contoh: 081234567890 -> 0812******90
    private function _samarkanNohp($nohp)
    {
        $nohp = (string) $nohp;
        $panjang = strlen($nohp);
        if ($panjang <= 6) {
            return $nohp;
        }
        return substr($nohp, 0, 4) . str_repeat('*', $panjang - 6) . substr($nohp, -2);
    }

    // Contoh: jemaat@gmail.com -> je***@gmail.com
    private function _samarkanEmail($email)
    {
        $email = (string) $email;
        $at = strpos($email, '@');
        if ($at === false || $at < 2) {
            return '***';
        }
        return substr($email, 0, 2) . str_repeat('*', max(3, $at - 2)) . substr($email, $at);
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/api/Auth.php */