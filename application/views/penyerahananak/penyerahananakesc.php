<?php
$this->load->view('template/festavalive/header');
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body, html {
    font-family: 'Figtree', sans-serif !important;
    overflow-x: hidden;
    background-color: #fff;
    color: #444;
  }

  h1, h2 { color: #333; margin-bottom: 20px; }

  p {
    font-size: 17px;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto 20px;
  }

  /* ---------- Hero / Parallax ---------- */
  .parallax-section {
    background-image: url('<?php echo base_url('myesc.id/assets/gambar/penyerahan12.jpg'); ?>');
    height: 60vh;
    min-height: 320px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    position: relative;
  }

  .parallax-section:before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
  }

  .parallax-section h1 {
    position: relative;
    font-size: clamp(28px, 5vw, 48px);
    color: #fefefe;
    padding: 0 20px;
    margin: 0;
    font-weight: 700;
  }

  @media (max-width: 768px) {
    .parallax-section {
      height: 40vh;
      min-height: 220px;
      /* fixed attachment lag/patah di mobile browser, terutama iOS Safari */
      background-attachment: scroll;
    }
  }

  /* ---------- Section: Ayat + Video ---------- */
  .section {
    padding: 50px 20px;
    text-align: center;
  }

  .section.dedication {
    background-color: #141414;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .dedication-text {
    flex: 1 1 400px;
    max-width: 600px;
    text-align: left;
    color: #ffffff;
  }

  .dedication-text p { color: #ffffff; max-width: none; text-align: left; }

  .dedication-text blockquote {
    font-style: italic;
    color: #eee;
    margin-top: 12px;
    border-left: 4px solid #ef5008;
    padding-left: 16px;
  }

  .dedication-video {
    flex: 1 1 400px;
    max-width: 560px;
    width: 100%;
  }

  /* wrapper rasio 16:9 responsif, ganti iframe fixed 560x315 */
  .video-frame {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
    border-radius: 8px;
    overflow: hidden;
  }

  .video-frame iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border: none;
  }

  /* ---------- Who is care / Penyerahan Anak ---------- */
  .who-is-care {
    background-color: #ffffff;
    padding: 60px 20px;
    text-align: center;
  }

  .who-is-care h2 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: bold;
    margin-bottom: 40px;
    color: #ef5008;
  }

  .container { max-width: 1200px; margin: 0 auto; }

  .content {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
    align-items: center;
  }

  .left, .right {
    flex: 1 1 500px;
    max-width: 560px;
    text-align: left;
  }

  .left p {
    margin-bottom: 20px;
    line-height: 1.8;
    color: #000000;
    max-width: none;
  }

  /* slideshow responsif, tidak lagi lebar/tinggi fix piksel */
  .dedication-slideshow {
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    position: relative;
    border-radius: 8px;
  }

  .dedication-slideshow img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
  }

  .dedication-slideshow img.active { opacity: 1; }

  .button {
    display: inline-block;
    padding: 12px 26px;
    border: 1px solid #999;
    border-radius: 24px;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
    color: #ef5008;
    background-color: transparent;
    transition: all 0.3s ease;
    text-decoration: none;
    margin-top: 10px;
  }

  .button:hover {
    background-color: #ef5008;
    color: #fff;
  }

  @media (max-width: 768px) {
    .content { flex-direction: column; }
    .left, .right {
      flex: 1 1 auto;
      width: 100%;
      max-width: 100%;
      text-align: center;
    }
    .left p { text-align: center; }
  }
</style>

<body>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Hero -->
    <div class="parallax-section">
      <h1>Penyerahan Anak</h1>
    </div>

    <!-- Section: Ayat + Video -->
    <div class="section dedication">
      <div class="dedication-text">
        <p>
          "Tetapi Yesus berkata: 'Biarkanlah anak-anak itu, janganlah menghalang-halangi mereka datang kepada-Ku; sebab orang-orang yang seperti itulah yang empunya Kerajaan Sorga.'"
        </p>
        <blockquote>
          - Matius 19:14
        </blockquote>
      </div>

      <div class="dedication-video">
        <div class="video-frame">
          <iframe src="https://www.youtube.com/embed/g0N-dWoVk5w?si=YxC7UMTjI71E-DGN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>

    <!-- Section: Penyerahan Anak -->
    <section class="who-is-care">
      <div class="container">
        <h2>Penyerahan Anak</h2>
        <div class="content">

          <div class="right">
            <div class="dedication-slideshow">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan11.jpg'); ?>" class="slide active" alt="Penyerahan Anak">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan12.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan10.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan9.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan8.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan7.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
              <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan.jpg'); ?>" class="slide" alt="Penyerahan Anak" loading="lazy">
            </div>
          </div>

          <div class="left">
            <p>
              GBI El Shaddai tidak mempraktikkan baptisan terhadap anak-anak yang masih kecil, melainkan menyerahkan mereka kepada Tuhan dalam sebuah upacara khusus sebagai bentuk iman dan dedikasi rohani orang tua kepada Allah.
            </p>
            <p>
              Anak-anak dapat diserahkan kepada Tuhan mulai usia delapan hari hingga dua belas tahun, sebagaimana dicatat dalam Lukas 2:21-52.
            </p>
            <a href="<?php echo site_url('penyerahananak/tambah'); ?>" class="button">Ajukan Permohonan</a>
          </div>

        </div>
      </div>
    </section>

  </main>

  <script>
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    if (slides.length > 1) {
      setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
      }, 2500);
    }
  </script>

  <?php $this->load->view('template/festavalive/footer'); ?>