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
      body {
    font-family: 'Figtree', sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
    background-color: #fff;
    }

    .hero-section {
        /*background: url('/assets/gambar/jesus2.jpg') no-repeat center center/cover;*/
        background: url('<?php echo base_url("myesc.id/assets/gambar/jesus2.jpg"); ?>')no-repeat center center/cover;
        color: white;
        text-align: center;
        padding: 380px 20px;
    }

    .hero-section h1 {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 24px;
    }

    
    .new-beginning-section {
    padding: 80px 20px;
    text-align: center;
    background-color: #eeeeee;
    font-family: 'Figtree', sans-serif;
    }

    @media (max-width: 768px) {
    .new-beginning-section {
        padding: 20px 0px;
        text-align: center;
        background-color: #eeeeee;
        font-family: 'Figtree', sans-serif;
    }
    }

    .new-beginning-section h2 {
        font-family: 'MedievalSharp', cursive;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
    }

    .new-beginning-section .content {
        max-width: 570px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 2.8;
    }

    @media (max-width: 768px) {
        .new-beginning-section .content {
        max-width: 800px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 1.8;
    }
    }

   

    .new-beginning-section em {
        font-style: italic;
        color: #555;
    }

    .new-beginning-section strong {
        font-weight: 600;
        color: #111;
    }

    .new-beginning-section .congrats {
        margin-top: 30px;
        font-style: italic;
        color: #666;
    }

    .new-beginning-section .btn-learn {
        margin-top: 30px;
        display: inline-block;
        background: #4CAF50;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .new-beginning-section .btn-learn:hover {
        background: #388e3c;
    }




    .follow-section {
    padding: 80px 20px;
    text-align: center;
    background-color: #eeeeee;
    font-family: 'Figtree', sans-serif;
    }

    .follow-section h2 {
        font-family: 'MedievalSharp', cursive;
        font-size: 36px;
        font-weight: 700px;
        margin-bottom: 30px;
        color: #333;
    }


    @media (max-width: 768px) {
        .follow-section h2 {
        font-family: 'MedievalSharp', cursive;
        font-size: 24px;
        font-weight: 700px;
        margin-bottom: 30px;
        color: #333;
    }
    }



    .follow-section .content {
        max-width: 800px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 1.8;
    }

    .follow-section em {
        font-style: italic;
        color: #555;
    }

    .follow-section strong {
        font-weight: 600;
        color: #111;
    }

    .follow-section .congrats {
        margin-top: 30px;
        font-style: italic;
        color: #666;
    }

    .follow-section .btn-learn {
        margin-top: 30px;
        display: inline-block;
        background: #4CAF50;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .follow-section .btn-learn:hover {
        background: #388e3c;
    }

    .follow-section {
    padding: 155px;
    }

    @media (max-width: 768px) {
        .follow-section {
        padding: 13px;
        }
    }

    .btn-modern {
    padding: 30px 80px;
    font-family: 'MedievalSharp', cursive;
    background-color: #000000; /* biru indigo */
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    }

    @media (max-width: 768px) {
        .btn-modern {
        padding: 22px 24px;
        font-family: 'MedievalSharp', cursive;
        background-color: #000000; /* biru indigo */
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        }
    }

    /* Efek hover: membesar dan ubah warna */
    .btn-modern:hover {
        background-color: #000000;
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Efek click: sedikit mengecil */
    .btn-modern:active {
        transform: scale(0.98);
    }






    .jesus-section {
    padding: 80px 20px;
    text-align: center;
    background-color: #eeeeee;
    font-family: 'Figtree', sans-serif;
    }

    @media (max-width: 768px) {
    .jesus-section {
        padding: 20px 0px;
        text-align: center;
        background-color: #eeeeee;
        font-family: 'Figtree', sans-serif;
    }
    }

    .jesus-section h2 {
        font-family: 'MedievalSharp', cursive;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
    }

    .jesus-section .content {
        max-width: 800px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 1.8;
    }


    @media (max-width: 768px) {
        .jesus-section .content {
        max-width: 800px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 1.8;
    }
    }
    

    .jesus-section em {
        font-style: italic;
        color: #555;
    }

    .jesus-section strong {
        font-weight: 600;
        color: #111;
    }

    .jesus-section .congrats {
        margin-top: 30px;
        font-style: italic;
        color: #666;
    }

    .jesus-section .btn-learn {
        margin-top: 30px;
        display: inline-block;
        background: #4CAF50;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .jesus-section .btn-learn:hover {
        background: #388e3c;
    }





    
    .parallax-section {
    background-image: url('myesc.id/assets/gambar/paralaxjesus.jpg');
    height: 70vh; /* Default untuk desktop */
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    }

    /* Tambahkan ini untuk tampilan mobile */
    @media (max-width: 768px) {
        .parallax-section {
        background: url('<?php echo base_url("myesc.id/assets/gambar/paralaxjesus.jpg"); ?>')no-repeat center center/cover;
        height: 50vh; /* Default untuk desktop */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        }
    }


    
    .parallax-divider {
    position: relative;
    height: 400px; /* default untuk desktop */
    background: url('<?php echo base_url("myesc.id/assets/gambar/paralaxjesus.jpg"); ?>')no-repeat center center/cover;
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    text-align: center;
    }

    /* Untuk layar kecil seperti handphone */
    @media (max-width: 767px) {
    .parallax-divider {
        height: 150px; /* atau 200px, sesuaikan dengan konten */
        background-attachment: scroll; /* fallback karena background-attachment: fixed sering tidak berfungsi di mobile */
    }
    }


    .parallax-divider p {
    font-size: 19px;
    color: #ffffff; /* putih terang */
    max-width: 70%;
    line-height: 1.6;
    text-align: center;
    left: 15%;
    position: relative;
    transition: transform 0.5s ease-out, opacity 0.5s ease-out;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6); /* bayangan agar teks tetap kontras */
    }

    @media (max-width: 767px) {
        
        .parallax-divider p {
        font-size: 11px;
        color: #ffffff; /* putih terang */
        max-width: 100%;
        line-height: 1.6;
        text-align: center;
        left: 1%;
        position: relative;
        transition: transform 0.5s ease-out, opacity 0.5s ease-out;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6); /* bayangan agar teks tetap kontras */
        }
    }


    .parallax-text-wrapper {
    padding: 100px;
    border-radius: 10px;
    backdrop-filter: blur(10px); /* efek blur untuk kesan modern */
    }

    @media (max-width: 768px) {
        .parallax-text-wrapper {
        padding: 30px;
        border-radius: 10px;
        backdrop-filter: blur(10px); /* efek blur untuk kesan modern */
        }
    }
  </style>
