<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoringbooking extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Bookingruangan_model');
        $this->session->set_userdata('IDMENUSELECTED', 'M509');
        $this->cekOtorisasi();
        $this->Bookingruangan_model->autoUpdateSelesai();
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal') ?? date('Y-m-d');
        $idruangan = $this->input->get('idruangan') ?? '';
        $status = $this->input->get('status') ?? '';

        $data['rsBooking'] = $this->Bookingruangan_model->getAllBooking($tanggal, $idruangan, $status);
        $data['statistik'] = $this->Bookingruangan_model->getStatistikHariIni();
        $data['rsRuangan'] = $this->Bookingruangan_model->getAllRuangan();
        $data['tanggal'] = $tanggal;
        $data['idruangan'] = $idruangan;
        $data['status'] = $status;
        $data['menu'] = 'monitoringbooking';
        $this->load->view('monitoringbooking/index', $data);
    }

    public function batal($idbooking)
    {
        $idbooking = $this->encrypt->decode($idbooking);
        $rsBooking = $this->Bookingruangan_model->getBookingById($idbooking);

        if ($rsBooking->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data booking tidak ditemukan!'));
            redirect('monitoringbooking');
            return;
        }

        if ($rsBooking->row()->status == 'Selesai') {
            $this->session->set_flashdata('pesan', $this->_pesan('warning', 'Booking yang sudah selesai tidak dapat dibatalkan!'));
            redirect('monitoringbooking');
            return;
        }

        $batal = $this->Bookingruangan_model->batalkanBooking($idbooking);
        if ($batal) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Booking berhasil dibatalkan!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal membatalkan booking!'));
        }
        redirect('monitoringbooking');
    }

    public function getDataBooking()
    {
        $tanggal = $this->input->get('tanggal') ?? date('Y-m-d');
        $idruangan = $this->input->get('idruangan') ?? '';
        $status = $this->input->get('status') ?? '';

        $this->Bookingruangan_model->autoUpdateSelesai();
        $rsBooking = $this->Bookingruangan_model->getAllBooking($tanggal, $idruangan, $status);
        $statistik = $this->Bookingruangan_model->getStatistikHariIni();

        $arrBooking = array();
        if ($rsBooking->num_rows() > 0) {
            foreach ($rsBooking->result() as $row) {
                $arrBooking[] = array(
                    'idbooking' => $row->idbooking,
                    'namaruangan' => $row->namaruangan,
                    'lokasi' => $row->lokasi,
                    'namadc' => $row->namadc,
                    'namadm' => $row->namadm,
                    'namapembooking' => $row->namapembooking,
                    'tanggalbooking' => date('d-m-Y', strtotime($row->tanggalbooking)),
                    'jamulai' => $row->jamulai,
                    'jamselesai' => $row->jamselesai,
                    'keperluan' => $row->keperluan,
                    'status' => $row->status,
                    'urlbatal' => site_url('monitoringbooking/batal/' . $this->encrypt->encode($row->idbooking)),
                );
            }
        }

        echo json_encode(array(
            'booking' => $arrBooking,
            'statistik' => $statistik,
        ));
    }

    private function _pesan($type, $text)
    {
        $label = ($type == 'success') ? 'Berhasil!' : ($type == 'warning' ? 'Perhatian!' : 'Gagal!');
        return '
        <div class="alert alert-' . $type . ' alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <strong>' . $label . '</strong> ' . $text . '
        </div>';
    }
}
