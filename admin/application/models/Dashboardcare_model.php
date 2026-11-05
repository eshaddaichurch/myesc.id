<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare_model extends CI_Model
{
    // Daftar error query, dikirim ke view agar mudah dilacak
    public $errors = array();

    /**
     * Jalankan query tanpa melempar error halaman CI.
     * Return FALSE jika query gagal, dan error dicatat di $this->errors.
     */
    private function _query($sql)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $q = $this->db->query($sql);
        $this->db->db_debug = $debug;

        if ($q === FALSE) {
            $err = $this->db->error();
            $this->errors[] = $err['message'];
            log_message('error', 'Dashboardcare: ' . $err['message'] . ' | SQL: ' . $sql);
            return FALSE;
        }
        return $q;
    }

    private function _scalar($sql)
    {
        $q = $this->_query($sql);
        if ($q === FALSE) {
            return 0;
        }
        $row = $q->row();
        return $row ? (int) $row->jumlah : 0;
    }

    /**
     * Jumlah data per bulan dalam satu tahun.
     * Return: array 12 elemen (Jan..Des), selalu lengkap.
     */
    public function grafikBulanan($table, $kolomTanggal, $tahun, $where = array())
    {
        $hasil = array_fill(1, 12, 0);

        $sql = "SELECT MONTH($kolomTanggal) AS bulan, COUNT(*) AS total
                FROM $table
                WHERE $kolomTanggal IS NOT NULL
                  AND YEAR($kolomTanggal) = " . (int) $tahun;

        foreach ($where as $kolom => $nilai) {
            $sql .= " AND $kolom = " . $this->db->escape($nilai);
        }
        $sql .= " GROUP BY MONTH($kolomTanggal)";

        $q = $this->_query($sql);
        if ($q === FALSE) {
            return array_values($hasil);
        }

        foreach ($q->result() as $r) {
            $hasil[(int) $r->bulan] = (int) $r->total;
        }
        return array_values($hasil);
    }

    public function getTotalJemaat()
    {
        return $this->_scalar("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Jemaat'");
    }

    public function getTotalSimpatisan()
    {
        return $this->_scalar("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Simpatisan'");
    }

    public function getTotalUmum()
    {
        return $this->_scalar("SELECT COUNT(*) AS jumlah FROM jemaat WHERE statusjemaat = 'Umum'");
    }

    public function getTotalBaptis()
    {
        return $this->_scalar("SELECT COUNT(*) AS jumlah FROM aktabaptisan");
    }

    /**
     * Dipakai oleh cetak() (PDF). Tidak diubah.
     */
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