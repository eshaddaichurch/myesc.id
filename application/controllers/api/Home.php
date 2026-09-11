<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Home extends BaseApi
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->model('Akun_model'); // dipakai untuk ambil data profil jemaat (sama seperti web)
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

        // ================================================
        // DATA PROFIL SINGKAT UNTUK KARTU DI HOME (foto, no. anggota, status, QR)
        // Sumbernya sama persis dengan halaman web akun/profil (Akun_model->getInfoJemaat()).
        //
        // LOGIKA QR CODE BERDASARKAN STATUS JEMAAT (disamakan dengan web):
        // - Umum / Simpatisan  -> QR hanya idjemaat
        // - Jemaat (+ noaj)    -> QR = idjemaat-noaj (permanen)
        // ================================================
        $rowProfil = $this->Akun_model->getInfoJemaat()->row();

        $profil = null;
        if ($rowProfil) {
            $qrContent = $rowProfil->idjemaat;
            if ($rowProfil->statusjemaat == 'Jemaat' && !empty($rowProfil->noaj)) {
                $qrContent = $rowProfil->idjemaat . '-' . $rowProfil->noaj;
            }

            $profil = array(
                'idjemaat'     => $rowProfil->idjemaat,
                'namalengkap'  => $rowProfil->namalengkap,
                'noaj'         => $rowProfil->noaj ? $rowProfil->noaj : null,
                'statusjemaat' => $rowProfil->statusjemaat,
                'foto'         => $rowProfil->foto
                    ? base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto)
                    : null,
                'qrcontent'    => $qrContent,
            );
        }

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
            'profil' => $profil,
            'jumlahnotifikasi' => (int) $jumlahNotifikasi,
        ));
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/api/Home.php */