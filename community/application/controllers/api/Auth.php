<?php

class Auth extends CI_Controller {

    public function login()
    {
        header('Content-Type: application/json');

        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        if (!$username || !$password) {
            return $this->json(false, 'Username dan password wajib diisi');
        }

        $user = $this->db->get_where('jemaat', [
            'username' => $username,
            'password' => $password
        ])->row();

        if (!$user) {
            return $this->json(false, 'Username atau password salah');
        }

        // hapus token lama (1 user 1 device)
        $this->db->where('user_id', $user->idjemaat)->delete('api_key');

        $token = bin2hex(random_bytes(20)); // 40 char

        $this->db->insert('api_key', [
            'user_id' => $user->idjemaat,
            'key' => $token,
            'level' => 1,
            'ignore_limits' => 0,
            'is_private_key' => 0,
            'ip_addresses' => $this->input->ip_address(),
            'date_created' => time()
        ]);

        return $this->json(true, 'Login berhasil', [
            'idjemaat' => $user->idjemaat,
            'nama' => $user->namalengkap,
            'iddc' => $user->iddc,
            'token' => $token
        ]);
    }

    private function json($status, $message, $data = null)
    {
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
}
