<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruangan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Ruangan_model');
        $this->load->library('image_lib');
        $this->session->set_userdata('IDMENUSELECTED', 'M508');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'ruangan';
        $this->load->view('ruangan/listdata', $data);
    }

    public function tambah()
    {
        $data['idruangan'] = '';
        $data['menu'] = 'ruangan';
        $this->load->view('ruangan/form', $data);
    }

    public function edit($idruangan)
    {
        $idruangan = $this->encrypt->decode($idruangan);
        if ($this->Ruangan_model->get_by_id($idruangan)->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('ruangan');
            exit();
        }
        $data['idruangan'] = $idruangan;
        $data['menu'] = 'ruangan';
        $this->load->view('ruangan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Ruangan_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $row) {
                $no++;

                $fotoSrc = base_url('images/nofoto.png');
                if (!empty($row->foto)) {
                    $fotoSrc = base_url('uploads/ruangan/' . $row->foto);
                }
                $fotoHtml = '<img src="' . $fotoSrc . '" width="45" height="45"
                                class="rounded border" style="object-fit:cover;">';

                $badgeStatus = ($row->statusaktif == 'Aktif')
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-secondary">Nonaktif</span>';

                $kapasitas = $row->kapasitas > 0
                    ? '<span class="badge badge-info">' . $row->kapasitas . ' Orang</span>'
                    : '-';

                $aksi = '
                    <a href="' . site_url('ruangan/edit/' . $this->encrypt->encode($row->idruangan)) . '"
                        class="btn btn-sm btn-warning btn-circle" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="' . site_url('ruangan/blokir/' . $this->encrypt->encode($row->idruangan)) . '"
                        class="btn btn-sm btn-danger btn-circle" title="Blokir Ruangan">
                        <i class="fa fa-ban"></i>
                    </a>
                    <a href="' . site_url('ruangan/delete/' . $this->encrypt->encode($row->idruangan)) . '"
                        class="btn btn-sm btn-dark btn-circle" id="hapus" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </a>';

                $data[] = array(
                    $no,
                    $fotoHtml,
                    '<b>' . $row->namaruangan . '</b>',
                    $row->lokasi ?? '-',
                    $kapasitas,
                    $row->fasilitas ?? '-',
                    $badgeStatus,
                    $aksi,
                );
            }
        }

        echo json_encode(array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Ruangan_model->count_all(),
            'recordsFiltered' => $this->Ruangan_model->count_filtered(),
            'data' => $data,
        ));
    }

    public function simpan()
    {
        $idruangan = $this->input->post('idruangan');
        $namaruangan = $this->input->post('namaruangan');
        $kapasitas = $this->input->post('kapasitas');
        $lokasi = $this->input->post('lokasi');
        $fasilitas = $this->input->post('fasilitas');
        $keterangan = $this->input->post('keterangan');
        $statusaktif = $this->input->post('statusaktif');
        $now = date('Y-m-d H:i:s');

        if ($idruangan == '') {
            $idruangan = $this->db->query(
                'SELECT create_idruangan() AS idruangan'
            )->row()->idruangan;

            $foto = $this->_upload_foto($_FILES, 'foto');

            $data = array(
                'idruangan' => $idruangan,
                'namaruangan' => $namaruangan,
                'kapasitas' => $kapasitas,
                'lokasi' => $lokasi,
                'fasilitas' => $fasilitas,
                'keterangan' => $keterangan,
                'foto' => $foto,
                'statusaktif' => $statusaktif,
                'tanggalinsert' => $now,
                'tanggalupdate' => $now,
            );
            $simpan = $this->Ruangan_model->simpan($data);
        } else {
            $rowLama = $this->Ruangan_model->get_by_id($idruangan)->row();
            $fotoLama = $rowLama->foto ?? '';
            $foto = $this->_update_foto($_FILES, 'foto', $fotoLama);

            $data = array(
                'namaruangan' => $namaruangan,
                'kapasitas' => $kapasitas,
                'lokasi' => $lokasi,
                'fasilitas' => $fasilitas,
                'keterangan' => $keterangan,
                'foto' => $foto,
                'statusaktif' => $statusaktif,
                'tanggalupdate' => $now,
            );
            $simpan = $this->Ruangan_model->update($data, $idruangan);
        }

        if ($simpan) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Data berhasil disimpan!'));
        } else {
            $eror = $this->db->error();
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data gagal disimpan! ' . $eror['message']));
        }
        redirect('ruangan');
    }

    public function delete($idruangan)
    {
        $idruangan = $this->encrypt->decode($idruangan);
        if ($this->Ruangan_model->get_by_id($idruangan)->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('ruangan');
            exit();
        }

        $rowLama = $this->Ruangan_model->get_by_id($idruangan)->row();
        if (!empty($rowLama->foto)) {
            $path = 'uploads/ruangan/' . $rowLama->foto;
            if (file_exists($path))
                unlink($path);
        }

        $hapus = $this->Ruangan_model->hapus($idruangan);
        if ($hapus) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Data berhasil dihapus!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data gagal dihapus!'));
        }
        redirect('ruangan');
    }

    // ── BLOKIR ───────────────────────────────────────────────
    public function blokir($idruangan)
    {
        $idruangan = $this->encrypt->decode($idruangan);
        if ($this->Ruangan_model->get_by_id($idruangan)->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data ruangan tidak ditemukan!'));
            redirect('ruangan');
            return;
        }
        $data['rowRuangan'] = $this->Ruangan_model->get_by_id($idruangan)->row();
        $data['rsBlokir'] = $this->Ruangan_model->getBlokirByRuangan($idruangan);
        $data['idruangan'] = $idruangan;
        $data['menu'] = 'ruangan';
        $this->load->view('ruangan/blokir', $data);
    }

    public function simpanblokir()
    {
        $idblokir = $this->input->post('idblokir');
        $idruangan = $this->input->post('idruangan');
        $tanggalblokir = $this->input->post('tanggalblokir');
        $jenisblokir = $this->input->post('jenisblokir');
        $keterangan = $this->input->post('keterangan');
        $now = date('Y-m-d H:i:s');

        $jamulai = ($jenisblokir == 'perjam') ? $this->input->post('jamulai') : null;
        $jamselesai = ($jenisblokir == 'perjam') ? $this->input->post('jamselesai') : null;

        if ($jenisblokir == 'perjam' && $jamselesai <= $jamulai) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Jam selesai harus lebih besar dari jam mulai!'));
            redirect('ruangan/blokir/' . $this->encrypt->encode($idruangan));
            return;
        }

        if ($idblokir == '') {
            $idblokir = $this->db->query(
                'SELECT create_idblokir() AS idblokir'
            )->row()->idblokir;

            $data = array(
                'idblokir' => $idblokir,
                'idruangan' => $idruangan,
                'tanggalblokir' => $tanggalblokir,
                'jamulai' => $jamulai,
                'jamselesai' => $jamselesai,
                'keterangan' => $keterangan,
                'tanggalinsert' => $now,
                'tanggalupdate' => $now,
            );
            $simpan = $this->Ruangan_model->simpanBlokir($data);
        } else {
            $data = array(
                'tanggalblokir' => $tanggalblokir,
                'jamulai' => $jamulai,
                'jamselesai' => $jamselesai,
                'keterangan' => $keterangan,
                'tanggalupdate' => $now,
            );
            $simpan = $this->Ruangan_model->updateBlokir($data, $idblokir);
        }

        if ($simpan) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Data blokir berhasil disimpan!'));
        } else {
            $eror = $this->db->error();
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal menyimpan! ' . $eror['message']));
        }
        redirect('ruangan/blokir/' . $this->encrypt->encode($idruangan));
    }

    public function hapusblokir($idblokir)
    {
        $idblokir = $this->encrypt->decode($idblokir);
        $rsBlokir = $this->Ruangan_model->getBlokirById($idblokir);

        if ($rsBlokir->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('ruangan');
            return;
        }

        $idruangan = $rsBlokir->row()->idruangan;
        $hapus = $this->Ruangan_model->hapusBlokir($idblokir);

        if ($hapus) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Data blokir berhasil dihapus!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data blokir gagal dihapus!'));
        }
        redirect('ruangan/blokir/' . $this->encrypt->encode($idruangan));
    }

    // ── HELPER ───────────────────────────────────────────────
    private function _upload_foto($file, $field)
    {
        if (!empty($file[$field]['name'])) {
            if (!is_dir('uploads/ruangan/')) {
                mkdir('uploads/ruangan/', 0777, true);
            }
            $config = array(
                'upload_path' => 'uploads/ruangan/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'remove_spaces' => TRUE,
                'max_size' => 2000,
            );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload($field)) {
                return $this->upload->data('file_name');
            }
        }
        return '';
    }

    private function _update_foto($file, $field, $foto_lama)
    {
        if (!empty($file[$field]['name'])) {
            if (!empty($foto_lama) && file_exists('uploads/ruangan/' . $foto_lama)) {
                unlink('uploads/ruangan/' . $foto_lama);
            }
            $foto_baru = $this->_upload_foto($file, $field);
            return !empty($foto_baru) ? $foto_baru : $foto_lama;
        }
        return $foto_lama;
    }

    private function _pesan($type, $text)
    {
        $label = ($type == 'success') ? 'Berhasil!' : 'Gagal!';
        return '
        <div class="alert alert-' . $type . ' alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <strong>' . $label . '</strong> ' . $text . '
        </div>';
    }
}
