<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Dc extends BaseApi
{
    const KOLOM_DC = 'iddc, namadc, namadm, alamatdc, haridc, jamdc, kategoridc, fotodm, idkabupaten, idkecamatan';

    // GET /api/dc/list?idkategoridc=&idkabupaten=&idkecamatan=&cari=&carinamadm=
    public function list()
    {
        $this->db->select(self::KOLOM_DC);
        $this->db->from('v_disciplescommunity');
        $this->db->where('statusaktif', 'Aktif');

        $idkategoridc = trim((string) $this->input->get('idkategoridc', true));
        $idkabupaten  = trim((string) $this->input->get('idkabupaten', true));
        $idkecamatan  = trim((string) $this->input->get('idkecamatan', true));
        $cari         = trim((string) $this->input->get('cari', true));
        $carinamadm   = trim((string) $this->input->get('carinamadm', true));

        if ($idkategoridc !== '') {
            $this->db->where('kategoridc', $idkategoridc);
        }
        if ($idkabupaten !== '') {
            $this->db->where('idkabupaten', $idkabupaten);
        }
        if ($idkecamatan !== '') {
            $this->db->where('idkecamatan', $idkecamatan);
        }
        if ($cari !== '') {
            $this->db->like('namadc', $cari);
        }
        if ($carinamadm !== '') {
            $this->db->like('namadm', $carinamadm);
        }

        $rows = $this->db->get()->result();

        $dc = array();
        foreach ($rows as $row) {
            $dc[] = $this->_formatDc($row);
        }

        $this->jsonSuccess(array('dc' => $dc));
    }

    // GET /api/dc/detail/{iddc}
    public function detail($iddc = '')
    {
        $iddc = trim((string) $iddc);
        $row = $iddc === '' ? null : $this->_ambilDc($iddc);

        if (!$row) {
            $this->jsonError('DC tidak ditemukan.');
            return;
        }

        $this->jsonSuccess(array('dc' => $this->_formatDc($row)));
    }

    // GET /api/dc/saya — status DC jemaat yang login (wajib token)
    public function saya()
    {
        $idjemaat = $this->requireAuth();
        $verifikasi = $this->_sudahVerifikasiWa($idjemaat);

        $aktif = $this->db->query("
            SELECT * FROM v_dcmember WHERE idjemaat = ? AND statusaktif = 'Aktif' LIMIT 1
        ", array($idjemaat))->row();

        if ($aktif) {
            $this->jsonSuccess(array(
                'status' => 'aktif',
                'statusverifikasiwa' => $verifikasi,
                'dc' => array(
                    'iddc' => isset($aktif->iddc) ? $aktif->iddc : null,
                    'namadc' => $aktif->namadc,
                ),
            ));
            return;
        }

        $menunggu = $this->_permohonanMenunggu($idjemaat);
        if ($menunggu) {
            $this->jsonSuccess(array(
                'status' => 'menunggu',
                'statusverifikasiwa' => $verifikasi,
                'dc' => array('iddc' => $menunggu->iddc),
            ));
            return;
        }

        $this->jsonSuccess(array(
            'status' => 'belum',
            'statusverifikasiwa' => $verifikasi,
        ));
    }

    // POST /api/dc/gabung — body: iddc, keterangan (opsional) — wajib token
    public function gabung()
    {
        $idjemaat = $this->requireAuth();
        $iddc = trim((string) $this->input->post('iddc', true));
        $keterangan = trim((string) $this->input->post('keterangan', true));

        if ($iddc === '') {
            $this->jsonError('DC tidak valid.');
            return;
        }

        $rowDc = $this->_ambilDc($iddc);
        if (!$rowDc) {
            $this->jsonError('DC tidak ditemukan.');
            return;
        }

        // Dicek di server, bukan hanya di aplikasi
        if (!$this->_sudahVerifikasiWa($idjemaat)) {
            $this->jsonError('Silakan verifikasi nomor WhatsApp anda terlebih dahulu.');
            return;
        }

        if ($this->_permohonanMenunggu($idjemaat)) {
            $this->jsonError('Permohonan anda sebelumnya masih dalam progres konfirmasi. Harap tunggu sampai permohonan anda sebelumnya dikonfirmasi!');
            return;
        }

        $cekDC = $this->db->query("
            SELECT namadc FROM v_dcmember WHERE idjemaat = ? AND statusaktif = 'Aktif' LIMIT 1
        ", array($idjemaat))->row();

        if ($cekDC) {
            $this->jsonError('Anda sudah tergabung dengan dc ' . $cekDC->namadc . '.');
            return;
        }

        $simpan = $this->db->insert('dcmember_permohonan', array(
            'tglpermohonan' => date('Y-m-d H:i:s'),
            'iddc' => $iddc,
            'idjemaat' => $idjemaat,
            'keterangan' => $keterangan !== '' ? $keterangan : null,
            'statuskonfirmasi' => 'Menunggu Konfirmasi',
        ));

        if (!$simpan) {
            $this->jsonError('Permohonan gagal disimpan.');
            return;
        }

        $rowJemaat = $this->db->query(
            'SELECT namalengkap, nohp FROM jemaat WHERE idjemaat = ?',
            array($idjemaat)
        )->row();

        $this->_kirimNotifikasiPendaftaran($rowDc, $rowJemaat);

        $this->jsonSuccess(array(
            'msg' => 'Permohonan berhasil dikirim. Tim kami akan segera menghubungi Anda.',
        ));
    }

    // ============================================================
    // Helper
    // ============================================================

    private function _ambilDc($iddc)
    {
        return $this->db->select(self::KOLOM_DC)
            ->from('v_disciplescommunity')
            ->where('iddc', $iddc)
            ->where('statusaktif', 'Aktif')
            ->get()
            ->row();
    }

    private function _permohonanMenunggu($idjemaat)
    {
        return $this->db->query("
            SELECT iddc FROM dcmember_permohonan
            WHERE idjemaat = ? AND statuskonfirmasi = 'Menunggu Konfirmasi'
            LIMIT 1
        ", array($idjemaat))->row();
    }

    private function _sudahVerifikasiWa($idjemaat)
    {
        $row = $this->db->query(
            'SELECT statusverifikasiwa FROM jemaat WHERE idjemaat = ?',
            array($idjemaat)
        )->row();

        return $row ? !empty($row->statusverifikasiwa) : false;
    }

    private function _formatDc($row)
    {
        // Sama seperti halaman web: foto DM, atau gambar default jika kosong
        $fotourl = !empty($row->fotodm)
            ? base_url('myesc.id/admin/uploads/jemaat/' . $row->fotodm)
            : base_url('myesc.id/images/bg-dc.png');

        return array(
            'iddc' => $row->iddc,
            'namadc' => $row->namadc,
            'namadm' => $row->namadm,
            'alamatdc' => $row->alamatdc,
            'haridc' => $row->haridc,
            'jamdc' => $row->jamdc,
            'kategoridc' => $row->kategoridc,
            'fotodm' => $row->fotodm,
            'fotourl' => $fotourl,
            'idkabupaten' => $row->idkabupaten,
            'idkecamatan' => $row->idkecamatan,
        );
    }

    private function _kirimNotifikasiPendaftaran($rowDc, $rowJemaat)
    {
        $tgl = date('Y-m-d H:i:s');
        $namaJemaat = $rowJemaat ? ucwords(strtolower($rowJemaat->namalengkap)) : '';

        try {
            if ($rowJemaat) {
                $pesanWA = "Shalom {$namaJemaat}! Terima kasih telah mendaftar sebagai bagian dari *{$rowDc->namadc}* pada tanggal {$tgl}.\n"
                    . "Kami sangat menghargai setiap langkah iman yang Saudara ambil untuk bertumbuh dan dimuridkan.\n"
                    . "Saat ini data pendaftaran Saudara sudah kami terima.\n"
                    . "*Tim kami akan segera menghubungi Saudara melalui WhatsApp* untuk informasi dan langkah selanjutnya.\n"
                    . "Tuhan Yesus memberkati";
                $this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);
            }

            $pesanDM = "Shalom DM " . ucwords(strtolower($rowDc->namadm)) . ",\n"
                . "Ada *pendaftaran DCM baru atas nama {$namaJemaat}* yang menunggu untuk ditindaklanjuti.\n"
                . "Mohon segera melakukan pengecekan dan approval melalui Aplikasi MyDC+, agar proses pemuridan dapat berjalan tepat waktu.\n"
                . "Terima kasih atas kesediaan dan kesetiaan DM dalam melayani.\n"
                . "Tuhan memberkati";
            $this->whatsapp->send_message(formatNomorWhatsapp($rowDc->nohpdm), $pesanDM);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal kirim WA pendaftaran DC: ' . $e->getMessage());
        }

        try {
            $this->_kirimPushNotifikasi(
                $rowDc->iddc,
                'Permohonan Bergabung Baru 🔔',
                $namaJemaat . ' ingin bergabung di ' . $rowDc->namadc
            );
        } catch (\Throwable $e) {
            log_message('error', 'Gagal kirim push pendaftaran DC: ' . $e->getMessage());
        }
    }

    private function _kirimPushNotifikasi($iddc, $judul, $pesan)
    {
        $rsToken = $this->db->where('iddc', $iddc)->get('push_tokens')->row();

        if (!$rsToken || empty($rsToken->token)) {
            return;
        }

        // Harus array of object
        $data = array(array(
            'to' => $rsToken->token,
            'title' => $judul,
            'body' => $pesan,
            'sound' => 'default',
            'data' => array('iddc' => $iddc),
        ));

        $ch = curl_init('https://exp.host/--/api/v2/push/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Accept-Encoding: gzip, deflate',
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}

/* End of file Dc.php */
/* Location: ./application/controllers/api/Dc.php */