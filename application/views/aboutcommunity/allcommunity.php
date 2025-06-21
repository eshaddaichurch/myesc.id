<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

    <main>



        <?php $this->load->view('template/festavalive/topmenu'); ?>



        <style>
            @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
            @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
            $main-green: #79dd09 !default;
            $main-green-rgb-015: rgba(121, 221, 9, 0.1) !default;
            $main-yellow: #bdbb49 !default;
            $main-yellow-rgb-015: rgba(189, 187, 73, 0.1) !default;
            $main-red: #bd150b !default;
            $main-red-rgb-015: rgba(189, 21, 11, 0.1) !default;
            $main-blue: #0076bd !default;
            $main-blue-rgb-015: rgba(0, 118, 189, 0.1) !default;

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

            /* Cards */
            .postcard {
                flex-wrap: wrap;
                display: flex;

                box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
                border-radius: 10px;
                margin: 0 0 4rem 0;
                overflow: hidden;
                position: relative;
                color: #ffffff;

                &.dark {
                    background-color: #18151f;
                }

                &.light {
                    background-color: #e1e5ea;
                }

                .t-dark {
                    color: #18151f;
                }

                a {
                    color: inherit;
                }

                h1,
                .h1 {
                    margin-bottom: 0.5rem;
                    font-weight: 500;
                    line-height: 1.2;
                }

                .small {
                    font-size: 80%;
                }

                .postcard__title {
                    font-size: 1.75rem;
                    padding-left: 10px;
                }

                .postcard__img {
                    max-height: 180px;
                    width: 100%;
                    object-fit: cover;
                    position: relative;
                }

                .postcard__img_link {
                    display: contents;
                }

                .postcard__bar {
                    width: 50px;
                    height: 10px;
                    margin: 10px 0;
                    border-radius: 5px;
                    background-color: #424242;
                    transition: width 0.2s ease;
                }

                .postcard__text {
                    padding: 2.5rem;
                    position: relative;
                    display: flex;
                    flex-direction: column;
                }

                .postcard__preview-txt {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    text-align: left;
                    height: 100%;
                }

                .postcard__tagbox {
                    display: flex;
                    flex-flow: row wrap;
                    font-size: 14px;
                    margin: 20px 0 0 0;
                    padding: 0;
                    justify-content: center;

                    .tag__item {

                        display: inline-block;
                        background: #FAF0E6;
                        border-radius: 3px;
                        padding: 2.5px 10px;
                        margin: 0 5px 5px 0;
                        cursor: default;
                        user-select: none;
                        transition: background-color 0.3s;

                        &:hover {
                            background: #FFD09B;
                        }
                    }
                }

                &:before {
                    content: "";
                    position: abslute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    background-image: linear-gradient(-70deg, #424242, transparent 50%);
                    opacity: 1;
                    border-radius: 10px;
                }

                &:hover .postcard__bar {
                    width: 100px;
                }
            }

            @media screen and (min-width: 769px) {
                .postcard {
                    flex-wrap: inherit;

                    .postcard__title {
                        font-size: 2rem;
                    }

                    .postcard__tagbox {
                        justify-content: start;
                    }

                    .postcard__img {
                        max-width: 300px;
                        max-height: 100%;
                        transition: transform 0.3s ease;
                    }

                    .postcard__text {
                        padding-left: 4rem;
                        width: 100%;

                    }

                    .media.postcard__text:before {
                        content: "";
                        position: absolute;
                        display: block;
                        background: #18151f;
                        top: -20%;
                        height: 130%;
                        width: 55px;
                    }

                    &:hover .postcard__img {
                        transform: scale(1.1);
                    }

                    &:nth-child(2n+1) {
                        flex-direction: row;
                    }

                    &:nth-child(2n+0) {
                        flex-direction: row-reverse;
                    }

                    &:nth-child(2n+1) .postcard__text::before {
                        left: -12px !important;
                        transform: rotate(4deg);
                    }

                    &:nth-child(2n+0) .postcard__text::before {
                        right: -12px !important;
                        transform: rotate(-4deg);
                    }
                }
            }

            @media screen and (min-width: 1024px) {
                .postcard__text {
                    padding: 2rem 3.5rem;
                }

                .postcard__text:before {
                    content: "";
                    position: absolute;
                    display: block;

                    top: -20%;
                    height: 130%;
                    width: 55px;
                }

                .postcard.dark {
                    .postcard__text:before {
                        background: #18151f;
                    }
                }

                .postcard.light {
                    .postcard__text:before {
                        background: #e1e5ea;
                    }
                }
            }
        </style>


        <style>
            @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body,
            html {
                font-family: 'Figtree', sans-serif;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            a,
            span,
            div,
            li,
            strong,
            em {
                font-family: 'Figtree', sans-serif !important;
            }


            .parallax-section h1 {
                font-size: 48px;
                /* background: rgba(0,0,0,0.5); */
                padding: 20px 40px;
                border-radius: 10px;
            }

            body {
                margin: 0;
                font-family: 'Helvetica Neue', sans-serif;
                background-color: #fff;
                color: #444;
            }

            .section {
                padding: 60px 20px;
                text-align: center;
            }

            .section.light {
                background-color: #141414;
            }

            h1,
            h2 {
                color: #333;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 26px;
                font-weight: 700;
            }

            h2 {
                font-size: 22px;
                font-weight: 700;
            }

            p {
                font-size: 16px;
                line-height: 1.6;
                max-width: 800px;
                margin: 0 auto 20px;
            }

            .button {
                display: inline-block;
                padding: 15px 35px;
                border: 1px solid #999;
                border-radius: 24px;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 1px;
                color: #ef5008;
                background-color: transparent;
                transition: all 0.3s ease;
                text-decoration: none;
            }

            @media (max-width: 768px) {
                .button {
                    display: inline-block;
                    padding: 15px 80px;
                    border: 1px solid #999;
                    border-radius: 24px;
                    text-transform: uppercase;
                    font-size: 12px;
                    letter-spacing: 1px;
                    color: #ef5008;
                    background-color: transparent;
                    transition: all 0.3s ease;
                    text-decoration: none;
                }
            }

            .button:hover {
                background-color: #ef5008;
                color: #fff;
            }

            /* Child Dedication Section */
            .section.light.dedication {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 40px;
                padding: 60px 20px;
            }

            .dedication-text {
                flex: 1 1 400px;
                max-width: 600px;
                text-align: left;
            }

            .dedication-text blockquote {
                font-style: italic;
                color: #333;
                margin-top: 20px;
                border-left: 4px solid #ef5008;
                padding-left: 16px;
            }

            .dedication-video {
                flex: 1 1 400px;
                max-width: 560px;
            }

            .dedication-video iframe {
                width: 100%;
                height: 315px;
                border: none;
            }



            /*aboutcommunity*/
            /*aboutcare*/
            .musik-section {
                padding: 60px 20px;
                text-align: center;
                background-color: #ffffff;
            }

            .musik-section h2 {
                font-size: 2.5rem;
                font-weight: bold;
                margin-bottom: 10px;
                color: #ef5008;
            }

            .subjudul {
                font-size: 1.3rem;
                color: #666;
                margin-bottom: 40px;
            }

            .musik-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
            }

            .musik-card {
                overflow: hidden;
                width: 500px;
                background: #f9f9f9;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s ease;
            }

            .musik-card:hover {
                transform: translateY(-5px);
            }

            .musik-card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }

            .musik-content {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                height: 150px;
            }

            .musik-card h3 {
                font-size: 1.2rem;
                font-weight: bold;
                margin: 0 0 20px;
                color: #333;
            }

            .visit-btn {
                padding: 12px 40px;
                border-radius: 30px;
                background-color: transparent;
                border: 2px solid #000000;
                color: #ef5008;
                font-size: 0.9rem;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .visit-btn:hover {
                background-color: #ef5008;
                color: #fff;
            }

            /*aboutcare*/
            /*aboutcommunity*/

            /*whatiscare*/
            .who-is-care {
                background-color: #000000;
                color: #fff;
                padding: 200px 20px;
                text-align: center;
                font-family: 'Helvetica Neue', sans-serif;
            }

            .who-is-care h2 {
                font-size: 2.5rem;
                font-weight: bold;
                margin-bottom: 40px;
                color: #ef5008;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .content {
                display: flex;
                flex-wrap: wrap;
                gap: 40px;
                justify-content: center;
            }

            .left,
            .right {
                flex: 1 1 500px;
                max-width: 600px;
                text-align: left;
            }

            .left p,
            .right p {
                margin-bottom: 20px;
                line-height: 1.8;
                color: #ccc;
            }

            /*whatiscare*/

            .class-cards {
                display: flex;
                flex-wrap: wrap;
                gap: 30px;
                justify-content: center;
            }

            .class-card {
                width: 380px;
                border-radius: 8px;
                overflow: hidden;
                background-color: #f5f5f5;
                display: flex;
                flex-direction: column;
            }

            .card-image {
                height: 400px;
                background-size: cover;
                background-position: center;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Tambahkan ini untuk tampilan mobile */
            @media (max-width: 768px) {
                .card-image {
                    height: 260px;
                    /* Lebih pendek di layar kecil */
                }
            }

            .card-title {
                color: white;
                font-size: 20px;
                font-weight: bold;
                text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
                text-align: center;
            }

            .card-info {
                padding: 20px;
            }

            .class-time {
                font-size: 12px;
                color: #999;
                margin-bottom: 5px;
                text-transform: uppercase;
            }

            .class-name {
                font-size: 15px;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .class-description {
                font-size: 14px;
                color: #333;
                text-align: justify;
            }
        </style>
        </head>

        <body>

            <!-- Parallax Header -->
            <!--<div class="parallax-section">-->
            <!--  <h1 style="color: #fff;">Permohonan Doa</h1>-->
            <!--</div>-->

            <!-- Konten -->

            <section class="who-is-care">
                <div class="container">
                    <h2>Apa Itu Community?</h2>
                    <div class="content">
                        <div class="left">
                            <p>
                                ESC Community adalah wadah komunitas di El Shaddai Church yang dirancang untuk menjawab kebutuhan jemaat sesuai dengan demografi usia dan musim kehidupan yang belum dapat disentuh secara spesifik dalam ibadah umum.
                            <p>
                                Masing-masing komunitas difokuskan untuk membangun pertumbuhan rohani yang relevan, membentuk karakter Kristus, dan memperlengkapi jemaat agar hidup dalam panggilan mereka.
                            </p>
                            <p>
                                Melalui ESC Community, ESC mengaktualisasikan visi: “Membangun Generasi yang Menghidupi Amanat Agung” dengan menciptakan lingkungan komunitas yang membina, mengutus, dan memperlengkapi setiap generasi untuk menjadi murid Kristus yang berdampak.
                            </p>
                        </div>
                        <div class="right">
                            <div class="dedication-video">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/ZqULgqLXYz8?autoplay=1&mute="
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                                </iframe>

                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <section style="padding: 60px; background-color: #ffffff;">
                <div style="text-align: center; margin-bottom: 40px;">
                    <h2 style="font-size: 32px; font-weight: bold; margin-bottom: 10px;">Community</h2>
                    <p style="font-size: 16px; color: #555;">Seluruh Bidang Community</p>
                </div>

                <div class="class-cards">
                    <!-- Card 1 -->
                    <div class="class-card">
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 1.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC KIDS</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->
                            <a href="<?php echo site_url('esckids/index'); ?>" class="button">Visit</a>
                        </div>
                    </div>

                    <div class="class-card">
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 2.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC YOUTH</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->
                            <a href="<?php echo site_url('youth/index'); ?>" class="button">Visit</a>
                        </div>
                    </div>

                    <div class="class-card">
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 5.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC YOUNG ADULT</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->
                            <a href="<?php echo site_url('youngadult/index'); ?>" class="button">Visit</a>
                        </div>
                    </div>

                    <div class="class-card">
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 6.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC WOMEN</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->
                            <a href="<?php echo site_url('escwomen/index'); ?>" class="button">Visit</a>
                        </div>
                    </div>

                    <div class="class-card">
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 3.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC GOLD</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->
                            <a href="<?php echo site_url('baptisan/index'); ?>" class="button">Visit</a>
                        </div>
                    </div>

                    <div class="class-card">
                        <!--<div class="card-image" style="background-image: url('assets/gambar/Artboard\ 4.png');">-->
                        <div class="card-image" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/Artboard\ 4.png'); ?>');">
                            <!-- <div class="card-title">KIDS</div> -->
                        </div>
                        <div class="card-info">
                            <!-- <p class="class-time">SUNDAYS AT 8:00 AM</p>
                    <p class="class-time">SUNDAYS AT 10:30 AM</p>
                    <p class="class-time">SUNDAYS AT 16:00 PM</p> -->
                            <h3 class="class-name">ESC DISCIPLES COMMUNITY</h3>
                            <!-- <p class="class-description">
                        Taught by Dann Farrelly, Deeper Life is a 12-week course exploring our faith and life in a revival culture.
                    </p> -->

                            <a href="<?php echo site_url('disciples_community/index'); ?>" class="button">Visit</a>


                        </div>
                    </div>


                </div>
            </section>

            <?php $this->load->view('template/festavalive/footer'); ?>