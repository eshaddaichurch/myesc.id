<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardkehadiran_model extends CI_Model
{
    public function getAbsenJenis()
    {
        return $this->db->query(
            "SELECT idabsenjenis, namaabsenjenis FROM absenjenis WHERE statusaktif = 'Aktif' ORDER BY idabsenjenis"
        )->result_array();
    }

    public function getSesi()
    {
        return $this->db->query(
            "SELECT idsesi, namasesi FROM sesiibadahminggu ORDER BY idsesi"
        )->result_array();
    }

    // Total kehadiran satu bulan penuh
    public function totalBulan($idjenis, DateTime $bulan)
    {
        $awal  = $bulan->format('Y-m-01');
        $akhir = $bulan->format('Y-m-t');

        return $this->totalPeriode($idjenis, $awal, $akhir);
    }

    // Total kehadiran dalam rentang tanggal (inklusif)
    public function totalPeriode($idjenis, $tglawal, $tglakhir)
    {
        $row = $this->db->query(
            "SELECT COALESCE(SUM(jumlahhadir), 0) AS jumlah
             FROM absen
             WHERE idabsenjenis = ?
               AND tglabsen >= ?
               AND tglabsen < DATE_ADD(?, INTERVAL 1 DAY)",
            array($idjenis, $tglawal, $tglakhir)
        )->row();

        return (int) $row->jumlah;
    }

    // Daftar tanggal (Y-m-d) yang sudah punya catatan absen untuk jenis ini
    public function tanggalAda($idjenis, $tglawal, $tglakhir)
    {
        $rows = $this->db->query(
            "SELECT DISTINCT DATE(tglabsen) AS tgl
             FROM absen
             WHERE idabsenjenis = ?
               AND tglabsen >= ?
               AND tglabsen < DATE_ADD(?, INTERVAL 1 DAY)",
            array($idjenis, $tglawal, $tglakhir)
        )->result_array();

        return array_column($rows, 'tgl');
    }

    // Total per tanggal dan sesi dalam periode
    public function getHarian($idjenis, $tglawal, $tglakhir)
    {
        return $this->db->query(
            "SELECT DATE(tglabsen) AS tgl, idsesi, SUM(jumlahhadir) AS jumlah
             FROM absen
             WHERE idabsenjenis = ?
               AND tglabsen >= ?
               AND tglabsen < DATE_ADD(?, INTERVAL 1 DAY)
             GROUP BY DATE(tglabsen), idsesi
             ORDER BY DATE(tglabsen)",
            array($idjenis, $tglawal, $tglakhir)
        )->result_array();
    }

    // Total per lokasi dan sesi dalam periode
    public function getLokasi($idjenis, $tglawal, $tglakhir)
    {
        return $this->db->query(
            "SELECT a.idabsenlokasi, l.namaabsenlokasi, a.idsesi, s.namasesi,
                    SUM(a.jumlahhadir) AS totalhadir
             FROM absen a
             LEFT JOIN absenlokasi l ON a.idabsenlokasi = l.idabsenlokasi
             LEFT JOIN sesiibadahminggu s ON a.idsesi = s.idsesi
             WHERE a.idabsenjenis = ?
               AND a.tglabsen >= ?
               AND a.tglabsen < DATE_ADD(?, INTERVAL 1 DAY)
               AND a.idabsenlokasi IS NOT NULL
               AND a.idabsenlokasi != ''
             GROUP BY a.idabsenlokasi, l.namaabsenlokasi, a.idsesi, s.namasesi
             ORDER BY a.idsesi, a.idabsenlokasi",
            array($idjenis, $tglawal, $tglakhir)
        )->result_array();
    }

    // Total per bulan (12 elemen) untuk satu tahun
    public function getPerBulan($idjenis, $tahun)
    {
        $per  = array_fill(0, 12, 0);
        $rows = $this->db->query(
            "SELECT MONTH(tglabsen) AS bln, SUM(jumlahhadir) AS jumlah
             FROM absen
             WHERE idabsenjenis = ? AND YEAR(tglabsen) = ?
             GROUP BY MONTH(tglabsen)",
            array($idjenis, (int) $tahun)
        )->result_array();

        foreach ($rows as $r) {
            $per[(int) $r['bln'] - 1] = (int) $r['jumlah'];
        }
        return $per;
    }
}

/* End of file Dashboardkehadiran_model.php */
/* Location: ./application/models/Dashboardkehadiran_model.php */