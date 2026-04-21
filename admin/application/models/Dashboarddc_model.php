<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboarddc_model extends CI_Model
{
    function __construct() {}

    public function memberBaruLalu()
    {
        $bulanLalu = date('m', strtotime('-1 month'));
        $tahunLalu = date('Y', strtotime('-1 month'));

        return $this->db->query("
            SELECT count(*) as jumlah 
            FROM dcmember_permohonan 
            WHERE statuskonfirmasi='Disetujui' 
                AND MONTH(tglpermohonan) = " . $bulanLalu . " 
                AND YEAR(tglpermohonan) = '" . $tahunLalu . "'
        ")->row()->jumlah;
    }

    public function memberBaruIni()
    {
        $bulanIni = date('m');
        $tahunIni = date('Y');

        return $this->db->query("
            SELECT count(*) as jumlah 
            FROM dcmember_permohonan 
            WHERE statuskonfirmasi='Disetujui' 
                AND MONTH(tglpermohonan) = " . $bulanIni . " 
                AND YEAR(tglpermohonan) = '" . $tahunIni . "'
        ")->row()->jumlah;
    }

    public function jumlahDc()
    {
        return $this->db->query("
            SELECT count(*) as jumlah FROM disciplescommunity WHERE statusaktif = 'Aktif'
        ")->row()->jumlah;
    }

    public function jumlahMember()
    {
        return $this->db->query("
            SELECT count(*) as jumlah FROM dcmember WHERE statusaktif = 'Aktif'
        ")->row()->jumlah;
    }

    public function getgrafikmember($tglawal, $tglakhir)
    {
        $sql = "
            SELECT convert(tglkonfirmasi, date) as tglkonfirmasi, count(*) as jumlah
            FROM dcmember_permohonan
            WHERE convert(tglkonfirmasi, date) 
                BETWEEN '" . date('Y-m-d', strtotime($tglawal)) . "' 
                AND '" . date('Y-m-d', strtotime($tglakhir)) . "'
            GROUP BY convert(tglkonfirmasi, date)
            ORDER BY tglkonfirmasi
        ";
        return $this->db->query($sql);
    }

    /**
     * FIX: Hapus GROUP BY MONTH() agar query menghasilkan 1 baris pivot
     * GROUP BY menyebabkan multi-row sehingga ->row() hanya ambil baris pertama (Jan)
     * dan bulan lain jadi NULL/0
     */
    public function getjumlahmemberperbulan()
    {
        return $this->db->query("
            SELECT 
                SUM(CASE WHEN MONTH(tglpermohonan) = 01 THEN 1 ELSE 0 END) AS m01,
                SUM(CASE WHEN MONTH(tglpermohonan) = 02 THEN 1 ELSE 0 END) AS m02,
                SUM(CASE WHEN MONTH(tglpermohonan) = 03 THEN 1 ELSE 0 END) AS m03,
                SUM(CASE WHEN MONTH(tglpermohonan) = 04 THEN 1 ELSE 0 END) AS m04,
                SUM(CASE WHEN MONTH(tglpermohonan) = 05 THEN 1 ELSE 0 END) AS m05,
                SUM(CASE WHEN MONTH(tglpermohonan) = 06 THEN 1 ELSE 0 END) AS m06,
                SUM(CASE WHEN MONTH(tglpermohonan) = 07 THEN 1 ELSE 0 END) AS m07,
                SUM(CASE WHEN MONTH(tglpermohonan) = 08 THEN 1 ELSE 0 END) AS m08,
                SUM(CASE WHEN MONTH(tglpermohonan) = 09 THEN 1 ELSE 0 END) AS m09,
                SUM(CASE WHEN MONTH(tglpermohonan) = 10 THEN 1 ELSE 0 END) AS m10,
                SUM(CASE WHEN MONTH(tglpermohonan) = 11 THEN 1 ELSE 0 END) AS m11,
                SUM(CASE WHEN MONTH(tglpermohonan) = 12 THEN 1 ELSE 0 END) AS m12
            FROM dcmember_permohonan 
            WHERE statuskonfirmasi = 'Disetujui' 
                AND YEAR(tglpermohonan) = '" . date('Y') . "'
        ");
    }

    public function getMemberBaru($tglawal, $tglakhir)
    {
        return $this->db->query("
            SELECT * FROM v_dcmember_permohonan 
            WHERE statuskonfirmasi='Disetujui' 
                AND tglkonfirmasi 
                BETWEEN '" . date('Y-m-d', strtotime($tglawal)) . "' 
                AND '" . date('Y-m-d', strtotime($tglakhir)) . "'
        ");
    }

    public function getDc()
    {
        return $this->db->query("
            SELECT * FROM v_disciplescommunity WHERE statusaktif = 'Aktif'
        ");
    }

    public function getCT($iddc)
    {
        return $this->db->query("
            SELECT * FROM v_dcmember 
            WHERE iddc = '$iddc' 
                AND statusaktif = 'Aktif' 
                AND statuskeanggotaan = 'Core Team'
        ");
    }

    public function getJumlahMemberDc($iddc)
    {
        return $this->db->query("
            SELECT count(*) as jumlah FROM v_dcmember 
            WHERE iddc = '$iddc' AND statusaktif = 'Aktif'
        ")->row()->jumlah;
    }
}

/* End of file Dashboarddc_model.php */
/* Location: ./application/models/Dashboarddc_model.php */
