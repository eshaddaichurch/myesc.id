<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp_webhook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('whatsapp');
    }

    // Menangani verifikasi awal dari Meta (GET) dan pesan masuk (POST)
    public function index() {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $this->verify();
        } elseif ($method === 'POST') {
            $this->receive();
        }
    }

    // Step verifikasi webhook (dipanggil sekali saat Anda klik "Verify and save" di dashboard Meta)
    private function verify() {
        $verify_token = $this->config->item('whatsapp')['verify_token'];

        $mode      = $this->input->get('hub_mode');
        $token     = $this->input->get('hub_verify_token');
        $challenge = $this->input->get('hub_challenge');

        if ($mode === 'subscribe' && $token === $verify_token) {
            echo $challenge;
            http_response_code(200);
        } else {
            http_response_code(403);
            echo 'Verification failed';
        }
    }

    // Menangani pesan masuk dari jemaat
    private function receive() {
        $input = file_get_contents('php://input');
        $data  = json_decode($input, true);

        // Log untuk debugging (opsional, hapus di production)
        log_message('debug', 'WA Webhook: ' . $input);

        // Ambil nomor pengirim & isi pesan
        $entry   = $data['entry'][0] ?? null;
        $changes = $entry['changes'][0] ?? null;
        $value   = $changes['value'] ?? null;
        $message = $value['messages'][0] ?? null;

        if ($message) {
            $from = $message['from']; // nomor pengirim
            $text = strtolower(trim($message['text']['body'] ?? ''));

            $this->load->library('Whatsapp_sender_resmi');
            $this->whatsapp_sender_resmi->send_auto_reply($from, $text);
        }

        http_response_code(200);
        echo json_encode(['status' => 'received']);
    }
}