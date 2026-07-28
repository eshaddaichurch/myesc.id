<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jemaatbaru_model extends CI_Model
{
    var $tabelview = 'v_carejemaatbaru';
    var $tabel = 'carejemaatbaru';
    var $idcarejemaatbaru = 'idcarejemaatbaru';
    var $column_order = array(null, 'namajemaat', 'tglinsert', 'email', 'nohp', 'status', null);
    var $column_search = array('namajemaat', 'tglinsert', 'email', 'nohp', 'status');
    var $order = array('idcarejemaatbaru' => 'desc');  // default order

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

        // FITUR BARU: Filter periode tanggal (opsional, dikirim dari frontend)
        // Diterapkan di sini supaya otomatis ikut dipakai oleh get_datatables()
        // dan count_filtered() sekaligus, tanpa perlu duplikasi logic.
        $this->_apply_filter_periode();

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)  // last loop
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

    // FITUR BARU: helper filter periode, dipakai oleh _get_datatables_query()
    // dan get_all_for_pdf() supaya logic filter konsisten di kedua tempat.
    private function _apply_filter_periode()
    {
        $tglMulai = isset($_POST['tgl_mulai']) ? $_POST['tgl_mulai'] : (isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '');
        $tglAkhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : (isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '');

        if (!empty($tglMulai)) {
            $this->db->where('tglinsert >=', $tglMulai . ' 00:00:00');
        }
        if (!empty($tglAkhir)) {
            $this->db->where('tglinsert <=', $tglAkhir . ' 23:59:59');
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

    // FITUR BARU: ambil SEMUA data (tanpa pagination) sesuai filter periode,
    // dipakai untuk cetak PDF. $tglMulai / $tglAkhir bisa dikosongkan (null)
    // untuk cetak semua data tanpa filter.
    public function get_all_for_pdf($tglMulai = null, $tglAkhir = null)
    {
        $this->db->from($this->tabelview);

        if (!empty($tglMulai)) {
            $this->db->where('tglinsert >=', $tglMulai . ' 00:00:00');
        }
        if (!empty($tglAkhir)) {
            $this->db->where('tglinsert <=', $tglAkhir . ' 23:59:59');
        }

        $this->db->order_by('tglinsert', 'asc');
        return $this->db->get();
    }

    public function get_by_id($idcarejemaatbaru)
    {
        $this->db->where('idcarejemaatbaru', $idcarejemaatbaru);
        return $this->db->get($this->tabelview);
    }

    public function update($dataCare, $idcarejemaatbaru)
    {
        $this->db->trans_begin();
        try {
            $idjemaatbaru = $this->db->query("select idjemaat from carejemaatbaru where idcarejemaatbaru=$idcarejemaatbaru ")->row()->idjemaat;

            // $this->db->query("update jemaat set statusjemaat = 'Simpatisan' where idjemaat = '$idjemaatbaru' ");

            $this->db->where('idcarejemaatbaru', $idcarejemaatbaru);
            $this->db->update($this->tabel, $dataCare);

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

/* End of file Jemaatbaru_model.php */
/* Location: ./application/models/Jemaatbaru_model.php */
