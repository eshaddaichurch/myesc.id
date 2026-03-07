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
        $data["menu"] = "dashboarddc";
        $this->load->view("dashboard/dc", $data);
    }

    public function getinfobox()
    {
        $memberBaruLalu = $this->Dashboarddc_model->memberBaruLalu();
        $memberBaruIni = $this->Dashboarddc_model->memberBaruIni();
        $jumlahDc = $this->Dashboarddc_model->jumlahDc();
        $jumlahMember = $this->Dashboarddc_model->jumlahMember();

        $data = array(
            'memberBaruLalu' => $memberBaruLalu,
            'memberBaruIni' => $memberBaruIni,
            'jumlahDc' => $jumlahDc,
            'jumlahMember' => $jumlahMember,
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
        $i = 1;
        if ($rsMember->num_rows() > 0) {
            foreach ($rsMember->result() as $rowMember) {
                $datatanggal[] = date('d-M', strtotime($rowMember->tglkonfirmasi));
                $jumlahmember[] = $rowMember->jumlah;
                $total += $rowMember->jumlah;
                $i++;
            }
        }
        $ratarata = number_format($total / $i);

        $data = array(
            'datatanggal' => $datatanggal,
            'jumlahmember' => $jumlahmember,
            'ratarata' => $ratarata,
            'jumlahi' => $i,
        );

        echo json_encode($data);
    }

    public function getjumlahmemberperbulan()
    {
        $rsPerbulan = $this->Dashboarddc_model->getjumlahmemberperbulan();
        echo json_encode($rsPerbulan->row());
    }

    public function cetak($jenisCetakan, $tglawal, $tglakhir)
    {
        error_reporting(0);

        $this->load->library('Pdf');

        $rsMemberBaru = $this->Dashboarddc_model->getMemberBaru($tglawal, $tglakhir);

        $dataMember = array();

        if ($rsMemberBaru->num_rows()>0) {
            foreach ($rsMemberBaru->result() as $row) {
                $dataMember[] = $row;
            }            
        }

        $rowInfoGereja = $this->db->query("
        		select * from infogereja
        	")->row();

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
        }else{
            $this->load->view('dashboard/cetakdc_excel', $data);            
        }
    }

}

/* End of file Dashboarddc.php */
/* Location: ./application/controllers/Dashboarddc.php */