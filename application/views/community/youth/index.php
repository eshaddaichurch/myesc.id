<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>
<?php $this->load->view('template/festavalive/topmenu'); ?>


<body>

  <style>
    /*--------------------------------------------------------------
# Sections & Section Header
--------------------------------------------------------------*/

    .section-bg {
      background-color: #f5f6f7;
    }

    .section-header {
      text-align: center;
      padding-bottom: 70px;
    }

    .section-header h2 {
      font-size: 32px;
      font-weight: 700;
      position: relative;
      color: #2e3135;
    }

    .section-header h2:before,
    .section-header h2:after {
      content: "";
      width: 50px;
      height: 2px;
      background: var(--color-primary);
      display: inline-block;
    }

    .section-header h2:before {
      margin: 0 15px 10px 0;
    }

    .section-header h2:after {
      margin: 0 0 10px 15px;
    }

    .section-header p {
      margin: 0 auto 0 auto;
    }

    @media (min-width: 1199px) {
      .section-header p {
        max-width: 60%;
      }
    }

    /*--------------------------------------------------------------
# Breadcrumbs
--------------------------------------------------------------*/
    .breadcrumbs {
      padding: 140px 0 60px 0;
      min-height: 30vh;
      position: relative;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .breadcrumbs:before {
      content: "";
      background-color: rgba(0, 0, 0, 0.6);
      position: absolute;
      inset: 0;
    }

    .breadcrumbs h2 {
      font-size: 56px;
      font-weight: 500;
      color: #fff;
      font-family: var(--font-secondary);
    }

    .breadcrumbs ol {
      display: flex;
      flex-wrap: wrap;
      list-style: none;
      padding: 0 0 10px 0;
      margin: 0;
      font-size: 16px;
      font-weight: 600;
      color: var(--color-primary);
    }

    .breadcrumbs ol a {
      color: rgba(255, 255, 255, 0.8);
      transition: 0.3s;
    }

    .breadcrumbs ol a:hover {
      text-decoration: underline;
    }

    .breadcrumbs ol li+li {
      padding-left: 10px;
    }

    .breadcrumbs ol li+li::before {
      display: inline-block;
      padding-right: 10px;
      color: #fff;
      content: "/";
    }


    /*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/
    .header {
      z-index: 997;
      position: absolute;
      padding: 30px 0;
      top: 0;
      left: 0;
      right: 0;
    }





    /*--------------------------------------------------------------
# Blog
--------------------------------------------------------------*/
    .blog .blog-pagination {
      margin-top: 30px;
      color: #838893;
    }

    .blog .blog-pagination ul {
      display: flex;
      padding: 0;
      margin: 0;
      list-style: none;
    }

    .blog .blog-pagination li {
      margin: 0 5px;
      transition: 0.3s;
    }

    .blog .blog-pagination li a {
      color: var(--color-secondary);
      padding: 7px 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .blog .blog-pagination li.active,
    .blog .blog-pagination li:hover {
      background: var(--color-primary);
      color: #fff;
    }

    .blog .blog-pagination li.active a,
    .blog .blog-pagination li:hover a {
      color: var(--color-white);
    }

    /*--------------------------------------------------------------
# Blog Posts List
--------------------------------------------------------------*/
    .blog .posts-list .post-item {
      box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.06);
      transition: 0.3s;
    }

    .blog .posts-list .post-img img {
      transition: 0.5s;
    }

    .blog .posts-list .post-date {
      position: absolute;
      right: 0;
      bottom: 0;
      background-color: var(--color-primary);
      color: #fff;
      text-transform: uppercase;
      font-size: 13px;
      padding: 6px 12px;
      font-weight: 500;
    }

    .blog .posts-list .post-content {
      padding: 30px;
    }

    .blog .posts-list .post-title {
      font-size: 24px;
      color: var(--color-secondary);
      font-weight: 700;
      transition: 0.3s;
      margin-bottom: 15px;
    }

    .blog .posts-list .meta i {
      font-size: 16px;
      color: var(--color-primary);
    }

    .blog .posts-list .meta span {
      font-size: 15px;
      color: #838893;
    }

    .blog .posts-list p {
      margin-top: 20px;
    }

    .blog .posts-list hr {
      color: #888;
      margin-bottom: 20px;
    }

    .blog .posts-list .readmore {
      display: flex;
      align-items: center;
      font-weight: 600;
      line-height: 1;
      transition: 0.3s;
      color: #838893;
    }

    .blog .posts-list .readmore i {
      line-height: 0;
      margin-left: 6px;
      font-size: 16px;
    }

    .blog .posts-list .post-item:hover .post-title,
    .blog .posts-list .post-item:hover .readmore {
      color: var(--color-primary);
    }

    .blog .posts-list .post-item:hover .post-img img {
      transform: scale(1.1);
    }

    /*--------------------------------------------------------------
# Blog Details
--------------------------------------------------------------*/
    .blog .blog-details {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .blog .blog-details .post-img {
      margin: -30px -30px 20px -30px;
      overflow: hidden;
    }

    .blog .blog-details .title {
      font-size: 28px;
      font-weight: 700;
      padding: 0;
      margin: 20px 0 0 0;
      color: var(--color-secondary);
    }

    .blog .blog-details .content {
      margin-top: 20px;
    }

    .blog .blog-details .content h3 {
      font-size: 22px;
      margin-top: 30px;
      font-weight: bold;
    }

    .blog .blog-details .content blockquote {
      overflow: hidden;
      background-color: rgba(82, 86, 94, 0.06);
      padding: 60px;
      position: relative;
      text-align: center;
      margin: 20px 0;
    }

    .blog .blog-details .content blockquote p {
      color: var(--color-default);
      line-height: 1.6;
      margin-bottom: 0;
      font-style: italic;
      font-weight: 500;
      font-size: 22px;
    }

    .blog .blog-details .content blockquote:after {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background-color: var(--color-primary);
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .blog .blog-details .meta-top {
      margin-top: 20px;
      color: #6c757d;
    }

    .blog .blog-details .meta-top ul {
      display: flex;
      flex-wrap: wrap;
      list-style: none;
      align-items: center;
      padding: 0;
      margin: 0;
    }

    .blog .blog-details .meta-top ul li+li {
      padding-left: 20px;
    }

    .blog .blog-details .meta-top i {
      font-size: 16px;
      margin-right: 8px;
      line-height: 0;
      color: var(--color-primary);
    }

    .blog .blog-details .meta-top a {
      color: #6c757d;
      font-size: 14px;
      display: inline-block;
      line-height: 1;
      transition: 0.3s;
    }

    .blog .blog-details .meta-top a:hover {
      color: var(--color-primary);
    }

    .blog .blog-details .meta-bottom {
      padding-top: 10px;
      border-top: 1px solid rgba(82, 86, 94, 0.15);
    }

    .blog .blog-details .meta-bottom i {
      color: #838893;
      display: inline;
    }

    .blog .blog-details .meta-bottom a {
      color: rgba(82, 86, 94, 0.8);
      transition: 0.3s;
    }

    .blog .blog-details .meta-bottom a:hover {
      color: var(--color-primary);
    }

    .blog .blog-details .meta-bottom .cats {
      list-style: none;
      display: inline;
      padding: 0 20px 0 0;
      font-size: 14px;
    }

    .blog .blog-details .meta-bottom .cats li {
      display: inline-block;
    }

    .blog .blog-details .meta-bottom .tags {
      list-style: none;
      display: inline;
      padding: 0;
      font-size: 14px;
    }

    .blog .blog-details .meta-bottom .tags li {
      display: inline-block;
    }

    .blog .blog-details .meta-bottom .tags li+li::before {
      padding-right: 6px;
      color: var(--color-default);
      content: ",";
    }

    .blog .blog-details .meta-bottom .share {
      font-size: 16px;
    }

    .blog .blog-details .meta-bottom .share i {
      padding-left: 5px;
    }

    .blog .post-author {
      padding: 20px;
      margin-top: 30px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .blog .post-author img {
      max-width: 120px;
      margin-right: 20px;
    }

    .blog .post-author h4 {
      font-weight: 600;
      font-size: 22px;
      margin-bottom: 0px;
      padding: 0;
      color: var(--color-secondary);
    }

    .blog .post-author .social-links {
      margin: 0 10px 10px 0;
    }

    .blog .post-author .social-links a {
      color: rgba(82, 86, 94, 0.5);
      margin-right: 5px;
    }

    .blog .post-author p {
      font-style: italic;
      color: rgba(108, 117, 125, 0.8);
      margin-bottom: 0;
    }

    /*--------------------------------------------------------------
# Blog Sidebar
--------------------------------------------------------------*/
    .blog .sidebar {
      padding: 30px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .blog .sidebar .sidebar-title {
      font-size: 20px;
      font-weight: 700;
      padding: 0;
      margin: 0;
      color: var(--color-secondary);
    }

    .blog .sidebar .sidebar-item+.sidebar-item {
      margin-top: 40px;
    }

    .blog .sidebar .search-form form {
      background: #fff;
      border: 1px solid rgba(82, 86, 94, 0.3);
      padding: 3px 10px;
      position: relative;
    }

    .blog .sidebar .search-form form input[type=text] {
      border: 0;
      padding: 4px;
      border-radius: 4px;
      width: calc(100% - 40px);
    }

    .blog .sidebar .search-form form input[type=text]:focus {
      outline: none;
    }

    .blog .sidebar .search-form form button {
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      border: 0;
      background: none;
      font-size: 16px;
      padding: 0 15px;
      margin: -1px;
      background: var(--color-primary);
      color: var(--color-secondary);
      transition: 0.3s;
      border-radius: 0 4px 4px 0;
      line-height: 0;
    }

    .blog .sidebar .search-form form button i {
      line-height: 0;
    }

    .blog .sidebar .search-form form button:hover {
      background: rgba(254, 185, 0, 0.8);
    }

    .blog .sidebar .categories ul {
      list-style: none;
      padding: 0;
    }

    .blog .sidebar .categories ul li+li {
      padding-top: 10px;
    }

    .blog .sidebar .categories ul a {
      color: var(--color-secondary);
      transition: 0.3s;
    }

    .blog .sidebar .categories ul a:hover {
      color: var(--color-default);
    }

    .blog .sidebar .categories ul a span {
      padding-left: 5px;
      color: rgba(54, 77, 89, 0.4);
      font-size: 14px;
    }

    .blog .sidebar .recent-posts .post-item {
      display: flex;
    }

    .blog .sidebar .recent-posts .post-item+.post-item {
      margin-top: 15px;
    }

    .blog .sidebar .recent-posts img {
      max-width: 80px;
      margin-right: 15px;
    }

    .blog .sidebar .recent-posts h4 {
      font-size: 15px;
      font-weight: bold;
    }

    .blog .sidebar .recent-posts h4 a {
      color: var(--color-secondary);
      transition: 0.3s;
    }

    .blog .sidebar .recent-posts h4 a:hover {
      color: var(--color-primary);
    }

    .blog .sidebar .recent-posts time {
      display: block;
      font-style: italic;
      font-size: 14px;
      color: rgba(54, 77, 89, 0.4);
    }

    .blog .sidebar .tags {
      margin-bottom: -10px;
    }

    .blog .sidebar .tags ul {
      list-style: none;
      padding: 0;
    }

    .blog .sidebar .tags ul li {
      display: inline-block;
    }

    .blog .sidebar .tags ul a {
      color: #838893;
      font-size: 14px;
      padding: 6px 14px;
      margin: 0 6px 8px 0;
      border: 1px solid rgba(131, 136, 147, 0.4);
      display: inline-block;
      transition: 0.3s;
    }

    .blog .sidebar .tags ul a:hover {
      color: var(--color-secondary);
      border: 1px solid var(--color-primary);
      background: var(--color-primary);
    }

    .blog .sidebar .tags ul a span {
      padding-left: 5px;
      color: rgba(131, 136, 147, 0.8);
      font-size: 14px;
    }

    /*--------------------------------------------------------------
# Blog Comments
--------------------------------------------------------------*/
    .blog .comments {
      margin-top: 30px;
    }

    .blog .comments .comments-count {
      font-weight: bold;
    }

    .blog .comments .comment {
      margin-top: 30px;
      position: relative;
    }

    .blog .comments .comment .comment-img {
      margin-right: 14px;
    }

    .blog .comments .comment .comment-img img {
      width: 60px;
    }

    .blog .comments .comment h5 {
      font-size: 16px;
      margin-bottom: 2px;
    }

    .blog .comments .comment h5 a {
      font-weight: bold;
      color: var(--color-default);
      transition: 0.3s;
    }

    .blog .comments .comment h5 a:hover {
      color: var(--color-primary);
    }

    .blog .comments .comment h5 .reply {
      padding-left: 10px;
      color: var(--color-secondary);
    }

    .blog .comments .comment h5 .reply i {
      font-size: 20px;
    }

    .blog .comments .comment time {
      display: block;
      font-size: 14px;
      color: rgba(82, 86, 94, 0.8);
      margin-bottom: 5px;
    }

    .blog .comments .comment.comment-reply {
      padding-left: 40px;
    }

    .blog .comments .reply-form {
      margin-top: 30px;
      padding: 30px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .blog .comments .reply-form h4 {
      font-weight: bold;
      font-size: 22px;
    }

    .blog .comments .reply-form p {
      font-size: 14px;
    }

    .blog .comments .reply-form input {
      border-radius: 4px;
      padding: 10px 10px;
      font-size: 14px;
    }

    .blog .comments .reply-form input:focus {
      box-shadow: none;
      border-color: rgba(254, 185, 0, 0.8);
    }

    .blog .comments .reply-form textarea {
      border-radius: 4px;
      padding: 10px 10px;
      font-size: 14px;
    }

    .blog .comments .reply-form textarea:focus {
      box-shadow: none;
      border-color: rgba(254, 185, 0, 0.8);
    }

    .blog .comments .reply-form .form-group {
      margin-bottom: 25px;
    }

    .blog .comments .reply-form .btn-primary {
      border-radius: 4px;
      padding: 10px 20px;
      border: 0;
      background-color: var(--color-secondary);
    }

    .blog .comments .reply-form .btn-primary:hover {
      color: var(--color-secondary);
      background-color: var(--color-primary);
    }

    /* Tombol */
    /* button {
  --color: #0077ff;
  --color1:white;
  --color2:#FF6500;
  font-family: inherit;
  display: inline-block;
  width: 6em;
  height: 2.6em;
  line-height: 2.5em;
  overflow: hidden;
  cursor: pointer;
  margin: 20px;
  font-size: 17px;
  z-index: 1;
  color: var(--color2);
  border: 2px solid var(--color1);
  border-radius: 6px;
  position: relative;
}

button::before {
  position: absolute;
  content: "";
  background: var(--color2);
  width: 150px;
  height: 200px;
  z-index: -1;
  border-radius: 50%;
}

button:hover {
  color: var(--color1);
}

button:before {
  top: 100%;
  left: 100%;
  transition: 0.3s all;
}

button:hover::before {
  top: -30px;
  left: -30px;
} */
  </style>

  <section>
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('<?php echo base_url('myesc.id/assets/gambar/back.jpg'); ?>'); height: 400px; background-size: cover; background-position: center;">
      <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

        <h2><?php echo $title ?></h2>
        <!-- <button>Daftar</button> -->


      </div>
    </div><!-- End Breadcrumbs -->
  </section>

  <section id="blog" class="blog" style="padding-top: 70px;">
    <div class="container">

      <div>
        <p>Di tengah dunia yang terus berubah dan penuh tantangan, generasi muda memerlukan ruang yang mendukung pertumbuhan iman, pengembangan karakter, dan pergaulan yang sehat. Gereja Bethel Indonesia (GBI) El Shaddai menjawab kebutuhan ini dengan membentuk sebuah komunitas yang dikenal sebagai Youth. Komunitas ini menjadi tempat berkumpulnya anak-anak muda yang ingin belajar, bertumbuh, dan melayani bersama dalam lingkungan rohani yang positif.</p>
        <h5>Apa itu Youth?</h5>
        <p>Youth adalah komunitas anak muda di bawah naungan GBI El Shaddai. Komunitas ini menjadi wadah bagi para remaja dan pemuda untuk saling mendukung dalam iman dan kehidupan sehari-hari. Tidak hanya fokus pada kegiatan kerohanian, Youth juga mengadakan berbagai aktivitas yang mendukung perkembangan bakat dan minat para anggotanya. Dengan semangat yang inklusif dan ramah, Youth menyambut siapa saja yang ingin bertumbuh bersama, baik dalam iman Kristen maupun dalam hubungan sosial yang sehat.</p>
        <h5>Visi dan Misi Youth</h5>
        <p>Visi utama Youth adalah untuk membentuk generasi muda yang memiliki iman yang kuat, karakter yang baik, dan semangat melayani. Dengan adanya komunitas ini, diharapkan para anggotanya dapat menjadi terang dan garam bagi dunia, sesuai dengan ajaran Yesus Kristus. Misi Youth di GBI El Shaddai mencakup beberapa hal penting, antara lain:</p>

        <ol>
          <li>
            Memperdalam Iman dan Hubungan dengan Tuhan: Melalui pengajaran Alkitab, ibadah, dan pembinaan rohani, Youth membantu para anggotanya untuk memahami firman Tuhan dan hidup sesuai dengan nilai-nilai Kristiani.
          </li>
          <li>
            Mengembangkan Karakter dan Kepemimpinan: Youth mengadakan berbagai pelatihan yang bertujuan untuk membangun karakter yang kuat dan keterampilan kepemimpinan. Hal ini penting agar setiap anggota dapat menjadi teladan baik di lingkungan gereja maupun masyarakat.
          </li>
          <li>
            Membangun Komunitas yang Hangat dan Mendukung: Youth berusaha menciptakan lingkungan yang aman dan mendukung bagi anggotanya. Di sini, anak-anak muda dapat saling berbagi cerita, menghadapi tantangan bersama, dan membangun persahabatan yang bermakna.
          </li>
        </ol>
        <h5> Kegiatan dan Program Youth</h5>
        <p>Komunitas Youth memiliki berbagai program yang dirancang khusus untuk mendukung kebutuhan rohani dan sosial anak muda, di antaranya:</p>
        <ul>
          <li>
            Ibadah dan Pujian: Setiap minggunya, Youth mengadakan ibadah khusus yang diisi dengan pujian, penyembahan, dan firman Tuhan yang relevan bagi kehidupan sehari-hari anak muda.
          </li>
          <li>
            Kelompok Kecil (Small Group): Youth membentuk kelompok-kelompok kecil yang memungkinkan anggotanya untuk lebih dalam mengenal satu sama lain, berdiskusi tentang Alkitab, serta membangun keintiman dan saling dukung dalam doa.
          </li>
          <li>
            Retreat dan Perkemahan Rohani: Setiap tahun, Youth mengadakan retreat atau perkemahan rohani yang berfungsi sebagai momen untuk mendalami iman, refleksi diri, dan mempererat tali persaudaraan.
          </li>
          <li>
            Pelayanan Sosial: Dalam rangka mewujudkan iman yang aktif, Youth juga terlibat dalam kegiatan sosial seperti bakti sosial, penggalangan dana untuk mereka yang membutuhkan, serta pelayanan di masyarakat.
          </li>
          <li>
            Pengembangan Bakat: Youth memberikan ruang bagi anggotanya untuk mengembangkan bakat dan minat mereka, baik di bidang seni, musik, olahraga, hingga teknologi. Dengan cara ini, anak-anak muda dapat berkontribusi dan melayani dengan cara-cara yang sesuai dengan talenta yang mereka miliki.
          </li>
        </ul>

        <p>Youth di GBI El Shaddai adalah sebuah komunitas yang memfasilitasi anak-anak muda untuk bertumbuh dalam iman dan menjadi pribadi yang lebih baik. Melalui berbagai kegiatan dan program yang disediakan, Youth memberikan dukungan yang penuh kasih bagi para anggotanya, membantu mereka mengatasi tantangan hidup, serta menjadi generasi yang kuat dan berdampak positif. Dengan semangat persaudaraan dan pelayanan, Youth berkomitmen untuk terus memajukan visi dan misi gereja demi kemuliaan nama Tuhan.</p>
      </div>
  </section>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-6 mb-3">
        <div class="card bg-dark text-white" style="height: 200px;">
          <img src="<?php echo base_url('myesc.id/assets/assetku/img/blog/kids.png'); ?>" class="card-img" style="height:100%; object-fit:cover" alt="...">
          <div class="card-img-overlay">
            <h5 class="card-title text-white m-3">KIDS</h5>
            <p class="card-text text-white"> This is a wider card with supporting text below as a natural</p>
            <p class="card-text text-white"><a href="<?php echo base_url('KIDS'); ?>"><b>JOIN KIDS</b></a></p>
          </div>
        </div>
      </div>
      <div class="col-6 mb-3">
        <div class="card bg-dark text-white" style="height: 200px;">
          <img src="<?php echo base_url('myesc.id/assets/gambar/back.jpg'); ?>" class="card-img" style="height:100%; object-fit:cover" alt="...">
          <div class="card-img-overlay">
            <h5 class="card-title text-white m-3">GOLD</h5>
            <p class="card-text text-white"> This is a wider card with supporting text below as a natural</p>
            <p class="card-text text-white"><a href="<?php echo base_url('gold'); ?>"><b>JOIN GOLD</b></a></p>
          </div>
        </div>
      </div>
    </div>
  </div>







</body>

<?php $this->load->view('template/festavalive/footer'); ?>