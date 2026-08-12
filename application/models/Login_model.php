<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function cekLoginAjax($email, $password)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $email = preg_replace('/[^0-9]/', '', $email);
            $field = 'nohp';
        }

        // $field aman ditempel langsung karena nilainya hardcoded dari logic PHP di atas,
        // bukan dari input user secara langsung. $email & $password tetap di-bind.
        return $this->db->query("SELECT * FROM jemaat WHERE $field = ? AND password = ?", array($email, $password));
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

    public function kirimKodeResetPassword($email)
    {
        try {
            $this->db->trans_begin();

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $email = preg_replace('/[^0-9]/', '', $email);
                $field = 'nohp';
            }

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

            // random string 6 digit
            $idjemaat = $rowJemaat->idjemaat;
            $tokenlupapassword = random_int(100000, 999999);
            $dataToken = array(
                'tokenlupapassword' => $tokenlupapassword,
                'tgltokenlupapassword' => date('Y-m-d H:i:s'),
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
                    $this->App->sendEmailDaftar($email, 'Reset Password Myesc.id', $pesanEmail);
                }
            } else {
                // kirim pesan whatsapp
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

                try {
                    $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);
                } catch (\Throwable $e) {
                    log_message('error', 'Gagal kirim WA reset password (gateway belum tersambung?): ' . $e->getMessage());
                    log_message('debug', 'Token reset password WA (fallback log): ' . $tokenlupapassword);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array('success' => false, 'msg' => 'Gagal mengirim kode reset password.');
            } else {
                $this->db->trans_commit();
                return array('success' => true, 'tokenlupapassword' => $tokenlupapassword);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return array('success' => false, 'msg' => $th->getMessage());
        }
    }

    public function cekTokenResetPassword($email, $tokenResetPassword)
    {
        try {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $email = preg_replace('/[^0-9]/', '', $email);
                $field = 'nohp';
            }

            $rsCekEmail = $this->db->query(
                "SELECT * FROM jemaat WHERE $field = ? AND tokenlupapassword = ?",
                array($email, $tokenResetPassword)
            );

            if ($rsCekEmail->num_rows() == 0) {
                return array('success' => false, 'msg' => 'Token reset password salah.');
            }

            return array('success' => true);
        } catch (\Throwable $th) {
            return array('success' => false, 'msg' => $th->getMessage());
        }
    }

    public function updateResetPassword($email, $password)
    {
        try {
            $this->db->trans_begin();

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $email = preg_replace('/[^0-9]/', '', $email);
                $field = 'nohp';
            }

            $this->db->where($field, $email);
            $this->db->update('jemaat', array('password' => md5($password), 'tokenlupapassword' => null));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array('success' => false, 'msg' => 'Gagal mengganti password.');
            } else {
                $this->db->trans_commit();
                return array('success' => true);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return array('success' => false, 'msg' => $th->getMessage());
        }
    }
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */
