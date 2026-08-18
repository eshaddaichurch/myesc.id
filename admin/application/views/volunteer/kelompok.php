<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Volunteer - Tampilan Kelompok</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('volunteer')) ?>">Volunteer</a></li>
        <li class="breadcrumb-item active">Kelompok</li>
      </ol>
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-header">
          <h5 class="card-title">Volunteer Dikelompokkan per Departemen &amp; Pelayanan</h5>
          <a href="<?php echo(site_url('volunteer')) ?>" class="btn btn-sm btn-default float-right"><i class="fa fa-list"></i> Tampilan List</a>
          <a href="<?php echo(site_url('volunteer/tambah')) ?>" class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>
        <div class="card-body">

          <!-- ===== FILTER ===== -->
          <form method="get" action="<?php echo site_url('volunteer/kelompok') ?>" class="mb-4">
            <div class="row">
              <div class="col-md-5">
                <label class="col-form-label">Filter Departement</label>
                <select name="iddepartement" class="form-control select2" onchange="this.form.submit()">
                  <option value="">Semua Departement</option>
                  <?php
                    $rsdepartement = $this->db->query("select * from departement where statusaktif='Aktif' order by namadepartement");
                    if ($rsdepartement->num_rows() > 0) {
                      foreach ($rsdepartement->result() as $rowdepartement) {
                        $selected = ($filter_iddepartement == $rowdepartement->iddepartement) ? 'selected' : '';
                        echo '<option value="' . $rowdepartement->iddepartement . '" ' . $selected . '>' . $rowdepartement->namadepartement . '</option>';
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="col-form-label">Filter Status</label>
                <select name="statusaktif" class="form-control" onchange="this.form.submit()">
                  <option value="">Semua Status</option>
                  <option value="Aktif" <?php echo ($filter_statusaktif=='Aktif') ? 'selected' : '' ?>>Aktif</option>
                  <option value="Tidak Aktif" <?php echo ($filter_statusaktif=='Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
              </div>
              <div class="col-md-3 d-flex align-items-end">
                <a href="<?php echo site_url('volunteer/kelompok') ?>" class="btn btn-default mb-1"><i class="fa fa-undo"></i> Reset Filter</a>
              </div>
            </div>
          </form>

          <?php if (empty($grouped)) { ?>

            <div class="alert alert-info">Tidak ada data volunteer untuk filter yang dipilih.</div>

          <?php } else { ?>

          <div id="accordionDepartement">
            <?php $idx = 0; foreach ($grouped as $namadept => $daftarpelayanan) { $idx++; 

              // hitung total orang di departemen ini (unik, karena 1 orang bisa muncul di lebih dari 1 pelayanan dalam departemen yang sama)
              $totalorang = array();
              foreach ($daftarpelayanan as $listorang) {
                foreach ($listorang as $orang) {
                  $totalorang[$orang->idjemaat] = true;
                }
              }
            ?>

              <div class="card mb-2">
                <div class="card-header p-2" id="headingDept<?php echo $idx ?>" style="cursor:pointer; background:#f4f6f9;" data-toggle="collapse" data-target="#collapseDept<?php echo $idx ?>">
                  <h6 class="mb-0 d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-users mr-2"></i><?php echo $namadept ?></span>
                    <span class="badge badge-primary"><?php echo count($totalorang) ?> orang</span>
                  </h6>
                </div>

                <div id="collapseDept<?php echo $idx ?>" class="collapse <?php echo ($idx==1) ? 'show' : '' ?>" data-parent="#accordionDepartement">
                  <div class="card-body">

                    <?php foreach ($daftarpelayanan as $namapely => $listorang) { ?>
                      <div class="mb-3">
                        <h6 class="text-muted border-bottom pb-1 mb-2">
                          <i class="fa fa-tag mr-1"></i> <?php echo $namapely ?>
                          <span class="badge badge-secondary float-right"><?php echo count($listorang) ?></span>
                        </h6>
                        <div class="row">
                          <?php foreach ($listorang as $orang) { ?>
                            <div class="col-md-4 col-sm-6 mb-2">
                              <div class="d-flex align-items-center p-2" style="background:#fafafa; border-radius:8px; border:1px solid #f0f0f0;">
                                <div class="flex-grow-1">
                                  <div style="font-weight:600; font-size:13px;">
                                    <a href="" id="tampilinfojemaat" data-idjemaat="<?php echo $orang->idjemaat ?>"><?php echo $orang->namalengkap ?></a>
                                  </div>
                                  <div style="font-size:11px; color:#999;">
                                    <?php if ($orang->statusaktif == 'Aktif') { ?>
                                      <span class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
                                      <span class="badge badge-light border">Tidak Aktif</span>
                                    <?php } ?>
                                  </div>
                                </div>
                                <a href="<?php echo site_url('volunteer/edit/'.$this->encrypt->encode($orang->idvolunteer)) ?>" class="btn btn-xs btn-warning btn-circle" title="Edit"><i class="fa fa-edit"></i></a>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                </div>
              </div>

            <?php } ?>
          </div>

          <?php } ?>

        </div> <!-- ./card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->


<?php $this->load->view("template/footer") ?>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalinfojemaat">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Riwayat Kelas &amp; Baptis <span id="modaljudulnama" class="text-muted"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 text-center ">
            <nav class="nav-justified ">
              <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="pop2-tab" data-toggle="tab" href="#pop2" role="tab" aria-controls="pop2" aria-selected="true">Riwayat Pelayanan</a>
                <a class="nav-item nav-link" id="pop5-tab" data-toggle="tab" href="#pop5" role="tab" aria-controls="pop5" aria-selected="false">Kelas</a>
                <a class="nav-item nav-link" id="pop6-tab" data-toggle="tab" href="#pop6" role="tab" aria-controls="pop6" aria-selected="false">Baptis</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

              <div class="tab-pane fade show active" id="pop2" role="tabpanel" aria-labelledby="pop2-tab">
                <div class="pt-3"></div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Departement</th>
                      <th>Pelayanan</th>
                      <th>Status</th>
                      <th>Tgl Bergabung</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyinfopelayanan">

                  </tbody>
                </table>
              </div>

              <div class="tab-pane fade" id="pop5" role="tabpanel" aria-labelledby="pop5-tab">
                <div class="pt-3"></div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama Kelas</th>
                      <th>Status</th>
                      <th>Tgl Kelulusan</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyinfokelas">

                  </tbody>
                </table>
              </div>

              <div class="tab-pane fade" id="pop6" role="tabpanel" aria-labelledby="pop6-tab">
                <div class="pt-3"></div>
                <table class="table">
                  <tbody>
                    <tr class="text-left">
                      <td style="width: 25%;">Nomor/ Tanggal Akta</td>
                      <td style="width: 5%;">:</td>
                      <td id="tdbaptisantanggalakta"></td>
                    </tr>
                    <tr class="text-left">
                      <td style="width: 25%;">Tanggal Baptis</td>
                      <td style="width: 5%;">:</td>
                      <td id="tdbaptisantanggalbaptis"></td>
                    </tr>
                    <tr class="text-left">
                      <td style="width: 25%;">Nama Gereja</td>
                      <td style="width: 5%;">:</td>
                      <td id="tdbaptisannamagereja"></td>
                    </tr>
                    <tr class="text-left">
                      <td style="width: 25%;">Nama Gembala</td>
                      <td style="width: 5%;">:</td>
                      <td id="tdbaptisannamagembala"></td>
                    </tr>
                    <tr class="text-left" id="trFileAkta">
                      <td style="width: 25%;">File Akta Baptis</td>
                      <td style="width: 5%;">:</td>
                      <td id=""><a href="" target="_blank" id="linkFileAktaBaptis"><i class="fas fa-file-alt mr-2"></i>File Akta Baptis</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
  });


  // =====================================================
  // MODAL INFO KELAS & BAPTIS (endpoint mandiri di controller Volunteer,
  // sengaja TIDAK menampilkan data pribadi jemaat)
  // =====================================================
  $(document).on('click', '#tampilinfojemaat', function(event) {
    event.preventDefault();
    $('#modalinfojemaat').modal({
      backdrop: 'static',
      keyboard: false
    });
    $('#modalinfojemaat').modal('show');

    kosongkanModalInfoJemaat();
    var idjemaat = $(this).attr("data-idjemaat");

    $.ajax({
        url: '<?php echo site_url('volunteer/get_info_jemaat') ?>',
        type: 'GET',
        dataType: 'json',
        data: {
          'idjemaat': idjemaat
        },
      })
      .done(function(result) {

        if (!result.success) {
          swal("Informasi", result.msg, "info");
          return;
        }

        $('#modaljudulnama').html('- ' + result.namalengkap + ' (' + result.noaj + ')');

        var arrPelayanan = result.arrPelayanan;
        $('#tbodyinfopelayanan').empty();
        if (arrPelayanan.length > 0) {
          for (var i = 0; i < arrPelayanan.length; i++) {
            var statusBadge = (arrPelayanan[i]['statusaktif'] == 'Aktif')
              ? '<span class="badge badge-success">Aktif</span>'
              : '<span class="badge badge-secondary">Tidak Aktif</span>';
            var addRow = `<tr>
                        <td>` + arrPelayanan[i]['namadepartement'] + `</td>
                        <td>` + arrPelayanan[i]['namapelayanan'] + `</td>
                        <td>` + statusBadge + `</td>
                        <td>` + arrPelayanan[i]['tanggalbergabung'] + `</td>
                      </tr>`;
            $('#tbodyinfopelayanan').append(addRow);
          }
        } else {
          $('#tbodyinfopelayanan').append('<tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>');
        }

        var arrBaptisan = result.arrBaptisan;
        if (arrBaptisan.length > 0) {
          $('#tdbaptisantanggalakta').html(arrBaptisan[0]['noakta'] + " / " + arrBaptisan[0]['tglakta']);
          $('#tdbaptisantanggalbaptis').html(arrBaptisan[0]['tglbaptis']);
          $('#tdbaptisannamagereja').html(arrBaptisan[0]['namagereja']);
          $('#tdbaptisannamagembala').html(arrBaptisan[0]['namagembala']);

          if (arrBaptisan[0]['tempatbaptis'] == 'Elshaddai') {
            $('#trFileAkta').hide();
          } else {
            $('#trFileAkta').show();
            $('#linkFileAktaBaptis').attr("href", arrBaptisan[0]['fileaktalokasi']);
          }
        } else {
          $('#tdbaptisantanggalakta').html('');
          $('#tdbaptisantanggalbaptis').html('');
          $('#tdbaptisannamagereja').html('');
          $('#tdbaptisannamagembala').html('');
          $('#trFileAkta').hide();
        }

        var rskelas = result.rskelas;
        $('#tbodyinfokelas').empty();
        for (var i = 0; i < rskelas.length; i++) {
          if (rskelas[i]['statuslulus'] == '1') {
            var addText = `<tr>
                        <td>` + rskelas[i]['namakelas'] + `</td>
                        <td><i class="fa fa-check text-success"></i></td>
                        <td>` + rskelas[i]['tglsertifikat'] + `</td>
                        <td><a href="<?php echo site_url('registrasikelas/cetaksertifikat/') ?>` + rskelas[i]['idregistrasikelas'] + `" class="btn btn-primary btn-sm" target="_blank"> <i class="fa fa-pring"></i> Lihat Sertifikat</a></td>
                      </tr>
        `;
          } else {
            var addText = `<tr>
                        <td>` + rskelas[i]['namakelas'] + `</td>
                        <td><i class="fas fa-times text-danger"></i></td>
                        <td>-</td>
                        <td></td>
                      </tr>
        `;
          }
          $('#tbodyinfokelas').append(addText);
        }
      })
      .fail(function() {
        console.log("error get get_info_jemaat");
      });

  });

  function kosongkanModalInfoJemaat(argument) {
    $('#modaljudulnama').html('');
    $('#tbodyinfopelayanan').empty();
    $('#tdbaptisantanggalakta').html('');
    $('#tdbaptisantanggalbaptis').html('');
    $('#tdbaptisannamagereja').html('');
    $('#tdbaptisannamagembala').html('');
    $('#tbodyinfokelas').empty();
  }
</script>

</body>
</html>