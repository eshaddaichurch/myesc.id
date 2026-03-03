<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
  @import url(' https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  /* Vars CSS (simulasi SCSS) */
  :root {
    --main-green: #79dd09;
    --main-green-rgb-015: rgba(121, 221, 9, 0.1);
    --main-yellow: #bdbb49;
    --main-yellow-rgb-015: rgba(189, 187, 73, 0.1);
    --main-red: #bd150b;
    --main-red-rgb-015: rgba(189, 21, 11, 0.1);
    --main-blue: #0076bd;
    --main-blue-rgb-015: rgba(0, 118, 189, 0.1);
  }

  /* Breadcrumbs */
  .breadcrumbs {
    padding: 140px 0 60px 0;
    min-height: 30vh;
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin-bottom: 2rem;
  }
  .breadcrumbs::before {
    content: "";
    background-color: rgba(0, 0, 0, 0.6);
    position: absolute;
    inset: 0;
  }
  .breadcrumbs h2 {
    font-size: 56px;
    font-weight: 500;
    color: #fff;
    font-family: sans-serif;
  }
  .breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0 0 10px 0;
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--main-blue);
  }
  .breadcrumbs ol a {
    color: rgba(255, 255, 255, 0.8);
    transition: 0.3s;
  }
  .breadcrumbs ol a:hover {
    text-decoration: underline;
  }
  .breadcrumbs ol li + li {
    padding-left: 10px;
  }
  .breadcrumbs ol li + li::before {
    display: inline-block;
    padding-right: 10px;
    color: #fff;
    content: "/";
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }


/* ================= HERO SECTION ================= */

.generosity-hero {
  position: relative;
  min-height: 100svh; /* paling aman untuk mobile modern */
  width: 100%;
  background: url("<?php echo base_url('myesc.id/assets/gambar/giving.jpg'); ?>") center center no-repeat;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #fff;
  padding: 80px 20px;
}

.generosity-hero {
  min-height: 100vh;
  min-height: 100svh;
}



.generosity-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.65);
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 900px;
  padding: 20px;
  animation: fadeInUp 1s ease;
}

.hero-content h1 {
  font-size: 64px;
  font-weight: 700;
  margin-bottom: 20px;
}

.subtitle {
  font-size: 18px;
  margin-bottom: 15px;
  opacity: 0.9;
}

.choose {
  margin-bottom: 40px;
  font-size: 16px;
  opacity: 0.8;
}

.region-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 16px;
}

.region-btn {
  padding: 14px 30px;
  border: 1px solid #6c757d;
  border-radius: 50px;
  background: transparent;
  color: #fff;
  font-weight: 600;
  letter-spacing: 1px;
  text-decoration: none;
  display: inline-block;
  width: 100%;
  max-width: 320px;
  transition: all 0.3s ease;
}

.region-btn:hover {
  background: #fff;
  color: #000;
  transform: scale(1.05);
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}


@media(max-width:768px){
  .hero-content h1 { 
    font-size: 36px; 
  }

  .subtitle {
    font-size: 15px;
  }

  .choose {
    font-size: 14px;
  }
}

@media(max-width:420px){
  .hero-content h1 { 
    font-size: 30px; 
  }

  .region-btn {
    padding: 12px 20px;
    font-size: 14px;
  }
}
</style>

<body>

<?php $this->load->view('template/festavalive/topmenu'); ?>

<div class="generosity-hero">
  <div class="hero-content">
    <h1>Giving</h1>
    <p class="subtitle">
    Memberi adalah ungkapan syukur,
    <br>ketaatan, dan kasih kepada Tuhan.
    </p>
    <p class="choose">
    Pilih tujuan persembahan Anda di bawah ini.
    </p>

    <div class="region-grid">
      <a href="<?= base_url('persepuluhan'); ?>" class="region-btn">PERSEPULUHAN</a>
      <a href="<?= base_url('pembangunan'); ?>" class="region-btn">PEMBANGUNAN</a>
      <a href="<?= base_url('persembahan_pertama'); ?>" class="region-btn">PERSEMBAHAN PERTAMA</a>
      <a href="<?= base_url('persembahan_kedua'); ?>" class="region-btn">PERSEMBAHAN KEDUA</a>
      <a href="<?= base_url('yayasan_yesaya_58'); ?>" class="region-btn">YAYASAN YESAYA 58</a>
    </div>
  </div>
</div>

<?php $this->load->view('template/festavalive/footer'); ?>

</body>
</html>