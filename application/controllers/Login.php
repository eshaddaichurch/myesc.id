<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function keluar()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }

    private function cekRecaptcha($token)
    {
        $secret = '6Lee0W8tAAAAAHV9JHkL5WlMVfdYVL9gs9ApJbDd';

        if (empty($token)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'secret' => $secret,
            'response' => $token,
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            log_message('error', 'reCAPTCHA verify gagal diakses (curl error)');
            return true;  // jangan block user kalau Google API tidak bisa diakses
        }

        $result = json_decode($response);

        log_message('debug', 'reCAPTCHA result: ' . json_encode($result));

        return isset($result->success) && $result->success && isset($result->score) && $result->score >= 0.5;
    }

    public function index()
    {
        $idjemaat = $this->session->userdata('idjemaat');
        if (!empty($idjemaat)) {
            redirect(site_url());
        } else {
            $this->load->view('login');
        }
    }

    public function cekLoginAjax()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (empty($email) and empty($password)) {
            echo json_encode(array('msg' => 'Email atau password tidak boleh kosong'));
        } else {
            $kirim = $this->Login_model->cekLoginAjax($email, md5($password));
            if ($kirim->num_rows() > 0) {
                $result = $kirim->row();

                // check email atau nomor whatsapp
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($result->statusverifikasiemail == 0) {
                        echo json_encode(array('msg' => 'Email anda belum di verifikasi.'));
                        exit();
                    }
                } else {
                    if ($result->statusverifikasiwa == 0) {
                        echo json_encode(array('msg' => 'Nomor whatsapp anda belum di verifikasi.'));
                        exit();
                    }
                }

                $this->App->reloadSession($result->idjemaat);

                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => 'Password atau Email anda salah. harap periksa lagi'));
            }
        }
    }

    public function simpanregistrasi()
    {
        // === RATE LIMIT: maksimal 3 percobaan registrasi per IP per jam ===
        $ip = $this->input->ip_address();
        $countIp = $this->db->query('
            SELECT COUNT(*) as jumlah FROM registrasi_log
            WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ', array($ip))->row()->jumlah;

        if ($countIp >= 3) {
            echo json_encode(array('msg' => 'Terlalu banyak percobaan pendaftaran dari perangkat/koneksi ini. Silakan coba lagi dalam 1 jam, atau hubungi hotline gereja WhatsApp 085550001187.'));
            exit();
        }

        // === CEK reCAPTCHA ===
        $recaptchaToken = $this->input->post('g-recaptcha-response');
        if (!$this->cekRecaptcha($recaptchaToken)) {
            echo json_encode(array('msg' => 'Verifikasi keamanan gagal, silakan muat ulang halaman dan coba lagi.'));
            exit();
        }

        $namalengkap = $this->input->post('namalengkap');
        $nik = $this->input->post('nik');
        $jeniskelamin = $this->input->post('jeniskelamin');
        $tempatlahir = $this->input->post('tempatlahir');
        $tanggallahir = $this->input->post('tanggallahir');
        $alamatrumah = $this->input->post('alamatrumah');
        $nohp = $this->input->post('nohp');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $alasanmembuatakun = $this->input->post('alasanmembuatakun');
        $sudahpernahfondationclass = $this->input->post('sudahpernahfondationclass');
        $tanggalinsert = date('Y-m-d H:i:s');

        // === Tentukan dulu apakah ini kasus MERGE (NIK + tanggal lahir cocok dengan data lama) ===
        // Ini harus dihitung SEBELUM cek email/nohp duplikat, supaya baris yang jadi
        // target merge tidak ikut kena tolak sebagai "sudah pernah terdaftar".
        $idjemaatMerge = null;
        $sudahAdaNIK = false;
        $sudahAdaNIKTgllahir = false;

        if ($alasanmembuatakun == 'Bergabung' && !empty($nik)) {
            $sudahAdaNIK = $this->Login_model->sudahAdaNIK($nik);
            $sudahAdaNIKTgllahir = $this->Login_model->sudahAdaNIKTgllahir($nik, $tanggallahir);

            if ($sudahAdaNIK && !$sudahAdaNIKTgllahir) {
                $pesan = "<script>
                    swal('Informasi', 'Nik tidak cocok dengan tanggal lahir anda.', 'warning');
                </script>";
                $this->session->set_flashdata('pesan', $pesan);
                redirect(site_url());
            }

            if ($sudahAdaNIKTgllahir) {
                $idjemaatMerge = $this->Login_model->getIdJemaatByNIK($nik)->idjemaat;
            }
        }

        // === Cek Email — kecualikan baris target merge, hapus zombie yang belum pernah verified ===
        $cekEmail = $this->db->query('
            SELECT idjemaat, statusverifikasiemail, statusverifikasiwa FROM jemaat WHERE email = ?
        ', array($email))->row();

        if ($cekEmail && $cekEmail->idjemaat != $idjemaatMerge) {
            if ($cekEmail->statusverifikasiemail == 1 || $cekEmail->statusverifikasiwa == 1) {
                echo json_encode(array('msg' => 'Email ' . $email . ' sudah pernah terdaftar! Jika anda merasa belum pernah mendaftar hubungi hotline gereja WhatsApp 085550001187 untuk konfirmasi akun.'));
                exit();
            } else {
                // akun lama belum pernah diverifikasi sama sekali -> aman dihapus untuk registrasi ulang
                $this->db->query('DELETE FROM otp_log WHERE idjemaat = ?', array($cekEmail->idjemaat));
                $this->db->query('DELETE FROM carejemaatbaru WHERE idjemaat = ?', array($cekEmail->idjemaat));
                $this->db->query('DELETE FROM jemaat WHERE idjemaat = ?', array($cekEmail->idjemaat));
                log_message('debug', 'Akun zombie (email) dihapus untuk registrasi ulang: idjemaat=' . $cekEmail->idjemaat);
            }
        }

        // === Cek Nomor WA — kecualikan baris target merge, hapus zombie yang belum pernah verified ===
        $cekWa = $this->db->query('
            SELECT idjemaat, statusverifikasiemail, statusverifikasiwa FROM jemaat WHERE nohp = ?
        ', array($nohp))->row();

        if ($cekWa && $cekWa->idjemaat != $idjemaatMerge) {
            if ($cekWa->statusverifikasiemail == 1 || $cekWa->statusverifikasiwa == 1) {
                echo json_encode(array('msg' => 'Nomor Whatsapp ' . $nohp . ' sudah pernah terdaftar! Jika anda merasa belum pernah mendaftar hubungi hotline gereja WhatsApp 085550001187 untuk konfirmasi akun.'));
                exit();
            } else {
                $this->db->query('DELETE FROM otp_log WHERE idjemaat = ?', array($cekWa->idjemaat));
                $this->db->query('DELETE FROM carejemaatbaru WHERE idjemaat = ?', array($cekWa->idjemaat));
                $this->db->query('DELETE FROM jemaat WHERE idjemaat = ?', array($cekWa->idjemaat));
                log_message('debug', 'Akun zombie (WA) dihapus untuk registrasi ulang: idjemaat=' . $cekWa->idjemaat);
            }
        }

        if ($alasanmembuatakun == 'Bergabung') {
            if ($sudahAdaNIKTgllahir) {
                $idjemaat = $idjemaatMerge;

                $data = array(
                    'namalengkap' => $namalengkap,
                    'nik' => $nik,
                    'jeniskelamin' => $jeniskelamin,
                    'tempatlahir' => $tempatlahir,
                    'nohp' => $nohp,
                    'email' => $email,
                    'password' => md5($password),
                    'alasanmembuatakun' => $alasanmembuatakun,
                    'sudahpernahfondationclass' => $sudahpernahfondationclass,
                    'statusverifikasiwa' => 0,  // WAJIB: reset supaya OTP tetap diperlukan setelah merge
                    'statusverifikasiemail' => 0,  // WAJIB: reset supaya OTP tetap diperlukan setelah merge
                );

                $simpan = $this->Login_model->updateregistrasi($data, $idjemaat);
            } else {
                $idjemaat = $this->db->query("select create_idjemaat('" . $tanggalinsert . "') as idjemaat")->row()->idjemaat;

                $data = array(
                    'idjemaat' => $idjemaat,
                    'namalengkap' => $namalengkap,
                    'nik' => $nik,
                    'jeniskelamin' => $jeniskelamin,
                    'tempatlahir' => $tempatlahir,
                    'tanggallahir' => $tanggallahir,
                    'alamatrumah' => $alamatrumah,
                    'nohp' => $nohp,
                    'email' => $email,
                    'password' => md5($password),
                    'tanggalinsert' => $tanggalinsert,
                    'statusjemaat' => 'Umum',
                    'alasanmembuatakun' => $alasanmembuatakun,
                    'sudahpernahfondationclass' => $sudahpernahfondationclass,
                );

                $simpan = $this->Login_model->simpanregistrasi($data);
            }
        } else {
            $sudahpernahfondationclass = 'NULL';

            $idjemaat = $this->db->query("select create_idjemaat('" . $tanggalinsert . "') as idjemaat")->row()->idjemaat;

            $data = array(
                'idjemaat' => $idjemaat,
                'namalengkap' => $namalengkap,
                'nik' => $nik,
                'jeniskelamin' => $jeniskelamin,
                'tempatlahir' => $tempatlahir,
                'tanggallahir' => $tanggallahir,
                'alamatrumah' => $alamatrumah,
                'nohp' => $nohp,
                'email' => $email,
                'password' => md5($password),
                'tanggalinsert' => $tanggalinsert,
                'statusjemaat' => 'Umum',
                'alasanmembuatakun' => $alasanmembuatakun,
                'sudahpernahfondationclass' => $sudahpernahfondationclass,
            );

            $simpan = $this->Login_model->simpanregistrasi($data);
        }

        if ($simpan) {
            // === CATAT LOG REGISTRASI untuk rate limiting ===
            $this->db->insert('registrasi_log', array(
                'ip_address' => $ip,
                'nohp' => $nohp,
                'created_at' => date('Y-m-d H:i:s'),
            ));

            // FIX: catat SEMUA pendaftaran akun yang berhasil ke carejemaatbaru,
            // sebagai record/log pendaftaran (tanpa syarat alasanmembuatakun atau
            // sudahpernahfondationclass, karena tabel ini sekarang berfungsi sebagai
            // log jumlah pendaftar, bukan alur approval admin).
            $dataCareJemaatBaru = array(
                'tglinsert' => date('Y-m-d H:i:s'),
                'idjemaat' => $idjemaat,
                'status' => 'Registered',  // penanda: otomatis terdaftar, tidak menunggu approval admin
                'idadmin' => null,
            );
            $simpanCare = $this->Login_model->kirimKeCare($dataCareJemaatBaru);

            // FIX: kalau insert record gagal, catat ke log server supaya ketahuan,
            // tanpa mengganggu proses pendaftaran akun user (yang sudah pasti berhasil
            // di titik ini karena $simpan sudah true).
            if (!$simpanCare) {
                $errCare = $this->db->error();
                log_message('error', 'Gagal insert carejemaatbaru untuk idjemaat=' . $idjemaat . ' - ' . json_encode($errCare));
            }

            // === GENERATE & KIRIM OTP EMAIL (ganti dari link ke kode) ===
            $otpEmail = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $this->db->insert('otp_log', array(
                'idjemaat' => $idjemaat,
                'tipe' => 'email',
                'tujuan' => $email,
                'otp_hash' => password_hash($otpEmail, PASSWORD_DEFAULT),
                'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                'verified' => 0,
                'percobaan_salah' => 0,
                'ip_address' => $ip,
                'created_at' => date('Y-m-d H:i:s'),
            ));

            $textemail =
                '<h4>Shalom! ' . $namalengkap . ', Welcome to myesc! </h4>
                <p>Kode verifikasi email kamu:</p>
                <h2 style="letter-spacing:6px;">' . $otpEmail . '</h2>
                <p>Masukkan kode ini di halaman pendaftaran untuk menyelesaikan proses. Kode berlaku 10 menit.</p>
                <p>Terima Kasih,</p>
                <p>GBI EL SHADDAI</p>
                ';

            if (!isLocalhost()) {
                $this->App->sendEmailDaftar($email, 'Kode Verifikasi Email - MyESC', $textemail);
            } else {
                log_message('debug', 'OTP EMAIL (localhost, tidak benar-benar dikirim): ' . $otpEmail);
            }

            // === GENERATE & KIRIM OTP WA (ganti dari link ke kode) ===
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $this->db->insert('otp_log', array(
                'idjemaat' => $idjemaat,
                'tipe' => 'wa',
                'tujuan' => $nohp,
                'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
                'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                'verified' => 0,
                'percobaan_salah' => 0,
                'ip_address' => $ip,
                'created_at' => date('Y-m-d H:i:s'),
            ));

            $pesanWA = 'Shalom ' . $namalengkap . '! Welcome to myesc! Kode verifikasi WhatsApp kamu: *' . $otp . "*\n\nMasukkan kode ini di halaman pendaftaran untuk menyelesaikan proses. Kode berlaku 10 menit.";

            try {
                $this->whatsapp->send_message(formatNomorWhatsapp($nohp), $pesanWA);
            } catch (\Throwable $e) {
                // WA gateway belum tersambung / bermasalah: jangan gagalkan registrasi
                log_message('error', 'Gagal kirim OTP WA (gateway belum tersambung?): ' . $e->getMessage());
                log_message('debug', 'OTP WA (fallback log): ' . $otp);
            }

            echo json_encode(array(
                'success' => true,
                'idjemaat' => $this->encrypt->encode($idjemaat),
            ));
        } else {
            $eror = $this->db->error();
            log_message('error', 'simpanregistrasi gagal: ' . json_encode($eror));
            echo json_encode(array('msg' => 'Data gagal disimpan. Silakan coba lagi atau hubungi admin.'));
        }
    }

    public function verifikasiOtpWa()
    {
        $idjemaatEnc = $this->input->post('idjemaat');
        $otpInput = $this->input->post('otp');

        $idjemaat = $this->encrypt->decode($idjemaatEnc);

        if (empty($idjemaat) || empty($otpInput)) {
            echo json_encode(array('msg' => 'Data tidak lengkap.'));
            exit();
        }

        $row = $this->db->query('
            SELECT * FROM otp_log
            WHERE idjemaat = ? AND tipe = "wa" AND verified = 0
            ORDER BY created_at DESC LIMIT 1
        ', array($idjemaat))->row();

        if (!$row) {
            echo json_encode(array('msg' => 'Kode OTP tidak ditemukan. Silakan minta kode baru.'));
            exit();
        }

        if (strtotime($row->expired_at) < time()) {
            echo json_encode(array('msg' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.'));
            exit();
        }

        if ($row->percobaan_salah >= 5) {
            echo json_encode(array('msg' => 'Terlalu banyak percobaan salah. Silakan minta kode baru.'));
            exit();
        }

        if (!password_verify($otpInput, $row->otp_hash)) {
            $this->db->query('
                UPDATE otp_log SET percobaan_salah = percobaan_salah + 1 WHERE id = ?
            ', array($row->id));

            echo json_encode(array('msg' => 'Kode OTP salah. Silakan periksa kembali.'));
            exit();
        }

        // OTP benar: tandai verified + update status di tabel jemaat
        $this->db->query('
            UPDATE otp_log SET verified = 1 WHERE id = ?
        ', array($row->id));

        $this->db->query('
            UPDATE jemaat SET statusverifikasiwa = "1" WHERE idjemaat = ?
        ', array($idjemaat));

        echo json_encode(array('success' => true));
    }

    public function kirimUlangOtpWa()
    {
        $idjemaatEnc = $this->input->post('idjemaat');
        $idjemaat = $this->encrypt->decode($idjemaatEnc);

        if (empty($idjemaat)) {
            echo json_encode(array('msg' => 'Data tidak lengkap.'));
            exit();
        }

        $rowJemaat = $this->db->query('
            SELECT * FROM jemaat WHERE idjemaat = ?
        ', array($idjemaat))->row();

        if (!$rowJemaat) {
            echo json_encode(array('msg' => 'Data akun tidak ditemukan.'));
            exit();
        }

        // rate limit: minimal jeda 60 detik antar kirim ulang
        $lastOtp = $this->db->query('
            SELECT created_at FROM otp_log
            WHERE idjemaat = ? AND tipe = "wa"
            ORDER BY created_at DESC LIMIT 1
        ', array($idjemaat))->row();

        if ($lastOtp && (time() - strtotime($lastOtp->created_at)) < 60) {
            echo json_encode(array('msg' => 'Mohon tunggu sebentar sebelum meminta kode baru.'));
            exit();
        }

        $ip = $this->input->ip_address();
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => 'wa',
            'tujuan' => $rowJemaat->nohp,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'verified' => 0,
            'percobaan_salah' => 0,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ));

        $pesanWA = 'Shalom ' . $rowJemaat->namalengkap . '! Kode verifikasi WhatsApp kamu: *' . $otp . "*\n\nBerlaku 10 menit.";

        try {
            $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal kirim ulang OTP WA (gateway belum tersambung?): ' . $e->getMessage());
            log_message('debug', 'OTP WA resend (fallback log): ' . $otp);
        }

        echo json_encode(array('success' => true));
    }

    public function verifikasiOtpEmail()
    {
        $idjemaatEnc = $this->input->post('idjemaat');
        $otpInput = $this->input->post('otp');

        $idjemaat = $this->encrypt->decode($idjemaatEnc);

        if (empty($idjemaat) || empty($otpInput)) {
            echo json_encode(array('msg' => 'Data tidak lengkap.'));
            exit();
        }

        $row = $this->db->query('
            SELECT * FROM otp_log
            WHERE idjemaat = ? AND tipe = "email" AND verified = 0
            ORDER BY created_at DESC LIMIT 1
        ', array($idjemaat))->row();

        if (!$row) {
            echo json_encode(array('msg' => 'Kode OTP tidak ditemukan. Silakan minta kode baru.'));
            exit();
        }

        if (strtotime($row->expired_at) < time()) {
            echo json_encode(array('msg' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.'));
            exit();
        }

        if ($row->percobaan_salah >= 5) {
            echo json_encode(array('msg' => 'Terlalu banyak percobaan salah. Silakan minta kode baru.'));
            exit();
        }

        if (!password_verify($otpInput, $row->otp_hash)) {
            $this->db->query('
                UPDATE otp_log SET percobaan_salah = percobaan_salah + 1 WHERE id = ?
            ', array($row->id));

            echo json_encode(array('msg' => 'Kode OTP salah. Silakan periksa kembali.'));
            exit();
        }

        $this->db->query('UPDATE otp_log SET verified = 1 WHERE id = ?', array($row->id));
        $this->db->query('UPDATE jemaat SET statusverifikasiemail = "1" WHERE idjemaat = ?', array($idjemaat));

        echo json_encode(array('success' => true));
    }

    public function kirimUlangOtpEmail()
    {
        $idjemaatEnc = $this->input->post('idjemaat');
        $idjemaat = $this->encrypt->decode($idjemaatEnc);

        if (empty($idjemaat)) {
            echo json_encode(array('msg' => 'Data tidak lengkap.'));
            exit();
        }

        $rowJemaat = $this->db->query('SELECT * FROM jemaat WHERE idjemaat = ?', array($idjemaat))->row();

        if (!$rowJemaat) {
            echo json_encode(array('msg' => 'Data akun tidak ditemukan.'));
            exit();
        }

        $lastOtp = $this->db->query('
            SELECT created_at FROM otp_log
            WHERE idjemaat = ? AND tipe = "email"
            ORDER BY created_at DESC LIMIT 1
        ', array($idjemaat))->row();

        if ($lastOtp && (time() - strtotime($lastOtp->created_at)) < 60) {
            echo json_encode(array('msg' => 'Mohon tunggu sebentar sebelum meminta kode baru.'));
            exit();
        }

        $ip = $this->input->ip_address();
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => 'email',
            'tujuan' => $rowJemaat->email,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'expired_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'verified' => 0,
            'percobaan_salah' => 0,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ));

        $textemail =
            '<h4>Shalom! ' . $rowJemaat->namalengkap . ', kode verifikasi baru kamu:</h4>
            <h2 style="letter-spacing:6px;">' . $otp . '</h2>
            <p>Berlaku 10 menit.</p>';

        if (!isLocalhost()) {
            $this->App->sendEmailDaftar($rowJemaat->email, 'Kode Verifikasi Email - MyESC', $textemail);
        } else {
            log_message('debug', 'OTP EMAIL resend (localhost): ' . $otp);
        }

        echo json_encode(array('success' => true));
    }

    public function verifikasiemail($email)
    {
        $email = $this->encrypt->decode($email);

        /* Periksa Email */
        if ($this->Login_model->emailsudahada($email)) {
            $simpan = $this->db->query('update jemaat set statusverifikasiemail = "1" where email = ?', array($email));
            if ($simpan) {
                $pesan = "<script>
                                    swal('Berhasil', 'Email anda berhasil di verifikasi.', 'success');
                          </script>";
            } else {
                $pesan = "<script>swal('Maaf', 'Email gagal di verifikasi. Silahkan coba lagi.', 'error')</script>";
            }
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url());
        } else {
            $pesan = "<script>
                            swal('Sorry', 'Email not found.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url());
        }
    }

    public function verifikasiwa($nomorwa)
    {
        $nomorwa = $this->encrypt->decode($nomorwa);

        /* Periksa Wa */
        if ($this->Login_model->whatsappsudahada($nomorwa)) {
            $simpan = $this->db->query('update jemaat set statusverifikasiwa = "1" where nohp = ?', array($nomorwa));
            if ($simpan) {
                $pesan = "<script>
                                    swal('Congrats', 'Nomor whatsapp anda berhasil di verifikasi.', 'success');
                          </script>";
            } else {
                $pesan = "<script>swal('Sorry', 'Nomor whatsapp anda gagal diverifikasi. silahkan ulangi beberapa saat kemudian!', 'error')</script>";
            }
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url());
        } else {
            $pesan = "<script>
                            swal('Sorry', 'Whatsapp number not found.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url());
        }
    }

    public function kirimKodeResetPassword()
    {
        $email = $this->input->post('email');

        $kirim = $this->Login_model->kirimKodeResetPassword($email);

        echo json_encode($kirim);
    }

    public function cekTokenResetPassword()
    {
        $email = $this->input->post('email');
        $tokenResetPassword = $this->input->post('tokenResetPassword');

        $kirim = $this->Login_model->cekTokenResetPassword($email, $tokenResetPassword);

        echo json_encode($kirim);
    }

    public function updateResetPassword()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $kirim = $this->Login_model->updateResetPassword($email, $password);

        echo json_encode($kirim);
    }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
