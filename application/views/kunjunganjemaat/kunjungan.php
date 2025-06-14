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

      background-image: url('<?php echo base_url("assets/gambar/kunjungan2.jpg"); ?>');
      height: 80vh;
      background-attachment: fixed;
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

     /* Tambahkan ini untuk tampilan mobile */
     @media (max-width: 768px) {
        .parallax-section h1 {
            font-size: 35px;
        }
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
      font-size: 16px;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto 20px;
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

    /*konseling*/
    .konseling {
    background-color: #033f27;
    padding: 60px 20px;
    }

    .konseling .container {
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 1200px;
    margin: auto;
    gap: 40px;
    flex-wrap: wrap;
    }

    .konseling .image img {
    width: 100%;
    max-width: 500px;
    border-radius: 4px;
    }

    .konseling .text {
    max-width: 500px;
    }

    .konseling h2 {
    font-size: 2rem;
    margin-bottom: 16px;
    color: #000;
    }

    .konseling p {
    font-size: 1.1rem;
    margin-bottom: 24px;
    color: #ffffff;
    }

    .konseling .btn {
    background-color: #000;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    transition: background 0.3s;
    }

    .konseling .btn:hover {
    background-color: #333;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
    .konseling .container {
        flex-direction: column;
        text-align: center;
    }

    .konseling .text {
        max-width: 100%;
    }

    .konseling .btn {
        margin-top: 10px;
    }
    }
    /*kunjugan*/

    .expect-section {
      max-width: 800px;
      margin: auto;
      padding: 40px 20px;
      background-color: #fff;
      font-family: Arial, sans-serif;
    }

    .expect-title {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }

    .expect-accordion {
      background-color: #000;
      color: #fff;
      border-radius: 5px;
      margin-bottom: 15px;
      overflow: hidden;
    }

    .expect-header {
      padding: 20px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .expect-header:hover {
      background-color: #222;
    }

    .expect-arrow {
      transition: transform 0.3s ease;
    }

    .expect-header.active .expect-arrow {
      transform: rotate(180deg);
    }

    .expect-content {
      max-height: 0;
      overflow: hidden;
      background-color: #033f27;
      transition: max-height 0.3s ease, padding 0.3s ease;
      padding: 0 20px;
      color: #fff;
    }

    .expect-content.open {
      padding: 20px;
      max-height: 300px;
    }

  </style>
</head>
<body>

 <!-- Parallax Header -->
  <div class="parallax-section">
    <h1 style="color: #000000;"> Pelayanan Kunjungan Jemaat</h1>
  </div>

 <!-- Konten -->

    


    <section class="konseling">
        <div class="container">
            <div class="dedication-video">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/ZqULgqLXYz8?autoplay=1&mute="
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                        </iframe>
            </div>
          <div class="text">
            <h2 style="color: #ffffff;">Pelayanan Kunjungan Jemaat</h2>
            <p>Pelayanan Kunjungan Jemaat adalah bentuk perhatian dan kasih nyata dari gereja kepada setiap jemaat yang membutuhkan kehadiran rohani secara langsung di tengah situasi kehidupan mereka. Kami percaya bahwa kehadiran dan doa dapat menjadi kekuatan yang nyata bagi setiap orang yang sedang mengalami pergumulan maupun sukacita.</p>
            <a href="<?php echo site_url('kunjunganjemaat/tambah'); ?>" class="btn">Ajukan Kunjungan →</a>
          </div>
        </div>
    </section>

     <section class="expect-section">
        <h2 class="expect-title">KAMI MELAYANI KUNJUNGAN :</h2>
    
        <div class="expect-accordion">
          <div class="expect-header">
            <span>JEMAAT SAKIT</span>
            <span class="expect-arrow">▼</span>
          </div>
          <div class="expect-content">
            <p style="color: #ffffff;">Jemaat yang sedang mengalami sakit, baik di rumah maupun di rumah sakit</p>
          </div>
        </div>
    
        <div class="expect-accordion">
          <div class="expect-header">
            <span>JEMAAT LANSIA</span>
            <span class="expect-arrow">▼</span>
          </div>
          <div class="expect-content">
            <p style="color: #ffffff;">Jemaat lansia yang sudah tidak dapat datang ke Gereja.</p>
          </div>
        </div>
    
        <div class="expect-accordion">
          <div class="expect-header">
            <span>PENGURAPAN RUMAH - TEMPAT USAHA</span>
            <span class="expect-arrow">▼</span>
          </div>
          <div class="expect-content">
            <p style="color: #ffffff;">Pengurapan untuk untuk rumah atau tempat usaha.</p>
          </div>
        </div>

        <div class="expect-accordion">
            <div class="expect-header">
              <span>UCAPAN SYUKUR</span>
              <span class="expect-arrow">▼</span>
            </div>
            <div class="expect-content">
              <p style="color: #ffffff;">Ucapan syukur dalam momen istimewa seperti kelahiran anak, ulang tahun pribadi atau pernikahan.</p>
            </div>
          </div>
    </section>
    
    <script>
    document.querySelectorAll('.expect-header').forEach(header => {
      header.addEventListener('click', () => {
        const content = header.nextElementSibling;
        header.classList.toggle('active');
        content.classList.toggle('open');
      });
    });
  </script>

<?php $this->load->view('template/festavalive/footer'); ?>
