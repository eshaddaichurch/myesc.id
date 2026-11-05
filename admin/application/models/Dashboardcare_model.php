<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare_model extends CI_Model
{
    public $errors = array();

    /**
     * Jalankan query tanpa melempar error halaman CI.
     * Return FALSE jika gagal, dan pesan error dicatat di $this->errors.
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
     * Jumlah per bulan dalam satu tahun (untuk dashboard).
     * Return: array 12 elemen (Jan..Des).
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

    /**
     * Daftar detail (nama per baris) dalam rentang tanggal, untuk laporan PDF.
     * $namaExpr dan $detailExpr berupa ekspresi SQL (kolom atau CONCAT, dll).
     * Return: array baris ['tanggal', 'nama', 'keterangan'], urut tanggal.
     */
    public function listRincian($table, $kolomTanggal, $tglMulai, $tglAkhir, $namaExpr, $detailExpr, $where = array())
    {
        $sql = "SELECT $kolomTanggal AS tanggal,
                       ($namaExpr) AS nama,
                       ($detailExpr) AS keterangan
                FROM $table
                WHERE $kolomTanggal IS NOT NULL
                  AND DATE($kolomTanggal) BETWEEN " . $this->db->escape($tglMulai) . "
                                              AND " . $this->db->escape($tglAkhir);

        foreach ($where as $kolom => $nilai) {
            $sql .= " AND $kolom = " . $this->db->escape($nilai);
        }
        $sql .= " ORDER BY $kolomTanggal ASC";

        $q = $this->_query($sql);
        return $q === FALSE ? array() : $q->result_array();
    }

    /**
     * Daftar bulan dari tanggal mulai sampai tanggal akhir, format 'YYYY-MM'.
     */
    public function daftarBulan($tglMulai, $tglAkhir)
    {
        $awal  = new DateTime(date('Y-m-01', strtotime($tglMulai)));
        $akhir = new DateTime(date('Y-m-01', strtotime($tglAkhir)));
        $list  = array();

        while ($awal <= $akhir) {
            $list[] = $awal->format('Y-m');
            $awal->modify('+1 month');
        }
        return $list;
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
}

/* End of file Dashboardcare_model.php */
/* Location: ./application/models/Dashboardcare_model.php */