</head>
<body>

 
  
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="content">
            <h1 style="font-size: 6.2rem; margin-bottom: 20px; color: #e79746; font-weight: bold;">YESUS</h1>
            <!-- <p>Sang Juru Selamat Dunia yang Mengubah Segalanya</p> -->
        </div>
    </section>

    <!-- Tentang Yesus -->
    <section class="new-beginning-section">
        <h2>Siapa Itu Yesus?</h2>
        <div class="content">
            <p>Kebenaran yang kekal.
                Penggenapan janji.
                Pribadi  yang lahir untuk memberikan keselamatan.
            </p>
    
            <p><em>Terang yang melenyapkan segala kegelapan.
                Penebus yang ajaib.
                Pribadi yang mati untuk menghapuskan semua dosa.
                </em>
            </p>
    
            <p>Dia lah yang berjalan diatas air.
                Dia lah yang berkata kepada badai, "Diam! Tenanglah!"
                Dia lah yang berjalan di dalam api bersama ku.
            </p>
    
            <p>Dia mengaum seperti singa,
                tapi yang berdarah seperti anak domba.
                Dia membawa kesembuhan di dalam tanganNya.
            </p>
    
            <p>Mesias.
                Juru Selamat ku.
                Nama yang penuh kuasa.
            </p>
    
            <p>Batu karang yang teguh.
                Kota benteng dan perisai ku.
                Penyelamat yang bangkit dan hidup.
            </p>
            
        </div>
    </section>


     <!-- Tentang Yesus -->
