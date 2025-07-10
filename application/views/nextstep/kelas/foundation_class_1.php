<?php $this->load->view('template/festavalive/header'); ?>
<body>
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <section class="membership-section">
    <h1>Foundation Class 1</h1>
    <p>Foundation Class 1 Salvation and Baptism (FC 1) adalah kelas dasar yang bertujuan membantu jemaat memahami secara mendalam arti keselamatan dan baptisan...</p>

    <p>Topik Pembelajaran</p>
    <p>1. Keselamatan dalam Kristus ...</p>
    <p>2. Baptisan Air dan Roh Kudus ...</p>
    <p>Kelas ini dikemas secara interaktif dengan diskusi dan tanya jawab...</p>

    <?php if ($this->session->userdata('idjemaat')): ?>
      <?php if ($rsJadwal->num_rows() > 0): ?>
        <form id="formDaftar">
          <input type="hidden" name="idjadwalevent" value="<?= $rsJadwal->row()->idjadwalevent ?>">
          <button type="submit" class="btn-membership">Daftar</button>
        </form>
      <?php else: ?>
        <p><em>Belum ada jadwal kelas tersedia saat ini.</em></p>
      <?php endif; ?>
    <?php else: ?>
      <p><em>Silakan login terlebih dahulu untuk mendaftar ke kelas ini.</em></p>
    <?php endif; ?>
  </section>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('formDaftar');
      if (form) {
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          const formData = new FormData(form);

          fetch("<?= site_url('nextstep/daftar') ?>", {
            method: "POST",
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("✅ Berhasil mendaftar ke kelas.");
              // Optional redirect
              window.location.href = "<?= site_url('nextstep/kelas/') ?>" + data.kelas_slug;
            } else {
              alert("⚠️ " + data.msg);
            }
          })
          .catch(error => {
            console.error("❌ Gagal:", error);
            alert("Terjadi kesalahan saat mengirim data.");
          });
        });
      }
    });
  </script>

  <style>
    body {
      background-color: #e9d6a8;
      font-family: 'Figtree', sans-serif;
      color: #111;
    }
    .membership-section {
      max-width: 900px;
      margin: 0 auto;
      padding: 80px 20px;
    }
    .membership-section h1 {
      font-size: 52px;
      font-weight: 700;
      margin-bottom: 40px;
    }
    .membership-section p {
      margin-bottom: 20px;
      font-size: 18px;
    }
    .btn-membership {
      margin-top: 40px;
      display: inline-block;
      background-color: #000;
      color: #fff;
      padding: 14px 24px;
      text-decoration: none;
      font-weight: 500;
      border-radius: 4px;
      transition: background 0.3s ease;
      cursor: pointer;
      border: none;
    }
    .btn-membership:hover {
      background-color: #333;
    }
  </style>
</body>
