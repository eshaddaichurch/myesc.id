<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Konseling</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo (site_url('konseling')) ?>">Konseling</a></li>
            <li class="breadcrumb-item active" id="lblactive">Proses</li>
        </ol>

    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">



        <form action="<?php echo (site_url('konseling/simpan')) ?>" method="post" id="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="cardcontent">
                        <div class="card-body">

                            <div class="col-md-12">
                                <?php
                                $pesan = $this->session->flashdata("pesan");
                                if (!empty($pesan)) {
                                    echo $pesan;
                                }
                                ?>
                            </div>

                            <h3 class="text-gray">Permohonan Konseling</h3>
                            <hr>

                            <input type="hidden" name="idcarekonseling" id="idcarekonseling" value="<?php echo $rowKonseling->idcarekonseling ?>">

                            <div class="form-group row">
                                <div class="col-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-infojemaat">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%;">Nama Pemohon</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo $rowKonseling->namalengkap; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Jenis Kelamin</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo $rowKonseling->jeniskelamin; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tanggal Input</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo formatHariTanggal($rowKonseling->tglinsert); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tanggal Permohonan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo formatHariTanggalJam($rowKonseling->tglpermohonan); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Email</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo $rowKonseling->email; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">No HP</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo $rowKonseling->nohp; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Keterangan Permohonan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td style="width: 75%;"><?php echo $rowKonseling->keteranganpermohonan; ?></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="" class="col-md-4">Penanggung Jawab</label>
                                        <div class="col-md-8">
                                            <input type="text" name="namapenanggungjawab" id="namapenanggungjawab" class="form-control" placeholder="Cari nama penanggung jawab">
                                            <input type="hidden" name="idpenanggungjawab" id="idpenanggungjawab">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="" class="col-md-4">Tempat/ Tanggal Konseling</label>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="tempatkonseling" id="tempatkonseling" class="form-control" placeholder="Tempat konseling">
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    /
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="datetime-local" name="tglkonseling" id="tglkonseling" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="" class="col-md-4">Keterangan</label>
                                        <div class="col-md-8">
                                            <textarea name="keteranganadmin" id="keteranganadmin" class="form-control" rows="5" placeholder="Keterangan"><?php echo $rowKonseling->keteranganadmin ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div> <!-- ./card-body -->

                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary float-right" name="status" value="Disetujui">
                            <input type="submit" class="btn btn-danger float-right mr-1" name="status" value="Ditolak">

                            <a href="<?php echo (site_url('konseling')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div>
        </form>





    </div>
</div> <!-- /.row -->
<!-- Main row -->



<?php $this->load->view("template/footer") ?>



<script type="text/javascript">
    var idcarekonseling = "<?php echo ($idcarekonseling) ?>";
    console.log("1");

    $(document).ready(function() {
        console.log("2");

        $('.select2').select2();


        //---------------------------------------------------------> JIKA EDIT DATA
        if (idcarekonseling != "") {
            $.ajax({
                    type: 'POST',
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
                    $("#namapenanggungjawab").val(result.namapenanggungjawab);
                    $("#idpenanggungjawab").val(result.idpenanggungjawab);
                    $("#tempatkonseling").val(result.tempatkonseling);
                    $("#tglkonseling").val(result.tglkonseling);
                    $("#keteranganadmin").val(result.keteranganadmin);

                    console.log("3");

                });
        }

        console.log("4");

        //----------------------------------------------------------------- > validasi
        $("#form").bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                namapenanggungjawab: {
                    validators: {
                        notEmpty: {
                            message: "nama penanggung jawab tidak boleh kosong"
                        },
                    }
                },
                tempatkonseling: {
                    validators: {
                        notEmpty: {
                            message: "tempat konseling tidak boleh kosong"
                        },
                    }
                },
                tglkonseling: {
                    validators: {
                        notEmpty: {
                            message: "tanggal konseling tidak boleh kosong"
                        },
                    }
                },
            }
        });

        $("form").attr('autocomplete', 'off');
        $("#rtrw").mask("000/000", {
            placeholder: "000/000"
        });
    }); //end (document).ready


    $("#namapenanggungjawab").autocomplete({
            minLength: 1,
            source: function(request, response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Ajax/autocomplateJemaat'); ?>",
                    dataType: "json",
                    data: {
                        'cari': request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            focus: function(event, ui) {
                $('#idpenanggungjawab').val(ui.item.idjemaat);
                return false;
            },
            select: function(event, ui) {
                $('#namapenanggungjawab').val(ui.item.namalengkap);
                $('#idpenanggungjawab').val(ui.item.idjemaat);
                return false;
            }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {

            return $("<li>")
                .append("<div class='row'><div class='col-12'><strong>" + item.namalengkap + "</strong></div><div class='col-12'><small>Nomor AJ: " + item.noaj + "</small></div></div>")
                .appendTo(ul);
        };
</script>

</body>

</html>