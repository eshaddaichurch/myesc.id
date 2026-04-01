<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Master Ruangan</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
      <li class="breadcrumb-item active">Master Ruangan</li>
    </ol>
  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">
    <div class="card" id="cardcontent">
      <div class="card-body">

        <?php
        $pesan = $this->session->flashdata('pesan');
        if (!empty($pesan))
            echo $pesan;
        ?>

        <div class="mb-3">
          <a href="<?= site_url('ruangan/tambah') ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Tambah Ruangan
          </a>
        </div>

        <table id="tblRuangan" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th width="4%">No</th>
              <th width="6%">Foto</th>
              <th width="18%">Nama Ruangan</th>
              <th width="12%">Lokasi</th>
              <th width="9%">Kapasitas</th>
              <th width="22%">Fasilitas</th>
              <th width="9%">Status</th>
              <th width="20%">Aksi</th>
            </tr>
          </thead>
        </table>

      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

<script>
$(document).ready(function () {

  $('#tblRuangan').DataTable({
    processing : true,
    serverSide : true,
    ajax: {
      url  : '<?= site_url('ruangan/datatablesource') ?>',
      type : 'POST',
    },
    columns: [
      { data: 0, className: 'text-center' },
      { data: 1, className: 'text-center', orderable: false },
      { data: 2 },
      { data: 3 },
      { data: 4, className: 'text-center' },
      { data: 5 },
      { data: 6, className: 'text-center' },
      { data: 7, className: 'text-center', orderable: false },
    ],
    language: {
      processing : "Memuat data...",
      search     : "Cari:",
      lengthMenu : "Tampilkan _MENU_ data",
      zeroRecords: "Data tidak ditemukan",
      info       : "Menampilkan _START_ - _END_ dari _TOTAL_ data",
      paginate   : { previous: "Sebelumnya", next: "Berikutnya" }
    }
  });

  $(document).on('click', '#hapus', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    Swal.fire({
      title             : 'Yakin ingin menghapus?',
      text              : 'Data ruangan akan dihapus permanen!',
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

});
</script>

</body>
</html>