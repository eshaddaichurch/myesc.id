<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardnextstep_model extends CI_Model
{

    public function getStatusMenunggu()
    {
        return $this->db->query("select * from v_pendaftarankelas where statuskonfirmasi='Menunggu' ");
    }

    public function getinfobox()
    {
        $rsData = $this->db->query("
                                    SELECT SUM(CASE WHEN idkelas='KL001' THEN 1 ELSE 0 END) AS MembershipClass,
                                                SUM(CASE WHEN idkelas='KL002' THEN 1 ELSE 0 END) AS FondationClass1,
                                                SUM(CASE WHEN idkelas='KL003' THEN 1 ELSE 0 END) AS FondationClass2,
                                                SUM(CASE WHEN idkelas='KL004' THEN 1 ELSE 0 END) AS FondationClass3,
                                                SUM(CASE WHEN idkelas='KL005' THEN 1 ELSE 0 END) AS Grade1,
                                                SUM(CASE WHEN idkelas='KL006' THEN 1 ELSE 0 END) AS Grade2,
                                                SUM(CASE WHEN idkelas='KL007' THEN 1 ELSE 0 END) AS Grade3,
                                                SUM(CASE WHEN idkelas='KL008' THEN 1 ELSE 0 END) AS FolunteerClass,
                                                SUM(CASE WHEN idkelas='KL101' THEN 1 ELSE 0 END) AS MarriageClass
                                                FROM registrasikelas WHERE statuslulus=1
                                    ");
        return $rsData;
    }


    public function getgrafikmembership()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL001' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }

    public function getgrafikfc1()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL002' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }

    public function getgrafikfc2()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL003' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }

    public function getgrafikfc3()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL004' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }


    public function getgrafikgrade1()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL005' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }

    public function getgrafikgrade2()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL006' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }


    public function getgrafikgrade3()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL007' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }


    public function getgrafikfolunteer()
    {
        $query = "
            SELECT SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=1)  THEN 1 ELSE 0 END) AS Jan,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=2)  THEN 1 ELSE 0 END) AS Feb,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=3)  THEN 1 ELSE 0 END) AS Mar,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=4)  THEN 1 ELSE 0 END) AS Apr,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=5)  THEN 1 ELSE 0 END) AS Mei,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=6)  THEN 1 ELSE 0 END) AS Jun,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=7)  THEN 1 ELSE 0 END) AS Jul,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=8)  THEN 1 ELSE 0 END) AS Ags,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=9)  THEN 1 ELSE 0 END) AS Sep,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=10)  THEN 1 ELSE 0 END) AS Okt,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=11)  THEN 1 ELSE 0 END) AS Nov,
                SUM( CASE WHEN (idkelas='KL008' AND MONTH(tglsertifikat)=12)  THEN 1 ELSE 0 END) AS Des
                FROM registrasikelas 
                WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
                    AND YEAR(tglsertifikat) = YEAR(NOW())
        ";
        return $this->db->query($query);
    }

    public function getgrafikfc2_old()
    {
        $query = "
    SELECT tglsertifikat, COUNT(*) AS jumlah
	FROM registrasikelas 
	WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
		AND YEAR(tglsertifikat) = '" . date('Y') . "' AND idkelas='KL003'
	GROUP BY tglsertifikat
        ";
        return $this->db->query($query);
    }

    public function getgrafikfc3_old()
    {
        $query = "
            SELECT tglsertifikat, COUNT(*) AS jumlah
	FROM registrasikelas 
	WHERE statuslulus=1  AND tglsertifikat IS NOT NULL
		AND YEAR(tglsertifikat) = '" . date('Y') . "' AND idkelas='KL004'
	GROUP BY tglsertifikat
        ";
        return $this->db->query($query);
    }

        // Ringkasan jumlah lulus per kelas dalam rentang tanggal sertifikat
    public function ringkasPeriode($tglawal, $tglakhir, $kelas)
    {
        if (empty($kelas)) {
            return array();
        }
        $ph = implode(',', array_fill(0, count($kelas), '?'));
        $binds = array_merge(array($tglawal, $tglakhir), $kelas);

        return $this->db->query(
            "SELECT idkelas, COUNT(*) AS jumlah
             FROM registrasikelas
             WHERE statuslulus = 1
               AND tglsertifikat IS NOT NULL
               AND DATE(tglsertifikat) BETWEEN ? AND ?
               AND idkelas IN ($ph)
             GROUP BY idkelas",
            $binds
        )->result_array();
    }

    // Daftar lulusan per kelas dalam rentang tanggal, untuk rincian PDF
    public function listLulusan($tglawal, $tglakhir, $kelas)
    {
        if (empty($kelas)) {
            return array();
        }
        $ph = implode(',', array_fill(0, count($kelas), '?'));
        $binds = array_merge(array($tglawal, $tglakhir), $kelas);

        return $this->db->query(
            "SELECT rk.idkelas, rk.tglsertifikat, rk.idregistrasi,
                    j.namalengkap, j.jeniskelamin
             FROM registrasikelas rk
             LEFT JOIN jemaat j ON j.idjemaat = rk.idjemaat
             WHERE rk.statuslulus = 1
               AND rk.tglsertifikat IS NOT NULL
               AND DATE(rk.tglsertifikat) BETWEEN ? AND ?
               AND rk.idkelas IN ($ph)
             ORDER BY rk.tglsertifikat ASC, j.namalengkap ASC",
            $binds
        )->result_array();
    }

    // Daftar kelas (kode dan nama) untuk pilihan filter
    public function getDaftarKelas()
    {
        return $this->db->query(
            "SELECT idkelas, namakelas FROM kelas ORDER BY idkelas"
        )->result_array();
    }
}

/* End of file Dashboardnextstep_model.php */
/* Location: ./application/models/Dashboardnextstep_model.php */