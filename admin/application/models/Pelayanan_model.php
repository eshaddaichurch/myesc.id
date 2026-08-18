<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan_model extends CI_Model {

	var $tabelview = 'v_pelayanan';
    var $tabel     = 'pelayanan';
    var $idpelayanan = 'idpelayanan';

    var $column_order = array(null, 'idpelayanan', 'namapelayanan', 'namadepartement', 'statusaktif', null);
    var $column_search = array('idpelayanan', 'namapelayanan', 'namadepartement', 'namagroup');
    var $order = array('namapelayanan' => 'asc');


    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();        
    }

    private function _get_datatables_query()
    {   
        $this->db->from($this->tabelview);
        $i = 0;
        foreach ($this->column_search as $item) 
        {
            if($_POST['search']['value']) 
            {
                if($i===0) {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)){
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
        $this->db->order_by('namapelayanan', 'asc');
        return $this->db->get($this->tabelview);
    }

    public function get_by_departement($iddepartement)
    {
        $this->db->where('iddepartement', $iddepartement);
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('namapelayanan', 'asc');
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idpelayanan)
    {
        $this->db->where('idpelayanan', $idpelayanan);
        return $this->db->get($this->tabelview);
    }

    public function generate_id()
    {
        $rs = $this->db->query("SELECT MAX(CAST(SUBSTRING(idpelayanan, 3) AS UNSIGNED)) as maxid FROM pelayanan WHERE idpelayanan LIKE 'PL%'")->row();
        $next = ($rs->maxid) ? $rs->maxid + 1 : 1;
        return 'PL' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function cek_nama_sudah_ada($namapelayanan, $idpelayanan = '')
    {
        $this->db->where('namapelayanan', $namapelayanan);
        if (!empty($idpelayanan)) {
            $this->db->where('idpelayanan !=', $idpelayanan);
        }
        return $this->db->get($this->tabel);
    }

    public function cek_dipakai($idpelayanan)
    {
        $this->db->where('idpelayanan', $idpelayanan);
        $rsVolunteer = $this->db->get('jemaatvolunteer');

        $this->db->where('idpelayanan', $idpelayanan);
        $rsJadwal = $this->db->get('jadwaleventdetailpelayanan');

        return array(
            'dipakai'      => ($rsVolunteer->num_rows() > 0 || $rsJadwal->num_rows() > 0),
            'jml_volunteer' => $rsVolunteer->num_rows(),
            'jml_jadwal'    => $rsJadwal->num_rows(),
        );
    }

    public function hapus($idpelayanan)
    {
        $this->db->where('idpelayanan', $idpelayanan);      
        return $this->db->delete($this->tabel);
    }

    public function simpan($data)
    {       
        return $this->db->insert($this->tabel, $data);
    }

    public function update($data, $idpelayanan)
    {
        $this->db->where('idpelayanan', $idpelayanan);
        return $this->db->update($this->tabel, $data);
    }	

}

/* End of file Pelayanan_model.php */
/* Location: ./application/models/Pelayanan_model.php */