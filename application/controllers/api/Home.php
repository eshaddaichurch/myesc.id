<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Home extends BaseApi
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->model('Akun_model');
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
        // Ambil profil jemaat BERDASARKAN $idjemaat dari token.
        // TIDAK memakai Akun_model->getInfoJemaat() karena model itu
        // membaca session yang tidak tersedia di API.
        // ================================================
        $rowProfil = $this->db
            ->query('SELECT * FROM v_jemaat WHERE idjemaat = ?', array($idjemaat))
            ->row();

        $profil = null;
        if ($rowProfil) {
            // --- QR content ---
            $qrContent = $rowProfil->idjemaat;
            if ($rowProfil->statusjemaat == 'Jemaat' && !empty($rowProfil->noaj)) {
                $qrContent = $rowProfil->idjemaat . '-' . $rowProfil->noaj;
            }

            // --- Foto: cek file fisik supaya tidak kirim URL mati ---
            $fotoUrl = null;
            if (!empty($rowProfil->foto)) {
                $pathFisik = FCPATH . 'myesc.id/admin/uploads/jemaat/' . $rowProfil->foto;
                if (file_exists($pathFisik)) {
                    $fotoUrl = base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto);
                }
            }

            $profil = array(
                'idjemaat'        => $rowProfil->idjemaat,
                'namalengkap'     => $rowProfil->namalengkap,
                'noaj'            => !empty($rowProfil->noaj) ? $rowProfil->noaj : null,
                'statusjemaat'    => $rowProfil->statusjemaat,
                'jeniskelamin'    => isset($rowProfil->jeniskelamin) ? $rowProfil->jeniskelamin : null,
                'kewarganegaraan' => isset($rowProfil->kewarganegaraan) ? $rowProfil->kewarganegaraan : null,
                'foto'            => $fotoUrl,
                'qrcontent'       => $qrContent,
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
                'gambar'    => $row->gambarhomepage ? base_url('myesc.id/admin/uploads/infogereja/' . $row->gambarhomepage) : null,
                'judul'     => $row->judulhomepage,
                'subjudul'  => $row->subjudulhomepage,
                'urltombol' => $row->urlbuttonhomepage,
                'tabbaru'   => (bool) $row->opennewtabbuttonhomepage,
            ),
            'profil' => $profil,
            'jumlahnotifikasi' => (int) $jumlahNotifikasi,
        ));
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/api/Home.php */