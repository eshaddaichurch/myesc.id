<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Kunci: dari environment, atau dari file lokal yang tidak di-commit
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

// Folder foto absensi, dihitung dari APPPATH (folder application), bukan FCPATH.
// Hasil selalu diakhiri separator.
if (!function_exists('dcfoto_dir')) {
    function dcfoto_dir()
    {
        $dir = realpath(APPPATH . '../community/uploads/absensi');
        return $dir === false ? '' : $dir . DIRECTORY_SEPARATOR;
    }
}

// Nama file aman dan benar-benar ada di folder absensi
if (!function_exists('dcfoto_exists')) {
    function dcfoto_exists($file)
    {
        if (!is_string($file) || $file === '') {
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9._-]+$/', $file) || basename($file) !== $file) {
            return false;
        }

        $dir = dcfoto_dir();
        return $dir !== '' && is_file($dir . $file);
    }
}

/* End of file dcfoto_helper.php */
/* Location: ./application/helpers/dcfoto_helper.php */