<?php 
use PhpParser\Node\Stmt\Echo_; 
$this->load->view('template/festavalive/header'); 
?>

<body>

  <main>
    <!-- Navbar -->
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Tambahkan style fix navbar -->
    <style>
      .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
      }
      main {
        padding-top: 80px; /* sesuaikan tinggi navbar */
      }
    </style>


<style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #fafafa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6, p, a, span, div, li, strong, em {
            font-family: 'Figtree', sans-serif !important;
        }


            .parallax-section h1 {
                font-size: 48px;
                /* background: rgba(0,0,0,0.5); */
                padding: 20px 40px;
                border-radius: 10px;
            }

            /* body {
                margin: 0;
                font-family: 'Helvetica Neue', sans-serif;
                background-color: #fff;
                color: #444;
            } */

            /* .section {
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
            } */

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
                border-radius: 12px;
                width: 300px;
                text-align: center;
            }

            .musik-card img {
                width: 100%;
                margin-bottom: 15px;
            }

            @media (max-width: 768px) {
                
                .musik-card img {
                width: 80%;
                margin-bottom: 15px;
                }

            }

            .musik-card h3 {
                font-size: 1.2rem;
                font-weight: bold;
                margin: 10px 0 10px;
            }

            .musik-card p {
                font-size: 0.95rem;
                color: #555;
                margin-bottom: 15px;
            }

            .musik-card button {
                border: 1px solid #ccc;
                padding: 15px 70px;
                border-radius: 30px;
                background: transparent;
                font-weight: bold;
                color: #555;
                cursor: pointer;
                transition: all 0.3s;
            }

            .musik-card button:hover {
                background-color: #ef5008;
                color: white;
                border-color: #555;
            }

            /*aboutcommunity*/

            /*whatiscare*/
            .who-is-care {
                background-color: #1c1c1c;
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

            
        </style>
        <!-- </head>

        <body> -->

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
            </p>
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
                title="YouTube video player" frameborder="0"
                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="musik-section">
      <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 32px; font-weight: bold; color:#ef5008; margin-bottom: 10px;">Community</h2>
        <p style="font-size: 16px; color: #555;">Seluruh bidang community</p>
      </div>
      <div class="musik-container">

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids.png'); ?>" alt="ESC Kids">
          <h3>ESC KIDS</h3>
          <a href="<?= site_url('esckids/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/youth.png'); ?>" alt="ESC Youth">
          <h3>ESC YOUTH</h3>
          <a href="<?= site_url('youth/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/ya.png'); ?>" alt="ESC Young Adult">
          <h3>ESC YOUNG ADULT</h3>
          <a href="<?= site_url('youngadult/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/women.png'); ?>" alt="ESC Women">
          <h3>ESC WOMEN</h3>
          <a href="<?= site_url('escwomen/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/gold.png'); ?>" alt="ESC Gold">
          <h3>ESC GOLD</h3>
          <a href="<?= site_url('gold/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

        <div class="musik-card">
          <img src="<?php echo base_url('myesc.id/assets/gambar/dc.png'); ?>" alt="ESC Disciples Community">
          <h3>ESC DISCIPLES COMMUNITY</h3>
          <a href="<?= site_url('disciples_community/index') ?>">
            <button type="button">Selengkapnya</button>
          </a>
        </div>

      </div>
    </section>

    <!-- ========== Konten Selesai ========== -->

    <?php $this->load->view('template/festavalive/footer'); ?>
  </main>

</body>
</html>