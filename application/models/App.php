<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Model
{
    public function sendEmailDaftar($email, $subject, $textemail)
    {
        $this->load->library('email');

        $smtp_host = 'mail.myesc.id';
        $smtp_port = '465';
        $smtp_user = 'connect@myesc.id';
        $smtp_pass = 'Elshaddaichurch1';
        $namapengirim = 'Elshaddai Church';

        $config = array();
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $smtp_host;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_crypto'] = 'ssl';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $config['charset'] = 'utf-8';
        $this->email->initialize($config);

        $this->email->from($smtp_user, $namapengirim);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($textemail);

        return $this->email->send();
    }

    public function uploadImage($file, $namaFile, $namaFileLama, $foldername)
    {
        $this->load->library('image_lib');

        if (!empty($file[$namaFile]['name'])) {
            // FIX: path absolut pakai FCPATH + segmen 'myesc.id/', karena
            // struktur folder fisik di server adalah
            // public_html/myesc.id/admin/uploads/..., bukan langsung
            // public_html/admin/uploads/... (FCPATH mengarah ke public_html/,
            // satu level di atas folder aplikasi ini).
            $config['upload_path'] = FCPATH . 'myesc.id/admin/uploads/' . $foldername . '/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space'] = TRUE;
            $config['max_size'] = '2000KB';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($namaFile)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext = $this->upload->data('file_ext');
            } else {
                // FIX: catat pesan error asli dari library upload ke log,
                // supaya kalau gagal lagi di masa depan, penyebabnya langsung
                // ketahuan (misal: ukuran file kelebihan, folder tidak writable,
                // dll) tanpa perlu menebak-nebak seperti kemarin.
                log_message('error', 'uploadImage gagal untuk field=' . $namaFile . ', folder=' . $foldername . ' - ' . strip_tags($this->upload->display_errors()));
                $foto = $namaFileLama;
            }
        } else {
            $foto = $namaFileLama;
        }

        return $foto;
    }

    public function uploadPdf($file, $namaFile, $namaFileLama, $foldername, $ukuran = '2000')
    {
        $this->load->library('image_lib');

        if (!empty($file[$namaFile]['name'])) {
            // FIX: sama seperti uploadImage() - pakai path absolut FCPATH
            // + segmen 'myesc.id/' supaya cocok dengan struktur folder asli
            // di server (public_html/myesc.id/admin/uploads/jemaat/).
            $config['upload_path'] = FCPATH . 'myesc.id/admin/uploads/' . $foldername . '/';
            $config['allowed_types'] = 'pdf';
            $config['remove_space'] = TRUE;
            $config['max_size'] = $ukuran . 'KB';  // in KB

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($namaFile)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext = $this->upload->data('file_ext');
            } else {
                // FIX: log pesan error asli, supaya kegagalan upload tidak
                // lagi tertelan diam-diam seperti sebelumnya.
                log_message('error', 'uploadPdf gagal untuk field=' . $namaFile . ', folder=' . $foldername . ' - ' . strip_tags($this->upload->display_errors()));
                $foto = $namaFileLama;
            }
        } else {
            $foto = $namaFileLama;
        }

        return $foto;
    }

    public function sudahLulusKelas($idjemaat, $idkelas)
    {
        $rsTemp = $this->db->query("
            select * from v_registrasikelas_sudahlulus where idjemaat='$idjemaat' and idkelas = '$idkelas'
        ");
        if ($rsTemp->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function reloadSession($idjemaat)
    {
        $rsTemp = $this->db->query("
            select * from jemaat where idjemaat='$idjemaat'
        ")->row();

        if (empty($rsTemp->foto)) {
            $foto = base_url('admin/images/user-01.png');
        } else {
            $foto = base_url('myesc.id/admin/uploads/jemaat/' . $rsTemp->foto);
        }

        $data = array(
            'idjemaat' => $rsTemp->idjemaat,
            'namalengkap' => $rsTemp->namalengkap,
            'namapanggilan' => $rsTemp->namapanggilan,
            'alamatrumah' => $rsTemp->alamatrumah,
            'rtrw' => $rsTemp->rtrw,
            'kelurahan' => $rsTemp->alamatrumah,
            'kecamatan' => $rsTemp->kecamatan,
            'kotakabupaten' => $rsTemp->kotakabupaten,
            'propinsi' => $rsTemp->propinsi,
            'foto' => $foto,
            'notelp' => $rsTemp->notelp,
            'nohp' => $rsTemp->nohp,
            'email' => $rsTemp->email,
            'statusverifikasiemail' => $rsTemp->statusverifikasiemail,
            'statusverifikasiwa' => $rsTemp->statusverifikasiwa,
        );

        $this->session->set_userdata($data);
    }

    public function getInfoJemaat($idjemaat = '')
    {
        return $this->db->get_where('jemaat', array('idjemaat' => $idjemaat))->row();
    }

    public function getInfoKelas($idkelas = '')
    {
        return $this->db->get_where('kelas', array('idkelas' => $idkelas))->row();
    }
}

/* End of file App.php */
/* Location: ./application/models/App.php */
