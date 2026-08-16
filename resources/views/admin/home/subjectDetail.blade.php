<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $subject->logn_name }} - University Subject Portal
    </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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


        /* =====================================================
           NAVBAR
        ===================================================== */

        .main-navbar {

            height: 88px;

            background: #ffffff;

            border-bottom: 1px solid #edf1f6;

            z-index: 1000;
        }


        .navbar-brand {

            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            color: #12264a;
        }


        .university-logo {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #0759c9;

            color: #ffffff;

            font-size: 24px;
        }


        .brand-title {

            font-size: 20px;

            font-weight: 800;

            line-height: 1.1;
        }


        .brand-subtitle {

            font-size: 11px;

            color: #71809b;

            margin-top: 4px;
        }


        .navbar-nav .nav-link {

            color: #253452 !important;

            font-size: 15px;

            font-weight: 600;

            margin: 0 12px;

            padding: 32px 4px;

            position: relative;
        }


        .navbar-nav .nav-link:hover {

            color: #1261d6 !important;
        }


        .navbar-nav .nav-link.active {

            color: #1261d6 !important;
        }


        .navbar-nav .nav-link.active::after {

            content: "";

            position: absolute;

            left: 0;

            right: 0;

            bottom: 19px;

            height: 2px;

            background: #1261d6;
        }


        .login-button {

            background: #1261d6;

            color: #ffffff !important;

            border-radius: 8px;

            padding: 11px 21px !important;

            margin-left: 12px !important;

            text-decoration: none;

            transition: .2s;
        }


        .login-button:hover {

            background: #084da9;

            color: #ffffff !important;
        }



        /* =====================================================
           HERO
        ===================================================== */

        .hero {

            min-height: 440px;

            position: relative;

            background-image:

                linear-gradient(90deg,
                    rgba(4, 45, 105, .98) 0%,
                    rgba(5, 54, 120, .93) 38%,
                    rgba(5, 54, 120, .58) 62%,
                    rgba(5, 54, 120, .08) 100%),

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

            background: rgba(255, 255, 255, .14);

            border: 1px solid rgba(255, 255, 255, .18);

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;
        }


        .hero-title {

            font-size: 53px;

            line-height: 1.08;

            font-weight: 800;

            margin-top: 20px;

            max-width: 650px;
        }


        .hero-title span {

            color: #74b7ff;
        }


        .hero-description {

            max-width: 600px;

            font-size: 17px;

            line-height: 1.7;

            color: #e5efff;

            margin-top: 18px;
        }


        .hero-button {

            display: inline-flex;

            align-items: center;

            margin-top: 20px;

            padding: 13px 23px;

            background: #ffffff;

            color: #1261d6;

            border-radius: 8px;

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;

            transition: .2s;
        }


        .hero-button:hover {

            background: #eef5ff;

            color: #084da9;
        }



        /* =====================================================
           SUBJECT DETAIL SECTION
        ===================================================== */

        .detail-section {

            padding: 75px 0 85px;

            background: #ffffff;
        }


        /* =====================================================
           DETAIL HEADER
        ===================================================== */

        .detail-header {

            text-align: center;

            margin-bottom: 45px;
        }


        .detail-label {

            color: #1261d6;

            font-size: 12px;

            font-weight: 800;

            letter-spacing: .7px;

            text-transform: uppercase;
        }


        .detail-heading {

            font-size: 32px;

            line-height: 1.25;

            font-weight: 800;

            color: #142950;

            margin-top: 9px;

            margin-bottom: 8px;
        }


        .detail-description {

            color: #6b7890;

            font-size: 14px;

            line-height: 1.7;

            max-width: 650px;

            margin: 0 auto;
        }


        .blue-line {

            width: 45px;

            height: 3px;

            background: #1261d6;

            margin: 15px auto 0;
        }



        /* =====================================================
           IMAGE CARD
        ===================================================== */

        .detail-image-card {

            background: #ffffff;

            border: 1px solid #e5ebf3;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 8px 25px rgba(20, 50, 90, .06);
        }


        .detail-image-wrapper {

            width: 100%;

            height: 390px;

            overflow: hidden;

            background: #eef5ff;
        }


        .detail-image {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

            transition: transform .35s ease;
        }


        .detail-image-card:hover .detail-image {

            transform: scale(1.03);
        }



        /* =====================================================
           INFORMATION CARD
        ===================================================== */

        .info-card {

            background: #ffffff;

            border: 1px solid #e5ebf3;

            border-radius: 14px;

            padding: 28px;

            box-shadow:
                0 8px 25px rgba(20, 50, 90, .05);

            height: 100%;
        }


        .info-title {

            font-size: 20px;

            font-weight: 800;

            color: #142950;

            margin-bottom: 22px;
        }


        .info-item {

            display: flex;

            align-items: flex-start;

            gap: 14px;

            padding: 15px 0;

            border-bottom: 1px solid #edf1f6;
        }


        .info-item:last-child {

            border-bottom: none;
        }


        .info-icon {

            width: 40px;

            height: 40px;

            flex: 0 0 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            background: #eef5ff;

            color: #1261d6;

            font-size: 16px;
        }


        .info-label {

            font-size: 11px;

            color: #8793a6;

            margin-bottom: 3px;
        }


        .info-value {

            font-size: 14px;

            color: #172a4d;

            font-weight: 700;

            line-height: 1.5;
        }



        /* =====================================================
           SUBJECT DESCRIPTION
        ===================================================== */

        .description-card {

            margin-top: 30px;

            background: #ffffff;

            border: 1px solid #e5ebf3;

            border-radius: 14px;

            padding: 30px;

            box-shadow:
                0 8px 25px rgba(20, 50, 90, .05);
        }


        .description-title {

            font-size: 20px;

            font-weight: 800;

            color: #142950;

            margin-bottom: 18px;
        }


        .description-text {

            color: #6b7890;

            font-size: 14px;

            line-height: 1.9;

            margin: 0;
        }



        /* =====================================================
           BACK BUTTON
        ===================================================== */

        .back-button {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 30px;

            padding: 11px 18px;

            border-radius: 8px;

            background: #1261d6;

            color: #ffffff;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition: .2s;
        }


        .back-button:hover {

            background: #084da9;

            color: #ffffff;
        }



        /* =====================================================
           FOOTER
        ===================================================== */

        footer {

            background: #0c2146;

            color: #9dafc9;

            padding: 55px 0 20px;
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

            color: #aabbd4;

            text-decoration: none;

            font-size: 13px;

            margin-top: 9px;
        }


        footer a:hover {

            color: #ffffff;
        }


        .footer-bottom {

            border-top:
                1px solid rgba(255, 255, 255, .1);

            margin-top: 40px;

            padding-top: 18px;

            text-align: center;

            font-size: 12px;
        }



        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 991px) {

            .main-navbar {

                height: auto;

                padding: 12px 0;
            }


            .navbar-nav {

                padding-top: 10px;
            }


            .navbar-nav .nav-link {

                margin: 4px 0;

                padding: 9px 0;
            }


            .navbar-nav .nav-link.active::after {

                display: none;
            }


            .login-button {

                display: inline-block;

                margin: 8px 0 !important;
            }


            .hero-title {

                font-size: 43px;
            }


            .detail-heading {

                font-size: 29px;
            }
        }


        @media(max-width: 576px) {

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


            .detail-section {

                padding: 55px 0;
            }


            .detail-heading {

                font-size: 26px;
            }


            .detail-image-wrapper {

                height: 240px;
            }


            .info-card {

                padding: 22px;
            }


            .description-card {

                padding: 22px;
            }
        }
    </style>

