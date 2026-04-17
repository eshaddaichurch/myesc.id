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
     * FIX: Jika num_rows()===0, tetap kirim array 0 (bukan 404) agar JS tidak NaN
     */
    public function getgrafikjemaatbaru()
    {
        $bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');

        try {
            $result = $this->Dashboardcare_model->getgrafikjemaatbaru();

            // FIX: Jika query gagal total
            if (!$result) {
                $this->_sendErrorResponse('Query gagal dijalankan', 500);
                return;
            }

            // FIX: Jika tidak ada baris sama sekali, kirim data kosong (bukan 404)
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

            $totaljemaat = array_sum($jumlahjemaat);

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get grafik marriage class per bulan
     * FIX: Jika num_rows()===0, tetap kirim array 0 (bukan 404) agar JS tidak NaN
     */
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

            $totaljemaat = array_sum($jumlahjemaat);

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get grafik baptis per bulan
     * FIX: Jika num_rows()===0, tetap kirim array 0 (bukan 404) agar JS tidak NaN
     */
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

            $totaljemaat = array_sum($jumlahjemaat);

            echo json_encode(array(
                'success' => true,
                'datatanggal' => $bulan,
                'jumlahjemaat' => $jumlahjemaat,
                'totaljemaat' => $totaljemaat,
            ));
        } catch (Exception $e) {
            $this->_sendErrorResponse('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Helper: Send error response as JSON
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
