 <?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Whatsapp Blast</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('group')) ?>">Group</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">

                 
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <h3 class="text-gray">Kirim Pesan WhatsAPP ke Jemaat</h3><hr>                    
                    </div>

                    <div class="col-12 mb-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">TEXT WHATSAPP YANG AKAN DIKIRIM:</label>
                                    <textarea name="textWa" id="textWa" class="form-control" placeholder="Ketikkan text whatsapp yang akan dikirim" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button class="btn btn-sm btn-success float-right">Simpan Sebagai Template</button>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="">Template Text:</label>
                                                    </div>
                                                    <div class="col-12 text-lg">
                                                        <div class="badge badge-success template">
                                                            <a href="" class="text-white" data-template="selamatpaskah">Selamat Hari Paskah</a> <a href="" class="text-danger ml-2"><i class="fa fa-trash"></i></a>
                                                        </div>

                                                        <div class="badge badge-success template">
                                                            <a href="" class="text-white" data-template="selamatpaskah">Selamat Hari Minggu</a> <a href="" class="text-danger ml-2"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <label for="">Tags:</label>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-sm btn-secondary btn-tag" data-tag="[[idjemaat]]">[[idjemaat]]</button>
                                                <button class="btn btn-sm btn-secondary btn-tag" data-tag="[[namalengkap]]">[[namalengkap]]</button>
                                                <button class="btn btn-sm btn-secondary btn-tag" data-tag="[[email]]">[[email]]</button>
                                                <button class="btn btn-sm btn-secondary btn-tag" data-tag="[[nohp]]">[[nohp]]</button>                                                                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-sm-3">Status Pernikahan</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuspernikahanoption" id="statuspernikahan1" value="Semua" checked>
                                    <label class="form-check-label" for="statuspernikahan1">Semua</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuspernikahanoption" id="statuspernikahan2" value="Belum Kawin">
                                    <label class="form-check-label" for="statuspernikahan2">Belum Kawin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuspernikahanoption" id="statuspernikahan3" value="Kawin">
                                    <label class="form-check-label" for="statuspernikahan3">Kawin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuspernikahanoption" id="statuspernikahan4" value="Janda/ Duda">
                                    <label class="form-check-label" for="statuspernikahan4">Janda/ Duda</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-3">Status Jemaat</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusjemaatoption" id="statusjemaat1" value="Semua" checked>
                                    <label class="form-check-label" for="statusjemaat1">Semua</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusjemaatoption" id="statusjemaat2" value="Jemaat">
                                    <label class="form-check-label" for="statusjemaat2">Jemaat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusjemaatoption" id="statusjemaat3" value="Simpatisan">
                                    <label class="form-check-label" for="statusjemaat3">Simpatisan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusjemaatoption" id="statusjemaat4" value="Registered">
                                    <label class="form-check-label" for="statusjemaat4">Registered</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jeniskelaminoption" id="jeniskelamin1" value="Semua" checked>
                                    <label class="form-check-label" for="jeniskelamin1">Semua</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jeniskelaminoption" id="jeniskelamin2" value="Laki-laki">
                                    <label class="form-check-label" for="jeniskelamin2">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jeniskelaminoption" id="jeniskelamin3" value="Perempuan">
                                    <label class="form-check-label" for="jeniskelamin3">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Disciple Community</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="dcoption" id="dc1" value="Semua" checked>
                                            <label class="form-check-label" for="dc1">Semua</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="dcoption" id="dc2" value="Terpilih">
                                            <label class="form-check-label" for="dc2">Terpilih</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3" id="divDc" style="display:none;">
                                        <select name="iddc" id="iddc" class="form-control select2">
                                            <option value="Semua">Semua</option>
                                            <?php  
                                                foreach ($rsDc->result() as $row) {
                                                    echo '<option value="'.$row->iddc.'">'.$row->namadc.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-3">Usia</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="usiaoption" id="usia1" value="Semua" checked>
                                            <label class="form-check-label" for="usia1">Semua</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="usiaoption" id="usia2" value="Terpilih">
                                            <label class="form-check-label" for="usia2">Terpilih</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3" id="divUsia" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="number" name="usiaawal" id="usiaawal" class="form-control" placeholder="0" value="0">
                                            </div>
                                            <label for="" class="col-sm-1 text-center">SD</label>
                                            <div class="col-md-2">
                                                <input type="number" name="usiasampai" id="usiasampai" class="form-control" placeholder="0" value="0">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body bg-gray" style="height: 200px;">
                                                <div class="text-center display-block font-weight-bold">JUMLAH JEMAAT</div>
                                                <h1 class="text-center mt-3 mb-3" id="totalJemaat">0</h1>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body bg-success" style="height: 200px;">
                                                <div class="text-center display-block font-weight-bold">JUMLAH TERPILIH</div>
                                                <h1 class="text-center mt-3 mb-3" id="totalJemaatTerpilih">0</h1>
                                                <div class="text-center display-block">
                                                    <a href="#" class="text-white" id="btnLihatDetail">Lihat Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="button" class="btn btn-lg btn-success w-100"><i class="fab fa-whatsapp mr-2"></i> Kirim</button>
                    </div>

                    





                    

                    

                </div>

                                       

              </div> <!-- ./card-body -->

            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>





    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>


<?php $this->load->view('whatsappblast/modaldetail');

 ?>
<script type="text/javascript">
  
  
    $(document).ready(function() {

        $('.select2').select2();
        $("form").attr('autocomplete', 'off');
        getJumlahJemaat();
    }); 
  

    $('input[name="statuspernikahanoption"]').on('change', function() {
        getJumlahJemaat();
    }); 

    $('input[name="statusjemaatoption"]').on('change', function() {
        getJumlahJemaat();
    });

    $('input[name="jeniskelaminoption"]').on('change', function() {
        getJumlahJemaat();
    }); 

    $('input[name="dcoption"]').on('change', function() {
        if ($(this).val() === 'Terpilih') {
            $('#divDc').show();
        } else {
            $('#divDc').hide();
        }
        getJumlahJemaat();
    });


    $('input[name="usiaoption"]').on('change', function() {
        if ($(this).val() === 'Terpilih') {
            $('#divUsia').show();
        } else {
            $('#divUsia').hide();
        }
        getJumlahJemaat();
    });

    $('input[name="usiaawal"]').on('change', function() {
        getJumlahJemaat();
    });

    $('input[name="usiasampai"]').on('change', function() {
        getJumlahJemaat();
    });

    function getJumlahJemaat() {
        var jumlahjemaat = 0;
        
        var statuspernikahan = $('input[name="statuspernikahanoption"]:checked').val();
        var statusjemaat = $('input[name="statusjemaatoption"]:checked').val();
        var jeniskelamin = $('input[name="jeniskelaminoption"]:checked').val();
        var dcoption = $('input[name="dcoption"]:checked').val();
        var usiaoption = $('input[name="usiaoption"]:checked').val();
        var iddc = $('select[name="iddc"]').val();
        var usiaawal = $('input[name="usiaawal"]').val();
        var usiasampai = $('input[name="usiasampai"]').val();

        var formdata = {
            'statuspernikahan': statuspernikahan,
            'statusjemaat': statusjemaat,
            'jeniskelamin': jeniskelamin,
            'dcoption': dcoption,
            'iddc': iddc,
            'usiaoption': usiaoption,
            'usiaawal': usiaawal,
            'usiasampai': usiasampai,
        };
        
        //kosongkan tbody detail
        $('#tbodyDetailWaBlast').html("");

        $.ajax({
            url: '<?= site_url('whatsappblast/getJumlahJemaat') ?>',
            type: 'GET',
            dataType: 'json',
            data: formdata,
        })
        .done(function(response) {
            // console.log(response);
            $('#totalJemaatTerpilih').html(response.length);
            
            //tampilkan detail di modal
            var html = "";
            var no = 1;
            if (response.length > 0) {
                $.each(response, function(key, value){
                    html += "<tr>";
                    html += "<td class='text-center'>"+no+"</td>";
                    html += "<td class='text-left'>"+value.namalengkap+"</td>";
                    html += "<td class='text-center'>"+(value.namadc == null ? "-" : value.namadc)+"</td>";
                    html += "<td class='text-center'>"+value.nohp+"</td>";
                    html += "</tr>";
                    no++;
                });
                $("#tbodyDetailWaBlast").html(html);
                
            }else{
                html += "<tr>";
                html += "<td colspan='4' class='text-center'>Tidak Ada Data</td>";
                html += "</tr>";
                $("#tbodyDetailWaBlast").html(html);
            }
        })
        .fail(function() {
            console.log('error');
        });

        
    }

    $(document).on('click', '#btnLihatDetail', function(e) {
        e.preventDefault();
        $("#modalDetailWaBlast").modal("show");
    });

    $(document).on('click', '.btn-tag', function() {
        var tag = $(this).attr('data-tag');
        var textarea = $('#textWa')[0]; // Ambil DOM element (bukan jQuery object)
        
        var textWa = $('#textWa').val();
        var pos = textarea.selectionStart; // Posisi kursor saat ini
        
        // Insert tag di posisi kursor
        var textWaBaru = textWa.substring(0, pos) + tag + textWa.substring(pos);
        $('#textWa').val(textWaBaru);
        
        // Hitung posisi kursor baru
        var newPos = pos + tag.length;
        
        // Set ulang posisi kursor (start dan end sama = cursor, bukan seleksi)
        textarea.setSelectionRange(newPos, newPos);
        
        // Focus ke textarea
        $('#textWa').focus();
    });
</script>

</body>
</html>
