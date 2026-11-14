<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('dcfoto_secret')) {
    function dcfoto_secret()
    {
        $env = getenv('DC_FOTO_SECRET');
        if ($env !== false && $env !== '') {
            return $env;
        }

        $file = APPPATH . 'config/dcfoto_secret.php';
        if (!is_file($file)) {
            return '';
        }

        $dcfoto_secret = '';
        include $file;
        return (string) $dcfoto_secret;
    }
}

if (!function_exists('dcfoto_sign')) {
    function dcfoto_sign($file, $exp)
    {
        return hash_hmac('sha256', $file . '|' . $exp, dcfoto_secret());
    }
}