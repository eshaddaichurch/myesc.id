<footer class="site-footer" style="background:#111; color:#fff; font-family:inherit; padding:0;">

  <!-- Top Bar -->
  <div style="border-bottom:0.5px solid rgba(255,255,255,0.12); padding:3rem 2.5rem 2rem; display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
    <div>
      <h2 style="font-size:28px; font-weight:500; margin:0; color:#fff;">El Shaddai Church</h2>
      <p style="font-size:12px; color:rgba(255,255,255,0.4); margin:4px 0 0; text-transform:uppercase; letter-spacing:0.06em;">Pontianak, Kalimantan Barat</p>
    </div>
    <a href="<?php echo site_url('') ?>/ourlocation/index/V05TSFJlBWcLYQ~~" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:rgba(255,255,255,0.55); border:0.5px solid rgba(255,255,255,0.2); padding:6px 14px; border-radius:20px; text-decoration:none;">
      📍 Lihat di Maps
    </a>
  </div>

  <!-- Columns -->
  <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:2rem; padding:2.5rem; border-bottom:0.5px solid rgba(255,255,255,0.1);">

    <!-- Kontak -->
    <div>
      <p style="font-size:11px; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin:0 0 14px;">Kontak</p>
      <p style="font-size:14px; color:rgba(255,255,255,0.75); margin:0 0 6px;">
        <a href="tel:+6285550001187" style="color:inherit; text-decoration:none;">+62 855 5000 1187</a>
      </p>
      <p style="font-size:14px; color:rgba(255,255,255,0.75); margin:0;">
        <a href="mailto:connect@myesc.id" style="color:inherit; text-decoration:none;">connect@myesc.id</a>
      </p>
    </div>

    <!-- Lokasi -->
    <div>
      <p style="font-size:11px; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin:0 0 14px;">Lokasi</p>
      <p style="font-size:14px; color:rgba(255,255,255,0.75); margin:0 0 10px; line-height:1.6;">Jl. Prof. M. Yamin No.1 A<br>Pontianak, Kalimantan Barat</p>
    </div>

    <!-- Sosial Media -->
    <div>
      <p style="font-size:11px; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin:0 0 14px;">Sosial Media</p>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">

        <a href="https://www.instagram.com/elshaddai_church/" target="_blank" rel="noopener"
           style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:8px; border:0.5px solid rgba(255,255,255,0.15); font-size:12px; color:rgba(255,255,255,0.7); text-decoration:none;">
          <span class="bi-instagram" style="font-size:15px;"></span> Instagram
        </a>

        <a href="https://www.youtube.com/@elshaddaichurchpontianak" target="_blank" rel="noopener"
           style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:8px; border:0.5px solid rgba(255,255,255,0.15); font-size:12px; color:rgba(255,255,255,0.7); text-decoration:none;">
          <span class="bi-youtube" style="font-size:15px;"></span> YouTube
        </a>

        <a href="https://open.spotify.com/artist/0ttHVHLE08tW3WQJySwIOz" target="_blank" rel="noopener"
           style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:8px; border:0.5px solid rgba(255,255,255,0.15); font-size:12px; color:rgba(255,255,255,0.7); text-decoration:none;">
          <span class="bi-spotify" style="font-size:15px;"></span> Spotify
        </a>

        <a href="https://www.threads.com/@elshaddai_church" target="_blank" rel="noopener"
           style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:8px; border:0.5px solid rgba(255,255,255,0.15); font-size:12px; color:rgba(255,255,255,0.7); text-decoration:none;">
          <span class="bi-threads" style="font-size:15px;"></span> Threads
        </a>

      </div>
    </div>

  </div>

  <!-- Bottom Bar -->
  <div style="display:flex; align-items:center; justify-content:space-between; padding:1.25rem 2.5rem; flex-wrap:wrap; gap:1rem;">
    <p style="font-size:12px; color:rgba(255,255,255,0.35); margin:0;">
      © 2023–<?php echo date('Y') ?> El Shaddai Church. All rights reserved.
    </p>
  </div>

  <!-- Semua script & PHP original kamu tetap di sini -->
  ...

</footer>

    <!--

T e m p l a t e M o


-->
    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 50%;
            height: 50%;
            z-index: 9999;
            background: url('<?php echo base_url('myesc.id/images/Spinner-3.gif') ?>') 100% 100% no-repeat;
        }

        @media (max-width: 576px) {
        .esc-top {
            flex-direction: column;
            align-items: flex-start;
        }
        .esc-cols {
            padding: 1.5rem 1.25rem;
            gap: 1.5rem;
        }
        .esc-bottom {
            padding: 1rem 1.25rem;
        }
        }
    </style>
    <div class="loader"></div>


    <!-- JAVASCRIPT FILES -->
    <script src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>js/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>js/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>js/jquery.sticky.js"></script>
    <script src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>js/click-scroll.js"></script>
    <script src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>js/custom.js"></script>

    <!-- AOS animation JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>




    <!-- datatables -->
    <script src="<?php echo (base_url()) ?>myesc.id/admin/assets/datatables2/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript" src="<?php echo base_url(); ?>myesc.id/admin/assets/bootbox/bootbox.js"></script>

    <!-- jquery-confirm  -->
    <script src="<?php echo (base_url('myesc.id/admin/assets/')) ?>jquery-confirm/js/jquery-confirm.min.js"></script>

    <!-- jquery-mask -->
    <script type="text/javascript" src="<?php echo base_url('myesc.id/admin/assets/') ?>jquery_mask/jquery.mask.js"></script>

    <!-- Bootstrap validator -->
    <script src="<?php echo (base_url('myesc.id/admin/assets/')) ?>bootstrap-validator/js/bootstrapValidator.js"></script>

    <!-- jquery-ui -->
    <script src="<?php echo (base_url('myesc.id/admin/assets/')) ?>jquery-ui/jquery-ui-2.js"></script>

    <!-- select2 -->
    <script src="<?php echo (base_url()) ?>myesc.id/admin/assets/select2/js/select2.min.js"></script>

    <!-- CK Editor -->
    <!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
    <script src="<?php echo base_url(); ?>myesc.id/admin/assets/ckeditor/ckeditor.js"></script>

    <script src="<?php echo (base_url()) ?>myesc.id/admin/assets/sweetalert/sweetalert.min.js"></script>
    <script>
        AOS.init();
    </script>


    <script>
        var $loading = $('.loader').hide();
        $('.select2').select2();

        $(document)
            .ajaxStart(function() {
                //ajax request went so show the loading image
                $loading.show();
                $('button[type="submit"]').prop('disabled', true);
            })
            .ajaxStop(function() {
                //got response so hide the loading image
                $loading.hide();
                $('button[type="submit"]').prop('disabled', false);
            });
    </script>




    <?php
    $pesan = $this->session->flashdata('pesan');
    if (!empty($pesan)) {
        echo $pesan;
    }
    ?>



    <?php
    $this->load->view('loginModal');
    $this->load->view('registrasiModal');
    $this->load->view('lupaPasswordModal');
    ?>

    <script>
        $('.show-form-login').click(function(e) {
            e.preventDefault();
            $('#registrasiModal').modal('hide');
            $('#lupaPasswordModal').modal('hide');
            $('#loginModal').modal('show');
        });

        $('.show-form-registrasi').click(function(e) {
            e.preventDefault();
            $('#loginModal').modal('hide');
            $('#lupaPasswordModal').modal('hide');
            $('#registrasiModal').modal('show');
        });

        $('.show-form-lupapassword').click(function(e) {
            e.preventDefault();
            $('#loginModal').modal('hide');
            $('#registrasiModal').modal('hide');

            //reset password
            $('#formMasukkanEmail').show(); 
            $('#formMasukkanToken').hide();
            $('#formMasukkanPassword').hide();
            $('#lupaPasswordModal').modal('show');
        });

        $(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation();
            window.location = $(this).attr('href');
        });
    </script>


    <script>
        function addSelectOption(selectId, optValue, optText) {
            var select = document.getElementById(selectId);
            var option = document.createElement("option");
            option.value = optValue;
            option.innerHTML = optText;
            select.appendChild(option);
        }
    </script>


    <script>
        
        $(document).ready(function () {
            
            var idjemaatlogin = "<?php echo $this->session->userdata('idjemaat'); ?>";
            //get notifikasi
            if (idjemaatlogin != "") {
                $.ajax({
                    url: "<?= site_url('home/getNotifikasi') ?>",
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(response) {
                    if (response != "0" && response != "null" && response != "") {
                        $('.notifikasi-permohonan').html(response);   
                    }
                })
                .fail(function() {
                    console.log('error getNotifikasi');
                });
                                
            }
        });


        function belumLogin() {
            var idjemaatlogin = "<?php echo $this->session->userdata('idjemaat'); ?>";  

            if (idjemaatlogin == "") {
                return true;
            }else{
                return false;
            }
        }
    </script>