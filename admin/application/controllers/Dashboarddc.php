<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboarddc extends MY_controller
{
    private $namabulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    private $namabulanpanjang = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    private $maksHari = 400;

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'M506');
        $this->load->model('Dashboarddc_model');
    }

    public function index()
    {
        $f = $this->_filter();

        $data['menu']     = 'dashboarddc';
        $data['tglawal']  = $f['tglawal'];
        $data['tglakhir'] = $f['tglakhir'];
        $data['error']    = $f['error'];
        $this->load->view('dashboard/dc', $data);
    }

    // Kartu ringkasan: member baru bulan ini & lalu, jumlah DC & member aktif
    public function getinfobox()
    {
        $m = $this->Dashboarddc_model;

        $ini  = new DateTime('first day of this month');
        $lalu = (clone $ini)->modify('-1 month');
        $dua  = (clone $ini)->modify('-2 month');

        $vIni  = $m->memberBulan($ini);
        $vLalu = $m->memberBulan($lalu);
        $vDua  = $m->memberBulan($dua);

        $this->_json(array(
            'success'        => true,
            'memberBaruIni'  => $vIni,
            'memberBaruLalu' => $vLalu,
            'pctIni'         => $this->_pct($vIni, $vLalu),
            'pctLalu'        => $this->_pct($vLalu, $vDua),
            'namabulanini'   => $this->_namaBulan($ini),
            'namabulanlalu'  => $this->_namaBulan($lalu),
            'jumlahDc'       => $m->jumlahDc(),
            'jumlahMember'   => $m->jumlahMember(),
        ));
    }

    // Grafik harian member baru dan ringkasan untuk periode terpilih
    public function getgrafik()
    {
        $f    = $this->_filter();
        $rows = $this->Dashboarddc_model->getHarian($f['tglawal'], $f['tglakhir']);

        $labels  = array();
        $tanggal = array();
        $jumlah  = array();
        foreach ($rows as $r) {
            $labels[]  = date('d M', strtotime($r['tgl']));
            $tanggal[] = date('d-m-Y', strtotime($r['tgl']));
            $jumlah[]  = (int) $r['jumlah'];
        }

        $total = array_sum($jumlah);
        $hari  = count($jumlah);

        $tertinggi = array('tgl' => '-', 'jumlah' => 0);
        foreach ($jumlah as $i => $v) {
            if ($v > $tertinggi['jumlah']) {
                $tertinggi = array('tgl' => $tanggal[$i], 'jumlah' => $v);
            }
        }

        $this->_json(array(
            'success' => true,
            'error'   => $f['error'],
            'labels'  => $labels,
            'tanggal' => $tanggal,
            'jumlah'  => $jumlah,
            'ringkas' => array(
                'total'     => $total,
                'hari'      => $hari,
                'rata'      => $hari > 0 ? round($total / $hari, 1) : 0,
                'tertinggi' => $tertinggi,
            ),
        ));
    }

    // Perbandingan periode terpilih dengan periode sebelumnya (panjang sama)
    public function getbanding()
    {
        $f  = $this->_filter();
        $m  = $this->Dashboarddc_model;
        $ps = $this->_periodeSebelumnya($f['tglawal'], $f['tglakhir']);

        $now  = $m->memberPeriode($f['tglawal'], $f['tglakhir']);
        $prev = $m->memberPeriode($ps['awal'], $ps['akhir']);

        $this->_json(array('success' => true) + $this->_banding($now, $prev, $ps));
    }

    // Total per bulan untuk tahun dari tanggal akhir periode
    public function getbulan()
    {
        $f     = $this->_filter();
        $tahun = (int) substr($f['tglakhir'], 0, 4);

        $this->_json(array(
            'success' => true,
            'tahun'   => $tahun,
            'bulan'   => $this->namabulan,
            'data'    => $this->Dashboarddc_model->getPerBulan($tahun),
        ));
    }

    // Daftar DC aktif beserta jumlah member (untuk tabel)
    public function getdc()
    {
        $rows = $this->Dashboarddc_model->getDc()->result_array();
        $this->_json(array('success' => true, 'data' => $rows));
    }

    // Cetak PDF: ringkasan dan member baru per bulan (dengan nama)
    public function cetak()
    {
        error_reporting(0);

        $f = $this->_filter();
        if ($f['error'] !== '') {
            show_error($f['error'], 400);
            return;
        }

        $this->load->library('Pdf');

        $m        = $this->Dashboarddc_model;
        $ps       = $this->_periodeSebelumnya($f['tglawal'], $f['tglakhir']);
        $baru     = $m->getMemberBaru($f['tglawal'], $f['tglakhir']);
        $bulanKeys = $this->_daftarBulan($f['tglawal'], $f['tglakhir']);

        $rincian = array_fill_keys($bulanKeys, array());
        foreach ($baru as $r) {
            $ym = substr($r['tglkonfirmasi'], 0, 7);
            if (isset($rincian[$ym])) {
                $rincian[$ym][] = $r;
            }
        }

        $labelBulan = array();
        foreach ($bulanKeys as $ym) {
            $labelBulan[$ym] = $this->namabulanpanjang[(int) substr($ym, 5, 2) - 1] . ' ' . substr($ym, 0, 4);
        }

        $now  = count($baru);
        $prev = $m->memberPeriode($ps['awal'], $ps['akhir']);

        $data = array(
            'info'         => $this->_infoGereja(),
            'mulai'        => $f['tglawal'],
            'akhir'        => $f['tglakhir'],
            'banding'      => $this->_banding($now, $prev, $ps),
            'bulanKeys'    => $bulanKeys,
            'labelBulan'   => $labelBulan,
            'rincian'      => $rincian,
            'jumlahDc'     => $m->jumlahDc(),
            'jumlahMember' => $m->jumlahMember(),
        );

        $this->load->view('dashboard/cetakdc_pdf', $data);
    }

    // Cetak Excel: daftar DC dan member baru (format .xls berupa tabel HTML)
    public function cetakexcel()
    {
        error_reporting(0);

        $f = $this->_filter();
        if ($f['error'] !== '') {
            show_error($f['error'], 400);
            return;
        }

        $filename = 'laporan-dc-' . $f['tglawal'] . '_sd_' . $f['tglakhir'] . '.xls';
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $data = array(
            'mulai'      => $f['tglawal'],
            'akhir'      => $f['tglakhir'],
            'rekapDc'    => $this->_rekapDc(),
            'memberBaru' => $this->Dashboarddc_model->getMemberBaru($f['tglawal'], $f['tglakhir']),
        );

        $this->load->view('dashboard/cetakdc_excel', $data);
    }

    // Laporan anggota per DC (memakai view cetakdc_anggota_pdf)
    public function cetaklaporananggota()
    {
        error_reporting(0);

        $this->load->library('Pdf');

        $m      = $this->Dashboarddc_model;
        $filter = $this->_filterAnggota();

        $data = array(
            'rowInfoGereja'      => $this->_infoGereja(),
            'rsDc'               => $m->getDc(),
            'jumlahDc'           => $m->jumlahDc(),
            'jumlahMember'       => $m->jumlahMember(),
            'filterJeniskelamin' => $filter['jeniskelamin'],
            'filterUmur'         => $filter['umur'],
            'filterStatus'       => $filter['status'],
        );

        $this->load->view('dashboard/cetakdc_anggota_pdf', $data);
    }

    // =========================================================
    // PRIVATE HELPER
    // =========================================================

    // Rekap per DC untuk Excel: nama, DM, daftar Core Team, dan jumlah member
    private function _rekapDc()
    {
        $m    = $this->Dashboarddc_model;
        $out  = array();

        foreach ($m->getDc()->result_array() as $dc) {
            $ct = array_column($m->getCT($dc['iddc'])->result_array(), 'namalengkap');
            $out[] = array(
                'nama'   => $dc['namadc'],
                'dm'     => !empty($dc['namadm']) ? $dc['namadm'] : '-',
                'ct'     => $ct,
                'jumlah' => (int) $dc['jumlah'],
            );
        }
        return $out;
    }

    // Validasi filter anggota (jenis kelamin, umur, status)
    private function _filterAnggota()
    {
        $jk     = (string) $this->input->get('jeniskelamin');
        $umur   = (string) $this->input->get('umur');
        $status = (string) $this->input->get('status');

        if (!in_array($jk, array('', 'Laki-laki', 'Perempuan'), true)) {
            $jk = '';
        }
        if (!in_array($umur, array('', '0-17', '18-25', '26-35', '36-45', '46-99'), true)) {
            $umur = '';
        }
        if (!in_array($status, array('', 'Core Team', 'Member'), true)) {
            $status = '';
        }

        return array('jeniskelamin' => $jk, 'umur' => $umur, 'status' => $status);
    }

    // Data periode dari GET: tanggal dan validasi
    private function _filter()
    {
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

        return array('tglawal' => $tglawal, 'tglakhir' => $tglakhir, 'error' => $error);
    }

    // Periode pembanding: panjang sama, berakhir sehari sebelum tglawal
    private function _periodeSebelumnya($awal, $akhir)
    {
        $a = new DateTime($awal);
        $b = new DateTime($akhir);
        $n = $a->diff($b)->days + 1;

        $pakhir = (clone $a)->modify('-1 day');
        $pawal  = (clone $pakhir)->modify('-' . ($n - 1) . ' days');

        return array('awal' => $pawal->format('Y-m-d'), 'akhir' => $pakhir->format('Y-m-d'));
    }

    private function _banding($now, $prev, $ps)
    {
        return array(
            'now'       => $now,
            'prev'      => $prev,
            'selisih'   => $now - $prev,
            'persen'    => $this->_pct($now, $prev),
            'prevawal'  => $ps['awal'],
            'prevakhir' => $ps['akhir'],
        );
    }

    private function _daftarBulan($awal, $akhir)
    {
        $a   = new DateTime(substr($awal, 0, 8) . '01');
        $b   = new DateTime(substr($akhir, 0, 8) . '01');
        $out = array();
        while ($a <= $b) {
            $out[] = $a->format('Y-m');
            $a->modify('+1 month');
        }
        return $out;
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

/* End of file Dashboarddc.php */
/* Location: ./application/controllers/Dashboarddc.php */