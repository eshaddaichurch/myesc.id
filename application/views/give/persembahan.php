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
      body {
      margin: 0;
      font-family: 'Figtree', sans-serif;
      background-color: #e8d5a7;
    }
    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 175vh;
      padding: 1rem;
      box-sizing: border-box;
    }
    .persembahan-container {
      width: 100%;
      max-width: 48rem;
      background-color: #fff;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 1.5rem;
      margin-bottom: 20px;
    }
    .label {
      font-size: 0.875rem;
      font-weight: 800;
      color: #374151;
      margin-bottom: 0.75rem;
      display: block;
    }
    .button-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
      gap: 0.5rem;
      margin-bottom: 2.5rem;
    }
    .btn {
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
    }
    .output-area {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .card {
      background-color: #e8d5a7;
      padding: 5rem;
      border-radius: 5rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      animation: fadeIn 0.5s ease-out;
    }


    @media (max-width: 768px) {
      .card {
      background-color: white;
      padding: 2rem;
      border-radius: 2rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      animation: fadeIn 0.5s ease-out;
    }
    }


    .account-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      width: 100%;
    }
    .account-info {
      flex: 1;
    }
    .account-info h2 {
      font-size: 1.125rem;
      font-weight: bold;
      color: #1f2937;
      margin-bottom: 0.25rem;
    }

    @media (max-width: 768px) {
      .account-info h2 {
        font-size: 15px;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 45px;
      }
    }
    .rekening {
      font-size: 1rem;
      font-weight: 600;
      color: #ea580c;
      margin-right: 0.5rem;
    }
    .copy-btn {
      background-color: #ff8100;
      color: white;
      border: none;
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      border-radius: 0.25rem;
      cursor: pointer;
    }
    .qr {
      margin-left: 2rem;
      flex-shrink: 0;
    }
    .qr img {
      width: 15rem;
      height: 15rem;
      border-radius: 10.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: opacity 0.3s;
    }
    .qr img:hover {
      opacity: 0.8;
    }
    .logos {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(64px, 1fr));
      gap: 1.5rem;
      margin-top: 5rem;
    }
    .logo-box {
      background-color: #f3f4f6;
      padding: 0.75rem;
      border-radius: 100rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .logo-box img {
      width: 80%;
      height: 80%;
      object-fit: contain;
    }
    @media (max-width: 768px) {
      .qr img {
        width: 5rem;
        height: 5rem;
      }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    </style>
    </head>

    <body>

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
  </script>
  <script>
    function tampilkanData(jenis) {
      const data = dataPersembahan[jenis];
      const container = document.getElementById("output");
      const accountHtml = (data.accounts || [data]).map((acc, i) => `
        <div class="card">
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