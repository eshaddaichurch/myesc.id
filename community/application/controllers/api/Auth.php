<?php

class Auth extends CI_Controller {

    public function login()
{
    // ambil input JSON atau form
    $input = json_decode(file_get_contents("php://input"), true);

    $username = $input['username'] ?? $this->input->post('username');
    $password = $input['password'] ?? $this->input->post('password');

    if (empty($username) || empty($password)) {
        echo json_encode([
            'status' => false,
            'message' => 'Username dan password wajib diisi',
            'data' => null
        ]);
        return;
    }

    $user = $this->db
        ->where('username', $username)
        ->where('password', md5($password))
        ->get('jemaat')
        ->row();

    if (!$user) {
        echo json_encode([
            'status' => false,
            'message' => 'Username atau password salah',
            'data' => null
        ]);
        return;
    }

    // generate token
    $token = bin2hex(random_bytes(20));

    $this->db->insert('api_key', [
        'user_id' => $user->idjemaat,
        'key' => $token,
        'level' => 1,
        'ignore_limits' => 0,
        'is_private_key' => 0,
        'date_created' => time()
    ]);

    echo json_encode([
        'status' => true,
        'message' => 'Login berhasil',
        'data' => [
            'idjemaat' => $user->idjemaat,
            'namalengkap' => $user->namalengkap,
            'token' => $token
        ]
    ]);
}

}
