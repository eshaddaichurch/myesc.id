<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function login()
    {
        // Set response JSON
        $this->output->set_content_type('application/json');

        // Ambil raw input
        $rawInput = file_get_contents("php://input");
        $input = json_decode($rawInput, true);

        // Ambil username & password
        $username = $input['username'] ?? $this->input->post('username');
        $password = $input['password'] ?? $this->input->post('password');

        // Validasi
        if (empty($username) || empty($password)) {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Username dan password wajib diisi',
                'data' => null
            ]));
            return;
        }

        // Cek login (TANPA md5)
        $user = $this->Login_model->cek_login($username, $password);

        if ($user->num_rows() === 0) {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Username atau password salah',
                'data' => null
            ]));
            return;
        }

        $result = $user->row();

        // Response sukses
        $this->output->set_output(json_encode([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'idjemaat'     => $result->idjemaat,
                'namalengkap'  => $result->namalengkap,
                'username'     => $result->username
            ]
        ]));
    }
}
