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
    body {
      margin: 0;
      font-family: 'Figtree', sans-serif;
    }

    /* Parallax Background */
    .video-section-parallax {
      display: flex;
      flex-direction: column;
      justify-content: center; /* default tengah */
      align-items: center;
      min-height: 100vh;
      background-color: #c7c3a9;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      padding: 20px;
      color: #fff;
      position: relative;
      z-index: 1;
    }


    @media (max-width: 768px) {
        .video-section-parallax {
        display: flex;
        flex-direction: column;
        justify-content: center; /* default tengah */
        align-items: center;
        min-height: 80vh;
        background-color: #c7c3a9;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 20px;
        color: #fff;
        position: relative;
        z-index: 1;
        }
    }



    /* Overlay transparan */
    .video-section-parallax .overlay {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 40px 20px;
    border-radius: 12px;
    max-width: 900px;
    width: 100%;
    text-align: center;
    }

    


    /* Judul */
    .video-section-parallax h2 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 30px;
    }

    /* Container Video */
    .video-container {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    .video-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    /* Disable parallax on mobile */
    @media (max-width: 768px) {
      .video-section-parallax {
        background-attachment: scroll;
      }
    }





    .follow-section {
    padding: 80px 20px;
    text-align: center;
    background-color: #eeeeee;
    font-family: 'Figtree', sans-serif;
    }

    .follow-section h2 {
        font-size: 36px;
        font-weight: 700px;
        margin-bottom: 30px;
        color: #333;
    }


    @media (max-width: 768px) {
        .follow-section h2 {
        font-size: 24px;
        font-weight: 700px;
        margin-bottom: 30px;
        color: #333;
    }
    }



    .follow-section .content {
        max-width: 800px;
        margin: auto;
        font-size: 18px;
        color: #444;
        line-height: 1.8;
    }

    .follow-section em {
        font-style: italic;
        color: #555;
    }

    .follow-section strong {
        font-weight: 600;
        color: #111;
    }

    .follow-section .congrats {
        margin-top: 30px;
        font-style: italic;
        color: #666;
    }

    .follow-section .btn-learn {
        margin-top: 30px;
        display: inline-block;
        background: #4CAF50;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .follow-section .btn-learn:hover {
        background: #388e3c;
    }

    .follow-section {
    padding: 155px;
    }

    @media (max-width: 768px) {
        .follow-section {
        padding: 13px;
        }
    }

    .btn-modern {
    padding: 30px 80px;
    background-color: #000000; /* biru indigo */
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    }

    @media (max-width: 768px) {
        .btn-modern {
        padding: 22px 24px;

        background-color: #000000; /* biru indigo */
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        }
    }

    /* Efek hover: membesar dan ubah warna */
    .btn-modern:hover {
        background-color: #000000;
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Efek click: sedikit mengecil */
    .btn-modern:active {
        transform: scale(0.98);
    }



  </style>
</head>
<body>

 
<!-- Tambahkan class align-top / align-middle / align-bottom sesuai kebutuhan -->
  <section class="video-section-parallax align-bottom">
    <div class="overlay">
      <h2>Doa Keselamatan</h2>
      <div class="video-container">
        <iframe
          src="https://www.youtube.com/embed/ZqULgqLXYz8?autoplay=1&mute="
          title="Video Tentang Yesus"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </section>

  <section class="follow-section">
        <div class="content">
            <h2>Selamat Anda Sudah Bergabung Dalam keluarga Allah.</h2>
            <button class="btn-modern">Langkah Berikutnya -> </button>
        </div>
        </div>
    
  </section>
    
        

<?php $this->load->view('template/festavalive/footer'); ?>