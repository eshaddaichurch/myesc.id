<?php $this->load->view('template/festavalive/header'); ?>


<body>

  <style>
    @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700,900);



    body {
      background: #ffffff;
      color: #4f585e;
      font-family: 'Source Sans Pro', sans-serif;
      text-rendering: optimizeLegibility;
    }


    a.btn {
      background: #f5008;
      border-radius: 16px;
      box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.25);
      color: #ffffff;
      display: inline-block;
      padding: 20px 50px 20px;
      position: relative;
      text-decoration: none;
      transition: all 0.1s 0s ease-out;
    }

    .no-touch a.btn:hover {
      background: lighten(#0096a0, 2.5);
      box-shadow: 0px 8px 2px 0 rgba(0, 0, 0, 0.075);
      transform: translateY(-2px);
      transition: all 0.25s 0s ease-out;
    }




    .no-touch a.btn:active,
    a.btn:active {
      background: darken(#0096a0, 2.5);
      box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.25);
      transform: translate3d(0, 1px, 0);
      transition: all 0.025s 0s ease-out;
    }

    div.cards {
      margin: 80px auto;
      max-width: 960px;
      text-align: center;
    }

    div.card {
      background: #ffffff;
      display: inline-block;
      margin: 8px;
      max-width: 300px;
      perspective: 1000;
      position: relative;
      text-align: left;
      transition: all 0.3s 0s ease-in;
      width: 300px;
      z-index: 1;

      img {
        max-width: 300px;
      }

      .card__image-holder {
        background: rgba(0, 0, 0, 0.1);
        height: 0;
        padding-bottom: 75%;
      }

      div.card-title {
        background: #ffffff;
        padding: 6px 15px 10px;
        position: relative;
        z-index: 0;

        a.toggle-info {
          border-radius: 32px;
          height: 32px;
          padding: 0;
          position: absolute;
          right: 15px;
          top: 10px;
          width: 32px;

          span {
            background: #ffffff;
            display: block;
            height: 2px;
            position: absolute;
            top: 16px;
            transition: all 0.15s 0s ease-out;
            width: 12px;
          }

          span.left {
            right: 14px;
            transform: rotate(45deg);
          }

          span.right {
            left: 14px;
            transform: rotate(-45deg);
          }
        }

        h2 {
          font-size: 24px;
          font-weight: 700;
          letter-spacing: -0.05em;
          margin: 0;
          padding: 0;

          small {
            display: block;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.025em;
          }
        }
      }

      div.card-description {
        padding: 0 15px 10px;
        position: relative;
        font-size: 14px;
      }

      div.card-actions {
        box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.075);
        padding: 10px 15px 20px;
        text-align: center;
      }

      div.card-flap {
        background: darken(#ffffff, 15);
        position: absolute;
        width: 100%;
        transform-origin: top;
        transform: rotateX(-90deg);
      }

      div.flap1 {
        transition: all 0.3s 0.3s ease-out;
        z-index: -1;
      }

      div.flap2 {
        transition: all 0.3s 0s ease-out;
        z-index: -2;
      }

    }

    div.cards.showing {
      div.card {
        cursor: pointer;
        opacity: 0.6;
        transform: scale(0.88);
      }
    }

    .no-touch div.cards.showing {
      div.card:hover {
        opacity: 0.94;
        transform: scale(0.92);
      }
    }

    div.card.show {
      opacity: 1 !important;
      transform: scale(1) !important;

      div.card-title {
        a.toggle-info {
          background: #ff6666 !important;

          span {
            top: 15px;
          }

          span.left {
            right: 10px;
          }

          span.right {
            left: 10px;
          }
        }
      }

      div.card-flap {
        background: #ffffff;
        transform: rotateX(0deg);
      }

      div.flap1 {
        transition: all 0.3s 0s ease-out;
      }

      div.flap2 {
        transition: all 0.3s 0.2s ease-out;
      }
    }

    #section_1 {
      height: 100vh;
    }
  </style>
  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>


    <section class="hero-section" id="section_1">
      <div class="section-overlay"></div>

      <div class="container d-flex justify-content-center align-items-center">
        <div class="row">

          <div class="col-12 mt-auto mb-5 text-center">
            <small><?php echo $rowinfogereja->subjudulhomepage ?></small>

            <h1 class="text-white mb-5"><?php echo $rowinfogereja->judulhomepage ?></h1>
            <?php
            if (!empty($rowinfogereja->urlbuttonhomepage)) {
              echo '
                                    <a class="btn custom-btn smoothscroll" href="' . $rowinfogereja->urlbuttonhomepage . '" target="_blank">Watch</a>
                                ';
            } else {
            }
            ?>
          </div>

          <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
            <div class="date-wrap">
              <!-- <h5 class="text-white">
                                <i class="custom-icon bi-clock me-2"></i>
                                10 - 12<sup>th</sup>, Dec 2023
                            </h5> -->
            </div>

            <div class="location-wrap mx-auto py-3 py-lg-0">
              <!-- <h5 class="text-white">
                                <i class="custom-icon bi-geo-alt me-2"></i>
                                National Center, United States
                            </h5> -->
            </div>

            <div class="social-share">
              <!-- <ul class="social-icon d-flex align-items-center justify-content-center">
                                <span class="text-white me-3">Share:</span>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-facebook"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-twitter"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-instagram"></span>
                                    </a>
                                </li>
                            </ul> -->
            </div>
          </div>
        </div>
      </div>

      <div class="video-wrap">
        <video autoplay="" loop="" muted="" class="custom-video" poster="">
          <!-- <source src="<?php echo base_url('myesc.id/assets/FestavaLive/') ?>video/vdo01.mp4" type="video/mp4"> -->
          <source src="<?php echo base_url('myesc.id/admin/uploads/infogereja/') . $rowinfogereja->gambarhomepage ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </section>



    <?php $this->load->view('template/festavalive/footer'); ?>



</body>

</html>