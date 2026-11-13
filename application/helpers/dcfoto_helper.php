<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Secret penanda URL foto. Dipakai bersama oleh Dcrecap (menandatangani)
 * dan Dcfoto (memverifikasi), supaya keduanya selalu membaca nilai yang sama.
 */
function dcfoto_secret()
{
    $secret = getenv('DC_FOTO_SECRET');

    if ($secret === false || $secret === '') {
        $secret = isset($_SERVER['DC_FOTO_SECRET']) ? $_SERVER['DC_FOTO_SECRET'] : '';
    }
    if ($secret === '' && isset($_ENV['DC_FOTO_SECRET'])) {
        $secret = $_ENV['DC_FOTO_SECRET'];
    }

    if (!is_string($secret) || strlen($secret) < 32) {
        throw new RuntimeException('DC_FOTO_SECRET belum di-set atau terlalu pendek (minimal 32 karakter).');
    }

    return $secret;
}

function dcfoto_sign($file, $exp)
{
    return hash_hmac('sha256', $file . '|' . $exp, dcfoto_secret());
}