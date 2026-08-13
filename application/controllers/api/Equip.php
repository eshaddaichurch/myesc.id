<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/BaseApi.php';

class Equip extends BaseApi
{
    public function list()
    {
        $idjemaat = $this->requireAuth();

        $rsKelas = $this->db->query('
            SELECT kelas.idkelas, kelas.namakelas, kelas.kelas_slug, kelas.urlsertifikat,
                registrasikelas.statuslulus, tglsertifikat, idregistrasikelas
            FROM kelas 
            LEFT JOIN registrasikelas ON registrasikelas.idkelas = kelas.idkelas 
                AND idjemaat = ? AND statuslulus = 1
            GROUP BY kelas.idkelas, kelas.namakelas, kelas.kelas_slug, kelas.urlsertifikat,
                registrasikelas.statuslulus, tglsertifikat, idregistrasikelas
        ', array($idjemaat));

        $kelasArr = array();
        foreach ($rsKelas->result() as $row) {
            $kelasArr[] = array(
                'idkelas' => $row->idkelas,
                'namakelas' => $row->namakelas,
                'kelas_slug' => $row->kelas_slug,
                'sudahlulus' => !empty($row->statuslulus),
                'tglsertifikat' => $row->tglsertifikat,
                'idregistrasikelas' => $row->idregistrasikelas,
            );
        }

        $this->jsonSuccess(array('kelas' => $kelasArr));
    }
}

/* End of file Equip.php */
/* Location: ./application/controllers/api/Equip.php */
