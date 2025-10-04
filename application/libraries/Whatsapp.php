<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library untuk mengirim pesan WhatsApp melalui API eksternal
 * 
 * Contoh penggunaan:
 * $this->load->library('whatsapp');
 * $response = $this->whatsapp->send_message('6289xxx', 'Halo, ini pesan uji coba!');
 * 
 * @author Your Name
 */
class Whatsapp
{
    protected $CI;
    protected $base_url = 'https://notifapi.com';
    protected $api_key = 'adpa493ec6c-b691-408a-9b92-177e3a001b3f';

    public function __construct($config = array())
    {
        $this->CI =& get_instance();

        if (empty($this->base_url) || empty($this->api_key)) {
            show_error('Konfigurasi WhatsApp API tidak lengkap: base_url dan api_key harus diisi.');
        }
    }

    /**
     * Mengirim pesan WhatsApp ke nomor tujuan
     *
     * @param string $phone_no   Nomor telepon (format internasional tanpa +, contoh: 6281234567890)
     * @param string $message    Isi pesan
     * @return array|bool        Response dari API dalam bentuk array, atau false jika gagal
     */
    public function send_message($phone_no, $message)
    {
        $url = $this->base_url . '/send_message';

        $data = array(
            'phone_no' => $phone_no,
            'key'      => $this->api_key,
            'message'  => $message
        );

        $payload = json_encode($data);

        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // timeout 30 detik
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // nonaktifkan jika SSL bermasalah (hanya untuk dev)

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'WhatsApp API Error: ' . $error);
            return false;
        }

        // Decode response
        $result = json_decode($response, true);

        // Jika decode gagal, kembalikan response asli
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('debug', 'WhatsApp API Response (non-JSON): ' . $response);
            return array('raw_response' => $response, 'http_code' => $http_code);
        }

        return $result;
    }
}