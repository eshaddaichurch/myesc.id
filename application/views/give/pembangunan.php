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
  background: #aaa;
}

/* ================= SECTION ================= */

.giving-wrapper {
  padding: 120px 20px 80px;
}

.giving-container {
  max-width: 1100px;
  margin: auto;
}

.section-title {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 30px;
  color: #111827;
}

/* ================= QR CARD ================= */

.qr-card {
  background: #fff;
  border-radius: 18px;
  padding: 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 50px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.06);
}

.qr-left {
  flex: 0 0 220px;
  display: flex;
  justify-content: center;
}

.qr-left img {
  width: 240px;
  border-radius: 14px;
}

/* RIGHT SIDE (TEXT) */
.qr-right {
  flex: 1;
}
.qr-right h3 {
  font-size: 15px;
  margin-bottom: 15px;
  font-weight: 600;
}

.qr-right p {
  color: #4b5563;
  margin-bottom: 20px;
  line-height: 1.6;
}

.qr-content h3 {
  font-size: 15px;
  margin-bottom: 10px;
}

.qr-content p {
  color: #4b5563;
  margin-bottom: 20px;
}

.btn-orange {
  display: inline-block;
  background: #f97316;
  color: #fff;
  padding: 12px 22px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  margin-bottom: 20px;
  transition: 0.3s;
}

.btn-orange:hover {
  background: #ea580c;
}

/* BADGES */
.badges span {
  display: inline-block;
  background: #f3f4f6;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  margin-right: 8px;
}


/* ================= MOBILE ================= */

@media (max-width: 768px) {
  .qr-card {
    flex-direction: column;
    text-align: center;
    padding: 30px 20px;
  }

  .qr-left {
    flex: unset;
  }

  .qr-left img {
    width: 240px;
  }

  .qr-right {
    width: 100%;
  }
}

/* ================= BANK SECTION ================= */

.bank-title {
  font-size: 15px;
  font-weight: 600;
  margin: 50px 0 20px;
}

.bank-card {
  background: #fff;
  padding: 20px;
  border-radius: 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

.bank-left {
  display: flex;
  align-items: center;
  gap: 15px;
}

.bank-icon {
  width: 45px;
  height: 45px;
  background: #fff7ed;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.rekening {
  font-weight: 600;
  font-size: 18px;
}

.bank-name {
  font-size: 14px;
  color: #6b7280;
}

.badge-bank {
  background: #ff5008;
  color: #fff;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 12px;
  margin-left: 8px;
}

.btn-copy {
  background: #ff5008;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  cursor: pointer;
}

/* ================= CONFIRMATION ================= */

.confirm-box {
  margin-top: 40px;
  padding: 20px;
  background: #fff7ed;
  border: 1px solid #ff5008;
  border-radius: 14px;
}


.confirm-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}


.confirm-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.confirm-box strong {
  font-size: 16px;
}

.confirm-box p {
  margin: 0;
  color: #000;
  line-height: 1.6;
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){
  .qr-card {
    flex-direction: column;
    text-align: center;
  }

  .qr-image img {
    width: 180px;
  }

  .bank-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .btn-copy {
    width: 100%;
  }
}
</style>

<body>

<?php $this->load->view('template/festavalive/topmenu'); ?>

<section class="giving-wrapper">
  <div class="giving-container">

    <h2 class="section-title">Pembangunan</h2>

    <!-- QR SECTION -->
    <div class="qr-card">
    
        <div class="qr-left">
            <img src="<?= base_url('myesc.id/assets/gambar/pembangunan.png'); ?>" alt="QRIS">
        </div>

        <div class="qr-right">
            <h3>Scan untuk Memberi</h3>
            <p>
            Scan kode QRIS menggunakan e-wallet atau mobile banking
            (GoPay, OVO, Dana, LinkAja, atau aplikasi bank lainnya).
            </p>

            <a href="<?= base_url('myesc.id/assets/gambar/pembangunan.png'); ?>" 
            download 
            class="btn-orange">
            Download QR Code
            </a>

            <div class="badges">
            <span>QRIS</span>
            <span>GOPAY</span>
            <span>OVO</span>
            <span>DANA</span>
            </div>
        </div>

    </div>

    <!-- BANK TRANSFER -->
    <h3 class="bank-title">Detail Transfer Bank</h3>

    <div class="bank-card">
      <div class="bank-left">
        <div class="bank-icon">🏦</div>
        <div>
          <div class="rekening">
            7061 4359 5600 <span class="badge-bank">QRIS CIMB</span>
          </div>
          <div class="bank-name">Gereja Bethel Indonesia Jemaat El Shaddai</div>
        </div>
      </div>
      <button class="btn-copy" onclick="copyToClipboard('706143595600')">Copy</button>
    </div>

    <div class="bank-card">
      <div class="bank-left">
        <div class="bank-icon">🏦</div>
        <div>
          <div class="rekening">
            029 227 6115 <span class="badge-bank">BCA</span>
          </div>
          <div class="bank-name">Gereja Bethel Indonesia</div>
        </div>
      </div>
      <button class="btn-copy" onclick="copyToClipboard('0292276115')">Copy</button>
    </div>

   <!-- CONFIRMATION -->
    <div class="confirm-box">
    
    <div class="confirm-header">
        
        <div class="confirm-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="#ff5008" stroke-width="2"/>
            <line x1="12" y1="10" x2="12" y2="16" stroke="#ff5008" stroke-width="2" stroke-linecap="round"/>
            <circle cx="12" cy="7" r="1.5" fill="#ff5008"/>
        </svg>
        </div>

        <strong>Konfirmasi</strong>

    </div>

    <p>
        Jika Saudara ingin mendapatkan bukti transfer dengan nama pengirim,
        khusus untuk Persepuluhan dan Pembangunan, silakan transfer menggunakan
        nomor rekening (bukan scan QR Code).
    </p>

    </div>

  </div>
</section>

<script>
function copyToClipboard(text) {
  navigator.clipboard.writeText(text)
    .then(() => alert("Nomor rekening berhasil disalin"))
    .catch(() => alert("Gagal menyalin"));
}
</script>

<?php $this->load->view('template/festavalive/footer'); ?>

</body>
</html>