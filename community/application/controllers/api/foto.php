<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {

    public function jemaat($filename = null)
    {
        // === PATH ASLI FILE DI SERVER ===
        $basePath = FCPATH . 'myesc.id/admin/uploads/jemaat/';
        $noFoto   = FCPATH . 'myesc.id/images/nofoto.png';

        // kalau tidak ada nama file
        if (empty($filename)) {
            $this->outputImage($noFoto);
            return;
        }

        // security: cegah ../
        $filename = basename($filename);

        $filePath = $basePath . $filename;

        // kalau file tidak ditemukan
        if (!file_exists($filePath) || !is_file($filePath)) {
            $filePath = $noFoto;
        }

        $this->outputImage($filePath);
    }

    private function outputImage($path)
    {
        // fallback mime
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
