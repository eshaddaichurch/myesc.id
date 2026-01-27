<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>


    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>
      @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
     

      /* This pen */




      .dark {
        background: #110f16;
      }

      /*--------------------------------------------------------------
                    # Breadcrumbs
                    --------------------------------------------------------------*/
      .breadcrumbs {
        padding: 140px 0 60px 0;
        min-height: 30vh;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      .breadcrumbs:before {
        content: "";
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        inset: 0;
      }

      .breadcrumbs h2 {
        font-size: 56px;
        font-weight: 500;
        color: #fff;
        font-family: var(--font-secondary);
      }

      .breadcrumbs ol {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0 0 10px 0;
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--color-primary);
      }

      .breadcrumbs ol a {
        color: rgba(255, 255, 255, 0.8);
        transition: 0.3s;
      }

      .breadcrumbs ol a:hover {
        text-decoration: underline;
      }

      .breadcrumbs ol li+li {
        padding-left: 10px;
      }

      .breadcrumbs ol li+li::before {
        display: inline-block;
        padding-right: 10px;
        color: #fff;
        content: "/";
      }


      .light {
        background: #f3f5f7;
      }

      a,
      a:hover {
        text-decoration: none;
        transition: color 0.3s ease-in-out;
      }

      #pageHeaderTitle {
        margin: 2rem 0;
        text-transform: uppercase;
        text-align: center;
        font-size: 2.5rem;
      }

      
      

      
      

      /* ===== MODAL DC FINAL ===== */
    .modal-dc {
    border-radius: 18px;
    overflow: hidden;
    border: none;
    }

    /* header */
    .modal-dc-header {
    background: #ff5008;
    color: #fff;
    padding: 18px 24px;
    }

    /* left side */
    .modal-dc-left {
    background: #eee;
    position: relative;
    min-height: 420px;
    }

    .modal-dc-map {
        position: relative;
        height: 100%;
    }

    .modal-dc-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    .modal-dc-location {
    position: absolute;
    bottom: 24px;
    left: 24px;
    background: rgba(255,255,255,0.85);
    padding: 12px 16px;
    border-radius: 12px;
    display: flex;
    gap: 10px;
    align-items: center;
    font-size: 14px;
    }

    /* right side */
    .modal-dc-right {
    padding: 32px;
    }

    .modal-dc-badge {
    background: rgba(255,80,8,.12);
    color: #ff5008;
    border-radius: 999px;
    font-size: 12px;
    padding: 6px 14px;
    font-weight: 600;
    }

    /* info list */
    .modal-dc-info {
    display: grid;
    gap: 18px;
    }

    .info-item {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    }

    .info-item i {
    color: #ff5008;
    font-size: 18px;
    margin-top: 2px;
    }

    .text-orange {
    color: #ff5008;
    }

    /* button */
    .btn-dc-join {
    background: #ff5008;
    color: #fff;
    padding: 14px 26px;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    }

    .btn-dc-join:hover {
    background: #ff6a2a;
    color: #fff;
    }


      

        body {
            margin: 0;
            background: #e9ecef;
            font-family: 'Figtree', sans-serif;
            color: #111;
            line-height: 1.7;
        }

        

        .page-content {
        padding-top: 110px; /* sesuaikan tinggi navbar asli */
        }
        

        .container-fluid,
        .container {
            /* max-width: 1200px; */
        }

        .card-container {
            padding: 100px 0px;
            -webkit-perspective: 1000;
            perspective: 1000;
        }

     

        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            border: none;
        }

        .modal-header {
            background-color: #ff5008;
            color: #fff;
            padding: 1.5rem;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
            background-color: #fffaf7;
        }

        .modal-footer {
            background-color: #fffaf7;
            padding: 1.5rem 2rem;
            gap: 1rem;
        }

        .btn-outline-secondary {
            border-color: #000;
            color: #000;
        }

        .btn-outline-secondary:hover {
            background-color: #000;
            color: #fff;
        }

        .btn-black {
            background-color: #000;
            color: #fff;
            border: none;
        }

        .btn-black:hover {
            background-color: #333;
        }


        .dc-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            height: 380px;
            box-shadow: 0 12px 35px rgba(0,0,0,.15);
        }

        .dc-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.25);
        }

        .dc-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* overlay gelap bawah */

        .dc-page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #0f172a;
        }

        /* container text */
        .dc-info {
            position: absolute;
            left: 18px;
            bottom: 12px;
            z-index: 2;
            color: #ffffff;
            line-height: 1.2;
        }

        /* Nama DM (lebih besar) */
        .dc-dm {
            font-size: 20px;
            font-weight: 700;
        }

        /* Nama DC (lebih kecil) */
        .dc-name {
            font-size: 14px;
            opacity: .9;
        }


        .dc-card {
            margin-bottom: 24px;
        }

    
        @media (max-width: 576px) {
            .dc-card img {
                height: 240px;
            }

            .dc-dm {
                font-size: 18px;
            }

            .dc-name {
                font-size: 13px;
            }
        }



        /* filter box */
        .dc-filter-box {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,.06);
        margin-bottom: 40px;
        }

        .dc-filter-box label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
        }

        .btn-search {
        background: #0f172a;
        color: #fff;
        height: 46px;
        border-radius: 12px;
        font-weight: 600;
        }

        .btn-search:hover {
        background: #020617;
        }

        /* cards */
        .dc-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        height: 380px;
        box-shadow: 0 12px 35px rgba(0,0,0,.15);
        transition: transform .3s ease, box-shadow .3s ease;
        }

        .dc-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 45px rgba(0,0,0,.25);
        }

        .dc-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        }

        /* gradient bawah */
        .dc-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
            to top,
            rgba(0,0,0,.75),
            rgba(0,0,0,.25),
            transparent
            );
        }

        /* text */
        .dc-info {
        position: absolute;
        left: 20px;
        bottom: 20px;
        z-index: 2;
        color: #fff;
        }

        .dc-dm {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
        }

        .dc-name {
        font-size: 14px;
        opacity: .9;
        }

        /* responsive */
        @media (max-width: 768px) {
        .dc-card {
            height: 300px;
        }
        }


        /* ===== MODAL ANIMATION ===== */
        .modal.fade .modal-dialog {
        transform: translateY(40px);
        transition: transform .35s ease-out, opacity .35s ease-out;
        opacity: 0;
        }

        .modal.fade.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
        }


        /* ===== MOBILE STACK ===== */
        @media (max-width: 768px) {
        

        .modal-dc-map {
            border-radius: 0;
        }

        .modal-dc-right {
            padding: 24px 20px;
        }

        .btn-dc-join {
            width: 100%;
            text-align: center;
        }

        .modal-dc-location {
            left: 16px;
            right: 16px;
            bottom: 16px;
            font-size: 13px;
        }
        }

        @media (max-width: 576px) {

            /* modal wrapper */
            .modal-dialog {
            margin: 10px;
            }

            .modal-content {
            max-height: 92vh;
            border-radius: 16px;
            overflow: hidden;
            }

            .modal-body {
            padding: 0;
            overflow-y: auto;
            }

            /* LEFT SIDE (MAP / FOTO) */
            .modal-dc-left {
            min-height: 180px;
            max-height: 180px;
            width: 100%;
            }

            /* Google Maps iframe */
            .modal-dc-map iframe {
            width: 100%;
            height: 180px;
            border: 0;
            }

            /* LOCATION INFO → JADI DI BAWAH MAP */
            .modal-dc-location {
            position: static;              /* ❗ penting */
            background: #fff;
            padding: 12px 16px;
            font-size: 13px;
            border-top: 1px solid #eee;
            }

            /* RIGHT CONTENT */
            .modal-dc-right {
            padding: 16px;
            }

            /* BUTTON JOIN */
            .btn-dc-join {
            position: sticky;
            bottom: 0;
            width: 100%;
            border-radius: 0;
            padding: 16px;
            font-size: 15px;
            z-index: 10;
            }

        }

    </style>
    <!-- </head>

    <body> -->

    <section class="page-content section-padding">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="row">
                        <!-- <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h5 class="text-muted">Filter Nama Disciples Community</h5>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="">Kategori DC</label>
                                    <select name="idkategoridc" id="idkategoridc" class="form-control select2">
                                        <option value="">Semua</option>
                                        
                                        <option value="Young Adult">Dewasa Muda (Kuliah, Kerja, Single)</option>
                                        
                                        <option value="Family">Keluarga (Menikah)</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="">Cari Nama DC</label>
                                    <input type="text" name="carinamadc" id="carinamadc" class="form-control" placeholder="Cari berdasarkan nama dc">
                                </div>
                                

                                <div class="col-md text-center mt-3">
                                    <button class="btn btn-black" id="btnCari">
                                        <i class="fa fa-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-12 mb-4">
                            <h2 class="dc-page-title">Disciples Community Directory</h2>
                            </div>

                            <div class="col-12">
                            <div class="dc-filter-box">
                                <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label>Kategori DC</label>
                                    <select name="idkategoridc" id="idkategoridc" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    <option value="Young Adult">Dewasa Muda(kuliah),(kerja),(single)</option>
                                    <option value="Family">Keluarga</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Cari Nama DC</label>
                                    <input type="text" name="carinamadc" id="carinamadc"
                                        class="form-control"
                                        placeholder="Cari berdasarkan nama DC...">
                                </div>

                                <div class="col-md-3 d-grid">
                                    <button class="btn btn-search" id="btnCari">
                                    <i class="fa fa-search me-2"></i> Cari Community
                                    </button>
                                </div>
                                </div>
                            </div>
                            </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="col-12">
                            <div class="row" id="divListDC">
                                <?php
                                if ($rsDC->num_rows() > 0) {
                                    foreach ($rsDC->result() as $row) {

                                        if (!empty($row->fotodm)) {
                                            $fotodm = base_url('myesc.id/admin/uploads/jemaat/' . $row->fotodm);
                                        } else {
                                            $fotodm = base_url('myesc.id/images/bg-dc.png');
                                        }

                                        echo '
                                            <div class="col-md-4 col-sm-6">
                                                <div class="dc-card btn-informasi-dc" data-iddc="'.$row->iddc.'">
                                                    <img src="'.$fotodm.'" alt="Foto DM">
                                                    <div class="dc-overlay"></div>
                                                    <div class="dc-info">
                                                    <div class="dc-dm">'.$row->namadm.'</div>
                                                    <div class="dc-name">
                                                    <i class="fa fa-users me-1 text-warning"></i>
                                                    '.$row->namadc.'
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            ';

                                        // <a href="' . site_url('disciples_community/bergabung/' . $this->encrypt->encode($row->iddc)) . '" class="btn btn-primary profile-buttons">Lihat Informasi DC</a>
                                    }
                                }
                                ?>

                            </div>
                        </div>

                    </div>
        </section>






    </main>


    <!-- <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modalInfoDC">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi Disciples Community</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="namadc">NAMA DC</h5>
                                <span>Nama DM: <span class="namadm"></span></span>
                            </div>
                            <div class="col-12">
                                Alamat: <span class="alamatdc"></span>
                            </div>
                            <div class="col-12">
                                Hari: <span class="haridc"></span>
                            </div>
                            <div class="col-12">
                                Jam: <span class="jamdc"></span>
                            </div>
                            <div class="col-12">
                                Kategori: <span class="kategoridc"></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="modal fade" id="modalInfoDC" tabindex="-1" aria-labelledby="modalInfoDCTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoDCTitle">Informasi Disciples Community</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row gy-3">
                            <div class="col-12">
                                <h5 class="namadc text-dark fw-bold mb-2">Nama Disciples Community</h5>
                                <p class="mb-1">Nama DM: <span class="namadm fw-medium text-dark"></span></p>
                            </div>
                            <div class="col-12">
                                <p class="mb-1"><i class="bi bi-geo-alt-fill me-1 text-secondary"></i>Alamat: <span class="alamatdc text-dark"></span></p>
                                <p class="mb-1"><i class="bi bi-calendar-event me-1 text-secondary"></i>Hari: <span class="haridc text-dark"></span></p>
                                <p class="mb-1"><i class="bi bi-clock-fill me-1 text-secondary"></i>Jam: <span class="jamdc text-dark"></span></p>
                                <p class="mb-1"><i class="bi bi-tags-fill me-1 text-secondary"></i>Kategori: <span class="kategoridc text-dark"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    
                    <a href="#" id="btnModalBergabung" class="btn btn-black w-50">Bergabung Sekarang</a>
                </div>
            </div>
        </div>
    </div> -->



        <div class="modal fade" id="modalInfoDC" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content modal-dc shadow-lg">

                <!-- HEADER -->
                <div class="modal-header modal-dc-header">
                    <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-users"></i>
                    <h5 class="modal-title">Informasi Disciples Community</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-0">
                    <div class="row g-0">
                            <!-- LEFT : MAP -->
                        <div class="col-md-6 modal-dc-left">
                            <div class="modal-dc-map">
                                <iframe
                                id="modalDcMap"
                                src=""
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                                </iframe>


                                <div class="modal-dc-location">
                                <i class="fa fa-map-marker-alt"></i>
                                <div>
                                <small>Lokasi Pertemuan DC</small>
                                <div class="alamatdc fw-semibold"></div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- RIGHT -->
                    <div class="col-md-6 modal-dc-right">
                        <span class="badge modal-dc-badge mb-2">COMMUNITY</span>

                        <h3 class="namadc fw-bold mb-4"></h3>

                        <div class="modal-dc-info">
                        <div class="info-item">
                            <i class="fa fa-user"></i>
                            <div>
                            <small>Nama DM</small>
                            <div class="namadm fw-semibold"></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fa fa-calendar"></i>
                            <div>
                            <small>Hari</small>
                            <div class="haridc fw-semibold"></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fa fa-clock"></i>
                            <div>
                            <small>Jam</small>
                            <div class="jamdc fw-semibold"></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fa fa-tag"></i>
                            <div>
                            <small>Kategori</small>
                            <div class="kategoridc fw-semibold text-orange"></div>
                            </div>
                        </div>
                        </div>

                        <a href="#" id="btnModalBergabung" class="btn btn-dc-join mt-4">
                        Bergabung Sekarang →
                        </a>
                    </div>

                    </div>
                </div>

                </div>
            </div>
        </div>




    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
        $('#idkabupaten').change(function(e) {
            var idkabupaten = $(this).val();
            getKecamatan(idkabupaten);
        });

        // $('#idkecamatan').change(function(e) {
        //   var idkecamatan = $(this).val();
        //   getdesa(idkecamatan);
        // });

        function getKecamatan(idkabupaten, idkecamatandefault = "") {

            $('#idkecamatan').empty();
            // console.log(idkabupaten);

            addSelectOption('idkecamatan', '', 'Pilih kecamatan ...')

            $.ajax({
                    url: '<?= site_url('disciples_community/getKecamatan') ?>',
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
                            // console.log(response[i]);
                            addSelectOption('idkecamatan', response[i]['idkecamatan'], response[i]['namakecamatan']);
                            if (idkecamatandefault != "" && idkecamatandefault == response[i]['idkecamatan']) {
                                $('#idkecamatan').val(response[i]['idkecamatan']).trigger('change');
                            }
                        }
                    }
                })
                .fail(function() {
                    console.log('error getKecamatan');
                });

        }

        $(document).on('click', '#btnCari', function() {
            console.log("1");
            cari();
        });

        function cari() {
            var idkategoridc = $('#idkategoridc').val();
            var idkabupaten = $('#idkabupaten').val();
            var idkecamatan = $('#idkecamatan').val();
            var cari = $('#carinamadc').val();

            $('#divListDC').empty();

            var baseURL = "<?php echo base_url() ?>";
            $.ajax({
                    url: '<?php echo site_url('disciples_community/getListDC') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idkategoridc': idkategoridc,
                        'idkabupaten': idkabupaten,
                        'idkecamatan': idkecamatan,

                        'cari': cari,
                    },
                })
                .done(function(response) {
                    console.log(response);
                    if (response.success && response.data.length > 0) {
                        for (var i = 0; i < response.data.length; i++) {
                            var fotodm;
                            if (response.data[i]['fotodm'] && response.data[i]['fotodm'] !== "") {
                                fotodm = baseURL + "myesc.id/admin/uploads/jemaat/" + response.data[i]['fotodm'];
                            } else {
                                fotodm = baseURL + "myesc.id/images/bg-dc.png";
                            }

                            var addText = `
                            <div class="col-md-4 col-sm-6">
                            <div class="dc-card btn-informasi-dc" data-iddc="${response.data[i]['iddc']}">
                                <img src="${fotodm}" alt="Foto DM">
                                <div class="dc-overlay"></div>
                                <div class="dc-info">
                                <div class="dc-dm">${response.data[i]['namadm']}</div>
                                <div class="dc-name">
                                    <i class="fa fa-users me-1 text-warning"></i>
                                    ${response.data[i]['namadc']}
                                </div>
                                </div>
                            </div>
                            </div>
                            `;

                            $('#divListDC').append(addText);
                        }
                    } else {
                        $('#divListDC').html('<p>Tidak ada data ditemukan</p>');
                    }
                })

                .fail(function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#divListDC').html('<p>Terjadi kesalahan saat memuat data</p>');
                });
        }

        $(document).on('click', '.btn-informasi-dc', function(e) {
            e.preventDefault();
            var iddc = $(this).data('iddc');

            $.ajax({
                    url: '<?= site_url('disciples_community/getInformasiDC') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'iddc': iddc
                    },
                })
                // .done(function(response) {
                //     console.log(response);
                //     if (response['status'] == 'success') {
                //         $('#modalInfoDC').modal('show');
                //         $('.namadc').html(response['data'][0]['namadc']);
                //         // set background kiri (foto DM)
                        
                //         var fotoDM = response['data'][0]['fotodm'];

                //         if (fotoDM && fotoDM !== "") {
                //             $('#modalDcBg').css(
                //                 'background-image',
                //                 'url(' + baseURL + 'myesc.id/admin/uploads/jemaat/' + fotoDM + ')'
                //             );
                //         } else {
                //             $('#modalDcBg').css(
                //                 'background-image',
                //                 'url(' + baseURL + 'myesc.id/images/bg-dc.png)'
                //             );
                //         }
                //         $('.namadm').html(response['data'][0]['namadm']);
                //         $('.alamatdc').html(response['data'][0]['alamatdc']);
                //         $('.haridc').html(response['data'][0]['haridc']);
                //         $('.jamdc').html(response['data'][0]['jamdc']);
                //         $('.kategoridc').html(response['data'][0]['kategoridc']);

                        
                //         var baseURL = "<?= base_url() ?>";
                        
                //         $('#btnModalBergabung').attr('data-iddc', response['iddcEncrypt']);

                //     } else {
                //         swal('Informasi', 'Data DC tidak ditemukan!', 'info');
                //     }
                // })
                .done(function(response) {
                    console.log(response);

                    if (response.status === 'success' && response.data.length > 0) {

                        const dc = response.data[0];

                        $('#modalInfoDC').modal('show');

                        $('.namadc').html(dc.namadc);
                        $('.namadm').html(dc.namadm);
                        $('.alamatdc').html(dc.alamatdc);
                        $('.haridc').html(dc.haridc);
                        $('.jamdc').html(dc.jamdc);
                        $('.kategoridc').html(dc.kategoridc);

                        // GOOGLE MAPS EMBED
                        let alamat = encodeURIComponent(dc.alamatdc);
                        let mapUrl = `https://www.google.com/maps?q=${alamat}&output=embed`;

                        $('#modalDcMap').attr('src', mapUrl);

                        // tombol bergabung
                        $('#btnModalBergabung').attr('data-iddc', response.iddcEncrypt);

                    } else {
                        swal('Informasi', 'Data DC tidak ditemukan!', 'info');
                    }
                })
                .fail(function() {
                    console.log('error getInformasiDC');
                });
        });

        $(document).on('click', '#btnModalBergabung', function(e) {
            e.preventDefault();
            var iddc = $(this).data('iddc');

            if (belumLogin()) {
                swal('Informasi', 'Silahkan login terlebih dahulu', 'info').then(
                    function() {
                        //buka modal login
                        $('#modalInfoDC').modal('hide');
                        $('#loginModal').modal('show');
                        
                    }
                );
                return false;
            }

            $.ajax({
                url: '<?= site_url('disciples_community/ajaxCeStatusWhatsAPP') ?>',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(response) {
                console.log('success');
                if (!response.statusverifikasiwa) {
                    swal('Informasi', 'Silahkan verifikasi nomor WhatsApp anda terlebih dahulu', 'info')
                    .then(function() {
                      //pergi ke halaman baru dalam tab yang sama
                      window.open("<?php echo site_url('akun/ubahprofil') ?>", "_self");                      
                    })
                }else{

                    $.ajax({
                        url: '<?= site_url('disciples_community/ajaxSimpanPermohonan') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {'iddc': iddc},
                    })
                    .done(function(response) {
                        console.log(response);

                        if (response.success) {
                            swal('Berhasil', 'Permohonan untuk bergabung dengan DC berhasil dikirim', 'success')
                            .then(function() {
                                $('#modalInfoDC').modal('hide');                        
                            });
                        }else{
                            swal('Informasi', response.msg, 'info');
                        }
                    })
                    .fail(function() {
                        swal('Informasi', 'Terjadi kesalahan', 'info');
                    });


                }
            })
            .fail(function() {
                console.log('error cekstatusverifikasi wa');
            });
            

            

        })
    </script>
      

      