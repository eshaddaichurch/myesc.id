<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboarddc extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'M506');
        $this->load->model('Dashboarddc_model');
    }

    public function index()
    {
        $data['menu'] = 'dashboarddc';
        $this->load->view('dashboard/dc', $data);
    }

    public function getinfobox()
    {
        $data = array(
            'memberBaruLalu' => $this->Dashboarddc_model->memberBaruLalu() ?? 0,
            'memberBaruIni' => $this->Dashboarddc_model->memberBaruIni() ?? 0,
            'jumlahDc' => $this->Dashboarddc_model->jumlahDc() ?? 0,
            'jumlahMember' => $this->Dashboarddc_model->jumlahMember() ?? 0,
        );
        echo json_encode($data);
    }

    public function getgrafikmember()
    {
        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        $rsMember = $this->Dashboarddc_model->getgrafikmember($tglawal, $tglakhir);
        $datatanggal = array();
        $jumlahmember = array();
        $total = 0;
        $jumlahHari = 0;  // FIX: hitung jumlah baris yang benar-benar ada data

        if ($rsMember && $rsMember->num_rows() > 0) {
            foreach ($rsMember->result() as $rowMember) {
                $datatanggal[] = date('d-M', strtotime($rowMember->tglkonfirmasi));
                $jumlahmember[] = (int) $rowMember->jumlah;
                $total += (int) $rowMember->jumlah;
                $jumlahHari++;
            }
        }

        // FIX: Hindari pembagian dengan nol
        $ratarata = ($jumlahHari > 0) ? number_format($total / $jumlahHari) : 0;

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmember' => $jumlahmember,
            'ratarata' => $ratarata,
            'jumlahi' => $jumlahHari,
        );

        echo json_encode($data);
    }

    public function getjumlahmemberperbulan()
    {
        $rsPerbulan = $this->Dashboarddc_model->getjumlahmemberperbulan();

        // FIX: Jika query kosong, kirim semua 0 agar JS tidak error
        if (!$rsPerbulan || $rsPerbulan->num_rows() === 0) {
            $empty = array(
                'm01' => 0,
                'm02' => 0,
                'm03' => 0,
                'm04' => 0,
                'm05' => 0,
                'm06' => 0,
                'm07' => 0,
                'm08' => 0,
                'm09' => 0,
                'm10' => 0,
                'm11' => 0,
                'm12' => 0,
            );
            echo json_encode($empty);
            return;
        }

        $row = $rsPerbulan->row();

        // FIX: Pastikan setiap field di-cast ke int, bukan null
        $data = array(
            'm01' => (int) ($row->m01 ?? 0),
            'm02' => (int) ($row->m02 ?? 0),
            'm03' => (int) ($row->m03 ?? 0),
            'm04' => (int) ($row->m04 ?? 0),
            'm05' => (int) ($row->m05 ?? 0),
            'm06' => (int) ($row->m06 ?? 0),
            'm07' => (int) ($row->m07 ?? 0),
            'm08' => (int) ($row->m08 ?? 0),
            'm09' => (int) ($row->m09 ?? 0),
            'm10' => (int) ($row->m10 ?? 0),
            'm11' => (int) ($row->m11 ?? 0),
            'm12' => (int) ($row->m12 ?? 0),
        );

        echo json_encode($data);
    }

    public function cetak($jenisCetakan, $tglawal, $tglakhir)
    {
        error_reporting(0);

        $this->load->library('Pdf');

        $rsMemberBaru = $this->Dashboarddc_model->getMemberBaru($tglawal, $tglakhir);

        $rowInfoGereja = $this->db->query('
            SELECT * FROM infogereja
        ')->row();

        $data = array(
            'rsDc' => $this->Dashboarddc_model->getDc(),
            'rsMemberBaru' => $rsMemberBaru,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
            'rowInfoGereja' => $rowInfoGereja,
            'jumlahDc' => $this->Dashboarddc_model->jumlahDc(),
            'jumlahMember' => $this->Dashboarddc_model->jumlahMember(),
        );

        if ($jenisCetakan == 'pdf') {
            $this->load->view('dashboard/cetakdc_pdf', $data);
        } else {
            $this->load->view('dashboard/cetakdc_excel', $data);
        }
    }
}

/* End of file Dashboarddc.php */
/* Location: ./application/controllers/Dashboarddc.php */
