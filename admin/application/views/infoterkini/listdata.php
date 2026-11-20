<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

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

    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <a href="<?= site_url('infoterkini/tambah') ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Info
          </a>
        </div>

        <table class="table table-bordered table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th width="5%">No</th>
              <th width="16%">Gambar</th>
              <th>Judul</th>
              <th width="10%" class="text-center">Urutan</th>
              <th width="11%" class="text-center">Status</th>
              <th width="14%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($rsInfo->num_rows() > 0): ?>
              <?php $no = 1;
    foreach ($rsInfo->result() as $row): ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td>
                    <img src="<?= base_url('uploads/info/' . $row->gambar) ?>" alt=""
                      style="width:120px;height:70px;object-fit:cover;border-radius:6px;">
                  </td>
                  <td>
                    <b><?= html_escape($row->judul) ?></b><br>
                    <small class="text-muted"><?= html_escape($row->subjudul) ?></small>
                    <?php if (!empty($row->urltombol)): ?>
                      <br><small><i class="fa fa-link"></i> <?= html_escape($row->urltombol) ?></small>
                    <?php endif; ?>
                  </td>
                  <td class="text-center"><?= (int) $row->urutan ?></td>
                  <td class="text-center">
                    <?php if ($row->statusaktif): ?>
                      <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php $enc = $this->encrypt->encode($row->idinfo); ?>
                    <a href="<?= site_url('infoterkini/edit/' . $enc) ?>" class="btn btn-sm btn-warning btn-circle" title="Edit">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?= site_url('infoterkini/toggle/' . $enc) ?>" class="btn btn-sm btn-info btn-circle" title="Aktif / nonaktifkan">
                      <i class="fa fa-eye"></i>
                    </a>
                    <a href="<?= site_url('infoterkini/hapus/' . $enc) ?>" class="btn btn-sm btn-danger btn-circle btnHapus" title="Hapus">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">
                  <i class="fa fa-inbox fa-2x"></i><br>Belum ada info terkini.
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