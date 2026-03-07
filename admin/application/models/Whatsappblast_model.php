<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsappblast_model extends CI_Model {

    public function getDetailWaBlast($statuspernikahan, $statusjemaat, $jeniskelamin, $dcoption, $iddc, $usiaoption, $usiaawal, $usiasampai)
    {        
        $this->db->where('statusverifikasiwa', '1');

        //filter status pernikahan
        if ($statuspernikahan != 'Semua') {
            $this->db->where('statuspernikahan', $statuspernikahan);
        }

        //filter status jemaat
        $this->db->where('statusjemaat <>', 'Hapus');
        if ($statusjemaat != 'Semua') {
            $this->db->where('statusjemaat', $statusjemaat);
        }

        //filter jenis kelamin
        if ($jeniskelamin != 'Semua') {
            $this->db->where('jeniskelamin', $jeniskelamin);
        }

        //filter dc
        if ($dcoption == 'Terpilih') {
            $this->db->where('iddc', $iddc);
        }

        //filter usia
        // $this->db->where('umur >', 0);
        if ($usiaoption == 'Terpilih') {
            $this->db->where('umur >=', $usiaawal);
            $this->db->where('umur <=', $usiasampai);
        }

        return $this->db->get('v_jemaat');
    }

}