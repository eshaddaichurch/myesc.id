<?php

class Auth extends CI_Controller {

    public function login()
    {
        // ambil raw JSON
        $input = json_decode(trim(file_get_contents("php://input")), true);
    
        // fallback kalau bukan JSON (misal form)
        $username = $input['username'] ?? $this->input->post('username');
        $password = $input['password'] ?? $this->input->post('password');
    
        if (empty($username) || empty($password)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Username dan password wajib diisi',
                    'data' => null
                ]));
            return;
        }
    
        $user = $this->Login_model->cek_login($username, md5($password));
    
        if ($user->num_rows() === 0) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Username atau password salah',
                    'data' => null
                ]));
            return;
        }
    
        $result = $user->row();
    
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'idjemaat' => $result->idjemaat,
                    'namalengkap' => $result->namalengkap
                ]
            ]));
    }
    

}
