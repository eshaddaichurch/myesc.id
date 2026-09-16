<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingRuangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Bookingruangan_model');
        
    }

    // =========================================
    // 1️⃣ CARI RUANGAN
    // =========================================
    public function getRuangan()
    {
        $tanggal = $this->input->get('tanggal');
        $jamulai = $this->input->get('jamulai');
        $jamselesai = $this->input->get('jamselesai');
        $iddc = $this->input->get('iddc');

        if (!$tanggal || !$jamulai || !$jamselesai || !$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
            return;
        }

        if ($jamselesai <= $jamulai) {
            echo json_encode([
                'status' => false,
                'message' => 'Jam selesai harus lebih besar dari jam mulai!'
            ]);
            return;
        }

        $jumlahBooking = $this->Bookingruangan_model->getJumlahBookingHariIni($iddc, $tanggal);
        $sudahMaksimal = ($jumlahBooking >= 1);

        $rsRuanganTersedia = $this->Bookingruangan_model->getRuanganTersedia($tanggal, $jamulai, $jamselesai);
        $rsRuanganTerpakai = $this->Bookingruangan_model->getRuanganTerpakai($tanggal, $jamulai, $jamselesai);

        $tersedia = [];
        foreach ($rsRuanganTersedia->result() as $row) {
            // ✅ fix domain
            $foto = !empty($row->foto)
                ? 'https://admin.myesc.id/uploads/ruangan/' . $row->foto
                : 'https://admin.myesc.id/images/nofoto.png';

            $tersedia[] = [
                'idruangan' => $row->idruangan,
                'namaruangan' => $row->namaruangan,
                'kapasitas' => $row->kapasitas,
                'lokasi' => $row->lokasi,
                'fasilitas' => $row->fasilitas,
                'foto' => $foto,
            ];
        }

        $terpakai = [];
        foreach ($rsRuanganTerpakai->result() as $row) {
            // ✅ fix domain
            $foto = !empty($row->foto)
                ? 'https://admin.myesc.id/uploads/ruangan/' . $row->foto
                : 'https://admin.myesc.id/images/nofoto.png';

            $terpakai[] = [
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
            ];
        }

        echo json_encode([
            'status' => true,
            'tersedia' => $tersedia,
            'terpakai' => $terpakai,
            'sudahMaksimal' => $sudahMaksimal,
            'jumlahBooking' => (int) $jumlahBooking,
        ]);
    }

    // =========================================
    // 2️⃣ SIMPAN BOOKING
    // =========================================
    public function simpan()
    {
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);

        $idruangan = $input['idruangan'] ?? '';
        $iddc = $input['iddc'] ?? '';
        $idjemaat = $input['idjemaat'] ?? '';
        $tanggal = $input['tanggal'] ?? '';
        $jamulai = $input['jamulai'] ?? '';
        $jamselesai = $input['jamselesai'] ?? '';
        $keperluan = $input['keperluan'] ?? '';

        if (!$idruangan || !$iddc || !$idjemaat || !$tanggal || !$jamulai || !$jamselesai) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        if ($jamselesai <= $jamulai) {
            echo json_encode(['status' => false, 'message' => 'Jam selesai harus lebih besar dari jam mulai!']);
            return;
        }

        $jumlahBooking = $this->Bookingruangan_model->getJumlahBookingHariIni($iddc, $tanggal);
        if ($jumlahBooking >= 1) {
            echo json_encode(['status' => false, 'message' => 'DC Anda sudah memiliki booking aktif pada tanggal ini. Maksimal 1 booking per hari.']);
            return;
        }

        $adaKonflik = $this->Bookingruangan_model->cekKonflikJam($idruangan, $tanggal, $jamulai, $jamselesai);
        if ($adaKonflik) {
            $rsKonflik = $this->Bookingruangan_model->getBookingKonflik($idruangan, $tanggal, $jamulai, $jamselesai)->row();
            echo json_encode([
                'status' => false,
                'message' => 'Ruangan sudah dibooking oleh ' . $rsKonflik->namadc . ' pukul ' . $rsKonflik->jamulai . ' - ' . $rsKonflik->jamselesai
            ]);
            return;
        }

        $idbooking = $this->db->query('SELECT create_idbooking() AS idbooking')->row()->idbooking;

        $data = [
            'idbooking' => $idbooking,
            'idruangan' => $idruangan,
            'iddc' => $iddc,
            'idjemaat' => $idjemaat,
            'tanggalbooking' => $tanggal,
            'jamulai' => $jamulai,
            'jamselesai' => $jamselesai,
            'keperluan' => $keperluan,
            'status' => 'Disetujui',
            'tanggalinsert' => date('Y-m-d H:i:s'),
            'tanggalupdate' => date('Y-m-d H:i:s'),
        ];

        $simpan = $this->Bookingruangan_model->simpanBooking($data);

        if ($simpan) {
            // FITUR BARU: kirim email detail booking ke admin.
            // Dibungkus try/catch(Throwable) + pengecekan berlapis supaya
            // endpoint TIDAK PERNAH gagal/crash gara-gara proses email ini,
            // apapun jenis errornya (Exception biasa maupun fatal Error).
            try {
                $this->load->model('App'); // WAJIB: load di sini, model App tidak di-autoload/tidak ada di constructor

                $rsBookingBaru = $this->Bookingruangan_model->getBookingById($idbooking);

                $namaruangan = '-';
                $lokasi = '-';
                $namadc = '-';
                $namadm = '-';

                if ($rsBookingBaru && $rsBookingBaru->num_rows() > 0) {
                    $rowBookingBaru = $rsBookingBaru->row();
                    $namaruangan = isset($rowBookingBaru->namaruangan) ? $rowBookingBaru->namaruangan : '-';
                    $lokasi      = isset($rowBookingBaru->lokasi) ? $rowBookingBaru->lokasi : '-';
                    $namadc      = isset($rowBookingBaru->namadc) ? $rowBookingBaru->namadc : '-';
                    $namadm      = isset($rowBookingBaru->namadm) ? $rowBookingBaru->namadm : '-';
                } else {
                    log_message('error', 'API BookingRuangan: getBookingById kosong untuk idbooking=' . $idbooking);
                }

                $judul = 'Booking Ruangan Baru - ' . $namaruangan;

                $textemail = '
                    <h4>Ada Booking Ruangan Baru</h4>
                    <p>Berikut detail booking yang baru saja masuk ke sistem (dari aplikasi mobile):</p>
                    <table style="border-collapse: collapse; width: 100%; max-width: 500px;">
                        <tr>
                            <td style="padding: 4px 8px;"><b>ID Booking</b></td>
                            <td style="padding: 4px 8px;">: ' . $idbooking . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 8px;"><b>Ruangan</b></td>
                            <td style="padding: 4px 8px;">: ' . $namaruangan . ' (' . $lokasi . ')</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 8px;"><b>DC / DM</b></td>
                            <td style="padding: 4px 8px;">: ' . $namadc . ' / ' . $namadm . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 8px;"><b>Tanggal</b></td>
                            <td style="padding: 4px 8px;">: ' . date('d-m-Y', strtotime($tanggal)) . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 8px;"><b>Jam</b></td>
                            <td style="padding: 4px 8px;">: ' . $jamulai . ' - ' . $jamselesai . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 8px;"><b>Keperluan</b></td>
                            <td style="padding: 4px 8px;">: ' . $keperluan . '</td>
                        </tr>
                    </table>
                    <p>Silakan cek menu Monitoring Booking untuk detail lebih lanjut.</p>
                ';

                $hasilKirim = $this->App->sendEmailDaftar('yemimaceria@gmail.com', $judul, $textemail);

                if (!$hasilKirim) {
                    log_message('error', 'API BookingRuangan: sendEmailDaftar return false untuk idbooking=' . $idbooking);
                }
            } catch (Throwable $e) {
                // Throwable menangkap Exception DAN Error (termasuk fatal error
                // semacam "call to member function on null"), supaya proses
                // booking TIDAK PERNAH gagal hanya gara-gara bagian email ini.
                log_message('error', 'API BookingRuangan: gagal kirim email notifikasi booking - ' . $e->getMessage());
            }

            echo json_encode([
                'status' => true,
                'message' => 'Booking berhasil!',
                'idbooking' => $idbooking,
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Booking gagal disimpan!']);
        }
    }

    // =========================================
    // 3️⃣ RIWAYAT BOOKING
    // =========================================
    public function riwayat()
    {
        $iddc = $this->input->get('iddc');
        $tglawal = $this->input->get('tglawal') ?? date('Y-m-01');
        $tglakhir = $this->input->get('tglakhir') ?? date('Y-m-t');

        if (!$iddc) {
            echo json_encode(['status' => false, 'message' => 'iddc wajib diisi']);
            return;
        }

        $rs = $this->Bookingruangan_model->getRiwayatByDc($iddc, $tglawal, $tglakhir);
        $result = [];

        foreach ($rs->result() as $row) {
            $result[] = [
                'idbooking' => $row->idbooking,
                'namaruangan' => $row->namaruangan,
                'lokasi' => $row->lokasi,
                'tanggalbooking' => $row->tanggalbooking,
                'jamulai' => $row->jamulai,
                'jamselesai' => $row->jamselesai,
                'keperluan' => $row->keperluan,
                'status' => $row->status,
            ];
        }

        echo json_encode([
            'status' => true,
            'total' => count($result),
            'data' => $result,
        ]);
    }

    // =========================================
    // 4️⃣ BATALKAN BOOKING
    // =========================================
    public function batal()
    {
        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true);

        $idbooking = $input['idbooking'] ?? '';
        $iddc = $input['iddc'] ?? '';

        if (!$idbooking || !$iddc) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        $rsBooking = $this->Bookingruangan_model->getBookingById($idbooking);

        if ($rsBooking->num_rows() < 1) {
            echo json_encode(['status' => false, 'message' => 'Data booking tidak ditemukan!']);
            return;
        }

        $row = $rsBooking->row();

        if ($row->iddc != $iddc) {
            echo json_encode(['status' => false, 'message' => 'Anda tidak berhak membatalkan booking ini!']);
            return;
        }

        if ($row->status == 'Selesai') {
            echo json_encode(['status' => false, 'message' => 'Booking yang sudah selesai tidak dapat dibatalkan!']);
            return;
        }

        $batal = $this->Bookingruangan_model->batalkanBooking($idbooking, $iddc);

        echo json_encode([
            'status' => $batal ? true : false,
            'message' => $batal ? 'Booking berhasil dibatalkan!' : 'Gagal membatalkan booking!',
        ]);
    }

    // =========================================

    // 5️⃣ RUANGAN TERPAKAI SELAMA SEMINGGU
    // =========================================
    public function getRuanganMinggu()
    {
        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        if (!$tglawal || !$tglakhir) {
            echo json_encode([
                'status' => false,
                'message' => 'Parameter tglawal dan tglakhir wajib diisi'
            ]);
            return;
        }

        $rsRuanganTerpakai = $this->Bookingruangan_model->getRuanganTerpakaiRange($tglawal, $tglakhir);

        $terpakai = [];
        foreach ($rsRuanganTerpakai->result() as $row) {
            $foto = !empty($row->foto)
                ? 'https://admin.myesc.id/uploads/ruangan/' . $row->foto
                : 'https://admin.myesc.id/images/nofoto.png';

            $terpakai[] = [
                'idruangan' => $row->idruangan,
                'namaruangan' => $row->namaruangan,
                'kapasitas' => $row->kapasitas,
                'lokasi' => $row->lokasi,
                'fasilitas' => $row->fasilitas,
                'foto' => $foto,
                'tanggal' => $row->tanggal,  // ✅ untuk grouping per hari di FE
                'namadc' => $row->namadc,
                'namapembooking' => $row->namapembooking,
                'jamulai' => $row->jamulai,
                'jamselesai' => $row->jamselesai,
                'keperluan' => $row->keperluan,
                'jenispakai' => $row->jenispakai,
            ];
        }

        echo json_encode([
            'status' => true,
            'terpakai' => $terpakai,
        ]);
    }
}
