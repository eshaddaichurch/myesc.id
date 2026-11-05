<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare extends MY_controller
{
    private $namabulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

    private $namabulanpanjang = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D004');
        $this->cekOtorisasi();
        $this->load->model('Dashboardcare_model');
    }

    public function index()
    {
        $data['menu'] = 'dashboardcare';
        $data['tahun'] = $this->_tahun();
        $data['daftartahun'] = range((int) date('Y'), 2020);
        $this->load->view('dashboard/care', $data);
    }

    // =========================================================
    // DATA DASHBOARD (per tahun)
    // URL: dashboardcare/getdata?tahun=2026
    // =========================================================
    public function getdata()
    {
        $tahun = $this->_tahun();
        $m = $this->Dashboardcare_model;

        $series  = array();
        $summary = array();

        foreach ($this->_sumberData() as $kunci => $s) {
            $series[$kunci] = $m->grafikBulanan($s['table'], $s['tanggal'], $tahun, $s['where']);
            $tahunlalu      = $m->grafikBulanan($s['table'], $s['tanggal'], $tahun - 1, $s['where']);

            $summary[$kunci] = array(
                'total'     => array_sum($series[$kunci]),
                'tahunlalu' => array_sum($tahunlalu),
            );
        }

        $this->_json(array(
            'success'         => true,
            'tahun'           => $tahun,
            'bulan'           => $this->namabulan,
            'series'          => $series,
            'summary'         => $summary,
            'komposisi'       => array(
                'jemaat'     => $m->getTotalJemaat(),
                'simpatisan' => $m->getTotalSimpatisan(),
                'umum'       => $m->getTotalUmum(),
            ),
            'totalbaptisakta' => $m->getTotalBaptis(),
            'errors'          => array_values(array_unique($m->errors)),
        ));
    }

    // =========================================================
    // CETAK PDF (ringkasan + rincian nama per bulan)
    // URL: dashboardcare/cetak?tgl_mulai=2026-01-01&tgl_akhir=2026-03-31&kategori[]=jemaatbaru
    // =========================================================
    public function cetak()
    {
        error_reporting(0);

        $f = $this->_parseFilter();
        if (isset($f['error'])) {
            show_error($f['error'], 400);
            return;
        }

        $this->load->library('Pdf');

        $m         = $this->Dashboardcare_model;
        $sumber    = $this->_sumberData();
        $bulanKeys = $m->daftarBulan($f['mulai'], $f['akhir']);

        $labelBulan = array();
        $rincian    = array();
        foreach ($bulanKeys as $ym) {
            $labelBulan[$ym] = $this->namabulanpanjang[(int) substr($ym, 5, 2) - 1] . ' ' . substr($ym, 0, 4);
            $rincian[$ym]    = array();
        }

        $labels  = array();
        $summary = array();

        foreach ($f['kategori'] as $key) {
            $s = $sumber[$key];
            $labels[$key] = $s['label'];

            $rows = $m->listRincian(
                $s['table'], $s['tanggal'], $f['mulai'], $f['akhir'],
                $s['nama'], $s['detail'], $s['where']
            );

            $summary[$key] = count($rows);

            foreach ($rows as $r) {
                $ym = substr($r['tanggal'], 0, 7);
                if (isset($rincian[$ym])) {
                    $rincian[$ym][$key][] = $r;
                }
            }
        }

        $data = array(
            'rowInfoGereja' => $this->_getInfoGereja(),
            'mulai'         => $f['mulai'],
            'akhir'         => $f['akhir'],
            'kategori'      => $f['kategori'],
            'labels'        => $labels,
            'summary'       => $summary,
            'bulanKeys'     => $bulanKeys,
            'labelBulan'    => $labelBulan,
            'rincian'       => $rincian,
            'errors'        => array_values(array_unique($m->errors)),
        );

        $this->load->view('dashboard/cetakcare_pdf', $data);
    }

    // =========================================================
    // PRIVATE HELPER
    // =========================================================

    /**
     * Daftar sumber data.
     * table   : tabel/view sumber
     * tanggal : kolom tanggal acuan
     * where   : filter tambahan
     * nama    : ekspresi SQL untuk nama yang dicetak
     * detail  : ekspresi SQL untuk keterangan tambahan
     */
    private function _sumberData()
    {
        return array(
            'jemaatbaru' => array(
                'label'   => 'Pendaftar Akun',
                'table'   => 'v_carejemaatbaru',
                'tanggal' => 'tglinsert',
                'where'   => array(),
                'nama'    => 'namajemaat',
                'detail'  => "IFNULL(nohp, '-')",
            ),
            'pernikahan' => array(
                'label'   => 'Pernikahan',
                'table'   => 'v_aktanikah',
                'tanggal' => 'tglakta',
                'where'   => array(),
                'nama'    => "CONCAT(namajemaatpria, ' & ', namajemaatwanita)",
                'detail'  => "IFNULL(noakta, '-')",
            ),
            'penyerahananak' => array(
                'label'   => 'Penyerahan Anak',
                'table'   => 'v_aktapenyerahananak',
                'tanggal' => 'tglakta',
                'where'   => array(),
                'nama'    => 'namajemaatanak',
                'detail'  => "IFNULL(namagereja, '-')",
            ),
            'baptis' => array(
                'label'   => 'Baptis',
                'table'   => 'v_aktabaptisan',
                'tanggal' => 'tglakta',
                'where'   => array(),
                'nama'    => 'namalengkap',
                'detail'  => "IFNULL(noakta, '-')",
            ),
        );
    }

    /**
     * Validasi filter cetak. Return array mulai, akhir, kategori,
     * atau array berisi 'error' jika tidak valid.
     */
    private function _parseFilter()
    {
        $mulai = (string) $this->input->get('tgl_mulai');
        $akhir = (string) $this->input->get('tgl_akhir');

        $valid = function ($t) {
            $d = DateTime::createFromFormat('Y-m-d', $t);
            return $d && $d->format('Y-m-d') === $t;
        };

        if (!$valid($mulai) || !$valid($akhir)) {
            return array('error' => 'Tanggal tidak valid. Gunakan format Y-m-d.');
        }
        if ($mulai > $akhir) {
            return array('error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
        }

        $bulanMulai = (int) date('Y', strtotime($mulai)) * 12 + (int) date('n', strtotime($mulai));
        $bulanAkhir = (int) date('Y', strtotime($akhir)) * 12 + (int) date('n', strtotime($akhir));
        if (($bulanAkhir - $bulanMulai) > 60) {
            return array('error' => 'Rentang laporan maksimal 5 tahun (60 bulan).');
        }

        $kat = $this->input->get('kategori');
        if (is_string($kat)) {
            $kat = explode(',', $kat);
        }
        $kat = is_array($kat) ? $kat : array();

        $semua = array_keys($this->_sumberData());
        $kat   = array_values(array_intersect($semua, $kat));
        if (empty($kat)) {
            $kat = $semua;
        }

        return array('mulai' => $mulai, 'akhir' => $akhir, 'kategori' => $kat);
    }

    private function _tahun()
    {
        $t = (int) $this->input->get('tahun');
        if ($t >= 2000 && $t <= 2100) {
            return $t;
        }
        return (int) date('Y');
    }

    private function _json($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * Ambil info gereja dari tabel infogereja.
     * Return object kosong jika tabel kosong agar view tidak error.
     */
    private function _getInfoGereja()
    {
        $result = $this->db->query('SELECT * FROM infogereja LIMIT 1');
        if ($result && $result->num_rows() > 0) {
            return $result->row();
        }
        return (object) array(
            'namagereja'   => 'Nama Gereja',
            'alamatgereja' => '',
            'emailgereja'  => '',
        );
    }
}

/* End of file Dashboardcare.php */
/* Location: ./application/controllers/Dashboardcare.php */