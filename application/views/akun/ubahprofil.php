<?php $this->load->view('template/festavalive/header'); ?>

<body>
<style>
@import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

html, body {
  margin: 0; padding: 0;
  background: #f5f5f5;
  font-family: 'Figtree', sans-serif;
  color: #111; line-height: 1.6;
}

.page-content { padding-top: 80px !important; padding-bottom: 80px !important; }
@media (min-width: 768px)  { .page-content { padding-top: 120px !important; padding-bottom: 100px !important; } }
@media (min-width: 1200px) { .page-content { padding-top: 160px !important; padding-bottom: 151px !important; } }

/* ===== STEPPER ===== */
.stepper-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 32px;
  flex-wrap: wrap;
  gap: 6px;
}

.step-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  cursor: pointer;
}

.step-circle {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: #e8e8e8;
  color: #999;
  font-size: 13px;
  font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s;
  border: 2px solid transparent;
}

.step-item.active   .step-circle { background: #e04607; color: #fff; border-color: #e04607; }
.step-item.done     .step-circle { background: #fff0ea; color: #e04607; border-color: #e04607; }

.step-label {
  font-size: 10px;
  font-weight: 600;
  color: #bbb;
  text-align: center;
  max-width: 64px;
  line-height: 1.3;
  text-transform: uppercase;
  letter-spacing: 0.4px;
}

.step-item.active .step-label,
.step-item.done   .step-label { color: #e04607; }

.step-connector {
  width: 28px; height: 2px;
  background: #e8e8e8;
  margin-bottom: 20px;
  flex-shrink: 0;
  transition: background 0.25s;
}
.step-connector.done { background: #e04607; }

/* ===== CARD ===== */
.form-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
  overflow: hidden;
}

.form-card-header {
  background: linear-gradient(135deg, #e04607 0%, #ff7c42 60%, #ffb347 100%);
  padding: 22px 28px;
  display: flex;
  align-items: center;
  gap: 14px;
}

.form-card-header-icon {
  width: 42px; height: 42px;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}

.form-card-header-icon svg { width: 20px; height: 20px; }

.form-card-header h5 {
  font-size: 15px;
  font-weight: 700;
  color: #fff;
  margin: 0 0 2px;
}

.form-card-header p {
  font-size: 12px;
  color: rgba(255,255,255,0.75);
  margin: 0;
}

.form-card-body { padding: 28px; }

/* ===== FORM FIELDS ===== */
.form-group { margin-bottom: 18px; }

.form-group label {
  font-size: 12px;
  font-weight: 600;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
  display: block;
}

.form-control {
  border: 1.5px solid #ececec;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 14px;
  font-family: 'Figtree', sans-serif;
  color: #111;
  background: #fafafa;
  width: 100%;
  transition: border-color 0.2s, background 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #e04607;
  background: #fff;
  box-shadow: 0 0 0 3px rgba(224,70,7,0.08);
}

.form-control[readonly],
.form-control[disabled] {
  background: #f0f0f0;
  color: #999;
  cursor: not-allowed;
  border-color: #e0e0e0;
}

select.form-control { appearance: auto; }

textarea.form-control { resize: vertical; }

/* ===== AVATAR UPLOAD ===== */
.avatar-upload-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  padding: 24px;
  border: 2px dashed #e8e8e8;
  border-radius: 16px;
  text-align: center;
  background: #fafafa;
  transition: border-color 0.2s;
}

.avatar-upload-box:hover { border-color: #e04607; }

.avatar-upload-box img {
  width: 100px; height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #e04607;
}

.avatar-upload-hint {
  font-size: 12px;
  color: #aaa;
}

.status-pill-form {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #fff0ea;
  border: 1px solid #ffd0b8;
  padding: 6px 14px;
  border-radius: 30px;
  font-size: 12px;
  font-weight: 600;
  color: #e04607;
}

/* ===== NAV BUTTONS ===== */
.step-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 28px;
  border-top: 1px solid #f0f0f0;
  background: #fafafa;
  gap: 10px;
}

.btn-step {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 22px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
  text-decoration: none;
  font-family: 'Figtree', sans-serif;
}

.btn-step.next {
  background: linear-gradient(135deg, #e04607, #ff7c42);
  color: #fff;
}

.btn-step.next:hover { opacity: 0.9; transform: translateY(-1px); }

.btn-step.prev {
  background: #fff;
  color: #555;
  border: 1.5px solid #e0e0e0;
}

.btn-step.prev:hover { background: #f5f5f5; }

.btn-step.save {
  background: linear-gradient(135deg, #2ecc71, #27ae60);
  color: #fff;
}

.btn-step.back-link {
  background: #fff;
  color: #888;
  border: 1.5px solid #e0e0e0;
  font-size: 13px;
}

/* Progress bar */
.progress-bar-wrap {
  height: 4px;
  background: #f0f0f0;
  border-radius: 0;
  overflow: hidden;
}

.progress-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, #e04607, #ffb347);
  transition: width 0.4s ease;
}

/* Step panels */
.step-panel { display: none; }
.step-panel.active { display: block; }

/* Responsive */
@media (max-width: 576px) {
  .form-card-body { padding: 18px; }
  .step-nav { padding: 14px 18px; flex-wrap: wrap; }
  .step-label { display: none; }
  .step-connector { width: 16px; }
}
</style>

<main>
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <section class="page-content">
    <div class="container">

      <form action="<?php echo site_url('akun/simpanJemaat') ?>" method="post" id="form" enctype="multipart/form-data">

        <!-- Flash message -->
        <div class="mb-3">
          <?php $pesan = $this->session->flashdata('pesan');
          if (!empty($pesan))
            echo $pesan; ?>
        </div>

        <!-- ===== STEPPER ===== -->
        <div class="stepper-wrap" id="stepper">
          <div class="step-item active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Identitas</div>
          </div>
          <div class="step-connector" id="conn-1"></div>
          <div class="step-item" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Kontak</div>
          </div>
          <div class="step-connector" id="conn-2"></div>
          <div class="step-item" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Alamat</div>
          </div>
          <div class="step-connector" id="conn-3"></div>
          <div class="step-item" data-step="4">
            <div class="step-circle">4</div>
            <div class="step-label">Darurat</div>
          </div>
          <div class="step-connector" id="conn-4"></div>
          <div class="step-item" data-step="5">
            <div class="step-circle">5</div>
            <div class="step-label">Pendidikan</div>
          </div>
          <div class="step-connector" id="conn-5"></div>
          <div class="step-item" data-step="6">
            <div class="step-circle">6</div>
            <div class="step-label">Dokumen</div>
          </div>
        </div>

        <!-- Progress bar -->
        <div class="progress-bar-wrap mb-4">
          <div class="progress-bar-fill" id="progressBar" style="width:20%"></div>
        </div>

        <!-- ===== FORM CARD ===== -->
        <div class="form-card">

          <!-- STEP 1: DATA IDENTITAS -->
          <div class="step-panel active" id="panel-1">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
              </div>
              <div>
                <h5>Data Identitas</h5>
                <p>Informasi dasar jemaat</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">

                <!-- Foto Profil -->
                <div class="col-12 col-md-4 mb-3">
                  <div class="avatar-upload-box">
                    <?php if (!empty($rowProfil->foto)) { ?>
                      <img src="<?php echo base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto) ?>" alt="Foto Profil">
                    <?php } else { ?>
                      <img src="<?php echo base_url('myesc.id/images/nofoto.png') ?>" alt="Foto Profil">
                    <?php } ?>
                    <div class="status-pill-form">
                      <span style="width:7px;height:7px;border-radius:50%;background:#e04607;display:inline-block;"></span>
                      <?php echo $rowProfil->statusjemaat; ?>
                    </div>
                    <div>
                      <input type="file" id="foto" name="foto" class="form-control" style="font-size:12px;">
                      <input type="hidden" id="foto_lama" name="foto_lama">
                      <div class="avatar-upload-hint">Maks. 2 MB</div>
                    </div>
                  </div>
                </div>

                <!-- Fields identitas -->
                <div class="col-12 col-md-8">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nikprofil" id="nikprofil" class="form-control" placeholder="Masukkan NIK">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                          <option value="">Pilih...</option>
                          <option value="Indonesia">Indonesia</option>
                          <option value="Asing">Asing</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="namalengkapprofil" id="namalengkapprofil" class="form-control" placeholder="Nama lengkap">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" name="namapanggilan" id="namapanggilan" class="form-control" placeholder="Nama panggilan">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempatlahirprofil" id="tempatlahirprofil" class="form-control" placeholder="Tempat lahir">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggallahirprofil" id="tanggallahirprofil" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jeniskelaminprofil" id="jeniskelaminprofil" class="form-control">
                          <option value="">Pilih...</option>
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Status Pernikahan</label>
                        <select name="statuspernikahan" id="statuspernikahan" class="form-control">
                          <option value="">Pilih...</option>
                          <option value="Belum Kawin">Belum Kawin</option>
                          <option value="Kawin">Kawin</option>
                          <option value="Janda/ Duda">Janda/ Duda</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Golongan Darah</label>
                        <select name="golongandarah" id="golongandarah" class="form-control">
                          <option value="">Pilih...</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="AB">AB</option>
                          <option value="O">O</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="step-nav">
              <a href="<?php echo site_url('akun/profil') ?>" class="btn-step back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
              </a>
              <button type="button" class="btn-step next" onclick="goStep(2)">
                Selanjutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
          </div>

          <!-- STEP 2: DATA SOSIAL MEDIA / KONTAK -->
          <div class="step-panel" id="panel-2">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3-8.59A2 2 0 0 1 3.12 1.5h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/>
                </svg>
              </div>
              <div>
                <h5>Kontak & Sosial Media</h5>
                <p>Nomor HP, email, dan akun media sosial</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">
                <div class="col-md-6" style="display:none;">
                  <div class="form-group">
                    <label>No Telepon / HP</label>
                    <input type="text" name="notelp" id="notelp" class="form-control" placeholder="Nomor telepon">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>No Whatsapp</label>
                    <input type="text" name="nohpprofil" id="nohpprofil" class="form-control" placeholder="Contoh: 08123456789">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="emailprofil" id="emailprofil" class="form-control" placeholder="contoh@gmail.com">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>URL Instagram</label>
                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="https://instagram.com/...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>URL Facebook</label>
                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="https://facebook.com/...">
                  </div>
                </div>
              </div>
            </div>
            <div class="step-nav">
              <button type="button" class="btn-step prev" onclick="goStep(1)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Sebelumnya
              </button>
              <button type="button" class="btn-step next" onclick="goStep(3)">
                Selanjutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
          </div>

          <!-- STEP 3: DATA ALAMAT -->
          <div class="step-panel" id="panel-3">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
              </div>
              <div>
                <h5>Alamat Jemaat</h5>
                <p>Tempat tinggal saat ini</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Alamat Rumah</label>
                    <textarea name="alamatrumahprofil" id="alamatrumahprofil" class="form-control" rows="4" placeholder="Jalan, nomor rumah, dll."></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>RT / RW</label>
                    <input type="text" name="rtrw" id="rtrw" class="form-control" placeholder="000/000">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="kodepos" id="kodepos" class="form-control" placeholder="Kode pos">
                  </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select name="propinsi" id="propinsi" class="form-control select2">
                      <option value="">Pilih provinsi...</option>
                      <?php
                      $rsProvinsi = $this->db->query('select * from provinsi order by namaprovinsi');
                      if ($rsProvinsi->num_rows() > 0) {
                        foreach ($rsProvinsi->result() as $row) {
                          echo '<option value="' . $row->idprovinsi . '">' . $row->namaprovinsi . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kabupaten / Kota</label>
                    <select name="kotakabupaten" id="kotakabupaten" class="form-control select2">
                      <option value="">Pilih kabupaten...</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control select2">
                      <option value="">Pilih kecamatan...</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kelurahan</label>
                    <select name="kelurahan" id="kelurahan" class="form-control select2">
                      <option value="">Pilih kelurahan...</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="step-nav">
              <button type="button" class="btn-step prev" onclick="goStep(2)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Sebelumnya
              </button>
              <button type="button" class="btn-step next" onclick="goStep(4)">
                Selanjutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
          </div>

          <!-- STEP 4: KONTAK DARURAT -->
          <div class="step-panel" id="panel-4">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
              </div>
              <div>
                <h5>Kontak Darurat</h5>
                <p>Yang bisa dihubungi saat darurat</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="namadarurat" id="namadarurat" class="form-control" placeholder="Nama kontak darurat">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Hubungan</label>
                    <select name="hubungan" id="hubungan" class="form-control">
                      <option value="">Pilih hubungan...</option>
                      <option value="Ayah">Ayah</option>
                      <option value="Ibu">Ibu</option>
                      <option value="Istri/ Suami">Istri/ Suami</option>
                      <option value="Anak">Anak</option>
                      <option value="Saudara">Saudara</option>
                      <option value="Kerabat">Kerabat</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="notelpdarurat" id="notelpdarurat" class="form-control" placeholder="Nomor telepon">
                  </div>
                </div>
              </div>
            </div>
            <div class="step-nav">
              <button type="button" class="btn-step prev" onclick="goStep(3)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Sebelumnya
              </button>
              <button type="button" class="btn-step next" onclick="goStep(5)">
                Selanjutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
          </div>

          <!-- STEP 5: PENDIDIKAN & PEKERJAAN -->
          <div class="step-panel" id="panel-5">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
              </div>
              <div>
                <h5>Pendidikan &amp; Pekerjaan</h5>
                <p>Riwayat pendidikan dan pekerjaan saat ini</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <select name="pendidikanterakhir" id="pendidikanterakhir" class="form-control">
                      <option value="">Pilih...</option>
                      <option value="SD">SD</option>
                      <option value="SMP">SMP</option>
                      <option value="SMA/ SMK">SMA/ SMK</option>
                      <option value="D1">D1</option>
                      <option value="D2">D2</option>
                      <option value="D3">D3</option>
                      <option value="S1">S1</option>
                      <option value="S2">S2</option>
                      <option value="S3">S3</option>
                      <option value="Lainnya">Lainnya</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input type="text" name="namasekolah" id="namasekolah" class="form-control" placeholder="Nama sekolah / universitas">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan" id="pekerjaan" class="form-control">
                      <option value="">Pilih...</option>
                      <option value="Swasta">Swasta</option>
                      <option value="Wiraswasta">Wiraswasta</option>
                      <option value="Pegawai Negeri">Pegawai Negeri</option>
                      <option value="TNI">TNI</option>
                      <option value="POLRI">POLRI</option>
                      <option value="Gembala">Gembala</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="namaperusahaan" id="namaperusahaan" class="form-control" placeholder="Nama perusahaan">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Alamat Kantor</label>
                    <textarea name="alamatkantor" id="alamatkantor" class="form-control" rows="2" placeholder="Alamat kantor"></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Sektor Industri</label>
                    <input type="text" name="sektorindustri" id="sektorindustri" class="form-control" placeholder="Sektor industri">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>No Telepon Kantor</label>
                    <input type="text" name="notelpkantor" id="notelpkantor" class="form-control" placeholder="Nomor telepon kantor">
                  </div>
                </div>
              </div>
            </div>
            <div class="step-nav">
              <button type="button" class="btn-step prev" onclick="goStep(4)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Sebelumnya
              </button>
              <button type="button" class="btn-step next" onclick="goStep(6)">
                Selanjutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
          </div>


          <!-- STEP 6: DOKUMEN -->
          <div class="step-panel" id="panel-6">
            <div class="form-card-header">
              <div class="form-card-header-icon">
                <!-- svg icon file upload -->
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><polygon points="25.15 6.32 50.81 6.32 50.81 54.84 13.19 54.84 13.19 19.18 25.15 6.32" stroke-linecap="round"></polygon><polyline points="25.17 6.32 25.15 19.18 13.19 19.18"></polyline><path d="M40.26,34v7.4a.82.82,0,0,1-.82.81H24.56a.82.82,0,0,1-.82-.81V34"></path><polyline points="36.08 30.87 32 26.79 27.93 30.87"></polyline><line x1="32" y1="26.79" x2="32" y2="38.74"></line></g></svg>
              </div>
              <div>
                <h5>Dokumen</h5>
                <p>Dokumen-dokumen pendukung</p>
              </div>
            </div>
            <div class="form-card-body">
              <div class="row">

                <!-- GANTI blok "Kartu Keluarga" yang lama dengan versi ini -->
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Kartu Keluarga <strong class="text-danger">(PDF)</strong></label>
                    <div class="col-md-9">
                      <div class="display-block mb-3" id="filekartukeluarga_preview" style="display:none">
                        <a href="#" target="_blank" id="filekartukeluarga_link"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h22v19H1z"/><path d="M10 12l4-4-4-4v16z"/></svg> <span id="filekartukeluarga_name" class="text-primary">Kartu Keluarga</span></a>
                      </div>

                      <!-- FITUR BARU: status review KK -->
                      <div id="statuskk_pill" class="mb-2" style="display:none;"></div>
                      <div id="statuskk_catatan" class="mb-2" style="display:none; font-size:12px; color:#e04607; background:#fff3ee; border:1px solid #ffd0b8; border-radius:8px; padding:8px 12px;"></div>

                      <input type="file" name="filekartukeluarga" id="filekartukeluarga" class="form-control" accept=".pdf">
                      <small class="text-muted">Ukuran maksimal dokumen: 5 MB</small>
                      <input type="hidden" name="filekartukeluarga_lama" id="filekartukeluarga_lama">
                    </div>
                  </div>
                </div>

                
                
              </div>
            </div>

            <div class="step-nav">
              <button type="button" class="btn-step prev" onclick="goStep(5)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Sebelumnya
              </button>
              <button type="submit" class="btn-step save" id="btnSimpan">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Data
              </button>
            </div>
          </div>

        </div><!-- /.form-card -->
      </form>

    </div>
  </div>
  </section>
</main>

<?php $this->load->view('template/festavalive/footer'); ?>

<script>
/* ===== MULTI-STEP NAVIGATION ===== */
var totalSteps = 6;
var currentStep = 1;

function goStep(n) {
  document.getElementById('panel-' + currentStep).classList.remove('active');
  document.querySelector('[data-step="' + currentStep + '"]').classList.remove('active');
  document.querySelector('[data-step="' + currentStep + '"]').classList.add('done');

  // if going back, remove done from target
  if (n < currentStep) {
    document.querySelector('[data-step="' + n + '"]').classList.remove('done');
  }

  currentStep = n;
  document.getElementById('panel-' + currentStep).classList.add('active');
  document.querySelector('[data-step="' + currentStep + '"]').classList.remove('done');
  document.querySelector('[data-step="' + currentStep + '"]').classList.add('active');

  // update connectors
  for (var i = 1; i < totalSteps; i++) {
    var conn = document.getElementById('conn-' + i);
    if (conn) conn.classList.toggle('done', i < currentStep);
  }

  // progress bar
  document.getElementById('progressBar').style.width = (currentStep / totalSteps * 100) + '%';

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ===== SEMUA JS FUNGSI ASLI (TIDAK DIUBAH) ===== */
$(document).ready(function() {

  $.ajax({
    type: 'POST',
    url: '<?php echo site_url('akun/getJemaatId') ?>',
    dataType: 'json',
    encode: true
  })
  .done(function(result) {
    // console.log(result);

    $("#nikprofil").val(result.nik);
    $("#kewarganegaraan").val(result.kewarganegaraan);
    $("#namalengkapprofil").val(result.namalengkap);
    $("#namapanggilan").val(result.namapanggilan);
    $("#tempatlahirprofil").val(result.tempatlahir);
    $("#tanggallahirprofil").val(result.tanggallahir);
    $("#jeniskelaminprofil").val(result.jeniskelamin);
    $("#statuspernikahan").val(result.statuspernikahan);
    $("#golongandarah").val(result.golongandarah);
    $("#notelp").val(result.notelp);

    $("#nohpprofil").val(result.nohp);
    if (result.statusverifikasiwa === "1") {
      $("#nohpprofil").attr('readonly', true);
      $("#nohpprofil").parent().find('label').html('No Whatsapp <span class="text-success ml-1 text-sm"><i class="fa fa-lock"></i> Terverifikasi</span>');
    } else {
      $("#nohpprofil").attr('readonly', false);
      $("#nohpprofil").parent().find('label').html('No Whatsapp <span class="text-danger ml-1 text-sm">Belum Diverifikasi</span><button type="button" class="btn btn-sm btn-primary linkverifikasihp">Kirim Link Verifikasi</button>');
    }

    $("#emailprofil").val(result.email);
    if (result.statusverifikasiemail === "1") {
      $("#emailprofil").attr('readonly', true);
      $("#emailprofil").parent().find('label').html('Email <span class="text-success ml-1 text-sm"><i class="fa fa-lock"></i> Terverifikasi</span>');
    } else {
      $("#emailprofil").attr('readonly', false);
      $("#emailprofil").parent().find('label').html('Email <span class="text-danger ml-1 text-sm">Belum diverifikasi</span> <button type="button" class="btn btn-sm btn-primary linkverifikasiemail">Kirim Link Verifikasi</button>');
    }

    $("#facebook").val(result.facebook);
    $("#instagram").val(result.instagram);
    $("#namadarurat").val(result.namadarurat);
    $("#hubungan").val(result.hubungan);
    $("#notelpdarurat").val(result.notelpdarurat);
    $("#pendidikanterakhir").val(result.pendidikanterakhir);
    $("#namasekolah").val(result.namasekolah);
    $("#pekerjaan").val(result.pekerjaan);
    $("#namaperusahaan").val(result.namaperusahaan);
    $("#sektorindustri").val(result.sektorindustri);
    $("#alamatkantor").val(result.alamatkantor);
    $("#notelpkantor").val(result.notelpkantor);
    $("#alamatrumahprofil").val(result.alamatrumah);
    $("#rtrw").val(result.rtrw);
    $("#propinsi").val(result.propinsi).trigger('change');
    $("#kotakabupaten").val(result.kotakabupaten).trigger('change');

    setTimeout(function() { $("#kecamatan").val(result.kecamatan).trigger('change'); }, 1000);
    setTimeout(function() { $("#kelurahan").val(result.kelurahan).trigger('change'); }, 1500);

    $("#kodepos").val(result.kodepos);
    $("#foto_lama").val(result.foto);

    if (result.filekartukeluarga != "" && result.filekartukeluarga != null) {
      $('#filekartukeluarga_preview').show();
      $('#filekartukeluarga_link').attr('href', "<?php echo base_url('myesc.id/admin/uploads/jemaat/') ?>" + result.filekartukeluarga);
      $('#filekartukeluarga_name').html(result.filekartukeluarga);
    }else{
      $('#filekartukeluarga_preview').hide();
      $('#filekartukeluarga_link').attr('href', 'javascript:void(0)');
      $('#filekartukeluarga_name').html('');
    }

    // FITUR BARU: tampilkan status review KK ke jemaat
    if (result.statuskk == 'Menunggu Review') {
      $('#statuskk_pill').html('<span class="status-pill-form" style="background:#fff8e1;border-color:#ffe082;color:#f9a825;">Menunggu Review</span>').show();
      $('#statuskk_catatan').hide();
    } else if (result.statuskk == 'Disetujui') {
      $('#statuskk_pill').html('<span class="status-pill-form" style="background:#e8f5e9;border-color:#a5d6a7;color:#2e7d32;">Disetujui</span>').show();
      $('#statuskk_catatan').hide();
    } else if (result.statuskk == 'Ditolak') {
      $('#statuskk_pill').html('<span class="status-pill-form" style="background:#fdecea;border-color:#f5c6cb;color:#c62828;">Ditolak - Mohon upload ulang</span>').show();
      if (result.catatanreviewkk) {
        $('#statuskk_catatan').html('<strong>Catatan Admin:</strong> ' + result.catatanreviewkk).show();
      } else {
        $('#statuskk_catatan').hide();
      }
    } else {
      $('#statuskk_pill').hide();
      $('#statuskk_catatan').hide();
    }

    getKabupaten(result.propinsi, result.kotakabupaten);
    getKecamatan(result.kotakabupaten, result.kecamatan);

    if (result.statusjemaat == 'Jemaat') {
      $('#statusjemaat').attr('disabled', true);
    }

    if (result.statusjemaat == 'Registered' || result.statusjemaat == 'Simpatisan') {
      $('#nikprofil').focus();
    } else {
      $('#notelp').focus();
      $('#nikprofil').attr('disabled', true);
      $('#kewarganegaraan').attr('disabled', true);
      $('#namalengkapprofil').attr('disabled', true);
      $('#namapanggilan').attr('disabled', true);
      $('#tempatlahirprofil').attr('disabled', true);
      $('#tanggallahirprofil').attr('disabled', true);
      $('#jeniskelaminprofil').attr('disabled', true);
      $('#statuspernikahan').attr('disabled', true);
      $('#golongandarah').attr('disabled', true);
    }
  });

  $("#form").bootstrapValidator({
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      nikprofil:         { validators: { notEmpty: { message: "nik tidak boleh kosong" } } },
      kewarganegaraan:   { validators: { notEmpty: { message: "kewarganegaraan tidak boleh kosong" } } },
      namalengkapprofil: { validators: { notEmpty: { message: "nama lengkap tidak boleh kosong" } } },
      namapanggilan:     { validators: { notEmpty: { message: "nama panggilan tidak boleh kosong" } } },
      tempatlahirprofil: { validators: { notEmpty: { message: "tempat lahir tidak boleh kosong" } } },
      tanggallahirprofil:{ validators: { notEmpty: { message: "tanggal lahir tidak boleh kosong" } } },
      jeniskelaminprofil:{ validators: { notEmpty: { message: "jenis kelamin tidak boleh kosong" } } },
      statuspernikahan:  { validators: { notEmpty: { message: "status pernikahan tidak boleh kosong" } } },
      emailprofil:       { validators: { notEmpty: { message: "email tidak boleh kosong" } } },
    }
  })
  .on('success.form.bv', function(e) {
    $('#btnSimpan').attr('disabled', true);
  });

  $(document).on('click', '.linkverifikasiemail', function(e) {
    e.preventDefault();
    var thiss = $(this);
    var email = $('#emailprofil').val();
    $.ajax({ url: '<?= site_url('akun/sendverifikasiemail') ?>', type: 'GET', dataType: 'json', data: {'email': email} })
    .done(function(response) {
      if (response.success) {
        thiss.hide();
        thiss.parent().html(thiss.parent().html() + ' <span class="text-success">Sudah dikirim</span>');
      } else { swal("Upss!", response.msg, "info"); }
    });
  });

  $(document).on('click', '.linkverifikasihp', function(e) {
    e.preventDefault();
    var thiss = $(this);
    var nohp = $('#nohpprofil').val();
    $.ajax({ url: '<?= site_url('akun/sendverifikasihp') ?>', type: 'GET', dataType: 'json', data: {'nohp': nohp} })
    .done(function(response) {
      if (response.success) {
        thiss.hide();
        thiss.parent().html(thiss.parent().html() + ' <span class="text-success">Sudah dikirim</span>');
      } else { swal("Upss!", response.msg, "info"); }
    });
  });

});

function getKabupaten(idprovinsi, idkabupatendefault) {
  idkabupatendefault = idkabupatendefault || "";
  $('#kotakabupaten').empty();
  $('#kecamatan').empty();
  addSelectOption('kotakabupaten', '', 'Pilih kabupaten/ kota ...');
  addSelectOption('kecamatan', '', 'Pilih kecamatan ...');
  $.ajax({ url: '<?= site_url('akun/getKabupaten') ?>', type: 'GET', dataType: 'json', data: { 'idprovinsi': idprovinsi } })
  .done(function(response) {
    if (response.length > 0) {
      for (var i = 0; i < response.length; i++) {
        addSelectOption('kotakabupaten', response[i]['idkabupaten'], response[i]['namakabupaten']);
        if (idkabupatendefault && idkabupatendefault == response[i]['idkabupaten']) {
          $('#kotakabupaten').val(response[i]['idkabupaten']).trigger('change');
        }
      }
    }
  });
}

$('#propinsi').change(function() { getKabupaten($(this).val()); });
$('#kotakabupaten').change(function() { getKecamatan($(this).val()); });
$('#kecamatan').change(function() { getdesa($(this).val()); });

function getKecamatan(idkabupaten, idkecamatandefault) {
  idkecamatandefault = idkecamatandefault || "";
  $('#kecamatan').empty();
  addSelectOption('kecamatan', '', 'Pilih kecamatan ...');
  $.ajax({ url: '<?= site_url('akun/getKecamatan') ?>', type: 'GET', dataType: 'json', data: { 'idkabupaten': idkabupaten } })
  .done(function(response) {
    if (response.length > 0) {
      for (var i = 0; i < response.length; i++) {
        addSelectOption('kecamatan', response[i]['idkecamatan'], response[i]['namakecamatan']);
        if (idkecamatandefault && idkecamatandefault == response[i]['idkecamatan']) {
          $('#kecamatan').val(response[i]['idkecamatan']).trigger('change');
        }
      }
    }
  });
}

function getdesa(idkecamatan, iddesadefault) {
  iddesadefault = iddesadefault || "";
  $('#kelurahan').empty();
  addSelectOption('kelurahan', '', 'Pilih kelurahan ...');
  $.ajax({ url: '<?= site_url('akun/getKelurahan') ?>', type: 'GET', dataType: 'json', data: { 'idkecamatan': idkecamatan } })
  .done(function(response) {
    if (response.length > 0) {
      for (var i = 0; i < response.length; i++) {
        addSelectOption('kelurahan', response[i]['iddesa'], response[i]['namadesa']);
        if (iddesadefault && iddesadefault == response[i]['iddesa']) {
          $('#kelurahan').val(response[i]['iddesa']).trigger('change');
        }
      }
    }
  });
}
</script>

</body>
</html>