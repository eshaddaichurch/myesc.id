<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Sermon extends BaseApi
{
    const CHANNEL_ID = 'UCRSh1ZxtGNjcILTGl2N_1jg';
    const CACHE_DETIK = 900; // 15 menit
    const MAKS_PLAYLIST = 50;
    const MAKS_VIDEO = 50;
    const NAMA_CACHE = 'sermon_playlist';

    // GET /api/sermon/playlist (publik)
    public function playlist()
    {
        header('Cache-Control: public, max-age=' . self::CACHE_DETIK);

        $cache = $this->_bacaCache(self::NAMA_CACHE);
        if ($cache !== null) {
            $this->jsonSuccess(array('playlist' => $cache));
            return;
        }

        $data = $this->_ambilPlaylist();
        if ($data === null) {
            $lama = $this->_bacaCache(self::NAMA_CACHE, true);
            if ($lama !== null) {
                $this->jsonSuccess(array('playlist' => $lama));
                return;
            }
            $this->jsonError('Daftar sermon belum bisa dimuat. Coba lagi beberapa saat lagi.');
            return;
        }

        $this->_simpanCache(self::NAMA_CACHE, $data);
        $this->jsonSuccess(array('playlist' => $data));
    }

    // GET /api/sermon/video?playlist=PLAYLIST_ID (publik)
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

        $data = $this->_ambilVideo($playlistId);
        if ($data === null) {
            $lama = $this->_bacaCache($nama, true);
            if ($lama !== null) {
                $this->jsonSuccess(array('video' => $lama));
                return;
            }
            $this->jsonError('Daftar video belum bisa dimuat. Coba lagi beberapa saat lagi.');
            return;
        }

        $this->_simpanCache($nama, $data);
        $this->jsonSuccess(array('video' => $data));
    }

    private function _ambilPlaylist()
    {
        $json = $this->_panggilYoutube('playlists', array(
            'part' => 'snippet,contentDetails',
            'channelId' => self::CHANNEL_ID,
            'maxResults' => self::MAKS_PLAYLIST,
        ));
        if ($json === null || !isset($json['items'])) {
            return null;
        }

        $hasil = array();
        foreach ($json['items'] as $item) {
            $snip = isset($item['snippet']) ? $item['snippet'] : array();
            $hasil[] = array(
                'id' => $item['id'],
                'judul' => isset($snip['title']) ? $snip['title'] : '',
                'deskripsi' => isset($snip['description']) ? mb_substr($snip['description'], 0, 140) : '',
                'thumbnail' => $this->_pilihThumbnail($snip),
                'jumlahVideo' => isset($item['contentDetails']['itemCount']) ? (int) $item['contentDetails']['itemCount'] : 0,
                'url' => 'https://www.youtube.com/playlist?list=' . $item['id'],
            );
        }
        return $hasil;
    }

    private function _ambilVideo($playlistId)
    {
        $json = $this->_panggilYoutube('playlistItems', array(
            'part' => 'snippet,contentDetails',
            'playlistId' => $playlistId,
            'maxResults' => self::MAKS_VIDEO,
        ));
        if ($json === null || !isset($json['items'])) {
            return null;
        }

        $hasil = array();
        foreach ($json['items'] as $item) {
            $snip = isset($item['snippet']) ? $item['snippet'] : array();
            $videoId = isset($item['contentDetails']['videoId']) ? $item['contentDetails']['videoId'] : null;
            if ($videoId === null) {
                continue;
            }
            $hasil[] = array(
                'id' => $videoId,
                'judul' => isset($snip['title']) ? $snip['title'] : '',
                'thumbnail' => $this->_pilihThumbnail($snip),
                'tanggal' => isset($snip['publishedAt']) ? $snip['publishedAt'] : '',
                'url' => 'https://www.youtube.com/watch?v=' . $videoId . '&list=' . $playlistId,
            );
        }

        // Terbaru di atas, berdasarkan tanggal publikasi
        usort($hasil, function ($a, $b) {
            return strcmp($b['tanggal'], $a['tanggal']);
        });

        return $hasil;
    }

        private function _panggilYoutube($resource, $params)
    {
        $apiKey = $this->_apiKey();
        if ($apiKey === '') {
            log_message('error', 'Sermon: API key YouTube belum diatur');
            return null;
        }

        $params['key'] = $apiKey;
        $url = 'https://www.googleapis.com/youtube/v3/' . $resource . '?' . http_build_query($params);

        for ($percobaan = 1; $percobaan <= 2; $percobaan++) {
            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 8,
                CURLOPT_TIMEOUT => 20,
            ));
            $response = curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($response !== false && $error === '' && $status === 200) {
                $json = json_decode($response, true);
                return is_array($json) ? $json : null;
            }

            $pesanGoogle = is_string($response) ? substr($response, 0, 300) : '';
            log_message('error', 'Sermon: YouTube gagal (percobaan ' . $percobaan . '), resource=' . $resource . ' status=' . $status . ' body=' . $pesanGoogle);

            // log_message('error', 'Sermon: YouTube gagal (percobaan ' . $percobaan . '), resource=' . $resource . ' status=' . $status . ' err=' . $error);

            // Error selain 5xx/timeout tidak perlu diulang
            if ($status !== 0 && $status < 500) {
                break;
            }
        }

        return null;
    }

    private function _pilihThumbnail($snip)
    {
        foreach (array('high', 'medium', 'default') as $ukuran) {
            if (isset($snip['thumbnails'][$ukuran]['url'])) {
                return $snip['thumbnails'][$ukuran]['url'];
            }
        }
        return null;
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

    private function _simpanCache($nama, $data)
    {
        @file_put_contents($this->_pathCache($nama), json_encode($data), LOCK_EX);
    }
}

/* End of file Sermon.php */
/* Location: ./application/controllers/api/Sermon.php */