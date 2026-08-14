<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Give extends BaseApi
{
    private function categories()
    {
        $baseImg = base_url('myesc.id/assets/gambar/');
        $confirmNote = 'Jika Saudara ingin mendapatkan bukti transfer dengan nama pengirim, khusus untuk Persepuluhan dan Pembangunan, silakan transfer menggunakan nomor rekening (bukan scan QR Code).';

        return array(
            array(
                'slug' => 'persepuluhan',
                'title' => 'Persembahan Persepuluhan',
                'qrcode' => $baseImg . 'perpuluhan.png',
                'accounts' => array(
                    array('label' => 'BCA', 'nama_pemilik' => 'Gereja Bethel Indonesia', 'rekening_display' => '029 227 6611', 'rekening_copy' => '0292276611'),
                    array('label' => 'QRIS CIMB', 'nama_pemilik' => 'Gereja Bethel Indonesia', 'rekening_display' => '7061 4361 6500', 'rekening_copy' => '70614361 6500'),
                ),
                'confirm_note' => $confirmNote,
            ),
            array(
                'slug' => 'pembangunan',
                'title' => 'Persembahan Pembangunan',
                'qrcode' => $baseImg . 'pembangunan.png',
                'accounts' => array(
                    array('label' => 'QRIS CIMB', 'nama_pemilik' => 'Gereja Bethel Indonesia Jemaat El Shaddai', 'rekening_display' => '7061 4359 5600', 'rekening_copy' => '706143595600'),
                    array('label' => 'BCA', 'nama_pemilik' => 'Gereja Bethel Indonesia', 'rekening_display' => '029 227 6115', 'rekening_copy' => '0292276115'),
                ),
                'confirm_note' => $confirmNote,
            ),
            array(
                'slug' => 'persembahan_pertama',
                'title' => 'Persembahan Pertama (Diakonia)',
                'qrcode' => $baseImg . 'persembahan_diakonia.png',
                'accounts' => array(
                    array('label' => 'QRIS CIMB', 'nama_pemilik' => 'Gereja Bethel Indonesia Jemaat El Shaddai', 'rekening_display' => '7061 4357 5600', 'rekening_copy' => '706143575600'),
                ),
                'confirm_note' => $confirmNote,
            ),
            array(
                'slug' => 'persembahan_kedua',
                'title' => 'Persembahan Kedua (Umum)',
                'qrcode' => $baseImg . 'persembahan_umum.png',
                'accounts' => array(
                    array('label' => 'QRIS CIMB', 'nama_pemilik' => 'Gereja Bethel Indonesia Jemaat El Shaddai', 'rekening_display' => '7060 1517 0700', 'rekening_copy' => '706015170700'),
                ),
                'confirm_note' => $confirmNote,
            ),
        );
    }

    // GET /api/give/list
    public function list()
    {
        $this->requireAuth();
        $this->jsonSuccess(array('kategori' => $this->categories()));
    }

    // GET /api/give/detail/{slug}
    public function detail($slug = '')
    {
        $this->requireAuth();

        foreach ($this->categories() as $kategori) {
            if ($kategori['slug'] === $slug) {
                $this->jsonSuccess(array('kategori' => $kategori));
                return;
            }
        }

        $this->jsonError('Kategori persembahan tidak ditemukan.');
    }
}

/* End of file Give.php */
/* Location: ./application/controllers/api/Give.php */
