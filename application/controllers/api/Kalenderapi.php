<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Kalenderapi extends BaseApi
{
    const WARNA_DEFAULT = array(
        'ibadah'   => '#FF5008',
        'doa'      => '#C49A14',
        'dc'       => '#2D6B5E',
        'nextstep' => '#1A6B3C',
        'youth'    => '#5B4A8A',
        'default'  => '#888888',
    );

    // GET /api/kalender/bulan?bulan=11&tahun=2026
    public function bulan()
    {
        $bulan = (int) $this->input->get('bulan');
        $tahun = (int) $this->input->get('tahun');

        if ($bulan < 1 || $bulan > 12) {
            $bulan = (int) date('n');
        }
        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) date('Y');
        }

        // Rentang tanggal dihitung di PHP, lalu dipakai sebagai parameter binding
        $mulai   = sprintf('%04d-%02d-01', $tahun, $bulan);
        $selesai = date('Y-m-d', strtotime($mulai . ' +1 month'));

        $rows = $this->db->query(
            "SELECT tgljadwal, namaevent, namakelas, tema, subtema, jenisjadwal,
                    warnapenjadwalan, jammulai, jamselesai
             FROM v_jadwaleventdetailtanggal_tampildiwebsite
             WHERE statuskonfirmasi = 'Disetujui'
               AND tgljadwal >= ?
               AND tgljadwal < ?
             ORDER BY tgljadwal, jammulai",
            array($mulai, $selesai)
        )->result();

        $data = array();
        foreach ($rows as $r) {
            $jenisKey = $this->_jenisKey($r->jenisjadwal);

            $data[] = array(
                'tanggal'     => substr((string) $r->tgljadwal, 0, 10),
                'namaevent'   => (string) $r->namaevent,
                'namakelas'   => (string) $r->namakelas,
                'tema'        => (string) $r->tema,
                'subtema'     => (string) $r->subtema,
                'jenisjadwal' => (string) $r->jenisjadwal,
                'jenis_key'   => $jenisKey,
                'warna'       => $this->_warna($r->warnapenjadwalan, $jenisKey),
                'jammulai'    => substr((string) $r->jammulai, 0, 5),
                'jamselesai'  => empty($r->jamselesai) ? '' : substr((string) $r->jamselesai, 0, 5),
            );
        }

        $this->jsonSuccess(array(
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data'  => $data,
        ));
    }

    // ============================================================
    // Helper
    // ============================================================

    private function _jenisKey($jenis)
    {
        $j = strtolower(trim((string) $jenis));

        if (strpos($j, 'ibadah') !== false) return 'ibadah';
        if (strpos($j, 'doa') !== false || strpos($j, 'fasting') !== false || strpos($j, 'menara') !== false) return 'doa';
        if (strpos($j, 'disciple') !== false || $j === 'dc') return 'dc';
        if (strpos($j, 'next step') !== false) return 'nextstep';
        if (strpos($j, 'youth') !== false || strpos($j, 'remaja') !== false || strpos($j, 'pemuda') !== false) return 'youth';

        return 'default';
    }

    private function _warna($warnaDb, $jenisKey)
    {
        $w = ltrim(trim((string) $warnaDb), '#');
        if (preg_match('/^[0-9A-Fa-f]{6}$/', $w)) {
            return '#' . strtoupper($w);
        }
        return self::WARNA_DEFAULT[$jenisKey] ?? '#888888';
    }
}

/* End of file Kalenderapi.php */
/* Location: ./application/controllers/api/Kalenderapi.php */