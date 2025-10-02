<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konseling_model extends CI_Model
{

    var $tabelview = 'v_carekonseling';
    var $tabel     = 'carekonseling';
    var $idcarekonseling = 'idcarekonseling';

    var $column_order = array(null, 'namalengkap', 'tglpermohonan', 'email', 'nohp', 'status', null);
    var $column_search = array('namalengkap', 'tglpermohonan', 'email', 'nohp', 'status');
    var $order = array('idcarekonseling' => 'desc'); // default order 


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

    public function get_by_id($idcarekonseling)
    {
        $this->db->where('idcarekonseling', $idcarekonseling);
        return $this->db->get($this->tabelview);
    }

    public function update($data, $idcarekonseling)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idcarekonseling', $idcarekonseling);
            $this->db->update($this->tabel, $data);

            // Cek apakah update berhasil
            if ($this->db->affected_rows() === 0) {
                // Tidak ada baris yang diupdate — mungkin ID tidak ditemukan
                throw new Exception("Data dengan ID $idcarekonseling tidak ditemukan.");
            }


            // Buat Notifikasi 
            $query = $this->db->query("SELECT idjemaat FROM carekonseling WHERE idcarekonseling = ?", $idcarekonseling);
            if ($query->num_rows() === 0) {
                throw new Exception("Data konseling tidak ditemukan untuk ID: $idcarekonseling");
            }
            $idjemaatpemohon = $query->row()->idjemaat;
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idcarekonseling and jenisnotifikasi = 'Konseling'
                    and idjemaatpenerima = $idjemaatpemohon
            ");
            $notifikasi = array(
                'tglnotifikasi' => date('Y-m-d H:i:s'),
                'deskripsi' => 'Care telah mengkonfirmasi konseling anda.',
                'linknotifikasi' => 'konseling/detail/' . $this->encrypt->encode($idcarekonseling),
                'idlinknotifikasi' => $idcarekonseling,
                'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                'jenisnotifikasi' => 'Konseling',
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



/* End of file Konseling_model.php */
/* Location: ./application/models/Konseling_model.php */