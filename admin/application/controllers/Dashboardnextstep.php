<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardnextstep extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D003');
        $this->load->model('Dashboardnextstep_model');
    }

    public function index()
    {

        $f = $this->_filter();

        $data['rsMenunggu'] = $this->Dashboardnextstep_model->getStatusMenunggu();
        $data['menu']       = 'dashboardnextstep';
        $data['kelas']      = $this->_daftarKelas();
        $data['tglawal']    = $f['tglawal'];
        $data['tglakhir']   = $f['tglakhir'];
        $data['error']      = $f['error'];
        $this->load->view('dashboard/nextstep', $data);

        $rsMenunggu = $this->Dashboardnextstep_model->getStatusMenunggu();
        // var_dump($rsMenunggu);
        // exit;
        $data['rsMenunggu'] = $rsMenunggu;
        $data["menu"] = "dashboardnextstep";
        $this->load->view("dashboard/nextstep", $data);
    }

    public function detail()
    {
        $rsMenunggu = $this->Dashboardnextstep_model->getStatusMenunggu();
        // var_dump($rsMenunggu);
        // exit;
        $data['rsMenunggu'] = $rsMenunggu;
        $data["menu"] = "dashboardnextstep";
        $this->load->view("dashboard/nextstepdetail", $data);
    }

    public function getinfobox()
    {
        $rsinfobox = $this->Dashboardnextstep_model->getinfobox();
        $row = $rsinfobox->row_array();
        $hasil = array();
        foreach ((array) $row as $kunci => $nilai) {
            $hasil[$kunci] = (int) $nilai;
        }
        echo json_encode(array($hasil));
    }

    public function getgrafikmembership()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikmembership()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }

    public function getgrafikfc1()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfc1()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }

    public function getgrafikfc2()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfc2()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }


    public function getgrafikfc3()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfc3()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }


    public function getgrafikgrade1()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikgrade1()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }

    public function getgrafikgrade2()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikgrade2()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }


    public function getgrafikgrade3()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikgrade3()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }

    public function getgrafikfolunteer()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfolunteer()->row();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;

        $datatanggal = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        $jumlahmurid = array($rskelas->Jan, $rskelas->Feb, $rskelas->Mar, $rskelas->Apr, $rskelas->Mei, $rskelas->Jun, $rskelas->Jul, $rskelas->Ags, $rskelas->Sep, $rskelas->Okt, $rskelas->Nov, $rskelas->Des);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'totalsiswa' => $rskelas->Jan + $rskelas->Feb + $rskelas->Mar + $rskelas->Apr + $rskelas->Mei + $rskelas->Jun + $rskelas->Jul + $rskelas->Ags + $rskelas->Sep + $rskelas->Okt + $rskelas->Nov + $rskelas->Des
        );
        echo json_encode($data);
    }
    public function getgrafikfc2_old()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfc2();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;
        if ($rskelas->num_rows() > 0) {
            $i = 1;
            foreach ($rskelas->result() as $row) {
                $datatanggal[] = 'Tgl-' . date('d-m-Y', strtotime($row->tglsertifikat));
                $jumlahmurid[] = $row->jumlah;
                $ratarata[] = ($jumlah + $row->jumlah) / $i;

                $jumlah += $row->jumlah;
                $i++;
            }
        }

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'ratarata' => $ratarata,
            'totalsiswa' => $jumlah,
        );

        echo json_encode($data);
    }


    public function getgrafikfc3_old()
    {
        $rskelas = $this->Dashboardnextstep_model->getgrafikfc3();
        $datatanggal = array();
        $jumlahmurid = array();
        $ratarata = array();
        $jumlah = 0;
        if ($rskelas->num_rows() > 0) {
            $i = 1;
            foreach ($rskelas->result() as $row) {
                $datatanggal[] = 'Tgl-' . date('d-m-Y', strtotime($row->tglsertifikat));
                $jumlahmurid[] = $row->jumlah;
                $ratarata[] = ($jumlah + $row->jumlah) / $i;

                $jumlah += $row->jumlah;
                $i++;
            }
        }

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmurid' => $jumlahmurid,
            'ratarata' => $ratarata,
            'totalsiswa' => $jumlah,
        );

        echo json_encode($data);
    }

        // Ringkasan jumlah lulus per kelas untuk periode terpilih (dipakai kartu periode)
    public function getperiode()
    {
        $f     = $this->_filter();
        $kelas = $f['kelas'];
        $rows  = $this->Dashboardnextstep_model->ringkasPeriode($f['tglawal'], $f['tglakhir'], $kelas);

        $jumlah = array_fill_keys($kelas, 0);
        foreach ($rows as $r) {
            $jumlah[$r['idkelas']] = (int) $r['jumlah'];
        }

        $this->_json(array(
            'success' => true,
            'error'   => $f['error'],
            'jumlah'  => $jumlah,
            'total'   => array_sum($jumlah),
        ));
    }

    // Cetak PDF: ringkasan per kelas dan rincian lulusan per bulan dengan nama
    public function cetak()
    {
        error_reporting(0);

        $f = $this->_filter();
        if ($f['error'] !== '') {
            show_error($f['error'], 400);
            return;
        }

        $this->load->library('Pdf');

        $m     = $this->Dashboardnextstep_model;
        $kelas = $f['kelas'];

        $daftar = array();
        foreach ($m->getDaftarKelas() as $k) {
            $daftar[$k['idkelas']] = $k['namakelas'];
        }

        $rows = $m->listLulusan($f['tglawal'], $f['tglakhir'], $kelas);

        $bulanKeys = $this->_daftarBulan($f['tglawal'], $f['tglakhir']);
        $rincian   = array();
        foreach ($bulanKeys as $ym) {
            $rincian[$ym] = array();
        }

        $summary = array_fill_keys($kelas, 0);
        foreach ($rows as $r) {
            $summary[$r['idkelas']]++;
            $ym = substr($r['tglsertifikat'], 0, 7);
            if (isset($rincian[$ym])) {
                $rincian[$ym][$r['idkelas']][] = $r;
            }
        }

        $labelBulan = array();
        foreach ($bulanKeys as $ym) {
            $labelBulan[$ym] = $this->namabulanpanjang[(int) substr($ym, 5, 2) - 1] . ' ' . substr($ym, 0, 4);
        }

        $labels = array();
        foreach ($kelas as $k) {
            $labels[$k] = isset($daftar[$k]) ? $daftar[$k] : $k;
        }

        $data = array(
            'info'       => $this->_infoGereja(),
            'mulai'      => $f['tglawal'],
            'akhir'      => $f['tglakhir'],
            'kelas'      => $kelas,
            'labels'     => $labels,
            'summary'    => $summary,
            'bulanKeys'  => $bulanKeys,
            'labelBulan' => $labelBulan,
            'rincian'    => $rincian,
        );

        $this->load->view('dashboard/cetaknextstep_pdf', $data);
    }

    // =========================================================
    // PRIVATE HELPER
    // =========================================================

    private $namabulanpanjang = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    private $maksHari = 400;

    // Kode kelas yang boleh dicetak. Daftar ini tetap, dari kode yang dipakai grafik.
    private function _kodeKelas()
    {
        return array('KL001', 'KL002', 'KL003', 'KL004', 'KL005', 'KL006', 'KL007', 'KL008', 'KL101');
    }

    private function _daftarKelas()
    {
        $nama = array(
            'KL001' => 'Membership Class',
            'KL002' => 'Foundation Class 1',
            'KL003' => 'Foundation Class 2',
            'KL004' => 'Foundation Class 3',
            'KL005' => 'Grade 1',
            'KL006' => 'Grade 2',
            'KL007' => 'Grade 3',
            'KL008' => 'Volunteer Class',
            'KL101' => 'Marriage Class',
        );
        $out = array();
        foreach ($this->_kodeKelas() as $k) {
            $out[] = array('idkelas' => $k, 'namakelas' => $nama[$k]);
        }
        return $out;
    }

    private function _filter()
    {
        $tglawal  = (string) $this->input->get('tglawal');
        $tglakhir = (string) $this->input->get('tglakhir');
        $error    = '';

        $defAwal  = date('Y-01-01');
        $defAkhir = date('Y-12-31');

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

        // Kelas: array kelas[]=KL001&kelas[]=KL002. Hanya kode yang dikenal yang diterima.
        $kelasInput = $this->input->get('kelas');
        if (is_string($kelasInput)) {
            $kelasInput = explode(',', $kelasInput);
        }
        $kelasInput = is_array($kelasInput) ? $kelasInput : array();
        $kelas = array_values(array_intersect($this->_kodeKelas(), $kelasInput));
        if (empty($kelas)) {
            $kelas = $this->_kodeKelas();
        }

        return array('tglawal' => $tglawal, 'tglakhir' => $tglakhir, 'kelas' => $kelas, 'error' => $error);
    }

    private function _validTgl($t)
    {
        $d = DateTime::createFromFormat('Y-m-d', $t);
        return $d && $d->format('Y-m-d') === $t;
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

/* End of file Dashboardnextstep.php */
/* Location: ./application/controllers/Dashboardnextstep.php */