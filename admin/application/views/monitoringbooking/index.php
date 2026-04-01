<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Monitoring Booking Ruangan</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item active">Monitoring Booking</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">

    <?php
    $pesan = $this->session->flashdata('pesan');
    if (!empty($pesan))
        echo $pesan;
    ?>

    <div class="row mb-3">
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-check"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Booking Hari Ini</span>
            <span class="info-box-number" id="statTotal"><?= $statistik->total ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-door-open"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Sedang Aktif</span>
            <span class="info-box-number" id="statAktif"><?= $statistik->aktif ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-door-closed"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Ruangan Terpakai</span>
            <span class="info-box-number">
              <span id="statRuanganTerpakai"><?= $statistik->ruangan_terpakai ?></span>
              / <span id="statTotalRuangan"><?= $statistik->total_ruangan ?></span>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dibatalkan</span>
            <span class="info-box-number" id="statDibatalkan"><?= $statistik->dibatalkan ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row align-items-end mb-3">
          <div class="col-md-3">
            <label>Tanggal</label>
            <input type="date" id="filterTanggal" class="form-control" value="<?= $tanggal ?>">
          </div>
          <div class="col-md-3">
            <label>Ruangan</label>
            <select id="filterRuangan" class="form-control">
              <option value="">Semua Ruangan</option>
              <?php foreach ($rsRuangan->result() as $r): ?>
                <option value="<?= $r->idruangan ?>" <?= ($idruangan == $r->idruangan) ? 'selected' : '' ?>>
                  <?= $r->namaruangan ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Status</label>
            <select id="filterStatus" class="form-control">
              <option value="">Semua Status</option>
              <option value="Disetujui"  <?= ($status == 'Disetujui') ? 'selected' : '' ?>>Disetujui</option>
              <option value="Selesai"    <?= ($status == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
              <option value="Dibatalkan" <?= ($status == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
          </div>
          <div class="col-md-3">
            <button class="btn btn-primary btn-block" id="btnFilter">
              <i class="fa fa-filter"></i> Filter
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
          <small class="text-muted">
            <i class="fa fa-sync-alt"></i> Auto refresh setiap 30 detik |
            Terakhir update: <span id="lastUpdate">-</span>
          </small>
          <button class="btn btn-sm btn-outline-secondary" id="btnRefresh">
            <i class="fa fa-sync-alt"></i> Refresh Sekarang
          </button>
        </div>

        <table class="table table-bordered table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th width="5%">No</th>
              <th width="12%">ID Booking</th>
              <th width="13%">Ruangan</th>
              <th width="15%">DC / DM</th>
              <th width="10%">Tanggal</th>
              <th width="10%">Jam</th>
              <th width="18%">Keperluan</th>
              <th width="9%">Status</th>
              <th width="8%">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbodyBooking">
            <?php if ($rsBooking->num_rows() > 0): ?>
              <?php $no = 1;
    foreach ($rsBooking->result() as $row): ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><small><code><?= $row->idbooking ?></code></small></td>
                  <td>
                    <b><?= $row->namaruangan ?></b><br>
                    <small class="text-muted"><i class="fa fa-map-marker-alt"></i> <?= $row->lokasi ?></small>
                  </td>
                  <td>
                    <b><?= $row->namadc ?></b><br>
                    <small class="text-muted"><?= $row->namadm ?></small>
                  </td>
                  <td class="text-center"><?= date('d-m-Y', strtotime($row->tanggalbooking)) ?></td>
                  <td class="text-center">
                    <?= str_replace(':', '.', $row->jamulai) ?> -
                    <?= str_replace(':', '.', $row->jamselesai) ?>
                  </td>
                  <td><?= $row->keperluan ?></td>
                  <td class="text-center">
                    <?php
                    if ($row->status == 'Disetujui')
                        echo '<span class="badge badge-success">Aktif</span>';
                    elseif ($row->status == 'Selesai')
                        echo '<span class="badge badge-secondary">Selesai</span>';
                    else
                        echo '<span class="badge badge-danger">Dibatalkan</span>';
                    ?>
                  </td>
                  <td class="text-center">
                    <?php if ($row->status == 'Disetujui'): ?>
                      <a href="<?= site_url('monitoringbooking/batal/' . $this->encrypt->encode($row->idbooking)) ?>"
                        class="btn btn-sm btn-danger btn-circle btnBatal">
                        <i class="fa fa-times"></i>
                      </a>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-4">
                  <i class="fa fa-inbox fa-2x"></i><br>Tidak ada data booking.
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
var filterTanggal = '<?= $tanggal ?>';
var filterRuangan = '<?= $idruangan ?>';
var filterStatus  = '<?= $status ?>';

$(document).ready(function () {
  $('#btnFilter').on('click', function () {
    filterTanggal = $('#filterTanggal').val();
    filterRuangan = $('#filterRuangan').val();
    filterStatus  = $('#filterStatus').val();
    refreshData();
  });

  $('#btnRefresh').on('click', function () { refreshData(); });

  setInterval(function () { refreshData(); }, 30000);

  $(document).on('click', '.btnBatal', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    Swal.fire({
      title             : 'Batalkan Booking?',
      text              : 'Booking ini akan dibatalkan oleh admin!',
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
});

function refreshData() {
  $.ajax({
    url      : '<?= site_url('monitoringbooking/getDataBooking') ?>',
    type     : 'GET',
    dataType : 'json',
    data     : { tanggal: filterTanggal, idruangan: filterRuangan, status: filterStatus },
  })
  .done(function (res) {
    $('#statTotal').text(res.statistik.total);
    $('#statAktif').text(res.statistik.aktif);
    $('#statRuanganTerpakai').text(res.statistik.ruangan_terpakai);
    $('#statTotalRuangan').text(res.statistik.total_ruangan);
    $('#statDibatalkan').text(res.statistik.dibatalkan);

    var html = '';
    if (res.booking.length > 0) {
      $.each(res.booking, function (i, b) {
        var badge = b.status == 'Disetujui'
          ? '<span class="badge badge-success">Aktif</span>'
          : b.status == 'Selesai'
          ? '<span class="badge badge-secondary">Selesai</span>'
          : '<span class="badge badge-danger">Dibatalkan</span>';

        var btnBatal = b.status == 'Disetujui'
          ? `<a href="${b.urlbatal}" class="btn btn-sm btn-danger btn-circle btnBatal"><i class="fa fa-times"></i></a>`
          : '<span class="text-muted">-</span>';

        html += `
        <tr>
          <td class="text-center">${i + 1}</td>
          <td><small><code>${b.idbooking}</code></small></td>
          <td><b>${b.namaruangan}</b><br><small class="text-muted"><i class="fa fa-map-marker-alt"></i> ${b.lokasi}</small></td>
          <td><b>${b.namadc}</b><br><small class="text-muted">${b.namadm}</small></td>
          <td class="text-center">${b.tanggalbooking}</td>
          <td class="text-center">${b.jamulai.replace(':', '.')} - ${b.jamselesai.replace(':', '.')}</td>
          <td>${b.keperluan}</td>
          <td class="text-center">${badge}</td>
          <td class="text-center">${btnBatal}</td>
        </tr>`;
      });
    } else {
      html = '<tr><td colspan="9" class="text-center text-muted py-4"><i class="fa fa-inbox fa-2x"></i><br>Tidak ada data booking.</td></tr>';
    }

    $('#tbodyBooking').html(html);
    $('#lastUpdate').text(new Date().toLocaleTimeString('id-ID'));
  });
}
</script>

</body>
</html>