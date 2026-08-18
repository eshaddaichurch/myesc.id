<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");

?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Volunteer</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">Volunteer</li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-header">
          <h5 class="card-title">List Data Volunteer Gereja Elshaddai</h5>
          <a href="<?php echo(site_url('volunteer/tambah')) ?>" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
          <a href="<?php echo(site_url('volunteer/kelompok')) ?>" class="btn btn-sm btn-default float-right mr-1"><i class="fa fa-sitemap"></i> Tampilan Kelompok</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <?php 
                $pesan = $this->session->flashdata("pesan");
                if (!empty($pesan)) {
                  echo $pesan;
                }
              ?>
            </div> 

            <!-- ===== FILTER ===== -->
            <div class="col-md-12 mb-3">
              <div class="row">
                <div class="col-md-4">
                  <label class="col-form-label">Filter Departement</label>
                  <select id="filter_iddepartement" class="form-control select2">
                    <option value="">Semua Departement</option>
                    <?php
                      $rsdepartement = $this->db->query("select * from departement where statusaktif='Aktif' order by namadepartement");
                      if ($rsdepartement->num_rows() > 0) {
                        foreach ($rsdepartement->result() as $rowdepartement) {
                          echo '<option value="' . $rowdepartement->iddepartement . '">' . $rowdepartement->namadepartement . '</option>';
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="col-form-label">Filter Pelayanan</label>
                  <select id="filter_idpelayanan" class="form-control select2">
                    <option value="">Semua Pelayanan</option>
                    <?php
                      $rspelayanan = $this->db->query("select * from pelayanan where statusaktif='Aktif' order by namapelayanan");
                      if ($rspelayanan->num_rows() > 0) {
                        foreach ($rspelayanan->result() as $rowpelayanan) {
                          echo '<option value="' . $rowpelayanan->idpelayanan . '">' . $rowpelayanan->namapelayanan . '</option>';
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="col-form-label">Filter Status</label>
                  <select id="filter_statusaktif" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                  <button type="button" id="btnResetFilter" class="btn btn-default mb-1" title="Reset Filter"><i class="fa fa-undo"></i></button>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <!-- datatable -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-condesed" id="table">
                  <thead>
                    <tr class="bg-primary" style="">
                      <th style="width: 5%; text-align: center;">No</th>
                      <th style="text-align: center; width: 18%;">Nama Jemaat</th>
                      <th style="text-align: center;">Departement &amp; Pelayanan</th>
                      <th style="text-align: center; width: 13%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>              
                </table>
              </div>

            </div>



          </div> <!-- /.row -->
        </div> <!-- ./card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->
  <!-- Main row -->




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

  var table;

  $(document).ready(function() {

    $('.select2').select2();

    //defenisi datatable
    table = $("#table").DataTable({ 
        "select": true,
        "processing": true, 
        "serverSide": true, 
        "order": [], 
         "ajax": {
            "url": "<?php echo site_url('volunteer/datatablesource')?>",
            "type": "POST",
            "data": function(d) {
                d.filter_iddepartement = $('#filter_iddepartement').val();
                d.filter_idpelayanan   = $('#filter_idpelayanan').val();
                d.filter_statusaktif   = $('#filter_statusaktif').val();
            }
        },
        "columnDefs": [
                        { "targets": [ 0 ], "orderable": false, "className": "dt-body-center" },
                        { "targets": [ 1 ], "className": "dt-body-center" },
                        { "targets": [ 2 ], "orderable": false, "className": "dt-body-left" },
                        { "targets": [ 3 ], "orderable": false, "className": "dt-body-center" },
        ],
 
    });

    // -------------------------> Reload datatable saat filter berubah
    $(document).on('change', '#filter_iddepartement, #filter_idpelayanan, #filter_statusaktif', function() {
      table.ajax.reload();
    });

    // -------------------------> Reset semua filter
    $(document).on('click', '#btnResetFilter', function() {
      $('#filter_iddepartement').val('').trigger('change.select2');
      $('#filter_idpelayanan').val('').trigger('change.select2');
      $('#filter_statusaktif').val('');
      table.ajax.reload();
    });

  }); //end (document).ready

  
  $(document).on("click", "#hapus", function(e) {
    var link = $(this).attr("href");
    e.preventDefault();
    bootbox.confirm("Anda yakin ingin menghapus data ini ?", function(result) {
      if (result) {
        document.location.href = link;
      }
    });
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