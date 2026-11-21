<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Infoterkini extends BaseApi
{
    // Jumlah maksimal item yang dikirim ke aplikasi
    const BATAS_ITEM = 10;

    // URL publik folder gambar (admin.myesc.id/uploads/info/)
    const BASE_GAMBAR = 'https://admin.myesc.id/uploads/info/';

    // Lokasi fisik folder gambar, relatif terhadap FCPATH (root myesc.id)
    const FOLDER_GAMBAR = 'admin/uploads/info/';

    // Masa simpan respons di perangkat/CDN (detik)
    const CACHE_DETIK = 300;

    // GET /api/infoterkini (tanpa login)
    public function index()
    {
        $rows = $this->db
            ->select('idinfo, judul, subjudul, gambar, urltombol')
            ->from('info_terkini')
            ->where('statusaktif', 1)
            ->order_by('urutan', 'ASC')
            ->order_by('idinfo', 'DESC')
            ->limit(self::BATAS_ITEM)
            ->get()
            ->result();

        $folder = realpath(FCPATH . self::FOLDER_GAMBAR);
        $items = array();

        foreach ($rows as $r) {
            // Nama file harus sesuai pola yang dibuat helper upload
            if (!preg_match('/^info_[0-9A-Za-z_]+\.(jpg|png|webp)$/', (string) $r->gambar)) {
                continue;
            }

            // Lewati item jika file gambarnya tidak ada di server
            if ($folder === false || !is_file($folder . DIRECTORY_SEPARATOR . $r->gambar)) {
                continue;
            }

            // Hanya link http/https yang dikirim ke aplikasi
            $urltombol = null;
            if (!empty($r->urltombol) && preg_match('#^https?://#i', $r->urltombol)) {
                $urltombol = $r->urltombol;
            }

            $items[] = array(
                'idinfo'    => (int) $r->idinfo,
                'judul'     => $r->judul,
                'subjudul'  => !empty($r->subjudul) ? $r->subjudul : null,
                'gambar'    => self::BASE_GAMBAR . rawurlencode($r->gambar),
                'urltombol' => $urltombol,
            );
        }

        $this->output->set_header('Cache-Control: public, max-age=' . self::CACHE_DETIK);

        $this->jsonSuccess(array(
            'status' => count($items) > 0 ? 'ada' : 'kosong',
            'items'  => $items,
        ));
    }
}

/* End of file Infoterkini.php */
/* Location: ./application/controllers/api/Infoterkini.php */