<section class="jesus-section">
    <h2>Tentang Yesus</h2>
    <div class="content">
        <p>
            Yesus Kristus adalah pribadi Allah yang mengambil rupa manusia, Mesias yang dijanjikan, dan Juruselamat dunia. Ia lahir sekitar 2.000 tahun yang lalu di kota Betlehem, Yudea, dari seorang perawan bernama Maria, melalui karya Roh Kudus (Matius 1:18–25; Lukas 1:26–38). Kelahiran-Nya digenapi sesuai nubuat dalam Perjanjian Lama, dan menjadi titik awal penggenapan rencana keselamatan Allah bagi umat manusia.
        </p>

        <p>
            Yesus dibesarkan di kota kecil Nazaret, sebagai anak dari Yusuf, seorang tukang kayu. Meskipun hidup dalam kesederhanaan, sejak kecil Yesus menunjukkan hikmat dan kedekatan yang mendalam dengan Allah (Lukas 2:41–52). Ia mulai pelayanan publik-Nya pada usia sekitar 30 tahun, setelah dibaptis oleh Yohanes Pembaptis di Sungai Yordan. Pada saat baptisan-Nya, suara dari surga menyatakan, “Inilah Anak-Ku yang Kukasihi, kepada-Nyalah Aku berkenan” (Matius 3:17), menandai awal pelayanan ilahi-Nya.
        </p>

        <p>
            Selama tiga tahun pelayanan-Nya di bumi, Yesus mengajar tentang kasih, pertobatan, Kerajaan Allah, dan pengampunan dosa. Ia melakukan banyak mujizat menyembuhkan orang sakit, mengusir roh jahat, membangkitkan orang mati, memberi makan ribuan orang dengan makanan yang sedikit, serta berjalan di atas air. Ia menjangkau semua kalangan: orang miskin, berdosa, sakit, bahkan yang tersisih dari masyarakat, dengan penuh belas kasih dan kebenaran.
        </p>

        <p>
            Yesus juga mengajarkan bahwa Ia adalah “Jalan, Kebenaran, dan Hidup” (Yohanes 14:6), dan tidak seorang pun dapat datang kepada Bapa kecuali melalui Dia. Ajaran-Nya membawa harapan, tetapi juga menimbulkan perlawanan dari pemimpin agama Yahudi yang merasa terusik oleh kuasa dan kebenaran-Nya.
        </p>

        <p>
            Pada akhirnya, Yesus disalibkan di Golgota oleh keputusan penguasa Romawi, setelah ditolak oleh bangsanya sendiri. Namun, kematian-Nya bukan kekalahan, melainkan penggenapan dari rencana Allah, Yesus mati sebagai korban yang sempurna untuk menebus dosa manusia (Yesaya 53; 1 Petrus 2:24). Ia menanggung hukuman yang seharusnya kita terima, agar kita dapat menerima pengampunan dan diperdamaikan dengan Allah.
        </p>

        <p>
            Pada hari ketiga setelah kematian-Nya, Yesus bangkit dari antara orang mati. Kebangkitan-Nya adalah bukti nyata bahwa Ia sungguh-sungguh adalah Allah, dan bahwa kuasa dosa dan maut telah dikalahkan. Setelah itu, Ia menampakkan diri kepada banyak orang, termasuk para murid-Nya, selama 40 hari, sebelum terangkat ke surga (Kisah Para Rasul 1:3–9). Ia kini duduk di sebelah kanan Allah Bapa dan akan datang kembali kelak.
        </p>

    </div>
</section>



    <!-- <section class="beginning-section">
        <div class="content">
            <p style="color: #eeeeee; font-size: 24px;">
                Karena begitu besar kasih Allah akan dunia ini  sehingga Ia telah mengaruniakan  Anak-Nya  yang tunggal, supaya setiap orang yang percaya kepadaNya tidak binasa, melainkan beroleh hidup yang kekal.
                <br>
                Yohanes 3:16
            </p>
    
        </div>
    </section> -->

     <!-- PARALLAX DIVIDER -->
     <div class="parallax-divider">
        <div class="parallax-text-wrapper">
          <p id="parallax-text">
            Karena begitu besar kasih Allah akan dunia ini  sehingga Ia telah mengaruniakan  Anak-Nya  yang tunggal, supaya setiap orang yang percaya kepadaNya tidak binasa, melainkan beroleh hidup yang kekal.
            <br>
            Yohanes 3:16
          </p>
        </div>
      </div>
    

    
    <section class="follow-section">
        <div class="content">
            <h2>Langkah Pertama </h2>
             <a href="<?php echo site_url('vidioajakandoa/index'); ?>" class="btn-modern">VISIT -></a>
            <!--<button class="btn-modern">VISIT -></button>-->
        </div>
        </div>
     
    </section>
    
        

<?php $this->load->view('template/festavalive/footer'); ?>
