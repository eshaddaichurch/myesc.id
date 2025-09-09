<?php $this->load->view('template/festavalive/header'); ?>

<body>
<main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="about-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4 mb-lg-0">
                    <h2 class="text-white text-center mb-4 mt-3">PERMOHONAN BAPTISAN</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="page-content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 p-5">
                    <form action="<?php echo site_url('baptisan/simpan') ?>" method="POST" id="form">
                        <input type="hidden" name="idcarebaptisan" id="idcarebaptisan">

                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <h5 id="lbljudul">Tambah Permohonan Baptisan</h5>
                            </div>

                            <!-- Nomor HP -->
                            <div class="col-12">
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label">No HP Yang Bisa Dihubungi</label>
                                    <div class="col-md-8">
                                        <input type="text" 
                                               name="nohpyangbisadihubungi" 
                                               id="nohpyangbisadihubungi" 
                                               class="form-control" 
                                               placeholder="Nomor HP">
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12">
                                <div class="form-group row mb-3">
                                    <label class="col-md-4 col-form-label">Keterangan Permohonan</label>
                                    <div class="col-md-8">
                                        <textarea name="keteranganpermohonan" 
                                                  id="keteranganpermohonan" 
                                                  class="form-control" 
                                                  rows="5" 
                                                  placeholder="Keterangan (Optional)"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-12 text-center mt-5 d-none d-md-block">
                                <a href="<?php echo site_url('baptisan') ?>" class="btn btn-default mr-1">Kembali</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Ajukan Permohonan
                                </button>
                            </div>
                            <div class="col-12 text-center mt-5 d-md-none d-sm-block">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Ajukan Permohonan
                                </button>
                                <a href="<?php echo site_url('baptisan') ?>" class="btn btn-default mr-1">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<?php $this->load->view('template/festavalive/footer'); ?>

<script>
    var idcarebaptisan = "<?php echo $idcarebaptisan; ?>";

    $(document).ready(function() {
        // Jika edit data
        if (idcarebaptisan != "") {
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url("baptisan/get_edit_data") ?>',
                data: { idcarebaptisan: idcarebaptisan },
                dataType: 'json',
                encode: true
            })
            .done(function(result) {
                $("#idcarebaptisan").val(result.idcarebaptisan);
                $("#nohpyangbisadihubungi").val(result.nohpyangbisadihubungi);
                $("#keteranganpermohonan").val(result.keteranganpermohonan);
            });

            $("#lbljudul").html("Ubah Permohonan Baptisan");
        } else {
            $("#lbljudul").html("Tambah Permohonan Baptisan");
        }

        // Validasi
        $("#form").bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nohpyangbisadihubungi: {
                    validators: {
                        notEmpty: {
                            message: "Nomor hp yang bisa dihubungi tidak boleh kosong"
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>
