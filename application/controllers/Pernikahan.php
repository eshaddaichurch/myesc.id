<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pernikahan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->wajibLogin();
        $this->load->model('Home_model');
        $this->load->model('Pernikahan_model');
    }

    public function index($idmenu = "")
    {
        $rsPernikahan = $this->Pernikahan_model->getAll();
        $idmenu = $this->encrypt->decode($idmenu);
        $data['rsPernikahan'] = $rsPernikahan;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('pernikahan/pernikahanesc', $data);
    }


    public function tambah($idmenu = "")
    {
        $this->wajibLogin(); // <-- hanya aktif di sini

        $this->cekStatusWhatsApp();

        //Cek apakah ada permohonan sebelumnya
        if ($this->Pernikahan_model->adaPermohonanSebelumnya()) {
            $pesan = "<script>
                            swal('Permohonan belum dikonfirmasi!', 'Anda masih memiliki permohonan sebelumnya yang belum dikonfirmasi oleh gereja, silahkan tunggu maksimal 2 x 24 Jam untuk mengonfirmasi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('permohonansaya');
        }


        $idmenu = $this->encrypt->decode($idmenu);
        $data['idpernikahan'] = '';
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('pernikahan/formpermohonanpernikahan', $data);
    }


    public function edit($idpernikahan, $idmenu = "")
    {
        $idpernikahan = $this->encrypt->decode($idpernikahan);

        $rsPernikahan = $this->Pernikahan_model->getByID($idpernikahan);
        if ($rsPernikahan->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan pernikahan tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pernikahan');
        }
        $rowPernikahan = $rsPernikahan->row();

        if ($rowPernikahan->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowPernikahan->status . "', 'Status permohonan pernikahan sudah " . $rowPernikahan->status . ", sehingga tidak boleh dihapus lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pernikahan');
        }


        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowPernikahan'] = $rowPernikahan;
        $data['idpernikahan'] = $idpernikahan;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('pernikahan/form', $data);
    }

    // Kirim notifikasi WhatsApp ke admin lewat Fonnte (tidak boleh menggagalkan proses simpan)
    private function kirimWAAdminPernikahan($idjemaat, $nohp, $keterangan, $namamempelaipria, $namamempelaiwanita)
    {
        try {
            $this->config->load('fonnte', TRUE);
            $token = $this->config->item('fonnte_token', 'fonnte');
            $target = $this->config->item('fonnte_admin_pernikahan', 'fonnte');

            if (empty($token) || empty($target)) {
                log_message('error', 'Fonnte: token atau nomor admin pernikahan belum diset di config/fonnte.php');
                return false;
            }

            // Ambil nama jemaat yang mengajukan
            $rowJemaat = $this->db->query(
                "select namalengkap from jemaat where idjemaat = ? limit 1",
                array($idjemaat)
            )->row();
            $nama = $rowJemaat ? $rowJemaat->namalengkap : '-';

            $keterangan = trim((string) $keterangan);
            if ($keterangan === '') {
                $keterangan = '-';
            }

            $pesan = "*Permohonan Pernikahan Baru*\n\n"
                . "Nama Pemohon: " . $nama . "\n"
                . "No HP: " . $nohp . "\n"
                . "Mempelai Pria: " . $namamempelaipria . "\n"
                . "Mempelai Wanita: " . $namamempelaiwanita . "\n"
                . "Keterangan: " . $keterangan . "\n\n"
                . "Silakan konfirmasi permohonan ini di halaman admin.";

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => $pesan,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array('Authorization: ' . $token),
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
            ));
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                log_message('error', 'Fonnte curl error: ' . $error);
                return false;
            }

            $hasil = json_decode($response, true);
            if (empty($hasil['status'])) {
                log_message('error', 'Fonnte gagal kirim WA admin pernikahan: ' . $response);
                return false;
            }
            return true;
        } catch (Exception $e) {
            log_message('error', 'Fonnte exception: ' . $e->getMessage());
            return false;
        }
    }

    public function simpan()
    {
        $idpernikahan = $this->input->post("idpernikahan");
        $nohpyangbisadihubungi = $this->input->post("nohpyangbisadihubungi");
        $keterangan = $this->input->post("keterangan");
        $namamempelaipria = $this->input->post("namamempelaipria");
        $namaayahpria = $this->input->post("namaayahpria");
        $namaibupria = $this->input->post("namaibupria");
        $namamempelaiwanita = $this->input->post("namamempelaiwanita");
        $namaayahwanita = $this->input->post("namaayahwanita");
        $namaibuwanita = $this->input->post("namaibuwanita");
        $tglinsert = date('Y-m-d H:i:s');
        $status = 'Permohonan';
        $permohonanBaru = false;

        if (empty($idpernikahan)) {

            $data = array(
                'tglinsert' => $tglinsert,
                'idjemaat' => $this->session->userdata('idjemaat'),
                'status' => $status,
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keterangan' => $keterangan,
                'namamempelaipria' => $namamempelaipria,
                'namaayahpria' => $namaayahpria,
                'namaibupria' => $namaibupria,
                'namamempelaiwanita' => $namamempelaiwanita,
                'namaayahwanita' => $namaayahwanita,
                'namaibuwanita' => $namaibuwanita,
            );
            $simpan = $this->Pernikahan_model->simpan($data);
            $permohonanBaru = true;
        } else {
            $data = array(
                'idjemaat' => $this->session->userdata('idjemaat'),
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keterangan' => $keterangan,
                'namamempelaipria' => $namamempelaipria,
                'namaayahpria' => $namaayahpria,
                'namaibupria' => $namaibupria,
                'namamempelaiwanita' => $namamempelaiwanita,
                'namaayahwanita' => $namaayahwanita,
                'namaibuwanita' => $namaibuwanita,
            );
            $simpan = $this->Pernikahan_model->update($data, $idpernikahan);
        }

        if ($simpan['status']) {
            // Permohonan baru berhasil: beri tahu admin lewat WhatsApp
            if ($permohonanBaru) {
                $this->kirimWAAdminPernikahan(
                    $this->session->userdata('idjemaat'),
                    $nohpyangbisadihubungi,
                    $keterangan,
                    $namamempelaipria,
                    $namamempelaiwanita
                );
            }

            $pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil disimpan.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Permohonan gagal disimpan. Error: " . $simpan['message'] . "', 'warning');
                        </script>";
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pernikahan');
    }

    public function hapus($idpernikahan)
    {
        $idpernikahan = $this->encrypt->decode($idpernikahan);
        $rsPernikahan = $this->Pernikahan_model->getByID($idpernikahan);
        if ($rsPernikahan->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan pernikahan tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pernikahan');
        }

        $rowPernikahan = $rsPernikahan->row();
        if ($rowPernikahan->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowPernikahan->status . "', 'Status permohonan pernikahan sudah " . $rowPernikahan->status . ", sehingga tidak boleh dihapus lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pernikahan');
        }

        $hapus = $this->Pernikahan_model->hapus($idpernikahan);
        if ($hapus['status']) {
            $pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil dihapus.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Permohonan gagal dihapus. Error: " . $hapus['message'] . "', 'warning');
                        </script>";
        }
        $this->session->set_flashdata('pesan', $pesan);
        redirect('pernikahan');
    }

    public function get_edit_data()
    {
        $idpernikahan = $this->input->get('idpernikahan');

        $rsPernikahan = $this->Pernikahan_model->getByID($idpernikahan);

        $dataEdit = array();
        if ($rsPernikahan->num_rows() > 0) {
            $row = $rsPernikahan->row();
            $dataEdit = array(
                'idpernikahan' => $row->idpernikahan,
                'keterangan' => $row->keterangan,
                'nohpyangbisadihubungi' => $row->nohpyangbisadihubungi,
                'namamempelaipria' => $row->namamempelaipria,
                'namaayahpria' => $row->namaayahpria,
                'namaibupria' => $row->namaibupria,
                'namamempelaiwanita' => $row->namamempelaiwanita,
                'namaayahwanita' => $row->namaayahwanita,
                'namaibuwanita' => $row->namaibuwanita,
            );
        }
        echo json_encode($dataEdit);
    }
}

/* End of file Pernikahan.php */
/* Location: ./application/controllers/Pernikahan.php */