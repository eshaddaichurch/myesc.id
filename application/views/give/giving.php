<?php $this->load->view('template/festavalive/header'); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Figtree', sans-serif;
  padding-top: 60px;
}

/* ================= HERO SECTION ================= */

.generosity-hero {
  position: relative;
  min-height: 100svh; /* lebih aman dari 100vh di mobile */
  padding: 80px 20px;
  background: url("<?php echo base_url('myesc.id/assets/gambar/bg-giving.jpg'); ?>") center/cover no-repeat;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #fff;
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
  border: 2px solid #fff;
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
    <h1>Generosity</h1>
    <p class="subtitle">
      Give online quickly, easily and securely using your mobile number or email address.
    </p>
    <p class="choose">
      Please choose where you would like to give.
    </p>

    <div class="region-grid">
      <a href="<?= base_url('persepuluhan'); ?>" class="region-btn">PERSEPULUHAN</a>
      <a href="<?= base_url('pembangunan'); ?>" class="region-btn">PEMBANGUNAN</a>
      <a href="<?= base_url('persembahan'); ?>" class="region-btn">PERSEMBAHAN</a>
    </div>
  </div>
</div>

<?php $this->load->view('template/festavalive/footer'); ?>

</body>
</html>