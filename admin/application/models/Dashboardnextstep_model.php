<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardnextstep_model extends CI_Model
{
    public function getStatusMenunggu()
    {
        return $this->db->query("SELECT * FROM v_pendaftarankelas WHERE statuskonfirmasi = 'Menunggu'");
    }

    public function getinfobox()
    {
        return $this->db->query("
            SELECT SUM(CASE WHEN idkelas='KL001' THEN 1 ELSE 0 END) AS MembershipClass,
                   SUM(CASE WHEN idkelas='KL002' THEN 1 ELSE 0 END) AS FondationClass1,
                   SUM(CASE WHEN idkelas='KL003' THEN 1 ELSE 0 END) AS FondationClass2,
                   SUM(CASE WHEN idkelas='KL004' THEN 1 ELSE 0 END) AS FondationClass3,
                   SUM(CASE WHEN idkelas='KL005' THEN 1 ELSE 0 END) AS Grade1,
                   SUM(CASE WHEN idkelas='KL006' THEN 1 ELSE 0 END) AS Grade2,
                   SUM(CASE WHEN idkelas='KL007' THEN 1 ELSE 0 END) AS Grade3,
                   SUM(CASE WHEN idkelas='KL008' THEN 1 ELSE 0 END) AS FolunteerClass,
                   SUM(CASE WHEN idkelas='KL101' THEN 1 ELSE 0 END) AS MarriageClass
            FROM registrasikelas
            WHERE statuslulus = 1
        ");
    }

    public function getgrafikmembership() { return $this->_pivot('KL001'); }
    public function getgrafikfc1()        { return $this->_pivot('KL002'); }
    public function getgrafikfc2()        { return $this->_pivot('KL003'); }
    public function getgrafikfc3()        { return $this->_pivot('KL004'); }
    public function getgrafikgrade1()     { return $this->_pivot('KL005'); }
    public function getgrafikgrade2()     { return $this->_pivot('KL006'); }
    public function getgrafikgrade3()     { return $this->_pivot('KL007'); }
    public function getgrafikfolunteer()  { return $this->_pivot('KL008'); }

    /**
     * Pivot 12 bulan untuk satu kode kelas pada tahun berjalan.
     * Kode kelas di-binding, bukan disisipkan ke string SQL.
     */
    private function _pivot($idkelas)
    {
        $sql = "SELECT
                    SUM(CASE WHEN MONTH(tglsertifikat)=1  THEN 1 ELSE 0 END) AS Jan,
                    SUM(CASE WHEN MONTH(tglsertifikat)=2  THEN 1 ELSE 0 END) AS Feb,
                    SUM(CASE WHEN MONTH(tglsertifikat)=3  THEN 1 ELSE 0 END) AS Mar,
                    SUM(CASE WHEN MONTH(tglsertifikat)=4  THEN 1 ELSE 0 END) AS Apr,
                    SUM(CASE WHEN MONTH(tglsertifikat)=5  THEN 1 ELSE 0 END) AS Mei,
                    SUM(CASE WHEN MONTH(tglsertifikat)=6  THEN 1 ELSE 0 END) AS Jun,
                    SUM(CASE WHEN MONTH(tglsertifikat)=7  THEN 1 ELSE 0 END) AS Jul,
                    SUM(CASE WHEN MONTH(tglsertifikat)=8  THEN 1 ELSE 0 END) AS Ags,
                    SUM(CASE WHEN MONTH(tglsertifikat)=9  THEN 1 ELSE 0 END) AS Sep,
                    SUM(CASE WHEN MONTH(tglsertifikat)=10 THEN 1 ELSE 0 END) AS Okt,
                    SUM(CASE WHEN MONTH(tglsertifikat)=11 THEN 1 ELSE 0 END) AS Nov,
                    SUM(CASE WHEN MONTH(tglsertifikat)=12 THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas
                WHERE statuslulus = 1
                  AND idkelas = ?
                  AND tglsertifikat IS NOT NULL
                  AND YEAR(tglsertifikat) = YEAR(NOW())";

        return $this->db->query($sql, array($idkelas));
    }

    /**
     * Jalankan query SELECT. Jika gagal, kembalikan array kosong dan catat error ke log.
     */
    private function _rows($sql, $binds = array())
    {
        $q = $this->db->query($sql, $binds);
        if ($q === false) {
            $err = $this->db->error();
            log_message('error', 'Dashboardnextstep: ' . $err['message'] . ' | SQL: ' . $sql);
            return array();
        }
        return $q->result_array();
    }

    // Ringkasan jumlah lulus per kelas dalam rentang tanggal sertifikat
    public function ringkasPeriode($tglawal, $tglakhir, $kelas)
    {
        if (empty($kelas)) {
            return array();
        }
        $ph    = implode(',', array_fill(0, count($kelas), '?'));
        $binds = array_merge(array($tglawal, $tglakhir), $kelas);

        return $this->_rows(
            "SELECT idkelas, COUNT(*) AS jumlah
             FROM registrasikelas
             WHERE statuslulus = 1
               AND tglsertifikat IS NOT NULL
               AND DATE(tglsertifikat) BETWEEN ? AND ?
               AND idkelas IN ($ph)
             GROUP BY idkelas",
            $binds
        );
    }

    // Daftar lulusan per kelas dalam rentang tanggal, untuk rincian PDF
    public function listLulusan($tglawal, $tglakhir, $kelas)
    {
        if (empty($kelas)) {
            return array();
        }
        $ph    = implode(',', array_fill(0, count($kelas), '?'));
        $binds = array_merge(array($tglawal, $tglakhir), $kelas);

        return $this->_rows(
            "SELECT v.idkelas, v.tglsertifikat, v.namalengkap, v.jeniskelamin
             FROM v_pendaftarankelas v
             WHERE v.statuslulus = 1
               AND v.tglsertifikat IS NOT NULL
               AND DATE(v.tglsertifikat) BETWEEN ? AND ?
               AND v.idkelas IN ($ph)
             ORDER BY v.tglsertifikat ASC, v.namalengkap ASC",
            $binds
        );
    }
}

/* End of file Dashboardnextstep_model.php */
/* Location: ./application/models/Dashboardnextstep_model.php */