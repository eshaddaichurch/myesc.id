<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookingruangan_model extends CI_Model
{
    public function getAllRuangan()
    {
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('namaruangan', 'asc');
        return $this->db->get('ruangan');
    }

    public function getRuanganById($idruangan)
    {
        $this->db->where('idruangan', $idruangan);
        return $this->db->get('ruangan');
    }

    public function cekKonflikJam($idruangan, $tanggal, $jamulai, $jamselesai, $idbooking = '')
    {
        $sql = "
            SELECT COUNT(*) as jumlah
            FROM booking_ruangan
            WHERE idruangan      = ?
              AND tanggalbooking  = ?
              AND status         != 'Dibatalkan'
              AND ?               < jamselesai
              AND ?               > jamulai
        ";
        $params = array($idruangan, $tanggal, $jamulai, $jamselesai);
        if ($idbooking != '') {
            $sql .= ' AND idbooking != ?';
            $params[] = $idbooking;
        }
        return $this->db->query($sql, $params)->row()->jumlah > 0;
    }

    public function getBookingKonflik($idruangan, $tanggal, $jamulai, $jamselesai)
    {
        $sql = "
            SELECT b.*, r.namaruangan, dc.namadc, j.namalengkap AS namapembooking
            FROM   booking_ruangan    b
            JOIN   ruangan            r   ON r.idruangan  = b.idruangan
            JOIN   disciplescommunity dc  ON dc.iddc      = b.iddc
            JOIN   jemaat             j   ON j.idjemaat   = b.idjemaat
            WHERE  b.idruangan      = ?
              AND  b.tanggalbooking  = ?
              AND  b.status         != 'Dibatalkan'
              AND  ?                 < b.jamselesai
              AND  ?                 > b.jamulai
        ";
        return $this->db->query($sql, array($idruangan, $tanggal, $jamulai, $jamselesai));
    }

    public function getRuanganTersedia($tanggal, $jamulai, $jamselesai)
    {
        $sql = "
            SELECT r.*
            FROM   ruangan r
            WHERE  r.statusaktif = 'Aktif'
              AND r.idruangan NOT IN (
                  SELECT idruangan FROM booking_ruangan
                  WHERE  tanggalbooking = ?
                    AND  status        != 'Dibatalkan'
                    AND  ?              < jamselesai
                    AND  ?              > jamulai
              )
              AND r.idruangan NOT IN (
                  SELECT idruangan FROM blokir_ruangan
                  WHERE  tanggalblokir = ?
                    AND  (
                        (jamulai IS NULL AND jamselesai IS NULL)
                        OR (? < jamselesai AND ? > jamulai)
                    )
              )
            ORDER BY r.namaruangan ASC
        ";
        return $this->db->query($sql, array(
            $tanggal, $jamulai, $jamselesai,
            $tanggal, $jamulai, $jamselesai
        ));
    }

    public function getRuanganTerpakai($tanggal, $jamulai, $jamselesai)
    {
        $sql = "
            SELECT
                r.idruangan,    r.namaruangan,  r.kapasitas,
                r.lokasi,       r.fasilitas,    r.foto,
                b.jamulai,      b.jamselesai,   b.keperluan,
                dc.namadc,
                j.namalengkap   AS namapembooking,
                'booking'       AS jenispakai
            FROM   booking_ruangan    b
            JOIN   ruangan            r   ON r.idruangan  = b.idruangan
            JOIN   disciplescommunity dc  ON dc.iddc      = b.iddc
            JOIN   jemaat             j   ON j.idjemaat   = b.idjemaat
            WHERE  b.tanggalbooking = ?
              AND  b.status        != 'Dibatalkan'
              AND  ?                < b.jamselesai
              AND  ?                > b.jamulai

            UNION ALL

            SELECT
                r.idruangan,    r.namaruangan,  r.kapasitas,
                r.lokasi,       r.fasilitas,    r.foto,
                bl.jamulai,     bl.jamselesai,  bl.keterangan AS keperluan,
                'Admin'         AS namadc,
                'Admin'         AS namapembooking,
                'blokir'        AS jenispakai
            FROM   blokir_ruangan bl
            JOIN   ruangan        r   ON r.idruangan = bl.idruangan
            WHERE  bl.tanggalblokir = ?
              AND  (
                  (bl.jamulai IS NULL AND bl.jamselesai IS NULL)
                  OR (? < bl.jamselesai AND ? > bl.jamulai)
              )

            ORDER BY namaruangan ASC, jamulai ASC
        ";
        return $this->db->query($sql, array(
            $tanggal, $jamulai, $jamselesai,
            $tanggal, $jamulai, $jamselesai
        ));
    }

    public function simpanBooking($data)
    {
        return $this->db->insert('booking_ruangan', $data);
    }

    public function batalkanBooking($idbooking, $iddc)
    {
        $this->db->where('idbooking', $idbooking);
        $this->db->where('iddc', $iddc);
        return $this->db->update('booking_ruangan', array(
            'status' => 'Dibatalkan',
            'tanggalupdate' => date('Y-m-d H:i:s'),
        ));
    }

    public function getBookingById($idbooking)
    {
        $this->db->where('idbooking', $idbooking);
        return $this->db->get('v_booking_ruangan');
    }

    public function getRiwayatByDc($iddc, $tglawal = '', $tglakhir = '')
    {
        $this->db->where('iddc', $iddc);
        if ($tglawal != '' && $tglakhir != '') {
            $this->db->where('tanggalbooking >=', $tglawal);
            $this->db->where('tanggalbooking <=', $tglakhir);
        }
        $this->db->order_by('tanggalbooking', 'desc');
        $this->db->order_by('jamulai', 'asc');
        return $this->db->get('v_booking_ruangan');
    }

    public function getJumlahBookingHariIni($iddc, $tanggal)
    {
        $result = $this->db->query("
            SELECT COUNT(*) AS jumlah
            FROM booking_ruangan
            WHERE iddc           = ?
              AND tanggalbooking  = ?
              AND status         != 'Dibatalkan'
        ", array($iddc, $tanggal))->row();
        return $result->jumlah;
    }
}
