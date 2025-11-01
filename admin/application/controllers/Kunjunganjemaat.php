<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjunganjemaat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Kunjunganjemaat_model');
        $this->load->model('Jemaat_model');
        $this->session->set_userdata('IDMENUSELECTED', 'C105');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'kunjunganjemaat';
        $this->load->view('kunjunganjemaat/listdata', $data);
    }

    public function proses($idkunjunganjemaat)
    {
        $idkunjunganjemaat = $this->encrypt->decode($idkunjunganjemaat);
        $rsKunjunganJemaat = $this->Kunjunganjemaat_model->get_by_id($idkunjunganjemaat);

        if ($rsKunjunganJemaat->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('kunjunganjemaat');
            exit();
        };
        $this->App->bacaNotifikasi($idkunjunganjemaat, $this->session->userdata('idjemaat'), 'Kunjungan Jemaat');


        $data['rowKunjunganJemaat'] = $rsKunjunganJemaat->row();
        $data['idkunjunganjemaat'] = $idkunjunganjemaat;
        $data['menu'] = 'kunjunganjemaat';
        $this->load->view('kunjunganjemaat/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Kunjunganjemaat_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                switch ($rowdata->status) {
                    case 'Disetujui':
                        $status = '<span class="badge badge-success">' . $rowdata->status . '</span>';
                        break;
                    case 'Ditolak':
                        $status = '<span class="badge badge-danger">' . $rowdata->status . '</span>';
                        break;
                    default:
                        $status = '<span class="badge badge-warning">' . $rowdata->status . '</span>';
                        break;
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = ($rowdata->tglinsert == null) ? '' : formatHariTanggalJam($rowdata->tglinsert);
                $row[] = $rowdata->namalengkap . '<br>' . $rowdata->jeniskelamin;
                $row[] = $rowdata->alamatjemaat;
                $row[] = $rowdata->email;
                $row[] = $rowdata->nohpyangbisadihubungi;
                $row[] = $status;
                $row[] = '<a href="' . site_url('kunjunganjemaat/proses/' . $this->encrypt->encode($rowdata->idkunjunganjemaat)) . '" class="btn btn-sm btn-primary btn-circle"><i class="fas fa-check-double"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Kunjunganjemaat_model->count_all(),
            "recordsFiltered" => $this->Kunjunganjemaat_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $idkunjunganjemaat             = $this->input->post('idkunjunganjemaat');
        $idpenanggungjawab             = $this->input->post('idpenanggungjawab');
        $tglkunjungan             = $this->input->post('tglkunjungan');
        $keteranganadmin             = $this->input->post('keteranganadmin');
        $status             = $this->input->post('status');
        $tglinsert = date('Y-m-d H:i:s');

        $data = array(
            'idkunjunganjemaat'   => $idkunjunganjemaat,
            'status'   => $status,
            'tglstatus'   => date('Y-m-d H:i:s'),
            'idadmin'   => $this->session->userdata('idjemaat'),
            'keteranganadmin'   => $keteranganadmin,
            'idpenanggungjawab'   => $idpenanggungjawab,
            'tglkunjungan'   => $tglkunjungan,
        );

        // var_dump($data);
        // exit();
        $result = $this->Kunjunganjemaat_model->update($data, $idkunjunganjemaat);

        if ($result['status']) {
            $pesan = '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Berhasil!</strong> Data berhasil disimpan!
                    </div>';

            if ($status=='Disetujui') {            
                $rowPenanggungJawab = $this->App->getJemaat($idpenanggungjawab)->row();                    
                $rowTemp = $this->Kunjunganjemaat_model->get_by_id($idkunjunganjemaat)->row();            
                $rowJemaat = $this->App->getJemaat($rowTemp->idjemaat)->row();            
                $pesanWA = "Shalom " . $rowJemaat->namalengkap . "! Permohonan kunjungan jemaat anda telah kami terima. !
                \n *ID Permohonan: " . replwzero($idkunjunganjemaat, 4) . "/" . date('m', strtotime($rowTemp->tglinsert)) . "/" . date('Y', strtotime($rowTemp->tglinsert)) . "*
                \n Jenis Permohonan: Permohonan Kunjungan Jemaat
                \n Waktu Kunjungan: " . hariTanggalJam($tglkunjungan) . "
                \n Yg Melayani: $rowPenanggungJawab->namalengkap
                \n Keterangan: $keteranganadmin";
                $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);                
            }else{
                $rowTemp = $this->Kunjunganjemaat_model->get_by_id($idkunjunganjemaat)->row();            
                $rowJemaat = $this->App->getJemaat($rowTemp->idjemaat)->row();            
                $pesanWA = "Shalom " . $rowJemaat->namalengkap . "! Permohonan kunjungan jemaat anda kami tolak.!
                \n *ID Permohonan: " . replwzero($idkunjunganjemaat, 4) . "/" . date('m', strtotime($rowTemp->tglinsert)) . "/" . date('Y', strtotime($rowTemp->tglinsert)) . "*
                \n Jenis Permohonan: Permohonan Kunjungan Jemaat
                \n Keterangan: $keteranganadmin";
                $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);
            }
        } else {
            $pesan = '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Gagal!</strong> Data gagal disimpan!<br>
                        Pesan Error: ' . htmlspecialchars($result['message']) . '
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('kunjunganjemaat');
    }

    public function get_edit_data()
    {
        $idkunjunganjemaat = $this->input->post('idkunjunganjemaat');
        $RsData = $this->Kunjunganjemaat_model->get_by_id($idkunjunganjemaat)->row();
        $data = array(
            'idkunjunganjemaat'     =>  $RsData->idkunjunganjemaat,
            'status'     =>  $RsData->status,
            'keteranganadmin'     =>  $RsData->keteranganadmin,
            'idpenanggungjawab'     =>  $RsData->idpenanggungjawab,
            'namapenanggungjawab'     =>  $RsData->namapenanggungjawab,
            'tglkunjungan'     =>  $RsData->tglkunjungan,
            'alamatjemaat'     =>  $RsData->alamatjemaat,
        );

        echo (json_encode($data));
    }
}

/* End of file Kunjunganjemaat.php */
/* Location: ./application/controllers/Kunjunganjemaat.php */