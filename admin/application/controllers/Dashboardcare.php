<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardcare extends MY_controller
{
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
        $this->load->view('dashboard/care', $data);
    }

    // =========================================================
    // INFO BOX
    // =========================================================

    public function getinfobox()
    {
        $data = array(
            'jumlahjemaatbaru' => $this->Dashboardcare_model->getJemaatBaru() ?? 0,
            'jumlahjemaatsemua' => $this->Dashboardcare_model->getTotalJemaat() ?? 0,
            'jumlahjemaatsimpatisan' => $this->Dashboardcare_model->getTotalSimpatisan() ?? 0,
            'jumlahjemaatumum' => $this->Dashboardcare_model->getTotalUmum() ?? 0,
            'jumlahjemaatbaptis' => $this->Dashboardcare_model->getTotalBaptis() ?? 0,
        );
        echo json_encode($data);
    }

    // =========================================================
    // GRAFIK JEMAAT BARU
    // =========================================================

    public function getgrafikjemaatbaru()
    {
        $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

        try {
            $result = $this->Dashboardcare_model->getgrafikjemaatbaru();

            if (!$result) {
                $this->_sendErrorResponse('Query gagal dijalankan', 500);
                return;
            }

            // Jika tidak ada baris, kembalikan data kosong agar chart tidak error
            if ($result->num_rows() === 0) {
                echo json_encode(array(
                    'success' => true,
                    'datatanggal' => $bulan,
                    'jumlahjemaat' => array_fill(0, 12, 0),
                    'totaljemaat' => 0,
                ));
                return;
            }

            $rskelas = $result->row();
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rskelas->$b) ? intval($rskelas->$b) : 0;
            }

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => array_sum($jumlahjemaat),
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    // =========================================================
    // GRAFIK MARRIAGE
    // =========================================================

    public function getgrafikmarriage()
    {
        $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

        try {
            $result = $this->Dashboardcare_model->getgrafikmarriage();

            if (!$result) {
                $this->_sendErrorResponse('Query gagal dijalankan', 500);
                return;
            }

            if ($result->num_rows() === 0) {
                echo json_encode(array(
                    'success' => true,
                    'datatanggal' => $bulan,
                    'jumlahjemaat' => array_fill(0, 12, 0),
                    'totaljemaat' => 0,
                ));
                return;
            }

            $rskelas = $result->row();
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rskelas->$b) ? intval($rskelas->$b) : 0;
            }

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => array_sum($jumlahjemaat),
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    // =========================================================
    // GRAFIK BAPTIS
    // =========================================================

    public function getgrafikbaptis()
    {
        $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

        try {
            $result = $this->Dashboardcare_model->getgrafikbaptis();

            if (!$result) {
                $this->_sendErrorResponse('Query gagal dijalankan', 500);
                return;
            }

            if ($result->num_rows() === 0) {
                echo json_encode(array(
                    'success' => true,
                    'datatanggal' => $bulan,
                    'jumlahjemaat' => array_fill(0, 12, 0),
                    'totaljemaat' => 0,
                ));
                return;
            }

            $rsAkta = $result->row();
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rsAkta->$b) ? intval($rsAkta->$b) : 0;
            }

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => array_sum($jumlahjemaat),
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    // =========================================================
    // CETAK PDF / EXCEL
    // URL: dashboardcare/cetak/pdf/2025-01-01/2025-01-31
    // URL: dashboardcare/cetak/excel/2025-01-01/2025-01-31
    // =========================================================

    public function cetak($jenisCetakan = 'pdf', $tglawal = '', $tglakhir = '')
    {
        // Suppress warning agar tidak merusak output PDF/Excel
        error_reporting(0);

        // Validasi parameter tanggal
        if (empty($tglawal) || empty($tglakhir)) {
            show_error('Parameter tanggal tidak valid.', 400);
            return;
        }
        if (!strtotime($tglawal) || !strtotime($tglakhir)) {
            show_error('Format tanggal tidak valid. Gunakan format Y-m-d.', 400);
            return;
        }

        // Load library PDF hanya jika cetak PDF
        if ($jenisCetakan === 'pdf') {
            $this->load->library('Pdf');
        }

        // Ambil data untuk dikirim ke view
        $rsJemaatBaru = $this->Dashboardcare_model->getJemaatBaruPeriode($tglawal, $tglakhir);

        // -------------------------------------------------------
        // GUARD: Jika query gagal (tabel/kolom tidak ditemukan),
        // tampilkan pesan error yang jelas daripada crash
        // -------------------------------------------------------
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
            'rowInfoGereja' => $this->_getInfoGereja(),
            'rsJemaatBaru' => $rsJemaatBaru,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
            'totalJemaat' => $this->Dashboardcare_model->getTotalJemaat() ?? 0,
            'totalSimpatisan' => $this->Dashboardcare_model->getTotalSimpatisan() ?? 0,
            'totalBaptis' => $this->Dashboardcare_model->getTotalBaptis() ?? 0,
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
            'namagereja' => 'Nama Gereja',
            'alamatgereja' => '',
            'emailgereja' => '',
        );
    }

    /**
     * Standardized JSON error response
     */
    private function _sendErrorResponse($message, $code = 400)
    {
        http_response_code($code);
        echo json_encode(array(
            'success' => false,
            'message' => $message,
            'code' => $code,
        ));
    }
}

/* End of file Dashboardcare.php */
/* Location: ./application/controllers/Dashboardcare.php */
