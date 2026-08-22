<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller ini KHUSUS untuk diakses aplikasi luar (Laravel absensi),
 * BUKAN untuk dipakai browser/session admin. Makanya sengaja tidak
 * extends MY_Controller (biar tidak kena cek login/session admin).
 * Proteksinya pakai API key di header.
 */
class Api_laravel_pcs extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->config->load('api');
        header('Content-Type: application/json');
        $this->cekApiKey();
    }

    private function cekApiKey()
    {
        // -------------------------> Ambil API key dari header "X-API-KEY"
        $key = $this->input->get_request_header('X-API-KEY', TRUE);

        if (empty($key) || $key !== $this->config->item('api_key')) {
            http_response_code(401);
            echo json_encode(array(
                'success' => false,
                'message' => 'Unauthorized: API key salah atau tidak dikirim'
            ));
            exit();
        }
    }

    /**
     * Endpoint UTAMA yang paling praktis dipakai Laravel.
     * Tinggal lempar hasil scan QR code mentah-mentah ke sini,
     * langsung dapat identitas + semua data volunteer orang itu.
     *
     * GET /admin/api/scan/2310310025-0000142
     * GET /admin/api/scan/2310310025            (untuk yang belum jadi Jemaat)
     */
    public function scan($qrstring = null)
    {
        if (empty($qrstring)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'Kode QR kosong'));
            exit();
        }

        // -------------------------> idjemaat selalu bagian SEBELUM tanda strip pertama
        // (kalau statusnya Simpatisan/Umum, memang tidak ada strip sama sekali, aman)
        $parts = explode('-', $qrstring);
        $idjemaat = $parts[0];

        $rowjemaat = $this->db->query(
            "SELECT idjemaat, namalengkap, foto, statusjemaat, noaj, jeniskelamin FROM jemaat WHERE idjemaat = ?",
            array($idjemaat)
        )->row();

        if (!$rowjemaat) {
            http_response_code(404);
            echo json_encode(array('success' => false, 'message' => 'QR tidak dikenali, jemaat tidak ditemukan'));
            exit();
        }

        $rsvolunteer = $this->db->query(
            "SELECT jv.iddepartement, d.namadepartement, d.idgroup, g.namagroup,
                    jv.idpelayanan, p.namapelayanan, jv.statusaktif, jv.tanggalbergabung
             FROM jemaatvolunteer jv
             JOIN departement d ON jv.iddepartement = d.iddepartement
             JOIN `group` g ON d.idgroup = g.idgroup
             LEFT JOIN pelayanan p ON jv.idpelayanan = p.idpelayanan
             WHERE jv.idjemaat = ? AND jv.statusaktif = 'Aktif'",
            array($idjemaat)
        )->result();

        echo json_encode(array(
            'success' => true,
            'data' => array(
                'idjemaat'     => $rowjemaat->idjemaat,
                'namalengkap'  => $rowjemaat->namalengkap,
                'foto_url'     => !empty($rowjemaat->foto) ? base_url('admin/uploads/jemaat/' . $rowjemaat->foto) : null,
                'statusjemaat' => $rowjemaat->statusjemaat,
                'noaj'         => !empty($rowjemaat->noaj) ? $rowjemaat->noaj : null,
                'jeniskelamin' => $rowjemaat->jeniskelamin,
                'volunteer'    => $rsvolunteer, // array kosong kalau bukan volunteer, bukan error
            )
        ));
    }

    /**
     * Endpoint identitas saja (tanpa data volunteer), kalau Laravel cuma butuh ini.
     * GET /admin/api/jemaat/2310310025
     */
    public function jemaat($idjemaat = null)
    {
        if (empty($idjemaat)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'idjemaat wajib diisi'));
            exit();
        }

        $row = $this->db->query(
            "SELECT idjemaat, namalengkap, foto, statusjemaat, noaj, jeniskelamin FROM jemaat WHERE idjemaat = ?",
            array($idjemaat)
        )->row();

        if (!$row) {
            http_response_code(404);
            echo json_encode(array('success' => false, 'message' => 'Jemaat tidak ditemukan'));
            exit();
        }

        echo json_encode(array(
            'success' => true,
            'data' => array(
                'idjemaat'     => $row->idjemaat,
                'namalengkap'  => $row->namalengkap,
                'foto_url'     => !empty($row->foto) ? base_url('admin/uploads/jemaat/' . $row->foto) : null,
                'statusjemaat' => $row->statusjemaat,
                'noaj'         => !empty($row->noaj) ? $row->noaj : null,
                'jeniskelamin' => $row->jeniskelamin,
            )
        ));
    }

    /**
     * Endpoint data volunteer saja.
     * GET /admin/api/volunteer/2310310025
     */
    public function volunteer($idjemaat = null)
    {
        if (empty($idjemaat)) {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'idjemaat wajib diisi'));
            exit();
        }

        $rows = $this->db->query(
            "SELECT jv.iddepartement, d.namadepartement, d.idgroup, g.namagroup,
                    jv.idpelayanan, p.namapelayanan, jv.statusaktif, jv.tanggalbergabung
             FROM jemaatvolunteer jv
             JOIN departement d ON jv.iddepartement = d.iddepartement
             JOIN `group` g ON d.idgroup = g.idgroup
             LEFT JOIN pelayanan p ON jv.idpelayanan = p.idpelayanan
             WHERE jv.idjemaat = ?",
            array($idjemaat)
        )->result();

        echo json_encode(array('success' => true, 'data' => $rows));
    }

    /**
     * Endpoint BARU: list semua jemaat (Umum/Simpatisan/Jemaat) sekaligus,
     * dipakai Laravel untuk SYNC/IMPORT massal ke database absensi.
     * Jadi bukan lookup satu-satu kayak /scan, tapi ambil banyak orang
     * sekaligus biar admin di Laravel bisa milih siapa aja yang boleh absen.
     *
     * GET /admin/api/laravel_pcs/list_jemaat
     * GET /admin/api/laravel_pcs/list_jemaat?page=2&limit=200
     * GET /admin/api/laravel_pcs/list_jemaat?status=Jemaat   (filter opsional)
     *
     * Response dibikin dengan pagination karena kalau jumlah jemaat sudah
     * ribuan, ambil semua sekaligus tanpa limit bisa berat/timeout di kedua
     * sisi (server CI3 maupun Laravel yang narik datanya).
     */
    public function list_jemaat()
    {
        $limit  = (int) $this->input->get('limit');
        $page   = (int) $this->input->get('page');
        $status = $this->input->get('status'); // opsional: Jemaat / Simpatisan / Umum

        if ($limit <= 0) $limit = 100;
        if ($limit > 500) $limit = 500; // -------------------------> jaga-jaga biar tidak ada yang narik 1 request buat semua data
        if ($page <= 0) $page = 1;
        $offset = ($page - 1) * $limit;

        // -------------------------> dipisah jadi closure biar where-clause-nya
        // konsisten dipakai ulang buat query count & query data (CI3 query
        // builder ke-reset otomatis tiap kali dieksekusi/get())
        $applyFilter = function () use ($status) {
            $this->db->from('jemaat');
            if (!empty($status)) {
                $this->db->where('statusjemaat', $status);
            }
        };

        $applyFilter();
        $total = $this->db->count_all_results();

        $applyFilter();
        $this->db->select('idjemaat, namalengkap, foto, statusjemaat, noaj, jeniskelamin');
        $this->db->order_by('idjemaat', 'ASC');
        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result();

        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idjemaat'     => $row->idjemaat,
                'namalengkap'  => $row->namalengkap,
                'foto_url'     => !empty($row->foto) ? base_url('admin/uploads/jemaat/' . $row->foto) : null,
                'statusjemaat' => $row->statusjemaat,
                'noaj'         => !empty($row->noaj) ? $row->noaj : null,
                'jeniskelamin' => $row->jeniskelamin,
            );
        }

        echo json_encode(array(
            'success' => true,
            'meta' => array(
                'page'        => $page,
                'limit'       => $limit,
                'total'       => (int) $total,
                'total_pages' => (int) ceil($total / $limit),
            ),
            'data' => $data,
        ));
    }

    /**
     * Endpoint BARU: list jemaat yang BERSTATUS VOLUNTEER SAJA
     * (punya baris di tabel jemaatvolunteer), lengkap dengan info
     * Grup/Departemen/Pelayanan-nya.
     *
     * Ini yang dipakai Laravel pas admin BIKIN EVENT, buat nampilin daftar
     * kandidat "siapa aja yang boleh absen di event ini" — bukan semua
     * jemaat kayak /list_jemaat, tapi cuma yang emang volunteer.
     *
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer?page=1&limit=100
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer?iddepartement=3
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer?idgroup=2
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer?idpelayanan=5
     * GET /admin/api/laravel_pcs/list_jemaat_volunteer?statusaktif=semua
     *   (default cuma yang statusaktif = 'Aktif' di jemaatvolunteer;
     *    kirim statusaktif=semua kalau mau ikutan yang nonaktif juga)
     */
    public function list_jemaat_volunteer()
    {
        $limit        = (int) $this->input->get('limit');
        $page         = (int) $this->input->get('page');
        $iddepartement = $this->input->get('iddepartement');
        $idgroup       = $this->input->get('idgroup');
        $idpelayanan   = $this->input->get('idpelayanan');
        $statusaktif   = $this->input->get('statusaktif');

        if ($limit <= 0) $limit = 100;
        if ($limit > 500) $limit = 500;
        if ($page <= 0) $page = 1;
        $offset = ($page - 1) * $limit;

        // -------------------------> susun WHERE dinamis, tapi tetap pakai
        // placeholder (?) biar aman dari SQL injection
        $conditions = array();
        $params = array();

        if ($statusaktif !== 'semua') {
            $conditions[] = "jv.statusaktif = 'Aktif'";
        }
        if (!empty($iddepartement)) {
            $conditions[] = "jv.iddepartement = ?";
            $params[] = $iddepartement;
        }
        if (!empty($idpelayanan)) {
            $conditions[] = "jv.idpelayanan = ?";
            $params[] = $idpelayanan;
        }
        if (!empty($idgroup)) {
            $conditions[] = "d.idgroup = ?";
            $params[] = $idgroup;
        }

        $whereSql = !empty($conditions) ? ('WHERE ' . implode(' AND ', $conditions)) : '';

        // -------------------------> hitung total dulu (DISTINCT idjemaat,
        // soalnya 1 orang bisa punya lebih dari 1 baris volunteer)
        $total = $this->db->query(
            "SELECT COUNT(DISTINCT jemaat.idjemaat) AS total
             FROM jemaat
             JOIN jemaatvolunteer jv ON jv.idjemaat = jemaat.idjemaat
             JOIN departement d ON jv.iddepartement = d.iddepartement
             $whereSql",
            $params
        )->row()->total;

        // -------------------------> ambil daftar jemaat-nya (identitas doang dulu)
        $rows = $this->db->query(
            "SELECT DISTINCT jemaat.idjemaat, jemaat.namalengkap, jemaat.foto,
                    jemaat.statusjemaat, jemaat.noaj, jemaat.jeniskelamin
             FROM jemaat
             JOIN jemaatvolunteer jv ON jv.idjemaat = jemaat.idjemaat
             JOIN departement d ON jv.iddepartement = d.iddepartement
             $whereSql
             ORDER BY jemaat.idjemaat ASC
             LIMIT $limit OFFSET $offset",
            $params
        )->result();

        $data = array();
        $idjemaatDiHalamanIni = array();
        foreach ($rows as $row) {
            $idjemaatDiHalamanIni[] = $row->idjemaat;
            $data[$row->idjemaat] = array(
                'idjemaat'     => $row->idjemaat,
                'namalengkap'  => $row->namalengkap,
                'foto_url'     => !empty($row->foto) ? base_url('admin/uploads/jemaat/' . $row->foto) : null,
                'statusjemaat' => $row->statusjemaat,
                'noaj'         => !empty($row->noaj) ? $row->noaj : null,
                'jeniskelamin' => $row->jeniskelamin,
                'volunteer'    => array(),
            );
        }

        // -------------------------> ambil detail volunteer (Grup/Departemen/
        // Pelayanan) HANYA untuk idjemaat yang ada di halaman ini, sekali
        // query aja (biar tidak N+1 query per orang)
        if (!empty($idjemaatDiHalamanIni)) {
            $inPlaceholder = implode(',', array_fill(0, count($idjemaatDiHalamanIni), '?'));
            $volParams = $idjemaatDiHalamanIni;
            $volConditions = array("jv.idjemaat IN ($inPlaceholder)");

            if ($statusaktif !== 'semua') {
                $volConditions[] = "jv.statusaktif = 'Aktif'";
            }

            $volWhereSql = 'WHERE ' . implode(' AND ', $volConditions);

            $rsvolunteer = $this->db->query(
                "SELECT jv.idjemaat, jv.iddepartement, d.namadepartement, d.idgroup, g.namagroup,
                        jv.idpelayanan, p.namapelayanan, jv.statusaktif, jv.tanggalbergabung
                 FROM jemaatvolunteer jv
                 JOIN departement d ON jv.iddepartement = d.iddepartement
                 JOIN `group` g ON d.idgroup = g.idgroup
                 LEFT JOIN pelayanan p ON jv.idpelayanan = p.idpelayanan
                 $volWhereSql",
                $volParams
            )->result();

            foreach ($rsvolunteer as $v) {
                if (isset($data[$v->idjemaat])) {
                    $data[$v->idjemaat]['volunteer'][] = array(
                        'iddepartement'   => $v->iddepartement,
                        'namadepartement' => $v->namadepartement,
                        'idgroup'         => $v->idgroup,
                        'namagroup'       => $v->namagroup,
                        'idpelayanan'     => $v->idpelayanan,
                        'namapelayanan'   => $v->namapelayanan,
                        'statusaktif'     => $v->statusaktif,
                        'tanggalbergabung'=> $v->tanggalbergabung,
                    );
                }
            }
        }

        echo json_encode(array(
            'success' => true,
            'meta' => array(
                'page'        => $page,
                'limit'       => $limit,
                'total'       => (int) $total,
                'total_pages' => (int) ceil($total / $limit),
            ),
            'data' => array_values($data), // -------------------------> balikin jadi array biasa, bukan object ber-key idjemaat
        ));
    }

}

/* End of file Api_laravel_pcs.php */
/* Location: ./application/controllers/Api/Api_laravel_pcs.php */