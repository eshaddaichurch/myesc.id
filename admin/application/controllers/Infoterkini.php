<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infoterkini extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Infoterkini_model');
        $this->load->helper('info_upload');
        $this->session->set_userdata('IDMENUSELECTED', '0009');
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['rsInfo'] = $this->Infoterkini_model->getAll();
        $data['menu'] = 'infoterkini';
        $this->load->view('infoterkini/listdata', $data);
    }

    public function tambah()
    {
        $data['idinfo'] = 0;
        $data['row'] = null;
        $data['menu'] = 'infoterkini';
        $this->load->view('infoterkini/form', $data);
    }

    public function edit($idinfoEnc)
    {
        $idinfo = $this->_decodeId($idinfoEnc);
        $rs = $idinfo > 0 ? $this->Infoterkini_model->getById($idinfo) : null;

        if (!$rs || $rs->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('infoterkini');
            return;
        }

        $data['idinfo'] = $idinfo;
        $data['row'] = $rs->row();
        $data['menu'] = 'infoterkini';
        $this->load->view('infoterkini/form', $data);
    }

    public function simpan()
    {
        $idinfo = $this->_decodeId($this->input->post('idinfo'));
        $judul = trim((string) $this->input->post('judul'));
        $subjudul = trim((string) $this->input->post('subjudul'));
        $urltombol = trim((string) $this->input->post('urltombol'));
        $urutan = (int) $this->input->post('urutan');
        $statusaktif = $this->input->post('statusaktif') ? 1 : 0;

        // Validasi teks
        if ($judul === '' || mb_strlen($judul) > 150) {
            return $this->_gagal('Judul wajib diisi (maksimal 150 karakter).', $idinfo);
        }
        if (mb_strlen($subjudul) > 150) {
            return $this->_gagal('Subjudul maksimal 150 karakter.', $idinfo);
        }
        if ($urltombol !== '') {
            if (mb_strlen($urltombol) > 255 || !preg_match('#^https?://#i', $urltombol) || !filter_var($urltombol, FILTER_VALIDATE_URL)) {
                return $this->_gagal('Link tombol harus diawali http:// atau https://.', $idinfo);
            }
        }
        if ($urutan < 0 || $urutan > 9999) {
            $urutan = 0;
        }

        // Data lama untuk edit
        $lama = null;
        if ($idinfo > 0) {
            $rs = $this->Infoterkini_model->getById($idinfo);
            if ($rs->num_rows() < 1) {
                $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
                redirect('infoterkini');
                return;
            }
            $lama = $rs->row()->gambar;
        }

        // Gambar wajib saat tambah, opsional saat edit
        $gambar = $lama;
        if (!empty($_FILES['gambar']['name'])) {
            try {
                $gambar = info_upload_gambar('gambar');
            } catch (RuntimeException $e) {
                return $this->_gagal($e->getMessage(), $idinfo);
            }
        } elseif ($idinfo === 0) {
            return $this->_gagal('Gambar wajib diunggah.', 0);
        }

        $data = array(
            'judul' => $judul,
            'subjudul' => $subjudul !== '' ? $subjudul : null,
            'gambar' => $gambar,
            'urltombol' => $urltombol !== '' ? $urltombol : null,
            'urutan' => $urutan,
            'statusaktif' => $statusaktif,
        );

        if ($idinfo > 0) {
            $ok = $this->Infoterkini_model->update($idinfo, $data);
        } else {
            $data['tanggalinsert'] = date('Y-m-d H:i:s');
            $ok = $this->Infoterkini_model->simpan($data);
        }

        if ($ok) {
            // Gambar lama dihapus hanya setelah data baru tersimpan
            if ($lama && $gambar !== $lama) {
                info_hapus_gambar($lama);
            }
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Info terkini berhasil disimpan!'));
        } else {
            // Gambar baru yang sudah terlanjur diunggah dibersihkan
            if ($gambar && $gambar !== $lama) {
                info_hapus_gambar($gambar);
            }
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal menyimpan data!'));
        }
        redirect('infoterkini');
    }

    public function hapus($idinfoEnc)
    {
        $idinfo = $this->_decodeId($idinfoEnc);
        $rs = $idinfo > 0 ? $this->Infoterkini_model->getById($idinfo) : null;

        if (!$rs || $rs->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('infoterkini');
            return;
        }

        $gambar = $rs->row()->gambar;
        if ($this->Infoterkini_model->hapus($idinfo)) {
            info_hapus_gambar($gambar);
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Info terkini berhasil dihapus!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal menghapus data!'));
        }
        redirect('infoterkini');
    }

    public function toggle($idinfoEnc)
    {
        $idinfo = $this->_decodeId($idinfoEnc);
        $rs = $idinfo > 0 ? $this->Infoterkini_model->getById($idinfo) : null;

        if (!$rs || $rs->num_rows() < 1) {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Data tidak ditemukan!'));
            redirect('infoterkini');
            return;
        }

        $statusBaru = $rs->row()->statusaktif ? 0 : 1;
        if ($this->Infoterkini_model->setStatus($idinfo, $statusBaru)) {
            $this->session->set_flashdata('pesan', $this->_pesan('success', 'Status berhasil diubah!'));
        } else {
            $this->session->set_flashdata('pesan', $this->_pesan('danger', 'Gagal mengubah status!'));
        }
        redirect('infoterkini');
    }

    // Mengembalikan id asli dari hasil encrypt, atau 0 jika tidak valid
    private function _decodeId($enc)
    {
        if (empty($enc)) {
            return 0;
        }
        $id = $this->encrypt->decode((string) $enc);
        return ctype_digit((string) $id) ? (int) $id : 0;
    }

    private function _gagal($pesan, $idinfo)
    {
        $this->session->set_flashdata('pesan', $this->_pesan('danger', $pesan));
        if ($idinfo > 0) {
            redirect('infoterkini/edit/' . $this->encrypt->encode($idinfo));
        } else {
            redirect('infoterkini/tambah');
        }
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