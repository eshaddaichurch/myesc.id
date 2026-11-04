<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Baptisan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->wajibLogin();
        $this->load->model('Home_model');
        $this->load->model('Baptisan_model');
    }

    public function index($idmenu = "")
    {
        $rsBaptisan = $this->Baptisan_model->getAll();
        $idmenu = $this->encrypt->decode($idmenu);

        // Cek status jemaat yang login
        $idjemaat = $this->session->userdata('idjemaat');
        $sudahBaptis = false;
        $belumFC1 = false;
        if (!empty($idjemaat)) {
            $sudahBaptis = $this->Baptisan_model->sudahPunyaAkta($idjemaat);
            if (!$sudahBaptis) {
                $belumFC1 = !$this->Baptisan_model->sudahPunyaSertifikatFC1($idjemaat);
            }
        }

        $data['rsBaptisan'] = $rsBaptisan;
        $data['sudahBaptis'] = $sudahBaptis;
        $data['belumFC1'] = $belumFC1;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('baptisan/baptisanesc', $data);
    }

    // Jika jemaat sudah punya akta baptis, tolak dan arahkan kembali
    private function tolakJikaSudahBaptis()
    {
        if ($this->Baptisan_model->sudahPunyaAkta($this->session->userdata('idjemaat'))) {
            $pesan = "<script>
                            swal('Sudah Dibaptis', 'Anda sudah memiliki akta baptis, sehingga tidak dapat mengajukan permohonan baptisan lagi.', 'info');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('baptisan');
        }
    }

    // Jika jemaat belum punya sertifikat Foundation Class 1, arahkan ke halaman pendaftaran FC1
    private function tolakJikaBelumFC1()
    {
        // Pastikan sudah login, kalau belum arahkan ke login
        $this->wajibLogin();

        if (!$this->Baptisan_model->sudahPunyaSertifikatFC1($this->session->userdata('idjemaat'))) {
            $pesan = "<script>
                            swal('Belum Memenuhi Syarat', 'Untuk mengajukan permohonan baptisan, Anda harus sudah memiliki sertifikat Foundation Class 1. Silakan daftar Foundation Class 1 terlebih dahulu.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('nextstep/kelas/foundation_class_1');
        }
    }

    public function tambah($idmenu = "")
    {
        $this->wajibLogin();

        $this->cekStatusWhatsApp();

        // Cek apakah jemaat sudah punya akta baptis
        $this->tolakJikaSudahBaptis();

        // Cek apakah jemaat sudah punya sertifikat Foundation Class 1
        $this->tolakJikaBelumFC1();

        //Cek apakah ada permohonan sebelumnya
        if ($this->Baptisan_model->adaPermohonanSebelumnya()) {
            $pesan = "<script>
                            swal('Permohonan belum dikonfirmasi!', 'Anda masih memiliki permohonan sebelumnya yang belum dikonfirmasi oleh gereja, silahkan tunggu maksimal 2 x 24 Jam untuk mengonfirmasi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('permohonansaya');
        }

        $idmenu = $this->encrypt->decode($idmenu);
        $data['idcarebaptisan'] = '';
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('baptisan/formpermohonanbaptisan', $data);
    }


    public function edit($idcarebaptisan, $idmenu = "")
    {
        $idcarebaptisan = $this->encrypt->decode($idcarebaptisan);

        $rsBaptisan = $this->Baptisan_model->getByID($idcarebaptisan);
        if ($rsBaptisan->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan baptisan tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('baptisan');
        }
        $rowBaptisan = $rsBaptisan->row();

        if ($rowBaptisan->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowBaptisan->status . "', 'Status permohonan baptisan sudah " . $rowBaptisan->status . ", sehingga tidak boleh diubah lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('baptisan');
        }


        $idmenu = $this->encrypt->decode($idmenu);
        $data['rowBaptisan'] = $rowBaptisan;
        $data['idcarebaptisan'] = $idcarebaptisan;
        $data['menu'] = $idmenu;
        $data["rowinfogereja"] = $this->Home_model->get_infogereja();
        $this->load->view('baptisan/form', $data);
    }

    public function simpan()
    {
        // Wajib login sebelum menyimpan
        $this->wajibLogin();

        $idcarebaptisan = $this->input->post("idcarebaptisan");
        $tglpermohonan = date('Y-m-d H:i:s');
        $nohpyangbisadihubungi = $this->input->post("nohpyangbisadihubungi");
        $keteranganpermohonan = $this->input->post("keteranganpermohonan");
        $tglinsert = date('Y-m-d H:i:s');
        $status = 'Permohonan';

        if (empty($idcarebaptisan)) {

            // Permohonan baru: tolak jika sudah punya akta baptis
            $this->tolakJikaSudahBaptis();

            // Permohonan baru: tolak jika belum punya sertifikat Foundation Class 1
            $this->tolakJikaBelumFC1();

            $data = array(
                'tglinsert' => $tglinsert,
                'idjemaat' => $this->session->userdata('idjemaat'),
                'status' => $status,
                'tglpermohonan' => $tglpermohonan,
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keteranganpermohonan' => $keteranganpermohonan,
            );
            $simpan = $this->Baptisan_model->simpan($data);
        } else {
            $data = array(
                'nohpyangbisadihubungi' => $nohpyangbisadihubungi,
                'keteranganpermohonan' => $keteranganpermohonan,
            );
            $simpan = $this->Baptisan_model->update($data, $idcarebaptisan);
        }

        if ($simpan['status']) {
            $pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil disimpan.', 'success');
                        </script>";
        } else {
            $pesan = "<script>
                            swal('Gagal', 'Permohonan gagal disimpan. Error: " . $simpan['message'] . "', 'warning');
                        </script>";
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('baptisan');
    }

    public function hapus($idcarebaptisan)
    {
        $idcarebaptisan = $this->encrypt->decode($idcarebaptisan);
        $rsBaptisan = $this->Baptisan_model->getByID($idcarebaptisan);
        if ($rsBaptisan->num_rows() == 0) {
            $pesan = "<script>
                            swal('Upss', 'Data permohonan baptisan tidak ditemukan.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('baptisan');
        }

        $rowBaptisan = $rsBaptisan->row();
        if ($rowBaptisan->status != "Permohonan") {
            $pesan = "<script>
                            swal('Sudah " . $rowBaptisan->status . "', 'Status permohonan baptisan sudah " . $rowBaptisan->status . ", sehingga tidak boleh dihapus lagi.', 'warning');
                        </script>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('baptisan');
        }

        $hapus = $this->Baptisan_model->hapus($idcarebaptisan);
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
        redirect('baptisan');
    }

    public function get_edit_data()
    {
        $idcarebaptisan = $this->input->get('idcarebaptisan');

        $rsBaptisan = $this->Baptisan_model->getByID($idcarebaptisan);

        $dataEdit = array();
        if ($rsBaptisan->num_rows() > 0) {
            $row = $rsBaptisan->row();
            $dataEdit = array(
                'idcarebaptisan' => $row->idcarebaptisan,
                'keteranganpermohonan' => $row->keteranganpermohonan,
                'tglpermohonan' => $row->tglpermohonan,
                'nohpyangbisadihubungi' => $row->nohpyangbisadihubungi,
            );
        }
        echo json_encode($dataEdit);
    }
}

/* End of file Baptisan.php */
/* Location: ./application/controllers/Baptisan.php */