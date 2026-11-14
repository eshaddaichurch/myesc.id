<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Kunci rahasia dibaca dari environment, diatur lewat SetEnv di .htaccess.
// Kunci tidak pernah ditulis di kode.
if (!function_exists('dcfoto_secret')) {
    function dcfoto_secret()
    {
        $secret = getenv('DC_FOTO_SECRET');
        if ($secret === false || $secret === '') {
            $secret = isset($_SERVER['DC_FOTO_SECRET']) ? $_SERVER['DC_FOTO_SECRET'] : '';
        }
        return (string) $secret;
    }
}

// Tanda tangan untuk satu nama file dan waktu kedaluwarsanya
if (!function_exists('dcfoto_sign')) {
    function dcfoto_sign($file, $exp)
    {
        return hash_hmac('sha256', $file . '|' . $exp, dcfoto_secret());
    }
}

/* End of file dcfoto_helper.php */
/* Location: ./application/helpers/dcfoto_helper.php */