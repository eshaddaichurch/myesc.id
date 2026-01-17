<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfirmasidcm extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Konfirmasidcm_model');
        $this->session->set_userdata('IDMENUSELECTED', 'M504');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['rsDc'] = $this->Konfirmasidcm_model->getDc();
        $data['menu'] = '';
        $this->load->view('konfirmasidcm/listdata', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Konfirmasidcm_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                switch ($rowdata->statuskonfirmasi) {
                    case 'Disetujui':
                        $statuskonfirmasi = '<span class="badge badge-success">' . $rowdata->statuskonfirmasi . '</span><br>'. since($rowdata->tglkonfirmasi);
                        if (!empty($rowdata->keterangankonfirmasi)) {
                            $statuskonfirmasi .= '<br>Keterangan: ' . $rowdata->keterangankonfirmasi;
                        }
                        break;
                    case 'Ditolak':
                        $statuskonfirmasi = '<span class="badge badge-danger">' . $rowdata->statuskonfirmasi . '</span><br>'. since($rowdata->tglkonfirmasi);
                        if (!empty($rowdata->keterangankonfirmasi)) {
                            $statuskonfirmasi .= '<br>Keterangan: ' . $rowdata->keterangankonfirmasi;
                        }
                        break;
                    default:
                        $statuskonfirmasi = '<span class="badge badge-warning">Menunggu</span>';
                        break;
                }

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = formatHariTanggalJam($rowdata->tglpermohonan);
                $row[] = $rowdata->namalengkap;
                $row[] = $rowdata->namadc;
                $row[] = $statuskonfirmasi;

                $row[] = '<button class="btn btn-sm btn-primary btn-circle" data-idpermohonan="' . $rowdata->idpermohonan . '" id="btnDetail"><i class="fa fa-search"></i> Lihat Detail</button>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Konfirmasidcm_model->count_all(),
            "recordsFiltered" => $this->Konfirmasidcm_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function getDetailPermohon()
    {
        $idpermohonan = $this->input->get('idpermohonan');

        $rsPermohonan = $this->Konfirmasidcm_model->get_by_id($idpermohonan);
        if ($rsPermohonan->num_rows() == 0) {
            echo json_encode(array('msg' => "Data permohonan tidak ditemukan!"));
            exit();
        }
        $rowPermohonan = $rsPermohonan->row();
        $idjemaat = $rowPermohonan->idjemaat;

        $rsNextStep = $this->App->getKelasJemaat($idjemaat);
        $arrNextStep = array();
        if ($rsNextStep->num_rows() > 0) {
            foreach ($rsNextStep->result() as $row) {
                array_push($arrNextStep, array(
                    'namakelas' => $row->namakelas
                ));
            }
        }

        $arrJemaatFamily = $this->App->getJemaatFamily($idjemaat);

        echo json_encode(array('rowPermohonan' => $rowPermohonan, 'arrNextStep' => $arrNextStep, 'arrJemaatFamily' => $arrJemaatFamily));
    }

}