</head>


<body>


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <nav class="navbar navbar-expand-lg main-navbar sticky-top">

        <div class="container">


            <!-- BRAND -->

            <a href="{{ route('page') }}" class="navbar-brand">

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



            <!-- MOBILE -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">

                <span class="navbar-toggler-icon"></span>

            </button>



            <!-- NAVIGATION -->

            <div class="collapse navbar-collapse" id="mainNavbar">

                <ul class="navbar-nav ms-auto align-items-lg-center">


                    <!-- HOME -->

                    <li class="nav-item">

                        <a href="{{ route('page') }}#home" class="nav-link">

                            Home

                        </a>

                    </li>


                    <!-- SUBJECT -->

                    <li class="nav-item">

                        <a href="{{ route('page') }}#subjects" class="nav-link active">

                            Subject

                        </a>

                    </li>


                    <!-- ABOUT -->

                    {{-- <li class="nav-item">

                        <a href="{{ route('page') }}#about" class="nav-link">

                            About

                        </a>

                    </li> --}}


                    <!-- LOGIN -->

                    <li class="nav-item">

                        <a href="{{ route('login') }}" class="nav-link login-button">

                            <i class="bi bi-person me-2"></i>

                            Login

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>



    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="hero" id="home">

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


                <a href="#subject-detail" class="hero-button">

                    View Subject

                    <i class="bi bi-arrow-down ms-2"></i>

                </a>

            </div>

        </div>

    </section>



    <!-- =====================================================
         SUBJECT DETAIL
    ====================================================== -->

    <section class="detail-section" id="subject-detail">

        <div class="container">


            <!-- =================================================
                 DETAIL TITLE
            ================================================== -->

            <div class="detail-header">

                <div class="detail-label">

                    Academic Subject

                </div>


                <h2 class="detail-heading">

                    Subject Detail

                </h2>


                <p class="detail-description">

                    View detailed academic information about
                    this university subject.

                </p>


                <div class="blue-line"></div>

            </div>



            <!-- =================================================
                 IMAGE + INFORMATION
            ================================================== -->

            <div class="row g-4">


                <!-- IMAGE -->

                <div class="col-lg-7">

                    <div class="detail-image-card">

                        <div class="detail-image-wrapper">


                            @if (!empty($subject->image))
                                <img src="{{ asset($subject->image) }}" alt="{{ $subject->name }}" class="detail-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80"
                                    alt="{{ $subject->name }}" class="detail-image">
                            @endif


                        </div>

                    </div>

                </div>



                <!-- INFORMATION -->

                <div class="col-lg-5">

                    <div class="info-card">

                        <!-- SUBJECT NAME -->

                        <div class="info-title">

                            <i class="bi bi-book me-2 text-primary"></i>

                            {{ $subject->long_name }}

                        </div>


                        <!-- SHORT NAME / SUBJECT CODE -->

                        @if (!empty($subject->short_name))
                            <div class="info-item">

                                <div class="info-icon">

                                    <i class="bi bi-upc-scan"></i>

                                </div>

                                <div>

                                    <div class="info-label">

                                        Subject Code

                                    </div>

                                    <div class="info-value">

                                        {{ $subject->short_name }}

                                    </div>

                                </div>

                            </div>
                        @endif


                        <!-- ACADEMIC YEAR -->

                        @if (isset($subject->year))
                            <div class="info-item">

                                <div class="info-icon">

                                    <i class="bi bi-mortarboard"></i>

                                </div>

                                <div>

                                    <div class="info-label">

                                        Academic Year

                                    </div>

                                    <div class="info-value">

                                        {{ $subject->year->name }}

                                    </div>

                                </div>

                            </div>
                        @endif


                        <!-- MAJOR -->

                        @if (isset($subject->major))
                            <div class="info-item">

                                <div class="info-icon">

                                    <i class="bi bi-building"></i>

                                </div>

                                <div>

                                    <div class="info-label">

                                        Major

                                    </div>

                                    <div class="info-value">

                                        {{ $subject->major->name }}

                                    </div>

                                </div>

                            </div>
                        @endif


                        <!-- SEMESTER -->

                        @if (isset($subject->semester))
                            <div class="info-item">

                                <div class="info-icon">

                                    <i class="bi bi-layers"></i>

                                </div>

                                <div>

                                    <div class="info-label">

                                        Semester

                                    </div>

                                    <div class="info-value">

                                        {{ $subject->semester->name }}

                                    </div>

                                </div>

                            </div>
                        @endif

                    </div>

                </div>

            </div>



            <!-- =================================================
                 DESCRIPTION
            ================================================== -->

            @if (!empty($subject->description))
                <div class="description-card">

                    <div class="description-title">

                        <i class="bi bi-file-text me-2 text-primary"></i>

                        Subject Description

                    </div>


                    <p class="description-text">

                        {!! $subject->description !!}

                    </p>

                </div>
            @endif



            <!-- =================================================
                 BACK BUTTON
            ================================================== -->

            <a href="{{ route('page') }}#subjects" class="back-button">

                <i class="bi bi-arrow-left"></i>

                Back to Subjects

            </a>

        </div>

    </section>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer>

        <div class="container">

            <div class="row g-5">


                <!-- BRAND -->

                <div class="col-lg-5">

                    <div class="footer-title">

                        <i class="bi bi-mortarboard-fill me-2"></i>

                        University Subject Portal

                    </div>


                    <p class="mt-3">

                        A modern university academic portal
                        that helps students explore subjects
                        and academic information easily.

                    </p>

                </div>



                <!-- PORTAL -->

                <div class="col-lg-2">

                    <div class="footer-title">

                        Portal

                    </div>


                    <a href="{{ route('page') }}#home">

                        Home

                    </a>


                    <a href="{{ route('page') }}#subjects">

                        Subject

                    </a>


                    <a href="{{ route('page') }}#about">

                        About

                    </a>

                </div>



                <!-- ACADEMIC -->

                <div class="col-lg-2">

                    <div class="footer-title">

                        Academic

                    </div>


                    <a href="{{ route('page') }}#subjects">

                        Subjects

                    </a>


                    <a href="{{ route('page') }}#subjects">

                        Academic Information

                    </a>

                </div>



                <!-- CONTACT -->

                <div class="col-lg-3">

                    <div class="footer-title">

                        Contact

                    </div>


                    <p class="mt-3">

                        <i class="bi bi-geo-alt me-2"></i>

                        University Campus

                    </p>


                    <p>

                        <i class="bi bi-envelope me-2"></i>

                        info@university.edu

                    </p>


                    <p>

                        <i class="bi bi-telephone me-2"></i>

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



    <!-- =====================================================
         BOOTSTRAP JS
    ====================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
