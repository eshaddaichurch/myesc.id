<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class DcRecap extends BaseApi
{
    // Berapa minggu ke belakang yang ditampilkan
    const JUMLAH_MINGGU = 8;

    // Masa berlaku URL foto (detik). 86400 = 24 jam
    const MASA_BERLAKU_FOTO = 86400;

    // GET /api/dcrecap
    public function index()
    {
        $idjemaat = $this->requireAuth();

        // Hanya jemaat yang tergabung dalam DC yang bisa melihat recap DC-nya
        $member = $this->db->query(
            'SELECT iddc FROM v_dcmember WHERE idjemaat = ? LIMIT 1',
            array($idjemaat)
        )->row();

        if (!$member) {
            $this->jsonSuccess(array('minggu' => array(), 'msg' => 'Anda belum tergabung dalam DC.'));
            return;
        }

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
                'url' => $this->_urlFoto($r->foto),
            );
        }

        $this->jsonSuccess(array('minggu' => array_values($minggu)));
    }

    // URL foto yang hanya berlaku untuk waktu tertentu dan harus ditandatangani
    private function _urlFoto($file)
    {
        $exp = time() + self::MASA_BERLAKU_FOTO;
        $sig = $this->_tandaTangan($file, $exp);

        return 'https://myesc.id/api/dcfoto?' . http_build_query(array(
            'f' => $file,
            'e' => $exp,
            's' => $sig,
        ));
    }

    private function _tandaTangan($file, $exp)
    {
        $secret = getenv('DC_FOTO_SECRET') ?: '';
        return hash_hmac('sha256', $file . '|' . $exp, $secret);
    }
}

/* End of file DcRecap.php */
/* Location: ./application/controllers/api/DcRecap.php */