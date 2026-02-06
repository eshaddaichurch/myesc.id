<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsendcModel extends CI_Model
{
    // ✅ Tambahkan parameter $iddc untuk support API
    public function get_all($iddc = null)
    {
        // Jika tidak ada parameter, gunakan session (untuk website)
        if ($iddc === null) {
            $iddc = $this->session->userdata('iddc');
        }
        
        $this->db->where('iddc', $iddc);
        $this->db->order_by('tglabsen', 'desc');
        return $this->db->get('dcabsen');
    }

    public function get_by_id($idabsen)
    {
        $this->db->where('idabsen', $idabsen);
        return $this->db->get('dcabsen');
    }

    // ✅ TAMBAH METHOD BARU UNTUK DETAIL ABSENSI
    public function get_detail_absensi($idabsen)
    {
        $this->db->select('
            a.*,
            COUNT(b.idjemaat) as totalpeserta
        ');
        $this->db->from('dcabsen a');
        $this->db->join('dcabsen_detail b', 'a.idabsen = b.idabsen', 'left');
        $this->db->where('a.idabsen', $idabsen);
        $this->db->group_by('a.idabsen');
        return $this->db->get();
    }

    // ✅ TAMBAH METHOD BARU UNTUK DAFTAR PESERTA
    public function get_peserta_absensi($idabsen)
    {
        $this->db->select('
            b.idjemaat,
            j.namalengkap,
            j.foto
        ');
        $this->db->from('dcabsen_detail b');
        $this->db->join('jemaat j', 'b.idjemaat = j.idjemaat', 'left');
        $this->db->where('b.idabsen', $idabsen);
        $this->db->order_by('j.namalengkap', 'ASC');
        return $this->db->get();
    }

    public function simpan($dataHeader, $dataJemaat)
    {
        try {
            $this->db->trans_begin();
            $this->db->insert('dcabsen', $dataHeader);

            $absenHadir = array();
            $idabsen = $this->db->insert_id();
            if (count($dataJemaat) > 0) {
                foreach ($dataJemaat as $value) {
                    $idjemaat = $value;
                    array_push($absenHadir, array(
                        'idabsen' => $idabsen,
                        'idjemaat' => $idjemaat,
                    ));
                }
                $this->db->insert_batch('dcabsen_detail', $absenHadir);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return false;
        }
    }
}