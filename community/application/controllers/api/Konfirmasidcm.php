<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidcm extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    /**
     * LIST PERMOHONAN BY DC
     * /api/konfirmasidcm?iddc=DGX01
     */
    public function index()
    {
        $iddc = $this->input->get('iddc');

        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'iddc wajib diisi'
            ]);
            return;
        }

        // Query data permohonan (sama seperti di website)
        $data = $this->db
            ->where('iddc', $iddc)
            ->order_by('tglpermohonan', 'DESC')
            ->get('v_dcmember_permohonan')
            ->result();

        // Format data untuk React Native
        $formatted = [];
        foreach ($data as $row) {
            // Foto
            $foto = base_url('images/user-01.png');
            if (!empty($row->foto)) {
                $foto = base_url('../admin/uploads/jemaat/' . $row->foto);
            }

            // Status untuk React Native
            $status = 'pending';
            if ($row->statuskonfirmasi == 'Disetujui') {
                $status = 'approved';
            } elseif ($row->statuskonfirmasi == 'Ditolak') {
                $status = 'rejected';
            }

            $formatted[] = [
                'idpermohonan' => $row->idpermohonan,
                'idjemaat' => $row->idjemaat,
                'namalengkap' => $row->namalengkap,
                'tglpermohonan' => $row->tglpermohonan,
                'foto' => $foto,
                'jeniskelamin' => $row->jeniskelamin,
                'umur' => $row->umur,
                'statuskonfirmasi' => $row->statuskonfirmasi,
                'status' => $status,
                'keterangankonfirmasi' => $row->keterangankonfirmasi,
                'iddc' => $row->iddc,
                'namadc' => $row->namadc,
            ];
        }

        echo json_encode([
            'status' => true,
            'total'  => count($formatted),
            'data'   => $formatted
        ]);
    }
}