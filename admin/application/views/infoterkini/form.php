<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
$isEdit = !empty($idinfo);
$aturan = info_aturan_gambar();
?>

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
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <?php
        $pesan = $this->session->flashdata('pesan');
        if (!empty($pesan)) {
          echo $pesan;
        }
        ?>

        <form action="<?= site_url('infoterkini/simpan') ?>" method="post" enctype="multipart/form-data">
          <?php if ($isEdit): ?>
            <input type="hidden" name="idinfo" value="<?= $this->encrypt->encode($idinfo) ?>">
          <?php endif; ?>

          <div class="form-group">
            <label>Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" maxlength="150" required
              value="<?= html_escape($row->judul ?? '') ?>">
          </div>

          <div class="form-group">
            <label>Subjudul</label>
            <input type="text" name="subjudul" class="form-control" maxlength="150"
              value="<?= html_escape($row->subjudul ?? '') ?>">
          </div>

          <div class="form-group">
            <label>Gambar <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
            <?php if ($isEdit && !empty($row->gambar)): ?>
              <div class="mb-2">
                <img src="<?= base_url('uploads/info/' . $row->gambar) ?>" alt=""
                  style="width:240px;height:120px;object-fit:cover;border-radius:10px;">
              </div>
            <?php endif; ?>
            <input type="file" name="gambar" class="form-control-file"
              accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?>>

            <div class="alert alert-info mt-2 mb-0 py-2 px-3" style="font-size:13px;">
              <strong>Aturan gambar:</strong><br>
              Ukuran rekomendasi <b><?= $aturan['rekomendasi'] ?></b>.<br>
              Lebar <?= $aturan['lebar_min'] ?>-<?= $aturan['lebar_maks'] ?> px,
              tinggi <?= $aturan['tinggi_min'] ?>-<?= $aturan['tinggi_maks'] ?> px,
              format <?= $aturan['format'] ?>, maksimal <?= $aturan['maks_teks'] ?>.<br>
              Gambar ditampilkan sebagai kartu lebar di aplikasi, jadi bagian tepi bisa terpotong.
              Letakkan objek penting di tengah.
              <?= $isEdit ? '<br>Kosongkan jika tidak ingin mengganti gambar.' : '' ?>
            </div>
          </div>

          <div class="form-group">
            <label>Link Tombol (opsional)</label>
            <input type="url" name="urltombol" class="form-control" maxlength="255"
              placeholder="https://..." value="<?= html_escape($row->urltombol ?? '') ?>">
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" min="0" max="9999"
                  value="<?= (int) ($row->urutan ?? 0) ?>">
                <small class="text-muted">Angka kecil tampil lebih dulu.</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>&nbsp;</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="statusaktif" name="statusaktif" value="1"
                    <?= (!$isEdit || !empty($row->statusaktif)) ? 'checked' : '' ?>>
                  <label class="custom-control-label" for="statusaktif">Tampilkan di aplikasi</label>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan
          </button>
          <a href="<?= site_url('infoterkini') ?>" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

</body>
</html>