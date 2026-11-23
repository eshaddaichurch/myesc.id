<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Sermon extends BaseApi
{
    const CHANNEL_ID = 'UCRSh1ZxtGNjcILTGl2N_1jg';
    const CACHE_DETIK = 900; // 15 menit
    const MAKS_PLAYLIST = 50;
    const NAMA_CACHE = 'sermon_playlist';

    // GET /api/sermon/playlist (publik, tanpa login)
    public function playlist()
    {
        $this->output->set_content_type('application/json');
        header('Cache-Control: public, max-age=' . self::CACHE_DETIK);

        $cache = $this->_bacaCache();
        if ($cache !== null) {
            $this->jsonSuccess(array('playlist' => $cache));
            return;
        }

        $data = $this->_ambilDariYoutube();
        if ($data === null) {
            // Jika YouTube gagal, pakai cache lama bila ada
            $lama = $this->_bacaCache(true);
            if ($lama !== null) {
                $this->jsonSuccess(array('playlist' => $lama));
                return;
            }
            $this->jsonError('Daftar sermon belum bisa dimuat. Coba lagi beberapa saat lagi.');
            return;
        }

        $this->_simpanCache($data);
        $this->jsonSuccess(array('playlist' => $data));
    }

    private function _ambilDariYoutube()
    {
        $apiKey = $this->_apiKey();
        if ($apiKey === '') {
            log_message('error', 'Sermon: YOUTUBE_API_KEY belum diatur');
            return null;
        }

        $url = 'https://www.googleapis.com/youtube/v3/playlists?' . http_build_query(array(
            'part' => 'snippet,contentDetails',
            'channelId' => self::CHANNEL_ID,
            'maxResults' => self::MAKS_PLAYLIST,
            'key' => $apiKey,
        ));

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
        ));
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false || $error !== '' || $status !== 200) {
            log_message('error', 'Sermon: YouTube gagal, status=' . $status . ' err=' . $error);
            return null;
        }

        $json = json_decode($response, true);
        if (!is_array($json) || !isset($json['items'])) {
            log_message('error', 'Sermon: respons YouTube tidak valid');
            return null;
        }

        $hasil = array();
        foreach ($json['items'] as $item) {
            $snip = isset($item['snippet']) ? $item['snippet'] : array();
            $thumb = isset($snip['thumbnails']['medium']['url'])
                ? $snip['thumbnails']['medium']['url']
                : (isset($snip['thumbnails']['default']['url']) ? $snip['thumbnails']['default']['url'] : null);

            $hasil[] = array(
                'id' => $item['id'],
                'judul' => isset($snip['title']) ? $snip['title'] : '',
                'deskripsi' => isset($snip['description']) ? mb_substr($snip['description'], 0, 140) : '',
                'thumbnail' => $thumb,
                'jumlahVideo' => isset($item['contentDetails']['itemCount']) ? (int) $item['contentDetails']['itemCount'] : 0,
                'url' => 'https://www.youtube.com/playlist?list=' . $item['id'],
            );
        }

        return $hasil;
    }

    private function _apiKey()
    {
        $env = getenv('YOUTUBE_API_KEY');
        if ($env !== false && $env !== '') {
            return $env;
        }

        $this->config->load('youtube', true);
        $key = $this->config->item('youtube_api_key', 'youtube');
        return is_string($key) ? trim($key) : '';
    }

    private function _pathCache()
    {
        return APPPATH . 'cache/' . self::NAMA_CACHE . '.json';
    }

    private function _bacaCache($abaikanMasaBerlaku = false)
    {
        $path = $this->_pathCache();
        if (!is_file($path)) {
            return null;
        }
        if (!$abaikanMasaBerlaku && (time() - filemtime($path)) > self::CACHE_DETIK) {
            return null;
        }
        $isi = json_decode((string) file_get_contents($path), true);
        return is_array($isi) ? $isi : null;
    }

    private function _simpanCache($data)
    {
        @file_put_contents($this->_pathCache(), json_encode($data), LOCK_EX);
    }
}

/* End of file Sermon.php */
/* Location: ./application/controllers/api/Sermon.php */