<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    var $tabelview = 'notifikasi';
    var $tabel     = 'notifikasi';
    var $idnotifikasi = 'idnotifikasi';

    var $column_order = array(null, 'deskripsi', 'tglnotifikasi', null);
    var $column_search = array('deskripsi', 'tglnotifikasi');
    var $order = array('idnotifikasi' => 'desc'); // default order 


    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();        
    }

    private function _get_datatables_query()
    {   
        $tglawal = $_POST['tglawal'];
        $tglakhir = $_POST['tglakhir'];

        $where = " idjemaatpenerima = " . $this->session->userdata('idjemaat') . " and (CONVERT(tglnotifikasi, date) Between '$tglawal' and '$tglakhir') ";        
        $this->db->where($where);

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
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        // -------------------------> Proses Order by        
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
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idnotifikasi)
    {
        $this->db->where('idnotifikasi', $idnotifikasi);
        return $this->db->get($this->tabelview);
    }

}