<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // CORS headers untuk React Native
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }

    public function jemaat($filename = null)
    {
        // Naik 1 level dari community ke myesc.id
        $basePath = realpath(FCPATH . '../admin/uploads/jemaat/') . DIRECTORY_SEPARATOR;
        $noFoto   = realpath(FCPATH . '../images/nofoto.png');

        if (empty($filename)) {
            return $this->outputImage($noFoto);
        }

        // Security: cegah path traversal
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