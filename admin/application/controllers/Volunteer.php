<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Volunteer extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->islogin();
        $this->load->model('Volunteer_model');
        $this->load->model('Jemaat_model');
        $this->session->set_userdata( 'IDMENUSELECTED', 'M900' );
        $this->cekOtorisasi();
    }

    public function index()
    {
        $data['menu'] = 'volunteer';
        $this->load->view('volunteer/listdata', $data);
    }   

    public function kelompok()
    {
        $filter_iddepartement = $this->input->get('iddepartement');
        $filter_statusaktif   = $this->input->get('statusaktif');

        $data['menu']                  = 'volunteer';
        $data['filter_iddepartement']  = $filter_iddepartement;
        $data['filter_statusaktif']    = $filter_statusaktif;

        $RsData = $this->Volunteer_model->get_grouped($filter_iddepartement, $filter_statusaktif);

        // -------------------------> Susun data flat menjadi bertingkat: Departement > Pelayanan > list jemaat
        $grouped = array();
        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $row) {
                $namadept  = $row->namadepartement;
                $namapely  = !empty($row->namapelayanan) ? $row->namapelayanan : 'Belum Ditentukan';

                if (!isset($grouped[$namadept])) {
                    $grouped[$namadept] = array();
                }
                if (!isset($grouped[$namadept][$namapely])) {
                    $grouped[$namadept][$namapely] = array();
                }
                $grouped[$namadept][$namapely][] = $row;
            }
        }

        $data['grouped'] = $grouped;
        $this->load->view('volunteer/kelompok', $data);
    }

    public function tambah()
    {       
        $data['idvolunteer'] = '';        
        $data['menu'] = 'volunteer';  
        $data['prefill_idjemaat'] = $this->input->get('idjemaat'); // untuk tombol "+ Tambah Pelayanan" dari list
        $this->load->view('volunteer/form', $data);
    }

    public function edit($idvolunteer)
    {       
        $idvolunteer = $this->encrypt->decode($idvolunteer);

        if ($this->Volunteer_model->get_by_id($idvolunteer)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('volunteer');
            exit();
        };
        $data['idvolunteer'] = $idvolunteer;        
        $data['menu'] = 'volunteer';
        $data['prefill_idjemaat'] = '';
        $this->load->view('volunteer/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Volunteer_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<a href="" id="tampilinfojemaat" data-idjemaat="' . $rowdata->idjemaat . '">' . $rowdata->namalengkap . '</a>';

                // -------------------------> Parse detail_pelayanan (GROUP_CONCAT) jadi badge-badge
                // format tiap item: idvolunteer|namadepartement|namapelayanan|statusaktif|kategori , dipisah ';;'
                $badges = '';
                $items = explode(';;', $rowdata->detail_pelayanan);
                foreach ($items as $item) {
                    $pecah = explode('|', $item);
                    if (count($pecah) < 5) continue;

                    $idvol      = $pecah[0];
                    $namadept   = $pecah[1];
                    $namapel    = $pecah[2];
                    $status     = $pecah[3];
                    $kategori   = $pecah[4];

                    $warnabadge = ($status == 'Aktif') ? 'badge-light border' : 'badge-light border text-muted';
                    $labelpel   = ($namapel != '-') ? $namadept . ' - ' . $namapel : $namadept;

                    $labelkategori = ($kategori == 'Major')
                        ? ' <span class="badge badge-primary" style="font-size:9px;">Major</span>'
                        : ' <span class="badge badge-light border" style="font-size:9px;">Minor</span>';

                    $badges .= '<span class="badge '.$warnabadge.' mb-1 mr-1" style="font-weight:normal; font-size:11px;">
                                    '.$labelpel.''.$labelkategori.'
                                    '. ($status != 'Aktif' ? '<i class="fa fa-pause-circle text-secondary ml-1" title="Tidak Aktif"></i>' : '') .'
                                    <a href="'.site_url('volunteer/edit/'.$this->encrypt->encode($idvol)).'" class="ml-1" title="Edit"><i class="fa fa-edit text-warning"></i></a>
                                    <a href="'.site_url('volunteer/delete/'.$this->encrypt->encode($idvol)).'" class="ml-1" id="hapus" title="Hapus"><i class="fa fa-trash text-danger"></i></a>
                                </span> ';
                }
                $row[] = $badges;
                $row[] = '<a href="'.site_url('volunteer/tambah?idjemaat='.$rowdata->idjemaat).'" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i> Pelayanan</a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Volunteer_model->count_all(),
                        "recordsFiltered" => $this->Volunteer_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idvolunteer)
    {
        $idvolunteer = $this->encrypt->decode($idvolunteer);  
        $rsdata = $this->Volunteer_model->get_by_id($idvolunteer);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('volunteer');
            exit();
        };

        $hapus = $this->Volunteer_model->hapus($idvolunteer);
        if ($hapus) {       
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('volunteer');        

    }

    public function simpan()
    {       
        $idvolunteer        = $this->input->post('idvolunteer');
        $idjemaat           = $this->input->post('idjemaat');
        $iddepartement      = $this->input->post('iddepartement');
        $idpelayanan        = $this->input->post('idpelayanan');
        $kategori           = $this->input->post('kategori');
        $statusaktif        = $this->input->post('statusaktif');
        $tanggalbergabung   = $this->input->post('tanggalbergabung');
        $keterangan         = $this->input->post('keterangan');
        $idadmin            = $this->session->userdata('idjemaat');
        $tanggalinsert      = date('Y-m-d H:i:s');

        // -------------------------> Validasi: pelayanan yang dipilih harus benar-benar milik departemen yang dipilih
        // (jaga-jaga kalau JS di-bypass / cascading dropdown gagal load)
        if (!empty($idpelayanan)) {
            $rspelayanan = $this->db->query("SELECT iddepartement FROM pelayanan WHERE idpelayanan='$idpelayanan'")->row();
            if (!$rspelayanan || $rspelayanan->iddepartement != $iddepartement) {
                $pesan = '<div>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <strong>Gagal!</strong> Pelayanan yang dipilih tidak sesuai dengan departemennya!
                            </div>
                        </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('volunteer');
                exit();
            }
        }

        // -------------------------> Cek duplikat kombinasi jemaat + departement + pelayanan
        $cek = $this->Volunteer_model->cek_duplikat($idjemaat, $iddepartement, $idpelayanan);
        $duplikat = false;
        if ($cek->num_rows()>0) {
            foreach ($cek->result() as $rowcek) {
                if ($idvolunteer=='' || $rowcek->idvolunteer != $idvolunteer) {
                    $duplikat = true;
                }
            }
        }

        if ($duplikat) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Jemaat ini sudah terdaftar pada departement dan pelayanan yang sama!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('volunteer');
            exit();
        }

        if ( $idvolunteer=='' ) {  

            $data = array(
                            'idjemaat'          => $idjemaat, 
                            'iddepartement'     => $iddepartement, 
                            'idpelayanan'       => empty($idpelayanan) ? NULL : $idpelayanan, 
                            'kategori'          => $kategori,
                            'statusaktif'       => $statusaktif, 
                            'tanggalbergabung'  => $tanggalbergabung, 
                            'keterangan'        => $keterangan, 
                            'idadmin'           => $idadmin, 
                            'tanggalinsert'     => $tanggalinsert, 
                        );
            $simpan = $this->Volunteer_model->simpan($data);      
        }else{ 

            $data = array(
                            'idjemaat'          => $idjemaat, 
                            'iddepartement'     => $iddepartement, 
                            'idpelayanan'       => empty($idpelayanan) ? NULL : $idpelayanan, 
                            'kategori'          => $kategori,
                            'statusaktif'       => $statusaktif, 
                            'tanggalbergabung'  => $tanggalbergabung, 
                            'keterangan'        => $keterangan, 
                        );
            $simpan = $this->Volunteer_model->update($data, $idvolunteer);
        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : '.$eror['code'].' '.$eror['message'].'
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('volunteer');   
    }
    
    public function get_edit_data()
    {
        $idvolunteer = $this->input->post('idvolunteer');
        $RsData = $this->Volunteer_model->get_by_id($idvolunteer)->row();

        $data = array( 
                            'idvolunteer'       =>  $RsData->idvolunteer,  
                            'idjemaat'          =>  $RsData->idjemaat,  
                            'iddepartement'     =>  $RsData->iddepartement,  
                            'idpelayanan'       =>  $RsData->idpelayanan,  
                            'kategori'          =>  $RsData->kategori,  
                            'statusaktif'       =>  $RsData->statusaktif,  
                            'tanggalbergabung'  =>  $RsData->tanggalbergabung,  
                            'keterangan'        =>  $RsData->keterangan,  
                        );

        echo(json_encode($data));
    }

    /**
     * Endpoint mandiri khusus modul Volunteer, HANYA menampilkan data Kelas & Baptis.
     * Sengaja tidak mengambil data pribadi (alamat, kontak, NIK, dll) supaya aman
     * jika menu Volunteer nanti dibuka aksesnya untuk leader/head departemen,
     * bukan hanya Administrator/Admin Elshaddai.
     */
    public function get_info_jemaat()
    {
        $idjemaat = $this->input->get('idjemaat');

        // -------------------------> Pastikan idjemaat ini memang terdaftar sebagai volunteer
        // (mencegah endpoint ini dipakai untuk intip data jemaat di luar konteks volunteer)
        $cekvolunteer = $this->Volunteer_model->get_by_jemaat($idjemaat);
        if ($cekvolunteer->num_rows() < 1) {
            echo json_encode(array('success' => false, 'msg' => 'Data tidak ditemukan'));
            exit();
        }

        $rowjemaat = $cekvolunteer->row();

        // -------------------------> Riwayat Pelayanan (semua kombinasi departemen+pelayanan orang ini)
        $arrPelayanan = array();
        foreach ($cekvolunteer->result() as $rowpel) {
            array_push($arrPelayanan, array(
                'namadepartement'   => $rowpel->namadepartement,
                'namapelayanan'     => !empty($rowpel->namapelayanan) ? $rowpel->namapelayanan : '-',
                'statusaktif'       => $rowpel->statusaktif,
                'tanggalbergabung'  => !empty($rowpel->tanggalbergabung) ? date('d-m-Y', strtotime($rowpel->tanggalbergabung)) : '-',
            ));
        }

        // -------------------------> Data Kelas
        $rskelas = $this->db->query("
                SELECT kelas.idkelas, kelas.namakelas, kelas.urlsertifikat,
                    registrasikelas.`statuslulus`, tglsertifikat, idregistrasikelas
                    FROM kelas 
                    LEFT JOIN registrasikelas ON registrasikelas.`idkelas`=kelas.`idkelas` and idjemaat='$idjemaat' AND statuslulus=1
                    GROUP BY kelas.idkelas, kelas.namakelas, kelas.urlsertifikat,
                    registrasikelas.`statuslulus`, tglsertifikat, idregistrasikelas
            ");

        // -------------------------> Data Baptis
        $rsBaptisan = $this->db->query("
                    SELECT * FROM v_aktabaptisan WHERE idjemaat = '$idjemaat' ORDER BY tglakta DESC LIMIT 1
            ");
        $arrBaptisan = array();
        if ($rsBaptisan->num_rows() > 0) {
            foreach ($rsBaptisan->result() as $rowBaptisan) {
                array_push($arrBaptisan, array(
                    'idakta' => $rowBaptisan->idakta,
                    'noakta' => $rowBaptisan->noakta,
                    'tglakta' => tglindonesia($rowBaptisan->tglakta),
                    'dilakukanoleh' => $rowBaptisan->dilakukanoleh,
                    'namaayah' => $rowBaptisan->namaayah,
                    'namaibu' => $rowBaptisan->namaibu,
                    'tglbaptis' => tglindonesia($rowBaptisan->tglbaptis),
                    'namagereja' => $rowBaptisan->namagereja,
                    'namagembala' => $rowBaptisan->namagembala,
                    'tempatbaptis' => $rowBaptisan->tempatbaptis,
                    'fileakta' => $rowBaptisan->fileakta,
                    'fileaktalokasi' => base_url('uploads/akta/baptis/' . $rowBaptisan->fileakta),
                ));
            }
        }

        echo json_encode(array(
            'success'       => true,
            'namalengkap'   => $rowjemaat->namalengkap,
            'noaj'          => !empty($rowjemaat->noaj) ? $rowjemaat->noaj : '-',
            'arrPelayanan'  => $arrPelayanan,
            'rskelas'       => $rskelas->result(),
            'arrBaptisan'   => $arrBaptisan,
        ));
    }

}

/* End of file Volunteer.php */
/* Location: ./application/controllers/Volunteer.php */