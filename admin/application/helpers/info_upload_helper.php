<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Aturan gambar info terkini. Ini satu-satunya sumber aturan:
// dipakai oleh validasi upload, form, dan halaman daftar.
if (!function_exists('info_aturan_gambar')) {
    function info_aturan_gambar()
    {
        return array(
            'maks_byte'   => 2 * 1024 * 1024,
            'lebar_min'   => 800,
            'lebar_maks'  => 2400,
            'tinggi_min'  => 400,
            'tinggi_maks' => 1200,
            'rasio'       => 2.0,   // lebar : tinggi
            'toleransi'   => 0.10,  // selisih rasio yang masih diterima (10%)
            'rekomendasi' => '1200 x 600 px (rasio 2:1)',
            'format'      => 'JPG, PNG, atau WEBP',
            'maks_teks'   => '2 MB',
        );
    }
}

if (!function_exists('info_upload_gambar')) {
    // Menyimpan gambar info terkini. Mengembalikan nama file yang tersimpan.
    // Melempar RuntimeException dengan pesan yang aman ditampilkan ke admin.
    function info_upload_gambar($field)
    {
        $aturan = info_aturan_gambar();
        $mimeTerizin = array(
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        );

        if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Gambar wajib diunggah.');
        }

        $tmp  = $_FILES[$field]['tmp_name'];
        $size = (int) $_FILES[$field]['size'];

        if ($size <= 0 || $size > $aturan['maks_byte']) {
            throw new RuntimeException('Ukuran file maksimal ' . $aturan['maks_teks'] . '.');
        }

        // Periksa isi file, bukan hanya ekstensi
        $info = @getimagesize($tmp);
        if ($info === false || !isset($mimeTerizin[$info['mime']])) {
            throw new RuntimeException('Format gambar harus ' . $aturan['format'] . '.');
        }

        // Periksa ukuran piksel dan rasio
        $lebar  = (int) $info[0];
        $tinggi = (int) $info[1];

        if ($lebar < $aturan['lebar_min'] || $lebar > $aturan['lebar_maks']
            || $tinggi < $aturan['tinggi_min'] || $tinggi > $aturan['tinggi_maks']) {
            throw new RuntimeException(
                'Ukuran gambar harus antara ' . $aturan['lebar_min'] . ' sampai ' . $aturan['lebar_maks']
                . ' px (lebar) dan ' . $aturan['tinggi_min'] . ' sampai ' . $aturan['tinggi_maks']
                . ' px (tinggi). Rekomendasi: ' . $aturan['rekomendasi'] . '.'
            );
        }

        $rasioGambar = $lebar / $tinggi;
        $selisih = abs($rasioGambar - $aturan['rasio']) / $aturan['rasio'];
        if ($selisih > $aturan['toleransi']) {
            throw new RuntimeException(
                'Rasio gambar harus mendekati 2:1 (lebar dua kali tinggi). Rekomendasi: '
                . $aturan['rekomendasi'] . '.'
            );
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
    // Menghapus file gambar. Nama file dicek dulu agar tidak bisa dipakai untuk menghapus file lain.
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