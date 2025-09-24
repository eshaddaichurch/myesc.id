<?php $this->load->view('template/festavalive/header'); ?>

<body>

    <main>



        <?php $this->load->view('template/festavalive/topmenu'); ?>


        <section class="about-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-12 mb-4 mb-lg-0">
                        <h2 class="text-white text-center mb-4 mt-3">Kelas Saya</h2>
                    </div>

                </div>
            </div>
        </section>



        <section class="about-section section-padding bg-dark text-white">
            <div class="container">
                <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-3 mt-2">📚 Kelas Saya</h2>
                    <p class="text-light">Daftar kelas yang sudah Anda ikuti</p>
                </div>
                </div>
            </div>
            </section>

            <section class="page-content section-padding">
            <div class="container">
                <div class="row justify-content-center">
                
                <div class="col-12">
                    <h5 class="fw-bold mb-3">List Kelas Yang Telah Diikuti</h5>
                    <hr>
                </div>

                <div class="col-12 pt-3">
                    <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Nama Kelas</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tgl Kelulusan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyinfokelas">
                        <?php
                        if ($rskelas->num_rows() > 0) {
                            foreach ($rskelas->result() as $row) {
                                $kelas_slug = $this->db->query("SELECT * FROM kelas WHERE idkelas='" . $row->idkelas . "'")->row()->kelas_slug;

                                $tglsertifikat = !empty($row->tglsertifikat) ? tglindonesia($row->tglsertifikat) : '';

                                if ($row->statuslulus == '1') {
                                    $statuslulus = '<span class="badge bg-success">Lulus</span>';
                                    $btnAksi = '<a href="' . site_url('akun/sertifikat/' . $row->idregistrasikelas) . '" class="btn btn-sm" style="background-color:#e04607;color:white;" target="_blank">Lihat Sertifikat</a>';
                                } else {
                                    $statuslulus = '<span class="badge bg-danger">Belum Lulus</span>';
                                    $btnAksi = '<a href="' . site_url('nextstep/kelas/' . $kelas_slug . '/') . '" class="btn btn-sm btn-primary">Registrasi Kelas</a>';
                                }

                                echo "
                                    <tr>
                                    <td>{$row->namakelas}</td>
                                    <td class='text-center'>{$statuslulus}</td>
                                    <td class='text-center'>{$tglsertifikat}</td>
                                    <td class='text-center'>{$btnAksi}</td>
                                    </tr>
                                ";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>

                    <!-- Mobile View as Card -->
                    <div class="d-md-none" id="tbodyinfokelasMobile">
                    <?php
                    if ($rskelas->num_rows() > 0) {
                        foreach ($rskelas->result() as $row) {
                            $kelas_slug = $this->db->query("SELECT * FROM kelas WHERE idkelas='" . $row->idkelas . "'")->row()->kelas_slug;

                            $tglsertifikat = !empty($row->tglsertifikat) ? tglindonesia($row->tglsertifikat) : '';

                            if ($row->statuslulus == '1') {
                                $statuslulus = '<span class="badge bg-success">Lulus</span>';
                                $btnAksi = '<a href="' . site_url('akun/sertifikat/' . $row->idregistrasikelas) . '" class="btn btn-sm w-100 mb-2" style="background-color:#e04607;color:white;" target="_blank">Lihat Sertifikat</a>';
                            } else {
                                $statuslulus = '<span class="badge bg-danger">Belum Lulus</span>';
                                $btnAksi = '<a href="' . site_url('nextstep/kelas/' . $kelas_slug . '/') . '" class="btn btn-sm btn-primary w-100">Registrasi Kelas</a>';
                            }

                            echo "
                            <div class='card mb-3 shadow-sm'>
                                <div class='card-body'>
                                <h6 class='fw-bold'>{$row->namakelas}</h6>
                                <p>Status: {$statuslulus}</p>
                                <p>Tgl Kelulusan: {$tglsertifikat}</p>
                                {$btnAksi}
                                </div>
                            </div>
                            ";
                        }
                    }
                    ?>
                    </div>

                </div>
                </div>
            </div>
            </section>







    </main>


    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>

    </script>

</body>

</html>