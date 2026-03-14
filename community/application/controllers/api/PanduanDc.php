<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanduanDc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function index()
    {
        $data = $this
            ->db
            ->where('jenisshared', 'DC DM/CT')
            ->where('status', 'Publish')
            ->order_by('idshared', 'DESC')
            ->limit(20)
            ->get('sharedfiles')
            ->result();

        $result = [];

        foreach ($data as $row) {
            $result[] = [
                'id' => $row->idshared,
                'judul' => $row->title,
                'tanggal' => $row->tglpublish,
                'url' => 'https://myesc.id/myesc.id/admin/uploads/sharedfiles/resumedc/' . $row->fileshared,
            ];
        }

        echo json_encode([
            'status' => true,
            'total' => count($result),
            'data' => $result
        ]);
    }
}
