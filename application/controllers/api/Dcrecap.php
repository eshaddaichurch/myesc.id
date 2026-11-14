<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';
require_once APPPATH . 'helpers/dcfoto_helper.php';

class Dcrecap extends BaseApi
{
    // Untuk jemaat yang tergabung DC
    const JUMLAH_MINGGU_MEMBER = 12;
    const MAKS_FOTO_PER_MINGGU_MEMBER = 50;

    // Tanpa login: hanya minggu terbaru, dibatasi jumlahnya
    const JUMLAH_MINGGU_PUBLIK = 1;
    const MAKS_FOTO_PUBLIK = 12;

    const BATAS_BARIS = 300;

    // Masa berlaku URL foto (detik). 86400 = 24 jam
    const MASA_BERLAKU_FOTO = 86400;

    // GET /api/dcrecap (wajib login)
    // status: ada | kosong | bukan_member
    public function index()
    {
        $idjemaat = $this->requireAuth();

        $member = $this->db->query(
            'SELECT iddc FROM v_dcmember WHERE idjemaat = ? LIMIT 1',
            array($idjemaat)
        )->row();

        if (!$member) {
            $this->jsonSuccess(array('status' => 'bukan_member', 'minggu' => array()));
            return;
        }

        $batas = (int) self::BATAS_BARIS;

        $rows = $this->db->query(
            "SELECT idabsen, tglabsen, keterangan, foto
             FROM dcabsen
             WHERE iddc = ?
               AND foto IS NOT NULL AND foto <> ''
             ORDER BY tglabsen DESC
             LIMIT {$batas}",
            array($member->iddc)
        )->result();

        $minggu = $this->_kelompokkan(
            $rows,
            self::JUMLAH_MINGGU_MEMBER,
            self::MAKS_FOTO_PER_MINGGU_MEMBER,
            true
        );

        $this->jsonSuccess(array(
            'status' => count($minggu) > 0 ? 'ada' : 'kosong',
            'minggu' => $minggu,
        ));
    }

    // GET /api/dcrecap/publik (tanpa login)
    // Foto minggu terbaru dari semua DC. Tanpa keterangan dan tanpa nama DC.
    public function publik()
    {
        $batas = (int) self::BATAS_BARIS;

        $rows = $this->db->query(
            "SELECT idabsen, tglabsen, foto
             FROM dcabsen
             WHERE foto IS NOT NULL AND foto <> ''
             ORDER BY tglabsen DESC
             LIMIT {$batas}"
        )->result();

        $minggu = $this->_kelompokkan(
            $rows,
            self::JUMLAH_MINGGU_PUBLIK,
            self::MAKS_FOTO_PUBLIK,
            false
        );

        $this->jsonSuccess(array(
            'status' => count($minggu) > 0 ? 'ada' : 'kosong',
            'minggu' => $minggu,
        ));
    }

    // Mengelompokkan foto per minggu ISO (Senin sampai Minggu), dari yang terbaru
    private function _kelompokkan($rows, $jumlahMinggu, $maksFoto, $sertakanKeterangan)
    {
        $minggu = array();

        foreach ($rows as $r) {
            $ts = strtotime($r->tglabsen);
            if ($ts === false) {
                continue;
            }

            $kunci = date('o-W', $ts);
            if (!isset($minggu[$kunci])) {
                if (count($minggu) >= $jumlahMinggu) {
                    break;
                }

                $senin = $ts - (((int) date('N', $ts)) - 1) * 86400;
                $minggu[$kunci] = array(
                    'kunci' => $kunci,
                    'mulai' => date('Y-m-d', $senin),
                    'selesai' => date('Y-m-d', $senin + 6 * 86400),
                    'foto' => array(),
                );
            }

            if (count($minggu[$kunci]['foto']) >= $maksFoto) {
                continue;
            }

            $item = array(
                'idabsen' => $r->idabsen,
                'tglabsen' => $r->tglabsen,
                'url' => $this->_urlFoto($r->foto),
            );
            if ($sertakanKeterangan) {
                $item['keterangan'] = $r->keterangan;
            }

            $minggu[$kunci]['foto'][] = $item;
        }

        return array_values($minggu);
    }

    // URL foto yang berlaku sementara dan harus ditandatangani
    private function _urlFoto($file)
    {
        $exp = time() + self::MASA_BERLAKU_FOTO;

        return site_url('api/dcfoto') . '?' . http_build_query(array(
            'f' => $file,
            'e' => $exp,
            's' => dcfoto_sign($file, $exp),
        ));
    }
}

/* End of file Dcrecap.php */
/* Location: ./application/controllers/api/Dcrecap.php */