<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Riwayat Booking Saya</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('bookingruangan') ?>">Booking Ruangan</a></li>
      <li class="breadcrumb-item active">Riwayat</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">

        <?php
        $pesan = $this->session->flashdata('pesan');
        if (!empty($pesan))
            echo $pesan;
        ?>

        <div class="mb-3">
          <a href="<?= site_url('bookingruangan') ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Booking Baru
          </a>
        </div>

        <div class="card card-body bg-light mb-3">
          <div class="row align-items-end">
            <div class="col-md-3">
              <label>Dari Tanggal</label>
              <input type="date" id="tglawal" class="form-control" value="<?= $tglawal ?>">
            </div>
            <div class="col-md-3">
              <label>Sampai Tanggal</label>
              <input type="date" id="tglakhir" class="form-control" value="<?= $tglakhir ?>">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary btn-block" id="btnFilter">
                <i class="fa fa-filter"></i> Filter
              </button>
            </div>
          </div>
        </div>

        <table class="table table-bordered table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th width="5%">No</th>
              <th width="15%">ID Booking</th>
              <th width="18%">Ruangan</th>
              <th width="12%">Tanggal</th>
              <th width="12%">Jam</th>
              <th width="20%">Keperluan</th>
              <th width="10%">Status</th>
              <th width="8%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($rsRiwayat->num_rows() > 0): ?>
              <?php $no = 1;
    foreach ($rsRiwayat->result() as $row): ?>
                <?php
                if ($row->status == 'Disetujui')
                    $badge = '<span class="badge badge-success">Disetujui</span>';
                elseif ($row->status == 'Selesai')
                    $badge = '<span class="badge badge-secondary">Selesai</span>';
                else
                    $badge = '<span class="badge badge-danger">Dibatalkan</span>';

                $btnBatal = '';
                if ($row->status == 'Disetujui' && $row->tanggalbooking >= date('Y-m-d')) {
                    $btnBatal = '
                    <a href="' . site_url('bookingruangan/batal/' . $this->encrypt->encode($row->idbooking)) . '"
                        class="btn btn-danger btn-sm btn-circle btnBatal" title="Batalkan">
                        <i class="fa fa-times"></i>
                    </a>';
                }
                ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><small><code><?= $row->idbooking ?></code></small></td>
                  <td>
                    <b><?= $row->namaruangan ?></b><br>
                    <small class="text-muted"><i class="fa fa-map-marker-alt"></i> <?= $row->lokasi ?></small>
                  </td>
                  <td class="text-center"><?= date('d-m-Y', strtotime($row->tanggalbooking)) ?></td>
                  <td class="text-center">
                    <?= str_replace(':', '.', $row->jamulai) ?> -
                    <?= str_replace(':', '.', $row->jamselesai) ?>
                  </td>
                  <td><?= $row->keperluan ?></td>
                  <td class="text-center"><?= $badge ?></td>
                  <td class="text-center"><?= $btnBatal ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="fa fa-inbox fa-2x"></i><br>
                  Belum ada riwayat booking.
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
$('#btnFilter').on('click', function () {
  var tglawal  = $('#tglawal').val();
  var tglakhir = $('#tglakhir').val();
  window.location.href = '<?= site_url('bookingruangan/riwayat') ?>'
    + '?tglawal=' + tglawal + '&tglakhir=' + tglakhir;
});

$(document).on('click', '.btnBatal', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title             : 'Batalkan Booking?',
    text              : 'Booking yang dibatalkan tidak dapat dikembalikan!',
    icon              : 'warning',
    showCancelButton  : true,
    confirmButtonColor: '#d33',
    cancelButtonColor : '#6c757d',
    confirmButtonText : 'Ya, Batalkan!',
    cancelButtonText  : 'Tidak',
  }).then(function (result) {
    if (result.isConfirmed) window.location.href = url;
  });
});
</script>

</body>
</html>