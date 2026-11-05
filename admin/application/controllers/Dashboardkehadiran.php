<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardkehadiran extends MY_controller
{
    private $namabulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    private $maksHari = 400;

    // Hari ibadah yang dicek kelengkapannya: 0 = Minggu, 1 = Senin, dst.
    private $hariIbadah = 0;

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D001');
        $this->load->model('Dashboardkehadiran_model');
    }

    public function index()
    {
        $f = $this->_filter();

        $data['menu']     = 'dashboardkehadiran';
        $data['jenis']    = $this->Dashboardkehadiran_model->getAbsenJenis();
        $data['idjenis']  = $f['idjenis'];
        $data['tglawal']  = $f['tglawal'];
        $data['tglakhir'] = $f['tglakhir'];
        $data['error']    = $f['error'];
        $this->load->view('dashboard/kehadiran', $data);
    }

    // Info bulan ini & bulan lalu (mengikuti jenis absen yang dipilih)
    public function getinfobox()
    {
        $m = $this->Dashboardkehadiran_model;
        $f = $this->_filter();

        $bulanIni  = new DateTime('first day of this month');
        $bulanLalu = (clone $bulanIni)->modify('-1 month');
        $duaBulan  = (clone $bulanIni)->modify('-2 month');

        $vIni  = $m->totalBulan($f['idjenis'], $bulanIni);
        $vLalu = $m->totalBulan($f['idjenis'], $bulanLalu);
        $vDua  = $m->totalBulan($f['idjenis'], $duaBulan);

        $this->_json(array(
            'success'            => true,
            'kehadiranbulanini'  => $vIni,
            'kehadiranbulanlalu' => $vLalu,
            'kenaikanbulanini'   => $this->_pct($vIni, $vLalu),
            'kenaikanbulanlalu'  => $this->_pct($vLalu, $vDua),
            'namabulanini'       => $this->_namaBulan($bulanIni),
            'namabulanlalu'      => $this->_namaBulan($bulanLalu),
        ));
    }

    // Data grafik tren, ringkasan, dan rincian harian untuk periode terpilih
    public function getgrafik()
    {
        $f = $this->_filter();
        $d = $this->_dataHarian($f);

        $this->_json(array_merge(array('success' => true, 'error' => $f['error']), $d));
    }

    // Jumlah per lokasi dan sesi untuk periode terpilih
    public function getlokasi()
    {
        $f    = $this->_filter();
        $rows = $this->Dashboardkehadiran_model->getLokasi($f['idjenis'], $f['tglawal'], $f['tglakhir']);

        $data = array();
        foreach ($rows as $r) {
            $data[] = array(
                'idlokasi'   => $r['idabsenlokasi'],
                'namalokasi' => $r['namaabsenlokasi'],
                'idsesi'     => $r['idsesi'],
                'namasesi'   => $r['namasesi'] ? $r['namasesi'] : 'Tanpa Sesi',
                'total'      => (int) $r['totalhadir'],
            );
        }

        $this->_json(array('success' => true, 'error' => $f['error'], 'data' => $data));
    }

    // Total per bulan untuk tahun dari tanggal akhir periode
    public function getbulan()
    {
        $f     = $this->_filter();
        $tahun = (int) substr($f['tglakhir'], 0, 4);
        $per   = $this->Dashboardkehadiran_model->getPerBulan($f['idjenis'], $tahun);

        $this->_json(array(
            'success' => true,
            'error'   => $f['error'],
            'tahun'   => $tahun,
            'bulan'   => $this->namabulan,
            'data'    => $per,
        ));
    }

    // Perbandingan periode terpilih dengan periode sebelumnya (panjang sama)
    public function getbanding()
    {
        $f  = $this->_filter();
        $m  = $this->Dashboardkehadiran_model;
        $ps = $this->_periodeSebelumnya($f['tglawal'], $f['tglakhir']);

        $now  = $m->totalPeriode($f['idjenis'], $f['tglawal'], $f['tglakhir']);
        $prev = $m->totalPeriode($f['idjenis'], $ps['awal'], $ps['akhir']);

        $this->_json(array(
            'success'  => true,
            'now'      => $now,
            'prev'     => $prev,
            'selisih'  => $now - $prev,
            'persen'   => $this->_pct($now, $prev),
            'prevawal' => $ps['awal'],
            'prevakhir'=> $ps['akhir'],
        ));
    }

    // Hari ibadah dalam periode yang belum ada catatan absennya
    public function getkosong()
    {
        $f = $this->_filter();
        $m = $this->Dashboardkehadiran_model;

        $ada    = $m->tanggalAda($f['idjenis'], $f['tglawal'], $f['tglakhir']);
        $kosong = $this->_hariIbadahKosong($f['tglawal'], $f['tglakhir'], $ada);

        $this->_json(array('success' => true, 'error' => $f['error'], 'data' => $kosong));
    }

    // Cetak PDF laporan kehadiran sesuai filter
    public function cetak()
    {
        error_reporting(0);

        $f = $this->_filter();
        if ($f['error'] !== '') {
            show_error($f['error'], 400);
            return;
        }

        $m = $this->Dashboardkehadiran_model;
        $this->load->library('Pdf');

        $harian = $this->_dataHarian($f);
        $lokasi = $m->getLokasi($f['idjenis'], $f['tglawal'], $f['tglakhir']);

        $ps    = $this->_periodeSebelumnya($f['tglawal'], $f['tglakhir']);
        $now   = $m->totalPeriode($f['idjenis'], $f['tglawal'], $f['tglakhir']);
        $prev  = $m->totalPeriode($f['idjenis'], $ps['awal'], $ps['akhir']);
        $kosong = $this->_hariIbadahKosong(
            $f['tglawal'], $f['tglakhir'],
            $m->tanggalAda($f['idjenis'], $f['tglawal'], $f['tglakhir'])
        );

        $jenisNama = '';
        foreach ($m->getAbsenJenis() as $j) {
            if ($j['idabsenjenis'] === $f['idjenis']) {
                $jenisNama = $j['namaabsenjenis'];
            }
        }

        $data = array(
            'info'      => $this->_infoGereja(),
            'jenisNama' => $jenisNama,
            'mulai'     => $f['tglawal'],
            'akhir'     => $f['tglakhir'],
            'harian'    => $harian,
            'lokasi'    => $lokasi,
            'banding'   => array(
                'now'      => $now,
                'prev'     => $prev,
                'selisih'  => $now - $prev,
                'persen'   => $this->_pct($now, $prev),
                'prevawal' => $ps['awal'],
                'prevakhir'=> $ps['akhir'],
            ),
            'kosong'    => $kosong,
        );

        $this->load->view('dashboard/cetakkehadiran_pdf', $data);
    }

    // =========================================================
    // PRIVATE HELPER
    // =========================================================

    /**
     * Data harian (grafik, ringkasan, tabel) untuk satu filter.
     * Dipakai oleh getgrafik() dan cetak().
     */
    private function _dataHarian($f)
    {
        $m        = $this->Dashboardkehadiran_model;
        $sesiList = $m->getSesi();
        $rows     = $m->getHarian($f['idjenis'], $f['tglawal'], $f['tglakhir']);

        $perTgl = array();
        foreach ($rows as $r) {
            $perTgl[$r['tgl']][$r['idsesi']] = (int) $r['jumlah'];
        }
        ksort($perTgl);

        $labels  = array();
        $tanggal = array();
        $totalHari = array();
        foreach ($perTgl as $tgl => $ps) {
            $labels[]    = date('d M', strtotime($tgl));
            $tanggal[]   = date('d-m-Y', strtotime($tgl));
            $totalHari[] = array_sum($ps);
        }

        $sesi = array();
        foreach ($sesiList as $s) {
            $data = array();
            $sum  = 0;
            foreach ($perTgl as $ps) {
                $v = isset($ps[$s['idsesi']]) ? $ps[$s['idsesi']] : 0;
                $data[] = $v;
                $sum   += $v;
            }
            $sesi[] = array(
                'id'    => $s['idsesi'],
                'nama'  => $s['namasesi'],
                'data'  => $data,
                'total' => $sum,
            );
        }

        $grand = array_sum($totalHari);
        $hari  = count($totalHari);

        $tertinggi = array('tgl' => '-', 'jumlah' => 0);
        foreach ($totalHari as $i => $t) {
            if ($t > $tertinggi['jumlah']) {
                $tertinggi = array('tgl' => $tanggal[$i], 'jumlah' => $t);
            }
        }

        $sesiTerbesar = array('nama' => '-', 'total' => 0);
        foreach ($sesi as $s) {
            if ($s['total'] > $sesiTerbesar['total']) {
                $sesiTerbesar = array('nama' => $s['nama'], 'total' => $s['total']);
            }
        }

        return array(
            'labels'    => $labels,
            'tanggal'   => $tanggal,
            'totalhari' => $totalHari,
            'sesi'      => $sesi,
            'ringkas'   => array(
                'total'         => $grand,
                'hari'          => $hari,
                'rata'          => $hari > 0 ? round($grand / $hari) : 0,
                'tertinggi'     => $tertinggi,
                'sesi_terbesar' => $sesiTerbesar,
            ),
        );
    }

    /**
     * Periode pembanding: panjang sama, berakhir sehari sebelum tglawal.
     */
    private function _periodeSebelumnya($awal, $akhir)
    {
        $a = new DateTime($awal);
        $b = new DateTime($akhir);
        $n = $a->diff($b)->days + 1;

        $pakhir = (clone $a)->modify('-1 day');
        $pawal  = (clone $pakhir)->modify('-' . ($n - 1) . ' days');

        return array('awal' => $pawal->format('Y-m-d'), 'akhir' => $pakhir->format('Y-m-d'));
    }

    /**
     * Hari ibadah (sesuai $hariIbadah) yang tidak punya catatan absen.
     * Hanya sampai hari ini.
     */
    private function _hariIbadahKosong($awal, $akhir, $ada)
    {
        $set  = array_flip($ada);
        $hari = date('Y-m-d');
        $out  = array();

        $d   = new DateTime($awal);
        $end = new DateTime($akhir);
        while ($d <= $end) {
            $tgl = $d->format('Y-m-d');
            if ($tgl > $hari) {
                break;
            }
            if ((int) $d->format('w') === $this->hariIbadah && !isset($set[$tgl])) {
                $out[] = array('tgl' => $tgl, 'label' => $d->format('d-m-Y'));
            }
            $d->modify('+1 day');
        }
        return $out;
    }

    private function _filter()
    {
        $idjenis  = (string) $this->input->get('idabsenjenis');
        $tglawal  = (string) $this->input->get('tglawal');
        $tglakhir = (string) $this->input->get('tglakhir');
        $error    = '';

        $defAwal  = date('Y-m-01');
        $defAkhir = date('Y-m-t');

        if (!$this->_validTgl($tglawal) || !$this->_validTgl($tglakhir)) {
            $tglawal  = $defAwal;
            $tglakhir = $defAkhir;
        } elseif ($tglawal > $tglakhir) {
            $error    = 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.';
            $tglawal  = $defAwal;
            $tglakhir = $defAkhir;
        } elseif ((strtotime($tglakhir) - strtotime($tglawal)) / 86400 > $this->maksHari) {
            $error    = 'Rentang periode maksimal ' . $this->maksHari . ' hari.';
            $tglawal  = $defAwal;
            $tglakhir = $defAkhir;
        }

        $ids = array_column($this->Dashboardkehadiran_model->getAbsenJenis(), 'idabsenjenis');
        if (!in_array($idjenis, $ids, true)) {
            $idjenis = isset($ids[0]) ? $ids[0] : '';
        }

        return array(
            'idjenis'  => $idjenis,
            'tglawal'  => $tglawal,
            'tglakhir' => $tglakhir,
            'error'    => $error,
        );
    }

    private function _validTgl($t)
    {
        $d = DateTime::createFromFormat('Y-m-d', $t);
        return $d && $d->format('Y-m-d') === $t;
    }

    private function _pct($a, $b)
    {
        if ($b == 0) {
            return 0;
        }
        return round(($a / $b) * 100 - 100, 1);
    }

    private function _namaBulan(DateTime $d)
    {
        return $this->namabulan[(int) $d->format('n') - 1] . ' ' . $d->format('Y');
    }

    private function _infoGereja()
    {
        $result = $this->db->query('SELECT * FROM infogereja LIMIT 1');
        if ($result && $result->num_rows() > 0) {
            return $result->row();
        }
        return (object) array('namagereja' => 'Nama Gereja', 'alamatgereja' => '', 'emailgereja' => '');
    }

    private function _json($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}

/* End of file Dashboardkehadiran.php */
/* Location: ./application/controllers/Dashboardkehadiran.php */