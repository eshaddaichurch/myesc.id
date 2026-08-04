<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_model extends CI_Model
{
    var $column_order = array(null, 'j.namalengkap', 'md.namadokumen', 'jd.tglupload', 'jd.statusdokumen', null);
    var $column_search = array('j.namalengkap', 'md.namadokumen', 'jd.statusdokumen');
    var $order = array('jd.tglupload' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('jd.idjemaat, jd.kodedokumen, j.namalengkap, md.namadokumen, jd.namafile, jd.statusdokumen, jd.catatanreview, jd.tglupload, jd.tglreview');
        $this->db->from('jemaatdokumen jd');
        $this->db->join('jemaat j', 'j.idjemaat = jd.idjemaat');
        $this->db->join('masterdokumen md', 'md.kodedokumen = jd.kodedokumen', 'left');
        $this->db->where('jd.namafile is not null');

        // FITUR BARU: filter jenis dokumen (dropdown "Semua Jenis" / KK / KTP / dst)
        $kodedokumen = isset($_POST['kodedokumen']) ? $_POST['kodedokumen'] : '';
        if (!empty($kodedokumen)) {
            $this->db->where('jd.kodedokumen', $kodedokumen);
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    public function count_all()
    {
        $this->db->where('namafile is not null');
        return $this->db->count_all_results('jemaatdokumen');
    }

    public function count_by_status($status)
    {
        $this->db->where('namafile is not null');
        $this->db->where('statusdokumen', $status);
        return $this->db->count_all_results('jemaatdokumen');
    }

    public function get_by_idjemaat_kodedokumen($idjemaat, $kodedokumen)
    {
        $this->db->select('jd.*, j.namalengkap, j.nik, j.email, j.nohp, md.namadokumen');
        $this->db->from('jemaatdokumen jd');
        $this->db->join('jemaat j', 'j.idjemaat = jd.idjemaat');
        $this->db->join('masterdokumen md', 'md.kodedokumen = jd.kodedokumen', 'left');
        $this->db->where('jd.idjemaat', $idjemaat);
        $this->db->where('jd.kodedokumen', $kodedokumen);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row() : null;
    }

    public function updateStatus($idjemaat, $kodedokumen, $dataUpdate)
    {
        $this->db->where('idjemaat', $idjemaat);
        $this->db->where('kodedokumen', $kodedokumen);
        return $this->db->update('jemaatdokumen', $dataUpdate);
    }

    // Dipakai untuk isi dropdown filter jenis dokumen di halaman listing
    public function getJenisDokumenAktif()
    {
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('urutan', 'asc');
        return $this->db->get('masterdokumen');
    }
}

/* End of file Dokumen_model.php */
/* Location: ./application/models/Dokumen_model.php */
