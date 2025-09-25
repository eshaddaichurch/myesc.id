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

      <!-- Status Jemaat -->
      <div class="col-12 mb-4 text-center">
        <h4 class="fw-bold">Status: <?php echo $rowProfil->statusjemaat; ?></h4>
      </div>

      <form action="<?php echo site_url('akun/simpanJemaat') ?>" method="post" id="form" enctype="multipart/form-data">
        <div class="card shadow-sm" id="cardcontent">
          <div class="card-body">

            <!-- Pesan -->
            <?php if ($pesan = $this->session->flashdata("pesan")): ?>
              <div class="alert alert-info"><?php echo $pesan; ?></div>
            <?php endif; ?>

            <!-- Identitas Jemaat -->
            <h6 class="fw-bold text-muted mb-3">Data Identitas Jemaat</h6>
            <div class="row g-3 align-items-start mb-4">
              <!-- Foto -->
              <div class="col-md-4 text-center">
                <h6 class="mb-2">Foto Profil</h6>
                <?php if (!empty($rowProfil->foto)): ?>
                  <img src="<?php echo base_url('myesc.id/admin/uploads/jemaat/'.$rowProfil->foto) ?>" class="img-fluid rounded mb-3" alt="Foto Profil">
                <?php else: ?>
                  <img src="<?php echo base_url('myesc.id/images/nofoto.png') ?>" class="img-fluid rounded mb-3" alt="Foto Profil">
                <?php endif; ?>
                <input type="file" name="foto" id="foto" class="form-control form-control-sm mb-2">
                <input type="hidden" name="foto_lama" id="foto_lama">
                <small class="text-danger d-block">*Ukuran foto maksimal 2 MB</small>
              </div>
              <!-- Form kanan -->
              <div class="col-md-8">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nikprofil" id="nikprofil" class="form-control" placeholder="Masukkan NIK">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan</label>
                    <select name="kewarganegaraan" id="kewarganegaraan" class="form-select">
                      <option value="">Pilih kewarganegaraan...</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="Asing">Asing</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="namalengkapprofil" id="namalengkapprofil" class="form-control" placeholder="Masukkan nama lengkap">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Nama Panggilan</label>
                    <input type="text" name="namapanggilan" id="namapanggilan" class="form-control" placeholder="Masukkan nama panggilan">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempatlahirprofil" id="tempatlahirprofil" class="form-control" placeholder="Masukkan tempat lahir">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggallahirprofil" id="tanggallahirprofil" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jeniskelaminprofil" id="jeniskelaminprofil" class="form-select">
                      <option value="">Pilih jenis kelamin...</option>
                      <option value="Laki-laki">Laki-laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Status Pernikahan</label>
                    <select name="statuspernikahan" id="statuspernikahan" class="form-select">
                      <option value="">Pilih status pernikahan</option>
                      <option value="Belum Kawin">Belum Kawin</option>
                      <option value="Kawin">Kawin</option>
                      <option value="Janda/ Duda">Janda/ Duda</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongandarah" id="golongandarah" class="form-select">
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

            <!-- Section lain (Sosial Media, Alamat, Darurat, Pendidikan, dll.) -->
            <!-- Struktur tetap, hanya rapikan heading + spacing -->
            <!-- ...lanjutkan sama seperti di atas dengan row g-3, label form-label, select form-select -->

          </div><!-- /.card-body -->

          <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> Simpan
            </button>
            <a href="<?php echo site_url('akun/profil') ?>" class="btn btn-light">
              <i class="fa fa-chevron-circle-left"></i> Kembali
            </a>
          </div>
        </div><!-- /.card -->
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

                     setTimeout(function() {
                        $("#kecamatan").val(result.kecamatan).trigger('change');
                    }, 1000);

                     setTimeout(function() {
                        $("#kelurahan").val(result.kelurahan).trigger('change');
                    }, 1500);
                    

                    
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