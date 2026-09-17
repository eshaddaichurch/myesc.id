<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Volunteer_model extends CI_Model {

	var $tabelview = 'v_jemaatvolunteer';
    var $tabel     = 'jemaatvolunteer';
    var $idvolunteer = 'idvolunteer';

    var $column_order = array(null, 'namalengkap', null, null);
    var $column_search = array('namalengkap', 'namadepartement', 'namapelayanan', 'idjemaat');
    var $order = array('namalengkap' => 'asc'); // default order


    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();        
    }

    private function _get_datatables_query()
    {   
        // -------------------------> Select dengan GROUP_CONCAT: 1 baris per jemaat,
        // semua kombinasi departemen+pelayanan dirangkum jadi 1 string dipisah ';;'
        // format tiap item: idvolunteer|namadepartement|namapelayanan|statusaktif|kategori
        $this->db->select("
            idjemaat, 
            namalengkap,
            GROUP_CONCAT(DISTINCT CONCAT_WS('|', idvolunteer, namadepartement, IFNULL(namapelayanan,'-'), statusaktif, kategori) SEPARATOR ';;') as detail_pelayanan,
            MIN(tanggalbergabung) as tanggalbergabung_pertama,
            COUNT(*) as jml_pelayanan
        ", false);
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
        
        // -------------------------> Proses Filter Departement / Pelayanan / Status
        if(!empty($_POST['filter_iddepartement'])){
            $this->db->where('iddepartement', $_POST['filter_iddepartement']);
        }
        if(!empty($_POST['filter_idpelayanan'])){
            $this->db->where('idpelayanan', $_POST['filter_idpelayanan']);
        }
        if(!empty($_POST['filter_statusaktif'])){
            $this->db->where('statusaktif', $_POST['filter_statusaktif']);
        }

        $this->db->group_by('idjemaat, namalengkap');

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
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->select('COUNT(DISTINCT idjemaat) as jlh');
        return $this->db->get($this->tabelview)->row()->jlh;
    }

    public function get_all()
    {
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idvolunteer)
    {
        $this->db->where('idvolunteer', $idvolunteer);
        return $this->db->get($this->tabelview);
    }

    public function get_by_jemaat($idjemaat)
    {
        $this->db->where('idjemaat', $idjemaat);
        $this->db->order_by('namadepartement', 'asc');
        return $this->db->get($this->tabelview);
    }

    public function get_grouped($iddepartement = null, $statusaktif = null)
    {
        $this->db->select('*');
        $this->db->from($this->tabelview);
        if (!empty($iddepartement)) {
            $this->db->where('iddepartement', $iddepartement);
        }
        if (!empty($statusaktif)) {
            $this->db->where('statusaktif', $statusaktif);
        }
        $this->db->order_by('namadepartement', 'asc');
        $this->db->order_by('namapelayanan', 'asc');
        $this->db->order_by('namalengkap', 'asc');
        return $this->db->get();
    }

    public function cek_duplikat($idjemaat, $iddepartement, $idpelayanan)
    {
        $this->db->where('idjemaat', $idjemaat);
        $this->db->where('iddepartement', $iddepartement);
        if (empty($idpelayanan)) {
            $this->db->where('idpelayanan IS NULL');
        }else{
            $this->db->where('idpelayanan', $idpelayanan);
        }
        return $this->db->get($this->tabel);
    }

    public function hapus($idvolunteer)
    {
        $this->db->where('idvolunteer', $idvolunteer);      
        return $this->db->delete($this->tabel);
    }

    public function simpan($data)
    {       
        return $this->db->insert($this->tabel, $data);
    }

    public function update($data, $idvolunteer)
    {
        $this->db->where('idvolunteer', $idvolunteer);
        return $this->db->update($this->tabel, $data);
    }	

        // -------------------------> Dipakai untuk cetak PDF laporan volunteer
    // Beda dari get_datatables(): tidak dipaginasi, dan ambil nohp langsung dari tabel jemaat
    public function get_all_for_print($iddepartement = null, $idpelayanan = null, $statusaktif = null)
    {
        $sql = "
            SELECT 
                j.idjemaat,
                j.namalengkap,
                j.nohp,
                GROUP_CONCAT(DISTINCT CONCAT_WS('|', d.namadepartement, IFNULL(p.namapelayanan,'-'), jv.kategori, jv.statusaktif) ORDER BY d.namadepartement, p.namapelayanan SEPARATOR ';;') as detail_pelayanan,
                MIN(jv.tanggalbergabung) as tanggalbergabung_pertama
            FROM jemaatvolunteer jv
            JOIN jemaat j ON jv.idjemaat = j.idjemaat
            JOIN departement d ON jv.iddepartement = d.iddepartement
            LEFT JOIN pelayanan p ON jv.idpelayanan = p.idpelayanan
            WHERE 1=1
        ";

        if (!empty($iddepartement)) {
            $sql .= " AND jv.iddepartement = " . $this->db->escape($iddepartement);
        }
        if (!empty($idpelayanan)) {
            $sql .= " AND jv.idpelayanan = " . $this->db->escape($idpelayanan);
        }
        if (!empty($statusaktif)) {
            $sql .= " AND jv.statusaktif = " . $this->db->escape($statusaktif);
        }

        $sql .= " GROUP BY j.idjemaat, j.namalengkap, j.nohp ORDER BY j.namalengkap ASC";

        return $this->db->query($sql);
    }

}

/* End of file Volunteer_model.php */
/* Location: ./application/models/Volunteer_model.php */