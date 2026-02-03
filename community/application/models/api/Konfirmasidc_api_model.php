<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc_api_model extends CI_Model {

    /**
     * List permohonan berdasarkan DC
     * dipakai oleh: API index()
     */
    public function getByDc($iddc)
    {
        return $this->db
            ->where('iddc', $iddc)
            ->order_by('tglpermohonan', 'DESC')
            ->get('v_dcmember_permohonan')
            ->result();
    }

    /**
     * Detail permohonan
     * dipakai oleh: API detail()
     */
    public function getDetail($idpermohonan)
    {
        return $this->db
            ->where('idpermohonan', $idpermohonan)
            ->get('v_dcmember_permohonan')
            ->row();
    }

    /**
     * Helper: cek permohonan exist
     * (opsional, tapi rapi)
     */
    public function existsPermohonan($idpermohonan)
    {
        return $this->db
            ->where('idpermohonan', $idpermohonan)
            ->count_all_results('dcmember_permohonan') > 0;
    }

}
