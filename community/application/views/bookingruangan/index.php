<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<style>
  .card-ruangan { transition: all .2s; }
  .card-ruangan:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }
  .badge-fasilitas {
    display: inline-block; background: #eaf4ff; color: #1a73e8;
    border-radius: 20px; padding: 2px 10px; font-size: 11px; margin: 2px;
  }
</style>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Booking Ruangan</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item active">Booking Ruangan</li>
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
          <a href="<?= site_url('bookingruangan/riwayat') ?>" class="btn btn-info btn-sm">
            <i class="fa fa-history"></i> Riwayat Booking Saya
          </a>
        </div>

        <div class="card card-body bg-light mb-3 shadow-sm">
          <div class="row align-items-end">
            <div class="col-md-3">
              <label>Tanggal</label>
              <input type="date" id="tanggal" class="form-control"
                value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
              <label>Jam Mulai</label>
              <input type="time" id="jamulai" class="form-control" value="08:00">
              <small class="text-muted"><i class="fa fa-info-circle"></i> AM = 00.00-11.59 | PM = 12.00-23.59</small>
            </div>
            <div class="col-md-3">
              <label>Jam Selesai</label>
              <input type="time" id="jamselesai" class="form-control" value="10:00">
              <small class="text-muted"><i class="fa fa-info-circle"></i> AM = 00.00-11.59 | PM = 12.00-23.59</small>
            </div>
            <div class="col-md-3">
              <button class="btn btn-primary btn-block" id="btnCariRuangan">
                <i class="fa fa-search"></i> Cari Ruangan
              </button>
            </div>
          </div>
        </div>

        <div id="divPanduan" class="text-center py-5">
          <i class="fa fa-search fa-3x text-muted mb-3"></i>
          <p class="text-muted">
            Pilih <b>tanggal</b>, <b>jam mulai</b>, dan <b>jam selesai</b><br>
            lalu klik <b>Cari Ruangan</b> untuk melihat ketersediaan.
          </p>
        </div>

        <div id="divLoading" style="display:none;" class="text-center py-4">
          <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
          <p class="text-muted mt-2">Mencari ruangan...</p>
        </div>

        <div id="divHasil" style="display:none;">
          <div class="mb-2">
            <h6 class="text-success font-weight-bold">
              <i class="fa fa-check-circle"></i> Ruangan Tersedia
              <span id="jmlTersedia" class="badge badge-success">0</span>
            </h6>
          </div>
          <div class="row mb-4" id="divTersedia"></div>

          <div class="mb-2">
            <h6 class="text-danger font-weight-bold">
              <i class="fa fa-times-circle"></i> Sudah Dibooking
              <span id="jmlTerpakai" class="badge badge-danger">0</span>
            </h6>
          </div>
          <div class="row" id="divTerpakai"></div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI BOOKING -->
<div class="modal fade" id="modalBooking" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa fa-calendar-check"></i> Konfirmasi Booking</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form action="<?= site_url('bookingruangan/simpan') ?>" method="POST">
        <div class="modal-body">
          <input type="hidden" name="idruangan"  id="m_idruangan">
          <input type="hidden" name="tanggal"    id="m_tanggal">
          <input type="hidden" name="jamulai"    id="m_jamulai">
          <input type="hidden" name="jamselesai" id="m_jamselesai">

          <table class="table table-sm table-borderless">
            <tr><td width="35%" class="text-muted">Ruangan</td><td><b id="m_namaruangan">-</b></td></tr>
            <tr><td class="text-muted">Lokasi</td><td id="m_lokasi">-</td></tr>
            <tr><td class="text-muted">Tanggal</td><td id="m_tgl_label">-</td></tr>
            <tr><td class="text-muted">Jam</td><td id="m_jam_label">-</td></tr>
            <tr><td class="text-muted">Kapasitas</td><td id="m_kapasitas">-</td></tr>
          </table>

          <div class="form-group mb-0">
            <label>Keperluan <span class="text-danger">*</span></label>
            <textarea name="keperluan" class="form-control" rows="3"
              placeholder="Contoh: Pertemuan rutin DC, Ibadah sel, dll..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> Booking Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

<script>
function formatJam(jam) {
  return jam ? jam.replace(':', '.') : '-';
}

