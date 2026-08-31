<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp_sender {

    protected $ci;
    protected $config;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->config->load('whatsapp');
        $this->config = $this->ci->config->item('whatsapp');
    }

    // Kirim pesan teks biasa
    public function send_text($to, $message) {
        $url = $this->config['base_url'] . '/' . $this->config['phone_number_id'] . '/messages';

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $to,
            'type'              => 'text',
            'text'              => ['body' => $message],
        ];

        return $this->_send($url, $payload);
    }

    // Kirim pesan pakai template (untuk OTP / konfirmasi kelas)
    public function send_template($to, $template_name, $params = []) {
        $url = $this->config['base_url'] . '/' . $this->config['phone_number_id'] . '/messages';

        $components = [];
        if (!empty($params)) {
            $components[] = [
                'type'       => 'body',
                'parameters' => array_map(fn($p) => ['type' => 'text', 'text' => $p], $params),
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $to,
            'type'              => 'template',
            'template'          => [
                'name'     => $template_name,
                'language' => ['code' => 'id'], // atau 'en_US' sesuai template Anda
                'components' => $components,
            ],
        ];

        return $this->_send($url, $payload);
    }

    // Logic auto-reply saat jemaat chat
    public function send_auto_reply($from, $text) {
        $hotlines = $this->ci->config->item('whatsapp_hotlines');

        if (strpos($text, 'equip') !== false || strpos($text, 'pengajaran') !== false || strpos($text, 'belajar') !== false) {
            $reply = "Untuk informasi *kelas pengajaran (Equip)*, silakan hubungi *{$hotlines['Equip']['name']}*:\nwa.me/{$hotlines['Equip']['number']}";
        } elseif (strpos($text, 'dc') !== false || strpos($text, 'disciples') !== false || strpos($text, 'komunitas') !== false) {
            $reply = "Untuk informasi *Disciples Community*, silakan hubungi *{$hotlines['dc']['name']}*:\nwa.me/{$hotlines['dc']['number']}";
        } elseif (strpos($text, 'doa') !== false || strpos($text, 'konseling') !== false || strpos($text, 'care') !== false || strpos($text, 'pelayanan') !== false) {
            $reply = "Untuk kebutuhan *konseling & pelayanan jemaat*, silakan hubungi *{$hotlines['care']['name']}*:\nwa.me/{$hotlines['care']['number']}";
        } else {
            $reply = "Shalom!\n\n"
                . "Selamat datang di *El Shaddai Church*.\n"
                . "Terima kasih telah menghubungi kami.\n\n"
                . "Silakan pilih layanan yang sesuai dengan kebutuhan Anda:\n\n"
                . "*{$hotlines['dc']['name']}*\n"
                . "Disciples Community\n"
                . "wa.me/{$hotlines['dc']['number']}\n\n"
                . "*{$hotlines['Equip']['name']}*\n"
                . "Kelas Pengajaran\n"
                . "wa.me/{$hotlines['Equip']['number']}\n\n"
                . "*{$hotlines['care']['name']}*\n"
                . "Konseling & Pelayanan Jemaat\n"
                . "wa.me/{$hotlines['care']['number']}\n\n"
                . "*{$hotlines['connect']['name']}*\n"
                . "Informasi Umum\n"
                . "wa.me/{$hotlines['connect']['number']}\n\n"
                . "Tuhan memberkati.";
        }

        return $this->send_text($from, $reply);
    }

    // Fungsi internal kirim request ke Graph API
    private function _send($url, $payload) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->config['access_token'],
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        log_message('debug', "WA Send Response ({$http_code}): " . $response);

        return json_decode($response, true);
    }
}