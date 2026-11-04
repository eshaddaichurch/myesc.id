<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap');

  :root {
    --pm-primary: #0076bd;
    --pm-primary-soft: rgba(0, 118, 189, 0.08);
    --pm-text: #1f2937;
    --pm-muted: #6b7280;
    --pm-border: #e5e7eb;
    --pm-success: #16a34a;
    --pm-success-soft: #dcfce7;
    --pm-warning: #b45309;
    --pm-warning-soft: #fef3c7;
    --pm-danger: #dc2626;
    --pm-danger-soft: #fee2e2;
    --pm-info: #0284c7;
    --pm-info-soft: #e0f2fe;
  }

  body {
    font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
    background: #f4f6fa;
    color: var(--pm-text);
  }

  .pm-page {
    padding: 110px 0 80px;
    min-height: 100vh;
  }

  .pm-header {
    margin-bottom: 28px;
  }
  .pm-header h2 {
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
  }
  .pm-header p {
    color: var(--pm-muted);
    margin: 0;
    font-size: 15px;
  }

  .pm-alert-wrap:empty { display: none; }

  .pm-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .pm-card {
    background: #fff;
    border: 1px solid var(--pm-border);
    border-left: 4px solid var(--pm-info);
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
    transition: box-shadow 0.25s ease, transform 0.25s ease;
  }
  .pm-card:hover {
    box-shadow: 0 10px 24px rgba(16, 24, 40, 0.08);
    transform: translateY(-2px);
  }
  .pm-card.is-success { border-left-color: var(--pm-success); }
  .pm-card.is-warning { border-left-color: #f59e0b; }
  .pm-card.is-danger  { border-left-color: var(--pm-danger); }

  .pm-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    flex-wrap: wrap;
  }

  .pm-jenis {
    font-size: 17px;
    font-weight: 700;
    color: var(--pm-text);
    display: block;
  }

  .pm-date {
    font-size: 13px;
    color: var(--pm-muted);
    margin-top: 4px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .pm-status {
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 999px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .pm-status.success { background: var(--pm-success-soft); color: var(--pm-success); }
  .pm-status.warning { background: var(--pm-warning-soft); color: var(--pm-warning); }
  .pm-status.danger  { background: var(--pm-danger-soft);  color: var(--pm-danger); }
  .pm-status.info    { background: var(--pm-info-soft);    color: var(--pm-info); }

  .pm-note {
    margin-top: 14px;
    padding: 12px 14px;
    background: #f9fafb;
    border-radius: 10px;
    font-size: 14px;
    color: #374151;
    line-height: 1.5;
  }
  .pm-note strong {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--pm-muted);
    margin-bottom: 4px;
  }

  .pm-actions {
    display: flex;
    gap: 10px;
    margin-top: 16px;
    flex-wrap: wrap;
  }
  .pm-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all 0.2s ease;
  }
  .pm-btn.edit {
    color: var(--pm-primary);
    background: var(--pm-primary-soft);
    border-color: rgba(0, 118, 189, 0.2);
  }
  .pm-btn.edit:hover {
    background: var(--pm-primary);
    color: #fff;
  }
  .pm-btn.delete {
    color: var(--pm-danger);
    background: var(--pm-danger-soft);
    border-color: rgba(220, 38, 38, 0.2);
  }
  .pm-btn.delete:hover {
    background: var(--pm-danger);
    color: #fff;
  }

  .pm-empty {
    background: #fff;
    border: 2px dashed var(--pm-border);
    border-radius: 14px;
    padding: 48px 24px;
    text-align: center;
    color: var(--pm-muted);
  }
  .pm-empty i {
    font-size: 40px;
    color: #cbd5e1;
    margin-bottom: 12px;
  }
  .pm-empty p {
    margin: 0;
    font-size: 15px;
  }

  @media (max-width: 576px) {
    .pm-page { padding-top: 90px; }
    .pm-header h2 { font-size: 24px; }
    .pm-card { padding: 16px; }
    .pm-btn { flex: 1; justify-content: center; }
  }
