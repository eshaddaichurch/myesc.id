<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyerahananak_model extends CI_Model
{

    var $tabelview = 'v_carepenyerahananak';
    var $tabel     = 'carepenyerahananak';
    var $idpenyerahananak = 'idpenyerahananak';

    var $column_order = array(null, 'namalengkap', 'namaanak', 'namaayah', 'nohpyangbisadihubungi', 'status', null);
    var $column_search = array('namalengkap', 'namaanak', 'namaayah', 'namaibu', 'nohpyangbisadihubungi', 'status');
    var $order = array('idpenyerahananak' => 'desc'); // default order 


    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->tabelview);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end();
            }
            $i++;
        }

        // -------------------------> Proses Order by        
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered()
    {
        $this->db->select('count(*) as jlh');
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->row()->jlh;
    }

    public function count_all()
    {
        $this->db->select('count(*) as jlh');
        return $this->db->get($this->tabelview)->row()->jlh;
    }

    public function get_all()
    {
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idpenyerahananak)
    {
        $this->db->where('idpenyerahananak', $idpenyerahananak);
        return $this->db->get($this->tabelview);
    }

    public function update($data, $idpenyerahananak)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idpenyerahananak', $idpenyerahananak);
            $this->db->update($this->tabel, $data);

            // Buat Notifikasi 
            $query = $this->db->query("SELECT idjemaat FROM carepenyerahananak WHERE idpenyerahananak = ?", $idpenyerahananak);
            if ($query->num_rows() === 0) {
                throw new Exception("Data permohonan penyerahan anak tidak ditemukan untuk ID: $idpenyerahananak");
            }
            $idjemaatpemohon = $query->row()->idjemaat;
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idpenyerahananak and jenisnotifikasi = 'Penyerahan Anak'
                    and idjemaatpenerima = $idjemaatpemohon
            ");
            $notifikasi = array(
                'tglnotifikasi' => date('Y-m-d H:i:s'),
                'deskripsi' => 'Care telah mengkonfirmasi permohonan penyerahan anak anda.',
                'linknotifikasi' => 'penyerahananak/detail/' . $this->encrypt->encode($idpenyerahananak),
                'idlinknotifikasi' => $idpenyerahananak,
                'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                'jenisnotifikasi' => 'Penyerahan Anak',
                'idjemaatpenerima' => $idjemaatpemohon,
            );                    
            $this->db->insert('notifikasi', $notifikasi);

            if ($this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                $this->db->trans_rollback();
                return ['status' => false, 'message' => 'Database error: ' . $error['code'] . ' - ' . $error['message']];
            } else {
                $this->db->trans_commit();
                return ['status' => true, 'message' => 'Berhasil'];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $th->getMessage()];
        }

        
    }
}



/* End of file Penyerahananak_model.php */
/* Location: ./application/models/Penyerahananak_model.php */