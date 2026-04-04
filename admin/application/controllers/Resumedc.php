<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resumedc extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Resumedc_model');
        $this->load->library('image_lib');
        $this->session->set_userdata('IDMENUSELECTED', 'M507');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'resumedc';
        $this->load->view('resumedc/listdata', $data);
    }

    public function tambah()
    {
        $data['idshared'] = '';
        $data['menu'] = 'resumedc';
        $this->load->view('resumedc/form', $data);
    }

    public function edit($idshared)
    {
        $idshared = $this->encrypt->decode($idshared);

        if ($this->Resumedc_model->get_by_id($idshared)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('resumedc');
            exit();
        };
        $data['idshared'] = $idshared;
        $data['menu'] = 'resumedc';
        $this->load->view('resumedc/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Resumedc_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                if ($rowdata->status == 'Publish') {
                    $status = '<span class="badge badge-success">' . $rowdata->status . '</span>' . '<br>' . since($rowdata->tglpublish);
                } else {
                    $status = '<span class="badge badge-secondary">' . $rowdata->status . '</span>';
                }

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->tglinsert;
                $row[] = '<a href="' . base_url('uploads/sharedfiles/resumedc/') . $rowdata->fileshared . '" target="_blank">' . $rowdata->title . '</a>';
                $row[] = $status;
                $row[] = '<a href="' . site_url('resumedc/edit/' . $this->encrypt->encode($rowdata->idshared)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="' . site_url('resumedc/delete/' . $this->encrypt->encode($rowdata->idshared)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Resumedc_model->count_all(),
            'recordsFiltered' => $this->Resumedc_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function delete($idshared)
    {
        $idshared = $this->encrypt->decode($idshared);
        $rsdata = $this->Resumedc_model->get_by_id($idshared);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('resumedc');
            exit();
        };
        $rowData = $rsdata->row();

        $hapus = $this->Resumedc_model->hapus($idshared, $rowData);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('resumedc');
    }

    public function simpan()
    {
        $idshared = $this->input->post('idshared');
        $title = $this->input->post('title');
        $status = $this->input->post('status');
        $deskripsisingkat = $this->input->post('deskripsisingkat');
        $fileshared_lama = $this->input->post('fileshared_lama');
        $tglinsert = date('Y-m-d H:i:s');
        $tglupdate = date('Y-m-d H:i:s');

        $fileshared = $this->App->uploadPdf($_FILES, 'fileshared', $fileshared_lama, 'sharedfiles/resumedc', '5000');
        if (empty($fileshared)) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> File resume belum ada!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('resumedc');
        }

        // ✅ TAMBAH BARU
        if ($idshared == '') {
            if ($status == 'Publish') {
                $tglpublish = date('Y-m-d H:i:s');
            } else {
                $tglpublish = null;
            }

            $data = array(
                'tglpublish' => $tglpublish,
                'title' => $title,
                'fileshared' => $fileshared,
                'idjemaatadmin' => $this->session->userdata('idjemaat'),
                'deskripsisingkat' => $deskripsisingkat,
                'tglinsert' => $tglinsert,
                'tglupdate' => $tglupdate,
                'jenisshared' => 'DC DM/CT',
                'status' => $status,
            );
            $simpan = $this->Resumedc_model->simpan($data);

            // ✅ Kirim notif hanya jika status Publish
            if ($simpan && $status == 'Publish') {
                $this->_kirimPushNotifikasiSemua(
                    'Panduan DC Baru 📄',
                    'Panduan baru telah ditambahkan: ' . $title
                );
            }

            // ✅ EDIT
        } else {
            $tglpublish = $this->Resumedc_model->get_by_id($idshared)->row()->tglpublish;
            $kirimNotif = false;

            if (empty($tglpublish)) {
                if ($status == 'Publish') {
                    $tglpublish = date('Y-m-d H:i:s');
                    $kirimNotif = true;  // ✅ baru pertama kali publish
                } else {
                    $tglpublish = null;
                }
            }

            $data = array(
                'tglpublish' => $tglpublish,
                'title' => $title,
                'fileshared' => $fileshared,
                'idjemaatadmin' => $this->session->userdata('idjemaat'),
                'deskripsisingkat' => $deskripsisingkat,
                'tglupdate' => $tglupdate,
                'jenisshared' => 'DC DM/CT',
                'status' => $status,
            );
            $simpan = $this->Resumedc_model->update($data, $idshared);

            // ✅ Kirim notif hanya saat pertama kali publish
            if ($simpan && $kirimNotif) {
                $this->_kirimPushNotifikasiSemua(
                    'Panduan DC Baru 📄',
                    'Panduan baru telah ditambahkan: ' . $title
                );
            }
        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('resumedc');
    }

    public function get_edit_data()
    {
        $idshared = $this->input->post('idshared');
        $RsData = $this->Resumedc_model->get_by_id($idshared)->row();
        echo (json_encode($RsData));
    }

    // ✅ Fungsi kirim notifikasi ke semua DM
    private function _kirimPushNotifikasiSemua($judul, $pesan)
    {
        $rsTokens = $this->db->get('push_tokens')->result();

        if (empty($rsTokens)) {
            return;
        }

        $messages = [];
        foreach ($rsTokens as $row) {
            if (!empty($row->token)) {
                $messages[] = [
                    'to' => $row->token,
                    'title' => $judul,
                    'body' => $pesan,
                    'sound' => 'default',
                    'data' => ['type' => 'panduan'],
                ];
            }
        }

        if (empty($messages)) {
            return;
        }

        // Expo maksimal 100 token per request
        $chunks = array_chunk($messages, 100);
        foreach ($chunks as $chunk) {
            $ch = curl_init('https://exp.host/--/api/v2/push/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($chunk));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}

/* End of file Resumedc.php */
/* Location: ./application/controllers/Resumedc.php */
