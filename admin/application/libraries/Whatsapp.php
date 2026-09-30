<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library WhatsApp berbasis Fonnte (pengganti notifapi / Woowa).
 *
 * Contoh penggunaan (sama seperti library lama):
 *   $this->load->library('whatsapp');
 *   $response = $this->whatsapp->send_message('6289xxx', 'Halo, ini pesan uji coba!');
 *
 * Kontrak nilai kembalian (sama dengan library lama):
 *   - array : pesan berhasil masuk antrian Fonnte (isi = respon Fonnte, mis. ['status' => true, 'id' => [...]])
 *   - false : gagal. Alasannya ada di $this->last_error dan di application/logs
 *
 * Token dibaca dari application/config/fonnte.php (file ini WAJIB di-gitignore):
 *   $config['fonnte_token'] = 'TOKEN_DEVICE_FONNTE';
 *
 * File yang sama dipakai di tiap aplikasi CI3 (root, admin, community),
 * masing-masing dengan config/fonnte.php miliknya sendiri.
 */
class Whatsapp
{
    protected $CI;
    protected $endpoint = 'https://api.fonnte.com/send';
    protected $token = null;

    /** Alasan gagal dari pemanggilan send_message() terakhir */
    public $last_error = '';

    public function __construct($config = array())
    {
        $this->CI =& get_instance();
    }

    /**
     * Baca token secara lazy (hanya saat pesan benar-benar dikirim).
     * File config yang tidak ada tidak menyebabkan error halaman, hanya dicatat di log.
     */
    protected function getToken()
    {
        if ($this->token === null) {
            $this->token = '';

            if ($this->CI->config->load('fonnte', TRUE, TRUE)) {
                $this->token = trim((string) $this->CI->config->item('fonnte_token', 'fonnte'));
            }
        }

        return $this->token;
    }

    /**
     * Kirim pesan WhatsApp.
     *
     * @param string|array $phone_no Nomor tujuan: 08xxx / 62xxx / +62xxx / 62xxx@c.us (boleh array)
     * @param string       $message  Isi pesan
     * @param array        $options  Parameter tambahan Fonnte (mis. ['url' => '...', 'delay' => '5-10'])
     * @return array|bool  Array respon Fonnte jika berhasil masuk antrian, FALSE jika gagal
     */
    public function send_message($phone_no, $message, $options = array())
    {
        $this->last_error = '';

        $token = $this->getToken();
        if ($token === '' || $token === 'ISI_TOKEN_DEVICE_KAMU') {
            return $this->gagal('Token Fonnte belum diisi (application/config/fonnte.php)');
        }

        $target = $this->normalize($phone_no);
        if ($target === '') {
            return $this->gagal('Nomor tujuan tidak valid');
        }

        $data = array_merge(array(
            'target'  => $target,
            'message' => $message,
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
            return $this->gagal('cURL: ' . $curlErr);
        }

        $result = json_decode($response, TRUE);

        if (!is_array($result)) {
            return $this->gagal('Respon Fonnte tidak valid: ' . substr($response, 0, 200));
        }

        if (empty($result['status'])) {
            $alasan = isset($result['reason']) ? $result['reason'] : $response;
            return $this->gagal('Fonnte menolak pesan ke ' . $target . ': ' . $alasan);
        }

        return $result;
    }

    /**
     * Catat alasan gagal lalu kembalikan FALSE.
     */
    protected function gagal($alasan)
    {
        $this->last_error = $alasan;
        log_message('error', 'WhatsApp (Fonnte) gagal: ' . $alasan);
        return FALSE;
    }

    /**
     * Ubah berbagai format nomor menjadi 62xxxxxxxxxx (boleh banyak nomor, dipisah koma).
     */
    protected function normalize($nomor)
    {
        $list = is_array($nomor) ? $nomor : explode(',', (string) $nomor);
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