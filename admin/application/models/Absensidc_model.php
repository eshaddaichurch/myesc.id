<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensidc_model extends CI_Model
{

    public function get_all()
    {
        return $this->db->get('v_dcabsen');
    }

    public function get_by_id($idabsen)
    {
        $this->db->where('idabsen', $idabsen);
        return $this->db->get('v_dcabsen');
    }

    public function getListAbsensi($tglawal, $tglakhir, $iddc)
    {
        $andwhere = '';
        if ($iddc != '') {
            $andwhere = " AND iddc = '$iddc' ";
        }
        $rsTemp = $this->db->query("
            select * from v_dcabsen WHERE CONVERT(tglabsen, DATE) BETWEEN  '$tglawal' AND '$tglakhir' $andwhere
        ");
        return $rsTemp;
    }

    public function getDc()
    {
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('kategoridc', 'asc');
        $this->db->order_by('namadc', 'asc');
        return $this->db->get('v_disciplescommunity');
    }
}
