<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Blokir Ruangan</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('ruangan') ?>">Master Ruangan</a></li>
      <li class="breadcrumb-item active">Blokir</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">

  <div class="col-md-12 mb-3">
    <div class="card card-body bg-light shadow-sm">
      <div class="row align-items-center">
        <div class="col-md-1 text-center">
          <?php
$fotoSrc = base_url('images/nofoto.png');
if (!empty($rowRuangan->foto)) {
    $fotoSrc = base_url('uploads/ruangan/' . $rowRuangan->foto);
}
?>
          <img src="<?= $fotoSrc ?>" class="rounded border"
            style="width:60px; height:60px; object-fit:cover;">
        </div>
        <div class="col-md-8">
          <h5 class="mb-0 font-weight-bold"><?= $rowRuangan->namaruangan ?></h5>
          <small class="text-muted">
            <i class="fa fa-map-marker-alt"></i> <?= $rowRuangan->lokasi ?>
            &nbsp;|&nbsp;
            <i class="fa fa-users"></i> Kapasitas: <?= $rowRuangan->kapasitas ?> Orang
            &nbsp;|&nbsp;
            <i class="fa fa-tools"></i> <?= $rowRuangan->fasilitas ?>
          </small>
        </div>
        <div class="col-md-3 text-right">
          <a href="<?= site_url('ruangan') ?>" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali ke List
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card">
      <div class="card-header bg-danger text-white">
        <h6 class="mb-0"><i class="fa fa-ban"></i> Tambah Jadwal Blokir</h6>
      </div>
      <div class="card-body">

        <?php
        $pesan = $this->session->flashdata('pesan');
        if (!empty($pesan))
            echo $pesan;
        ?>

        <form action="<?= site_url('ruangan/simpanblokir') ?>" method="POST">
          <input type="hidden" name="idblokir"  value="">
          <input type="hidden" name="idruangan" value="<?= $idruangan ?>">

          <div class="form-group">
            <label>Tanggal Blokir <span class="text-danger">*</span></label>
            <input type="date" name="tanggalblokir" class="form-control"
              value="<?= date('Y-m-d') ?>" required>
          </div>

          <div class="form-group">
            <label>Jenis Blokir</label>
            <div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenisblokir"
                  id="jenisSehari" value="seharian" checked>
                <label class="form-check-label" for="jenisSehari">
                  <i class="fa fa-ban text-danger"></i> Seharian Penuh
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenisblokir"
                  id="jenisPerjam" value="perjam">
                <label class="form-check-label" for="jenisPerjam">
                  <i class="fa fa-clock text-warning"></i> Per Jam
                </label>
              </div>
            </div>
          </div>

          <div id="divJam" style="display:none;">
            <div class="form-group">
              <label>Jam Mulai</label>
              <input type="time" name="jamulai" class="form-control" value="08:00">
              <small class="text-muted">AM = 00.00-11.59 | PM = 12.00-23.59</small>
            </div>
            <div class="form-group">
              <label>Jam Selesai</label>
              <input type="time" name="jamselesai" class="form-control" value="17:00">
              <small class="text-muted">AM = 00.00-11.59 | PM = 12.00-23.59</small>
            </div>
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"
              placeholder="Contoh: Ibadah Raya, Latihan Paduan Suara, Rapat Pengurus..."></textarea>
          </div>

          <button type="submit" class="btn btn-danger btn-block">
            <i class="fa fa-ban"></i> Simpan Blokir
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-7">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">
          <i class="fa fa-list"></i>
          Jadwal Blokir — <?= $rowRuangan->namaruangan ?>
          <span class="badge badge-danger"><?= $rsBlokir->num_rows() ?></span>
        </h6>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
          <thead class="thead-dark">
            <tr>
              <th width="5%">No</th>
              <th width="22%">Tanggal</th>
              <th width="25%">Jam</th>
              <th width="33%">Keterangan</th>
              <th width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($rsBlokir->num_rows() > 0): ?>
              <?php $no = 1;
    foreach ($rsBlokir->result() as $row): ?>
                <?php $isLampau = ($row->tanggalblokir < date('Y-m-d')); ?>
                <tr class="<?= $isLampau ? 'text-muted' : '' ?>">
                  <td class="text-center"><?= $no++ ?></td>
                  <td class="text-center">
                    <?= date('d-m-Y', strtotime($row->tanggalblokir)) ?>
                    <?php if ($row->tanggalblokir == date('Y-m-d')): ?>
                      <br><span class="badge badge-danger">Hari Ini</span>
                    <?php elseif ($isLampau): ?>
                      <br><span class="badge badge-secondary">Lampau</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if (empty($row->jamulai)): ?>
                      <span class="badge badge-danger">Seharian Penuh</span>
                    <?php else: ?>
                      <?= str_replace(':', '.', $row->jamulai) ?> —
                      <?= str_replace(':', '.', $row->jamselesai) ?>
                    <?php endif; ?>
                  </td>
                  <td><?= $row->keterangan ?? '-' ?></td>
                  <td class="text-center">
                    <a href="<?= site_url('ruangan/hapusblokir/' . $this->encrypt->encode($row->idblokir)) ?>"
                      class="btn btn-sm btn-danger btn-circle btnHapusBlokir">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fa fa-check-circle text-success fa-2x"></i><br>
                  Belum ada jadwal blokir untuk ruangan ini.
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
$('input[name="jenisblokir"]').on('change', function () {
  $('#divJam').toggle($(this).val() == 'perjam');
});

$(document).on('click', '.btnHapusBlokir', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title             : 'Hapus Jadwal Blokir?',
    text              : 'Ruangan akan bisa dibooking kembali pada tanggal ini!',
    icon              : 'warning',
    showCancelButton  : true,
    confirmButtonColor: '#d33',
    cancelButtonColor : '#6c757d',
    confirmButtonText : 'Ya, Hapus!',
    cancelButtonText  : 'Batal',
  }).then(function (result) {
    if (result.isConfirmed) window.location.href = url;
  });
});
</script>

</body>
</html>