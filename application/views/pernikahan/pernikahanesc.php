<?php
$this->load->view('template/festavalive/header');
?>

<style>
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

  h1, h2 {
    color: #333;
    margin-bottom: 20px;
  }

  p {
    font-size: 17px;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto 20px;
  }

  @media (max-width: 768px) {
    p {
      line-height: 1.8;
      color: #000000;
    }
  }

  /* ---------- Hero / Parallax ---------- */
  .parallax-section {
    background-image: url('<?php echo base_url('myesc.id/assets/gambar/pernikahan1.jpg'); ?>');
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
    letter-spacing: 0.5px;
  }

  @media (max-width: 768px) {
    .parallax-section {
      height: 40vh;
      min-height: 220px;
      /* fixed attachment is unreliable on mobile browsers (esp. iOS Safari) */
      background-attachment: scroll;
    }
  }

  .parallax-divider {
    position: relative;
    height: 320px;
    background-image: url('<?php echo base_url('myesc.id/assets/gambar/bgpernikahan1.jpg'); ?>');
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    text-align: center;
  }

  @media (max-width: 767px) {
    .parallax-divider {
      height: 200px;
      background-attachment: scroll;
    }
  }

  .parallax-divider:before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25);
  }

  .parallax-text-wrapper {
    position: relative;
    padding: 40px 30px;
    border-radius: 10px;
    max-width: 780px;
  }

  @media (min-width: 768px) {
    .parallax-text-wrapper {
      padding: 50px 60px;
    }
  }

  #parallax-text {
    color: #ffffff;
    font-size: 15px;
    text-align: center;
    line-height: 1.7;
    max-width: 100%;
    margin: 0 auto;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
    transition: transform 0.5s ease-out, opacity 0.5s ease-out;
  }

  @media (min-width: 768px) {
    #parallax-text { font-size: 20px; }
  }

  @media (min-width: 1024px) {
    #parallax-text { font-size: 24px; }
  }

  /* ---------- Section: Ajakan / Video ---------- */
  .section {
    padding: 50px 20px;
    text-align: center;
  }

  .section.light { background-color: #fefefe; }

  h2 { font-size: clamp(20px, 3vw, 22px); font-weight: 700; }

  .section.light.dedication {
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
  }

  .dedication-video {
    flex: 1 1 400px;
    max-width: 560px;
    width: 100%;
  }

  /* responsive 16:9 video wrapper instead of a fixed 560x315 iframe */
  .video-frame {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
  }

  .video-frame iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border: none;
  }

  /* ---------- Who is care / Pemberkatan Pernikahan ---------- */
  .who-is-care {
    padding: 60px 20px;
    background: #fff;
  }

  .who-is-care .section-title {
    color: #eaca62;
    text-align: center;
    margin-bottom: 40px;
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: bold;
  }

  .who-is-care .content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
  }

  .image-wrapper {
    flex: 1 1 45%;
    display: flex;
    justify-content: center;
  }

  .dedication-slideshow {
    width: 100%;
    max-width: 560px;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    position: relative;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .dedication-slideshow img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }

  .dedication-slideshow img.active { opacity: 1; }

  .text-wrapper { flex: 1 1 50%; text-align: left; }

  .text-wrapper p {
    font-size: 1rem;
    line-height: 1.6;
    color: #444;
    margin-bottom: 15px;
    max-width: none;
    text-align: left;
  }

  .esc-btn-light {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 25px;
    background: #e04607;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .esc-btn-light:hover {
    background: #c23c05;
    transform: translateY(-1px);
  }

  @media (max-width: 768px) {
    .who-is-care .content { flex-direction: column; text-align: center; }
    .text-wrapper { margin-top: 20px; text-align: center; }
    .text-wrapper p { text-align: center; }
  }

  /* ---------- Itineraries / Accordion ---------- */
  .itineraries {
    max-width: 1100px;
    background-color: #eaca62;
    margin: 40px auto 0;
    padding: 40px;
    border-radius: 12px;
  }

  @media (max-width: 768px) {
    .itineraries {
      padding: 28px 18px;
      margin: 24px 16px 0;
      border-radius: 8px;
    }
  }

  .header { margin-bottom: 24px; }

  .header h1 {
    font-size: clamp(26px, 4vw, 40px);
    font-family: 'Figtree', sans-serif !important;
    color: #2b2b2b;
  }

  .itinerary {
    background-color: #f6f6f6;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: 0.3s;
  }

  .summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    cursor: pointer;
    gap: 12px;
  }

  .summary h2 {
    margin: 0;
    font-size: 18px;
    text-align: left;
  }

  .toggle-icon {
    font-size: 18px;
    flex-shrink: 0;
    transition: transform 0.3s;
  }

  .summary.active .toggle-icon { transform: rotate(180deg); }

  .details {
    display: none;
    padding: 0 20px 20px;
    border-top: 1px solid #ddd;
    background-color: #fff;
    animation: fadeIn 0.3s ease-in-out;
  }

  .details p {
    text-align: left;
    max-width: none;
    margin: 14px 0 0;
    font-size: 15px;
    line-height: 1.6;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .download-btn {
    display: inline-flex;
    align-items: center;
    background-color: #000000;
    color: white;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 14px;
    margin-top: 16px;
    transition: background 0.3s;
  }

  .download-btn:hover { background-color: #b8933f; }
  .download-btn svg { margin-right: 8px; flex-shrink: 0; }

  /* ---------- Scroll reveal ---------- */
  .scroll-animate {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
  }

  .scroll-animate.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<body>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Hero -->
    <div class="parallax-section">
      <h1>Pemberkatan Pernikahan</h1>
    </div>

    <!-- Section: Video Pengantar -->
    <div class="section light dedication">
      <div class="dedication-text">
        <h2 style="color: #eaca62;">Shalom, Saudara terkasih!</h2>
        <p style="text-align: justify;">
          Bagi Saudara yang merindukan untuk menjalani pemberkatan pernikahan di Gereja GBI El Shaddai, kami mengundang Anda untuk menyimak video berikut.
        </p>
        <p style="text-align: justify;">
          Video ini akan membantu menjelaskan proses, persiapan, serta makna mendalam dari pemberkatan pernikahan yang berlaku pada Gereja GBI El Shaddai serta sejalan dengan nilai-nilai Firman Tuhan.
        </p>
      </div>

      <div class="dedication-video">
        <div class="video-frame">
          <iframe src="https://www.youtube.com/embed/DQhiViSMiRs?si=hlzROK2WjXuCIAm3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>

    <!-- Parallax Divider -->
    <div class="parallax-divider">
      <div class="parallax-text-wrapper">
        <p id="parallax-text">
          "Sebab itu laki-laki akan meninggalkan ayahnya dan ibunya dan bersatu dengan isterinya, sehingga keduanya menjadi satu daging."<br>
          - Kejadian 2:24
        </p>
      </div>
    </div>

    <!-- Section: Pemberkatan Pernikahan -->
    <section class="who-is-care">
      <div class="container">
        <h2 class="section-title">Pemberkatan Pernikahan</h2>
        <div class="content">

          <div class="image-wrapper scroll-animate">
            <div class="dedication-slideshow">
              <img src="<?php echo base_url('myesc.id/assets/gambar/marriage2.jpg'); ?>"
                   alt="Pemberkatan Pernikahan" class="active" loading="lazy">
            </div>
          </div>

          <div class="text-wrapper scroll-animate">
            <p>
              Pemberkatan pernikahan adalah upacara rohani di mana sepasang calon suami-istri menyatakan janji setia mereka di hadapan Tuhan dan jemaat.
            </p>
            <p>
              Dalam momen ini, gereja bukan hanya menjadi saksi, tetapi juga mendoakan dan meneguhkan pernikahan sebagai perjanjian kudus yang diberkati Tuhan.
            </p>
            <a href="<?php echo site_url('pernikahan/tambah'); ?>" class="esc-btn-light">
              Ajukan Permohonan &rarr;
            </a>
          </div>

        </div>
      </div>
    </section>

    <!-- Section: Hal yang Perlu Diperhatikan -->
    <section class="itineraries">
      <div class="header">
        <h1>Hal Yang Perlu Diperhatikan</h1>
      </div>

      <div class="itinerary">
        <div class="summary" onclick="toggleDetails(this)">
          <h2>Persyaratan dan Informasi Pemberkatan Nikah</h2>
          <div class="toggle-icon">&#9660;</div>
        </div>
        <div class="details">
          <p><strong>1.</strong> Berkas wajib diserahkan 5 bulan sebelum hari H di receptionist ataupun pada jam kantor gereja.</p>
          <p><strong>2.</strong> Silahkan mendownload file Formulir Pernikahan.</p>
          <p><strong>3.</strong> Formulir akan diterima jika sudah lengkap.</p>
          <p><strong>4.</strong> Silahkan ajukan pemberkatan pernikahan pada tombol Ajukan Permohonan.</p>

          <a href="<?php echo base_url('myesc.id/assets/gambar/formulir.pdf'); ?>" class="download-btn" download>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 16l4-5h-3V4h-2v7H8z"/><path d="M20 18H4v-2h16v2z"/></svg>
            Download Formulir
          </a>
        </div>
      </div>
    </section>

  </main>

  <script>
    window.addEventListener('scroll', function () {
      const parallax = document.querySelector('.parallax-divider');
      const text = document.getElementById('parallax-text');
      const rect = parallax.getBoundingClientRect();

      if (rect.top < window.innerHeight && rect.bottom > 0) {
        const scrollPercent = Math.min(1, Math.max(0, 0 - rect.top / (window.innerHeight * 0.2)));
        const translateY = scrollPercent * 50;
        const opacity = Math.max(0.6, 1 - scrollPercent * 0.8);

        text.style.transform = `translateY(${translateY}px)`;
        text.style.opacity = opacity;
        text.style.visibility = 'visible';
      } else {
        text.style.opacity = 0;
        text.style.visibility = 'hidden';
      }
    });

    function toggleDetails(element) {
      const details = element.nextElementSibling;
      details.style.display = details.style.display === 'block' ? 'none' : 'block';
      element.classList.toggle('active');
    }

    // Slideshow (siap dipakai jika gambar ditambah lebih dari satu)
    const slides = document.querySelectorAll('.dedication-slideshow img');
    if (slides.length > 1) {
      let currentSlide = 0;
      setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
      }, 3000);
    }

    // Scroll reveal
    const scrollElements = document.querySelectorAll('.scroll-animate');
    function handleScrollAnimation() {
      scrollElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
          el.classList.add('visible');
        }
      });
    }
    window.addEventListener('scroll', handleScrollAnimation);
    window.addEventListener('load', handleScrollAnimation);
  </script>

  <?php $this->load->view('template/festavalive/footer'); ?>