<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
$isEdit = !empty($idinfo);
$gambarLama = ($isEdit && !empty($row->gambar)) ? base_url('uploads/info/' . $row->gambar) : '';
?>

<style>
  .if-card { border:1px solid #eef0f4; border-radius:16px; box-shadow:0 2px 14px rgba(20,20,40,.04); overflow:hidden; margin-bottom:20px; }
  .if-card-head { padding:16px 22px; border-bottom:1px solid #f1f3f6; background:#fff; display:flex; align-items:center; gap:10px; }
  .if-card-head .ico { width:32px; height:32px; border-radius:9px; background:#fff1e8; color:#ff5008; display:flex; align-items:center; justify-content:center; }
  .if-card-head h5 { margin:0; font-size:15px; font-weight:700; color:#1c1b1a; }
  .if-card-body { padding:22px; background:#fff; }

  .if-card label.if-lbl { font-weight:600; font-size:13px; color:#3a362f; margin-bottom:6px; }
  .if-card .form-control { border-radius:10px; border:1px solid #e3e6ec; padding:10px 14px; height:auto; }
  .if-card .form-control:focus { border-color:#ff7c42; box-shadow:0 0 0 3px rgba(255,80,8,.12); }

  /* dropzone */
  .if-drop { position:relative; border:2px dashed #ffc9ad; background:#fffaf6; border-radius:14px; padding:26px 16px; text-align:center; transition:all .15s; }
  .if-drop:hover, .if-drop.drag { border-color:#ff5008; background:#fff1e8; }
  .if-drop input[type=file] { position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; }
  .if-drop .big { font-size:30px; color:#ff5008; }
  .if-drop .t1 { font-weight:700; color:#1c1b1a; margin-top:6px; }
  .if-drop .t2 { font-size:12px; color:#8a93a3; }
  .if-file-info { margin-top:10px; font-size:12.5px; }
  .if-msg { display:flex; gap:8px; align-items:flex-start; padding:9px 12px; border-radius:10px; font-size:12.5px; margin-top:8px; }
  .if-msg.ok  { background:#e8f7ee; color:#1a7f45; }
  .if-msg.err { background:#fdecec; color:#b42323; }

  /* panduan ukuran */
  .if-ratio { position:relative; width:100%; aspect-ratio:1200/520; border:2px solid #ff5008; border-radius:12px; background:repeating-linear-gradient(45deg,#fff7f2,#fff7f2 10px,#fff 10px,#fff 20px); display:flex; align-items:center; justify-content:center; }
  .if-ratio .safe { position:absolute; inset:9% 5%; border:1.5px dashed #ff9a6b; border-radius:8px; display:flex; align-items:center; justify-content:center; text-align:center; }
  .if-ratio .safe span { font-size:11px; color:#c2410c; font-weight:600; line-height:1.3; background:rgba(255,255,255,.85); padding:2px 8px; border-radius:6px; }
  .if-ratio .dim { position:absolute; top:-11px; left:14px; background:#ff5008; color:#fff; font-size:11px; font-weight:700; padding:2px 10px; border-radius:999px; }
  .if-rules { list-style:none; margin:16px 0 0; padding:0; }
  .if-rules li { display:flex; gap:10px; font-size:13px; color:#4b5563; padding:7px 0; border-bottom:1px solid #f4f5f8; }
  .if-rules li:last-child { border-bottom:0; }
  .if-rules li i { color:#22a559; margin-top:3px; }
  .if-rules li b { color:#1c1b1a; }
  .if-rules li.no i { color:#ef4444; }

  /* preview tampilan aplikasi */
  .if-phone { background:#f4f7fb; border-radius:14px; padding:18px 0 14px; overflow:hidden; }
  .if-strip { display:flex; gap:6px; padding:0 5.5%; }
  .if-strip .ghost { flex:0 0 4%; border-radius:12px; background:#dfe6f0; }
  .if-strip .main { flex:1 1 auto; aspect-ratio:1200/520; border-radius:12px; overflow:hidden; background:#e8ecf3; display:flex; align-items:center; justify-content:center; color:#9aa3b2; font-size:12px; }
  .if-strip .main img { width:100%; height:100%; object-fit:cover; display:block; }
  .if-dots { display:flex; justify-content:center; gap:6px; margin-top:10px; }
  .if-dots i { width:7px; height:7px; border-radius:50%; background:#d5d9e0; }
  .if-dots i.on { background:#ff5008; }

  .if-btn-save { background:linear-gradient(135deg,#ff5008,#ff7c42); border:0; color:#fff !important; border-radius:10px; padding:10px 26px; font-weight:600; box-shadow:0 4px 12px rgba(255,80,8,.25); }
  .if-btn-save:hover { transform:translateY(-1px); }
  .if-btn-cancel { border-radius:10px; padding:10px 22px; }
</style>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2"><?= $isEdit ? 'Edit' : 'Tambah' ?> Info Terkini</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('infoterkini') ?>">Info Terkini</a></li>
      <li class="breadcrumb-item active"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-12">
    <?php
    $pesan = $this->session->flashdata('pesan');
    if (!empty($pesan)) {
      echo $pesan;
    }
    ?>
  </div>

  <form id="formInfo" action="<?= site_url('infoterkini/simpan') ?>" method="post" enctype="multipart/form-data" class="w-100 d-flex flex-wrap">
    <?php if ($isEdit): ?>
      <input type="hidden" name="idinfo" value="<?= $this->encrypt->encode($idinfo) ?>">
    <?php endif; ?>

    <!-- ========== KOLOM KIRI: FORM ========== -->
    <div class="col-lg-7">

      <div class="card if-card">
        <div class="if-card-head"><span class="ico"><i class="fa fa-image"></i></span><h5>Gambar Banner</h5></div>
        <div class="if-card-body">
          <div class="if-drop" id="dropArea">
            <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?>>
            <div class="big"><i class="fa fa-cloud-upload-alt"></i></div>
            <div class="t1"><?= $isEdit ? 'Klik / seret untuk mengganti gambar' : 'Klik atau seret gambar ke sini' ?></div>
            <div class="t2">JPG, PNG, WEBP &middot; <b>1200 × 520 px</b> &middot; maks. 2 MB</div>
          </div>
          <div id="fileMsg"></div>
          <?php if ($isEdit): ?>
            <small class="form-text text-muted mt-2">Kosongkan jika tidak ingin mengganti gambar.</small>
          <?php endif; ?>
        </div>
      </div>

      <div class="card if-card">
        <div class="if-card-head"><span class="ico"><i class="fa fa-pen"></i></span><h5>Detail Info</h5></div>
        <div class="if-card-body">
          <div class="form-group">
            <label class="if-lbl">Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" maxlength="150" required
              placeholder="Contoh: Ibadah Natal 2026"
              value="<?= html_escape($row->judul ?? '') ?>">
            <small class="form-text text-muted">Hanya untuk penanda admin. Teks yang tampil di aplikasi adalah yang ada di dalam gambar.</small>
          </div>

          <div class="form-group">
            <label class="if-lbl">Subjudul</label>
            <input type="text" name="subjudul" class="form-control" maxlength="150"
              placeholder="Opsional"
              value="<?= html_escape($row->subjudul ?? '') ?>">
          </div>

          <div class="form-group">
            <label class="if-lbl">Link Tujuan (opsional)</label>
            <input type="url" name="urltombol" class="form-control" maxlength="255"
              placeholder="https://..." value="<?= html_escape($row->urltombol ?? '') ?>">
            <small class="form-text text-muted">Jika diisi, banner bisa diketuk di aplikasi dan membuka link ini.</small>
          </div>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label class="if-lbl">Urutan</label>
                <input type="number" name="urutan" class="form-control" min="0" max="9999"
                  value="<?= (int) ($row->urutan ?? 0) ?>">
                <small class="text-muted">Angka kecil tampil lebih dulu.</small>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label class="if-lbl">Status</label>
                <div class="custom-control custom-switch mt-2">
                  <input type="checkbox" class="custom-control-input" id="statusaktif" name="statusaktif" value="1"
                    <?= (!$isEdit || !empty($row->statusaktif)) ? 'checked' : '' ?>>
                  <label class="custom-control-label" for="statusaktif">Tampilkan di aplikasi</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <button type="submit" class="btn if-btn-save"><i class="fa fa-save mr-1"></i> Simpan</button>
        <a href="<?= site_url('infoterkini') ?>" class="btn btn-light if-btn-cancel">Batal</a>
      </div>
    </div>

    <!-- ========== KOLOM KANAN: PANDUAN + PREVIEW ========== -->
    <div class="col-lg-5">

      <div class="card if-card">
        <div class="if-card-head"><span class="ico"><i class="fa fa-ruler-combined"></i></span><h5>Panduan Ukuran Gambar</h5></div>
        <div class="if-card-body">
          <div class="if-ratio">
            <span class="dim">1200 × 520 px</span>
            <div class="safe"><span>Area aman<br>taruh teks &amp; logo di sini</span></div>
          </div>

          <ul class="if-rules">
            <li><i class="fa fa-check-circle"></i><span>Ukuran ideal <b>1200 × 520 px</b> (rasio 2,31 : 1). Ukuran lebih besar dengan rasio sama, mis. 2400 × 1040 px, juga diterima.</span></li>
            <li><i class="fa fa-check-circle"></i><span>Lebar minimal <b>1200 px</b>, maksimal 3000 px.</span></li>
            <li><i class="fa fa-check-circle"></i><span>Format <b>JPG, PNG, atau WEBP</b>, ukuran file maks. <b>2 MB</b>.</span></li>
            <li><i class="fa fa-check-circle"></i><span>Letakkan teks penting di <b>area aman</b> (sisakan ±5% jarak dari tepi) agar tidak terpotong di layar HP.</span></li>
            <li class="no"><i class="fa fa-times-circle"></i><span>Jangan membuat tombol di dalam gambar. Gunakan kolom <b>Link Tujuan</b>.</span></li>
          </ul>
        </div>
      </div>

      <div class="card if-card">
        <div class="if-card-head"><span class="ico"><i class="fa fa-mobile-alt"></i></span><h5>Pratinjau di Aplikasi</h5></div>
        <div class="if-card-body">
          <div class="if-phone">
            <div class="if-strip">
              <div class="ghost"></div>
              <div class="main" id="previewBox">
                <?php if ($gambarLama): ?>
                  <img src="<?= $gambarLama ?>" alt="">
                <?php else: ?>
                  Pilih gambar untuk melihat pratinjau
                <?php endif; ?>
              </div>
              <div class="ghost"></div>
            </div>
            <div class="if-dots"><i></i><i class="on"></i><i></i></div>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>

<?php $this->load->view('template/footer') ?>

<script>
(function () {
  // ===== ATURAN (harus sama dengan konstanta di BerandaScreen.tsx & validasi server) =====
  var RATIO     = 1200 / 520;     // 2.3077
  var TOLERANSI = 0.03;           // +-3% dari rasio ideal
  var MIN_W     = 1200;
  var MAX_W     = 3000;
  var MAX_BYTES = 2 * 1024 * 1024;
  var TIPE_OK   = ['image/jpeg', 'image/png', 'image/webp'];

  var input   = document.getElementById('gambar');
  var msgBox  = document.getElementById('fileMsg');
  var preview = document.getElementById('previewBox');
  var drop    = document.getElementById('dropArea');
  var previewAwal = preview.innerHTML;

  function tampilPesan(tipe, html) {
    msgBox.innerHTML = '<div class="if-msg ' + tipe + '"><i class="fa fa-' +
      (tipe === 'ok' ? 'check-circle' : 'exclamation-circle') + ' mt-1"></i><div>' + html + '</div></div>';
  }

  function tolak(pesan) {
    input.value = '';
    preview.innerHTML = previewAwal;
    tampilPesan('err', pesan);
  }

  input.addEventListener('change', function () {
    msgBox.innerHTML = '';
    var file = input.files && input.files[0];
    if (!file) { preview.innerHTML = previewAwal; return; }

    if (TIPE_OK.indexOf(file.type) === -1) {
      return tolak('Format file tidak didukung. Gunakan <b>JPG, PNG, atau WEBP</b>.');
    }
    if (file.size > MAX_BYTES) {
      return tolak('Ukuran file <b>' + (file.size / 1048576).toFixed(2) + ' MB</b> melebihi batas <b>2 MB</b>.');
    }

    var url = URL.createObjectURL(file);
    var img = new Image();
    img.onload = function () {
      var w = img.naturalWidth, h = img.naturalHeight;
      var rasio = w / h;
      var selisih = Math.abs(rasio - RATIO) / RATIO;

      if (w < MIN_W || w > MAX_W) {
        URL.revokeObjectURL(url);
        return tolak('Lebar gambar <b>' + w + ' px</b> tidak sesuai. Lebar harus antara <b>' + MIN_W + '–' + MAX_W + ' px</b>.');
      }
      if (selisih > TOLERANSI) {
        URL.revokeObjectURL(url);
        return tolak('Rasio gambar <b>' + w + ' × ' + h + ' px</b> (' + rasio.toFixed(2) +
          ' : 1) tidak sesuai. Gunakan <b>1200 × 520 px</b> (2,31 : 1).');
      }

      tampilPesan('ok', 'Gambar sesuai: <b>' + w + ' × ' + h + ' px</b>, ' + (file.size / 1024).toFixed(0) + ' KB.');
      preview.innerHTML = '';
      img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block';
      preview.appendChild(img);
    };
    img.onerror = function () {
      URL.revokeObjectURL(url);
      tolak('File tidak bisa dibaca sebagai gambar.');
    };
    img.src = url;
  });

  ['dragenter', 'dragover'].forEach(function (ev) {
    drop.addEventListener(ev, function () { drop.classList.add('drag'); });
  });
  ['dragleave', 'drop'].forEach(function (ev) {
    drop.addEventListener(ev, function () { drop.classList.remove('drag'); });
  });
})();
</script>

</body>
</html>