<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc_api_model extends CI_Model
{
    public function getPermohonanByDc($iddc)
    {
        return $this->db
            ->where('iddc', $iddc)
            ->order_by('tglpermohonan', 'DESC')
            ->get('v_dcmember_permohonan')
            ->result_array();
    }
}
