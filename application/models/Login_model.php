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

        $query = "select * from jemaat where $field='" . $email . "' and password='" . $password . "'";
        return $this->db->query($query);
    }

    public function simpanregistrasi($data)
    {
        return $this->db->insert('jemaat', $data);
    }

    public function emailsudahada($email)
    {
        $this->db->where('email', $email);
        $rsCekEmail = $this->db->get('jemaat');
        if ($rsCekEmail->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function nomorwasudahada($nohp)
    {
        $this->db->where('nohp', $nohp);
        $rsCekNoHP = $this->db->get('jemaat');
        if ($rsCekNoHP->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function whatsappsudahada($nomorwa)
    {
        $this->db->where('nohp', $nomorwa);
        $rsCekWa = $this->db->get('jemaat');
        if ($rsCekWa->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sudahAdaNIK($nik)
    {
        $query = "select * from jemaat where nik='" . $nik . "'";
        $rsTest = $this->db->query($query);
        if ($rsTest->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sudahAdaNIKTgllahir($nik, $tanggallahir)
    {
        $query = "select * from jemaat where nik='" . $nik . "' and tanggallahir='" . date('Y-m-d', strtotime($tanggallahir)) . "'";
        $rsTest = $this->db->query($query);
        if ($rsTest->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getIdJemaatByNIK($nik)
    {
        $query = "select * from jemaat where nik='" . $nik . "'";
        return $this->db->query($query)->row();
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
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */