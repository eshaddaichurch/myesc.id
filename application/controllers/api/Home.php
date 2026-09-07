<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Home extends BaseApi
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
    }

    // GET /api/home/infogereja
    public function infogereja()
    {
        $idjemaat = $this->requireAuth();

        $row = $this->Home_model->get_infogereja();

        if (!$row) {
            $this->jsonError('Data info gereja tidak ditemukan.');
            return;
        }

        $jumlahNotifikasi = $this->Home_model->getNotifikasi($idjemaat);

        $this->jsonSuccess(array(
            'gereja' => array(
                'namagereja'    => $row->namagereja,
                'alamatgereja'  => $row->alamatgereja,
                'emailgereja'   => $row->emailgereja,
                'notelpgereja'  => $row->notelpgereja,
                'urltwitter'    => $row->urltwittergereja,
                'urlfacebook'   => $row->urlfacebookgereja,
                'urlinstagram'  => $row->urlinstagramgereja,
                'urlgooglemaps' => $row->urlgooglemaps,
            ),
            'hero' => array(
                'gambar'      => $row->gambarhomepage ? base_url('myesc.id/admin/uploads/infogereja/' . $row->gambarhomepage) : null,
                'judul'       => $row->judulhomepage,
                'subjudul'    => $row->subjudulhomepage,
                'urltombol'   => $row->urlbuttonhomepage,
                'tabbaru'     => (bool) $row->opennewtabbuttonhomepage,
            ),
            'jumlahnotifikasi' => (int) $jumlahNotifikasi,
        ));
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/api/Home.php */