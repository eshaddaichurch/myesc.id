<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Sermon extends BaseApi
{
    const CACHE_DETIK = 21600; // 6 jam, cache diperbarui oleh cron sermon_cache.php
    const NAMA_CACHE = 'sermon_playlist';

    // GET /api/sermon/playlist (publik, hanya membaca cache)
    public function playlist()
    {
        header('Cache-Control: public, max-age=' . self::CACHE_DETIK);

        $cache = $this->_bacaCache(self::NAMA_CACHE);
        if ($cache !== null) {
            $this->jsonSuccess(array('playlist' => $cache));
            return;
        }

        // Cache kedaluwarsa: pakai data lama jika ada
        $lama = $this->_bacaCache(self::NAMA_CACHE, true);
        if ($lama !== null) {
            $this->jsonSuccess(array('playlist' => $lama));
            return;
        }

        $this->jsonError('Daftar sermon sedang diperbarui. Coba beberapa saat lagi.');
    }

    // GET /api/sermon/video?playlist=PLAYLIST_ID (publik, hanya membaca cache)
    public function video()
    {
        $playlistId = trim((string) $this->input->get('playlist', true));
        if (!preg_match('/^[A-Za-z0-9_-]{5,64}$/', $playlistId)) {
            $this->jsonError('Playlist tidak valid.');
            return;
        }

        header('Cache-Control: public, max-age=' . self::CACHE_DETIK);

        $nama = 'sermon_video_' . md5($playlistId);
        $cache = $this->_bacaCache($nama);
        if ($cache !== null) {
            $this->jsonSuccess(array('video' => $cache));
            return;
        }

        $lama = $this->_bacaCache($nama, true);
        if ($lama !== null) {
            $this->jsonSuccess(array('video' => $lama));
            return;
        }

        $this->jsonError('Daftar video sedang diperbarui. Coba beberapa saat lagi.');
    }

    private function _pathCache($nama)
    {
        return APPPATH . 'cache/' . $nama . '.json';
    }

    private function _bacaCache($nama, $abaikanMasaBerlaku = false)
    {
        $path = $this->_pathCache($nama);
        if (!is_file($path)) {
            return null;
        }
        if (!$abaikanMasaBerlaku && (time() - filemtime($path)) > self::CACHE_DETIK) {
            return null;
        }
        $isi = json_decode((string) file_get_contents($path), true);
        return is_array($isi) ? $isi : null;
    }
}

/* End of file Sermon.php */
/* Location: ./application/controllers/api/Sermon.php */