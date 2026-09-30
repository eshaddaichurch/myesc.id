<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library WhatsApp berbasis Fonnte (pengganti Woowa).
 * Nama class & method send_message() sengaja dipertahankan
 * supaya semua controller lama tetap jalan tanpa perubahan.
 */
class Whatsapp
{
    protected $endpoint = 'https://api.fonnte.com/send';
    protected $token = null;
    public $last_error = '';

    protected function getToken()
    {
        if ($this->token === null) {
            $CI =& get_instance();
            $CI->config->load('fonnte', TRUE);
            $this->token = (string) $CI->config->item('fonnte_token', 'fonnte');
        }
        return $this->token;
    }

    /**
     * Kirim pesan WhatsApp.
     *
     * @param string       $nomor   08xxx / 62xxx / +62xxx / 62xxx@c.us (bisa array)
     * @param string       $pesan   Isi pesan
     * @param array        $options Parameter tambahan Fonnte (mis. url, delay, schedule)
     * @return bool TRUE jika pesan berhasil masuk antrian Fonnte
     */
    public function send_message($nomor, $pesan, $options = array())
    {
        $this->last_error = '';

        $token = $this->getToken();
        if ($token === '' || $token === 'ISI_TOKEN_DEVICE_KAMU') {
            $this->last_error = 'Token Fonnte belum diisi';
            log_message('error', 'Fonnte: ' . $this->last_error);
            return FALSE;
        }

        $target = $this->normalize($nomor);
        if ($target === '') {
            $this->last_error = 'Nomor tujuan tidak valid';
            log_message('error', 'Fonnte: ' . $this->last_error);
            return FALSE;
        }

        $data = array_merge(array(
            'target'  => $target,
            'message' => $pesan,
        ), $options);

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $this->endpoint,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_HTTPHEADER     => array('Authorization: ' . $token),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 30,
        ));

        $response = curl_exec($ch);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($response === FALSE) {
            $this->last_error = 'cURL: ' . $curlErr;
            log_message('error', 'Fonnte gagal (cURL): ' . $curlErr);
            return FALSE;
        }

        $result = json_decode($response, TRUE);

        if (!is_array($result) || empty($result['status'])) {
            $reason = (is_array($result) && isset($result['reason'])) ? $result['reason'] : $response;
            $this->last_error = $reason;
            log_message('error', 'Fonnte gagal kirim ke ' . $target . ': ' . $reason);
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Ubah berbagai format nomor menjadi 62xxxxxxxxxx.
     * Aman untuk hasil formatNomorWhatsapp() lama (mis. berakhiran @c.us).
     */
    protected function normalize($nomor)
    {
        $list = is_array($nomor) ? $nomor : explode(',', $nomor);
        $out  = array();

        foreach ($list as $num) {
            $num = preg_replace('/@.*$/', '', (string) $num);  // buang suffix @c.us dsb
            $num = preg_replace('/\D/', '', $num);              // sisakan angka saja

            if ($num === '') {
                continue;
            }

            if (strpos($num, '0') === 0) {
                $num = '62' . substr($num, 1);
            } elseif (strpos($num, '8') === 0) {
                $num = '62' . $num;
            }

            $out[] = $num;
        }

        return implode(',', $out);
    }
}