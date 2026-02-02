<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Konfirmasidc_model');
    }

    /**
     * LIST PERMOHONAN BY DC
     * /api/konfirmasidc?iddc=DGX01
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

        $data = $this->db
            ->where('iddc', $iddc)
            ->order_by('tglpermohonan', 'DESC')
            ->get('v_dcmember_permohonan')
            ->result();

        // Format data untuk React Native
        $formatted = [];
        foreach ($data as $row) {
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

    /**
     * DETAIL PERMOHONAN
     * /api/konfirmasidc/detail?idpermohonan=DGX0100001
     */
    public function detail()
    {
        $idpermohonan = $this->input->get('idpermohonan');

        if (!$idpermohonan) {
            echo json_encode([
                'status' => false,
                'message' => 'idpermohonan wajib diisi'
            ]);
            return;
        }

        $data = $this->db
            ->where('idpermohonan', $idpermohonan)
            ->get('v_dcmember_permohonan')
            ->row();

        if (!$data) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        // Tentukan foto
        $foto = base_url('images/user-01.png');
        if (!empty($data->foto)) {
            $foto = base_url('../admin/uploads/jemaat/' . $data->foto);
        }

        // Tentukan status
        $status = 'pending';
        if ($data->statuskonfirmasi == 'Disetujui') {
            $status = 'approved';
        } elseif ($data->statuskonfirmasi == 'Ditolak') {
            $status = 'rejected';
        }

        $formatted = [
            'idpermohonan' => $data->idpermohonan,
            'idjemaat' => $data->idjemaat,
            'namalengkap' => $data->namalengkap,
            'tglpermohonan' => $data->tglpermohonan,
            'foto' => $foto,
            'jeniskelamin' => $data->jeniskelamin,
            'umur' => $data->umur,
            'statuskonfirmasi' => $data->statuskonfirmasi,
            'status' => $status,
            'keterangankonfirmasi' => $data->keterangankonfirmasi,
            'tempatlahir' => $data->tempatlahir,
            'tanggallahir' => $data->tanggallahir,
            'nohp' => $data->nohp,
            'username' => $data->username,
            'iddc' => $data->iddc,
            'namadc' => $data->namadc,
        ];

        echo json_encode([
            'status' => true,
            'data'   => $formatted
        ]);
    }

    /**
     * KONFIRMASI PERMOHONAN (APPROVE/REJECT)
     * POST /api/konfirmasidc/konfirmasi
     * Body: {
     *     "idpermohonan": "DGX0100001",
     *     "idjemaat": "2401170016",
     *     "status": "approve" atau "reject",
     *     "alasan": "alasan ditolak (opsional)"
     * }
     */
    public function konfirmasi()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $idpermohonan = $input['idpermohonan'] ?? null;
        $idjemaat = $input['idjemaat'] ?? null;
        $status = $input['status'] ?? null;
        $alasan = $input['alasan'] ?? '';

        if (!$idpermohonan || !$idjemaat || !$status) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        if (!in_array($status, ['approve', 'reject'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Status tidak valid'
            ]);
            return;
        }

        // Get detail permohonan
        $rsPermohonan = $this->Konfirmasidc_model->getPermohonanID($idpermohonan);
        if ($rsPermohonan->num_rows() == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Permohonan tidak ditemukan'
            ]);
            return;
        }
        $rowPermohonan = $rsPermohonan->row();

        // Proses konfirmasi
        if ($status == 'approve') {
            $result = $this->Konfirmasidc_model->setuju($idjemaat, $idpermohonan, $rowPermohonan);
            $message = $result ? 'Permohonan berhasil disetujui' : 'Gagal menyetujui permohonan';
        } else {
            $result = $this->Konfirmasidc_model->tolak($idpermohonan, $alasan);
            $message = $result ? 'Permohonan berhasil ditolak' : 'Gagal menolak permohonan';
        }

        echo json_encode([
            'status' => $result,
            'message' => $message
        ]);
    }
}