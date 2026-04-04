<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookingruangan extends MY_Controller
{
    private $iddc;
    private $idjemaat;

    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Bookingruangan_model');
        $this->iddc = $this->session->userdata('iddc');
        $this->idjemaat = $this->session->userdata('idjemaat');

        if (empty($this->iddc)) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Anda tidak terdaftar sebagai DM!'));
            redirect('/');
            exit();
        }
    }

    public function index()
    {
        $data['menu'] = 'bookingruangan';
        $this->load->view('bookingruangan/index', $data);
    }

    public function getRuangan()
    {
        $tanggal = $this->input->get('tanggal');
        $jamulai = $this->input->get('jamulai');
        $jamselesai = $this->input->get('jamselesai');

        if ($jamselesai <= $jamulai) {
            echo json_encode(array('status' => 'error', 'message' => 'Jam selesai harus lebih besar dari jam mulai!'));
            return;
        }

        $jumlahBooking = $this->Bookingruangan_model->getJumlahBookingHariIni($this->iddc, $tanggal);
        $sudahMaksimal = ($jumlahBooking >= 1);

        $rsRuanganTersedia = $this->Bookingruangan_model->getRuanganTersedia($tanggal, $jamulai, $jamselesai);
        $rsRuanganTerpakai = $this->Bookingruangan_model->getRuanganTerpakai($tanggal, $jamulai, $jamselesai);

        $tersedia = array();
        if ($rsRuanganTersedia->num_rows() > 0) {
            foreach ($rsRuanganTersedia->result() as $row) {
                // ✅ pakai domain admin
                $foto = 'https://admin.myesc.id/images/nofoto.png';
                if (!empty($row->foto)) {
                    $foto = 'https://admin.myesc.id/uploads/ruangan/' . $row->foto;
                }
                $tersedia[] = array(
                    'idruangan' => $row->idruangan,
                    'namaruangan' => $row->namaruangan,
                    'kapasitas' => $row->kapasitas,
                    'lokasi' => $row->lokasi,
                    'fasilitas' => $row->fasilitas,
                    'foto' => $foto,
                );
            }
        }

        $terpakai = array();
        if ($rsRuanganTerpakai->num_rows() > 0) {
            foreach ($rsRuanganTerpakai->result() as $row) {
                // ✅ pakai domain admin
                $foto = 'https://admin.myesc.id/images/nofoto.png';
                if (!empty($row->foto)) {
                    $foto = 'https://admin.myesc.id/uploads/ruangan/' . $row->foto;
                }
                $terpakai[] = array(
                    'idruangan' => $row->idruangan,
                    'namaruangan' => $row->namaruangan,
                    'kapasitas' => $row->kapasitas,
                    'lokasi' => $row->lokasi,
                    'fasilitas' => $row->fasilitas,
                    'foto' => $foto,
                    'namadc' => $row->namadc,
                    'namapembooking' => $row->namapembooking,
                    'jamulai' => $row->jamulai,
                    'jamselesai' => $row->jamselesai,
                    'keperluan' => $row->keperluan,
                    'jenispakai' => $row->jenispakai,
                );
            }
        }

        echo json_encode(array(
            'status' => 'ok',
            'tersedia' => $tersedia,
            'terpakai' => $terpakai,
            'sudahMaksimal' => $sudahMaksimal,
            'jumlahBooking' => $jumlahBooking,
        ));
    }

    public function simpan()
    {
        $idruangan = $this->input->post('idruangan');
        $tanggal = $this->input->post('tanggal');
        $jamulai = $this->input->post('jamulai');
        $jamselesai = $this->input->post('jamselesai');
        $keperluan = $this->input->post('keperluan');

        if ($jamselesai <= $jamulai) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Jam selesai harus lebih besar dari jam mulai!'));
            redirect('bookingruangan');
            return;
        }

        $jumlahBooking = $this->Bookingruangan_model->getJumlahBookingHariIni($this->iddc, $tanggal);
        if ($jumlahBooking >= 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger',
                'DC Anda sudah memiliki booking aktif pada tanggal <b>' . $tanggal . '</b>. '
                    . 'Maksimal 1 booking per hari. Batalkan booking sebelumnya jika ingin membooking ruangan lain.'));
            redirect('bookingruangan');
            return;
        }

        $adaKonflik = $this->Bookingruangan_model->cekKonflikJam($idruangan, $tanggal, $jamulai, $jamselesai);
        if ($adaKonflik) {
            $rsKonflik = $this->Bookingruangan_model->getBookingKonflik($idruangan, $tanggal, $jamulai, $jamselesai)->row();
            $pesanError = 'Ruangan sudah dibooking oleh <b>' . $rsKonflik->namadc . '</b>'
                . ' pukul ' . $rsKonflik->jamulai . ' - ' . $rsKonflik->jamselesai
                . '. Silakan pilih jam lain!';
            $this->session->set_flashdata('pesan', $this->_pesan('danger', $pesanError));
            redirect('bookingruangan');
            return;
        }

        $idbooking = $this->db->query('SELECT create_idbooking() AS idbooking')->row()->idbooking;

        $data = array(
            'idbooking' => $idbooking,
            'idruangan' => $idruangan,
            'iddc' => $this->iddc,
            'idjemaat' => $this->idjemaat,
            'tanggalbooking' => $tanggal,
            'jamulai' => $jamulai,
            'jamselesai' => $jamselesai,
            'keperluan' => $keperluan,
            'status' => 'Disetujui',
            'tanggalinsert' => date('Y-m-d H:i:s'),
            'tanggalupdate' => date('Y-m-d H:i:s'),
        );

        $simpan = $this->Bookingruangan_model->simpanBooking($data);

        if ($simpan) {
            $this->session->set_flashdata('pesan', $this->_pesan('success',
                'Ruangan berhasil dibooking! ID Booking: <b>' . $idbooking . '</b>'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Booking gagal disimpan!'));
        }
        redirect('bookingruangan/riwayat');
    }

    public function riwayat()
    {
        $tglawal = $this->input->get('tglawal') ?? date('Y-m-01');
        $tglakhir = $this->input->get('tglakhir') ?? date('Y-m-t');

        $rsRiwayat = $this->Bookingruangan_model->getRiwayatByDc($this->iddc, $tglawal, $tglakhir);

        $data['rsRiwayat'] = $rsRiwayat;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['menu'] = 'bookingruangan';
        $this->load->view('bookingruangan/riwayat', $data);
    }

    public function batal($idbooking)
    {
        $idbooking = $this->encrypt->decode($idbooking);
        $rsBooking = $this->Bookingruangan_model->getBookingById($idbooking);

        if ($rsBooking->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data booking tidak ditemukan!'));
            redirect('bookingruangan/riwayat');
            return;
        }

        $row = $rsBooking->row();

        if ($row->iddc != $this->iddc) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Anda tidak berhak membatalkan booking ini!'));
            redirect('bookingruangan/riwayat');
            return;
        }

        if ($row->status == 'Selesai') {
            $this->session->set_flashdata('pesan', $this->_pesan('warning', 'Booking yang sudah selesai tidak dapat dibatalkan!'));
            redirect('bookingruangan/riwayat');
            return;
        }

        $batal = $this->Bookingruangan_model->batalkanBooking($idbooking, $this->iddc);

        if ($batal) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Booking berhasil dibatalkan!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal membatalkan booking!'));
        }
        redirect('bookingruangan/riwayat');
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
