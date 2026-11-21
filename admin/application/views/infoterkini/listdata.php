<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

$aturan = info_aturan_gambar();
$totalInfo = (int) $statistik['total'];
$totalAktif = (int) $statistik['aktif'];
$totalNonaktif = (int) $statistik['nonaktif'];
?>

<style>
  .it-stat { border: 0; border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.06); }
  .it-stat-body { display: flex; align-items: center; gap: 14px; padding: 16px 18px; }
  .it-ico { width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #fff; flex-shrink: 0; }
  .it-val { font-size: 22px; font-weight: 800; line-height: 1; color: #1C1B1A; }
  .it-lbl { font-size: 12px; color: #8A8A8A; margin-top: 4px; }
  .it-card { border: 0; border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.06); overflow: hidden; }
  .it-table thead th { border-bottom: 0; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; background: #1C1B1A; color: #fff; }
  .it-table td { vertical-align: middle; }
  .it-thumb { width: 160px; height: 80px; object-fit: cover; border-radius: 10px; background: #F5F4F2; box-shadow: 0 2px 8px rgba(0,0,0,.12); display: block; }
  .it-judul { font-weight: 700; color: #1C1B1A; font-size: 14px; line-height: 1.3; }
  .it-sub { font-size: 12px; color: #8A8A8A; }
  .it-link { font-size: 12px; color: #FF5008; max-width: 240px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; vertical-align: middle; }
  .it-urutan { display: inline-block; min-width: 36px; padding: 4px 10px; border-radius: 999px; background: #FFEFE5; color: #FF5008; font-weight: 800; font-size: 13px; }
  .it-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
  .it-badge.aktif { background: #E6F7EE; color: #1E8E4E; }
  .it-badge.nonaktif { background: #F1F1F1; color: #7A7A7A; }
  .it-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
  .it-aksi .btn { width: 34px; height: 34px; padding: 0; line-height: 34px; border-radius: 10px; margin: 0 2px; }
  .it-aksi .btn:active { transform: scale(.94); }
  .it-tip { border-radius: 12px; border: 0; background: #FFF6F0; color: #7A4A2E; font-size: 13px; }
</style>

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

    <!-- Ringkasan -->
    <div class="row mb-3">
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card it-stat">
          <div class="it-stat-body">
            <div class="it-ico" style="background:#1C1B1A;"><i class="fa fa-layer-group"></i></div>
            <div>
              <div class="it-val"><?= $totalInfo ?></div>
              <div class="it-lbl">Total info</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card it-stat">
          <div class="it-stat-body">
            <div class="it-ico" style="background:#1E8E4E;"><i class="fa fa-eye"></i></div>
            <div>
              <div class="it-val"><?= $totalAktif ?></div>
              <div class="it-lbl">Tampil di aplikasi</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card it-stat">
          <div class="it-stat-body">
            <div class="it-ico" style="background:#8A8A8A;"><i class="fa fa-eye-slash"></i></div>
            <div>
              <div class="it-val"><?= $totalNonaktif ?></div>
              <div class="it-lbl">Nonaktif</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Aturan gambar -->
    <div class="alert it-tip mb-3">
      <i class="fa fa-info-circle"></i>
      <strong>Aturan gambar:</strong> rekomendasi <b><?= $aturan['rekomendasi'] ?></b>,
      format <?= $aturan['format'] ?>, maksimal <?= $aturan['maks_teks'] ?>.
      Gambar tampil sebagai kartu di aplikasi.
    </div>

    <div class="card it-card">
      <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-bottom:1px solid #F1ECE7;">
        <div>
          <strong style="font-size:16px;">Daftar Info Terkini</strong>
          <div class="it-sub">Urut sesuai kolom Urutan, lalu yang terbaru</div>
        </div>
        <a href="<?= site_url('infoterkini/tambah') ?>" class="btn btn-primary" style="border-radius:12px;">
          <i class="fa fa-plus"></i> Tambah Info
        </a>
      </div>

      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="tabelInfoTerkini" class="table it-table table-hover mb-0" style="width:100%;">
            <thead>
              <tr>
                <th class="text-center" style="width:60px;">No</th>
                <th style="width:190px;">Gambar</th>
                <th>Judul</th>
                <th class="text-center" style="width:100px;">Urutan</th>
                <th class="text-center" style="width:130px;">Status</th>
                <th class="text-center" style="width:150px;">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer') ?>

<script type="text/javascript">
  var table;

  $(document).ready(function () {
    table = $('#tabelInfoTerkini').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [[3, 'asc']],
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      "ajax": {
        "url": "<?= site_url('infoterkini/datatablesource') ?>",
        "type": "POST"
      },
      "columnDefs": [
        { "targets": [0], "orderable": false, "className": "dt-body-center" },
        { "targets": [1], "orderable": false },
        { "targets": [2], "className": "dt-body-left" },
        { "targets": [3], "className": "dt-body-center" },
        { "targets": [4], "className": "dt-body-center" },
        { "targets": [5], "orderable": false, "className": "dt-body-center" }
      ],
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data",
        "infoFiltered": "(disaring dari _MAX_ data)",
        "zeroRecords": "Data tidak ditemukan",
        "processing": "Memuat data...",
        "paginate": { "first": "Awal", "last": "Akhir", "next": "Lanjut", "previous": "Balik" }
      }
    });
  });

  $(document).on("click", ".btnHapus", function (e) {
    e.preventDefault();
    var link = $(this).attr("href");

    bootbox.confirm("Anda yakin ingin menghapus info ini? Gambar juga akan ikut dihapus.", function (result) {
      if (result) {
        document.location.href = link;
      }
    });
  });
</script>

</body>
</html>