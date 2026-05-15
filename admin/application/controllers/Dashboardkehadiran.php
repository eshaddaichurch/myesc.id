<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardkehadiran extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->session->set_userdata('IDMENUSELECTED', 'D001');
        $this->load->model('Dashboardkehadiran_model');
    }

    public function index()
    {
        $data['menu'] = 'dashboardkehadiran';
        $this->load->view('dashboard/kehadiran', $data);
    }

    public function getinfobox()
    {
        $kehadiranbulanini = $this->Dashboardkehadiran_model->kehadiranbulanini();
        $kehadiranbulanlalu = $this->Dashboardkehadiran_model->kehadiranbulanlalu();
        $kenaikanbulanlalu = number_format($this->Dashboardkehadiran_model->kenaikanbulanlalu($kehadiranbulanlalu));
        $kenaikanbulanini = number_format($this->Dashboardkehadiran_model->kenaikanbulanini($kehadiranbulanini, $kehadiranbulanlalu));

        $data = array(
            'kehadiranbulanini' => $kehadiranbulanini,
            'kehadiranbulanlalu' => $kehadiranbulanlalu,
            'kenaikanbulanlalu' => $kenaikanbulanlalu,
            'kenaikanbulanini' => $kenaikanbulanini,
        );
        echo json_encode($data);
    }

    public function getgrafikabsen()
    {
        $idabsenjenis = $this->input->get('idabsenjenis');
        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        $rsAbsen = $this->Dashboardkehadiran_model->getgrafikabsen($idabsenjenis, $tglawal, $tglakhir);

        $datatanggal = array();
        $datatotalhadiribadah = array();
        $datahadiribadah1 = array();
        $datahadiribadah2 = array();
        $datahadiribadah3 = array();
        $datahadiribadah4 = array();
        $datahadiribadah5 = array();

        $jumlah = 0;
        // FIX: $i dimulai dari 0, bukan 1.
        // Sebelumnya $i=1 membuat jumlahPerMinggu selalu dibagi lebih besar 1,
        // dan jumlahi yang dikirim ke view pun salah (selalu +1 dari jumlah data).
        $i = 0;

        if ($rsAbsen->num_rows() > 0) {
            foreach ($rsAbsen->result() as $rowAbsen) {
                $datatanggal[] = date('d-M', strtotime($rowAbsen->tglabsen));
                $datahadiribadah1[] = $rowAbsen->jumlahibadah1;
                $datahadiribadah2[] = $rowAbsen->jumlahibadah2;
                $datahadiribadah3[] = $rowAbsen->jumlahibadah3;
                $datahadiribadah4[] = $rowAbsen->jumlahibadah4;
                $datahadiribadah5[] = $rowAbsen->jumlahibadah5;

                // FIX: tambahkan jumlahibadah5 (sebelumnya tidak dihitung)
                $totalRow = $rowAbsen->jumlahibadah1
                    + $rowAbsen->jumlahibadah2
                    + $rowAbsen->jumlahibadah3
                    + $rowAbsen->jumlahibadah4
                    + $rowAbsen->jumlahibadah5;

                $datatotalhadiribadah[] = $totalRow;
                $jumlah += $totalRow;
                $i++;
            }
        }

        // ===== HITUNG TOTAL PER IBADAH =====
        $totalIbadah1 = array_sum($datahadiribadah1);
        $totalIbadah2 = array_sum($datahadiribadah2);
        $totalIbadah3 = array_sum($datahadiribadah3);
        $totalIbadah4 = array_sum($datahadiribadah4);
        $totalIbadah5 = array_sum($datahadiribadah5);
        $totalSemua = $totalIbadah1 + $totalIbadah2 + $totalIbadah3 + $totalIbadah4 + $totalIbadah5;

        // ===== FORMAT PERIODE UNTUK DISPLAY =====
        $periodeDisplay = '';
        if ($tglawal && $tglakhir) {
            $periodeDisplay = date('d M', strtotime($tglawal)) . ' - ' . date('d M Y', strtotime($tglakhir));
        }

        // Hindari division by zero jika tidak ada data
        $jumlahPerMinggu = ($i > 0) ? number_format($jumlah / $i) : 0;

        $jumlahPerbulan = array();
        $rsAbsenPerbulan = $this->Dashboardkehadiran_model->getgrafikabsenperbulan($idabsenjenis);
        if ($rsAbsenPerbulan->num_rows() > 0) {
            foreach ($rsAbsenPerbulan->result() as $rowAbsen) {
                $jumlahPerbulan[] = array(
                    'jumlah01' => number_format($rowAbsen->jumlah01),
                    'jumlah02' => number_format($rowAbsen->jumlah02),
                    'jumlah03' => number_format($rowAbsen->jumlah03),
                    'jumlah04' => number_format($rowAbsen->jumlah04),
                    'jumlah05' => number_format($rowAbsen->jumlah05),
                    'jumlah06' => number_format($rowAbsen->jumlah06),
                    'jumlah07' => number_format($rowAbsen->jumlah07),
                    'jumlah08' => number_format($rowAbsen->jumlah08),
                    'jumlah09' => number_format($rowAbsen->jumlah09),
                    'jumlah10' => number_format($rowAbsen->jumlah10),
                    'jumlah11' => number_format($rowAbsen->jumlah11),
                    'jumlah12' => number_format($rowAbsen->jumlah12),
                );
            }
        }

        $data = array(
            'datatanggal' => $datatanggal,
            'datahadiribadah1' => $datahadiribadah1,
            'datahadiribadah2' => $datahadiribadah2,
            'datahadiribadah3' => $datahadiribadah3,
            'datahadiribadah4' => $datahadiribadah4,
            'datahadiribadah5' => $datahadiribadah5,
            'datatotalhadiribadah' => $datatotalhadiribadah,
            'jumlahPerMinggu' => $jumlahPerMinggu,
            'jumlahPerbulan' => $jumlahPerbulan,
            'jumlahi' => $i,
            // ===== TAMBAHAN BARU: SCORECARD =====
            'totalIbadah1' => $totalIbadah1,
            'totalIbadah2' => $totalIbadah2,
            'totalIbadah3' => $totalIbadah3,
            'totalIbadah4' => $totalIbadah4,
            'totalIbadah5' => $totalIbadah5,
            'totalSemua' => $totalSemua,
            'periodeDisplay' => $periodeDisplay
        );
        echo json_encode($data);
    }

    public function getescwomengrafik()
    {
        $rsAbsen = $this->Dashboardkehadiran_model->getescwomengrafik();

        $datatanggal = array();
        // FIX: inisialisasi array sebelum dipakai di dalam loop
        $datahadiribadah = array();

        $jumlah = 0;
        // FIX: $i diinisialisasi di luar if agar tidak undefined saat num_rows = 0
        $i = 0;

        if ($rsAbsen->num_rows() > 0) {
            foreach ($rsAbsen->result() as $rowAbsen) {
                $datatanggal[] = date('d-M', strtotime($rowAbsen->tglabsen));
                $datahadiribadah[] = $rowAbsen->jumlahhadir;
                $jumlah += $rowAbsen->jumlahhadir;
                $i++;
            }
        }

        // Hindari division by zero
        $jumlahPerMinggu = ($i > 0) ? $jumlah / $i : 0;

        $data = array(
            'datatanggal' => $datatanggal,
            'datahadiribadah' => $datahadiribadah,
            'jumlahPerMinggu' => $jumlahPerMinggu,
            'jumlahi' => $i,
        );
        echo json_encode($data);
    }

    public function getpersentase()
    {
        $idabsenjenis = $this->input->get('idabsenjenis');
        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        $rsAbsen = $this->Dashboardkehadiran_model->getgrafikabsen($idabsenjenis, $tglawal, $tglakhir);

        $datatanggal = array();
        $datapersentase = array();

        $jumlah_old = 0;
        $totalpersentase = 0;

        // FIX: $i dimulai dari 0. Sebelumnya $i=1 membuat rata-rata
        // persentase selalu dibagi lebih besar 1 dari jumlah data aktual.
        $i = 0;

        if ($rsAbsen->num_rows() > 0) {
            foreach ($rsAbsen->result() as $rowAbsen) {
                $datatanggal[] = date('d-M', strtotime($rowAbsen->tglabsen));

                $jumlah = $rowAbsen->jumlahibadah1
                    + $rowAbsen->jumlahibadah2
                    + $rowAbsen->jumlahibadah3
                    + $rowAbsen->jumlahibadah4
                    + $rowAbsen->jumlahibadah5;

                if ($jumlah_old == 0 || $jumlah == 0) {
                    $persentase = 0;
                } else {
                    $persentase = (($jumlah / $jumlah_old) * 100) - 100;
                }

                $datapersentase[] = $persentase;
                $jumlah_old = $jumlah;
                $totalpersentase += $persentase;
                $i++;
            }
        }

        // Hindari division by zero
        $ratarata = ($i > 0) ? $totalpersentase / $i : 0;

        $data = array(
            'datatanggal' => $datatanggal,
            'datapersentase' => $datapersentase,
            'ratarata' => $ratarata,
        );
        echo json_encode($data);
    }

    public function getgrafikabsenperlokasi()
    {
        $idabsenjenis = $this->input->get('idabsenjenis');
        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        // Query ini sudah terbukti berhasil di screenshot Anda
        $sql = "SELECT 
                    a.idabsenlokasi, 
                    l.namaabsenlokasi, 
                    a.idsesi, 
                    s.namasesi, 
                    SUM(a.jumlahhadir) as totalhadir 
                FROM absen a 
                LEFT JOIN absenlokasi l ON a.idabsenlokasi = l.idabsenlokasi 
                LEFT JOIN sesiibadahminggu s ON a.idsesi = s.idsesi 
                WHERE a.idabsenjenis = ? 
                AND a.tglabsen BETWEEN ? AND ? 
                AND a.idabsenlokasi IS NOT NULL 
                AND a.idabsenlokasi != '' 
                GROUP BY a.idabsenlokasi, l.namaabsenlokasi, a.idsesi, s.namasesi 
                ORDER BY a.idabsenlokasi ASC";

        $query = $this->db->query($sql, array($idabsenjenis, $tglawal, $tglakhir));

        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array(
                    'idlokasi' => $row->idabsenlokasi,
                    'namalokasi' => $row->namaabsenlokasi,
                    'namasesi' => $row->namasesi ? $row->namasesi : 'Tanpa Sesi',
                    'total' => (int) $row->totalhadir
                );
            }
        }

        // Return JSON murni
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

/* End of file Dashboardkehadiran.php */
/* Location: ./application/controllers/Dashboardkehadiran.php */
