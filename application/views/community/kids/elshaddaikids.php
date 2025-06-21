<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>
      @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
      $main-green: #79dd09 !default;
      $main-green-rgb-015: rgba(121, 221, 9, 0.1) !default;
      $main-yellow: #bdbb49 !default;
      $main-yellow-rgb-015: rgba(189, 187, 73, 0.1) !default;
      $main-red: #bd150b !default;
      $main-red-rgb-015: rgba(189, 21, 11, 0.1) !default;
      $main-blue: #0076bd !default;
      $main-blue-rgb-015: rgba(0, 118, 189, 0.1) !default;

      /* This pen */


      .dark {
        background: #110f16;
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


      .light {
        background: #f3f5f7;
      }

      a,
      a:hover {
        text-decoration: none;
        transition: color 0.3s ease-in-out;
      }

      #pageHeaderTitle {
        margin: 2rem 0;
        text-transform: uppercase;
        text-align: center;
        font-size: 2.5rem;
      }

      /* Cards */
      .postcard {
        flex-wrap: wrap;
        display: flex;

        box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
        border-radius: 10px;
        margin: 0 0 4rem 0;
        overflow: hidden;
        position: relative;
        color: #ffffff;

        &.dark {
          background-color: #18151f;
        }

        &.light {
          background-color: #e1e5ea;
        }

        .t-dark {
          color: #18151f;
        }

        a {
          color: inherit;
        }

        h1,
        .h1 {
          margin-bottom: 0.5rem;
          font-weight: 500;
          line-height: 1.2;
        }

        .small {
          font-size: 80%;
        }

        .postcard__title {
          font-size: 1.75rem;
          padding-left: 10px;
        }

        .postcard__img {
          max-height: 180px;
          width: 100%;
          object-fit: cover;
          position: relative;
        }

        .postcard__img_link {
          display: contents;
        }

        .postcard__bar {
          width: 50px;
          height: 10px;
          margin: 10px 0;
          border-radius: 5px;
          background-color: #424242;
          transition: width 0.2s ease;
        }

        .postcard__text {
          padding: 2.5rem;
          position: relative;
          display: flex;
          flex-direction: column;
        }

        .postcard__preview-txt {
          overflow: hidden;
          text-overflow: ellipsis;
          text-align: left;
          height: 100%;
        }

        .postcard__tagbox {
          display: flex;
          flex-flow: row wrap;
          font-size: 14px;
          margin: 20px 0 0 0;
          padding: 0;
          justify-content: center;

          .tag__item {

            display: inline-block;
            background: #FAF0E6;
            border-radius: 3px;
            padding: 2.5px 10px;
            margin: 0 5px 5px 0;
            cursor: default;
            user-select: none;
            transition: background-color 0.3s;

            &:hover {
              background: #FFD09B;
            }
          }
        }

        &:before {
          content: "";
          position: abslute;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          background-image: linear-gradient(-70deg, #424242, transparent 50%);
          opacity: 1;
          border-radius: 10px;
        }

        &:hover .postcard__bar {
          width: 100px;
        }
      }

      @media screen and (min-width: 769px) {
        .postcard {
          flex-wrap: inherit;

          .postcard__title {
            font-size: 2rem;
          }

          .postcard__tagbox {
            justify-content: start;
          }

          .postcard__img {
            max-width: 300px;
            max-height: 100%;
            transition: transform 0.3s ease;
          }

          .postcard__text {
            padding-left: 4rem;
            width: 100%;

          }

          .media.postcard__text:before {
            content: "";
            position: absolute;
            display: block;
            background: #18151f;
            top: -20%;
            height: 130%;
            width: 55px;
          }

          &:hover .postcard__img {
            transform: scale(1.1);
          }

          &:nth-child(2n+1) {
            flex-direction: row;
          }

          &:nth-child(2n+0) {
            flex-direction: row-reverse;
          }

          &:nth-child(2n+1) .postcard__text::before {
            left: -12px !important;
            transform: rotate(4deg);
          }

          &:nth-child(2n+0) .postcard__text::before {
            right: -12px !important;
            transform: rotate(-4deg);
          }
        }
      }

      @media screen and (min-width: 1024px) {
        .postcard__text {
          padding: 2rem 3.5rem;
        }

        .postcard__text:before {
          content: "";
          position: absolute;
          display: block;

          top: -20%;
          height: 130%;
          width: 55px;
        }

        .postcard.dark {
          .postcard__text:before {
            background: #18151f;
          }
        }

        .postcard.light {
          .postcard__text:before {
            background: #e1e5ea;
          }
        }
      }
    </style>




    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body,
      html {
        font-family: 'Figtree', sans-serif;
        background-color: #f7a18d;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6,
      p,
      a,
      span,
      div,
      li,
      strong,
      em {
        font-family: 'Figtree', sans-serif !important;
      }

      .section-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        padding: 150px 4%;
        gap: 10px;
      }

      .section-text {
        flex: 1 1 400px;
      }

      @media (max-width: 768px) {
        .section-text {
          flex: 1 1 320px;
        }
      }


      .section-text h1 {
        font-size: 3rem;
        margin-bottom: 20px;
      }

      .section-text p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 30px;
      }

      .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #2f2fff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
      }

      .btn:hover {
        background-color: #1a1aff;
      }

      .section-image {
        /* flex: 1 1 400px; */
        background: #eee;
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .section-image img {
        max-width: 100%;
        max-height: 130%;
        object-fit: cover;
      }

      @media (max-width: 768px) {
        .section-container {
          flex-direction: column;
          text-align: center;
        }

        .section-text h1 {
          font-size: 2.2rem;
        }
      }

      /* Child Dedication Section */
      .section.light.dedication {
        background: #000000;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 40px;
        padding: 30px 20px;
      }

      @media (max-width: 768px) {
        .section.light.dedication {
          background: #000000;
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          justify-content: center;
          gap: 40px;
          padding: 50px 3px;
        }
      }

      .dedication-text {
        flex: 1 1 400px;
        max-width: 600px;
        text-align: left;
      }

      .dedication-text blockquote {
        font-style: italic;
        color: #333;
        margin-top: 20px;
        border-left: 4px solid #ef5008;
        padding-left: 16px;
      }

      .dedication-video {
        flex: 1 1 400px;
        max-width: 560px;
      }

      .dedication-video iframe {
        width: 100%;
        height: 315px;
        border: none;
      }

      .early-years {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #efcb3d;
        padding: 60px 80px;
        color: white;
        flex-wrap: wrap;
      }

      .early-years .content {
        max-width: 600px;
        flex: 1 1 50%;
      }

      .early-years .content .category {
        font-size: 25px;
        opacity: 0.9;
      }

      @media (max-width: 768px) {
        .early-years .content .category {
          font-size: 23px;
          opacity: 0.9;
        }
      }

      .early-years .content h1 {
        font-size: 64px;
        margin: 10px 0;
      }

      @media (max-width: 768px) {
        .early-years .content h1 {
          font-size: 39px;
          margin: 10px 0;
        }
      }

      .early-years .content .quote {
        font-size: 18px;
        font-style: italic;
        margin-bottom: 20px;
      }

      @media (max-width: 768px) {
        .early-years .content .quote {
          font-size: 15px;
          margin-bottom: 10px;
        }
      }

      .early-years .content .description {
        font-size: 18px;
        line-height: 1.6;
      }

      .early-years .image {
        flex: 1 1 40%;
        display: flex;
        justify-content: center;
      }

      .early-years .image img {
        max-width: 80%;
        border-radius: 8px;
        object-fit: cover;
      }

      @media (max-width: 768px) {
        .early-years .image img {
          max-width: 130%;
          border-radius: 10px;
          object-fit: cover;
        }

      }


      /* Tambahkan ke file CSS kamu */
      .early-years {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease-in-out;
      }

      .early-years.show {
        opacity: 1;
        transform: translateY(0);
      }


      .kindy-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #b2b4f7;
        padding: 30px 75px;
        color: white;
        flex-wrap: wrap;
      }

      .kindy-image {
        flex: 1 1 40%;
        display: flex;
        justify-content: center;
      }

      .kindy-image img {
        max-width: 80%;
        border-radius: 8px;
        object-fit: cover;
      }

      @media (max-width: 768px) {
        .kindy-image img {
          max-width: 130%;
          border-radius: 10px;
          object-fit: cover;
        }

      }

      .kindy-text {
        flex: 1 1 50%;
        max-width: 600px;
      }

      .kindy-label {
        font-size: 25px;
        opacity: 0.9;
      }

      @media (max-width: 768px) {
        .kindy-label {
          font-size: 23px;
          opacity: 0.9;
        }
      }

      .kindy-title {
        font-size: 64px;
        margin: 10px 0;
      }

      @media (max-width: 768px) {
        .kindy-title {
          font-size: 39px;
          margin: 10px 0;
        }
      }

      .kindy-quote {
        font-size: 18px;
        font-style: italic;
        margin-bottom: 20px;
      }

      @media (max-width: 768px) {
        .kindy-quote {
          font-size: 15px;
          margin-bottom: 20px;
        }
      }

      .kindy-description {
        font-size: 18px;
        line-height: 1.6;
      }

      /* Tambahkan ke file CSS kamu */
      /* .kindy-section {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-in-out;
    }

    .kindy-section.show {
    opacity: 1;
    transform: translateY(0);
    } */


      .shining-years {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f79dd4;
        padding: 30px 80px;
        color: white;
        flex-wrap: wrap;
      }

      .shining-years .content {
        max-width: 600px;
        flex: 1 1 50%;
      }

      .shining-years .content .category {
        font-size: 16px;
        opacity: 0.9;
      }

      @media (max-width: 768px) {
        .shining-years .content .category {
          font-size: 23px;
          opacity: 0.9;
        }
      }

      .shining-years .content h1 {
        font-size: 64px;
        margin: 10px 0;
      }

      @media (max-width: 768px) {
        .shining-years .content h1 {
          font-size: 39px;
          margin: 10px 0;
        }
      }

      .shining-years .content .quote {
        font-size: 18px;
        font-style: italic;
        margin-bottom: 20px;
      }

      @media (max-width: 768px) {
        .shining-years .content .quote {
          font-size: 15px;
          margin-bottom: 10px;
        }
      }

      .shining-years .content .description {
        font-size: 18px;
        line-height: 1.6;
      }

      .shining-years .image {
        flex: 1 1 40%;
        display: flex;
        justify-content: center;
      }

      .shining-years .image img {
        max-width: 80%;
        border-radius: 8px;
        object-fit: cover;
      }

      /* Tambahkan ke file CSS kamu */
      /* .shining-years {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-in-out;
    }

    .shining-years.show {
    opacity: 1;
    transform: translateY(0);
    } */

      @media (max-width: 768px) {
        .shining-years .image img {
          max-width: 130%;
          border-radius: 10px;
          object-fit: cover;
        }
      }


      .events-calendar {
        background-color: #ffffff;
        padding: 170px 250px;
        color: white;
      }

      @media (max-width: 768px) {
        .events-calendar {
          background-color: #ffffff;
          padding: 60px 30px;
          color: white;
        }
      }

      .events-title {
        font-size: 24px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 40px;
        text-transform: uppercase;
      }

      .events-list {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
      }

      .event-card {
        background-color: #000000;
        color: #ffffff;
        padding: 70px;
        border-radius: 6px;
        flex: 1 1 280px;
        max-width: 320px;
      }

      .event-date,
      .event-date-range {
        color: #757265;
        font-size: 14px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .event-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
      }

      .event-subtitle {
        font-size: 16px;
        color: #ffffff;
      }

      @media (max-width: 768px) {
        .event-subtitle {
          font-size: 12px;
          color: #ffffff;
        }
      }





      @media (max-width: 768px) {
        .hero-content h1 {
          font-size: 2.5rem;
        }

        .hero-content h2 {
          font-size: 2rem;
        }

        .hero-content {
          width: 100%;
          padding: 20px;
        }
      }

      .school-list div {
        animation: blink 1s infinite;
      }

      @keyframes blink {

        0%,
        100% {
          opacity: 1;
        }

        50% {
          opacity: 0;
        }
      }
    </style>
    </head>

    <body>


      <section class="section-container" id="small-groups" data-aos="fade-up">
        <div class="section-text">
          <h1 style="color: #ffffff; font-size: 100px;">KIDS</h1>
          <a href="#" class="btn" style="background-color: #000000;">
            Daftar ESC Kids →
          </a>
        </div>
        <div class="section-image">
          <!--<img src="assets/gambar/kids1.JPG" alt="Small Groups">-->
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids1.JPG'); ?>" alt="Small Groups">
        </div>
      </section>

      <!-- Section: Child Dedication -->
      <div class="section light dedication">
        <div class="dedication-video">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <div class="dedication-text">
          <br>
          <p style="color: #ffffff; text-align: justify;">
            Kami percaya bahwa anak-anak bukan hanya masa depan Gereja,tetapi bagian penting dari misi Allah, dipanggil untuk menghidupi Amanat Agungb <b>(Matius 28:19-20)</b> menjadi terang dunia (Matius 5:14), dan pembawa damai di tengah generasinya. Bersama El Shaddai Church, kami membangun generasi yang akan berdiri teguh diatas kebenaran dan membawa Kerajaan Allah hadir di bumi sejak usia dini.
          </p>
          <br>
          <p style="color: #ffffff;">
            Semua anakmu akan menjadi murid TUHAN, dan besarlah kesejahteraan mereka.
          </p>
          <p style="color: #ffffff;">
            - Yesaya 54:13
          </p>
        </div>
      </div>


      <section class="early-years">
        <div class="content">
          <p class="category">0 - 1 Tahun</p>
          <h1>Baby Class</h1>
          <p class="quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>
          <br>
          <p class="category">1 - 3 Tahun</p>
          <h1>Toddler Class</h1>
          <p class="quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>
          <!-- <p class="description">
            These are wonderful years where hearts and minds are being shaped and
            often it looks like play. We engage children in Biblical stories, worship
            time and make sure we create an environment where children can play with
            Jesus. We host Early Years every Sunday morning, Sunday night, and
            Tuesday night when Equip classes are on.
          </p> -->
        </div>
        <div class="image">
          <!--<img src="assets/gambar/kids6.JPG" alt="Small Groups">-->
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids6.JPG'); ?>" alt="Small Groups">
        </div>
      </section>

      <section class="kindy-section">
        <div class="kindy-image">
          <!--<img src="assets/gambar/kids5.jpg" alt="Small Groups">-->
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids5.jpg'); ?>" alt="Small Groups">
        </div>

        </div>
        <div class="kindy-text">
          <br>
          <p class="kindy-label">3 (PG - TK B) - 5 (PG - TK B)</p>
          <h1 class="kindy-title">Joyful Class</h1>
          <p class="kindy-quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>

          <p class="kindy-label">1 SD - 2 SD</p>
          <h1 class="kindy-title">The Explorer Class</h1>
          <p class="kindy-quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>

        </div>
      </section>


      <section class="shining-years">
        <div class="content">
          <p class="category">3 SD - 5 SD</p>
          <h1>Shining Star</h1>
          <p class="quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>
          <br>
          <p class="category">6 SD - 1 SMP</p>
          <h1>Dunamos Class</h1>
          <p class="quote">
            <!-- "Play is often talked about as if it were a relief from serious learning.
            But for children play is serious learning. Play is really the work of
            childhood." - Fred Rogers -->
          </p>
          <!-- <p class="description">
            These are wonderful years where hearts and minds are being shaped and
            often it looks like play. We engage children in Biblical stories, worship
            time and make sure we create an environment where children can play with
            Jesus. We host Early Years every Sunday morning, Sunday night, and
            Tuesday night when Equip classes are on.
          </p> -->
        </div>
        <div class="image">
          <!--<img src="assets/gambar/kids7.jpg" alt="Small Groups">-->
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids7.jpg'); ?>" alt="Small Groups">
        </div>
      </section>

      <section class="events-calendar">
        <h2 class="events-title" style="color: #000000;">Jadwal Ibadah ESC Kids</h2>
        <div class="events-list">
          <div>
            <!--<img src="assets/gambar/KS1.png" alt="">-->
            <img src="<?php echo base_url('myesc.id/assets/gambar/KS1.png'); ?>" alt="Small Groups">
            <p class="event-date-range"></p>

          </div>
          <div>
            <!--<img src="assets/gambar/KS2.png" alt="">-->
            <img src="<?php echo base_url('myesc.id/assets/gambar/KS2.png'); ?>" alt="Small Groups">
            <p class="event-date"></p>

          </div>
          <div>
            <!--<img src="assets/gambar/KS3.png" alt="">-->
            <img src="<?php echo base_url('myesc.id/assets/gambar/KS3.png'); ?>" alt="Small Groups">
            <p class="event-date"></p>

          </div>
        </div>
      </section>


      <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
      <script>
        AOS.init({
          duration: 1000,
          once: true,
        });


        const section = document.querySelector('.early-years');
        const section2 = document.querySelector('.kindy-section');
        const section3 = document.querySelector('.shining-years');

        function revealOnScroll() {
          const sectionTop = section.getBoundingClientRect().top;
          const windowHeight = window.innerHeight;

          if (sectionTop < windowHeight - 100) {
            section.classList.add('show');
          }
        }

        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);
      </script>


      <?php $this->load->view('template/festavalive/footer'); ?>