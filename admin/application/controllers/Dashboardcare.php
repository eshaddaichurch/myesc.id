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

    /**
     * Get info box data (Jemaat Baru, Total Jemaat, Simpatisan, Baptis)
     */
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

    /**
     * Get grafik jemaat baru per bulan
     * FIX: Tambah null check dan error handling
     */
    public function getgrafikjemaatbaru()
    {
        try {
            $result = $this->Dashboardcare_model->getgrafikjemaatbaru();

            // FIX #1: Check apakah query return result
            if (!$result || $result->num_rows() === 0) {
                $this->_sendErrorResponse('Data grafik jemaat baru tidak ditemukan', 404);
                return;
            }

            $rskelas = $result->row();

            // FIX #2: Define bulan array
            $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

            // FIX #3: Build jumlahjemaat array dengan null check per bulan
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rskelas->$b) ? intval($rskelas->$b) : 0;
            }

            // FIX #4: Hitung total dengan array_sum (lebih clean)
            $totaljemaat = array_sum($jumlahjemaat);

            $data = array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            );

            echo json_encode($data);
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get grafik marriage class per bulan
     * FIX: Tambah null check dan error handling
     */
    public function getgrafikmarriage()
    {
        try {
            $result = $this->Dashboardcare_model->getgrafikmarriage();

            // FIX #1: Check apakah query return result
            if (!$result || $result->num_rows() === 0) {
                $this->_sendErrorResponse('Data grafik marriage tidak ditemukan', 404);
                return;
            }

            $rskelas = $result->row();

            // FIX #2: Define bulan array
            $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

            // FIX #3: Build jumlahjemaat array dengan null check per bulan
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rskelas->$b) ? intval($rskelas->$b) : 0;
            }

            // FIX #4: Hitung total dengan array_sum
            $totaljemaat = array_sum($jumlahjemaat);

            $data = array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            );

            echo json_encode($data);
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get grafik baptis per bulan
     * FIX: Tambah null check dan error handling
     */
    public function getgrafikbaptis()
    {
        try {
            $result = $this->Dashboardcare_model->getgrafikbaptis();

            // FIX #1: Check apakah query return result
            if (!$result || $result->num_rows() === 0) {
                $this->_sendErrorResponse('Data grafik baptis tidak ditemukan', 404);
                return;
            }

            $rsAkta = $result->row();

            // FIX #2: Define bulan array
            $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

            // FIX #3: Build jumlahjemaat array dengan null check per bulan
            $jumlahjemaat = array();
            foreach ($bulan as $b) {
                $jumlahjemaat[] = isset($rsAkta->$b) ? intval($rsAkta->$b) : 0;
            }

            // FIX #4: Hitung total dengan array_sum
            $totaljemaat = array_sum($jumlahjemaat);

            $data = array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            );

            echo json_encode($data);
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Helper: Send error response as JSON
     * FIX: Standardized error response
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
