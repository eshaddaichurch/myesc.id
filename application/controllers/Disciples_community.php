<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disciples_community extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Disciples_community_model');
	}

	public function index($idmenu = null)
	{
		$data['menu'] = $idmenu;
		$data['rowinfogereja'] = $this->Home_model->get_infogereja();
		$this->load->view('community/dc/esccommunity', $data);
	}

	public function list($idmenu = '')
	{
		$rsDC = $this->db->query("
			select * from v_disciplescommunity where statusaktif = 'Aktif'
		");

		$data['title'] = 'LIST DATA DISCIPLES COMMUNITY';
		$idmenu = $this->encrypt->decode($idmenu);
		$data['menu'] = $idmenu;
		$data['rsDC'] = $rsDC;
		$data['rowinfogereja'] = $this->Home_model->get_infogereja();
		$this->load->view('community/dc/listdata', $data);
	}

	public function getKecamatan()
	{
		$idkabupaten = $this->input->get('idkabupaten');
		$query = $this->db->query("
            select * from kecamatan where idkabupaten='$idkabupaten' order by namakecamatan
        ");
		echo json_encode($query->result());
	}

	public function getListDC()
	{
		$idkategoridc = $this->input->get('idkategoridc', true);
		$idkabupaten = $this->input->get('idkabupaten', true);
		$idkecamatan = $this->input->get('idkecamatan', true);
		$cari = $this->input->get('cari', true);

		// Inisialisasi query builder
		$this->db->select('*');
		$this->db->from('v_disciplescommunity');
		$this->db->where('statusaktif', 'Aktif');

		if (!empty($idkategoridc)) {
			$this->db->where('kategoridc', $idkategoridc);  // BUKAN idkategoridc
		}
		if (!empty($idkabupaten)) {
			$this->db->where('idkabupaten', $idkabupaten);
		}
		if (!empty($idkecamatan)) {
			$this->db->where('idkecamatan', $idkecamatan);
		}
		if (!empty($cari)) {
			$this->db->like('namadc', $cari);
		}

		// Eksekusi query
		$query = $this->db->get();

		$data = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				// array_push($data, array(
				// 	'iddc' => $row->iddc,
				// 	'namadc' => $row->namadc,
				// 	'kategoridc' => $row->kategoridc,
				// 	'alamatdc' => $row->alamatdc,
				// 	'fotodc' => $row->fotodc,
				// 	'iddcEncrypt' => $this->encrypt->encode($row->iddc),
				// ));

				array_push($data, array(
					'iddc' => $row->iddc,
					'namadc' => $row->namadc,
					'namadm' => $row->namadm,  // Tambahkan ini
					'alamatdc' => $row->alamatdc,
					'haridc' => $row->haridc,  // Optional kalau perlu di modal
					'jamdc' => $row->jamdc,  // Optional kalau perlu di modal
					'kategoridc' => $row->kategoridc,
					'fotodm' => $row->fotodm,  // Ini yang benar (bukan fotodc)
					'iddcEncrypt' => $this->encrypt->encode($row->iddc),
				));
			}
		}

		// Kirimkan respons JSON
		echo json_encode([
			'success' => true,
			'data' => $data,
		]);
	}

	public function bergabung($iddc)
	{
		$this->wajibLogin();
		$iddc = $this->encrypt->decode($iddc);
		$idmenu = '';

		$idmenu = $this->encrypt->decode($idmenu);
		// $rowDC = $this->Disciples_community_model->getDC($iddc);

		// $data['rowDC'] = $rowDC->row();
		$data['iddc'] = $iddc;
		$data['menu'] = $idmenu;
		$data['rowinfogereja'] = $this->Home_model->get_infogereja();
		$this->load->view('community/dc/bergabung', $data);
	}

	public function simpanpermohonanbergabung()
	{
		$keteranganpermohonan = $this->input->post('keteranganpermohonan');
		$iddc = $this->input->post('iddc');
		$idjemaat = $this->session->userdata('idjemaat');

		$rsPeriksaPermohonan = $this->db->query("
			select * from dcmember_permohonan where idjemaat = '$idjemaat' and statuskonfirmasi = 'Menunggu Konfirmasi'
		");
		if ($rsPeriksaPermohonan->num_rows() > 0) {
			$pesan = "<script>
                            swal('Upss!', 'Permohonan anda sebelum nya masih dalam progres konfirmasi. Harap tunggu sampai permohonan anda sebelumnya dikonfirmasi!', 'warning');
                        </script>";

			$this->session->set_flashdata('pesan', $pesan);
			redirect('disciples_community/list');
		}

		$cekDC = $this->db->query("
			select * from v_dcmember where idjemaat = '$idjemaat' and statusaktif = 'Aktif'
		");

		if ($cekDC->num_rows() > 0) {
			$pesan = "<script>
                            swal('Upps!', 'Anda sudah tergabung dengan dc " . $cekDC->result()[0]->namadc . ".', 'warning');
                        </script>";
			$this->session->set_flashdata('pesan', $pesan);
			redirect('disciples_community/list');
		}

		$dataPemohon = array(
			'tglpermohonan' => date('Y-m-d H:i:s'),
			'iddc' => $iddc,
			'idjemaat' => $idjemaat,
			'keterangan' => $keteranganpermohonan,
			'statuskonfirmasi' => 'Menunggu Konfirmasi',
		);

		$simpan = $this->Disciples_community_model->simpanpermohonanbergabung($dataPemohon);
		if ($simpan) {
			$pesan = "<script>
                            swal('Berhasil', 'Permohonan berhasil disimpan.', 'success');
                        </script>";
		} else {
			$pesan = "<script>
                            swal('Gagal', 'Permohonan gagal disimpan.', 'warning');
                        </script>";
		}

		$this->session->set_flashdata('pesan', $pesan);
		redirect('disciples_community/list');
	}

	public function ajaxSimpanPermohonan()
	{
		$iddc = $this->input->post('iddc');
		$iddc = $this->encrypt->decode($iddc);
		$idjemaat = $this->session->userdata('idjemaat');

		if (empty($this->session->userdata('idjemaat'))) {
			echo json_encode(array('msg' => 'Silahkan login terlebih dahulu untuk melanjutkan!'));
			exit();
		}

		// Periksa apakah ada permohonan sebelumnya
		$rsPeriksaPermohonan = $this->db->query("
			select * from dcmember_permohonan where idjemaat = '$idjemaat' and statuskonfirmasi = 'Menunggu Konfirmasi'
		");
		if ($rsPeriksaPermohonan->num_rows() > 0) {
			echo json_encode(array('msg' => 'Permohonan anda sebelum nya masih dalam progres konfirmasi. Harap tunggu sampai permohonan anda sebelumnya dikonfirmasi!'));
			exit();
		}

		// Periksa apakah sudah tergabung dalam dc
		$cekDC = $this->db->query("
			select * from v_dcmember where idjemaat = '$idjemaat' and statusaktif = 'Aktif'
		");
		if ($cekDC->num_rows() > 0) {
			echo json_encode(array('msg' => 'Anda sudah tergabung dengan dc ' . $cekDC->result()[0]->namadc . '.'));
			exit();
		}

		$dataPemohon = array(
			'tglpermohonan' => date('Y-m-d H:i:s'),
			'iddc' => $iddc,
			'idjemaat' => $idjemaat,
			'statuskonfirmasi' => 'Menunggu Konfirmasi',
		);

		$simpan = $this->Disciples_community_model->simpanpermohonanbergabung($dataPemohon);
		if ($simpan) {
			// Kirim Whatsapp Ke Jemaat
			$rowDc = $this->Disciples_community_model->getDC($iddc)->row();

			$rowJemaat = $this->App->getInfoJemaat($idjemaat);
			$pesanWA = 'Shalom ' . ucwords(strtolower($rowJemaat->namalengkap)) . '! Terima kasih telah mendaftar sebagai bagian dari *' . $rowDc->namadc . '* pada tanggal ' . date('Y-m-d H:i:s') . '.
Kami sangat menghargai setiap langkah iman yang Saudara ambil untuk bertumbuh dan dimuridkan.
Saat ini data pendaftaran Saudara sudah kami terima.
*Tim kami akan segera menghubungi Saudara melalui WhatsApp* untuk informasi dan langkah selanjutnya. 
Tuhan Yesus memberkati';
			$this->whatsapp->send_message(formatNomorWhatsapp($rowJemaat->nohp), $pesanWA);

			$pesanWADM = 'Shalom DM ' . ucwords(strtolower($rowDc->namadm)) . ',
Ada *pendaftaran DCM baru atas nama ' . ucwords(strtolower($rowJemaat->namalengkap)) . '* yang menunggu untuk ditindaklanjuti.
Mohon segera melakukan pengecekan dan approval melalui *Website https://dc.myesc.id*, agar proses pemuridan dapat berjalan tepat waktu.
Terima kasih atas kesediaan dan kesetiaan DM dalam melayani dan membangun murid Kristus.
Tuhan memberkati pelayanan Saudara';
			$this->whatsapp->send_message(formatNomorWhatsapp($rowDc->nohpdm), $pesanWADM);

			// ✅ TAMBAHKAN DI SINI - Kirim Push Notification ke DM
			$this->_kirimPushNotifikasi(
				$rowDc->iddc,
				'Permohonan Bergabung Baru 🔔',
				ucwords(strtolower($rowJemaat->namalengkap)) . ' ingin bergabung di ' . $rowDc->namadc
			);

			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('msg' => 'Permohonan gagal disimpan.'));
		}
	}

	private function _kirimPushNotifikasi($iddc, $judul, $pesan)
	{
		// Ambil token dari database
		$rsToken = $this
			->db
			->where('iddc', $iddc)
			->get('push_tokens')
			->row();

		if (!$rsToken || empty($rsToken->token)) {
			return;  // Tidak ada token, skip
		}

		$token = $rsToken->token;

		// Kirim ke Expo Push Notification Service
		$data = [
			'to' => $token,
			'title' => $judul,
			'body' => $pesan,
			'sound' => 'default',
			'data' => ['iddc' => $iddc],
		];

		$ch = curl_init('https://exp.host/--/api/v2/push/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Accept: application/json',
		]);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	public function getInformasiDC()
	{
		$iddc = $this->input->get('iddc');
		$dataDC = $this->Disciples_community_model->getDC($iddc);
		$iddcEncrypt = $this->encrypt->encode($iddc);
		if ($dataDC) {
			echo json_encode(['status' => 'success', 'data' => $dataDC->result(), 'iddcEncrypt' => $iddcEncrypt]);
		} else {
			echo json_encode(['status' => 'fail']);
		}
	}
}

/* End of file Disciples_community.php */
/* Location: ./application/controllers/Disciples_community.php */
