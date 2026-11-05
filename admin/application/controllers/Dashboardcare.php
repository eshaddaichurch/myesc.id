<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare extends MY_controller
{
    private $namabulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D004');
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
    // DATA DASHBOARD (satu request untuk semua kartu, grafik, tabel)
    // URL: dashboardcare/getdata?tahun=2026
    // =========================================================
    public function getdata()
    {
        $tahun = $this->_tahun();
        $m = $this->Dashboardcare_model;

        $series = array();
        $summary = array();

        foreach ($this->_sumberData() as $kunci => $s) {
            list($table, $kolom, $where) = $s;

            $series[$kunci] = $m->grafikBulanan($table, $kolom, $tahun, $where);
            $tahunlalu = $m->grafikBulanan($table, $kolom, $tahun - 1, $where);

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
        ));
    }

    // =========================================================
    // CETAK PDF / EXCEL
    // URL: dashboardcare/cetak/pdf/2025-01-01/2025-01-31
    // URL: dashboardcare/cetak/excel/2025-01-01/2025-01-31
    // =========================================================
    public function cetak($jenisCetakan = 'pdf', $tglawal = '', $tglakhir = '')
    {
        error_reporting(0);

        if (empty($tglawal) || empty($tglakhir)) {
            show_error('Parameter tanggal tidak valid.', 400);
            return;
        }
        if (!strtotime($tglawal) || !strtotime($tglakhir)) {
            show_error('Format tanggal tidak valid. Gunakan format Y-m-d.', 400);
            return;
        }

        if ($jenisCetakan === 'pdf') {
            $this->load->library('Pdf');
        }

        $rsJemaatBaru = $this->Dashboardcare_model->getJemaatBaruPeriode($tglawal, $tglakhir);

        if ($rsJemaatBaru === false || $rsJemaatBaru === null) {
            $lastQuery = $this->db->last_query();
            $dbError = $this->db->error();
            show_error(
                '<b>Query getJemaatBaruPeriode() gagal.</b><br><br>'
                    . '<b>DB Error:</b> [' . $dbError['code'] . '] ' . $dbError['message'] . '<br><br>'
                    . '<b>Query yang dijalankan:</b><br><pre>' . $lastQuery . '</pre>'
                    . '<br>Sesuaikan nama tabel dan kolom di Dashboardcare_model::getJemaatBaruPeriode()',
                500
            );
            return;
        }

        $data = array(
            'rowInfoGereja'     => $this->_getInfoGereja(),
            'rsJemaatBaru'      => $rsJemaatBaru,
            'tglawal'           => $tglawal,
            'tglakhir'          => $tglakhir,
            'totalJemaat'       => $this->Dashboardcare_model->getTotalJemaat() ?? 0,
            'totalSimpatisan'   => $this->Dashboardcare_model->getTotalSimpatisan() ?? 0,
            'totalBaptis'       => $this->Dashboardcare_model->getTotalBaptis() ?? 0,
            'jemaatBaruPeriode' => $rsJemaatBaru->num_rows(),
        );

        if ($jenisCetakan === 'pdf') {
            $this->load->view('dashboard/cetakcare_pdf', $data);
        } elseif ($jenisCetakan === 'excel') {
            $this->load->view('dashboard/cetakcare_excel', $data);
        }
    }

    // =========================================================
    // PRIVATE HELPER
    // =========================================================

    /**
     * Daftar sumber data dashboard.
     * Format: key => [tabel, kolom tanggal, filter tambahan]
     * CEK: sesuaikan nama tabel/kolom jika berbeda dengan database Anda
     */
    private function _sumberData()
    {
        return array(
            'pendaftar'      => array('jemaatbaru', 'tglinsert', array()),
            'jemaatbaru'     => array('jemaat', 'tanggalinsert', array('statusjemaat' => 'Jemaat')),
            'pernikahan'     => array('aktanikah', 'tglakta', array()),
            'penyerahananak' => array('aktapenyerahananak', 'tglakta', array()),
            'baptis'         => array('aktabaptisan', 'tglakta', array()),
        );
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
     * Ambil info gereja dari tabel infogereja
     * Return object kosong jika tabel kosong agar view tidak error
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