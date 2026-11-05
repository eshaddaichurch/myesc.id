<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboarddc_model extends CI_Model
{
    // Member baru (disetujui) dalam satu bulan penuh
    public function memberBulan(DateTime $bulan)
    {
        return $this->memberPeriode($bulan->format('Y-m-01'), $bulan->format('Y-m-t'));
    }

    // Member baru (disetujui) dalam rentang tanggal, inklusif
    public function memberPeriode($tglawal, $tglakhir)
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS jumlah
             FROM dcmember_permohonan
             WHERE statuskonfirmasi = 'Disetujui'
               AND tglkonfirmasi >= ?
               AND tglkonfirmasi < DATE_ADD(?, INTERVAL 1 DAY)",
            array($tglawal, $tglakhir)
        )->row();

        return (int) $row->jumlah;
    }

    // Jumlah member baru per hari dalam rentang tanggal
    public function getHarian($tglawal, $tglakhir)
    {
        return $this->db->query(
            "SELECT DATE(tglkonfirmasi) AS tgl, COUNT(*) AS jumlah
             FROM dcmember_permohonan
             WHERE statuskonfirmasi = 'Disetujui'
               AND tglkonfirmasi >= ?
               AND tglkonfirmasi < DATE_ADD(?, INTERVAL 1 DAY)
             GROUP BY DATE(tglkonfirmasi)
             ORDER BY DATE(tglkonfirmasi)",
            array($tglawal, $tglakhir)
        )->result_array();
    }

    // Jumlah member baru per bulan (12 elemen) untuk satu tahun
    public function getPerBulan($tahun)
    {
        $per  = array_fill(0, 12, 0);
        $rows = $this->db->query(
            "SELECT MONTH(tglkonfirmasi) AS bln, COUNT(*) AS jumlah
             FROM dcmember_permohonan
             WHERE statuskonfirmasi = 'Disetujui' AND YEAR(tglkonfirmasi) = ?
             GROUP BY MONTH(tglkonfirmasi)",
            array((int) $tahun)
        )->result_array();

        foreach ($rows as $r) {
            $per[(int) $r['bln'] - 1] = (int) $r['jumlah'];
        }
        return $per;
    }

    // Daftar member baru (dengan nama) dalam rentang tanggal, array
    public function getMemberBaru($tglawal, $tglakhir)
    {
        return $this->db->query(
            "SELECT * FROM v_dcmember_permohonan
             WHERE statuskonfirmasi = 'Disetujui'
               AND tglkonfirmasi >= ?
               AND tglkonfirmasi < DATE_ADD(?, INTERVAL 1 DAY)
             ORDER BY tglkonfirmasi ASC",
            array($tglawal, $tglakhir)
        )->result_array();
    }

    public function jumlahDc()
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS jumlah FROM disciplescommunity WHERE statusaktif = 'Aktif'"
        )->row();
        return (int) $row->jumlah;
    }

    public function jumlahMember()
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS jumlah FROM dcmember WHERE statusaktif = 'Aktif'"
        )->row();
        return (int) $row->jumlah;
    }

    // Daftar DC aktif beserta jumlah member aktif (objek query)
    public function getDc()
    {
        return $this->db->query(
            "SELECT v.*,
                    (SELECT COUNT(*) FROM dcmember dm
                     WHERE dm.iddc = v.iddc AND dm.statusaktif = 'Aktif') AS jumlah
             FROM v_disciplescommunity v
             WHERE v.statusaktif = 'Aktif'
             ORDER BY v.namadc"
        );
    }

    // Core Team satu DC (objek query)
    public function getCT($iddc)
    {
        return $this->db->query(
            "SELECT * FROM v_dcmember
             WHERE iddc = ? AND statusaktif = 'Aktif' AND statuskeanggotaan = 'Core Team'
             ORDER BY namalengkap",
            array($iddc)
        );
    }

    // Anggota aktif satu DC dengan filter opsional (objek query, parameter binding)
    public function getAnggotaPerDc($iddc, $jeniskelamin = '', $umurRange = '', $status = '')
    {
        $sql = "SELECT j.namalengkap, j.jeniskelamin,
                       TIMESTAMPDIFF(YEAR, j.tanggallahir, CURDATE()) AS umur,
                       j.nohp, j.email,
                       dm.statuskeanggotaan, dm.tanggalinsert AS tglbergabung
                FROM dcmember dm
                JOIN jemaat j ON j.idjemaat = dm.idjemaat
                WHERE dm.iddc = ? AND dm.statusaktif = 'Aktif'";
        $binds = array($iddc);

        if ($jeniskelamin !== '') {
            $sql .= " AND j.jeniskelamin = ?";
            $binds[] = $jeniskelamin;
        }
        if ($umurRange !== '') {
            $arr = explode('-', $umurRange);
            if (count($arr) === 2) {
                $sql .= " AND TIMESTAMPDIFF(YEAR, j.tanggallahir, CURDATE()) BETWEEN ? AND ?";
                $binds[] = (int) $arr[0];
                $binds[] = (int) $arr[1];
            }
        }
        if ($status !== '') {
            $sql .= " AND dm.statuskeanggotaan = ?";
            $binds[] = $status;
        }

        $sql .= " ORDER BY dm.statuskeanggotaan DESC, j.namalengkap ASC";

        return $this->db->query($sql, $binds);
    }
}

/* End of file Dashboarddc_model.php */
/* Location: ./application/models/Dashboarddc_model.php */