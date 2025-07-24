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

  body {
    font-family: 'Figtree', sans-serif;
    background-color: #e8d5a7;
    margin: 0;
    padding-top: 60px; /* tambahkan untuk menghindari tabrakan dengan navbar */
  }

  .section-title {
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
}

.list-wrapper {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.card-permohonan {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.card-permohonan:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.permohonan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.permohonan-header h4 {
    font-size: 18px;
    margin: 0;
    color: #333;
}

.badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #fff;
}

.badge.disetujui {
    background-color: #28a745;
}
.badge.ditolak {
    background-color: #dc3545;
}
.badge.menunggu {
    background-color: #ffc107;
    color: #333;
}

.date {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 10px;
}

.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    text-decoration: none;
    color: white;
    display: inline-block;
}

.btn-action.edit {
    background-color: #17a2b8;
}

.btn-action.delete {
    background-color: #dc3545;
}

.card-permohonan.empty {
    text-align: center;
    font-style: italic;
    color: #777;
}

html, body {
  height: 100%;
}

.page-wrapper {
  min-height: 100%;
  display: flex;
  flex-direction: column;
}

.section-padding {
  flex: 1; /* agar konten mengisi ruang tersisa */
}


</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="section-padding">
      <div class="container">
      <h2 class="section-title">Permohonan Saya</h2>

        <div class="list-wrapper">
            <?php
            if ($rsPermohonan->num_rows() > 0) {
                foreach ($rsPermohonan->result() as $row) {
                    $btnEdit = '';
                    $btnHapus = '';

                    if ($row->statuspermohonan != 'Disetujui') {
                        switch ($row->jenispermohonan) {
                            case 'Permohonan Baptisan':
                                $btnEdit = '<a href="' . site_url('baptisan/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('baptisan/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Pelayanan Kematian':
                                $btnEdit = '<a href="' . site_url('kematian/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('kematian/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Konseling':
                                $btnEdit = '<a href="' . site_url('konseling/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('konseling/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Kunjungan Jemaat':
                                $btnEdit = '<a href="' . site_url('kunjunganjemaat/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('kunjunganjemaat/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Penyerahan Anak':
                                $btnEdit = '<a href="' . site_url('penyerahananak/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('penyerahananak/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Pelayanan Doa':
                                $btnEdit = '<a href="' . site_url('permohonandoa/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('permohonandoa/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                            case 'Pernikahan':
                                $btnEdit = '<a href="' . site_url('pernikahan/edit/' . $this->encrypt->encode($row->id)) . '" class="btn-action edit"><i class="fa fa-edit"></i> Edit</a>';
                                $btnHapus = '<a href="' . site_url('pernikahan/hapus/' . $this->encrypt->encode($row->id)) . '" class="btn-action delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                                break;
                        }
                    }

                    echo '
                        <div class="card-permohonan">
                            <div class="permohonan-header">
                                <h4>' . $row->jenispermohonan . '</h4>
                                <span class="badge ' . strtolower($row->statuspermohonan) . '">' . $row->statuspermohonan . '</span>
                            </div>
                            <p class="date">Tanggal: ' . $row->tglpermohonan . '</p>
                            <div class="actions">
                                ' . $btnEdit . $btnHapus . '
                            </div>
                        </div>
                    ';
                }
            } else {
                echo '<div class="card-permohonan empty">Belum ada permohonan pelayanan.</div>';
            }
            ?>
        </div>
      </div>
    </section>

    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
        $(document).on('click', '.btn-hapus', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");

            swal({
                title: "Hapus?",
                text: "Apakah anda yakin akan menghapus permohonan ini?",
                icon: "warning",
                buttons: ["Batal", "Ya"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.location.href = link;
                }
            });
        });
    </script>

  </div>
</body>
</html>