</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="pm-page">
      <div class="container" style="max-width: 760px;">

        <div class="pm-alert-wrap"><?php echo $this->session->flashdata('pesan'); ?></div>

        <div class="pm-header">
          <h2>Permohonan Saya</h2>
          <p>Pantau status setiap permohonan pelayanan Anda di sini.</p>
        </div>

        <div class="pm-list">
          <?php
          $jenisRoute = array(
              'Permohonan Baptisan' => 'baptisan',
              'Pelayanan Kematian'  => 'kematian',
              'Konseling'           => 'konseling',
              'Kunjungan Jemaat'    => 'kunjunganjemaat',
              'Penyerahan Anak'     => 'penyerahananak',
              'Pelayanan Doa'       => 'permohonandoa',
              'Pernikahan'          => 'pernikahan',
          );

          $iconStatus = array(
              'Disetujui'           => 'fa-check-circle',
              'Permohonan'          => 'fa-clock',
              'Menunggu Konfirmasi' => 'fa-hourglass-half',
          );

          if ($rsPermohonan->num_rows() > 0) {
              foreach ($rsPermohonan->result() as $row) {
                  $status = $row->statuspermohonan;
                  $route  = isset($jenisRoute[$row->jenispermohonan]) ? $jenisRoute[$row->jenispermohonan] : '';

                  // Warna kartu dan badge berdasarkan status
                  if ($status == 'Disetujui') {
                      $cardClass = 'is-success';
                      $pillClass = 'success';
                  } elseif ($status == 'Permohonan' || $status == 'Menunggu Konfirmasi') {
                      $cardClass = 'is-warning';
                      $pillClass = 'warning';
                  } else {
                      $cardClass = 'is-danger';
                      $pillClass = 'danger';
                  }

                  $icon = isset($iconStatus[$status]) ? $iconStatus[$status] : 'fa-info-circle';

                  // Tombol edit dan hapus hanya muncul jika status belum disetujui
                  $btnEdit = '';
                  $btnHapus = '';
                  if ($status != 'Disetujui' && $route != '') {
                      $btnEdit = '<a href="' . site_url($route . '/edit/' . $this->encrypt->encode($row->id)) . '" class="pm-btn edit"><i class="fa fa-pen"></i> Edit</a>';
                      $btnHapus = '<a href="' . site_url($route . '/hapus/' . $this->encrypt->encode($row->id)) . '" class="pm-btn delete btn-hapus"><i class="fa fa-trash"></i> Hapus</a>';
                  }
                  ?>
                  <div class="pm-card <?php echo $cardClass; ?>">
                    <div class="pm-top">
                      <div>
                        <span class="pm-jenis"><?php echo html_escape($row->jenispermohonan); ?></span>
                        <span class="pm-date"><i class="far fa-calendar"></i> <?php echo html_escape($row->tglpermohonan); ?></span>
                      </div>
                      <span class="pm-status <?php echo $pillClass; ?>">
                        <i class="fa <?php echo $icon; ?>"></i>
                        <?php echo html_escape($status); ?>
                      </span>
                    </div>

                    <?php if (!empty($row->keteranganadmin)) { ?>
                      <div class="pm-note">
                        <strong>Catatan dari gereja</strong>
                        <?php echo html_escape($row->keteranganadmin); ?>
                      </div>
                    <?php } ?>

                    <?php if ($btnEdit != '' || $btnHapus != '') { ?>
                      <div class="pm-actions">
                        <?php echo $btnEdit . $btnHapus; ?>
                      </div>
                    <?php } ?>
                  </div>
                  <?php
              }
          } else {
              ?>
              <div class="pm-empty">
                <i class="fa fa-folder-open"></i>
                <p>Belum ada permohonan pelayanan.</p>
              </div>
              <?php
          }
          ?>
        </div>

      </div>
    </section>

    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
      $(document).on('click', '.btn-hapus', function (e) {
        e.preventDefault();
        var link = $(this).attr('href');

        swal({
          title: 'Hapus permohonan?',
          text: 'Permohonan yang dihapus tidak dapat dikembalikan.',
          icon: 'warning',
          buttons: ['Batal', 'Ya, hapus'],
          dangerMode: true,
        }).then(function (willDelete) {
          if (willDelete) {
            document.location.href = link;
          }
        });
      });
    </script>

  </div>
</body>
</html>