<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infoterkini_model extends CI_Model
{
    private $tabel = 'info_terkini';

    // Urutan kolom DataTables. null = tidak bisa diurutkan (No, Gambar, Aksi)
    private $column_order = array(null, null, 'judul', 'urutan', 'statusaktif', null);

    // Kolom yang ikut dicari
    private $column_search = array('judul', 'subjudul', 'urltombol');

    public function getById($idinfo)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->get($this->tabel);
    }

    public function simpan($data)
    {
        return $this->db->insert($this->tabel, $data);
    }

    public function update($idinfo, $data)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->update($this->tabel, $data);
    }

    public function hapus($idinfo)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->delete($this->tabel);
    }

    public function setStatus($idinfo, $status)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->update($this->tabel, array('statusaktif' => (int) $status));
    }

    // Data untuk DataTables (server-side)
    public function get_datatables($search, $kolomUrut, $arah, $start, $length)
    {
        $this->db->from($this->tabel);
        $this->_filter($search);
        $this->_order($kolomUrut, $arah);
        if ($length != -1) {
            $this->db->limit((int) $length, (int) $start);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($search)
    {
        $this->db->from($this->tabel);
        $this->_filter($search);
        return (int) $this->db->count_all_results();
    }

    public function count_all()
    {
        return (int) $this->db->count_all($this->tabel);
    }

    // Ringkasan untuk kartu statistik
    public function getStatistik()
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS total, COALESCE(SUM(statusaktif = 1), 0) AS aktif
             FROM info_terkini"
        )->row();

        $total = (int) $row->total;
        $aktif = (int) $row->aktif;

        return array(
            'total' => $total,
            'aktif' => $aktif,
            'nonaktif' => $total - $aktif,
        );
    }

    private function _filter($search)
    {
        if ($search === '') {
            return;
        }

        $this->db->group_start();
        foreach ($this->column_search as $i => $kolom) {
            if ($i === 0) {
                $this->db->like($kolom, $search);
            } else {
                $this->db->or_like($kolom, $search);
            }
        }
        $this->db->group_end();
    }

    private function _order($kolomUrut, $arah)
    {
        if ($kolomUrut !== null && isset($this->column_order[$kolomUrut]) && $this->column_order[$kolomUrut] !== null) {
            $this->db->order_by($this->column_order[$kolomUrut], $arah);
        }
        // Urutan bawaan dan penentu urutan yang sama
        $this->db->order_by('urutan', 'asc');
        $this->db->order_by('idinfo', 'desc');
    }
}

/* End of file Infoterkini_model.php */
/* Location: ./application/models/Infoterkini_model.php */