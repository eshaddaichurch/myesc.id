<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare_model extends CI_Model
{
    // ==========================================================
    // Jumlah data per bulan dalam satu tahun.
    // Return: array 12 elemen (Jan..Des), selalu lengkap walau bulan kosong.
    // ==========================================================
    public function grafikBulanan($table, $kolomTanggal, $tahun, $where = array())
    {
        $this->db->select("MONTH($kolomTanggal) AS bulan, COUNT(*) AS total", false);
        $this->db->from($table);
        $this->db->where("$kolomTanggal IS NOT NULL", null, false);
        $this->db->where("YEAR($kolomTanggal) = " . (int) $tahun, null, false);
        foreach ($where as $kolom => $nilai) {
            $this->db->where($kolom, $nilai);
        }
        $this->db->group_by("MONTH($kolomTanggal)", false);
        $rows = $this->db->get()->result();

        $hasil = array_fill(1, 12, 0);
        foreach ($rows as $r) {
            $hasil[(int) $r->bulan] = (int) $r->total;
        }
        return array_values($hasil);
    }

    // ----------------------------------------------------------
    // TOTAL (dipakai dashboard dan cetak())
    // ----------------------------------------------------------
    public function getTotalJemaat()
    {
        return (int) $this->db->query("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Jemaat'")->row()->jumlah;
    }

    public function getTotalSimpatisan()
    {
        return (int) $this->db->query("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Simpatisan'")->row()->jumlah;
    }

    public function getTotalUmum()
    {
        return (int) $this->db->query("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Umum'")->row()->jumlah;
    }

    public function getTotalBaptis()
    {
        return (int) $this->db->query("SELECT COUNT(*) AS jumlah FROM aktabaptisan")->row()->jumlah;
    }

    // ----------------------------------------------------------
    // Dipakai oleh cetak() (PDF). Tidak diubah.
    // ----------------------------------------------------------
    public function getJemaatBaruPeriode($tglawal, $tglakhir)
    {
        $sql = "
            SELECT
                j.namalengkap,
                j.jeniskelamin,
                j.tanggalinsert,
                TIMESTAMPDIFF(YEAR, j.tanggallahir, CURDATE()) AS umur
            FROM jemaat j
            WHERE j.statusjemaat = 'Jemaat'
                AND j.tanggalinsert BETWEEN ? AND ?
            ORDER BY j.tanggalinsert ASC
        ";
        return $this->db->query($sql, array($tglawal, $tglakhir));
    }
}

/* End of file Dashboardcare_model.php */
/* Location: ./application/models/Dashboardcare_model.php */