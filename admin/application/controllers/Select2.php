<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select2 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function searchJemaat()
    {
        $search = $this->input->get('q'); // Ambil keyword pencarian
        $results = [];

        // Jika ada input pencarian, gunakan LIKE, jika tidak, ambil semua
        $this->db->select('idjemaat, namalengkap, jeniskelamin, statuspernikahan');
        $this->db->from('jemaat');
        // $this->db->where_not_in('statusjemaat', ['Meninggal', 'Pindah']);
        
        if (!empty($search)) {
            $this->db->like('namalengkap', $search);
        }
        
        $this->db->order_by('namalengkap');
        $this->db->limit(50);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $results[] = [ // tambahkan ke array dengan []
                'id' => $row->idjemaat, // harus 'id' untuk Select2
                'text' => $row->namalengkap,
                'jeniskelamin' => $row->jeniskelamin,
                'statuspernikahan' => $row->statuspernikahan,
            ];
        }
        
        // Set header dan output JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['results' => $results]));
    }
}