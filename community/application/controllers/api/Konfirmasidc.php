<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PermohonanModel');
        
        // CORS headers untuk React Native
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }

    /**
     * GET - List semua permohonan
     * URL: /community/api/konfirmasidc
     */
    public function index()
    {
        // Ambil iddc dari session atau header (untuk React Native)
        $iddc = $this->input->get('iddc');
        
        if (!$iddc) {
            echo json_encode([
                'status' => false,
                'message' => 'ID DC tidak ditemukan'
            ]);
            return;
        }

        // Query data permohonan
        $rsPermohonan = $this->PermohonanModel->get_by_iddc($iddc);
        
        $data = [];
        foreach ($rsPermohonan->result() as $row) {
            // Tentukan foto
            $foto = base_url('images/user-01.png');
            if (!empty($row->foto)) {
                $foto = base_url('../admin/uploads/jemaat/' . $row->foto);
            }

            // Tentukan status
            $status = 'pending'; // default
            if ($row->statuskonfirmasi == 'Disetujui') {
                $status = 'approved';
            } elseif ($row->statuskonfirmasi == 'Ditolak') {
                $status = 'rejected';
            }

            $data[] = [
                'idpermohonan' => $row->idpermohonan,
                'idjemaat' => $row->idjemaat,
                'namalengkap' => $row->namalengkap,
                'tglpermohonan' => $row->tglpermohonan,
                'foto' => $foto,
                'jeniskelamin' => $row->jeniskelamin,
                'umur' => $row->umur,
                'statuskonfirmasi' => $row->statuskonfirmasi,
                'status' => $status, // untuk React Native: approved/pending/rejected
                'keterangankonfirmasi' => $row->keterangankonfirmasi,
            ];
        }

        echo json_encode([
            'status' => true,
            'data' => $data,
            'total' => count($data)
        ]);
    }

    /**
     * GET - Detail permohonan by ID
     * URL: /community/api/konfirmasidc/detail?idpermohonan=xxx
     */
    public function detail()
    {
        $idpermohonan = $this->input->get('idpermohonan');
        
        if (!$idpermohonan) {
            echo json_encode([
                'status' => false,
                'message' => 'ID Permohonan tidak ditemukan'
            ]);
            return;
        }

        // Query detail permohonan
        $rsPermohonan = $this->PermohonanModel->get_by_id($idpermohonan);
        
        if ($rsPermohonan->num_rows() == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        $row = $rsPermohonan->row();
        
        // Tentukan foto
        $foto = base_url('images/user-01.png');
        if (!empty($row->foto)) {
            $foto = base_url('../admin/uploads/jemaat/' . $row->foto);
        }

        // Tentukan status
        $status = 'pending';
        if ($row->statuskonfirmasi == 'Disetujui') {
            $status = 'approved';
        } elseif ($row->statuskonfirmasi == 'Ditolak') {
            $status = 'rejected';
        }

        $data = [
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
            'tempatlahir' => $row->tempatlahir,
            'tanggallahir' => $row->tanggallahir,
            'nohp' => $row->nohp,
            'username' => $row->username,
            // tambahkan field lain sesuai kebutuhan
        ];

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * POST - Konfirmasi permohonan (Approve/Reject)
     * URL: /community/api/konfirmasidc/konfirmasi
     */
    public function konfirmasi()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $idpermohonan = $input['idpermohonan'] ?? null;
        $status = $input['status'] ?? null; // 'Disetujui' atau 'Ditolak'
        $keterangankonfirmasi = $input['keterangankonfirmasi'] ?? '';
        
        if (!$idpermohonan || !$status) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        // Validasi status
        if (!in_array($status, ['Disetujui', 'Ditolak'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Status tidak valid'
            ]);
            return;
        }

        // Update status konfirmasi
        $dataUpdate = [
            'statuskonfirmasi' => $status,
            'keterangankonfirmasi' => $keterangankonfirmasi,
            'tanggalupdate' => date('Y-m-d H:i:s')
        ];

        $result = $this->PermohonanModel->update($idpermohonan, $dataUpdate);

        if ($result) {
            echo json_encode([
                'status' => true,
                'message' => 'Konfirmasi berhasil disimpan'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal menyimpan konfirmasi'
            ]);
        }
    }
}