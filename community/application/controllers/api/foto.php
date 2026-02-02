<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {

    public function jemaat($filename = null)
    {
        // naik 1 level dari community ke myesc.id
        $basePath = realpath(FCPATH . '../admin/uploads/jemaat/') . DIRECTORY_SEPARATOR;
        $noFoto   = realpath(FCPATH . '../images/nofoto.png');

        if (empty($filename)) {
            return $this->outputImage($noFoto);
        }

        // security: cegah ../
        $filename = basename($filename);

        $filePath = $basePath . $filename;

        if (!file_exists($filePath) || !is_file($filePath)) {
            $filePath = $noFoto;
        }

        $this->outputImage($filePath);
    }

    private function outputImage($path)
    {
        if (!file_exists($path)) {
            show_404();
            return;
        }

        $mime = function_exists('mime_content_type')
            ? mime_content_type($path)
            : 'image/png';

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: public, max-age=86400');
        header('Pragma: public');

        readfile($path);
        exit;
    }
}
