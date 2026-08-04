<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->wajibLogin();
        $this->load->model('Home_model');
        $this->load->model('Akun_model');
    }

    public function profil($idmenu = '')
    {
        $idmenu = $this->encrypt->decode($idmenu);
        $rsDC = $this->Akun_model->getInfoDC($this->session->userdata('idjemaat'));
        $data['rowProfil'] = $this->Akun_model->getInfoJemaat()->row();
        $data['rsDC'] = $this->Akun_model->getInfoDC($this->session->userdata('idjemaat'));
        $data['rowinfogereja'] = $this->Home_model->get_infogereja();
        $data['menu'] = 'Akun';
        $this->load->view('akun/profil', $data);
    }

    public function ubahprofil($idmenu = '')
    {
        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowProfil'] = $this->Akun_model->getInfoJemaat()->row();
        $data['rowinfogereja'] = $this->Home_model->get_infogereja();
        $data['menu'] = 'Akun';
        $this->load->view('akun/ubahprofil', $data);
    }

    public function gantipassword($idmenu = '')
    {
        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowProfil'] = $this->Akun_model->getInfoJemaat()->row();
        $data['rowinfogereja'] = $this->Home_model->get_infogereja();
        $data['menu'] = 'Akun';
        $this->load->view('akun/gantipassword', $data);
    }

    public function kelas($idmenu = '')
    {
        $idjemaat = $this->session->userdata('idjemaat');

        $rskelas = $this->db->query('
                SELECT kelas.idkelas, kelas.namakelas, kelas.urlsertifikat,
                    registrasikelas.`statuslulus`, tglsertifikat, idregistrasikelas
                    FROM kelas 
                    LEFT JOIN registrasikelas ON registrasikelas.`idkelas`=kelas.`idkelas` and idjemaat = ? AND statuslulus=1
                    GROUP BY kelas.idkelas, kelas.namakelas, kelas.urlsertifikat,
                    registrasikelas.`statuslulus`, tglsertifikat, idregistrasikelas
            ', array($idjemaat));

        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowinfogereja'] = $this->Home_model->get_infogereja();
        $data['menu'] = 'Akun';
        $data['rskelas'] = $rskelas;
        $this->load->view('akun/kelas', $data);
    }

    public function sertifikat($idregistrasikelas)
    {
        $this->load->library('Pdf');

        $idjemaat = $this->session->userdata('idjemaat');

        $rsregistrasi = $this->db->query('
                                        select * from v_registrasikelas
                                        where idregistrasikelas = ? and idjemaat = ?
                                    ', array($idregistrasikelas, $idjemaat))->row();

        if (!$rsregistrasi) {
            show_404();
            return;
        }

        $idkelas = $rsregistrasi->idkelas;
        switch ($idkelas) {
            case 'KL002':
                $report = 'sertifikatfc1';
                break;
            case 'KL003':
                $report = 'sertifikatfc2';
                break;
            case 'KL004':
                $report = 'sertifikatfc3';
                break;
            case 'KL005':
                $report = 'sertifikatgrade1';
                break;
            case 'KL006':
                $report = 'sertifikatgrade2';
                break;
            case 'KL007':
                $report = 'sertifikatgrade3';
                break;
            case 'KL008':
                $report = 'sertifikatvc';
                break;
            case 'KL101':
                $report = 'sertifikatpmc';
                break;
            default:
                $report = '';
                break;
        }

        $data['rsregistrasi'] = $rsregistrasi;
        $data['idregistrasikelas'] = $idregistrasikelas;
        $this->load->view('akun/' . $report, $data);
    }

    public function simpanupload()
    {
        $idjemaat = $this->session->userdata('idjemaat');

        $foto_lama = $this->input->post('foto_lama');
        $foto = $this->App->uploadImage($_FILES, 'foto', $foto_lama, 'jemaat');

        $dataUpload = array(
            'foto' => $foto,
        );

        $simpan = $this->Akun_model->simpanupload($dataUpload);
        redirect('akun/profil');
    }

    public function simpanregistered()
    {
        $nohp = $this->input->post('nohp');

        if ($this->Akun_model->hpSudahTerdaftar($nohp)) {
            $pesan = "<script>
                        swal('Gagal', 'Nomor HP sudah terdaftar.', 'warning');
                    </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/ubahprofil');
        }

        $data = array(
            'nohp' => htmlspecialchars($nohp)
        );
        $simpan = $this->Akun_model->update($data);
        if ($simpan) {
            $pesan = "<script>
                            swal('Berhasil', 'Data berhasil disimpan.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Data gagal disimpan.', 'warning');
                        </script>";
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('akun/profil');
    }

    public function simpanJemaat()
    {
        $idjemaat = $this->session->userdata('idjemaat');
        $nik = $this->input->post('nikprofil');
        $kewarganegaraan = $this->input->post('kewarganegaraan');
        $namalengkap = $this->input->post('namalengkapprofil');
        $namapanggilan = $this->input->post('namapanggilan');
        $tempatlahir = $this->input->post('tempatlahirprofil');
        $tanggallahir = $this->input->post('tanggallahirprofil');
        $jeniskelamin = $this->input->post('jeniskelaminprofil');
        $statuspernikahan = $this->input->post('statuspernikahan');
        $golongandarah = $this->input->post('golongandarah');
        if (empty($golongandarah)) {
            $golongandarah = null;
        }
        $notelp = $this->input->post('notelp');
        $nohp = $this->input->post('nohpprofil');
        $email = $this->input->post('emailprofil');
        $facebook = $this->input->post('facebook');
        $instagram = $this->input->post('instagram');
        $alamatrumah = $this->input->post('alamatrumahprofil');
        $rtrw = $this->input->post('rtrw');
        $kelurahan = $this->input->post('kelurahan');
        $kecamatan = $this->input->post('kecamatan');
        $kotakabupaten = $this->input->post('kotakabupaten');
        $propinsi = $this->input->post('propinsi');
        $kodepos = $this->input->post('kodepos');

        $namadarurat = $this->input->post('namadarurat');
        $hubungan = $this->input->post('hubungan');
        if (empty($hubungan)) {
            $hubungan = null;
        }
        $notelpdarurat = $this->input->post('notelpdarurat');
        $pendidikanterakhir = $this->input->post('pendidikanterakhir');
        if (empty($pendidikanterakhir)) {
            $pendidikanterakhir = null;
        }
        $namasekolah = $this->input->post('namasekolah');
        $pekerjaan = $this->input->post('pekerjaan');
        if (empty($pekerjaan)) {
            $pekerjaan = null;
        }
        $namaperusahaan = $this->input->post('namaperusahaan');
        $sektorindustri = $this->input->post('sektorindustri');
        $alamatkantor = $this->input->post('alamatkantor');
        $notelpkantor = $this->input->post('notelpkantor');
        $tanggalupdate = date('Y-m-d H:i:s');

        $foto_lama = $this->input->post('foto_lama');
        $foto = $this->App->uploadImage($_FILES, 'foto', $foto_lama, 'jemaat');

        $filekartukeluarga_lama = $this->input->post('filekartukeluarga_lama');
        $filekartukeluarga = $this->App->uploadPdf($_FILES, 'filekartukeluarga', $filekartukeluarga_lama, 'jemaat', '5000');

        if (empty($nohp)) {
            $nohp = null;
        }

        $rowJemaat = $this->db->query(
            'select * from v_jemaat where idjemaat = ?',
            array($idjemaat)
        )->row();

        // =======================================
        // DATA UMUM (boleh diubah semua status)
        // =======================================
        $data = array(
            'notelp' => $notelp,
            'nohp' => $nohp,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'namadarurat' => $namadarurat,
            'hubungan' => $hubungan,
            'notelpdarurat' => $notelpdarurat,
            'pendidikanterakhir' => $pendidikanterakhir,
            'namasekolah' => $namasekolah,
            'pekerjaan' => $pekerjaan,
            'namaperusahaan' => $namaperusahaan,
            'sektorindustri' => $sektorindustri,
            'alamatkantor' => $alamatkantor,
            'notelpkantor' => $notelpkantor,
            'alamatrumah' => $alamatrumah,
            'rtrw' => $rtrw,
            'kelurahan' => $kelurahan,
            'kecamatan' => $kecamatan,
            'kotakabupaten' => $kotakabupaten,
            'propinsi' => $propinsi,
            'kodepos' => $kodepos,
            'tanggalupdate' => $tanggalupdate,
            'foto' => $foto,
        );

        // =======================================
        // DATA IDENTITAS (HANYA Registered & Simpatisan)
        // =======================================
        if (in_array($rowJemaat->statusjemaat, ['Registered', 'Simpatisan'])) {
            $data['nik'] = $nik;
            $data['kewarganegaraan'] = $kewarganegaraan;
            $data['namalengkap'] = $namalengkap;
            $data['namapanggilan'] = $namapanggilan;
            $data['tempatlahir'] = $tempatlahir;
            $data['tanggallahir'] = $tanggallahir;
            $data['jeniskelamin'] = $jeniskelamin;
            $data['statuspernikahan'] = $statuspernikahan;
            $data['golongandarah'] = $golongandarah;
        }

        $simpan = $this->Akun_model->update($data, $filekartukeluarga, $idjemaat);

        if ($simpan) {
            $pesan = "<script>
                        swal('Berhasil', 'Data profil berhasil disimpan.', 'success');
                    </script>";
            $this->App->reloadSession($idjemaat);
        } else {
            $eror = $this->db->error();
            log_message('error', 'simpanJemaat gagal untuk idjemaat=' . $idjemaat . ' - ' . json_encode($eror));

            $pesan = "<script>
                        swal('Gagal', 'Data profil gagal disimpan. Silakan coba lagi atau hubungi admin.', 'warning');
                    </script>";
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('akun/ubahprofil');
    }

    public function simpanubahpassword()
    {
        $passwordlama = htmlspecialchars($this->input->post('passwordlama'));
        $passwordbaru1 = htmlspecialchars($this->input->post('passwordbaru1'));
        $passwordbaru2 = htmlspecialchars($this->input->post('passwordbaru2'));

        if (empty($passwordlama)) {
            $pesan = "<script>
                        swal('Gagal', 'Password lama tidak boleh kosong!', 'warning');
                    </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/gantipassword');
        }

        if (empty($passwordbaru1) || empty($passwordbaru2)) {
            $pesan = "<script>
                        swal('Gagal', 'Password baru tidak boleh kosong!', 'warning');
                    </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/gantipassword');
        }

        if (!$this->Akun_model->cekPasswordLama($passwordlama)) {
            $pesan = "<script>
                        swal('Gagal', 'Password lama salah!', 'warning');
                    </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/gantipassword');
        }

        if ($passwordbaru1 != $passwordbaru2) {
            $pesan = "<script>
                        swal('Gagal', 'Ulangi Password tidak sama!', 'warning');
                    </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun/gantipassword');
        }

        $data = array(
            'password' => md5($passwordbaru1),
        );

        $simpan = $this->Akun_model->update($data);
        if ($simpan) {
            $pesan = "<script>
                            swal('Berhasil', 'Data berhasil disimpan.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Data gagal disimpan.', 'warning');
                        </script>";
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('akun/profil');
    }

    public function getJemaatId()
    {
        $idjemaat = $this->session->userdata('idjemaat');

        $RsData = $this->db->query(
            'select * from v_jemaat where idjemaat = ?',
            array($idjemaat)
        )->row();

        // FITUR BARU: ambil SEMUA jenis dokumen milik jemaat ini (generik),
        // disusun sebagai array asosiatif per kodedokumen supaya frontend
        // bisa menampilkan status masing-masing jenis dokumen (KK, KTP, dst)
        // begitu jenis dokumen baru ditambahkan ke form nanti.
        $dokumen = $this->db->query(
            'select * from jemaatdokumen where idjemaat = ?',
            array($idjemaat)
        );
        $RsData->dokumen = array();
        if ($dokumen->num_rows() > 0) {
            foreach ($dokumen->result() as $rowDok) {
                $RsData->dokumen[$rowDok->kodedokumen] = array(
                    'namafile' => $rowDok->namafile,
                    'status' => $rowDok->statusdokumen,
                    'catatan' => $rowDok->catatanreview,
                );
            }
        }

        // Kompatibilitas dengan frontend yang sudah ada (masih memakai nama
        // field lama khusus KK: filekartukeluarga, statuskk, catatanreviewkk)
        $RsData->filekartukeluarga = isset($RsData->dokumen['KK']) ? $RsData->dokumen['KK']['namafile'] : '';
        $RsData->statuskk = isset($RsData->dokumen['KK']) ? $RsData->dokumen['KK']['status'] : '';
        $RsData->catatanreviewkk = isset($RsData->dokumen['KK']) ? $RsData->dokumen['KK']['catatan'] : '';

        echo (json_encode($RsData));
    }

    public function getKabupaten()
    {
        $idprovinsi = $this->input->get('idprovinsi');

        $query = $this->db->query('
            select * from kabupaten where idprovinsi = ? order by namakabupaten
        ', array($idprovinsi));
        echo json_encode($query->result());
    }

    public function getKecamatan()
    {
        $idkabupaten = $this->input->get('idkabupaten');

        $query = $this->db->query('
            select * from kecamatan where idkabupaten = ? order by namakecamatan
        ', array($idkabupaten));
        echo json_encode($query->result());
    }

    public function getKelurahan()
    {
        $idkecamatan = $this->input->get('idkecamatan');

        $query = $this->db->query('
            select * from desa where idkecamatan = ? order by namadesa
        ', array($idkecamatan));
        echo json_encode($query->result());
    }

    public function sendverifikasiemail()
    {
        $email = $this->input->get('email');
        $namalengkap = $this->session->userdata('namalengkap');
        $idjemaat = $this->session->userdata('idjemaat');
        $ip = $this->input->ip_address();

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('msg' => 'Format email tidak valid.'));
            exit();
        }

        if ($this->Akun_model->emailsudahada($email)) {
            echo json_encode(array('msg' => 'Email ' . $email . ' sudah pernah terdaftar! Jika anda merasa belum pernah mendaftar hubungi hotline gereja WhatsApp 085550001187 untuk konfirmasi akun.'));
            exit();
        }

        // === RATE LIMIT 1: email ini sendiri, minimal jeda 60 detik ===
        $lastByEmail = $this->db->query('
        SELECT created_at FROM otp_log
        WHERE tipe = "email" AND tujuan = ?
        ORDER BY created_at DESC LIMIT 1
    ', array($email))->row();

        if ($lastByEmail && (time() - strtotime($lastByEmail->created_at)) < 60) {
            echo json_encode(array('msg' => 'Mohon tunggu sebentar sebelum meminta verifikasi ulang.'));
            exit();
        }

        // === RATE LIMIT 2: dari IP ini, maksimal 5x kirim email per jam ===
        $countIp = $this->db->query('
        SELECT COUNT(*) as jumlah FROM otp_log
        WHERE tipe = "email" AND ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
    ', array($ip))->row()->jumlah;

        if ($countIp >= 5) {
            echo json_encode(array('msg' => 'Terlalu banyak percobaan verifikasi email. Silakan coba lagi nanti.'));
            exit();
        }

        $this->db->query('
        update jemaat set
        email = ?
        where idjemaat = ?
    ', array($email, $idjemaat));

        $textemail =
            '<h4>Shalom! ' . $namalengkap . 'Welcome to myesc! </h4>
        <p>We\xe2\x80\x99re thrilled to have you with us! Before you can start your journey with us, please verify your email with a quick click below!</p>
            <p> <a href="' . site_url('login/verifikasiemail/' . $this->encrypt->encode($email))
            . '">
        <div class= "btn btn-primary">
        Verify Email
        </div></a> </p>
        <p>Thank You,</p>
        <p>EL SHADDAI CHURCH</p>
        <hr>
        <h4>Shalom! ' . $namalengkap . 'Selamat datang di MyEsc! </h4>
        <p>Kami senang kamu sudah bergabung. Sebelum kamu bisa memulai perjalananmu bersama kami, yuk, verifikasi email ini dengan satu klik cepat di bawah ini!</p>
            <p> <a href="' . site_url('login/verifikasiemail/' . $this->encrypt->encode($email))
            . '">
        <div class= "btn btn-primary">
        Verifikasi Email
        </div></a> </p>
        <p>Terima Kasih,</p>
        <p>GBI EL SHADDAI</p>
        ';
        $this->App->sendEmailDaftar($email, 'Email Verification', $textemail);

        // catat log setelah berhasil kirim
        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => 'email',
            'tujuan' => $email,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ));

        echo json_encode(array('success' => true));
    }

    public function sendverifikasihp()
    {
        $nohp = $this->input->get('nohp');
        $namalengkap = $this->session->userdata('namalengkap');
        $idjemaat = $this->session->userdata('idjemaat');
        $ip = $this->input->ip_address();

        if (empty($nohp) || !preg_match('/^0[0-9]{9,14}$/', $nohp)) {
            echo json_encode(array('msg' => 'Format nomor WhatsApp tidak valid.'));
            exit();
        }

        if ($this->Akun_model->nomorwasudahada($nohp)) {
            echo json_encode(array('msg' => 'Nomor Whatsapp ' . $nohp . ' sudah pernah terdaftar! Jika anda merasa belum pernah mendaftar hubungi hotline gereja WhatsApp 085550001187 untuk konfirmasi akun.'));
            exit();
        }

        // === RATE LIMIT 1: nomor ini sendiri, minimal jeda 60 detik ===
        $lastByNomor = $this->db->query('
        SELECT created_at FROM otp_log
        WHERE tipe = "wa" AND tujuan = ?
        ORDER BY created_at DESC LIMIT 1
    ', array($nohp))->row();

        if ($lastByNomor && (time() - strtotime($lastByNomor->created_at)) < 60) {
            echo json_encode(array('msg' => 'Mohon tunggu sebentar sebelum meminta verifikasi ulang.'));
            exit();
        }

        // === RATE LIMIT 2: dari IP ini, maksimal 5x kirim WA per jam ===
        $countIp = $this->db->query('
        SELECT COUNT(*) as jumlah FROM otp_log
        WHERE tipe = "wa" AND ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
    ', array($ip))->row()->jumlah;

        if ($countIp >= 5) {
            echo json_encode(array('msg' => 'Terlalu banyak percobaan verifikasi WhatsApp. Silakan coba lagi nanti.'));
            exit();
        }

        $url = site_url('login/verifikasiwa/' . $this->encrypt->encode($nohp));

        $this->db->query('
        update jemaat set
        nohp = ?
        where idjemaat = ?
    ', array($nohp, $idjemaat));

        $pesanWA = 'Shalom ' . $namalengkap . "! Welcome to myesc! Kami senang kamu sudah bergabung. Sebelum kamu bisa memulai perjalananmu bersama kami, yuk, verifikasi nomor whatsapp ini dengan satu klik cepat di bawah ini!\n\n" . $url;

        $this->whatsapp->send_message(formatNomorWhatsapp($nohp), $pesanWA);

        // catat log setelah berhasil kirim
        $this->db->insert('otp_log', array(
            'idjemaat' => $idjemaat,
            'tipe' => 'wa',
            'tujuan' => $nohp,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ));

        echo json_encode(array('success' => true));
    }
}

/* End of file Akun.php */
/* Location: ./application/controllers/Akun.php */
