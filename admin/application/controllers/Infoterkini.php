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
        $data['statistik'] = $this->Infoterkini_model->getStatistik();
        $data['menu'] = 'infoterkini';
        $this->load->view('infoterkini/listdata', $data);
    }

    // Sumber data DataTables (server-side)
    public function datatablesource()
    {
        $draw = (int) $this->input->post('draw');
        $start = max(0, (int) $this->input->post('start'));
        $length = (int) $this->input->post('length');
        if ($length != -1 && ($length < 1 || $length > 100)) {
            $length = 10;
        }

        $searchInput = $this->input->post('search');
        $search = (is_array($searchInput) && isset($searchInput['value']))
            ? mb_substr(trim((string) $searchInput['value']), 0, 100)
            : '';

        $orderInput = $this->input->post('order');
        $kolomUrut = (is_array($orderInput) && isset($orderInput[0]['column']))
            ? (int) $orderInput[0]['column']
            : null;
        $arah = (is_array($orderInput) && isset($orderInput[0]['dir']) && $orderInput[0]['dir'] === 'desc')
            ? 'desc'
            : 'asc';

        $rows = $this->Infoterkini_model->get_datatables($search, $kolomUrut, $arah, $start, $length);

        $data = array();
        $no = $start;
        foreach ($rows as $r) {
            $no++;
            $enc = $this->encrypt->encode($r->idinfo);
            $aktif = !empty($r->statusaktif);

            $gambar = '<img class="it-thumb" src="' . html_escape(base_url('uploads/info/' . $r->gambar)) . '"'
                . ' alt="' . html_escape($r->judul) . '" loading="lazy"'
                . ' onerror="this.style.opacity=\'.3\';this.alt=\'Gambar tidak ditemukan\';">';

            $judul = '<div class="it-judul">' . html_escape($r->judul) . '</div>';
            if (!empty($r->subjudul)) {
                $judul .= '<div class="it-sub">' . html_escape($r->subjudul) . '</div>';
            }
            if (!empty($r->urltombol)) {
                $judul .= '<div class="mt-1"><i class="fa fa-link" style="color:#FF5008;font-size:11px;"></i> '
                    . '<span class="it-link" title="' . html_escape($r->urltombol) . '">'
                    . html_escape($r->urltombol) . '</span></div>';
            }

            $urutan = '<span class="it-urutan">' . (int) $r->urutan . '</span>';

            $status = $aktif
                ? '<span class="it-badge aktif"><span class="dot"></span>Aktif</span>'
                : '<span class="it-badge nonaktif"><span class="dot"></span>Nonaktif</span>';

            $aksi = '<div class="it-aksi">'
                . '<a href="' . site_url('infoterkini/edit/' . $enc) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>'
                . '<a href="' . site_url('infoterkini/toggle/' . $enc) . '" class="btn '
                . ($aktif ? 'btn-secondary' : 'btn-success') . '" title="' . ($aktif ? 'Nonaktifkan' : 'Aktifkan') . '">'
                . '<i class="fa ' . ($aktif ? 'fa-eye-slash' : 'fa-eye') . '"></i></a>'
                . '<a href="' . site_url('infoterkini/hapus/' . $enc) . '" class="btn btn-danger btnHapus" title="Hapus"><i class="fa fa-trash"></i></a>'
                . '</div>';

            $data[] = array($no, $gambar, $judul, $urutan, $status, $aksi);
        }

        $output = array(
            'draw' => $draw,
            'recordsTotal' => $this->Infoterkini_model->count_all(),
            'recordsFiltered' => $this->Infoterkini_model->count_filtered($search),
            'data' => $data,
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
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

/* End of file Infoterkini.php */
/* Location: ./application/controllers/Infoterkini.php */