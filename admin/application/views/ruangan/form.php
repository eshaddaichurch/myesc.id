<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

$isEdit = ($idruangan != '');
$rowData = $isEdit ? $this->Ruangan_model->get_by_id($idruangan)->row() : null;
$fotoSrc = base_url('images/nofoto.png');
if ($isEdit && !empty($rowData->foto)) {
    $fotoSrc = base_url('uploads/ruangan/' . $rowData->foto);
}
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2"><?= $isEdit ? 'Edit' : 'Tambah' ?> Ruangan</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('ruangan') ?>">Master Ruangan</a></li>
      <li class="breadcrumb-item active"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">
          <i class="fa fa-door-open"></i>
          <?= $isEdit ? 'Edit Data Ruangan' : 'Form Tambah Ruangan' ?>
        </h5>
      </div>
      <div class="card-body">
        <form action="<?= site_url('ruangan/simpan') ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="idruangan" value="<?= $isEdit ? $rowData->idruangan : '' ?>">

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Nama Ruangan <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" name="namaruangan" id="namaruangan" class="form-control"
                value="<?= $isEdit ? $rowData->namaruangan : '' ?>"
                placeholder="Contoh: Ruangan A" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Kapasitas</label>
            <div class="col-md-4">
              <div class="input-group">
                <input type="number" name="kapasitas" id="kapasitas" class="form-control"
                  value="<?= $isEdit ? $rowData->kapasitas : '0' ?>" min="0">
                <div class="input-group-append">
                  <span class="input-group-text">Orang</span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Lokasi / Lantai</label>
            <div class="col-md-9">
              <input type="text" name="lokasi" id="lokasi" class="form-control"
                value="<?= $isEdit ? $rowData->lokasi : '' ?>"
                placeholder="Contoh: Lantai 1, Gedung Utara">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Fasilitas</label>
            <div class="col-md-9">
              <input type="text" name="fasilitas" id="fasilitas" class="form-control"
                value="<?= $isEdit ? $rowData->fasilitas : '' ?>"
                placeholder="Contoh: AC, Proyektor, Whiteboard">
              <small class="text-muted">Pisahkan dengan koma ( , )</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Keterangan</label>
            <div class="col-md-9">
              <textarea name="keterangan" class="form-control" rows="3"
                placeholder="Keterangan tambahan..."><?= $isEdit ? $rowData->keterangan : '' ?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Foto Ruangan</label>
            <div class="col-md-9">
              <div class="mb-2">
                <img id="previewFoto" src="<?= $fotoSrc ?>" class="rounded border"
                  style="width:160px; height:120px; object-fit:cover;">
              </div>
              <input type="file" name="foto" id="foto" class="form-control-file"
                accept="image/jpg,image/jpeg,image/png,image/gif">
              <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Status</label>
            <div class="col-md-4">
              <select name="statusaktif" class="form-control">
                <option value="Aktif"    <?= ($isEdit && $rowData->statusaktif == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                <option value="Nonaktif" <?= ($isEdit && $rowData->statusaktif == 'Nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
              </select>
            </div>
          </div>

          <hr>
          <div class="form-group row">
            <div class="col-md-9 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan
              </button>
              <a href="<?= site_url('ruangan') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <i class="fa fa-eye"></i> Preview Ruangan
      </div>
      <div class="card-body p-0">
        <img id="previewFotoSide" src="<?= $fotoSrc ?>"
          style="width:100%; height:180px; object-fit:cover;">
      </div>
      <div class="card-body">
        <h5 id="previewNama" class="font-weight-bold mb-1">
          <?= $isEdit ? $rowData->namaruangan : 'Nama Ruangan' ?>
        </h5>
        <p id="previewLokasi" class="text-muted mb-1" style="font-size:13px;">
          <i class="fa fa-map-marker-alt"></i>
          <?= ($isEdit && $rowData->lokasi) ? $rowData->lokasi : '-' ?>
        </p>
        <p id="previewKapasitas" class="mb-1" style="font-size:13px;">
          <i class="fa fa-users text-info"></i>
          Kapasitas: <b><?= ($isEdit && $rowData->kapasitas) ? $rowData->kapasitas . ' Orang' : '-' ?></b>
        </p>
        <hr class="my-2">
        <p class="text-muted mb-0" style="font-size:12px;"><i class="fa fa-check-circle text-success"></i> Fasilitas:</p>
        <p id="previewFasilitas" style="font-size:12px;">
          <?= ($isEdit && $rowData->fasilitas) ? $rowData->fasilitas : '-' ?>
        </p>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

<script>
$('#foto').on('change', function () {
  var file = this.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#previewFoto, #previewFotoSide').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  }
});
$('#namaruangan').on('input', function () { $('#previewNama').text($(this).val() || 'Nama Ruangan'); });
$('#lokasi').on('input', function () { $('#previewLokasi').html('<i class="fa fa-map-marker-alt"></i> ' + ($(this).val() || '-')); });
$('#kapasitas').on('input', function () {
  var val = $(this).val();
  $('#previewKapasitas').html('<i class="fa fa-users text-info"></i> Kapasitas: <b>' + (val > 0 ? val + ' Orang' : '-') + '</b>');
});
$('#fasilitas').on('input', function () { $('#previewFasilitas').text($(this).val() || '-'); });
</script>

</body>
</html>