<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- AOS animation CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link href="<?php echo base_url('myesc.id/assets/gambar/esc10.png') ?>" rel="icon">
    <title>El Shaddai Church</title>





    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>css/bootstrap-icons.css" rel="stylesheet">

    <link href="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>css/templatemo-festava-live.css" rel="stylesheet">

    <!-- Font Awesome Icons 5.1 -->
    <link rel="stylesheet" href="<?php echo (base_url()) ?>myesc.id/admin/assets/adminlte/plugins/fontawesome-free/css/all.min.css">

    <!-- custom -->
    <link href="<?php echo (base_url()) ?>myesc.id/admin/assets/custom/custom.css" rel="stylesheet" />


    <!-- select2 -->
    <link href="<?php echo (base_url()) ?>myesc.id/admin/assets/select2/css/select2.min.css" rel="stylesheet" />
    <style>
        /*** Navbar ***/


        @media (max-width: 991.98px) {
            .navbar .navbar-nav {
                margin-top: 10px;
                border-top: 1px solid rgba(255, 255, 255, .3);
                background: var(--dark);
            }

            .navbar .navbar-nav .nav-link {
                padding: 5px 0;
            }
        }

        @media (min-width: 992px) {
            .navbar .nav-item .dropdown-menu {
                display: block;
                visibility: hidden;
                top: 100%;
                transform: rotateX(-75deg);
                transform-origin: 0% 0%;
                transition: .5s;
                opacity: 0;
            }

            .navbar .nav-item:hover .dropdown-menu {
                transform: rotateX(0deg);
                visibility: visible;
                transition: .5s;
                opacity: 1;
            }
        }

        .page-content {
            min-height: 500px;
        }


        .select2,
        .select2-search__field,
        .select2-results__option {
            font-size: 1.0em !important;
        }

        .select2-selection__rendered {
            /*line-height: 2em !important;*/
        }

        .select2-container .select2-selection--single {
            height: 2em !important;
            /* height: 40px; */
        }

        .select2-selection__arrow {
            height: 2em !important;
        }

        .form-group>.select2-container {
            width: 100% !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .card-mobile .judul {
            font-size: 20px;
            font-weight: bold;
        }

        .card-mobile .sub-judul {
            font-size: 12px;
            margin-top: -5px;
            margin-bottom: 20px;
        }

        .card-mobile .judul-content {
            font-size: 12px;
            font-weight: bold;
        }

        .card-mobile .isi-content {
            font-size: 12px;
        }

        .card .badge {
            font-size: 0.95rem;
            padding: 0.5em 0.75em;
        }

        .card-title {
            font-size: 1.5rem;
        }

        .promo-title {
            font-weight: bold;
            font-size: 2rem;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: scale(1.01);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background: #fff;
            padding: 20px;
        }

        #btnDaftar {
            transition: all 0.3s ease;
        }

        #btnDaftar:hover {
            transform: translateY(-2px);
            background-color: #218838 !important;
        }

        .col-12:not(:last-child) {
            margin-bottom: 10px;
        }

        .badge-status {
            font-size: 0.8rem;
            margin-left: 10px;
        }
    </style>



    <!-- TemplateMo 583 Festava Live

    https://templatemo.com/tm-583-festava-live -->

</head>