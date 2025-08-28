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

  /* body {
    font-family: 'Figtree', sans-serif;
   
    background: linear-gradient(135deg, #fffaf5, #ffe5b4);
    margin: 0;
    padding-top: 60px;
  } */

  body {
    font-family: 'Figtree', sans-serif;
    background: linear-gradient(63deg, #fffaf5, #ffb347);
    margin: 0;
    padding-top: 60px; /* biar tidak tabrakan sama navbar */
    min-height: 100vh;
  }


  .wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem 1rem 5rem;
    min-height: 100vh;
  }

  .persembahan-container {
    width: 100%;
    max-width: 48rem;
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 1.5rem 1.5rem 2rem;
    margin-bottom: 100px;
    transition: all 0.3s ease-in-out;
  }

  /* .label {
    font-size: 0.875rem;
    font-weight: 800;
    color: #374151;
    margin-bottom: 0.75rem;
  } */

  .label {
    font-size: 1rem;
    font-weight: 700;
    color: #ff5722;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .button-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.5rem;
    margin-bottom: 2.5rem;
  }

  /* .btn {
    background-color: #ff8100;
    color: white;
    padding: 0.5rem;
    border: none;
    border-radius: 1.5rem;
    font-weight: 200;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .btn:hover {
    background-color: #e46f00;
  } */

  .btn {
    background: linear-gradient(90deg, #ff9800, #ff5722);
    color: white;
    padding: 1.6rem 0rem;
    border: none;
    border-radius: 9999px;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.2s ease, opacity 0.2s ease;
  }
  .btn:hover {
    transform: scale(1.05);
    opacity: 0.9;
  }

  .output-area {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-top: 20px;
    transition: all 0.3s ease-in-out;
    min-height: auto;
  }

  /* .card {
    background-color: #e8d5a7;
    padding: 2rem;
    border-radius: 2rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-out;
  } */

  .card {
    background: #fff;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transition: transform 0.2s ease-in-out;
  }
  .card:hover {
    transform: translateY(-4px);
  }


  @media (max-width: 768px) {
    .card {
      padding: 1.5rem;
      border-radius: 1.5rem;
      background-color: #fff;
    }
  }

  .account-header {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
  }

  .account-info {
    flex: 1;
  }

  /* .account-info h2 {
    font-size: 1.125rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 0.25rem;
  } */

  .account-info h2 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
  }

  @media (max-width: 768px) {
    .account-info h2 {
      font-size: 15px;
      margin-bottom: 45px;
    }
  }

  /* .rekening {
    font-size: 1rem;
    font-weight: 600;
    color: #ea580c;
    margin-right: 0.5rem;
  } */

  .rekening {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff5722;
  }

  /* .copy-btn {
    background: #e0e0e0;
    border: none;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    margin-left: 10px;
  } */

  .copy-btn {
    background: #ff9800;
    color: #fff;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.85rem;
    transition: background 0.3s;
  }
  .copy-btn:hover {
    background: #e46f00;
  }

  .qr {
    margin-left: 2rem;
    flex-shrink: 0;
  }

  /* .qr img {
    width: 15rem;
    height: 15rem;
    border-radius: 10.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: opacity 0.3s;
    max-width: 100%;
  }

  .qr img:hover {
    opacity: 0.8;
  } */

  .qr img {
    width: 12rem;
    height: 12rem;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
  }
  .qr img:hover {
    transform: scale(1.05);
  }


  @media (max-width: 768px) {
    .qr img {
      width: 5rem;
      height: 5rem;
    }
  }

  .logos {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 1.5rem;
  }

  /* .logo-box {
    background-color: #f3f4f6;
    padding: 0.75rem;
    border-radius: 100rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  } */

  .logo-box {
    background: #fff;
    padding: 0.75rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
  }
  .logo-box:hover {
    transform: scale(1.1);
  }


  .logo-box img {
    width: 40px;
    height: auto;
    object-fit: contain;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<style>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-in-card {
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
  }

  /* Delay tiap card biar muncul bertahap */
  .fade-in-card:nth-child(1) {
    animation-delay: 0.2s;
  }
  .fade-in-card:nth-child(2) {
    animation-delay: 0.4s;
  }
  .fade-in-card:nth-child(3) {
    animation-delay: 0.6s;
  }
</style>


<body>
  
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <div class="wrapper">
      <div class="persembahan-container">
        <label class="label">Pilih Jenis Persembahan</label>
        <div class="button-grid">
          <button class="btn" onclick="tampilkanData('persepuluhan')">Persepuluhan</button>
          <button class="btn" onclick="tampilkanData('pembangunan')">Pembangunan</button>
          <button class="btn" onclick="tampilkanData('persembahan')">Persembahan</button>
        </div>
        <div id="output" class="output-area"></div>
      </div>
    </div>

    <script>
      const baseImage = "<?php echo base_url('myesc.id/assets/gambar/'); ?>";
      const dataPersembahan = {
        persepuluhan: {
          title: "ESC PERSEPULUHAN",
          bank: "Persembahan Persepuluhan",
          namaqr: "QRIS CIMB",
          akunbank: "Gereja Bethel Indonesia Jemaat El Shaddai",
          rekening: "7061 4361 6500",
          namaqrbca: "BCA",
          akunbankbca: "Gereja Bethel Indonesia",
          rekeningbca: "029 227 6611",
          qrcode: baseImage + "perpuluhan.png",
          metode: [
            { nama: "BCA", logo: baseImage + "bca.png" },
            { nama: "OVO", logo: baseImage + "ovo.png" },
            { nama: "DANA", logo: baseImage + "dana.png" },
            { nama: "Gopay", logo: baseImage + "gopay.png" },
            { nama: "LinkAja", logo: baseImage + "linkaja.png" },
            { nama: "ShopeePay", logo: baseImage + "shopeepay.png" }
          ]
        },
        pembangunan: {
          title: "ESC PEMBANGUNAN",
          bank: "Persembahan Pembangunan",
          namaqr: "QRIS CIMB",
          akunbank: "Gereja Bethel Indonesia Jemaat El Shaddai",
          rekening: "7061 4359 5600",
          namaqrbca: "BCA",
          akunbankbca: "Gereja Bethel Indonesia",
          rekeningbca: "029 227 6115",
          qrcode: baseImage + "pembangunan.png",
          metode: [
            { nama: "BCA", logo: baseImage + "bca.png" },
            { nama: "OVO", logo: baseImage + "ovo.png" },
            { nama: "DANA", logo: baseImage + "dana.png" },
            { nama: "Gopay", logo: baseImage + "gopay.png" },
            { nama: "LinkAja", logo: baseImage + "linkaja.png" },
            { nama: "ShopeePay", logo: baseImage + "shopeepay.png" }
          ]
        },
        persembahan: {
          title: "PERSEMBAHAN",
          accounts: [
            {
              bank: "Persembahan Pertama (Diakonia)",
              namaqr: "QRIS CIMB",
              akunbank: "Gereja Bethel Indonesia Jemaat EL Shaddai",
              rekening: "7061 4357 5600",
              qrcode: baseImage + "persembahan_diakonia.png"
            },
            {
              bank: "Persembahan Kedua (Umum)",
              namaqr: "QRIS CIMB",
              akunbank: "Gereja Bethel Indonesia Jemaat EL Shaddai",
              rekening: "7060 1517 0700",
              qrcode: baseImage + "persembahan_umum.png"
            }
          ],
          metode: [
            { nama: "BCA", logo: baseImage + "bca.png" },
            { nama: "OVO", logo: baseImage + "ovo.png" },
            { nama: "DANA", logo: baseImage + "dana.png" },
            { nama: "Gopay", logo: baseImage + "gopay.png" },
            { nama: "LinkAja", logo: baseImage + "linkaja.png" },
            { nama: "ShopeePay", logo: baseImage + "shopeepay.png" }
          ]
        }
      };

      function tampilkanData(jenis) {
        const data = dataPersembahan[jenis];
        const container = document.getElementById("output");
        const accountHtml = (data.accounts || [data]).map((acc, i) => `
          <div class="card fade-in-card">
            <div class="account-header">
              <div class="account-info">
                <h2>${acc.bank}</h2>
                ${acc.namaqr || acc.akunbank ? `<div><b>${acc.namaqr || ''}</b><br>${acc.akunbank || ''}</div>` : ''}
                <div><span class="rekening">${acc.rekening}</span>
                <button class="copy-btn" onclick="copyToClipboard('${acc.rekening.replace(/'/g, "\\'")}')">Salin</button></div>
              </div>
              <div class="qr">
                <a href="${acc.qrcode}" download title="Unduh QR Code">
                  <img src="${acc.qrcode}" alt="QR Code">
                </a>
              </div>
            </div>
            ${jenis === 'persepuluhan' && i === 0 ? `
              <div class="account-info" style="margin-top: 1rem;">
                <div><b>${data.namaqrbca}</b><br>${data.akunbankbca}</div>
                <div><span class="rekening">${data.rekeningbca}</span>
                <button class="copy-btn" onclick="copyToClipboard('${data.rekeningbca.replace(/'/g, "\\'")}')">Salin</button></div>
              </div>` : ''}
            ${data.metode ? `
            <div class="logos">
              ${data.metode.map(m => `
                <div class="logo-box">
                  <img src="${m.logo}" alt="${m.nama}">
                </div>`).join('')}
            </div>` : ''}
          </div>
        `).join("");
        container.innerHTML = `<h2 style="font-size: 15px; font-weight: bold; color: #374151; margin-bottom: 10px;">${data.title}</h2>${accountHtml}`;
      }

      function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
          .then(() => alert("Nomor rekening telah disalin ke clipboard."))
          .catch(() => alert("Gagal menyalin nomor rekening."));
      }

      tampilkanData('persepuluhan');
    </script>
  
  <?php $this->load->view('template/festavalive/footer'); ?>
</body>
</html>