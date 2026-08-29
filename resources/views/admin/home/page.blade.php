<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        University Subject Portal
    </title>


    {{-- =========================================================
        BOOTSTRAP 5
    ========================================================= --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    {{-- =========================================================
        BOOTSTRAP ICONS
    ========================================================= --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">


    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            margin: 0;

            font-family:
                "Inter",
                "Segoe UI",
                Arial,
                sans-serif;

            color: #13264a;

            background: #ffffff;
        }

        a {
            text-decoration: none;
        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .main-navbar {

            min-height: 88px;

            background: #ffffff;

            border-bottom:
                1px solid #edf1f6;

            z-index: 1000;

            transition:
                box-shadow .25s ease,
                background .25s ease;
        }


        .main-navbar.scrolled {

            box-shadow:
                0 6px 25px rgba(20, 50, 90, .08);
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .navbar-brand {

            display: flex;

            align-items: center;

            gap: 12px;

            color: #12264a;

            text-decoration: none;
        }


        .navbar-brand:hover {

            color: #12264a;
        }


        .university-logo {

            width: 52px;
            height: 52px;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 50%;

            background: #0759c9;

            color: #ffffff;

            font-size: 24px;

            box-shadow:
                0 6px 18px rgba(7, 89, 201, .15);
        }


        .brand-title {

            font-size: 20px;

            font-weight: 800;

            line-height: 1.1;
        }


        .brand-subtitle {

            margin-top: 4px;

            color: #71809b;

            font-size: 11px;
        }


        /* =========================================================
           NAVIGATION
        ========================================================= */

        .navbar-nav {

            align-items: center;
        }


        .navbar-nav .nav-item {

            display: flex;

            align-items: center;
        }


        .navbar-nav .nav-link {

            position: relative;

            display: inline-flex;

            align-items: center;

            margin: 0 10px;

            padding: 32px 4px;

            color: #253452 !important;

            font-size: 15px;

            font-weight: 600;

            transition:
                color .25s ease;
        }


        /* =========================================================
           NAVBAR HOVER + ACTIVE LINE
        ========================================================= */

        .navbar-nav .nav-link::after {

            content: "";

            position: absolute;

            left: 0;
            right: 0;

            bottom: 19px;

            height: 2px;

            background: #1261d6;

            border-radius: 10px;

            transform:
                scaleX(0);

            transform-origin:
                center;

            transition:
                transform .25s ease;
        }


        /* HOVER */

        .navbar-nav .nav-link:hover {

            color: #1261d6 !important;
        }


        .navbar-nav .nav-link:hover::after {

            transform:
                scaleX(1);
        }


        /* ACTIVE */

        .navbar-nav .nav-link.active {

            color: #1261d6 !important;
        }


        .navbar-nav .nav-link.active::after {

            transform:
                scaleX(1);
        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .login-nav-item {

            margin-left: 8px;
        }


        .login-button {

            position: relative;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 0;

            padding: 11px 21px !important;

            margin: 0 !important;

            background: #1261d6;

            color: #ffffff !important;

            border:
                1px solid #1261d6;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 700;

            line-height: 1.4;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }


        .login-button::after {

            display: none !important;
        }


        .login-button:hover {

            background: #084da9;

            border-color: #084da9;

            color: #ffffff !important;

            transform:
                translateY(-1px);

            box-shadow:
                0 5px 14px
                rgba(18, 97, 214, .20);
        }


        .login-button:focus {

            color: #ffffff !important;

            box-shadow:
                0 0 0 3px
                rgba(18, 97, 214, .15);
        }


        /* =========================================================
           NAVBAR TOGGLER
        ========================================================= */

        .navbar-toggler {

            border:
                1px solid #dce4ef;

            border-radius: 8px;

            padding: 7px 10px;
        }


        .navbar-toggler:focus {

            box-shadow:
                0 0 0 3px
                rgba(18, 97, 214, .10);
        }


        /* =========================================================
           HERO
        ========================================================= */

        .hero {

            position: relative;

            min-height: 440px;

            background-image:

                linear-gradient(
                    90deg,
                    rgba(4, 45, 105, .98) 0%,
                    rgba(5, 54, 120, .93) 38%,
                    rgba(5, 54, 120, .58) 62%,
                    rgba(5, 54, 120, .08) 100%
                ),

                url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZl1R89YkJaGb0vVmC_4uSe3TRlScybabvOvvOrldOuoxHQ_4KEB8Ia9Q&s=10");

            background-size: cover;

            background-position: center;

            overflow: hidden;
        }


        .hero-content {

            padding-top: 75px;

            padding-bottom: 70px;

            color: #ffffff;
        }


        .hero-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 9px 17px;

            background:
                rgba(255, 255, 255, .14);

            border:
                1px solid
                rgba(255, 255, 255, .18);

            border-radius: 30px;

            color: #ffffff;

            font-size: 13px;

            font-weight: 600;
        }


        .hero-title {

            max-width: 650px;

            margin-top: 20px;

            color: #ffffff;

            font-size: 53px;

            line-height: 1.08;

            font-weight: 800;
        }


        .hero-title span {

            color: #74b7ff;
        }


        .hero-description {

            max-width: 600px;

            margin-top: 18px;

            color: #e5efff;

            font-size: 17px;

            line-height: 1.7;
        }


        .hero-button {

            display: inline-flex;

            align-items: center;

            margin-top: 20px;

            padding: 13px 23px;

            background: #ffffff;

            color: #1261d6;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 700;

            transition: .2s ease;
        }


        .hero-button:hover {

            background: #eef5ff;

            color: #084da9;

            transform:
                translateY(-1px);
        }


        /* =========================================================
           COMMON SECTION
        ========================================================= */

        .subject-section,
        .location-section {

            padding: 75px 0 85px;

            background: #ffffff;
        }


        .about-section {

            padding: 75px 0;

            background: #f7f9fc;
        }


        .section-label {

            color: #1261d6;

            font-size: 12px;

            font-weight: 800;

            letter-spacing: .7px;

            text-transform: uppercase;
        }


        .section-title {

            margin-top: 9px;

            margin-bottom: 8px;

            color: #142950;

            font-size: 31px;

            line-height: 1.25;

            font-weight: 800;
        }


        .section-description {

            max-width: 650px;

            color: #6b7890;

            font-size: 14px;

            line-height: 1.7;
        }


        .blue-line {

            width: 45px;

            height: 3px;

            margin-top: 15px;

            margin-bottom: 30px;

            background: #1261d6;

            border-radius: 3px;
        }


        /* =========================================================
           YEAR NAVIGATION
        ========================================================= */

        .subject-year-nav {

            display: flex;

            justify-content: center;

            align-items: center;

            flex-wrap: wrap;

            gap: 7px;

            padding: 7px;

            margin-bottom: 25px;

            background: #f7f9fc;

            border:
                1px solid #e6ebf2;

            border-radius: 11px;
        }


        .year-filter {

            border: none;

            outline: none;

            padding: 10px 20px;

            background: transparent;

            color: #5d6b83;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }


        .year-filter:hover {

            background: #eef5ff;

            color: #1261d6;
        }


        .year-filter.active {

            background: #1261d6;

            color: #ffffff;

            box-shadow:
                0 4px 12px
                rgba(18, 97, 214, .18);
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .subject-filter {

            padding: 18px;

            margin-bottom: 30px;

            background: #ffffff;

            border:
                1px solid #e6ebf2;

            border-radius: 11px;

            box-shadow:
                0 4px 18px
                rgba(20, 50, 90, .035);
        }


        .subject-filter .form-label {

            margin-bottom: 8px;

            color: #263654;

            font-size: 12px;

            font-weight: 700;
        }


        .search-input-wrapper {

            position: relative;

            width: 100%;
        }


        .search-input {

            width: 100%;

            height: 48px !important;

            padding-left: 45px !important;

            padding-right: 48px !important;

            color: #263654;

            font-size: 14px !important;

            border:
                1px solid #dfe5ee;

            border-radius: 9px !important;

            transition: .2s ease;
        }


        .search-input::placeholder {

            color: #9aa6b8;
        }


        .search-input:focus {

            border-color: #1261d6;

            box-shadow:
                0 0 0 3px
                rgba(18, 97, 214, .08);
        }


        .search-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            z-index: 2;

            transform:
                translateY(-50%);

            color: #7b879b;

            font-size: 17px;

            pointer-events: none;
        }


        .clear-search {

            position: absolute;

            right: 9px;

            top: 50%;

            width: 31px;

            height: 31px;

            display: none;

            align-items: center;

            justify-content: center;

            transform:
                translateY(-50%);

            border: none;

            border-radius: 50%;

            background: #eef2f7;

            color: #68758a;

            cursor: pointer;

            transition: .2s ease;
        }


        .clear-search:hover {

            background: #e1e8f2;

            color: #1261d6;
        }


        /* =========================================================
           SUBJECT CARD
        ========================================================= */

        .subject-card {

            height: 100%;

            overflow: hidden;

            background: #ffffff;

            border:
                1px solid #e5ebf3;

            border-radius: 12px;

            box-shadow:
                0 4px 16px
                rgba(20, 50, 90, .04);

            transition: .25s ease;
        }


        .subject-card:hover {

            transform:
                translateY(-5px);

            border-color: #cfe0f8;

            box-shadow:
                0 16px 35px
                rgba(20, 70, 130, .12);
        }


        .subject-image-wrapper {

            position: relative;

            width: 100%;

            height: 190px;

            overflow: hidden;

            background: #eef5ff;
        }


        .subject-image {

            display: block;

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition:
                transform .35s ease;
        }


        .subject-card:hover
        .subject-image {

            transform:
                scale(1.06);
        }


        .subject-image-overlay {

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: 75px;

            background:
                linear-gradient(
                    transparent,
                    rgba(0, 0, 0, .35)
                );
        }


        .subject-content {

            padding: 20px;
        }


        .subject-code {

            display: inline-block;

            padding: 4px 9px;

            margin-bottom: 10px;

            background: #eef5ff;

            color: #1261d6;

            border-radius: 5px;

            font-size: 10px;

            font-weight: 700;
        }


        .subject-name {

            margin-bottom: 11px;

            color: #172a4d;

            font-size: 16px;

            line-height: 1.4;

            font-weight: 800;
        }


        .subject-info {

            color: #758198;

            font-size: 12px;

            line-height: 1.9;
        }


        .subject-info div {

            overflow: hidden;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .subject-info i {

            width: 18px;

            color: #1261d6;
        }


        .subject-button {

            display: inline-flex;

            align-items: center;

            margin-top: 14px;

            color: #1261d6;

            font-size: 12px;

            font-weight: 700;

            transition: .2s ease;
        }


        .subject-button:hover {

            color: #084da9;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .empty-subject {

            padding: 70px 20px;

            text-align: center;

            background: #f8fafc;

            border:
                1px dashed #d8e0eb;

            border-radius: 12px;
        }


        .empty-subject i {

            color: #b7c3d6;

            font-size: 45px;
        }


        .empty-subject h5 {

            margin-top: 15px;

            color: #4b5b75;

            font-weight: 700;
        }


        .empty-subject p {

            color: #8793a6;

            font-size: 13px;
        }


        /* =========================================================
           ABOUT
        ========================================================= */

        .about-card {

            height: 100%;

            padding: 32px;

            background: #ffffff;

            border:
                1px solid #e7ecf3;

            border-radius: 12px;

            transition: .25s ease;
        }


        .about-card:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 12px 30px
                rgba(20, 50, 90, .07);
        }


        .about-icon {

            width: 50px;

            height: 50px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 20px;

            background: #eef5ff;

            color: #1261d6;

            border-radius: 50%;

            font-size: 21px;
        }


        .about-card h4 {

            margin-bottom: 12px;

            color: #142950;

            font-size: 19px;

            font-weight: 800;
        }


        .about-card p {

            margin: 0;

            color: #6c7890;

            font-size: 13px;

            line-height: 1.8;
        }


        /* =========================================================
           LOCATION
        ========================================================= */

        .location-map-card {

            height: 100%;

            overflow: hidden;

            background: #ffffff;

            border:
                1px solid #e5ebf3;

            border-radius: 14px;

            box-shadow:
                0 8px 25px
                rgba(20, 50, 90, .06);
        }


        .location-map {

            display: block;

            width: 100%;

            height: 430px;

            border: 0;
        }


        .location-info {

            padding: 32px;
        }


        .location-info-title {

            margin-bottom: 15px;

            color: #142950;

            font-size: 22px;

            line-height: 1.4;

            font-weight: 800;
        }


        .location-info-description {

            margin-bottom: 20px;

            color: #6c7890;

            font-size: 14px;

            line-height: 1.8;
        }


        .location-info-item {

            display: flex;

            align-items: flex-start;

            gap: 12px;

            margin-top: 18px;
        }


        .location-info-icon {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex: 0 0 40px;

            background: #eef5ff;

            color: #1261d6;

            border-radius: 9px;
        }


        .location-info-item strong {

            display: block;

            margin-bottom: 3px;

            color: #263654;

            font-size: 13px;
        }


        .location-info-item span {

            color: #758198;

            font-size: 13px;

            line-height: 1.6;
        }


        .location-button {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 25px;

            padding: 12px 18px;

            background: #1261d6;

            color: #ffffff;

            border-radius: 8px;

            font-size: 13px;

            font-weight: 700;

            transition: .2s ease;
        }


        .location-button:hover {

            background: #084da9;

            color: #ffffff;
        }


        /* =========================================================
           STATISTICS
        ========================================================= */

        .statistics-section {

            padding: 28px 0;

            background: #0649a8;

            color: #ffffff;
        }


        .stat-item {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 12px;

            min-height: 55px;

            border-right:
                1px solid
                rgba(255, 255, 255, .25);
        }


        .stat-item:last-child {

            border-right: none;
        }


        .stat-icon {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            background:
                rgba(255, 255, 255, .12);

            border-radius: 50%;

            font-size: 18px;
        }


        .stat-number {

            font-size: 20px;

            line-height: 1;

            font-weight: 800;
        }


        .stat-label {

            margin-top: 4px;

            color: #d5e4ff;

            font-size: 10px;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        footer {

            padding: 55px 0 20px;

            background: #0c2146;

            color: #9dafc9;
        }


        .footer-title {

            color: #ffffff;

            font-size: 17px;

            font-weight: 800;
        }


        footer p {

            font-size: 13px;

            line-height: 1.7;
        }


        footer a {

            display: block;

            margin-top: 9px;

            color: #aabbd4;

            font-size: 13px;

            text-decoration: none;

            transition: .2s ease;
        }


        footer a:hover {

            color: #ffffff;
        }


        footer p a {

            display: inline;

            margin-top: 0;

            color: #aabbd4;
        }


        footer p a:hover {

            color: #ffffff;
        }


        .footer-bottom {

            margin-top: 40px;

            padding-top: 18px;

            border-top:
                1px solid
                rgba(255, 255, 255, .1);

            text-align: center;

            font-size: 12px;
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 991px) {

            .main-navbar {

                min-height: auto;

                padding: 12px 0;
            }


            .navbar-nav {

                align-items: flex-start;

                padding-top: 10px;
            }


            .navbar-nav .nav-item {

                width: 100%;
            }


            .navbar-nav .nav-link {

                width: 100%;

                margin: 4px 0;

                padding: 10px 0;
            }


            .navbar-nav .nav-link::after {

                display: none;
            }


            .navbar-nav .nav-link.active {

                padding-left: 10px;

                background: #eef5ff;

                border-radius: 7px;
            }


            .login-nav-item {

                margin-left: 0;

                margin-top: 5px;
            }


            .login-button {

                display: inline-flex;

                margin: 4px 0 !important;
            }


            .hero-title {

                font-size: 43px;
            }


            .stat-item {

                margin: 6px 0;

                border-right: none;
            }


            .subject-year-nav {

                justify-content: flex-start;

                overflow-x: auto;

                flex-wrap: nowrap;

                scrollbar-width: none;
            }


            .subject-year-nav::-webkit-scrollbar {

                display: none;
            }


            .year-filter {

                flex: 0 0 auto;
            }


            .location-map {

                height: 350px;
            }
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 576px) {

            .brand-title {

                font-size: 18px;
            }


            .brand-subtitle {

                font-size: 10px;
            }


            .university-logo {

                width: 46px;

                height: 46px;

                font-size: 21px;
            }


            .hero {

                min-height: auto;
            }


            .hero-content {

                padding-top: 55px;

                padding-bottom: 55px;
            }


            .hero-title {

                font-size: 35px;
            }


            .hero-description {

                font-size: 15px;
            }


            .subject-section,
            .about-section,
            .location-section {

                padding: 55px 0;
            }


            .section-title {

                font-size: 26px;
            }


            .subject-image-wrapper {

                height: 190px;
            }


            .location-map {

                height: 300px;
            }


            .location-info {

                padding: 25px;
            }


            .subject-filter {

                padding: 14px;
            }


            .search-input {

                height: 46px !important;
            }


            .statistics-section {

                padding: 20px 0;
            }


            .stat-item {

                justify-content: flex-start;
            }


            .stat-number {

                font-size: 18px;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     NAVBAR
========================================================= --}}

<nav
    class="navbar navbar-expand-lg main-navbar sticky-top"
    id="mainNavbarWrapper">

    <div class="container">


        {{-- =====================================================
            BRAND
        ====================================================== --}}

        <a
            href="#home"
            class="navbar-brand">

            <div class="university-logo">

                <i class="bi bi-mortarboard-fill"></i>

            </div>


            <div>

                <div class="brand-title">

                    University

                </div>


                <div class="brand-subtitle">

                    Excellence in Education

                </div>

            </div>

        </a>


        {{-- =====================================================
            MOBILE TOGGLE
        ====================================================== --}}

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        {{-- =====================================================
            NAVIGATION
        ====================================================== --}}

        <div
            class="collapse navbar-collapse"
            id="mainNavbar">

            <ul class="navbar-nav ms-auto">


                {{-- HOME --}}

                <li class="nav-item">

                    <a
                        href="#home"
                        class="nav-link active"
                        data-section="home">

                        <i class="bi bi-house-door me-1"></i>

                        Home

                    </a>

                </li>


                {{-- SUBJECT --}}

                <li class="nav-item">

                    <a
                        href="#subjects"
                        class="nav-link"
                        data-section="subjects">

                        <i class="bi bi-book me-1"></i>

                        Subject

                    </a>

                </li>


                {{-- ABOUT --}}

                <li class="nav-item">

                    <a
                        href="#about"
                        class="nav-link"
                        data-section="about">

                        <i class="bi bi-info-circle me-1"></i>

                        About

                    </a>

                </li>


                {{-- LOCATION --}}

                <li class="nav-item">

                    <a
                        href="#location"
                        class="nav-link"
                        data-section="location">

                        <i class="bi bi-geo-alt me-1"></i>

                        Location

                    </a>

                </li>


                {{-- LOGIN --}}

                <li class="nav-item login-nav-item">

                    <a
                        href="{{ route('login') }}"
                        class="login-button">

                        <i
                            class="bi bi-box-arrow-in-right me-2">
                        </i>

                        Login

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>



{{-- =========================================================
     HERO
========================================================= --}}

<section
    class="hero"
    id="home">

    <div class="container">

        <div class="hero-content">


            <div class="hero-badge">

                <i class="bi bi-book"></i>

                University Subject Portal

            </div>


            <h1 class="hero-title">

                Discover Your

                <br>

                <span>Subjects.</span>

                Learn More.

            </h1>


            <p class="hero-description">

                Explore university subjects, courses
                and academic information in one simple
                and convenient portal.

            </p>


            <a
                href="#subjects"
                class="hero-button">

                Explore Subjects

                <i
                    class="bi bi-arrow-right ms-2">
                </i>

            </a>


        </div>

    </div>

</section>



{{-- =========================================================
     SUBJECT SECTION
========================================================= --}}

<section
    class="subject-section"
    id="subjects">

    <div class="container">


        <div class="text-center">

            <div class="section-label">
                Academic
            </div>


            <h2 class="section-title">

                University Subjects

            </h2>


            <p class="mx-auto section-description">

                Explore all university subjects by
                academic year. Select a year to view
                its subjects.

            </p>


            <div class="mx-auto blue-line"></div>

        </div>


        {{-- YEAR FILTER --}}

        <div class="subject-year-nav">

            <button
                type="button"
                class="year-filter active"
                data-year="all">

                ALL

            </button>


            @if(isset($years) && $years->count() > 0)

                @foreach($years as $year)

                    <button
                        type="button"
                        class="year-filter"
                        data-year="{{ $year->id }}">

                        {{ $year->name }}

                    </button>

                @endforeach

            @endif

        </div>


        {{-- SEARCH --}}

        <div class="subject-filter">

            <label
                class="form-label"
                for="subjectSearch">

                Search Subject

            </label>


            <div class="search-input-wrapper">

                <i
                    class="bi bi-search search-icon">
                </i>


                <input
                    type="text"
                    id="subjectSearch"
                    class="form-control search-input"
                    placeholder="Search subject name or code..."
                    autocomplete="off">


                <button
                    type="button"
                    class="clear-search"
                    id="clearSearch"
                    aria-label="Clear search">

                    <i class="bi bi-x"></i>

                </button>

            </div>

        </div>


        {{-- SUBJECT LIST --}}

        <div
            class="row g-4"
            id="subjectList">


            @if(isset($subjects) && $subjects->count() > 0)


                @foreach($subjects as $subject)

                    <div
                        class="col-xl-3 col-lg-4 col-md-6 subject-item"
                        data-year="{{ $subject->year_id }}"
                        data-subject-name="{{ strtolower($subject->name ?? '') }} {{ strtolower($subject->long_name ?? '') }}"
                        data-subject-code="{{ strtolower($subject->code ?? '') }}">


                        <div class="subject-card">


                            {{-- IMAGE --}}

                            <div class="subject-image-wrapper">

                                @if(!empty($subject->image))

                                    <img
                                        src="{{ asset($subject->image) }}"
                                        alt="{{ $subject->long_name ?? $subject->name }}"
                                        class="subject-image">

                                @else

                                    <img
                                        src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80"
                                        alt="{{ $subject->long_name ?? $subject->name }}"
                                        class="subject-image">

                                @endif


                                <div
                                    class="subject-image-overlay">
                                </div>

                            </div>


                            {{-- CONTENT --}}

                            <div class="subject-content">


                                @if(!empty($subject->code))

                                    <div class="subject-code">

                                        {{ $subject->code }}

                                    </div>

                                @endif


                                <div class="subject-name">

                                    {{ $subject->long_name ?? $subject->name }}

                                </div>


                                <div class="subject-info">


                                    @if($subject->year)

                                        <div>

                                            <i
                                                class="bi bi-mortarboard">
                                            </i>

                                            {{ $subject->year->name }}

                                        </div>

                                    @endif


                                    @if($subject->major)

                                        <div>

                                            <i
                                                class="bi bi-building">
                                            </i>

                                            {{ $subject->major->name }}

                                        </div>

                                    @endif


                                    @if($subject->semester)

                                        <div>

                                            <i
                                                class="bi bi-layers">
                                            </i>

                                            {{ $subject->semester->name }}

                                        </div>

                                    @endif

                                </div>


                                <a
                                    href="{{ route('subject.detail', $subject->id) }}"
                                    class="subject-button">

                                    View Subject

                                    <i
                                        class="bi bi-arrow-right ms-1">
                                    </i>

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach


            @else

                <div class="col-12">

                    <div class="empty-subject">

                        <i class="bi bi-book"></i>

                        <h5>
                            No Subjects Available
                        </h5>

                        <p>
                            Subjects will appear here
                            when they are added to the system.
                        </p>

                    </div>

                </div>

            @endif


        </div>


        {{-- NO RESULT --}}

        <div
            id="noSearchResult"
            class="mt-4 empty-subject"
            style="display:none;">

            <i class="bi bi-search"></i>

            <h5>
                No Subject Found
            </h5>

            <p>
                Try another year or subject name.
            </p>

        </div>

    </div>

</section>



{{-- =========================================================
     ABOUT
========================================================= --}}

<section
    class="about-section"
    id="about">

    <div class="container">


        <div class="mb-5 text-center">

            <div class="section-label">
                About Us
            </div>


            <h2 class="section-title">

                University Subject Portal

            </h2>


            <p class="mx-auto section-description">

                A simple platform designed to help
                students explore university subjects
                and academic information.

            </p>


            <div class="mx-auto blue-line"></div>

        </div>


        <div class="row g-4">


            <div class="col-lg-4">

                <div class="about-card">

                    <div class="about-icon">

                        <i class="bi bi-book"></i>

                    </div>


                    <h4>
                        Subjects
                    </h4>


                    <p>

                        Students can browse university
                        subjects and view important
                        information about each subject.

                    </p>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="about-card">

                    <div class="about-icon">

                        <i class="bi bi-mortarboard"></i>

                    </div>


                    <h4>
                        Academic Information
                    </h4>


                    <p>

                        Subjects are organized according
                        to academic year, major and semester.

                    </p>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="about-card">

                    <div class="about-icon">

                        <i class="bi bi-phone"></i>

                    </div>


                    <h4>
                        Easy Access
                    </h4>


                    <p>

                        Access the subject portal easily
                        from desktop, tablet and mobile devices.

                    </p>

                </div>

            </div>


        </div>

    </div>

</section>



{{-- =========================================================
     LOCATION
========================================================= --}}

<section
    class="location-section"
    id="location">

    <div class="container">


        <div class="mb-5 text-center">

            <div class="section-label">
                Location
            </div>


            <h2 class="section-title">
                University Location
            </h2>


            <p class="mx-auto section-description">

                Find our university campus on the map
                and get directions easily.

            </p>


            <div class="mx-auto blue-line"></div>

        </div>


        <div class="row g-4 align-items-stretch">


            {{-- MAP --}}

            <div class="col-lg-8">

                <div class="location-map-card">

                    <iframe
                        class="location-map"
                        src="https://www.google.com/maps?q=University%20of%20Computer%20Studies%20Magway&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>

                </div>

            </div>


            {{-- INFORMATION --}}

            <div class="col-lg-4">

                <div class="location-map-card">

                    <div class="location-info">


                        <div class="location-info-title">

                            <i
                                class="bi bi-geo-alt-fill me-2 text-primary">
                            </i>

                            University of Computer Studies
                            (Magway)

                        </div>


                        <p class="location-info-description">

                            Visit our University of Computer Studies
                            (Magway) for academic information,
                            courses and student services.

                        </p>


                        <div class="location-info-item">

                            <div class="location-info-icon">

                                <i class="bi bi-geo-alt"></i>

                            </div>

                            <div>

                                <strong>
                                    Address
                                </strong>

                                <span>

                                    Computer University Studies,
                                    Magway, Myanmar

                                </span>

                            </div>

                        </div>


                        <div class="location-info-item">

                            <div class="location-info-icon">

                                <i class="bi bi-envelope"></i>

                            </div>

                            <div>

                                <strong>
                                    Email
                                </strong>

                                <span>
                                    info@university.edu
                                </span>

                            </div>

                        </div>


                        <div class="location-info-item">

                            <div class="location-info-icon">

                                <i class="bi bi-telephone"></i>

                            </div>

                            <div>

                                <strong>
                                    Phone
                                </strong>

                                <span>
                                    +95 9 000 000 000
                                </span>

                            </div>

                        </div>


                        <a
                            href="https://www.google.com/maps/search/?api=1&query=University+of+Computer+Studies+Magway"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="location-button">

                            <i class="bi bi-map"></i>

                            Open in Google Maps

                        </a>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     STATISTICS
========================================================= --}}

<section class="statistics-section">

    <div class="container">

        <div class="row">


            <div class="col-lg-3 col-md-6 col-6">

                <div class="stat-item">

                    <div class="stat-icon">

                        <i class="bi bi-book"></i>

                    </div>


                    <div>

                        <div class="stat-number">

                            {{ isset($subjects) ? $subjects->count() : 0 }}

                        </div>


                        <div class="stat-label">
                            Subjects
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 col-6">

                <div class="stat-item">

                    <div class="stat-icon">

                        <i class="bi bi-mortarboard"></i>

                    </div>


                    <div>

                        <div class="stat-number">

                            {{ isset($years) ? $years->count() : 0 }}

                        </div>


                        <div class="stat-label">
                            Academic Years
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 col-6">

                <div class="stat-item">

                    <div class="stat-icon">

                        <i class="bi bi-building"></i>

                    </div>


                    <div>

                        <div class="stat-number">

                            {{ isset($majors) ? $majors->count() : 0 }}

                        </div>


                        <div class="stat-label">
                            Majors
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 col-6">

                <div class="stat-item">

                    <div class="stat-icon">

                        <i class="bi bi-person"></i>

                    </div>


                    <div>

                        <div class="stat-number">

                            {{ isset($teachers) ? $teachers->count() : 0 }}

                        </div>


                        <div class="stat-label">
                            Teachers
                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



{{-- =========================================================
     FOOTER
========================================================= --}}

<footer>

    <div class="container">

        <div class="row g-5">


            <div class="col-lg-5">

                <div class="footer-title">

                    <i
                        class="bi bi-mortarboard-fill me-2">
                    </i>

                    University Subject Portal

                </div>


                <p class="mt-3">

                    A modern university academic portal
                    that helps students explore subjects
                    and academic information easily.

                </p>

            </div>


            <div class="col-lg-2">

                <div class="footer-title">
                    Portal
                </div>


                <a href="#home">
                    Home
                </a>


                <a href="#subjects">
                    Subject
                </a>


                <a href="#about">
                    About
                </a>


                <a href="#location">
                    Location
                </a>

            </div>


            <div class="col-lg-2">

                <div class="footer-title">
                    Academic
                </div>


                <a href="#subjects">
                    Subjects
                </a>


                <a href="#about">
                    Academic Information
                </a>


                <a href="#location">
                    University Campus
                </a>

            </div>


            <div class="col-lg-3">

                <div class="footer-title">
                    Contact
                </div>


                <p class="mt-3">

                    <i
                        class="bi bi-geo-alt me-2">
                    </i>

                    Computer University Studies

                </p>


                <p>

                    <i
                        class="bi bi-globe me-2">
                    </i>


                    <a
                        href="https://www.ucsmgy.edu.mm"
                        target="_blank"
                        rel="noopener noreferrer">

                        www.ucsmgy.edu.mm

                    </a>

                </p>


                <p>

                    <i
                        class="bi bi-telephone me-2">
                    </i>

                    +95 9 000 000 000

                </p>

            </div>


        </div>


        <div class="footer-bottom">

            © {{ date('Y') }}

            University Subject Portal.

            All Rights Reserved.

        </div>

    </div>

</footer>



{{-- =========================================================
     BOOTSTRAP JS
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =====================================================
           VARIABLES
        ===================================================== */

        let selectedYear = "all";


        const searchInput =
            document.getElementById("subjectSearch");


        const clearSearch =
            document.getElementById("clearSearch");


        const noSearchResult =
            document.getElementById("noSearchResult");


        const subjectItems =
            document.querySelectorAll(".subject-item");


        const yearButtons =
            document.querySelectorAll(".year-filter");


        const navLinks =
            document.querySelectorAll(
                '#mainNavbar .nav-link[data-section]'
            );


        const navbarWrapper =
            document.getElementById(
                "mainNavbarWrapper"
            );


        const navbarCollapse =
            document.getElementById(
                "mainNavbar"
            );


        /* =====================================================
           SUBJECT FILTER
        ===================================================== */

        function filterSubjects() {

            const keyword =
                searchInput
                    ? searchInput.value
                        .toLowerCase()
                        .trim()
                    : "";


            let found = 0;


            subjectItems.forEach(
                function (subject) {


                    const subjectYear =
                        subject.getAttribute(
                            "data-year"
                        ) || "";


                    const subjectName =
                        subject.getAttribute(
                            "data-subject-name"
                        ) || "";


                    const subjectCode =
                        subject.getAttribute(
                            "data-subject-code"
                        ) || "";


                    const searchableText =
                        (
                            subjectName +
                            " " +
                            subjectCode
                        ).toLowerCase();


                    const yearMatch =
                        selectedYear === "all" ||
                        subjectYear === selectedYear;


                    const searchMatch =
                        keyword === "" ||
                        searchableText.includes(
                            keyword
                        );


                    if (
                        yearMatch &&
                        searchMatch
                    ) {

                        subject.style.display = "";

                        found++;

                    } else {

                        subject.style.display = "none";

                    }

                }
            );


            if (
                subjectItems.length > 0 &&
                found === 0
            ) {

                noSearchResult.style.display =
                    "block";

            } else {

                noSearchResult.style.display =
                    "none";
            }


            if (clearSearch) {

                clearSearch.style.display =
                    keyword !== ""
                        ? "flex"
                        : "none";
            }

        }


        /* =====================================================
           YEAR FILTER
        ===================================================== */

        yearButtons.forEach(
            function (button) {

                button.addEventListener(
                    "click",
                    function () {


                        yearButtons.forEach(
                            function (btn) {

                                btn.classList.remove(
                                    "active"
                                );

                            }
                        );


                        this.classList.add(
                            "active"
                        );


                        selectedYear =
                            this.getAttribute(
                                "data-year"
                            ) || "all";


                        filterSubjects();

                    }
                );

            }
        );


        /* =====================================================
           SEARCH
        ===================================================== */

        if (searchInput) {

            searchInput.addEventListener(
                "input",
                filterSubjects
            );

        }


        /* =====================================================
           CLEAR SEARCH
        ===================================================== */

        if (clearSearch) {

            clearSearch.addEventListener(
                "click",
                function () {

                    if (searchInput) {

                        searchInput.value = "";

                        filterSubjects();

                        searchInput.focus();

                    }

                }
            );

        }


        /* =====================================================
           NAVBAR ACTIVE SECTION
        ===================================================== */

        const sections = [];


        navLinks.forEach(
            function (link) {

                const sectionId =
                    link.getAttribute(
                        "data-section"
                    );


                const section =
                    document.getElementById(
                        sectionId
                    );


                if (section) {

                    sections.push({
                        id: sectionId,
                        element: section,
                        link: link
                    });

                }


                /* =============================================
                   CLICK ACTIVE
                ============================================= */

                link.addEventListener(
                    "click",
                    function () {


                        navLinks.forEach(
                            function (nav) {

                                nav.classList.remove(
                                    "active"
                                );

                            }
                        );


                        this.classList.add(
                            "active"
                        );


                        /* MOBILE CLOSE */

                        if (
                            window.innerWidth < 992 &&
                            navbarCollapse.classList.contains(
                                "show"
                            )
                        ) {

                            const collapse =
                                bootstrap.Collapse
                                    .getInstance(
                                        navbarCollapse
                                    );


                            if (collapse) {

                                collapse.hide();

                            }

                        }

                    }
                );

            }
        );


        /* =====================================================
           SCROLL ACTIVE NAV
        ===================================================== */

        function updateActiveSection() {

            const scrollPosition =
                window.scrollY + 140;


            let currentSection =
                "home";


            sections.forEach(
                function (section) {

                    const top =
                        section.element.offsetTop;


                    if (
                        scrollPosition >= top
                    ) {

                        currentSection =
                            section.id;

                    }

                }
            );


            navLinks.forEach(
                function (link) {

                    const sectionId =
                        link.getAttribute(
                            "data-section"
                        );


                    if (
                        sectionId === currentSection
                    ) {

                        link.classList.add(
                            "active"
                        );

                    } else {

                        link.classList.remove(
                            "active"
                        );

                    }

                }
            );

        }


        /* =====================================================
           NAVBAR SCROLL SHADOW
        ===================================================== */

        function updateNavbar() {

            if (
                window.scrollY > 10
            ) {

                navbarWrapper.classList.add(
                    "scrolled"
                );

            } else {

                navbarWrapper.classList.remove(
                    "scrolled"
                );

            }

        }


        /* =====================================================
           SCROLL EVENT
        ===================================================== */

        window.addEventListener(
            "scroll",
            function () {

                updateActiveSection();

                updateNavbar();

            },
            {
                passive: true
            }
        );


        /* =====================================================
           INITIAL
        ===================================================== */

        filterSubjects();

        updateActiveSection();

        updateNavbar();

    }

);

</script>


</body>

</html>
