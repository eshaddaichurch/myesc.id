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
     * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
        font-family: 'Figtree', sans-serif;
    }

    h1, h2, h3, h4, h5, h6, p, a, span, div, li, strong, em {
            font-family: 'Figtree', sans-serif !important;
    }

    .parallax-section {
      background-image: url('<?php echo base_url("assets/gambar/kedukaan2.jpg"); ?>');
      height: 85vh;
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
            height: 60vh; /* Lebih pendek di layar kecil */
        }
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

    h1, h2 {
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
      font-size: 20px;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto 26px;
    }

    .button {
      display: inline-block;
      padding: 10px 24px;
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
  </style>
</head>
<body>

  <!-- Parallax Header -->
  <div class="parallax-section">
    <h1 style="color: #ffffff;">Pelayanan Kedukaan</h1>
  </div>

 <!-- Konten -->

     <!-- Section: Child Dedication -->
     <div class="section light dedication">
        <div class="dedication-text">
        <p style="color: #ffffff;">
            “Berbahagialah orang yang berdukacita, karena mereka akan dihibur.” 
        </p>
        <blockquote style="color: #ffffff;">
             <br>
            - Matius 5:4
        </blockquote>
        </div>
    
        <div class="dedication-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
  
  

    <section class="section" style="padding: 60px; background-color: #ffffff;">
        <h1 style="color: #000000;">Kami turut berduka cita, atas kepergian orang-orang terkasih dari tengah-tengah kita.</h1> 
        <br>
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <!-- Kolom Kiri -->
        <div style="flex: 1; min-width: 300px;">
            <br>
            <br>

            <p style="color: #000000; font-size: 18px; line-height: 1.6; text-align: justify;">
                Kehilangan orang terkasih adalah salah satu momen paling berat dalam kehidupan. 
                Dalam situasi seperti ini, Gereja rindu untuk menjadi perpanjangan tangan kasih Tuhan dengan hadir, menguatkan, dan mendampingi keluarga yang berduka melalui Pelayanan Kedukaan. 
            </p>

            <p style="color: #000000; font-size: 18px; line-height: 1.6; text-align: justify;">
                Pelayanan ini merupakan bentuk empati dan kepedulian rohani dari gereja kepada jemaat yang sedang berduka, sebagai wujud nyata dari tubuh Kristus yang saling menopang.
            </p>
            
        </div>

        <!-- Kolom Kanan -->
        <div style="flex: 1; min-width: 300px;">
            <br>
            <h3 style="color: #000000;">
                Bentuk Pelayanan Kedukaan
            </h3>
            <br>
            <p style="color: #000000; font-size: 18px; line-height: 1.6; text-align: justify;">
                1. Pelayanan Ibadah Penghiburan <br>
                2. Pelayanan Ibadah Pelepasan Jenazah <br>
                3. Pelayanan Ibadah Pemakaman <br>
            </p>
            <p style="color: #000000; font-size: 18px; line-height: 1.6; text-align: justify;">
                kami dapat membantu saudara untuk menghubungkan antara keluarga yang sedang berduka dengan pihak penyedia layanan seperti peti Jenazah, rumah duka, lahan pemakaman, dan ambulance <b>(Mohon diperhatiakan bahwa gereja hanya berperan sebagai penghubung, bukan penyelenggara atau penyedia layanan secara langsung).</b> 
            </p>
            <p style="color: #000000; font-size: 18px; line-height: 1.6; text-align: justify;">
                Jika ingin dilayani, dapat menghubungi <b>Hotline ESC (Pdp. Yopi) 0855 5000 1187 atau Sdr. Elkana Borneo Purba 0896 5603 8474</b>
            </p>
            
        </div>
    </div>
</section>
    

<?php $this->load->view('template/festavalive/footer'); ?>
