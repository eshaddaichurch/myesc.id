<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

// Hitung ringkasan sekali saja
$rows = ($rsInfo && $rsInfo->num_rows() > 0) ? $rsInfo->result() : array();
$total = count($rows);
$aktif = 0;
foreach ($rows as $r) {
  if (!empty($r->statusaktif)) $aktif++;
}
$nonaktif = $total - $aktif;
?>

<style>
  .it-stat { display:flex; align-items:center; gap:14px; background:#fff; border:1px solid #eef0f4; border-radius:14px; padding:16px 18px; height:100%; }
  .it-stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
  .it-stat-icon.all  { background:#fff1e8; color:#ff5008; }
  .it-stat-icon.on   { background:#e8f7ee; color:#22a559; }
  .it-stat-icon.off  { background:#f1f3f6; color:#8a93a3; }
  .it-stat-num { font-size:22px; font-weight:700; line-height:1.1; color:#1c1b1a; }
  .it-stat-lbl { font-size:12px; color:#8a93a3; }

  .it-card { border:1px solid #eef0f4; border-radius:16px; box-shadow:0 2px 14px rgba(20,20,40,.04); overflow:hidden; }
  .it-card-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; padding:18px 22px; border-bottom:1px solid #f1f3f6; background:#fff; }
  .it-card-head h5 { margin:0; font-weight:700; color:#1c1b1a; }
  .it-hint { font-size:12px; color:#8a93a3; margin:2px 0 0; }
  .it-hint b { color:#ff5008; }

  .it-btn-add { background:linear-gradient(135deg,#ff5008,#ff7c42); border:0; color:#fff !important; border-radius:10px; padding:9px 18px; font-weight:600; box-shadow:0 4px 12px rgba(255,80,8,.25); }
  .it-btn-add:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(255,80,8,.32); }

  .it-table { margin:0; }
  .it-table thead th { background:#fafbfc; color:#8a93a3; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; border-top:0; border-bottom:1px solid #eef0f4; padding:12px 16px; }
  .it-table td { vertical-align:middle; padding:14px 16px; border-top:1px solid #f4f5f8; }
  .it-table tbody tr:hover { background:#fffaf6; }

  .it-thumb { width:176px; aspect-ratio:1200/520; object-fit:cover; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.12); display:block; background:#f0e6d9; }
  .it-title { font-weight:700; color:#1c1b1a; margin-bottom:2px; }
  .it-sub { font-size:12.5px; color:#6b7280; }
  .it-link { display:inline-flex; align-items:center; gap:5px; margin-top:6px; font-size:11.5px; color:#ff5008; background:#fff1e8; border-radius:999px; padding:2px 10px; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

  .it-order { display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px; border-radius:10px; background:#f1f3f6; font-weight:700; color:#3a362f; }

  .it-status { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600; }
  .it-status::before { content:''; width:7px; height:7px; border-radius:50%; background:currentColor; }
  .it-status.on  { background:#e8f7ee; color:#22a559; }
  .it-status.off { background:#f1f3f6; color:#8a93a3; }

  .it-act { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:10px; border:0; color:#fff !important; margin:0 2px; transition:transform .15s; }
  .it-act:hover { transform:translateY(-2px); text-decoration:none; }
  .it-act.edit   { background:#f5a623; }
  .it-act.toggle { background:#3b82f6; }
  .it-act.del    { background:#ef4444; }

  .it-empty { text-align:center; padding:56px 20px; color:#8a93a3; }
  .it-empty i { font-size:42px; color:#d9dde3; margin-bottom:12px; display:block; }
  .it-empty b { display:block; color:#3a362f; font-size:15px; margin-bottom:4px; }
</style>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Info Terkini</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item active">Info Terkini</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">
    <?php
    $pesan = $this->session->flashdata('pesan');
    if (!empty($pesan)) {
      echo $pesan;
    }
    ?>

    <!-- Ringkasan -->
    <div class="row mb-3">
      <div class="col-md-4 mb-2 mb-md-0">
        <div class="it-stat">
          <div class="it-stat-icon all"><i class="fa fa-images"></i></div>
          <div><div class="it-stat-num"><?= $total ?></div><div class="it-stat-lbl">Total banner</div></div>
        </div>
      </div>
      <div class="col-md-4 mb-2 mb-md-0">
        <div class="it-stat">
          <div class="it-stat-icon on"><i class="fa fa-eye"></i></div>
          <div><div class="it-stat-num"><?= $aktif ?></div><div class="it-stat-lbl">Tampil di aplikasi</div></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="it-stat">
          <div class="it-stat-icon off"><i class="fa fa-eye-slash"></i></div>
          <div><div class="it-stat-num"><?= $nonaktif ?></div><div class="it-stat-lbl">Nonaktif</div></div>
        </div>
      </div>
    </div>

    <div class="card it-card">
      <div class="it-card-head">
        <div>
          <h5>Daftar Banner</h5>
          <p class="it-hint">Ukuran gambar wajib <b>1200 × 520 px</b> (rasio 2,31 : 1), maks. 2 MB.</p>
        </div>
        <a href="<?= site_url('infoterkini/tambah') ?>" class="btn it-btn-add">
          <i class="fa fa-plus mr-1"></i> Tambah Info
        </a>
      </div>

      <div class="table-responsive">
        <table class="table it-table">
          <thead>
            <tr>
              <th width="5%" class="text-center">No</th>
              <th width="22%">Banner</th>
              <th>Judul</th>
              <th width="9%" class="text-center">Urutan</th>
              <th width="12%" class="text-center">Status</th>
              <th width="15%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($total > 0): ?>
              <?php $no = 1; foreach ($rows as $row): ?>
                <?php $enc = $this->encrypt->encode($row->idinfo); ?>
                <tr>
                  <td class="text-center text-muted"><?= $no++ ?></td>
                  <td>
                    <img class="it-thumb" src="<?= base_url('uploads/info/' . $row->gambar) ?>" alt="">
                  </td>
                  <td>
                    <div class="it-title"><?= html_escape($row->judul) ?></div>
                    <?php if (!empty($row->subjudul)): ?>
                      <div class="it-sub"><?= html_escape($row->subjudul) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($row->urltombol)): ?>
                      <span class="it-link" title="<?= html_escape($row->urltombol) ?>">
                        <i class="fa fa-link"></i> <?= html_escape($row->urltombol) ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center"><span class="it-order"><?= (int) $row->urutan ?></span></td>
                  <td class="text-center">
                    <?php if ($row->statusaktif): ?>
                      <span class="it-status on">Aktif</span>
                    <?php else: ?>
                      <span class="it-status off">Nonaktif</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <a href="<?= site_url('infoterkini/edit/' . $enc) ?>" class="it-act edit" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="<?= site_url('infoterkini/toggle/' . $enc) ?>" class="it-act toggle" title="Aktif / nonaktifkan"><i class="fa fa-power-off"></i></a>
                    <a href="<?= site_url('infoterkini/hapus/' . $enc) ?>" class="it-act del btnHapus" title="Hapus"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">
                  <div class="it-empty">
                    <i class="fa fa-inbox"></i>
                    <b>Belum ada info terkini</b>
                    Klik tombol <b style="display:inline;color:#ff5008">Tambah Info</b> untuk membuat banner pertama.
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

<script>
$(document).on('click', '.btnHapus', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title             : 'Hapus info ini?',
    text              : 'Gambar juga akan ikut dihapus.',
    icon              : 'warning',
    showCancelButton  : true,
    confirmButtonColor: '#d33',
    cancelButtonColor : '#6c757d',
    confirmButtonText : 'Ya, hapus!',
    cancelButtonText  : 'Batal',
  }).then(function (result) {
    if (result.isConfirmed) window.location.href = url;
  });
});
</script>

</body>
</html>