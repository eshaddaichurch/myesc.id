<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dcfoto extends CI_Controller
{
    // Folder foto absensi, relatif dari root myesc.id (FCPATH)
    const FOLDER_ABSENSI = 'community/uploads/absensi/';

    // GET /api/dcfoto?f=nama.jpg&e=timestamp&s=signature
    public function index()
    {
        $file = (string) $this->input->get('f');
        $exp = (int) $this->input->get('e');
        $sig = (string) $this->input->get('s');

        if (!$this->_valid($file, $exp, $sig)) {
            $this->output->set_status_header(403);
            exit;
        }

        $base = realpath(FCPATH . self::FOLDER_ABSENSI);
        $path = $base ? realpath($base . DIRECTORY_SEPARATOR . $file) : false;

        // Pastikan file benar-benar berada di folder absensi
        if ($path === false || strpos($path, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
            $this->output->set_status_header(404);
            exit;
        }

        $info = @getimagesize($path);
        if ($info === false) {
            $this->output->set_status_header(404);
            exit;
        }

        header('Content-Type: ' . $info['mime']);
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: private, max-age=3600');
        header('X-Content-Type-Options: nosniff');
        readfile($path);
        exit;
    }

    private function _valid($file, $exp, $sig)
    {
        $secret = getenv('DC_FOTO_SECRET') ?: '';
        if ($secret === '' || $file === '' || $exp < time()) {
            return false;
        }

        // Nama file hanya huruf, angka, titik, garis bawah, dan strip
        if (!preg_match('/^[A-Za-z0-9._-]+$/', $file) || basename($file) !== $file) {
            return false;
        }

        $expected = hash_hmac('sha256', $file . '|' . $exp, $secret);
        return hash_equals($expected, $sig);
    }
}

/* End of file Dcfoto.php */
/* Location: ./application/controllers/api/Dcfoto.php */