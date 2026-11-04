<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konseling extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->wajibLogin();
        $this->load->model('Home_model');
        $this->load->model('Konseling_model');
    }

    public function index($idmenu = "")
    {
        $rsKonseling = $this->Konseling_model->getAll();
        $idmenu = $this->encrypt->decode($idmenu);
        $data['rsKonseling'] = $rsKonseling;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('konseling/index', $data);
    }


    public function tambah($idmenu = "")
    {
        $idmenu = $this->encrypt->decode($idmenu);

        $this->cekStatusWhatsApp();

        //Cek apakah ada permohonan sebelumnya
        if ($this->Konseling_model->adaPermohonanSebelumnya()) {
            $pesan = "<script>
                            swal('Permohonan belum dikonfirmasi!', 'Anda masih memiliki permohonan sebelumnya yang belum dikonfirmasi oleh gereja, silahkan tunggu maksimal 2 x 24 Jam untuk mengonfirmasi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('permohonansaya');
        }

        $data['idcarekonseling'] = '';
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('konseling/formpermohonankonseling', $data);
    }


    public function edit($idcarekonseling, $idmenu = "")
    {
        $idcarekonseling = $this->encrypt->decode($idcarekonseling);

        $rsKonseling = $this->Konseling_model->getByID($idcarekonseling);
        if ($rsKonseling->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan konseling tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('konseling');
        }
        $rowKonseling = $rsKonseling->row();

        if ($rowKonseling->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowKonseling->status . "', 'Status permohonan konseling sudah " . $rowKonseling->status . ", sehingga tidak boleh dihapus lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('konseling');
        }


        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowKonseling'] = $rowKonseling;
        $data['idcarekonseling'] = $idcarekonseling;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('konseling/form', $data);
    }

    // Kirim notifikasi WhatsApp ke admin lewat Fonnte (tidak boleh menggagalkan proses simpan)
    private function kirimWAAdminKonseling($idjemaat, $nohp, $keterangan)
    {
        try {
            $this->config->load('fonnte', TRUE);
            $token = $this->config->item('fonnte_token', 'fonnte');
            $target = $this->config->item('fonnte_admin_konseling', 'fonnte');

            if (empty($token) || empty($target)) {
                log_message('error', 'Fonnte: token atau nomor admin konseling belum diset di config/fonnte.php');
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

            $pesan = "*Permohonan Konseling Baru*\n\n"
                . "Nama: " . $nama . "\n"
                . "No HP: " . $nohp . "\n"
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
                log_message('error', 'Fonnte gagal kirim WA admin konseling: ' . $response);
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
        $idcarekonseling = $this->input->post("idcarekonseling");
        $tglpermohonan = date('Y-m-d H:i:s');
        $nohpyangbisadihubungi = $this->input->post("nohpyangbisadihubungi");
        $keteranganpermohonan = $this->input->post("keteranganpermohonan");
        $tglinsert = date('Y-m-d H:i:s');
        $status = 'Permohonan';
        $permohonanBaru = false;

        if (empty($idcarekonseling)) {

            $data = array(
                'tglinsert' => $tglinsert,
                'idjemaat' => $this->session->userdata('idjemaat'),
                'status' => $status,
                'tglpermohonan' => $tglpermohonan,
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keteranganpermohonan' => $keteranganpermohonan,
            );
            $simpan = $this->Konseling_model->simpan($data);
            $permohonanBaru = true;
        } else {
            $data = array(
                'tglpermohonan' => $tglpermohonan,
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keteranganpermohonan' => $keteranganpermohonan,
            );
            $simpan = $this->Konseling_model->update($data, $idcarekonseling);
        }

        if ($simpan) {
            // Permohonan baru berhasil: beri tahu admin lewat WhatsApp
            if ($permohonanBaru) {
                $this->kirimWAAdminKonseling(
                    $this->session->userdata('idjemaat'),
                    $nohpyangbisadihubungi,
                    $keteranganpermohonan
                );
            }

            $pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil disimpan.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Permohonan gagal disimpan.', 'warning');
                        </script>";
        }

        // $this->session->set_flashdata('pesan', $pesan);
        // redirect('konseling');

        $this->session->set_flashdata('pesan', $pesan);
        redirect('permohonansaya');

        
    }

    public function hapus($idcarekonseling)
    {
        $idcarekonseling = $this->encrypt->decode($idcarekonseling);
        $rsKonseling = $this->Konseling_model->getByID($idcarekonseling);
        if ($rsKonseling->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan konseling tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('konseling');
        }

        $rowKonseling = $rsKonseling->row();
        if ($rowKonseling->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowKonseling->status . "', 'Status permohonan konseling sudah " . $rowKonseling->status . ", sehingga tidak boleh dihapus lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('konseling');
        }

        $hapus = $this->Konseling_model->hapus($idcarekonseling);
        if ($hapus) {
            $pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil dihapus.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Permohonan gagal dihapus.', 'warning');
                        </script>";
        }
        $this->session->set_flashdata('pesan', $pesan);
        redirect('konseling');
    }

    public function get_edit_data()
    {
        $idcarekonseling = $this->input->get('idcarekonseling');

        $rsKonseling = $this->Konseling_model->getByID($idcarekonseling);

        $dataEdit = array();
        if ($rsKonseling->num_rows() > 0) {
            $row = $rsKonseling->row();
            $dataEdit = array(
                'idcarekonseling' => $row->idcarekonseling,
                'keteranganpermohonan' => $row->keteranganpermohonan,
                'tglpermohonan' => $row->tglpermohonan,
                'nohpyangbisadihubungi' => $row->nohpyangbisadihubungi,
            );
        }
        echo json_encode($dataEdit);
    }
}

/* End of file Konseling.php */
/* Location: ./application/controllers/Konseling.php */