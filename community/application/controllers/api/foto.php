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

        // 🔍 DEBUG LOG
        error_log("=== FOTO API DEBUG ===");
        error_log("Requested filename: " . ($filename ?: 'EMPTY'));
        error_log("Base path: " . $basePath);
        error_log("NoFoto path: " . $noFoto);

        if (empty($filename)) {
            error_log("Empty filename, returning nofoto");
            return $this->outputImage($noFoto);
        }

        // Security: cegah path traversal
        $filename = basename($filename);
        $filePath = $basePath . $filename;

        error_log("Cleaned filename: " . $filename);
        error_log("Full file path: " . $filePath);
        error_log("File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));
        error_log("Is file: " . (is_file($filePath) ? 'YES' : 'NO'));

        if (!file_exists($filePath) || !is_file($filePath)) {
            error_log("File not found, returning nofoto");
            $filePath = $noFoto;
        }

        $this->outputImage($filePath);
    }

    private function outputImage($path)
    {
        if (!file_exists($path)) {
            error_log("ERROR: Path does not exist: " . $path);
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

        error_log("Outputting image: " . $path . " (" . filesize($path) . " bytes)");
        
        readfile($path);
        exit;
    }
}