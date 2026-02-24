<?php $this->load->view('template/festavalive/header'); ?>
<body>

<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

<style>
body{
  font-family:'Figtree',sans-serif;
  background:#f3f4f6;
  color:#0f172a;
}

/* ===== WRAP ===== */
.detail-wrap{padding:130px 0 60px}
.detail-card{
  background:#fff;
  border-radius:24px;
  box-shadow:0 12px 34px rgba(0,0,0,.08);
  overflow:hidden;
}

/* ===== TOP SPLIT ===== */
.detail-top{
  display:grid;
  grid-template-columns:1.1fr 1fr;
}
.detail-media{
  background:#111;
}
.detail-media img{
  width:100%;
  height:100%;
  object-fit:cover;
}
.detail-info{
  padding:44px 46px;
}
.badge-loc{
  font-size:.75rem;
  letter-spacing:.14em;
  color:#f97316;
  font-weight:600;
  margin-bottom:14px;
}
.title-loc{
  font-size:2.2rem;
  font-weight:700;
  margin-bottom:26px;
  line-height:1.15;
}

/* ===== INFO ROW ===== */
.info-row{
  display:flex;
  gap:14px;
  margin-bottom:18px;
}
.info-icon{
  width:40px;
  height:40px;
  border-radius:12px;
  background:#fff7ed;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#f97316;
  font-size:17px;
  flex-shrink:0;
}
.info-text{
  font-size:.95rem;
  color:#475569;
}
.info-text b{
  color:#0f172a;
  display:block;
  margin-bottom:2px;
}

/* ===== ACTIONS ===== */
.actions{
  display:flex;
  gap:12px;
  margin-top:26px;
}
.btn-route{
  background:#f59e0b;
  color:#fff;
  border:none;
  border-radius:12px;
  padding:12px 22px;
  font-weight:600;
  text-decoration:none;
}
.btn-social{
  width:44px;
  height:44px;
  border-radius:12px;
  background:#f1f5f9;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#0f172a;
  text-decoration:none;
  font-size:18px;
}

/* ===== BOTTOM ===== */
.detail-bottom{
  display:grid;
  grid-template-columns:1fr 1fr;
  border-top:1px solid #e5e7eb;
}
.section{
  padding:36px 46px;
}
.section h3{
  font-size:1.2rem;
  font-weight:700;
  margin-bottom:18px;
}
.schedule-item{
  background:#f8fafc;
  border-radius:12px;
  padding:14px 16px;
  display:flex;
  justify-content:space-between;
  margin-bottom:10px;
  font-size:.92rem;
}
.schedule-item span:last-child{
  color:#f59e0b;
  font-weight:600;
}
.desc{
  font-size:.95rem;
  color:#475569;
  line-height:1.7;
}

/* ===== GALLERY ===== */
.owl-dots{
  position:absolute;
  bottom:14px;
  width:100%;
  text-align:center;
}
.owl-dots .owl-dot span{
  background:rgba(255,255,255,.6)!important;
}
.owl-nav button{
  position:absolute;
  top:50%;
  transform:translateY(-50%);
  width:40px;
  height:40px;
  border-radius:50%!important;
  background:rgba(255,255,255,.9)!important;
}
.owl-nav .owl-prev{left:12px}
.owl-nav .owl-next{right:12px}

/* ===== RESPONSIVE ===== */
@media(max-width:992px){
  .detail-top{grid-template-columns:1fr}
  .detail-bottom{grid-template-columns:1fr}
  .detail-info,.section{padding:26px}
  .title-loc{font-size:1.6rem}
}
</style>

<main>
<?php $this->load->view('template/festavalive/topmenu'); ?>

<section class="detail-wrap">
<div class="container">
<div class="detail-card">

<!-- TOP -->
<div class="detail-top">

<!-- MEDIA -->
<div class="detail-media">
<div id="gallery" class="owl-carousel owl-theme">
<?php
$gambarsampul=base_url('myesc.id/images/nofoto.png');
if(!empty($rowCabang->gambarsampul)){
  $gambarsampul=base_url('myesc.id/admin/uploads/cabanggereja/'.$rowCabang->gambarsampul);
}
?>
<div class="item"><img src="<?php echo $gambarsampul?>"></div>

<?php
if($rsGallery->num_rows()>0){
foreach($rsGallery->result() as $g){
$f=base_url('myesc.id/admin/uploads/cabanggereja/gallery/'.$g->filegallery);
?>
<div class="item"><img src="<?php echo $f?>"></div>
<?php }}?>
</div>
</div>

<!-- INFO -->
<div class="detail-info">
<div class="badge-loc">LOCATION PROFILE</div>
<div class="title-loc"><?php echo $rowCabang->namacabang?></div>

<div class="info-row">
<div class="info-icon">📍</div>
<div class="info-text">
<b>Alamat Gereja</b>
<?php echo $rowCabang->alamatlengkap?>
</div>
</div>

<div class="info-row">
<div class="info-icon">📞</div>
<div class="info-text">
<b>No Telepon</b>
<?php echo $rowCabang->notelp?>
</div>
</div>

<div class="info-row">
<div class="info-icon">👤</div>
<div class="info-text">
<b>Nama Gembala</b>
<?php echo $rowCabang->namagembala?>
</div>
</div>

<div class="actions">
<a class="btn-route" target="_blank"
href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($rowCabang->alamatlengkap)?>">
Dapatkan Rute
</a>

<?php if(!empty($rowCabang->urlinstagram)){?>
<a class="btn-social" href="<?php echo $rowCabang->urlinstagram?>" target="_blank">IG</a>
<?php }?>
<?php if(!empty($rowCabang->urlyoutube)){?>
<a class="btn-social" href="<?php echo $rowCabang->urlyoutube?>" target="_blank">YT</a>
<?php }?>
<?php if(!empty($rowCabang->urlfacebook)){?>
<a class="btn-social" href="<?php echo $rowCabang->urlfacebook?>" target="_blank">FB</a>
<?php }?>
</div>

</div>
</div>

<!-- BOTTOM -->
<div class="detail-bottom">

<div class="section">
<h3>Jadwal Ibadah</h3>
<?php
$jadwal=explode("\n",$rowCabang->jadwalibadah);
foreach($jadwal as $j){
if(trim($j)!=""){
?>
<div class="schedule-item">
<span><?php echo htmlspecialchars($j)?></span>
<span></span>
</div>
<?php }}?>
</div>

<?php if(!empty($rowCabang->deskripsi)){?>
<div class="section">
<h3>Deskripsi Gereja</h3>
<div class="desc"><?php echo $rowCabang->deskripsi?></div>
</div>
<?php }?>

</div>

</div>
</div>
</section>
</main>

<?php $this->load->view('template/festavalive/footer'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$('#gallery').owlCarousel({
  items:1,
  loop:true,
  nav:true,
  dots:true
});
</script>

</body>
</html>