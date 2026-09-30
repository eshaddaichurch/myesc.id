<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    // Masa berlaku token reset password (menit) & batas tebakan salah
    const RESET_TOKEN_MENIT = 15;
    const RESET_MAKS_SALAH = 5;

    // public function cekLoginAjax($email, $password)
    // {
    //     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $field = 'email';
    //     } else {
    //         $email = preg_replace('/[^0-9]/', '', $email);
    //         $field = 'nohp';
    //     }

    //     // $field aman ditempel langsung karena nilainya hardcoded dari logic PHP di atas,
    //     // bukan dari input user secara langsung. $email & $password tetap di-bind.
    //     return $this->db->query("SELECT * FROM jemaat WHERE $field = ? AND password = ?", array($email, $password));
    // }

    public function cekLoginAjax($email, $password)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $email = preg_replace('/[^0-9]/', '', $email);
            $field = 'nohp';
        }

        return $this->db->query("SELECT * FROM v_jemaat WHERE $field = ? AND password = ?", array($email, $password));
    }

    public function simpanregistrasi($data)
    {
        return $this->db->insert('jemaat', $data);
    }

    public function emailsudahada($email)
    {
        $this->db->where('email', $email);
        $rsCekEmail = $this->db->get('jemaat');
        return $rsCekEmail->num_rows() > 0;
    }

    public function nomorwasudahada($nohp)
    {
        $this->db->where('nohp', $nohp);
        $rsCekNoHP = $this->db->get('jemaat');
        return $rsCekNoHP->num_rows() > 0;
    }

    public function whatsappsudahada($nomorwa)
    {
        $this->db->where('nohp', $nomorwa);
        $rsCekWa = $this->db->get('jemaat');
        return $rsCekWa->num_rows() > 0;
    }

    public function sudahAdaNIK($nik)
    {
        $query = $this->db->query('SELECT * FROM jemaat WHERE nik = ?', array($nik));
        return $query->num_rows() > 0;
    }

    public function sudahAdaNIKTgllahir($nik, $tanggallahir)
    {
        $query = $this->db->query('
            SELECT * FROM jemaat WHERE nik = ? AND tanggallahir = ?
        ', array($nik, date('Y-m-d', strtotime($tanggallahir))));
        return $query->num_rows() > 0;
    }

    public function getIdJemaatByNIK($nik)
    {
        return $this->db->query('SELECT * FROM jemaat WHERE nik = ?', array($nik))->row();
    }

    public function updateregistrasi($data, $idjemaat)
    {
        $this->db->where('idjemaat', $idjemaat);
        return $this->db->update('jemaat', $data);
    }

    public function kirimKeCare($dataCareJemaatBaru)
    {
        return $this->db->insert('carejemaatbaru', $dataCareJemaatBaru);
    }

    /**
     * FIX: sama seperti kirimEmailAman() di Login.php controller.
     * Warning PHP dari fsockopen (misal DNS/SMTP belum siap) diubah jadi
     * Exception supaya bisa ditangkap try-catch, tidak bocor ke output,
     * dan tidak menghentikan alur reset password.
     */
    private function kirimEmailAman($email, $subject, $textemail, $fallbackLogLabel = '')
    {
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            $this->App->sendEmailDaftar($email, $subject, $textemail);
            restore_error_handler();
            return true;
        } catch (\Throwable $e) {
            restore_error_handler();
            log_message('error', 'Gagal kirim email (' . $fallbackLogLabel . '): ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Pastikan kolom jemaat.percobaantokensalah ada. Kalau belum, dibuat otomatis
     * (aman dipanggil berulang). Dengan begitu database lokal dan server tidak
     * perlu diubah manual satu per satu setelah git pull.
     *
     * Butuh hak ALTER pada user database. Kalau gagal, fitur reset password
     * ditolak (fail-closed) supaya tidak berjalan tanpa pembatas tebakan token.
     *
     * @return bool TRUE jika kolom tersedia
     */
    private function pastikanKolomReset()
    {
        static $sudahAda = false;
        if ($sudahAda) {
            return true;
        }

        $cek = "SHOW COLUMNS FROM jemaat LIKE 'percobaantokensalah'";

        if ($this->db->query($cek)->num_rows() > 0) {
            return $sudahAda = true;
        }

        // Matikan sementara db_debug supaya error ALTER tidak menampilkan halaman error CI
        $debugLama = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->query('ALTER TABLE jemaat ADD COLUMN percobaantokensalah INT NOT NULL DEFAULT 0');
        $this->db->db_debug = $debugLama;

        if ($this->db->query($cek)->num_rows() > 0) {
            log_message('info', 'Kolom jemaat.percobaantokensalah dibuat otomatis.');
            return $sudahAda = true;
        }

        log_message('error', 'Kolom jemaat.percobaantokensalah tidak ada dan gagal dibuat otomatis. Jalankan: ALTER TABLE jemaat ADD COLUMN percobaantokensalah INT NOT NULL DEFAULT 0;');
        return false;
    }

    /**
     * Tentukan kolom pencarian (email / nohp) dari input user.
     * Nomor HP dinormalisasi ke format 08xxxxxxxxxx (sama seperti saat registrasi).
     *
     * @return array [$field, $nilai]
     */
    private function tentukanFieldReset($input)
    {
        $input = trim((string) $input);

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return array('email', $input);
        }

        $nomor = preg_replace('/[^0-9]/', '', $input);
        if (strpos($nomor, '62') === 0) {
            $nomor = '0' . substr($nomor, 2);
        }

        return array('nohp', $nomor);
    }

    /**
     * Verifikasi token reset password: harus ada, belum kedaluwarsa,
     * belum melewati batas tebakan salah, dan cocok.
     * Tebakan salah dihitung di database (kolom percobaantokensalah).
     *
     * @return array ['success' => bool, 'msg' => string, 'idjemaat' => string|null]
     */
    private function verifikasiTokenReset($input, $token)
    {
        list($field, $nilai) = $this->tentukanFieldReset($input);
        $token = preg_replace('/[^0-9]/', '', (string) $token);

        $pesanUmum = 'Token reset password tidak valid. Silakan minta kode baru.';

        if (!$this->pastikanKolomReset()) {
            return array('success' => false, 'msg' => 'Fitur reset password sedang tidak tersedia. Silakan hubungi admin.', 'idjemaat' => null);
        }

        if ($nilai === '' || $token === '') {
            return array('success' => false, 'msg' => $pesanUmum, 'idjemaat' => null);
        }

        $row = $this->db->query(
            "SELECT idjemaat, tokenlupapassword, tgltokenlupapassword, percobaantokensalah
             FROM jemaat WHERE $field = ?",
            array($nilai)
        )->row();

        // Akun tidak ada / belum pernah minta token / token sudah dipakai
        if (!$row || empty($row->tokenlupapassword) || empty($row->tgltokenlupapassword)) {
            return array('success' => false, 'msg' => $pesanUmum, 'idjemaat' => null);
        }

        // Kedaluwarsa
        $umurDetik = time() - strtotime($row->tgltokenlupapassword);
        if ($umurDetik > self::RESET_TOKEN_MENIT * 60) {
            return array('success' => false, 'msg' => 'Token sudah kadaluarsa. Silakan minta kode baru.', 'idjemaat' => null);
        }

        // Terlalu banyak tebakan salah
        if ((int) $row->percobaantokensalah >= self::RESET_MAKS_SALAH) {
            return array('success' => false, 'msg' => 'Terlalu banyak percobaan salah. Silakan minta kode baru.', 'idjemaat' => null);
        }

        // Cocokkan token (perbandingan aman)
        if (!hash_equals((string) $row->tokenlupapassword, $token)) {
            $this->db->query(
                'UPDATE jemaat SET percobaantokensalah = percobaantokensalah + 1 WHERE idjemaat = ?',
                array($row->idjemaat)
            );
            return array('success' => false, 'msg' => 'Token reset password salah.', 'idjemaat' => null);
        }

        return array('success' => true, 'msg' => '', 'idjemaat' => $row->idjemaat);
    }

    public function kirimKodeResetPassword($email)
    {
        try {
            list($field, $email) = $this->tentukanFieldReset($email);

            // $field hardcoded dari logic PHP, aman ditempel; $email di-bind
            $rsJemaat = $this->db->query("SELECT * FROM jemaat WHERE $field = ?", array($email));

            if ($rsJemaat->num_rows() == 0) {
                return array('success' => false, 'msg' => 'Email atau nomor whatsapp tidak ditemukan.');
            }

            $rowJemaat = $rsJemaat->row();

            // === RATE LIMIT 1: minimal jeda 60 detik antar permintaan reset ===
            if (!empty($rowJemaat->tgltokenlupapassword)) {
                $selisihDetik = time() - strtotime($rowJemaat->tgltokenlupapassword);
                if ($selisihDetik < 60) {
                    return array('success' => false, 'msg' => 'Mohon tunggu sebentar sebelum meminta kode baru.');
                }
            }

            // === RATE LIMIT 2: maksimal 5x permintaan reset per jam per jemaat ===
            $countReset = $this->db->query('
                SELECT COUNT(*) as jumlah FROM jemaatresetpassword
                WHERE idjemaat = ? AND tgltokenlupapassword > DATE_SUB(NOW(), INTERVAL 1 HOUR)
            ', array($rowJemaat->idjemaat))->row()->jumlah;

            if ($countReset >= 5) {
                return array('success' => false, 'msg' => 'Terlalu banyak percobaan reset password. Silakan coba lagi dalam 1 jam, atau hubungi hotline gereja WhatsApp 085550001187.');
            }

            // email harus sudah diverifikasi sebelumnya
            if ($field == 'email') {
                if ($rowJemaat->statusverifikasiemail == 0) {
                    return array('success' => false, 'msg' => 'Email anda belum di verifikasi.');
                }
            }

            // whatsapp harus sudah diverifikasi sebelumnya
            if ($field == 'nohp') {
                if ($rowJemaat->statusverifikasiwa == 0) {
                    return array('success' => false, 'msg' => 'Nomor whatsapp anda belum di verifikasi.');
                }
            }

            // Pastikan kolom penghitung tebakan ada (dibuat otomatis kalau belum)
            if (!$this->pastikanKolomReset()) {
                return array('success' => false, 'msg' => 'Fitur reset password sedang tidak tersedia. Silakan hubungi admin.');
            }

            // Transaksi dimulai setelah semua validasi lolos
            $this->db->trans_begin();

            // random token 6 digit
            $idjemaat = $rowJemaat->idjemaat;
            $tokenlupapassword = random_int(100000, 999999);
            $dataToken = array(
                'tokenlupapassword' => $tokenlupapassword,
                'tgltokenlupapassword' => date('Y-m-d H:i:s'),
                'percobaantokensalah' => 0,  // token baru = hitungan salah mulai dari nol
            );
            $this->db->where('idjemaat', $idjemaat);
            $this->db->update('jemaat', $dataToken);

            $dataEmail = array(
                'idjemaat' => $idjemaat,
                'email' => $email,
                'tokenlupapassword' => $tokenlupapassword,
                'tgltokenlupapassword' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('jemaatresetpassword', $dataEmail);

            if ($field == 'email') {
                // kirim pesan email
                $pesanEmail = "
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    </head>
                    <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
                        <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f4f4f4; padding: 20px 0;'>
                            <tr>
                                <td align='center'>
                                    <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                                        <!-- Header -->
                                        <tr>
                                            <td style='background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0;'>
                                                <h1 style='color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;'>🔐 Reset Password</h1>
                                            </td>
                                        </tr>

                                        <!-- Content -->
                                        <tr>
                                            <td style='padding: 30px 40px;'>
                                                <p style='margin: 0 0 20px 0; font-size: 16px; line-height: 1.6; color: #333333;'>
                                                    Shalom <strong style='color: #2a5298;'>" . htmlspecialchars($rowJemaat->namalengkap) . "</strong>,
                                                </p>

                                                <p style='margin: 0 0 25px 0; font-size: 16px; line-height: 1.6; color: #555555;'>
                                                    Berikut adalah kode reset password untuk akun kamu:
                                                </p>

                                                <!-- Token Box -->
                                                <table width='100%' cellpadding='0' cellspacing='0'>
                                                    <tr>
                                                        <td style='background-color: #f8f9fa; border: 2px dashed #2a5298; border-radius: 8px; padding: 25px; text-align: center; margin: 20px 0;'>
                                                            <p style='margin: 0 0 10px 0; font-size: 14px; color: #666666; font-weight: 500;'>KODE RESET PASSWORD</p>
                                                            <h2 style='margin: 0; font-size: 32px; font-weight: 700; color: #1e3c72; letter-spacing: 3px;'>" . $tokenlupapassword . "</h2>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <p style='margin: 25px 0 15px 0; font-size: 14px; line-height: 1.6; color: #777777;'>
                                                    ⏰ <strong style='color: #ff6b6b;'>Kode ini berlaku selama 15 menit.</strong>
                                                </p>

                                                <p style='margin: 15px 0 0 0; font-size: 14px; line-height: 1.6; color: #777777;'>
                                                    Jika kamu tidak merasa mengirim permintaan mereset password, abaikan pesan ini.
                                                </p>
                                            </td>
                                        </tr>

                                        <!-- Footer -->
                                        <tr>
                                            <td style='background-color: #f8f9fa; padding: 20px 40px; border-radius: 0 0 8px 8px; text-align: center; border-top: 1px solid #e9ecef;'>
                                                <p style='margin: 0; font-size: 14px; color: #666666;'>
                                                    Terima kasih,<br>
                                                    <strong style='color: #2a5298;'>Tim GBI Elshaddai</strong>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Disclaimer -->
                                    <p style='margin-top: 20px; font-size: 12px; color: #999999;'>
                                        Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>
                    ";

                if (!isLocalhost()) {
                    // pakai helper aman supaya kalau SMTP gagal konek,
                    // warning PHP tidak bocor ke response JSON.
                    $emailTerkirim = $this->kirimEmailAman($email, 'Reset Password Myesc.id', $pesanEmail, 'reset password');
                    if (!$emailTerkirim) {
                        $this->db->trans_rollback();
                        return array('success' => false, 'msg' => 'Gagal mengirim kode ke email. Silakan coba lagi beberapa saat lagi.');
                    }
                } else {
                    // hanya untuk pengembangan lokal, tidak pernah tercatat di produksi
                    log_message('debug', 'Token reset password (localhost): ' . $tokenlupapassword);
                }
            } else {
                // kirim pesan whatsapp (via Fonnte)
                $pesanWA = "🔐 *RESET PASSWORD*\n\n"
                    . 'Shalom *' . $rowJemaat->namalengkap . "*!\n\n"
                    . "Berikut adalah kode reset password untuk akun kamu:\n\n"
                    . "━━━━━━━━━━━━━━━━━━\n"
                    . "🔢 *KODE RESET:*\n"
                    . '   *' . $tokenlupapassword . "*\n"
                    . "━━━━━━━━━━━━━━━━━━\n\n"
                    . "⏰ *Kode ini berlaku selama 15 menit*\n\n"
                    . "❗ Jika kamu *tidak* merasa mengirim permintaan mereset password, abaikan pesan ini.\n\n"
                    . "Terima kasih.\n"
                    . 'Tim GBI Elshaddai';

                $waTerkirim = $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);

                if (!$waTerkirim) {
                    $this->db->trans_rollback();
                    return array('success' => false, 'msg' => 'Gagal mengirim kode ke WhatsApp. Silakan coba lagi beberapa saat lagi.');
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array('success' => false, 'msg' => 'Gagal mengirim kode reset password.');
            } else {
                $this->db->trans_commit();
                // KEAMANAN: token TIDAK boleh pernah dikembalikan ke client.
                return array('success' => true);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            log_message('error', 'kirimKodeResetPassword error: ' . $th->getMessage());
            return array('success' => false, 'msg' => 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    /**
     * Langkah 2: cek token. Token TIDAK dihapus di sini karena
     * masih dibutuhkan (dan diverifikasi ulang) di langkah 3.
     */
    public function cekTokenResetPassword($email, $tokenResetPassword)
    {
        try {
            $hasil = $this->verifikasiTokenReset($email, $tokenResetPassword);

            if (!$hasil['success']) {
                return array('success' => false, 'msg' => $hasil['msg']);
            }

            return array('success' => true);
        } catch (\Throwable $th) {
            log_message('error', 'cekTokenResetPassword error: ' . $th->getMessage());
            return array('success' => false, 'msg' => 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    /**
     * Langkah 3: ganti password. Token WAJIB dikirim dan diverifikasi ulang,
     * sehingga endpoint ini tidak bisa dipanggil langsung tanpa kode dari email/WA.
     */
    public function updateResetPassword($email, $tokenResetPassword, $password)
    {
        try {
            $hasil = $this->verifikasiTokenReset($email, $tokenResetPassword);

            if (!$hasil['success']) {
                return array('success' => false, 'msg' => $hasil['msg']);
            }

            if (strlen((string) $password) < 6) {
                return array('success' => false, 'msg' => 'Password minimal 6 karakter.');
            }

            $this->db->trans_begin();

            $this->db->where('idjemaat', $hasil['idjemaat']);
            $this->db->update('jemaat', array(
                'password' => md5($password),
                'tokenlupapassword' => null,
                'tgltokenlupapassword' => null,
                'percobaantokensalah' => 0,
            ));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array('success' => false, 'msg' => 'Gagal mengganti password.');
            }

            $this->db->trans_commit();
            return array('success' => true);
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            log_message('error', 'updateResetPassword error: ' . $th->getMessage());
            return array('success' => false, 'msg' => 'Terjadi kesalahan, silakan coba lagi.');
        }
    }
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */