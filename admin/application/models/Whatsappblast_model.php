<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsappblast_model extends CI_Model {

    public function getJumlahJemaat($statuspernikahan, $statusjemaat, $jeniskelamin, $dcoption, $iddc, $usiaoption, $usiaawal, $usiasampai)
    {
        
        $this->db->where('statuspernikahan', $statuspernikahan);
        $this->db->where('statusjemaat', $statusjemaat);
        $this->db->where('jeniskelamin', $jeniskelamin);
        $this->db->where('iddc', $iddc);
        $this->db->where('usiaoption', $usiaoption);
        $this->db->where('usiaawal <=', $usiaawal);
        $this->db->where('usiasampai >=', $usiasampai);
        $this->db->where('dcoption', $dcoption);
        $this->db->from('jemaat');

        return $this->db->count_all_results();
    }

}