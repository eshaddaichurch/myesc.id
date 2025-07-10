
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



      /* body {
        margin: 0;
        font-family: 'Figtree', sans-serif;
        background-color: #fff;
        color: #444;
      } */

      body {
      margin: 0;
      padding: 0;
      background-color: #e9d6a8;
      font-family: 'Figtree', sans-serif;
      color: #111;
      line-height: 1.7;
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
    }

    .btn-membership:hover {
      background-color: #333;
    }

    @media (max-width: 768px) {
      .membership-section {
        padding: 60px 20px;
      }

      .membership-section h1 {
        font-size: 36px;
      }

      .membership-section p {
        font-size: 16px;
      }
    }

      /*whatiscare*/
    </style>
    </head>

    <body>

      <section class="membership-section">
        <h1>Foundation Class 1</h1>
        <p>Foundation Class 1 Salvation and Baptism (FC 1) adalah kelas dasar yang bertujuan membantu jemaat memahami secara mendalam arti keselamatan dan baptisan, dua aspek penting dalam kehidupan orang beriman. Kelas ini mengajak jemaat untuk mengenal lebih dalam anugerah keselamatan dari Yesus Kristus serta memahami peran baptisan sebagai langkah iman dalam menerima kasih karunia-Nya.</p>
        
        <p>Topik Pembelajaran</p>
        
        <p>1. Keselamatan dalam Kristus Membahas firman Tuhan mengenai keselamatan sebagai anugerah dari Allah, bukan hasil usaha manusia, dengan dasar ayat dari Efesus 2:8-9.</p>
        
        <p>2. Baptisan Air dan Roh Kudus – Memaparkan arti simbolis dan spiritual dari baptisan, sekaligus pentingnya komitmen pribadi dalam menerima baptisan sebagai wujud iman, sesuai Roma 6:3-4 dan Kisah Para Rasul 2:38.</p>
        
        <p>Kelas ini dikemas secara interaktif dengan diskusi dan tanya jawab, memungkinkan setiap jemaat untuk menggali konsep-konsep penting, bertanya, dan berbagi pengalaman guna memperdalam iman. Setelah mengikuti kelas ini, jemaat diharapkan semakin siap melangkah dalam iman dan menerima baptisan sebagai bentuk ketaatan perubahan hidup dalam Kristus.</p>
    
        <!-- <?php if ($rsJadwal->num_rows() > 0): ?>
        <form method="POST" action="<?= site_url('nextstep/daftar') ?>" id="formDaftar">
            <input type="hidden" name="idjadwalevent" value="<?= $rsJadwal->row()->idjadwalevent ?>">
            <button type="submit" class="btn-membership">Daftar</button>
        </form>
        <?php else: ?>
        <p>Belum ada jadwal tersedia untuk kelas ini.</p>
        <?php endif; ?> -->

      </section>

      <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                <h2 class="fw-bold">{{ $rowKelas->namakelas }}</h2>
                <hr class="w-25 mx-auto">
                <p>{!! $rowKelas->deskripsi !!}</p>
                </div>

                <div class="row justify-content-center">
                @forelse ($jadwalList as $jadwal)
                    @php
                    $tglEvent = $jadwal->tglmulai == $jadwal->tglselesai
                        ? \Carbon\Carbon::parse($jadwal->tglmulai)->format('d-m-Y')
                        : \Carbon\Carbon::parse($jadwal->tglmulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($jadwal->tglselesai)->format('d-m-Y');

                    $jamEvent = \Carbon\Carbon::parse($jadwal->tglmulai)->format('H:i') . ' WIB s/d ' . \Carbon\Carbon::parse($jadwal->tglselesai)->format('H:i') . ' WIB';

                    $jumlahPeserta = $jadwal->jumlah_pendaftar . '/' . ($jadwal->jumlahjemaat ?? '∞');
                    $sudahDaftar = $jadwal->sudah_daftar; // true/false
                    @endphp

                    <div class="col-md-6 col-lg-5 mb-5">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <img src="{{ asset('assets/gambar/bgkelas.jpg') }}" class="card-img-top" alt="Banner Event" style="object-fit: cover; height: 220px;">

                        <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-calendar-event me-2"></i> {{ $jadwal->namaevent }}</h5>
                            <span class="badge bg-secondary">Peserta: {!! $jadwal->jumlah_pendaftar == $jadwal->jumlahjemaat ? '<span class="text-danger">'.$jumlahPeserta.'</span>' : $jumlahPeserta !!}</span>
                        </div>

                        <p class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i> {{ $jadwal->lokasievent }}</p>
                        <p class="mb-1"><i class="bi bi-calendar3 me-2"></i> {!! nl2br(e($tglEvent)) !!}</p>
                        <p class="mb-1"><i class="bi bi-clock-fill me-2"></i> {!! nl2br(e($jamEvent)) !!}</p>

                        @if (!$sudahDaftar)
                            <div class="mt-4">
                            <a href="#" class="btn btn-success w-100 btn-daftar" data-id="{{ $jadwal->idjadwalevent }}">Daftar Sekarang</a>
                            </div>
                        @endif
                        </div>

                        @if ($sudahDaftar)
                        <div class="card-footer bg-light">
                            @php
                            $status = $jadwal->statuspendaftaran;
                            $statusClass = match($status) {
                                'Menunggu' => 'warning',
                                'Disetujui' => 'success',
                                'Ditolak' => 'danger',
                                default => 'secondary'
                            };
                            @endphp
                            <div class="alert alert-{{ $statusClass }} mb-0">
                            <strong>Status Pendaftaran:</strong> {{ $status }} <br>
                            @if ($status === 'Menunggu')
                                Mohon tunggu proses konfirmasi dari admin.
                            @elseif ($status === 'Disetujui')
                                Pendaftaran Anda telah <strong>disetujui</strong>. Silakan hadir sesuai jadwal.
                            @elseif ($status === 'Ditolak')
                                Maaf, pendaftaran ditolak. Silakan hubungi admin untuk info lebih lanjut.
                            @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                    <div class="alert alert-info">Belum ada jadwal untuk kelas ini.</div>
                    </div>
                @endforelse
                </div>
            </div>
        </section>

        <script>
        $(document).on('click', '.btn-daftar', function(e) {
            e.preventDefault();
            const idjadwalevent = $(this).data('id');

            swal({
            title: "Daftar Kelas?",
            text: "Anda yakin ingin mendaftar di kelas ini?",
            icon: "warning",
            buttons: ["Batal", "Ya, Daftar"],
            dangerMode: true,
            }).then((willDaftar) => {
            if (willDaftar) {
                $.ajax({
                url: '{{ route("nextstep.daftar") }}',
                type: 'POST',
                data: {
                    idjadwalevent: idjadwalevent,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                    swal("Berhasil!", response.message, "success").then(() => location.reload());
                    } else {
                    swal("Gagal", response.message, "info");
                    }
                },
                error: function() {
                    swal("Gagal", "Terjadi kesalahan saat mendaftar", "error");
                }
                });
            }
            });
        });
        </script>


        <!-- <script>
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
        </script> -->

      <?php $this->load->view('template/festavalive/footer'); ?>