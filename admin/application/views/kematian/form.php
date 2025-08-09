<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Permohonan Pelayanan Kematian</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo (site_url('kematian')) ?>">Permohonan Pelayanan Kematian</a></li>
            <li class="breadcrumb-item active" id="lblactive">Proses</li>
        </ol>

    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">



        <form action="<?php echo (site_url('kematian/simpan')) ?>" method="post" id="form">
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

                            <input type="hidden" name="idkematian" id="idkematian" value="<?php echo ($idkematian) ?>">
                            
                            <div class="row">
                                
                                <div class="col-12">
                                    <h3 class="text-gray">Informasi Pemohon</h3>                                
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="" class="">Tanggal Permohonan</label>
                                        <input type="date" name="tglpermohonan" id="tglpermohonan" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" >Nama Pemohon</label>
                                        <input type="text" name="namapemohon" id="namapemohon" class="form-control" placeholder="Nama Pemohoan" autofocus="">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="">Jenis Kelamin</label>
                                        <select name="jeniskelaminpemohon" id="jeniskelaminpemohon" class="form-control">
                                            <option value="">Pilih jenis kelamin...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="">No HP Pemohon</label>
                                        <input type="text" name="nohppemohon" id="nohppemohon" class="form-control" placeholder="No HP pemohon">
                                    </div>
                                </div>


                                <div class="col-12 mt-5">
                                    <h3 class="text-gray">Informasi Yang Meninggal</h3>                                
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="" class="">Nama Yang Meninggal</label>
                                        <input type="text" name="namayangmeninggal" id="namayangmeninggal" class="form-control" placeholder="Nama yang meninggal">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="">Tanggal Meninggal</label>
                                        <input type="date" name="tglmeninggal" id="tglmeninggal" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="">Umur</label>
                                        <input type="number" name="umuryangmeninggal" id="umuryangmeninggal" class="form-control" placeholder="0" value="">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="">Jenis Kelamin</label>
                                        <select name="jeniskelaminyangmeninggal" id="jeniskelaminyangmeninggal" class="form-control">
                                            <option value="">Pilih jenis kelamin...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="">Hubungan Keluarga</label>
                                        <select name="hubungankeluarga" id="hubungankeluarga" class="form-control">
                                            <option value="">Pilih hubungan keluarga...</option>
                                            <option value="Ayah/ Ibu">Ayah/ Ibu</option>
                                            <option value="Anak">Anak</option>
                                            <option value="Kakak/ Adik">Kakak/ Adik</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <h3 class="text-gray">Informasi Penanggung Jawab</h3>                                
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
                                        <label for="" class="col-md-4">Keterangan</label>
                                        <div class="col-md-8">
                                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                                        </div>
                                    </div>
                                </div>



                            </div>






                        </div> <!-- ./card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right mr-1"><i class="fa fa-save mr-1"></i>Simpan</button>
                            <a href="<?php echo (site_url('kematian')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
    var idkematian = "<?php echo ($idkematian) ?>";

    $(document).ready(function() {

        $('.select2').select2();
        //---------------------------------------------------------> JIKA EDIT DATA
        if (idkematian != "") {
            $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("kematian/get_edit_data") ?>',
                    data: {
                        idkematian: idkematian
                    },
                    dataType: 'json',
                    encode: true
                })
                .done(function(result) {
                    console.log(result);
                    $("#idkematian").val(result.idkematian);
                    $("#tglpermohonan").val(result.tglpermohonan);
                    $("#namapemohon").val(result.namapemohon);
                    $("#jeniskelaminpemohon").val(result.jeniskelaminpemohon);
                    $("#nohppemohon").val(result.nohppemohon);
                    $("#namayangmeninggal").val(result.namayangmeninggal);
                    $("#tglmeninggal").val(result.tglmeninggal);
                    $("#umuryangmeninggal").val(result.umuryangmeninggal);
                    $("#jeniskelaminyangmeninggal").val(result.jeniskelaminyangmeninggal);
                    $("#hubungankeluarga").val(result.hubungankeluarga);



                    $("#namapenanggungjawab").val(result.namapenanggungjawab);
                    $("#idpenanggungjawab").val(result.idpenanggungjawab);
                    $("#keterangan").val(result.keteranganadmin);
                    console.log("3");

                });
        }



        $("#form").bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                tglpermohonan: {
                    validators:{
                        notEmpty: {
                            message: "tglpermohonan tidak boleh kosong"
                        },
                    }
                },
                namapemohon: {
                    validators:{
                        notEmpty: {
                            message: "nama pemohon tidak boleh kosong"
                        },
                    }
                },
                jeniskelaminpemohon: {
                    validators:{
                        notEmpty: {
                            message: "jeniskelaminpemohon tidak boleh kosong"
                        },
                    }
                },
                nohppemohon: {
                    validators:{
                        notEmpty: {
                            message: "nomor hp pemohon tidak boleh kosong"
                        },
                    }
                },
                namayangmeninggal: {
                    validators:{
                        notEmpty: {
                            message: "nama yang meninggal tidak boleh kosong"
                        },
                    }
                },
                tglmeninggal: {
                    validators:{
                        notEmpty: {
                            message: "tgl meninggal tidak boleh kosong"
                        },
                    }
                },
                jeniskelaminyangmeninggal: {
                    validators:{
                        notEmpty: {
                            message: "jenis kelamin yang meninggal tidak boleh kosong"
                        },
                    }
                },
                hubungankeluarga: {
                    validators:{
                        notEmpty: {
                            message: "hubungankeluarga tidak boleh kosong"
                        },
                    }
                },
                namapenanggungjawab: {
                    validators:{
                        notEmpty: {
                            message: "namapenanggungjawab tidak boleh kosong"
                        },
                    }
                },
                keterangan: {
                    validators:{
                        notEmpty: {
                            message: "keterangan tidak boleh kosong"
                        },
                    }
                },
                umuryangmeninggal: {
                    validators:{
                        notEmpty: {
                            message: "umur yang meninggal tidak boleh kosong"
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