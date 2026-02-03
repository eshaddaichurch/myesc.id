<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc_api_model extends CI_Model {

    public function getPermohonan($iddc)
    {
        $this->db->where('iddc', $iddc);
        return $this->db->get('v_dcmember_permohonan')->result();
    }

}
