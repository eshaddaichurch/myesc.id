<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Review Dokumen</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo (site_url('dokumen')) ?>">Review Dokumen</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">

            <!-- Info jemaat + form aksi -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $pesan = $this->session->flashdata('pesan');
                        if (!empty($pesan)) {
                            echo $pesan;
                        }
                        ?>

                        <h5 class="text-gray"><?php echo $rowDokumen->namadokumen ?: $kodedokumen; ?></h5>
                        <hr>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">Nama</td>
                                    <td style="width: 5%;">:</td>
                                    <td><?php echo $rowDokumen->namalengkap; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?php echo $rowDokumen->nik; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><?php echo $rowDokumen->email; ?></td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>:</td>
                                    <td><?php echo $rowDokumen->nohp; ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Upload</td>
                                    <td>:</td>
                                    <td><?php echo formatHariTanggalJam($rowDokumen->tglupload); ?></td>
                                </tr>
                                <tr>
                                    <td>Status Saat Ini</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                        if ($rowDokumen->statusdokumen == 'Menunggu Review') {
                                            echo '<span class="badge badge-warning">Menunggu Review</span>';
                                        } elseif ($rowDokumen->statusdokumen == 'Disetujui') {
                                            echo '<span class="badge badge-success">Disetujui</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">Ditolak</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if (!empty($rowDokumen->catatanreview)) { ?>
                                <tr>
                                    <td>Catatan Sebelumnya</td>
                                    <td>:</td>
                                    <td><?php echo nl2br(htmlspecialchars($rowDokumen->catatanreview)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <form action="<?php echo site_url('dokumen/proses') ?>" method="post" id="formReview">
                            <input type="hidden" name="idjemaat" value="<?php echo $idjemaat; ?>">
                            <input type="hidden" name="kodedokumen" value="<?php echo $kodedokumen; ?>">
                            <div class="form-group">
                                <label>Catatan Review <small class="text-muted">(wajib diisi jika ditolak)</small></label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Contoh: Foto blur/tidak jelas, dokumen sudah kadaluarsa, tidak sesuai, dll."></textarea>
                            </div>
                            <div class="d-flex" style="gap: 8px;">
                                <button type="submit" name="aksi" value="setuju" class="btn btn-success flex-fill">
                                    <i class="fa fa-check"></i> Setujui
                                </button>
                                <button type="submit" name="aksi" value="tolak" class="btn btn-danger flex-fill" id="btnTolak">
                                    <i class="fa fa-times"></i> Tolak
                                </button>
                            </div>
                            <a href="<?php echo site_url('dokumen') ?>" class="btn btn-default btn-block mt-2">
                                <i class="fa fa-chevron-circle-left"></i> Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview dokumen -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Preview Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($rowDokumen->namafile)) { ?>
                            <iframe
                                src="<?php echo base_url('uploads/jemaat/' . $rowDokumen->namafile) ?>"
                                width="100%" height="700px" style="border:1px solid #ddd; border-radius:6px;">
                            </iframe>
                            <div class="mt-2">
                                <a href="<?php echo base_url('uploads/jemaat/' . $rowDokumen->namafile) ?>"
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-external-link-alt"></i> Buka di Tab Baru
                                </a>
                            </div>
                        <?php } else { ?>
                            <p class="text-muted">Tidak ada file dokumen.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('template/footer') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#btnTolak').on('click', function(e) {
            var catatan = $('#catatan').val().trim();
            if (!catatan) {
                e.preventDefault();
                swal('Catatan Wajib Diisi', 'Mohon isi catatan alasan penolakan sebelum menolak dokumen ini.', 'warning');
            }
        });
    });
</script>

</body>

</html>