$(document).ready(function () {
  $('#btnCariRuangan').on('click', function () { cariRuangan(); });

  function cariRuangan() {
    var tanggal    = $('#tanggal').val();
    var jamulai    = $('#jamulai').val();
    var jamselesai = $('#jamselesai').val();

    if (!tanggal || !jamulai || !jamselesai) {
      alert('Lengkapi tanggal dan jam terlebih dahulu!');
      return;
    }
    if (jamselesai <= jamulai) {
      alert('Jam selesai harus lebih besar dari jam mulai!');
      return;
    }

    $('#divPanduan').hide();
    $('#divLoading').show();
    $('#divHasil').hide();

    $.ajax({
      url      : '<?= site_url('bookingruangan/getRuangan') ?>',
      type     : 'GET',
      dataType : 'json',
      data     : { tanggal: tanggal, jamulai: jamulai, jamselesai: jamselesai },
    })
    .done(function (res) {
      $('#divLoading').hide();

      if (res.status === 'error') { alert(res.message); return; }

      $('#divTersedia').empty();
      $('#divTerpakai').empty();
      $('#jmlTersedia').text(res.tersedia.length);
      $('#jmlTerpakai').text(res.terpakai.length);

      // KARTU TERSEDIA
      if (res.tersedia.length > 0) {
        $.each(res.tersedia, function (i, r) {
          var fasilitas = '';
          if (r.fasilitas) {
            $.each(r.fasilitas.split(','), function (j, f) {
              fasilitas += '<span class="badge-fasilitas">' + $.trim(f) + '</span>';
            });
          }

          var btnBooking = '';
          if (res.sudahMaksimal) {
            btnBooking = `<button class="btn btn-secondary btn-block btn-sm" disabled>
              <i class="fa fa-ban"></i> Kuota Habis Hari Ini
            </button>`;
          } else {
            btnBooking = `<button class="btn btn-success btn-block btn-sm btnBooking"
              data-idruangan="${r.idruangan}"
              data-namaruangan="${r.namaruangan}"
              data-lokasi="${r.lokasi || '-'}"
              data-kapasitas="${r.kapasitas}">
              <i class="fa fa-calendar-plus"></i> Booking Sekarang
            </button>`;
          }

          var card = `
          <div class="col-md-4 mb-3">
            <div class="card card-ruangan border-success h-100">
              <div style="position:relative;">
                <img src="${r.foto}" class="card-img-top" style="height:160px; object-fit:cover;">
                <span class="badge badge-success" style="position:absolute; top:8px; right:8px; font-size:12px;">
                  <i class="fa fa-check"></i> Tersedia
                </span>
              </div>
              <div class="card-body">
                <h6 class="font-weight-bold mb-1">${r.namaruangan}</h6>
                <p class="text-muted mb-1" style="font-size:12px;">
                  <i class="fa fa-map-marker-alt"></i> ${r.lokasi || '-'}
                </p>
                <p class="text-muted mb-2" style="font-size:12px;">
                  <i class="fa fa-users"></i> Kapasitas: <b>${r.kapasitas} Orang</b>
                </p>
                <div class="mb-3">${fasilitas || '-'}</div>
                ${btnBooking}
              </div>
            </div>
          </div>`;
          $('#divTersedia').append(card);
        });

        if (res.sudahMaksimal) {
          $('#divTersedia').prepend(`
            <div class="col-12 mb-3">
              <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i>
                <b>DC Anda sudah memiliki booking aktif hari ini.</b>
                Maksimal 1 booking per hari.
                <a href="<?= site_url('bookingruangan/riwayat') ?>" class="alert-link">Lihat Riwayat →</a>
              </div>
            </div>`);
        }
      } else {
        $('#divTersedia').html(`
          <div class="col-12">
            <div class="alert alert-warning">
              <i class="fa fa-exclamation-triangle"></i>
              Tidak ada ruangan tersedia pada jam yang dipilih.
            </div>
          </div>`);
      }

      // KARTU TERPAKAI
      if (res.terpakai.length > 0) {
        $.each(res.terpakai, function (i, r) {
          var infoTerpakai = '';
          var badgeLabel   = '';

          if (r.jenispakai === 'blokir') {
            badgeLabel = `<span class="badge badge-danger" style="position:absolute; top:8px; right:8px; font-size:12px;">
              <i class="fa fa-ban"></i> Tidak Tersedia</span>`;
            infoTerpakai = `
              <p class="mb-1" style="font-size:12px;"><i class="fa fa-ban text-danger"></i> <b>Diblokir oleh Admin</b></p>
              <p class="mb-0 text-muted" style="font-size:11px;"><i class="fa fa-info-circle"></i> ${r.keperluan || 'Tidak tersedia untuk saat ini'}</p>`;
          } else {
            badgeLabel = `<span class="badge badge-danger" style="position:absolute; top:8px; right:8px; font-size:12px;">
              <i class="fa fa-lock"></i> Terpakai</span>`;
            infoTerpakai = `
              <p class="mb-1" style="font-size:12px;"><i class="fa fa-users text-danger"></i> <b>${r.namadc}</b></p>
              <p class="mb-1" style="font-size:12px;"><i class="fa fa-clock text-danger"></i> ${formatJam(r.jamulai)} - ${formatJam(r.jamselesai)}</p>
              <p class="mb-0 text-muted" style="font-size:11px;"><i class="fa fa-info-circle"></i> ${r.keperluan || '-'}</p>`;
          }

          var card = `
          <div class="col-md-4 mb-3">
            <div class="card card-ruangan border-danger h-100">
              <div style="position:relative;">
                <img src="${r.foto}" class="card-img-top" style="height:160px; object-fit:cover; filter:grayscale(40%);">
                ${badgeLabel}
              </div>
              <div class="card-body">
                <h6 class="font-weight-bold mb-1">${r.namaruangan}</h6>
                <p class="text-muted mb-1" style="font-size:12px;"><i class="fa fa-map-marker-alt"></i> ${r.lokasi || '-'}</p>
                <hr class="my-2">
                ${infoTerpakai}
              </div>
            </div>
          </div>`;
          $('#divTerpakai').append(card);
        });
      }

      $('#divHasil').show();
    })
    .fail(function () {
      $('#divLoading').hide();
      alert('Gagal memuat data ruangan!');
    });
  }

  $(document).on('click', '.btnBooking', function () {
    var tanggal    = $('#tanggal').val();
    var jamulai    = $('#jamulai').val();
    var jamselesai = $('#jamselesai').val();

    $('#m_idruangan').val($(this).data('idruangan'));
    $('#m_tanggal').val(tanggal);
    $('#m_jamulai').val(jamulai);
    $('#m_jamselesai').val(jamselesai);
    $('#m_namaruangan').text($(this).data('namaruangan'));
    $('#m_lokasi').text($(this).data('lokasi'));
    $('#m_kapasitas').text($(this).data('kapasitas') + ' Orang');
    $('#m_tgl_label').text(tanggal);
    $('#m_jam_label').text(formatJam(jamulai) + ' - ' + formatJam(jamselesai));

    $('#modalBooking').modal('show');
  });
});
</script>

</body>
</html>