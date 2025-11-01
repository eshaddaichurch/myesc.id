<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Model
{

    public function sendEmailDaftar($email, $subject, $textemail)
    {
        $this->load->library('email');

        // $pengaturan = $this->db->query("select * from infousaha")->row();



        // $smtp_host = $pengaturan->smtphost_daftar;
        // $smtp_port = $pengaturan->smtpport_daftar;
        // $smtp_user = $pengaturan->smtpuser_daftar;
        // $smtp_pass = $pengaturan->smtppassword_daftar;
        // $namapengirim = $pengaturan->namapengirim_daftar;

        $smtp_host = 'mail.myesc.id';
        $smtp_port = '465';
        $smtp_user = 'registrasi@myesc.id';
        $smtp_pass = 'Elshaddaichurch1';
        $namapengirim = 'Elshaddai Church';


        $config = array();
        $config['protocol'] = "smtp";
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $smtp_host;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_timeout'] = "5";
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
            $config['upload_path']          = 'myesc.id/admin/uploads/' . $foldername . '/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']            = '2000KB';


            $this->load->library('upload', $config);
            if ($this->upload->do_upload($namaFile)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
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
        if ($rsTemp->num_rows()>0) {
            return true;
        }else{
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
            $foto = base_url('admin/uploads/jemaat/' . $rsTemp->foto);
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

    public function getInfoJemaat($idjemaat = "")
    {
        return $this->db->get_where('jemaat', array('idjemaat' => $idjemaat))->row();
    }
}

/* End of file App.php */
/* Location: ./application/models/App.php */