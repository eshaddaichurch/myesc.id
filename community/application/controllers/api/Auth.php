<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        header('Content-Type: application/json');
    }

    public function login()
    {
        // Ambil JSON dari body
        $raw = file_get_contents("php://input");
        $input = json_decode($raw, true);

        $username = trim($input['username'] ?? '');
        $password = trim($input['password'] ?? '');

        if ($username === '' || $password === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Username dan password wajib diisi',
                'data' => null
            ]);
            return;
        }

        // cek login (password di DB = md5)
        $user = $this->Login_model->cek_login(
            strtolower($username),
            md5($password)
        );

        if ($user->num_rows() === 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Username atau password salah',
                'data' => null
            ]);
            return;
        }

        $u = $user->row();

        // 👉 RESPONSE INI YANG AKAN DISIMPAN DI MOBILE
        echo json_encode([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'idjemaat'     => $u->idjemaat,
                'iddc'         => $u->iddc,
                'namalengkap'  => $u->namalengkap,
                'username'     => $u->username
            ]
        ]);
    }
}
