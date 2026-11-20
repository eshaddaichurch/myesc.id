<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infoterkini_model extends CI_Model
{
    public function getAll()
    {
        $this->db->order_by('urutan', 'asc');
        $this->db->order_by('idinfo', 'desc');
        return $this->db->get('info_terkini');
    }

    public function getById($idinfo)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->get('info_terkini');
    }

    public function simpan($data)
    {
        return $this->db->insert('info_terkini', $data);
    }

    public function update($idinfo, $data)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->update('info_terkini', $data);
    }

    public function hapus($idinfo)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->delete('info_terkini');
    }

    public function setStatus($idinfo, $status)
    {
        $this->db->where('idinfo', (int) $idinfo);
        return $this->db->update('info_terkini', array('statusaktif' => (int) $status));
    }
}