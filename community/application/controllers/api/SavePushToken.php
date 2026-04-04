<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SavePushToken extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function save()
    {
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);

        $iddc = $input['iddc'] ?? '';
        $token = $input['token'] ?? '';

        if (!$iddc || !$token) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Cek apakah sudah ada
        $existing = $this
            ->db
            ->where('iddc', $iddc)
            ->get('push_tokens')
            ->row();

        if ($existing) {
            // Update token
            $this->db->where('iddc', $iddc);
            $this->db->update('push_tokens', [
                'token' => $token,
                'tanggalupdate' => date('Y-m-d H:i:s'),
            ]);
        } else {
            // Insert token baru
            $this->db->insert('push_tokens', [
                'iddc' => $iddc,
                'token' => $token,
                'tanggalinsert' => date('Y-m-d H:i:s'),
                'tanggalupdate' => date('Y-m-d H:i:s'),
            ]);
        }

        echo json_encode(['status' => true, 'message' => 'Token berhasil disimpan']);
    }
    
}
s