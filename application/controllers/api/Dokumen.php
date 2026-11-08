<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Dokumen extends BaseApi
{
    const KODE_KK = 'KK';
    const FIELD_KK = 'filekartukeluarga';
    const MAKS_KB = '5000'; // 5 MB, sama seperti web

    // GET /api/dokumen/kk
    public function kk()
    {
        $idjemaat = $this->requireAuth();
        $this->jsonSuccess(array('dokumen' => $this->_ambilKk($idjemaat)));
    }

    // POST /api/dokumen/uploadKk  (multipart/form-data, field: filekartukeluarga, PDF maks 5 MB)
    public function uploadKk()
    {
        $idjemaat = $this->requireAuth();

        if (empty($_FILES[self::FIELD_KK]['name'])) {
            $this->jsonError('Pilih file PDF Kartu Keluarga terlebih dahulu.');
            return;
        }

        $namaBaru = 'KK_' . $idjemaat . '_' . time() . '.pdf';

        $this->load->library('upload', array(
            'upload_path' => FCPATH . 'myesc.id/admin/uploads/jemaat/',
            'allowed_types' => 'pdf',
            'max_size' => self::MAKS_KB,
            'remove_space' => true,
            'file_name' => $namaBaru,
        ));

        if (!$this->upload->do_upload(self::FIELD_KK)) {
            $pesan = trim(strip_tags($this->upload->display_errors('', '')));
            $this->jsonError($pesan !== '' ? $pesan : 'File KK gagal diunggah.');
            return;
        }

        $namafile = $this->upload->data('file_name');

        // Sama seperti Akun_model::simpanDokumen() di web:
        // status kembali "Menunggu Review" dan catatan admin lama dihapus
        $simpan = $this->db->query("
            INSERT INTO jemaatdokumen (idjemaat, kodedokumen, namafile, statusdokumen, catatanreview, tglupload, tglreview, idadminreview)
            VALUES (?, ?, ?, 'Menunggu Review', NULL, NOW(), NULL, NULL)
            ON DUPLICATE KEY UPDATE
                namafile = VALUES(namafile),
                statusdokumen = 'Menunggu Review',
                catatanreview = NULL,
                tglupload = NOW(),
                tglreview = NULL,
                idadminreview = NULL
        ", array($idjemaat, self::KODE_KK, $namafile));

        if (!$simpan) {
            log_message('error', 'Dokumen::uploadKk gagal simpan DB untuk idjemaat=' . $idjemaat . ' - ' . json_encode($this->db->error()));
            $this->jsonError('Dokumen gagal disimpan. Silakan coba lagi.');
            return;
        }

        $this->jsonSuccess(array(
            'msg' => 'Dokumen KK berhasil diunggah. Admin akan meninjau dokumen kamu.',
            'dokumen' => $this->_ambilKk($idjemaat),
        ));
    }

    // ============================================================
    // Helper
    // ============================================================

    private function _ambilKk($idjemaat)
    {
        $row = $this->db->query(
            "SELECT namafile, statusdokumen, catatanreview FROM jemaatdokumen WHERE idjemaat = ? AND kodedokumen = ? LIMIT 1",
            array($idjemaat, self::KODE_KK)
        )->row();

        if (!$row) {
            return null;
        }

        return array(
            'namafile' => $row->namafile,
            'url' => !empty($row->namafile) ? base_url('myesc.id/admin/uploads/jemaat/' . $row->namafile) : null,
            'status' => $row->statusdokumen,
            'catatan' => $row->catatanreview,
        );
    }
}

/* End of file Dokumen.php */
/* Location: ./application/controllers/api/Dokumen.php */