<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<style>
  .card-dc { padding-top: 10px; }
  .card-dc .namadc { font-size: 18px; display: block; font-weight: bold; }
</style>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">List Absensi DC</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
      <li class="breadcrumb-item active">DCM</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">
    <div class="card" id="cardcontent">
      <div class="card-body">
        <div class="row">

          <div class="col-md-12">
            <?php
            $pesan = $this->session->flashdata('pesan');
            if (!empty($pesan)) {
              echo $pesan;
            }
            ?>
          </div>

          <div class="col-12">
            <h5 class="text-muted">Filter</h5>
          </div>

          <!-- Filter Tanggal -->
          <div class="col-12">
            <div class="form-group row">
              <label for="tanggal" class="col-md-2 col-form-label">Tanggal</label>
              <div class="col-md-2">
                <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo date('Y-m-d', strtotime('-7 day')) ?>">
              </div>
              <label for="tanggal" class="col-md-1 text-center col-form-label">s/d</label>
              <div class="col-md-2">
                <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <!-- Filter Nama DC -->
          <div class="col-12">
            <div class="form-group row">
              <label for="" class="col-md-2 col-form-label">Nama DC</label>
              <div class="col-md-10">
                <select name="iddc" id="iddc" class="form-control select2">
                  <option value="">Semua DC...</option>
                  <?php foreach ($rsDc->result() as $row) {
                    echo '<option value="' . $row->iddc . '">' . $row->namadc . '</option>';
                  } ?>
                </select>
              </div>
            </div>
          </div>

          <!-- ✅ TOMBOL CETAK PDF — letakkan di sini, setelah filter DC, sebelum <hr> -->
          <div class="col-12 mb-2">
            <button type="button" class="btn btn-danger btn-sm" id="btnExportPdf">
              <i class="fa fa-file-pdf"></i> Cetak PDF
            </button>
          </div>
          <!-- ✅ AKHIR TOMBOL -->

          <div class="col-12">
            <hr>
          </div>

          <div class="col-12">
            <div class="row" id="divListAbsen"></div>
          </div>

        </div> <!-- /.row -->
      </div> <!-- ./card-body -->
    </div> <!-- /.card -->
  </div> <!-- /.col -->
</div> <!-- /.row -->


<?php $this->load->view('template/footer') ?>


<script type="text/javascript">
  var table;

  $(document).ready(function() {
    $(".select2").select2();
    getListAbsensi();
  });

  function getListAbsensi() {
    var tglawal  = $('#tglawal').val();
    var tglakhir = $('#tglakhir').val();
    var iddc     = $('#iddc').val();

    $.ajax({
      url: '<?= site_url('absensidc/getListAbsensi') ?>',
      type: 'GET',
      dataType: 'json',
      data: { 'tglawal': tglawal, 'tglakhir': tglakhir, 'iddc': iddc },
    })
    .done(function(response) {
      $('#divListAbsen').empty();
      if (response.length > 0) {
        for (var i = 0; i < response.length; i++) {
          var addText = `
            <div class="col-md-3">
              <div class="card">
                <div class="card-body card-dc shadow">
                  <div class="row">
                    <div class="col-12">
                      <span class="namadc">${response[i]['namadc']} <span class="badge badge-warning">${response[i]['totalpeserta']}</span></span>
                      <span>${response[i]['tglabsen']}</span>
                    </div>
                    <div class="col-12 mt-3">
                      <img src="${response[i]['foto']}" alt="" class="rounded" style="width:100%; height:200px;">
                    </div>
                    <div class="col-12 mt-3">
                      <a href="${response[i]['urldetail']}" class="btn btn-sm btn-primary btn-block">Lihat Detail</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>`;
          $('#divListAbsen').append(addText);
        }
      } else {
        $('#divListAbsen').append(`
          <div class="col-md-12">
            <div class="card">
              <div class="card-body card-dc shadow">
                <div class="col-12 text-center">Data tidak ditemukan...</div>
              </div>
            </div>
          </div>`);
      }
    })
    .fail(function() { console.log('error'); });
  }

  $(document).on('change', '#tglawal',  function() { getListAbsensi(); });
  $(document).on('change', '#tglakhir', function() { getListAbsensi(); });
  $(document).on('change', '#iddc',     function() { getListAbsensi(); });

  // ✅ SCRIPT TOMBOL CETAK PDF — letakkan di sini, setelah event listener di atas
  $(document).on('click', '#btnExportPdf', function(e) {
    e.preventDefault();
    var tglawal  = $('#tglawal').val();
    var tglakhir = $('#tglakhir').val();
    var iddc     = $('#iddc').val();

    window.open(
      '<?= site_url('absensidc/cetakPdf') ?>/' + tglawal + '/' + tglakhir + '/' + encodeURIComponent(iddc),
      '_blank'
    );
  });
  // ✅ AKHIR SCRIPT

</script>

</body>
</html>