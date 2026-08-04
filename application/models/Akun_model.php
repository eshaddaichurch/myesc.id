<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun_model extends CI_Model
{
    public function hpSudahTerdaftar($nohp)
    {
        $idjemaat = $this->session->userdata('idjemaat');
        $rsNoHP = $this->db->query('
            select * from v_jemaat where idjemaat <> ? and nohp = ?
        ', array($idjemaat, $nohp));
        if ($rsNoHP->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function emailsudahada($email)
    {
        $idjemaat = $this->session->userdata('idjemaat');

        $this->db->where('email', $email);
        $this->db->where('idjemaat <>', $idjemaat);
        $rsCekEmail = $this->db->get('jemaat');
        if ($rsCekEmail->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function nomorwasudahada($nohp)
    {
        $idjemaat = $this->session->userdata('idjemaat');

        $this->db->where('nohp', $nohp);
        $this->db->where('idjemaat <>', $idjemaat);

        $rsCekNoHP = $this->db->get('jemaat');
        if ($rsCekNoHP->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cekPasswordLama($password)
    {
        $idjemaat = $this->session->userdata('idjemaat');
        $password = md5($password);

        $rsPassword = $this->db->query('
            select * from jemaat where idjemaat = ? and password = ?
        ', array($idjemaat, $password));
        if ($rsPassword->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getInfoJemaat($idjemaat = '')
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_jemaat');
    }

    public function simpanupload($dataUpload)
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->update('jemaat', $dataUpload);
    }

    public function update($data, $filekartukeluarga, $idjemaat)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
            $this->db->update('jemaat', $data);

            // FITUR BARU: generik untuk semua jenis dokumen lewat simpanDokumen().
            // Saat ini baru KK yang punya field upload di frontend. Untuk
            // menambah jenis dokumen baru nanti (KTP, Akta Lahir, dll):
            // 1. Tambah parameter baru di method update() ini (mis. $filektp)
            // 2. Panggil simpanDokumen() lagi dengan kode dokumen yang sesuai
            //    (kode harus sudah terdaftar di tabel masterdokumen)
            // Tidak perlu ubah struktur tabel lagi untuk jenis dokumen baru.
            $this->simpanDokumen($idjemaat, 'KK', $filekartukeluarga);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return false;
        }
    }

    // FITUR BARU: helper generik untuk simpan/update 1 jenis dokumen.
    // Dipakai untuk semua jenis dokumen (KK, KTP, Akta, dll), tinggal beda
    // $kodedokumen yang dikirim. Setiap kali dipanggil dengan file baru,
    // status otomatis reset jadi 'Menunggu Review' dan catatan lama dihapus,
    // supaya admin tahu ada dokumen yang perlu direview ulang.
    private function simpanDokumen($idjemaat, $kodedokumen, $namafile)
    {
        // FITUR BARU: log setiap kali fungsi ini dipanggil, supaya kalau
        // dokumen tidak masuk ke database, kita tinggal cek application/logs/
        // dan langsung tahu apakah penyebabnya (a) $namafile memang kosong
        // (berarti masalah di proses upload file, bukan di sini), atau
        // (b) $namafile terisi tapi query INSERT-nya yang gagal.
        if (empty($namafile)) {
            log_message('debug', 'simpanDokumen dilewati (namafile kosong) untuk idjemaat=' . $idjemaat . ', kodedokumen=' . $kodedokumen);
            return;
        }

        log_message('debug', 'simpanDokumen mencoba insert: idjemaat=' . $idjemaat . ', kodedokumen=' . $kodedokumen . ', namafile=' . $namafile);

        $result = $this->db->query('
            insert into jemaatdokumen (idjemaat, kodedokumen, namafile, statusdokumen, catatanreview, tglupload, tglreview, idadminreview)
            values (?, ?, ?, "Menunggu Review", NULL, NOW(), NULL, NULL)
            on duplicate key update
                namafile = VALUES(namafile),
                statusdokumen = "Menunggu Review",
                catatanreview = NULL,
                tglupload = NOW(),
                tglreview = NULL,
                idadminreview = NULL
        ', array($idjemaat, $kodedokumen, $namafile));

        if ($result === FALSE) {
            $eror = $this->db->error();
            log_message('error', 'simpanDokumen GAGAL untuk idjemaat=' . $idjemaat . ', kodedokumen=' . $kodedokumen . ' - ' . json_encode($eror));
        } else {
            log_message('debug', 'simpanDokumen berhasil untuk idjemaat=' . $idjemaat . ', kodedokumen=' . $kodedokumen . ', affected_rows=' . $this->db->affected_rows());
        }
    }

    public function getInfoDC($idjemaat)
    {
        $this->db->where('idjemaat', $idjemaat);
        $this->db->where('statusaktif', 'Aktif');
        return $this->db->get('v_dcmember');
    }
}

/* End of file Akun_model.php */
/* Location: ./application/models/Akun_model.php */
