<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {

    public function jemaat($filename = null)
    {
        $basePath = FCPATH . 'admin/uploads/jemaat/';
        $noFoto   = FCPATH . 'images/nofoto.png';

        if (!$filename) {
            $this->outputImage($noFoto);
            return;
        }

        $filename = basename($filename); // security

        $filePath = $basePath . $filename;

        if (!file_exists($filePath)) {
            $filePath = $noFoto;
        }

        $this->outputImage($filePath);
    }

    private function outputImage($path)
    {
        $mime = mime_content_type($path);

        header('Content-Type: ' . $mime);
        header('Cache-Control: public, max-age=86400'); // cache 1 hari
        header('Pragma: public');

        readfile($path);
        exit;
    }
}
