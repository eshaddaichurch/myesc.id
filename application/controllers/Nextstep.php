<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nextstep extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Nextstep_model');
	}

	public function kelas($kelas_slug, $idmenu = "")
	{
		$rowKelas = $this->db->query("select * from kelas where kelas_slug is not null and kelas_slug='$kelas_slug' LIMIT 1");

		if ($rowKelas->num_rows() > 0) {
			$rowKelas = $rowKelas->row();
		} else {
			return redirect('nextstep');
		}

		$tglsekarang = date('Y-m-d H:i:00');

		$idkelas = $rowKelas->idkelas;

		switch ($idkelas) {
			case 'KL004':
				$rsJadwal = $this->db->query("select * from v_jadwalevent where jenisjadwal='Kelas Next Step' and idkelas='KL004' and DATE_SUB( tglmulai, INTERVAL 14 DAY ) > '$tglsekarang' and statuskonfirmasi='Disetujui'");
				break;
			default:
				$rsJadwal = $this->db->query("select * from v_jadwalevent where jenisjadwal='Kelas Next Step' and idkelas='$idkelas' and DATE_SUB( tglmulai, INTERVAL 7 DAY ) > '$tglsekarang' and statuskonfirmasi='Disetujui'");
				break;
		}
		


		$idmenu = $this->encrypt->decode($idmenu);
		$data['kelas_slug'] = $kelas_slug;
		$data['menu'] = $idmenu;
		$data['rsJadwal'] = $rsJadwal;
		$data['rowKelas'] = $rowKelas;
		$data["rowinfogereja"] = $this->Home_model->get_infogereja();


		// $this->load->view('nextstep/kelas', $data);

		$slugView = 'nextstep/kelas/' . $kelas_slug;
		if (file_exists(APPPATH . 'views/' . $slugView . '.php')) {
			$this->load->view($slugView, $data);
		} else {
			// Fallback jika file view belum dibuat
			$this->load->view('nextstep/kelas', $data);
		}
	}

	public function cekPersyaratan()
	{

		$idjadwalevent = $this->input->get('idjadwalevent');
		$idjemaat = $this->session->userdata('idjemaat');
		if (empty($idjemaat)) {
			echo json_encode(array('msg' => "Anda harus login terlebih dahulu untuk mendaftar di kelas ini."));
			exit();
		}	


		if ($this->Nextstep_model->sudahPernahDaftar($idjadwalevent, $idjemaat)) {
			echo json_encode(array('msg' => "Anda sudah pernah mendaftar di jadwal kelas ini."));
			exit();
		}

		$rsJadwal = $this->Nextstep_model->getJadwal($idjadwalevent);
		if ($rsJadwal->num_rows()==0) {
			echo json_encode(array('msg' => "Data jadwal tidak ditemukan."));
			exit();
		}

		$rowJadwal = $rsJadwal->row();
		$idkelas = $rowJadwal->idkelas;

		//FC2 DAN FC3
		if ($idkelas=="KL003" || $idkelas=="KL004") {
			if (!$this->App->sudahLulusKelas($idjemaat, 'KL001')) {
				echo json_encode(array('msg' => "Anda harus mengikuti kelas membership terlebih dahulu!"));
				exit();
			}
		}

		//GRADE 1
		if ($idkelas=="KL005") {
			if (!$this->App->sudahLulusKelas($idjemaat, 'KL004')) {
				echo json_encode(array('msg' => "Anda harus mengikuti Foundation Class 3 terlebih dahulu!"));
				exit();
			}			
		}

		//GRADE 2
		if ($idkelas=="KL006") {
			if (!$this->App->sudahLulusKelas($idjemaat, 'KL005')) {
				echo json_encode(array('msg' => "Anda harus mengikuti Grade 1 terlebih dahulu!"));
				exit();
			}
		}

		//GRADE 3
		if ($idkelas=="KL007") {
			if (!$this->App->sudahLulusKelas($idjemaat, 'KL006')) {
				echo json_encode(array('msg' => "Anda harus mengikuti Grade 2 terlebih dahulu!"));
				exit();
			}
		}

		//FOLUNTEER
		if ($idkelas=="KL008") {
			if (!$this->App->sudahLulusKelas($idjemaat, 'KL007')) {
				echo json_encode(array('msg' => "Anda harus mengikuti Grade 3 terlebih dahulu!"));
				exit();
			}
		}

		echo json_encode(array('success' => true));		
	}

	public function daftar()
	{

		$idjadwalevent = $this->input->post('idjadwalevent');
		$idjemaat = $this->session->userdata('idjemaat');
		$tglregistrasi = date('Y-m-d H:i:s');
		$idregistrasi = $this->db->query("SELECT create_idregistrasievent('" . date('Y-m-d') . "') as idregistrasi")->row()->idregistrasi;
		$data = array(
			'idregistrasi' => $idregistrasi,
			'idjadwalevent' => $idjadwalevent,
			'tglregistrasi' => $tglregistrasi,
			'idjemaat' => $idjemaat,
			'statuskonfirmasi' => 'Menunggu',
		);
		// echo json_encode($data);
		// exit();

		$simpan = $this->Nextstep_model->daftar($data);
		if ($simpan) {
			$idkelas = '';
			$kelas_slug = '';
			$rsNextStep = $this->db->query("SELECT jadwalevent.idkelas, kelas.namakelas, kelas.kelas_slug 
													FROM jadwalevent JOIN kelas ON kelas.idkelas=jadwalevent.idkelas 
													where idjadwalevent='$idjadwalevent'");
			$namakelas = 'Kelas';
			if ($rsNextStep->num_rows() > 0) {
				$idkelas = $rsNextStep->row()->idkelas;
				$kelas_slug = $rsNextStep->row()->kelas_slug;
				$namakelas = $this->App->getInfoKelas($idkelas)->namakelas;
			}
						
			$rowJemaat = $this->App->getInfoJemaat($idjemaat);            
			$pesanWA = "Shalom " . ucwords(strtolower($rowJemaat->namalengkap))  . "! Pengajuan pendaftaran $namakelas anda telah kami terima. Akan segera kami konfirmasi 1x24 jam. Terimakasih.!
			\n ID Registrasi: $idregistrasi
			\n Tgl Registrasi: $tglregistrasi";			
			$this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);                			

			echo json_encode(array('success' => true, 'kelas_slug' => $kelas_slug, 'menu' => '-'));
		} else {
			echo json_encode(array('msg' => "Gagal registrasi kelas"));
		}
	}


	public function index($idmenu = null)
	{
		$data['title'] = 'NEXTSTEP';
		if ($idmenu !== null) {
			$idmenu-- > $this->encrypt->decode($idmenu);
			$data['menu'] = $idmenu;
		} else {
			$data['menu'] = 'NEXTSTEP';
		}
		$data["rowinfogereja"] = $this->Home_model->get_infogereja();
		$this->load->view('nextstep/aboutnextstep', $data);
	}
}

/* End of file Nextstep.php */
/* Location: ./application/controllers/Nextstep.php */