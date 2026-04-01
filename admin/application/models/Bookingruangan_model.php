<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookingruangan_model extends CI_Model
{
    public function getAllBooking($tanggal = '', $idruangan = '', $status = '')
    {
        if ($tanggal != '')
            $this->db->where('tanggalbooking', $tanggal);
        if ($idruangan != '')
            $this->db->where('idruangan', $idruangan);
        if ($status != '')
            $this->db->where('status', $status);
        $this->db->order_by('tanggalbooking', 'desc');
        $this->db->order_by('jamulai', 'asc');
        return $this->db->get('v_booking_ruangan');
    }

    public function getStatistikHariIni()
    {
        $today = date('Y-m-d');
        return $this->db->query("
            SELECT
                COUNT(*)                                        AS total,
                SUM(status = 'Disetujui')                      AS aktif,
                SUM(status = 'Selesai')                        AS selesai,
                SUM(status = 'Dibatalkan')                     AS dibatalkan,
                COUNT(DISTINCT idruangan)                      AS ruangan_terpakai,
                (SELECT COUNT(*) FROM ruangan WHERE statusaktif = 'Aktif') AS total_ruangan
            FROM booking_ruangan
            WHERE tanggalbooking = '$today'
        ")->row();
    }

    public function getAllRuangan()
    {
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('namaruangan', 'asc');
        return $this->db->get('ruangan');
    }

    public function batalkanBooking($idbooking)
    {
        $this->db->where('idbooking', $idbooking);
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

    public function autoUpdateSelesai()
    {
        return $this->db->query("
            UPDATE booking_ruangan
            SET    status        = 'Selesai',
                   tanggalupdate = NOW()
            WHERE  status         = 'Disetujui'
              AND  tanggalbooking  = CURDATE()
              AND  jamselesai     <= CURTIME()
        ");
    }
}
