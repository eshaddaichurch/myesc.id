<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'helpers/dcfoto_helper.php';

class Dcfoto extends CI_Controller
{
    const FOLDER_ABSENSI = 'community/uploads/absensi/';

    // GET /api/dcfoto?f=nama.jpg&e=timestamp&s=signature
    public function index()
    {
        $file = (string) $this->input->get('f');
        $exp = (int) $this->input->get('e');
        $sig = (string) $this->input->get('s');

        try {
            dcfoto_secret();
        } catch (RuntimeException $e) {
            log_message('error', 'Dcfoto: ' . $e->getMessage());
            $this->output->set_status_header(500);
            exit;
        }

        if (!$this->_valid($file, $exp, $sig)) {
            $this->output->set_status_header(403);
            exit;
        }

        $base = realpath(FCPATH . self::FOLDER_ABSENSI);
        $path = $base ? realpath($base . DIRECTORY_SEPARATOR . $file) : false;

        if ($path === false || strpos($path, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
            log_message('error', 'Dcfoto: file tidak ditemukan: ' . $file);
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
        if ($file === '' || $exp < time()) {
            return false;
        }

        if (!preg_match('/^[A-Za-z0-9._-]+$/', $file) || basename($file) !== $file) {
            return false;
        }

        return hash_equals(dcfoto_sign($file, $exp), $sig);
    }
}

/* End of file Dcfoto.php */
/* Location: ./application/controllers/api/Dcfoto.php */