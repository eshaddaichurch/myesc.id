<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruangan_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('ruangan');
    }

    public function get_by_id($idruangan)
    {
        $this->db->where('idruangan', $idruangan);
        return $this->db->get('ruangan');
    }

    public function simpan($data)
    {
        return $this->db->insert('ruangan', $data);
    }

    public function update($data, $idruangan)
    {
        $this->db->where('idruangan', $idruangan);
        return $this->db->update('ruangan', $data);
    }

    public function hapus($idruangan)
    {
        $this->db->where('idruangan', $idruangan);
        return $this->db->delete('ruangan');
    }

    public function get_datatables()
    {
        $this->_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get();
    }

    public function count_filtered()
    {
        $this->_datatables_query();
        return $this->db->get()->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all('ruangan');
    }

    private function _datatables_query()
    {
        $this->db->from('ruangan');
        $search = $_POST['search']['value'];
        if ($search != '') {
            $this->db->group_start();
            $this->db->like('namaruangan', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->or_like('fasilitas', $search);
            $this->db->or_like('statusaktif', $search);
            $this->db->group_end();
        }
        $cols = array('idruangan', 'namaruangan', 'lokasi', 'kapasitas', 'statusaktif');
        if (isset($_POST['order'][0]['column']) && isset($cols[$_POST['order'][0]['column']])) {
            $this->db->order_by($cols[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        }
    }

    // ── BLOKIR RUANGAN ───────────────────────────────────────

    public function getBlokirByRuangan($idruangan)
    {
        $this->db->where('idruangan', $idruangan);
        $this->db->order_by('tanggalblokir', 'desc');
        return $this->db->get('blokir_ruangan');
    }

    public function getBlokirById($idblokir)
    {
        $this->db->where('idblokir', $idblokir);
        return $this->db->get('blokir_ruangan');
    }

    public function simpanBlokir($data)
    {
        return $this->db->insert('blokir_ruangan', $data);
    }

    public function updateBlokir($data, $idblokir)
    {
        $this->db->where('idblokir', $idblokir);
        return $this->db->update('blokir_ruangan', $data);
    }

    public function hapusBlokir($idblokir)
    {
        $this->db->where('idblokir', $idblokir);
        return $this->db->delete('blokir_ruangan');
    }
}
