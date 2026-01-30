<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

    // public function cek_login($username, $password)
    // {
    //     $query = "select * from v_dcmember where username='" . $username . "' and password='" . $password . "'";
    //     return $this->db->query($query);
    // }

    public function cek_login($username, $password)
    {
        return $this->db
            ->where('LOWER(TRIM(username))', strtolower(trim($username)))
            ->where('password', $password)
            ->where('statusaktif', 'Aktif')
            ->get('v_dcmember');
    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */