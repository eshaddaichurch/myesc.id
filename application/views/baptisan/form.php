<?php $this->load->view('template/festavalive/header'); ?>

<body>

    <main>

        <?php $this->load->view('template/festavalive/topmenu'); ?>

        <style>
            /* ====== Form Permohonan Baptisan ====== */
            .baptisan-form-section {
                padding: 40px 0 70px;
            }

            .baptisan-card {
                background: #ffffff;
                color: #333333;
                border-radius: 16px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
                padding: 40px 45px;
            }

            .baptisan-card .card-title {
                font-size: 1.4rem;
                font-weight: 700;
                color: #e04607;
                margin: 0 0 6px;
            }

            .baptisan-card .card-subtitle {
                font-size: 0.95rem;
                color: #777777;
                margin: 0 0 28px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eeeeee;
            }

            .baptisan-card .form-group {
                position: relative;
                margin-bottom: 22px;
            }

            .baptisan-card label {
                display: block;
                font-weight: 600;
                font-size: 0.95rem;
                color: #333333;
                margin-bottom: 8px;
            }

            .baptisan-card .label-optional {
                font-weight: 400;
                color: #999999;
                font-size: 0.85rem;
            }

            .baptisan-card .form-control {
                width: 100%;
                font-size: 16px; /* 16px supaya tidak otomatis zoom di iPhone */
                padding: 12px 14px;
                border: 1px solid #d5d5d5;
                border-radius: 10px;
                background: #fafafa;
                color: #333333;
                transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            }

            .baptisan-card .form-control:focus {
                outline: none;
                background: #ffffff;
                border-color: #e04607;
                box-shadow: 0 0 0 3px rgba(224, 70, 7, 0.15);
            }

            .baptisan-card textarea.form-control {
                min-height: 140px;
                resize: vertical;
            }

            .baptisan-card .help-text {
                display: block;
                margin-top: 6px;
                font-size: 0.82rem;
                color: #888888;
            }

            /* Tampilan error dari bootstrapValidator */
            .baptisan-card .form-control-feedback {
                display: none !important;
            }

            .baptisan-card .has-error .form-control {
                border-color: #dc3545;
                background: #fff8f8;
            }

            .baptisan-card .has-error .form-control:focus {
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
            }

            .baptisan-card .has-success .form-control {
                border-color: #28a745;
            }

            .baptisan-card .help-block {
                display: block;
                margin-top: 6px;
                font-size: 0.85rem;
                color: #dc3545;
            }

            /* Tombol */
            .baptisan-card .form-actions {
                display: flex;
                flex-direction: column-reverse; /* di HP: tombol Ajukan di atas */
                gap: 12px;
                margin-top: 30px;
            }

            .baptisan-card .btn-esc {
                display: block;
                width: 100%;
                text-align: center;
                padding: 12px 24px;
                font-size: 1rem;
                font-weight: 600;
                border-radius: 30px;
                border: 2px solid transparent;
                cursor: pointer;
                transition: all 0.25s ease;
                text-decoration: none;
            }

            .baptisan-card .btn-esc-primary {
                background: #e04607;
                border-color: #e04607;
                color: #ffffff;
            }

            .baptisan-card .btn-esc-primary:hover,
            .baptisan-card .btn-esc-primary:focus {
                background: #c23c05;
                border-color: #c23c05;
                color: #ffffff;
            }

            .baptisan-card .btn-esc-primary:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .baptisan-card .btn-esc-secondary {
                background: transparent;
                border-color: #cccccc;
                color: #666666;
            }

            .baptisan-card .btn-esc-secondary:hover,
            .baptisan-card .btn-esc-secondary:focus {
                background: #f2f2f2;
                color: #333333;
            }

            /* Desktop */
            @media (min-width: 768px) {
                .baptisan-card .form-actions {
                    flex-direction: row;
                    justify-content: flex-end;
                }

                .baptisan-card .btn-esc {
                    width: auto;
                    min-width: 180px;
                }
            }

            /* HP */
            @media (max-width: 575px) {
                .baptisan-form-section {
                    padding: 20px 0 50px;
                }

                .baptisan-card {
                    padding: 25px 20px;
                    border-radius: 12px;
                }

                .baptisan-card .card-title {
                    font-size: 1.2rem;
                }
            }
        </style>

        <section class="about-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-12 mb-4 mb-lg-0">
                        <h2 class="text-white text-center mb-4 mt-3">PERMOHONAN BAPTISAN</h2>
                    </div>

                </div>
            </div>
        </section>

        <section class="page-content baptisan-form-section">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                        <div class="baptisan-card">

                            <form action="<?php echo site_url('baptisan/simpan') ?>" method="POST" id="form" autocomplete="off">
                                <input type="hidden" name="idcarebaptisan" id="idcarebaptisan">

                                <h5 class="card-title" id="lbljudul">Tambah Permohonan Baptisan</h5>
                                <p class="card-subtitle">Isi data di bawah ini. Pihak gereja akan menghubungi Anda untuk konfirmasi.</p>

                                <div class="form-group">
                                    <label for="nohpyangbisadihubungi">No HP yang Bisa Dihubungi</label>
                                    <input type="tel" inputmode="tel" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Contoh: 081234567890" maxlength="20">
                                    <small class="help-text">Pastikan nomor aktif dan bisa dihubungi lewat WhatsApp.</small>
                                </div>

                                <div class="form-group">
                                    <label for="keteranganpermohonan">Keterangan Permohonan <span class="label-optional">(opsional)</span></label>
                                    <textarea name="keteranganpermohonan" id="keteranganpermohonan" class="form-control" rows="5" placeholder="Tuliskan keterangan tambahan jika ada"></textarea>
                                </div>

                                <div class="form-actions">
                                    <a href="<?php echo site_url('baptisan') ?>" class="btn-esc btn-esc-secondary">Kembali</a>
                                    <button type="submit" class="btn-esc btn-esc-primary"><i class="fa fa-save"></i> Ajukan Permohonan</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>


    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
        var idcarebaptisan = "<?php echo $idcarebaptisan; ?>";

        $(document).ready(function() {

            //---------------------------------------------------------> JIKA EDIT DATA
            if (idcarebaptisan != "") {

                $.ajax({
                        type: 'GET',
                        url: '<?php echo site_url("baptisan/get_edit_data") ?>',
                        data: {
                            idcarebaptisan: idcarebaptisan
                        },
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

            $("#form").bootstrapValidator({
                fields: {
                    nohpyangbisadihubungi: {
                        validators: {
                            notEmpty: {
                                message: "Nomor HP yang bisa dihubungi tidak boleh kosong"
                            },
                        }
                    },
                },
            });
        });
    </script>

</body>

</html>