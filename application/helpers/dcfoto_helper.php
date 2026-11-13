<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Secret penanda URL foto. Dipakai bersama oleh Dcrecap dan Dcfoto.
 * Mengembalikan string kosong jika belum terbaca; pemanggil yang memutuskan apa yang dilakukan.
 */
function dcfoto_secret()
{
    $secret = getenv('DC_FOTO_SECRET');
    if ($secret === false || $secret === '') {
        $secret = isset($_SERVER['DC_FOTO_SECRET']) ? $_SERVER['DC_FOTO_SECRET'] : '';
    }
    return (string) $secret;
}

function dcfoto_sign($file, $exp)
{
    return hash_hmac('sha256', $file . '|' . $exp, dcfoto_secret());
}