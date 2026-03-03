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
  background: #fed7aa;
  color: #9a3412;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 12px;
  margin-left: 8px;
}

.btn-copy {
  background: #e5e7eb;
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
  border: 1px solid #fdba74;
  border-radius: 14px;
}

.confirm-box strong {
  display: block;
  margin-bottom: 10px;
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

    <h2 class="section-title">Persembahan Pertama (Diakonia)</h2>

    <!-- QR SECTION -->
    <div class="qr-card">
    
        <div class="qr-left">
            <img src="<?= base_url('myesc.id/assets/gambar/persembahan_diakonia.png'); ?>" alt="QRIS">
        </div>

        <div class="qr-right">
            <h3>Scan untuk Memberi</h3>
            <p>
            Scan kode QRIS menggunakan e-wallet atau mobile banking
            (GoPay, OVO, Dana, LinkAja, atau aplikasi bank lainnya).
            </p>

            <a href="<?= base_url('myesc.id/assets/gambar/persembahan_diakonia.png'); ?>" 
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
            7061 4357 5600 <span class="badge-bank">QRIS CIMB</span>
          </div>
          <div class="bank-name">Gereja Bethel Indonesia Jemaat El Shaddai</div>
        </div>
      </div>
      <button class="btn-copy" onclick="copyToClipboard('706143575600')">Copy</button>
    </div>

    <!-- CONFIRMATION -->
    <div class="confirm-box">
      <strong>Konfirmasi</strong>
      Jika Saudara ingin mendapatkan bukti transfer dengan nama pengirim, Khusus untuk Persepuluhan dan pembangunan,
    silahkan transfer menggunakan nomor rekening(bukan scan QR Code).
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