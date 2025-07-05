<?php $this->load->view('template/festavalive/header'); ?>

<body>
    <style>
        .informasi-akun table td {
            font-size: 10px;
            padding: 0px 0px 0px 0px;
        }

        .informasi-akun h5 {
            font-size: 12px;
            color: #655f62;
            font-weight: bold;
        }

        /* Untuk input dan textarea readonly */
        input[readonly],
        textarea[readonly] {
            background-color: #eee;
            color: #666;
            cursor: not-allowed;
            border: 1px solid #ccc;
        }

        /* Untuk select box (dropdown) readonly - tidak ada readonly pada select, jadi gunakan disabled */
        select[disabled] {
            background-color: #eee;
            color: #666;
            cursor: not-allowed;
            border: 1px solid #ccc;
        }

        /* Untuk option dalam select agar tidak bisa dipilih jika parent-nya disabled */
        select[disabled] option {
            background-color: #f9f9f9;
            color: #aaa;
        }

        /* Jika kamu ingin style tambahan saat hover */
        input[readonly]:hover,
        textarea[readonly]:hover,
        select[disabled]:hover {
            background-color: #f5f5f5;
        }
    </style>
    <main>



        <?php $this->load->view('template/festavalive/topmenu'); ?>


        <section class="about-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-12 mb-4 mb-lg-0">
                        <h2 class="text-white text-center mb-4 mt-3">Profil Saya</h2>
                    </div>

                </div>
            </div>
        </section>



        <section class="page-content section-padding">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-12 mb-5 text-center">
                        <h3>Status: <?php echo $rowProfil->statusjemaat; ?></h3>
                    </div>



                    <form action="<?php echo (site_url('akun/simpanJemaat')) ?>" method="post" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" id="cardcontent">
                                    <div class="card-body">

                                        <div class="col-md-12">
                                            <?php
                                            $pesan = $this->session->flashdata("pesan");
                                            if (!empty($pesan)) {
                                                echo $pesan;
                                            }
                                            ?>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-12">
                                                <h5 class="text-muted">DATA IDENTITAS JEMAAT</h5>
                                                <hr>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <h5>Foto Profil</h5>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <?php
                                                        if (!empty($rowProfil->foto)) {
                                                            echo '
                                                                        <img src="' . base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto) . '" alt="" style="width: 80%;" class="">
                                                                    ';
                                                        } else {
                                                            echo '
                                                                        <img src="' . base_url('myesc.id/images/nofoto.png') . '" alt="" style="width: 80%;" class="">
                                                                    ';
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="col-12 text-center mt-3">
                                                        <input type="file" class="btn btn-sm btn-primary" id="foto" name="foto">
                                                        <input type="hidden" id="foto_lama" name="foto_lama">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">NIK</label>
                                                            <input type="text" name="nikprofil" id="nikprofil" class="form-control" placeholder="Masukkan NIK">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Kewarganegaraan</label>
                                                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                                                                <option value="">Pilih kewarganegaraan...</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Asing">Asing</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Nama Lengkap</label>
                                                            <input type="text" name="namalengkapprofil" id="namalengkapprofil" class="form-control" placeholder="Masukkan nama lengkap">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Nama Panggilan</label>
                                                            <input type="text" name="namapanggilan" id="namapanggilan" class="form-control" placeholder="Masukkan nama panggilan">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Tempat / Tgl Lahir</label>
                                                            <input type="text" name="tempatlahirprofil" id="tempatlahirprofil" class="form-control" placeholder="Masukkan tempat lahir">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Tgl Lahir</label>
                                                            <input type="date" name="tanggallahirprofil" id="tanggallahirprofil" class="form-control">

                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Jenis Kelamin</label>
                                                            <select name="jeniskelaminprofil" id="jeniskelaminprofil" class="form-control">
                                                                <option value="">Pilih jenis kelamin...</option>
                                                                <option value="Laki-laki">Laki-laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group required">
                                                            <label for="" class="">Status Pernikahan</label>
                                                            <select name="statuspernikahan" id="statuspernikahan" class="form-control">
                                                                <option value="">Pilih status pernikahan</option>
                                                                <option value="Belum Kawin">Belum Kawin</option>
                                                                <option value="Kawin">Kawin</option>
                                                                <option value="Janda/ Duda">Janda/ Duda</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="">Golongan Darah</label>
                                                            <select name="golongandarah" id="golongandarah" class="form-control">
                                                                <option value="">Pilih golongan darah...</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="AB">AB</option>
                                                                <option value="O">O</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>






                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h5 class="text-muted">DATA SOSIAL MEDIA</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="">No Telepon.</label>
                                                    <input type="text" name="notelp" id="notelp" class="form-control" placeholder="Masukkan nomor telepon">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class=" text-right">No HP.</label>
                                                    <input type="text" name="nohpprofil" id="nohpprofil" class="form-control" placeholder="Masukkan nomor hp">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="">Email</label>
                                                    <input type="email" name="emailprofil" id="emailprofil" class="form-control" placeholder="contoh@gmail.com">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="">Url Instagram</label>
                                                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="Masukkan url instagram">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="">Url Facebook</label>
                                                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Masukkan url facebook">
                                                </div>
                                            </div>


                                        </div>




                                        <div class="row mt-3">
                                            <div class="col-12 mt-3">
                                                <h5 class="text-muted">DATA ALAMAT JEMAAT</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Alamat Rumah</label>
                                                    <textarea name="alamatrumahprofil" id="alamatrumahprofil" class="form-control" rows="4" placeholder="Masukkan alamat rumah"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="" class="">RT/ RW</label>
                                                        <input type="text" name="rtrw" id="rtrw" class="form-control" placeholder="000/000">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="">Kode Pos</label>
                                                        <input type="text" name="kodepos" id="kodepos" class="form-control" placeholder="Masukkan kode pos">
                                                    </div>
                                                    <div class="col-7"></div>
                                                    <div class="col-md-3">
                                                        <label for="" class="">Propinsi</label>
                                                        <select name="propinsi" id="propinsi" class="form-control select2">
                                                            <option value="">Pilih nama propinsi ...</option>
                                                            <?php
                                                            $rsProvinsi = $this->db->query("select * from provinsi order by namaprovinsi");
                                                            if ($rsProvinsi->num_rows() > 0) {
                                                                foreach ($rsProvinsi->result() as $row) {
                                                                    echo '
                                          <option value="' . $row->idprovinsi . '">' . $row->namaprovinsi . '</option>
                                      ';
                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="">Kabupaten/Kota</label>
                                                        <select name="kotakabupaten" id="kotakabupaten" class="form-control select2">
                                                            <option value="">Pilih nama kabupaten ...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="">Kecamatan</label>
                                                        <select name="kecamatan" id="kecamatan" class="form-control select2">
                                                            <option value="">Pilih nama kecamatan ...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="">Kelurahan</label>
                                                        <select name="kelurahan" id="kelurahan" class="form-control select2">
                                                            <option value="">Pilih nama kelurahan ...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-12 mt-3">
                                                <h5 class="text-muted">KONTAK DARURAT YANG BISA DIHUBUNGI</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="">Nama</label>
                                                    <input type="text" name="namadarurat" id="namadarurat" class="form-control" placeholder="Masukkan namadarurat">

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="">Hubungan</label>
                                                    <select name="hubungan" id="hubungan" class="form-control">
                                                        <option value="">Pilih hubungan...</option>
                                                        <option value="Ayah">Ayah</option>
                                                        <option value="Ibu">Ibu</option>
                                                        <option value="Istri/ Suami">Istri/ Suami</option>
                                                        <option value="Anak">Anak</option>
                                                        <option value="Saudara">Saudara</option>
                                                        <option value="Kerabat">Kerabat</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="">No Telp.</label>
                                                    <input type="text" name="notelpdarurat" id="notelpdarurat" class="form-control" placeholder="Masukkan notelp darurat">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-12 mt-3">
                                                <h5 class="text-muted">PENDIDIKAN DAN PEKERJAAN</h5>
                                                <hr>
                                            </div>



                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Pendidikan Terakhir</label>
                                                    <select name="pendidikanterakhir" id="pendidikanterakhir" class="form-control">
                                                        <option value="">Pilih pendidikan terakhir</option>
                                                        <option value="SD">SD</option>
                                                        <option value="SMP">SMP</option>
                                                        <option value="SMA/ SMK">SMA/ SMK</option>
                                                        <option value="D1">D1</option>
                                                        <option value="D2">D2</option>
                                                        <option value="D3">D3</option>
                                                        <option value="S1">S1</option>
                                                        <option value="S2">S2</option>
                                                        <option value="S3">S3</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Nama Sekolah</label>
                                                    <input type="text" name="namasekolah" id="namasekolah" class="form-control" placeholder="Masukkan nama sekolah">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Pekerjaan</label>
                                                    <select name="pekerjaan" id="pekerjaan" class="form-control">
                                                        <option value="">Pilih pekerjaan...</option>
                                                        <option value="Swasta">Swasta</option>
                                                        <option value="Wiraswasta">Wiraswasta</option>
                                                        <option value="Pegawai Negeri">Pegawai Negeri</option>
                                                        <option value="TNI">TNI</option>
                                                        <option value="POLRI">POLRI</option>
                                                        <option value="Gembala">Gembala</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Nama Perusahaan</label>
                                                    <input type="text" name="namaperusahaan" id="namaperusahaan" class="form-control" placeholder="Masukkan nama perusahaan">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Alamat Kantor</label>
                                                    <textarea name="alamatkantor" id="alamatkantor" class="form-control" rows="2" placeholder="Masukkan alamat kantor"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">Sektor Industri</label>
                                                    <input type="text" name="sektorindustri" id="sektorindustri" class="form-control" placeholder="Masukkan sektorindustri">
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="">No Telepon Kantor</label>
                                                    <input type="text" name="notelpkantor" id="notelpkantor" class="form-control" placeholder="Masukkan nomor telepon kantor">
                                                </div>
                                            </div>


                                        </div>






                                    </div> <!-- ./card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-end" id="btnSimpan"><i class="fa fa-save"></i> Simpan</button>
                                        <a href="<?php echo (site_url('akun/profil')) ?>" class="btn btn-default float-end mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                                    </div>
                                </div> <!-- /.card -->
                            </div> <!-- /.col -->
                        </div>
                    </form>














                </div>
            </div>
        </section>






    </main>


    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
        // $(document).on('change', '#foto', function(e) {
        //     $('#formUpload').submit();
        // });


        $(document).ready(function() {


            $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("akun/getJemaatId") ?>',
                    dataType: 'json',
                    encode: true
                })
                .done(function(result) {
                    console.log(result);
                    $("#nikprofil").val(result.nik);
                    $("#kewarganegaraan").val(result.kewarganegaraan);
                    $("#namalengkapprofil").val(result.namalengkap);
                    $("#namapanggilan").val(result.namapanggilan);
                    $("#tempatlahirprofil").val(result.tempatlahir);
                    $("#tanggallahirprofil").val(result.tanggallahir);
                    $("#jeniskelaminprofil").val(result.jeniskelamin);
                    $("#statuspernikahan").val(result.statuspernikahan);
                    $("#golongandarah").val(result.golongandarah);
                    $("#notelp").val(result.notelp);
                    $("#nohp").val(result.nohp);
                    $("#emailprofil").val(result.email);
                    $("#facebook").val(result.facebook);
                    $("#instagram").val(result.instagram);
                    $("#namadarurat").val(result.namadarurat);
                    $("#hubungan").val(result.hubungan);
                    $("#notelpdarurat").val(result.notelpdarurat);
                    $("#pendidikanterakhir").val(result.pendidikanterakhir);
                    $("#namasekolah").val(result.namasekolah);
                    $("#pekerjaan").val(result.pekerjaan);
                    $("#namaperusahaan").val(result.namaperusahaan);
                    $("#sektorindustri").val(result.sektorindustri);
                    $("#alamatkantor").val(result.alamatkantor);
                    $("#notelpkantor").val(result.notelpkantor);
                    $("#alamatrumahprofil").val(result.alamatrumah);
                    $("#rtrw").val(result.rtrw);
                    $("#propinsi").val(result.propinsi).trigger('change');
                    $("#kotakabupaten").val(result.kotakabupaten).trigger('change');
                    $("#kecamatan").val(result.kecamatan).trigger('change');
                    $("#kelurahan").val(result.kelurahan).trigger('change');
                    $("#kodepos").val(result.kodepos);
                    $("#foto_lama").val(result.foto);

                    getKabupaten(result.propinsi, result.kotakabupaten);
                    getKecamatan(result.kotakabupaten, result.kecamatan);

                    if (result.statusjemaat == 'Jemaat') {
                        $('#statusjemaat').attr('disabled', true);
                    }
                    usernameSudahAda = false;

                    $('#emailprofil').attr('readonly', true);



                    if (result.statusjemaat == 'Registered') {
                        $('#nikprofil').focus();

                    } else {
                        $('#notelp').focus();
                        $('#nikprofil').attr('disabled', true);
                        $('#kewarganegaraan').attr('disabled', true);
                        $('#namalengkapprofil').attr('disabled', true);
                        $('#namapanggilan').attr('disabled', true);
                        $('#tempatlahirprofil').attr('disabled', true);
                        $('#tanggallahirprofil').attr('disabled', true);
                        $('#jeniskelaminprofil').attr('disabled', true);
                        $('#statuspernikahan').attr('disabled', true);
                        $('#golongandarah').attr('disabled', true);

                    }


                });


            $("#form").bootstrapValidator({
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        nikprofil: {
                            validators: {
                                notEmpty: {
                                    message: "nik tidak boleh kosong"
                                },
                            }
                        },
                        kewarganegaraan: {
                            validators: {
                                notEmpty: {
                                    message: "kewarganegaraan tidak boleh kosong"
                                },
                            }
                        },
                        namalengkapprofil: {
                            validators: {
                                notEmpty: {
                                    message: "nama lengkap tidak boleh kosong"
                                },
                            }
                        },
                        namapanggilan: {
                            validators: {
                                notEmpty: {
                                    message: "nama panggilan tidak boleh kosong"
                                },
                            }
                        },
                        tempatlahirprofil: {
                            validators: {
                                notEmpty: {
                                    message: "tempat lahir tidak boleh kosong"
                                },
                            }
                        },
                        tanggallahirprofil: {
                            validators: {
                                notEmpty: {
                                    message: "tanggal lahir tidak boleh kosong"
                                },
                            }
                        },
                        jeniskelaminprofil: {
                            validators: {
                                notEmpty: {
                                    message: "jenis kelamin tidak boleh kosong"
                                },
                            }
                        },
                        statuspernikahan: {
                            validators: {
                                notEmpty: {
                                    message: "status pernikahan tidak boleh kosong"
                                },
                            }
                        },
                        emailprofil: {
                            validators: {
                                notEmpty: {
                                    message: "email tidak boleh kosong"
                                },
                            }
                        },
                    }
                })
                .on('success.form.bv', function(e) {
                    $('#btnSimpan').attr('disabled', true);
                });

            // $('#emailprofil').prop('readonly', true);
        });

        function getKabupaten(idprovinsi, idkabupatendefault = "") {

            $('#kotakabupaten').empty();
            $('#idkecamatan').empty();

            addSelectOption('kotakabupaten', '', 'Pilih kabupaten/ kota ...')
            addSelectOption('kecamatan', '', 'Pilih kecamatan ...')

            $.ajax({
                    url: '<?= site_url('akun/getKabupaten') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idprovinsi': idprovinsi
                    },
                })
                .done(function(response) {
                    console.log(response);
                    if (response.length > 0) {
                        for (var i = 0; i < response.length; i++) {
                            // console.log(response[i]);
                            addSelectOption('kotakabupaten', response[i]['idkabupaten'], response[i]['namakabupaten']);
                            if (idkabupatendefault != "" && idkabupatendefault == response[i]['idkabupaten']) {
                                $('#kotakabupaten').val(response[i]['idkabupaten']).trigger('change');
                            }
                        }
                    }
                })
                .fail(function() {
                    console.log('error getKabupaten');
                });

        }

        $('#propinsi').change(function(e) {
            var idprovinsi = $(this).val();
            getKabupaten(idprovinsi);
        });

        $('#kotakabupaten').change(function(e) {
            var idkabupaten = $(this).val();
            getKecamatan(idkabupaten);
        });

        $('#kecamatan').change(function(e) {
            var idkecamatan = $(this).val();
            getdesa(idkecamatan);
        });

        function getKecamatan(idkabupaten, idkecamatandefault = "") {

            $('#kecamatan').empty();
            // console.log(idkabupaten);

            addSelectOption('kecamatan', '', 'Pilih kecamatan ...')

            $.ajax({
                    url: '<?= site_url('akun/getKecamatan') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idkabupaten': idkabupaten
                    },
                })
                .done(function(response) {
                    // console.log(response);
                    if (response.length > 0) {
                        for (var i = 0; i < response.length; i++) {
                            console.log(response[i]);
                            addSelectOption('kecamatan', response[i]['idkecamatan'], response[i]['namakecamatan']);
                            if (idkecamatandefault != "" && idkecamatandefault == response[i]['idkecamatan']) {
                                $('#kecamatan').val(response[i]['idkecamatan']).trigger('change');
                            }
                        }
                    }
                })
                .fail(function() {
                    console.log('error getKecamatan');
                });

        }

        function getdesa(idkecamatan, iddesadefault = "") {

            $('#kelurahan').empty();

            addSelectOption('kelurahan', '', 'Pilih kelurahan ...')

            $.ajax({
                    url: '<?= site_url('akun/getKelurahan') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idkecamatan': idkecamatan
                    },
                })
                .done(function(response) {
                    console.log(response);
                    if (response.length > 0) {
                        for (var i = 0; i < response.length; i++) {
                            console.log(response[i]);
                            addSelectOption('kelurahan', response[i]['iddesa'], response[i]['namadesa']);
                            if (iddesadefault != "" && iddesadefault == response[i]['iddesa']) {
                                $('#kelurahan').val(response[i]['iddesa']).trigger('change');
                            }
                        }
                    }
                })
                .fail(function() {
                    console.log('error getKecamatan');
                });
        }
    </script>

</body>

</html>