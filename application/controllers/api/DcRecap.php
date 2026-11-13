<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class DcRecap extends BaseApi
{
    // Foto absensi disimpan di aplikasi DC (community)
    const BASE_FOTO = 'https://dc.myesc.id/uploads/absensi/';

    // Jumlah minggu ke belakang yang ditampilkan
    const JUMLAH_MINGGU = 8;

    // GET /api/dcrecap
    public function index()
    {
        $idjemaat = $this->requireAuth();

        $member = $this->db->query(
            'SELECT iddc FROM v_dcmember WHERE idjemaat = ? LIMIT 1',
            array($idjemaat)
        )->row();

        if (!$member) {
            $this->jsonSuccess(array('minggu' => array(), 'msg' => 'Anda belum tergabung dalam DC.'));
            return;
        }

        // Dicast ke integer agar aman dimasukkan ke query
        $jumlahMinggu = (int) self::JUMLAH_MINGGU;

        $rows = $this->db->query(
            "SELECT idabsen, tglabsen, keterangan, foto
             FROM dcabsen
             WHERE iddc = ?
               AND foto IS NOT NULL AND foto <> ''
               AND tglabsen >= DATE_SUB(CURDATE(), INTERVAL {$jumlahMinggu} WEEK)
             ORDER BY tglabsen DESC",
            array($member->iddc)
        )->result();

        // Kelompokkan per minggu ISO (Senin sampai Minggu)
        $minggu = array();
        foreach ($rows as $r) {
            $ts = strtotime($r->tglabsen);
            if ($ts === false) {
                continue;
            }

            $kunci = date('o-W', $ts);
            if (!isset($minggu[$kunci])) {
                $senin = $ts - (((int) date('N', $ts)) - 1) * 86400;
                $minggu[$kunci] = array(
                    'kunci' => $kunci,
                    'mulai' => date('Y-m-d', $senin),
                    'selesai' => date('Y-m-d', $senin + 6 * 86400),
                    'foto' => array(),
                );
            }

            $minggu[$kunci]['foto'][] = array(
                'idabsen' => $r->idabsen,
                'tglabsen' => $r->tglabsen,
                'keterangan' => $r->keterangan,
                'url' => self::BASE_FOTO . rawurlencode($r->foto),
            );
        }

        // Urutan dari minggu terbaru
        $this->jsonSuccess(array('minggu' => array_values($minggu)));
    }
}

/* End of file DcRecap.php */
/* Location: ./application/controllers/api/DcRecap.php */