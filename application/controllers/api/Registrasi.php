<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Registrasi extends BaseApi
{
    // Rate limit (semua dihitung di server)
    const MAKS_PERCOBAAN_IP_PER_JAM = 10;   // percobaan daftar per IP
    const MAKS_DAFTAR_HP_PER_HARI = 3;      // percobaan daftar per nomor WhatsApp
    const MAKS_OTP_PER_TUJUAN_PER_HARI = 5; // OTP terkirim per nomor/email per hari
    const OTP_MAKS_SALAH = 5;               // salah input per kode OTP
    const OTP_JEDA_DETIK = 60;              // jeda minimal kirim ulang OTP

    const PATTERN_HP = '/^08[0-9]{8,13}$/';
    const PATTERN_TGL = '/^\d{4}-\d{2}-\d{2}$/';
    const PATTERN_ID = '/^[A-Za-z0-9\-_]{1,40}$/';
    const KOLOM_VERIFIKASI = array('wa' => 'statusverifikasiwa', 'email' => 'statusverifikasiemail');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('App');
    }

    // POST /api/registrasi/daftar
    public function daftar()
    {
        $ip = $this->input->ip_address();
        $nohp = trim((string) $this->input->post('nohp'));

        // Batas percobaan per IP dalam 1 jam
        $jumlahIp = (int) $this->db->query(
            'SELECT COUNT(*) AS jml FROM registrasi_log WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)',
            array($ip)
        )->row()->jml;

        if ($jumlahIp >= self::MAKS_PERCOBAAN_IP_PER_JAM) {
            $this->jsonError('Terlalu banyak percobaan pendaftaran dari koneksi ini. Silakan coba lagi dalam 1 jam, atau hubungi hotline gereja WhatsApp 085550001187.');
            return;
        }

        // Batas percobaan per nomor WhatsApp dalam 24 jam
        if ($nohp !== '') {
            $jumlahHp = (int) $this->db->query(
                'SELECT COUNT(*) AS jml FROM registrasi_log WHERE nohp = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)',
                array($nohp)
            )->row()->jml;

            if ($jumlahHp >= self::MAKS_DAFTAR_HP_PER_HARI) {
                $this->jsonError('Terlalu banyak percobaan untuk nomor WhatsApp ini hari ini. Silakan coba lagi besok, atau hubungi hotline gereja WhatsApp 085550001187.');
                return;
            }
        }

        // Setiap percobaan dicatat, termasuk yang gagal validasi
        $this->db->insert('registrasi_log', array(
            'ip_address' => $ip,
            'nohp' => $nohp,
            'created_at' => date('Y-m-d H:i:s'),
        ));

        $err = null;
        $d = $this->_validasiData($err);
        if ($d === null) {
            $this->jsonError($err);
            return;
        }

        // Hanya untuk "Sudah Pernah": jika NIK sudah ada dan tanggal lahir cocok, data digabung ke akun lama
        $idMerge = null;
        if ($d['nik'] !== null) {
            $nikRow = $this->db->query('SELECT idjemaat, tanggallahir FROM jemaat WHERE nik = ? LIMIT 1', array($d['nik']))->row();
            if ($nikRow) {
                if ((string) $nikRow->tanggallahir !== $d['tanggallahir']) {
                    $this->jsonError('NIK tidak cocok dengan tanggal lahir Anda. Silakan hubungi hotline gereja WhatsApp 085550001187.');
                    return;
                }
                $idMerge = $nikRow->idjemaat;
            }
        }

        // Email atau nomor WhatsApp yang sudah terverifikasi tidak boleh dipakai lagi
        $cekEmail = $this->_akunPemakai('email', $d['email']);
        $cekHp    = $this->_akunPemakai('nohp', $d['nohp']);

        foreach (array(array($cekEmail, 'Email'), array($cekHp, 'Nomor WhatsApp')) as $pair) {
            list($row, $label) = $pair;
            if ($row && $row->idjemaat !== $idMerge && $this->_sudahVerifikasi($row)) {
                $this->jsonError($label . ' sudah pernah terdaftar! Jika Anda merasa belum pernah mendaftar, hubungi hotline gereja WhatsApp 085550001187.');
                return;
            }
        }

        // Akun belum terverifikasi yang memakai email/nomor ini boleh ditimpa
        $calonTimpa = null;
        foreach (array($cekEmail, $cekHp) as $row) {
            if ($row && $row->idjemaat !== $idMerge) {
                if ($calonTimpa !== null && $calonTimpa !== $row->idjemaat) {
                    $this->jsonError('Email dan nomor WhatsApp ini dipakai dua pendaftaran berbeda. Silakan hubungi hotline gereja WhatsApp 085550001187.');
                    return;
                }
                $calonTimpa = $row->idjemaat;
            }
        }
        if ($calonTimpa !== null && $idMerge === null) {
            $idMerge = $calonTimpa;
        }

        $sekarang = date('Y-m-d H:i:s');

        $this->db->trans_start();

        if ($idMerge !== null) {
            $idjemaat = $idMerge;
            $this->db->where('idjemaat', $idjemaat);
            $this->db->update('jemaat', array(
                'namalengkap' => $d['namalengkap'],
                'nik' => $d['nik'],
                'jeniskelamin' => $d['jeniskelamin'],
                'tempatlahir' => $d['tempatlahir'],
                'tanggallahir' => $d['tanggallahir'],
                'alamatrumah' => $d['alamatrumah'],
                'nohp' => $d['nohp'],
                'email' => $d['email'],
                'password' => md5($d['password']),
                'alasanmembuatakun' => 'Bergabung',
                'sudahpernahfondationclass' => $d['sudahpernah'],
                'statusverifikasiwa' => 0,
                'statusverifikasiemail' => 0,
            ));
        } else {
            $idjemaat = $this->db->query('SELECT create_idjemaat(?) AS idjemaat', array($sekarang))->row()->idjemaat;
            $this->db->insert('jemaat', array(
                'idjemaat' => $idjemaat,
                'namalengkap' => $d['namalengkap'],
                'nik' => $d['nik'],
                'jeniskelamin' => $d['jeniskelamin'],
                'tempatlahir' => $d['tempatlahir'],
                'tanggallahir' => $d['tanggallahir'],
                'alamatrumah' => $d['alamatrumah'],
                'nohp' => $d['nohp'],
                'email' => $d['email'],
                'password' => md5($d['password']),
                'tanggalinsert' => $sekarang,
                'statusjemaat' => 'Umum',
                'alasanmembuatakun' => 'Bergabung',
                'sudahpernahfondationclass' => $d['sudahpernah'],
            ));
        }

        // Kode OTP lama yang belum terpakai dihapus, hanya kode terbaru yang berlaku
        $this->db->where('idjemaat', $idjemaat)->where('verified', 0)->delete('otp_log');

        $this->db->insert('carejemaatbaru', array(
            'tglinsert' => $sekarang,
            'idjemaat' => $idjemaat,
            'status' => 'Registered',
            'idadmin' => null,
        ));

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'Registrasi::daftar gagal - ' . json_encode($this->db->error()));
            $this->jsonError('Data gagal disimpan. Silakan coba lagi atau hubungi admin.');
            return;
        }

        // Kode OTP dikirim ke email dan WhatsApp. Kegagalan kirim tidak membatalkan pendaftaran.
        $this->_buatDanKirimOtp($idjemaat, 'email', $d['email'], $d['namalengkap']);
        $this->_buatDanKirimOtp($idjemaat, 'wa', $d['nohp'], $d['namalengkap']);

        $this->jsonSuccess(array(
            'msg' => 'Registrasi berhasil. Masukkan kode verifikasi yang dikirim ke email dan WhatsApp Anda.',
            'idjemaat' => $this->encrypt->encode($idjemaat),
        ));
    }

    // POST /api/registrasi/verifikasi  (idjemaat, tipe: wa|email, otp)
    public function verifikasi()
    {
        $tipe = $this->_tipe();
        if ($tipe === null) {
            $this->jsonError('Jenis verifikasi tidak valid.');
            return;
        }

        $idjemaat = $this->_idDariEncrypt($this->input->post('idjemaat'));
        if ($idjemaat === null) {
            $this->jsonError('Data verifikasi tidak valid. Silakan ulangi pendaftaran.');
            return;
        }

        $otp = trim((string) $this->input->post('otp'));
        if (!preg_match('/^[0-9]{6}$/', $otp)) {
            $this->jsonError('Masukkan 6 digit kode verifikasi.');
            return;
        }

        $row = $this->db->query(
            'SELECT * FROM otp_log WHERE idjemaat = ? AND tipe = ? AND verified = 0 ORDER BY created_at DESC LIMIT 1',
            array($idjemaat, $tipe)
        )->row();

        if (!$row) {
            $this->jsonError('Kode tidak ditemukan. Silakan minta kode baru.');
            return;
        }

        if (strtotime($row->expired_at) < time()) {
            $this->jsonError('Kode sudah kadaluarsa. Silakan minta kode baru.');
            return;
        }

        if ((int) $row->percobaan_salah >= self::OTP_MAKS_SALAH) {
            $this->jsonError('Terlalu banyak percobaan salah. Silakan minta kode baru.');
            return;
        }

        if (!password_verify($otp, $row->otp_hash)) {
            $this->db->query('UPDATE otp_log SET percobaan_salah = percobaan_salah + 1 WHERE id = ?', array($row->id));
            $this->jsonError('Kode salah. Silakan periksa kembali.');
            return;
        }

        // Nama kolom diambil dari konstanta, bukan dari input
        $kolom = self::KOLOM_VERIFIKASI[$tipe];

        $this->db->trans_start();
        $this->db->query('UPDATE otp_log SET verified = 1 WHERE id = ?', array($row->id));
        $this->db->query("UPDATE jemaat SET {$kolom} = 1 WHERE idjemaat = ?", array($idjemaat));
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'Registrasi::verifikasi gagal untuk idjemaat=' . $idjemaat);
            $this->jsonError('Verifikasi gagal disimpan. Silakan coba lagi.');
            return;
        }

        $this->jsonSuccess(array('msg' => 'Verifikasi berhasil.'));
    }

    // POST /api/registrasi/kirim-ulang  (idjemaat, tipe: wa|email)
    public function kirimUlang()
    {
        $tipe = $this->_tipe();
        if ($tipe === null) {
            $this->jsonError('Jenis verifikasi tidak valid.');
            return;
        }

        $idjemaat = $this->_idDariEncrypt($this->input->post('idjemaat'));
        if ($idjemaat === null) {
            $this->jsonError('Data verifikasi tidak valid. Silakan ulangi pendaftaran.');
            return;
        }

        // Jeda minimal antar kiriman, dicek di server
        $terakhir = $this->db->query(
            'SELECT created_at FROM otp_log WHERE idjemaat = ? AND tipe = ? ORDER BY created_at DESC LIMIT 1',
            array($idjemaat, $tipe)
        )->row();

        if ($terakhir && (time() - strtotime($terakhir->created_at)) < self::OTP_JEDA_DETIK) {
            $this->jsonError('Mohon tunggu sebentar sebelum meminta kode baru.');
            return;
        }

        $jemaat = $this->db->query('SELECT namalengkap, nohp, email FROM jemaat WHERE idjemaat = ? LIMIT 1', array($idjemaat))->row();
        if (!$jemaat) {
            $this->jsonError('Data akun tidak ditemukan.');
            return;
        }

        $tujuan = $tipe === 'wa' ? $jemaat->nohp : $jemaat->email;

        // Batas OTP per nomor/email per hari, untuk mencegah spam biaya WhatsApp
        if ($this->_sudahMelebihiBatasOtp($tipe, $tujuan)) {
            $this->jsonError('Batas pengiriman kode hari ini sudah tercapai. Silakan coba lagi besok, atau hubungi hotline gereja WhatsApp 085550001187.');
            return;
        }

        if (!$this->_buatDanKirimOtp($idjemaat, $tipe, $tujuan, $jemaat->namalengkap)) {
            $this->jsonError('Gagal mengirim kode. Silakan coba lagi beberapa saat lagi.');
            return;
        }

        $this->jsonSuccess(array('msg' => 'Kode baru telah dikirim.'));
    }

    // ============================================================
    // Helper
    // ============================================================

    // Field NIK, tempat lahir, dan alamat hanya wajib untuk "Sudah Pernah".
    // Persetujuan syarat dan ketentuan wajib dikirim sebagai setujui = '1'.
    private function _validasiData(&$err)
    {
        $get = function ($k) {
            return trim((string) $this->input->post($k));
        };

        if ($get('setujui') !== '1') {
            $err = 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.';
            return null;
        }

        $pernah = $get('sudahpernahfondationclass');
        if (!in_array($pernah, array('Sudah', 'Belum'), true)) {
            $err = 'Pilih apakah Anda sudah pernah memiliki Kartu Anggota Jemaat.';
            return null;
        }
        $sudah = $pernah === 'Sudah';

        $nama = $get('namalengkap');
        $nik = $get('nik');
        $jk = $get('jeniskelamin');
        $tempat = $get('tempatlahir');
        $tgl = $get('tanggallahir');
        $alamat = $get('alamatrumah');
        $hp = $get('nohp');
        $email = $get('email');
        $pw = (string) $this->input->post('password');
        $pw2 = (string) $this->input->post('password2');

        if ($nama === '' || mb_strlen($nama) > 150) {
            $err = 'Nama lengkap wajib diisi (maksimal 150 karakter).';
            return null;
        }
        if ($sudah && !preg_match('/^[0-9]{16}$/', $nik)) {
            $err = 'NIK harus 16 digit angka.';
            return null;
        }
        if (!in_array($jk, array('Laki-laki', 'Perempuan'), true)) {
            $err = 'Pilih jenis kelamin.';
            return null;
        }
        if ($sudah && ($tempat === '' || mb_strlen($tempat) > 100)) {
            $err = 'Tempat lahir wajib diisi (maksimal 100 karakter).';
            return null;
        }
        if (!preg_match(self::PATTERN_TGL, $tgl)) {
            $err = 'Tanggal lahir tidak valid.';
            return null;
        }
        list($y, $m, $d) = explode('-', $tgl);
        if (!checkdate((int) $m, (int) $d, (int) $y)) {
            $err = 'Tanggal lahir tidak valid.';
            return null;
        }
        if ($sudah && ($alamat === '' || mb_strlen($alamat) > 255)) {
            $err = 'Alamat rumah wajib diisi (maksimal 255 karakter).';
            return null;
        }
        if (!preg_match(self::PATTERN_HP, $hp)) {
            $err = 'Format nomor WhatsApp tidak valid (08xxxxxxxxxx).';
            return null;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $err = 'Format email tidak valid.';
            return null;
        }
        if (mb_strlen($pw) < 6 || mb_strlen($pw) > 72) {
            $err = 'Password minimal 6 karakter.';
            return null;
        }
        if ($pw !== $pw2) {
            $err = 'Ulangi password tidak sama.';
            return null;
        }

        return array(
            'namalengkap' => $nama,
            'nik' => $sudah ? $nik : null,
            'jeniskelamin' => $jk,
            'tempatlahir' => $sudah ? $tempat : null,
            'tanggallahir' => $tgl,
            'alamatrumah' => $sudah ? $alamat : null,
            'nohp' => $hp,
            'email' => $email,
            'password' => $pw,
            'sudahpernah' => $pernah,
        );
    }

    private function _akunPemakai($field, $nilai)
    {
        // $field hanya 'email' atau 'nohp' dari kode, tidak dari input
        return $this->db->query(
            "SELECT idjemaat, statusverifikasiemail, statusverifikasiwa FROM jemaat WHERE {$field} = ? LIMIT 1",
            array($nilai)
        )->row();
    }

    private function _sudahVerifikasi($row)
    {
        return (string) $row->statusverifikasiemail === '1' || (string) $row->statusverifikasiwa === '1';
    }

    private function _tipe()
    {
        $t = trim((string) $this->input->post('tipe'));
        return in_array($t, array('wa', 'email'), true) ? $t : null;
    }

    // ID jemaat dikirim ke aplikasi dalam bentuk terenkripsi, sama seperti web
    private function _idDariEncrypt($raw)
    {
        $id = $this->encrypt->decode((string) $raw);
        if (!is_string($id) || !preg_match(self::PATTERN_ID, $id)) {
            return null;
        }

        $ada = $this->db->query('SELECT idjemaat FROM jemaat WHERE idjemaat = ? LIMIT 1', array($id))->row();
        return $ada ? $ada->idjemaat : null;
    }

    // Menghitung OTP yang sudah terkirim ke satu tujuan dalam 24 jam terakhir
    private function _sudahMelebihiBatasOtp($tipe, $tujuan)
    {
        $jumlah = (int) $this->db->query(
            'SELECT COUNT(*) AS jml FROM otp_log WHERE tipe = ? AND tujuan = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)',
            array($tipe, $tujuan)
        )->row()->jml;

        return $jumlah >= self::MAKS_OTP_PER_TUJUAN_PER_HARI;
    }

    private function _buatDanKirimOtp($idjemaat, $tipe, $tujuan, $nama)
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => $tipe,
            'tujuan' => $tujuan,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'verified' => 0,
            'percobaan_salah' => 0,
            'ip_address' => $this->input->ip_address(),
            'created_at' => date('Y-m-d H:i:s'),
        ));

        return $tipe === 'email'
            ? $this->_kirimEmail($tujuan, $nama, $otp)
            : $this->_kirimWa($tujuan, $nama, $otp);
    }

    private function _kirimEmail($tujuan, $nama, $otp)
    {
        $html = '<h4>Shalom! ' . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') . ', Welcome to myesc!</h4>'
            . '<p>Kode verifikasi email kamu:</p>'
            . '<h2 style="letter-spacing:6px;">' . $otp . '</h2>'
            . '<p>Masukkan kode ini di aplikasi untuk menyelesaikan proses. Kode berlaku 10 menit.</p>'
            . '<p>Terima Kasih,</p><p>GBI EL SHADDAI</p>';

        // Warning SMTP diubah jadi exception agar tidak bocor ke respons JSON
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            $this->App->sendEmailDaftar($tujuan, 'Kode Verifikasi Email - MyESC', $html);
            restore_error_handler();
            return true;
        } catch (\Throwable $e) {
            restore_error_handler();
            log_message('error', 'Registrasi: gagal kirim OTP email - ' . $e->getMessage());
            return false;
        }
    }

    private function _kirimWa($nohp, $nama, $otp)
    {
        $pesan = 'Shalom ' . $nama . "! Welcome to myesc! Kode verifikasi WhatsApp kamu: *" . $otp . "*\n\n"
            . 'Masukkan kode ini di aplikasi untuk menyelesaikan proses. Kode berlaku 10 menit.';

        try {
            return (bool) $this->whatsapp->send_message(formatNomorWhatsapp($nohp), $pesan);
        } catch (\Throwable $e) {
            log_message('error', 'Registrasi: gagal kirim OTP WA - ' . $e->getMessage());
            return false;
        }
    }
}

/* End of file Registrasi.php */
/* Location: ./application/controllers/api/Registrasi.php */