<!-- jQuery dulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



    <script>
    $(document).on('click', '#btnDaftar', function(e) {
      var idjadwalevent = $(this).attr('data-idjadwalevent');
      e.preventDefault();

      $.ajax({
        url: '<?= site_url('nextstep/cekPersyaratan') ?>',
        type: 'GET',
        dataType: 'json',
        data: {'idjadwalevent': idjadwalevent},
      })
      .done(function(response) {
        console.log(response);

        if (response.success) {



            swal({
                    title: "Daftar Kelas?",
                    text: "Anda ingin mendaftar di kelas ini?",
                    icon: "warning",
                    buttons: ["Batal!", "Ya!"],
                    dangerMode: true,
                    })
                    .then((daftarkelas) => {
                    if (daftarkelas) {

                        $.ajax({
                            url: '<?php echo site_url('nextstep/daftar') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                            'idjadwalevent': idjadwalevent
                            },
                        })
                        .done(function(daftarResult) {
                            console.log(daftarResult);

                            if (daftarResult.success) {
                            swal("Berhasil", "Pengajuan pendaftaran kelas next step anda berhasil disimpan. Periksa kembali status pengajuan pendaftaran anda dalam 2x24 Jam", "success")
                                .then(function() {
                                window.open("<?php echo site_url('nextstep/kelas/' . $kelas_slug . '/' . $this->encrypt->encode($menu)) ?>", "_self");
                                });
                            } else {
                            swal("Gagal", daftarResult.msg, "info");
                            }
                        })
                        .fail(function() {
                            console.log("error");
                        });

                    }
                });

            

        }else{
            swal("Informasi", response.msg, "info");
        }
      })
      .fail(function() {
        console.log('error');
      });


    });
  </script>