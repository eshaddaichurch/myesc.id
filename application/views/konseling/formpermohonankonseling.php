<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

body {
  font-family: 'Figtree', sans-serif;
  background-color: #e8d5a7;
  padding-top: 60px;
  margin: 0;
}

:root {
  --main-blue: #0076bd;
}

.permohonan-form-section {
  background: #e8d5a7;
}

.card {
  background: #ffffff;
  border-radius: 1rem;
}

.form-label {
  font-weight: 600;
  margin-bottom: 6px;
}

.form-control, .form-select {
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  border: 1px solid #ced4da;
  font-size: 1rem;
}

.form-control:focus, .form-select:focus {
  border-color: #86b7fe;
  box-shadow: 0 0 0 0.1rem rgba(13, 110, 253, 0.25);
}

.btn-primary {
  background-color: #ff5008;
  border: none;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  border-radius: 0.5rem;
}

.btn-outline-secondary {
  border: 1px solid #6c757d;
  color: #6c757d;
  background-color: transparent;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
}

.btn-outline-secondary:hover {
  background-color: #6c757d;
  color: white;
}

small#charCount {
  display: block;
  margin-top: 6px;
  color: #666;
  font-size: 0.85rem;
}

textarea.form-control {
  resize: vertical;
}

@media (max-width: 576px) {
  .form-control, .form-select {
    font-size: 0.95rem;
  }
}

</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

        <section class="page-content section-padding">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-12 p-5">
                        <form action="<?php echo site_url('konseling/simpan') ?>" method="POST" id="form">
                            <input type="hidden" name="idcarekonseling" id="idcarekonseling">
                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <h5 id="lbljudul">Tambah Permohonan Konseling</h5>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-3">
                                        <label for="" class="col-md-4">Tgl & Jam Permohonan</label>
                                        <div class="col-md-8">
                                            <input type="datetime-local" name="tglpermohonan" id="tglpermohonan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="" class="col-md-4">No HP Yang Bisa Dihubungi</label>
                                        <div class="col-md-8">
                                            <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="" class="col-md-4">Keterangan Permohonan</label>
                                        <div class="col-md-8">
                                            <textarea name="keteranganpermohonan" id="keteranganpermohonan" class="form-control" rows="10" placeholder="Keterangan (Optional)"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-5 d-none d-md-block">
                                    <a href="<?php echo site_url('konseling') ?>" class="btn btn-default mr-1">Kembali</a>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ajukan Permohonan</button>
                                </div>
                                <div class="col-12 text-center mt-5 d-md-none d-sm-block">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ajukan Permohonan</button>
                                    <a href="<?php echo site_url('konseling') ?>" class="btn btn-default mr-1">Kembali</a>
                                </div>



                            </div>
                        </form>
                    </div>




                </div>
            </div>
        </section>









    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
        var idcarekonseling = "<?php echo $idcarekonseling; ?>";
        // console.log(idcarekonseling);

        $(document).ready(function() {

            //---------------------------------------------------------> JIKA EDIT DATA
            if (idcarekonseling != "") {


                $.ajax({
                        type: 'GET',
                        url: '<?php echo site_url("konseling/get_edit_data") ?>',
                        data: {
                            idcarekonseling: idcarekonseling
                        },
                        dataType: 'json',
                        encode: true
                    })
                    .done(function(result) {
                        // console.log(result);
                        $("#idcarekonseling").val(result.idcarekonseling);
                        $("#tglpermohonan").val(result.tglpermohonan);
                        $("#nohpyangbisadihubungi").val(result.nohpyangbisadihubungi);
                        $("#keteranganpermohonan").val(result.keteranganpermohonan);

                        if (result.namajemaat == 'toni') {
                            return;
                        }
                    });
                // command2

                $("#lbljudul").html("Ubah Permohonan Konseling");
            } else {
                $("#lbljudul").html("Tambah Permohonan Konseling");
            }


            $("#form").bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    tglpermohonan: {
                        validators: {
                            notEmpty: {
                                message: "tanggal permohonan tidak boleh kosong"
                            },
                        }
                    },
                    nohpyangbisadihubungi: {
                        validators: {
                            notEmpty: {
                                message: "Nomor hp yang bisa dihubungi tidak boleh kosong"
                            },
                        }
                    },
                },
                onSuccess: function(e, data) {
                    // e.preventDefault();

                    // console.log("1");

                    // if ($('#optradioBergabung1').prop('checked') === false && $('#optradioBergabung2').prop('checked') === false) {
                    //   e.preventDefault();
                    //   swal("Upss", "Silahkan pilih apakah anda hanya ingin berkunjung atau ingin bergabung di El Shaddai Church.", "info")
                    //     .then(function() {
                    //       $('#optradioBergabung1').focus();
                    //     });
                    //   return false;
                    // }
                    // console.log("3");

                    // $('#btnDaftar').prop('disabled', true);
                }
            });
        });
    </script>

   </div>
</body>
</html>