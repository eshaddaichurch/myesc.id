<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kalender extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Kalender_model');
		$this->load->model('Nextstep_model');
	}

	// ============================================================
	// HELPER: hitung bulan sebelum & berikut dengan benar
	// ============================================================
	private function _hitungNavBulan($bulanEvent, $tahunEvent)
	{
		$bulanSebelum = $bulanEvent - 1;
		$tahunSebelum = $tahunEvent;
		$bulanBerikut = $bulanEvent + 1;
		$tahunBerikut = $tahunEvent;

		if ($bulanEvent == 1) {
			$bulanSebelum = 12;
			$tahunSebelum = $tahunEvent - 1;
		}
		if ($bulanEvent == 12) {
			$bulanBerikut = 1;
			$tahunBerikut = $tahunEvent + 1;
		}

		return [$bulanSebelum, $tahunSebelum, $bulanBerikut, $tahunBerikut];
	}

	// ============================================================
	// index() — tampilkan bulan ini
	// ============================================================
	public function index($idmenu)
	{
		$bulanEvent = (int) date('m');
		$tahunEvent = (int) date('Y');
		$idmenu = $this->encrypt->decode($idmenu);

		// FIX: pakai ->result_array() lalu convert ke object,
		//      atau simpan langsung sebagai array of object
		$query = $this->db->query("
      SELECT * FROM v_jadwaleventdetailtanggal_2
      WHERE MONTH(tgljadwal) = $bulanEvent
        AND YEAR(tgljadwal)  = $tahunEvent
        AND statuskonfirmasi = 'Disetujui'
      ORDER BY tgljadwal, jammulai
    ");

		// Konversi ke array biasa agar tidak habis saat di-loop
		$rsEvent = $query->result();  // array of stdClass — aman di-loop berkali-kali

		list($bulanSebelum, $tahunSebelum, $bulanBerikut, $tahunBerikut) =
			$this->_hitungNavBulan($bulanEvent, $tahunEvent);

		$data['rowinfogereja'] = $this->Home_model->get_infogereja();
		$data['rsEvent'] = $rsEvent;  // <-- array of object, BUKAN CI result object
		$data['bulanEvent'] = $bulanEvent;
		$data['tahunEvent'] = $tahunEvent;
		$data['bulanSebelum'] = $bulanSebelum;
		$data['tahunSebelum'] = $tahunSebelum;
		$data['bulanBerikut'] = $bulanBerikut;
		$data['tahunBerikut'] = $tahunBerikut;
		$data['menu'] = $idmenu;

		$this->load->view('kalender/index', $data);
	}

	// ============================================================
	// lihatbulan() — navigasi bulan
	// ============================================================
	public function lihatbulan($bulanEvent, $tahunEvent, $idmenu)
	{
		$bulanEvent = (int) $bulanEvent;
		$tahunEvent = (int) $tahunEvent;
		$idmenu = $this->encrypt->decode($idmenu);

		$query = $this->db->query("
      SELECT * FROM v_jadwaleventdetailtanggal_2
      WHERE MONTH(tgljadwal) = $bulanEvent
        AND YEAR(tgljadwal)  = $tahunEvent
        AND statuskonfirmasi = 'Disetujui'
      ORDER BY tgljadwal, jammulai
    ");

		// Konversi ke array biasa
		$rsEvent = $query->result();

		list($bulanSebelum, $tahunSebelum, $bulanBerikut, $tahunBerikut) =
			$this->_hitungNavBulan($bulanEvent, $tahunEvent);

		$data['rowinfogereja'] = $this->Home_model->get_infogereja();
		$data['rsEvent'] = $rsEvent;
		$data['bulanEvent'] = $bulanEvent;
		$data['tahunEvent'] = $tahunEvent;
		$data['bulanSebelum'] = $bulanSebelum;
		$data['tahunSebelum'] = $tahunSebelum;
		$data['bulanBerikut'] = $bulanBerikut;
		$data['tahunBerikut'] = $tahunBerikut;
		$data['menu'] = $idmenu;

		$this->load->view('kalender/index', $data);
	}

	// ============================================================
	// getEvent() — API JSON untuk keperluan lain
	// ============================================================
	public function getEvent()
	{
		$query = $this->db->query("
      SELECT * FROM v_jadwaleventdetailtanggal_2
      WHERE statuskonfirmasi  = 'Disetujui'
        AND tampilkandiwebsite = 'Ya'
      ORDER BY tgljadwal, jammulai
    ");
		echo json_encode($query->result());
	}
}

/* End of file Kalender.php */
/* Location: ./application/controllers/Kalender.php */
