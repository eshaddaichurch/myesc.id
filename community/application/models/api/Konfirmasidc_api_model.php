<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc_api_model extends CI_Model {

    public function getDetail($idpermohonan)
    {
        return $this->db
            ->where('idpermohonan', $idpermohonan)
            ->get('v_dcmember_permohonan')
            ->row();
    }

}
