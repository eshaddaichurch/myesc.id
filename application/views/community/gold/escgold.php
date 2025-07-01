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

    body, html {
        font-family: 'Figtree', sans-serif;
        background-color: #946e52;
    }

    h1, h2, h3, h4, h5, h6, p, a, span, div, li, strong, em {
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
        flex: 1 1 160px;
      }
    }


    .section-text h1 {
      font-size: 7rem;
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

    @media (max-width: 768px) {
      .section-image {
        /* flex: 1 1 400px; */
        background: #eee;
        height: 221px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
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
    background-color: #929292;
    padding: 60px 280px;
    color: white;
    flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .early-years {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #929292;
      padding: 60px 5px;
      color: white;
      flex-wrap: wrap;
      }

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
        font-size: 45px;
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
    max-width: 90%;
    border-radius: 8px;
    object-fit: cover;
    }

    @media (max-width: 768px) {
        .early-years .image img {
        max-width: 173%;
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
    background-color: #000000;
    padding: 30px 75px;
    color: white;
    flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .kindy-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #000000;
    padding: 30px 5px;
    color: white;
    flex-wrap: wrap;
    }

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
    max-width: 163%;
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
        margin-left: 20px;
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

    .kindy-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* bisa disesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .kindy-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .kindy-image-slider img.active {
      opacity: 1;
    }




    .outing-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #000000;
    padding: 30px 75px;
    color: white;
    flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .outing-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #000000;
    padding: 30px 5px;
    color: white;
    flex-wrap: wrap;
    }

    }

    .outing-image {
    flex: 1 1 40%;
    display: flex;
    justify-content: center;
    }

    .outing-image img {
    max-width: 80%;
    border-radius: 8px;
    object-fit: cover;
    }

    @media (max-width: 768px) {
        .outing-image img {
    max-width: 163%;
    border-radius: 10px;
    object-fit: cover;
    }

    }

    .outing-text {
    flex: 1 1 50%;
    max-width: 600px;
    }

    .outing-label {
    font-size: 25px;
    opacity: 0.9;
    }

    @media (max-width: 768px) {
        .outing-label {
        font-size: 23px;
        opacity: 0.9;
        }
    }

    .outing-title {
    font-size: 64px;
    margin: 10px 0;
    }

    @media (max-width: 768px) {
        .outing-title {
        font-size: 39px;
        margin: 10px 0;
        margin-left: 20px;
        }
    }

    .outing-quote {
    font-size: 18px;
    font-style: italic;
    margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .outing-quote {
        font-size: 15px;
        margin-bottom: 20px;
        }
    }

    .outing-description {
    font-size: 18px;
    line-height: 1.6;
    }

     /* Tambahkan ke file CSS kamu */
     /* .outing-section {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-in-out;
    }

    .outing-section.show {
    opacity: 1;
    transform: translateY(0);
    } */

    .outing-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* bisa disesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .outing-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .outing-image-slider img.active {
      opacity: 1;
    }

    /*--------*/

    .shining-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
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

    .shining-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* sesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .shining-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .shining-image-slider img.active {
      opacity: 1;
    }

    @media (max-width: 768px) {
      .shining-years .image img {
      max-width: 177%;
      border-radius: 10px;
      object-fit: cover;
      }
    }


    .shining-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
    padding: 60px 280px;
    color: white;
    flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .shining-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
    padding: 30px 5px;
    color: white;
    flex-wrap: wrap;
    }
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

    .shining-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* sesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .shining-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .shining-image-slider img.active {
      opacity: 1;
    }

    @media (max-width: 768px) {
        .shining-years .image img {
    max-width: 177%;
    border-radius: 10px;
    object-fit: cover;
    }
    }






    /*-------*/

    .sharing-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
    padding: 30px 80px;
    color: white;
    flex-wrap: wrap;
    }

    .sharing-years .content {
    max-width: 600px;
    flex: 1 1 50%;
    }

    .sharing-years .content .category {
    font-size: 16px;
    opacity: 0.9;
    }

    @media (max-width: 768px) {
        .sharing-years .content .category {
        font-size: 23px;
        opacity: 0.9;
        }
    }

    .sharing-years .content h1 {
    font-size: 64px;
    margin: 10px 0;
    }

    @media (max-width: 768px) {
        .sharing-years .content h1 {
        font-size: 39px;
        margin: 10px 0;
        }
    }

    .sharing-years .content .quote {
    font-size: 18px;
    font-style: italic;
    margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .sharing-years .content .quote {
        font-size: 15px;
        margin-bottom: 10px;
        }
    }

    .sharing-years .content .description {
    font-size: 18px;
    line-height: 1.6;
    }

    .sharing-years .image {
    flex: 1 1 40%;
    display: flex;
    justify-content: center;
    }

    .sharing-years .image img {
    max-width: 80%;
    border-radius: 8px;
    object-fit: cover;
    }

     /* Tambahkan ke file CSS kamu */
     /* .sharing-years {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-in-out;
    }

    .sharing-years.show {
    opacity: 1;
    transform: translateY(0);
    } */

    .sharing-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* sesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .sharing-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .sharing-image-slider img.active {
      opacity: 1;
    }

    @media (max-width: 768px) {
        .sharing-years .image img {
    max-width: 177%;
    border-radius: 10px;
    object-fit: cover;
    }
    }


    .sharing-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
    padding: 60px 280px;
    color: white;
    flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .sharing-years {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #929292;
    padding: 30px 5px;
    color: white;
    flex-wrap: wrap;
    }
    }

    .sharing-years .content {
    max-width: 600px;
    flex: 1 1 50%;
    }

    .sharing-years .content .category {
    font-size: 16px;
    opacity: 0.9;
    }

    @media (max-width: 768px) {
        .sharing-years .content .category {
        font-size: 23px;
        opacity: 0.9;
        }
    }

    .sharing-years .content h1 {
    font-size: 64px;
    margin: 10px 0;
    }

    @media (max-width: 768px) {
        .sharing-years .content h1 {
        font-size: 39px;
        margin: 10px 0;
        }
    }

    .sharing-years .content .quote {
    font-size: 18px;
    font-style: italic;
    margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .sharing-years .content .quote {
        font-size: 15px;
        margin-bottom: 10px;
        }
    }

    .sharing-years .content .description {
    font-size: 18px;
    line-height: 1.6;
    }

    .sharing-years .image {
    flex: 1 1 40%;
    display: flex;
    justify-content: center;
    }

    .sharing-years .image img {
    max-width: 80%;
    border-radius: 8px;
    object-fit: cover;
    }

     /* Tambahkan ke file CSS kamu */
     /* .sharing-years {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-in-out;
    }

    .sharing-years.show {
    opacity: 1;
    transform: translateY(0);
    } */

    .sharing-image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* sesuaikan */
      height: 300px;
      overflow: hidden;
    }

    .sharing-image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .sharing-image-slider img.active {
      opacity: 1;
    }

    @media (max-width: 768px) {
        .sharing-years .image img {
    max-width: 177%;
    border-radius: 10px;
    object-fit: cover;
    }
    }



    .young-esc {
    padding: 60px 40px;
    background-color: #946e52;
    font-family: 'Arial', sans-serif;
    color: #111;
    }

    .young-esc .info {
    display: flex;
    flex-wrap: wrap;
    gap: 60px;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    }

    .meeting-times {
    flex: 1;
    min-width: 280px;
    max-width: 400px;
    }

    .about {
    flex: 2;
    min-width: 300px;
    }

    .meeting-times h2 {
    font-size: 20px;
    margin-bottom: 10px;
    }

    .meeting-block {
    margin-bottom: 25px;
    }

    .meeting-times p {
    margin: 4px 0;
    }

    .about h1 {
    font-size: 60px;
    margin-bottom: 25px;
    }

    .about p {
    font-size: 18px;
    line-height: 1.6;
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
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
    }


    .image-slider {
      position: relative;
      width: 100%;
      max-width: 500px; /* sesuaikan dengan kebutuhan */
      height: 300px;
      overflow: hidden;
    }

    .image-slider img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .image-slider img.active {
      opacity: 1;
    }
    </style>
    </head>

    <body>


    <section class="section-container" id="small-groups" data-aos="fade-up">
    <div class="section-text">
      <h1 style="color: #ffffff;">ESC GOLD</h1>
      <p style="color: #ffffff;">
        <!-- Semua anakmu akan menjadi murid TUHAN, dan besarlah kesejahteraan mereka. -->
      </p>
      <p style="color: #ffffff;">
        
      </p>
      <!-- <a href="#" class="btn" style="background-color: #000000;">
        Daftar ESC Kids →
      </a> -->
    </div>
    <div class="section-image">
      <img src="<?php echo base_url('myesc.id/assets/gambar/gold2.JPG'); ?>" alt="Small Groups">
    </div>
  </section>

  <!-- Section: Child Dedication -->
    <div class="section light dedication">
        <div class="dedication-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <div class="dedication-text">
        <br>
        <p style="color: #ffffff; text-align: center;">
            "Orang benar akan bertunas seperti pohon korma, akan tumbuh subur seperti pohon aras di Libanon. Ditaburkan di rumah TUHAN, mereka akan bertumbuh subur di pelataran Allah kita. Bahkan pada masa tua mereka masih berbuah, mereka gemuk dan segar." - Mazmur 92:12-14
        </p>
        </div>
    </div>

    <section class="young-esc">
        <div class="info">
          
            <div class="about">
                <h1>ESC GOLD</h1>
                <p>
                  ESC Gold adalah komunitas yang menghormati dan merayakan kehidupan orang tua dari usia 55 tahun sampai lansia sebagai teladan hikmat, iman dan pilar rohani dalam tubuh Kristus. Kami percaya bahwa masa tua bukanlah masa akhir tetapi musim yang penuh tujuan untuk terus bertumbuh, dan menyelesaikan panggilan Tuhan dengan setia bahkan turut serta dalam memperkuat generasi dibawahnya. Bersama EL Shaddai Church, kami membangun komunitas Gold yang aktif, berpengaruh, dan tetap menyala dalam iman hingga garis akhir. 
                </p>
              </div>
          
        </div>
    </section>


    <section class="early-years">
      <div class="content">
        <h1>Bermain Angklung</h1>
        <p style="color: #000000; text-align: justify;">
          ESC Gold juga rutin berpartisipasi dalam penampilan bermain angklung saat ibadah raya dan kunjungan sosial. Latihan dimulai dua bulan sebelum tampil, dengan jadwal 2–3 kali tampil di ibadah raya dan 1–2 kali kunjungan per tahun ke panti jompo. Kegiatan ini membantu anggota tetap aktif, melatih daya ingat, dan meningkatkan konsentrasi melalui pembelajaran musik dan interaksi sosial. 
        </p>
      </div>
    
      <div class="image-slider">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gold1.JPG'); ?>" alt="Foto 1">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gda1.jpg'); ?>" alt="Foto 2">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gda2.jpg'); ?>" alt="Foto 3">
      </div>
    </section>
    
    

    <section class="kindy-section">
      <div class="kindy-text">
        <br>
        <h1 class="kindy-title">Ibadah</h1>
        <p>
          Ibadah Gold rutin diadakan sekali dalam dua bulan, pada hari rabu di minggu terakhir pukul 18.30 WIB di ruang Serbaguna Lantai 1 ESC. Firman Tuhan disampaikan dengan tema yang disesuaikan dengan kebutuhan dan tahap kehidupan orang tua hingga lansia, agar lebih relevan dan mudah dipahami.
        </p>
      </div>
      <div class="kindy-image-slider">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gbi1.jpg'); ?>" alt="Foto 1">    
        <img src="<?php echo base_url('myesc.id/assets/gambar/gbi2.jpg'); ?>" alt="Foto 2">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gold4.JPG'); ?>" alt="Foto 3">
      </div>
    </section>
    


    <section class="shining-years">
      <div class="content">
        <h1>Morning Sport</h1>
        <p style="color: #000000; text-align: justify;">
          Untuk mendukung kesehatan usia emas sampai lansia, ESC Gold mengadakan kegiatan Morning Sport yaitu senam atau olahraga pagi dan edukasi kesehatan praktis yang rutin dilaksanakan setiap bulan di minggu kedua pada hari Sabtu pukul 07.00 pagi.  
        </p>
      </div>
    
      <div class="shining-image-slider">
        <!-- <img src="myesc.id/assets/gambar/gold1.JPG" alt="Foto 1">
        <img src="myesc.id/assets/gambar/gold2.JPG" alt="Foto 2"> -->
        <img src="<?php echo base_url('myesc.id/assets/gambar/gold3.JPG'); ?>" alt="Foto 3">
      </div>
    </section>
    


    <section class="outing-section">
      <div class="kindy-text">
        <br>
        <h1 class="kindy-title">Outing</h1>
        <p style="text-align: justify;">
          Outing ESC Gold adalah kegiatan sekali dalam dua bulanan yang dilakukan di luar gereja seperti rekreasi, kunjungan ke panti jompo, dan retreat. Rekreasi memberi kesempatan jemaat menikmati waktu bersama lewat aktivitas seru seperti bermain games, menari, bernyanyi, dan berfoto. Kunjungan ke panti jompo memberi ruang yang menciptakan  momen berbagi dan saling menguatkan antar sesama usia emas sampai lansia. Retreat menghadirkan suasana baru untuk beristirahat, berinteraksi, dan mendapatkan inspirasi dalam suasana yang lebih akrab dan menyegarkan.
        </p>
      </div>
      <div class="outing-image-slider">
        <img src="<?php echo base_url('myesc.id/assets/gambar/outing.JPG'); ?>" alt="Outing 1">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gdo1.jpg'); ?>" alt="Outing 2">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gdo2.jpg'); ?>" alt="Outing 3">
      </div>
    </section>
    


    <section class="sharing-years">
      <div class="content">
        <h1>Sharing</h1>
        <p style="color: #000000; text-align: justify;">
          Seiring bertambahnya usia, kebutuhan untuk bercerita meningkat mulai dari kenangan masa lalu hingga kisah keluarga. Kegiatan sharing di ESC Gold menjadi wadah berbagi pengalaman, doa, kesaksian, dan firman Tuhan secara dua arah lewat percakapan atau kesaksian. Sharing ini biasanya dilakukan saat outing atau setelah Ibadah Gold, bersama teman sebaya yang memiliki pengalaman hidup serupa, sehingga tercipta rasa saling memahami saat berbagi cerita. 
        </p>

      </div>
    
      <div class="sharing-image-slider">
        <img src="<?php echo base_url('myesc.id/assets/gambar/sharing.JPG'); ?>" alt="Sharing 1">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gds1.jpg'); ?>" alt="Sharing 2">
        <img src="<?php echo base_url('myesc.id/assets/gambar/gds2.jpg'); ?>" alt="Sharing 3">
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


    function startSlider(selector) {
      let currentIndex = 0;
      const images = document.querySelectorAll(`${selector} img`);

      function showNextImage() {
        images[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % images.length;
        images[currentIndex].classList.add('active');
      }

      images[currentIndex].classList.add('active');
      setInterval(showNextImage, 2000);
    }

    // Jalankan untuk masing-masing slider
    startSlider('.image-slider');           // section Bermain Angklung
    startSlider('.kindy-image-slider');     // section Ibadah
    startSlider('.shining-image-slider');   // section Morning Sport
    startSlider('.outing-image-slider');    // Outing
    startSlider('.sharing-image-slider')
  </script>


      <?php $this->load->view('template/festavalive/footer'); ?>