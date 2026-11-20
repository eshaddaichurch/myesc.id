<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('info_upload_gambar')) {
    // Menyimpan gambar info terkini. Mengembalikan nama file yang tersimpan.
    // Melempar RuntimeException dengan pesan yang aman ditampilkan ke admin.
    function info_upload_gambar($field)
    {
        $maksByte = 2 * 1024 * 1024;
        $mimeTerizin = array(
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        );

        if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Gambar wajib diunggah.');
        }

        $tmp = $_FILES[$field]['tmp_name'];
        $size = (int) $_FILES[$field]['size'];

        if ($size <= 0 || $size > $maksByte) {
            throw new RuntimeException('Ukuran gambar maksimal 2 MB.');
        }

        // Periksa isi file, bukan hanya ekstensi
        $info = @getimagesize($tmp);
        if ($info === false || !isset($mimeTerizin[$info['mime']])) {
            throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.');
        }

        $folder = FCPATH . 'uploads/info/';
        if (!is_dir($folder) && !mkdir($folder, 0755, true)) {
            log_message('error', 'info_upload: gagal membuat folder ' . $folder);
            throw new RuntimeException('Gagal menyiapkan folder upload.');
        }

        $nama = 'info_' . date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $mimeTerizin[$info['mime']];

        if (!move_uploaded_file($tmp, $folder . $nama)) {
            log_message('error', 'info_upload: gagal memindahkan file ke ' . $folder . $nama);
            throw new RuntimeException('Gagal menyimpan gambar.');
        }

        return $nama;
    }
}

if (!function_exists('info_hapus_gambar')) {
    // Menghapus file gambar lama. Nama file dicek dulu agar tidak bisa dipakai untuk menghapus file lain.
    function info_hapus_gambar($nama)
    {
        if (!is_string($nama) || !preg_match('/^info_[0-9A-Za-z_]+\.(jpg|png|webp)$/', $nama)) {
            return false;
        }
        $path = FCPATH . 'uploads/info/' . $nama;
        return is_file($path) ? unlink($path) : false;
    }
}

/* End of file info_upload_helper.php */
/* Location: ./application/helpers/info_upload_helper.php */