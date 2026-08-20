@extends('user.layouts.master')

@section('content')
    {{-- =========================================================
    UCSMGY PORTAL HERO
========================================================= --}}
    <section class="ucsm-portal-hero">

        <div class="ucsm-portal-bg" style="background-image: url('{{ asset('user/img/hero/hero-5/hero-bg.svg') }}');">

            <div class="container">

                <div class="row align-items-center ucsm-portal-row">

                    {{-- =================================================
                    LEFT CONTENT
                ================================================== --}}
                    <div class="col-lg-6">

                        <div class="ucsm-content">

                            @if (auth()->check() && auth()->user()->role === 'teacher')
                                {{-- =========================
                                TEACHER PORTAL
                            ========================== --}}

                                <div class="portal-badge wow fadeInUp" data-wow-delay=".1s">

                                    <span class="portal-badge-icon">
                                        <i class="lni lni-graduation"></i>
                                    </span>

                                    <span class="portal-badge-text">
                                        TEACHER PORTAL
                                    </span>

                                </div>

                                <h1 class="wow fadeInUp" data-wow-delay=".2s">

                                    Welcome to the

                                    <span>
                                        UCSMGY Teacher Portal
                                    </span>

                                </h1>

                                <p class="wow fadeInUp" data-wow-delay=".35s">

                                    Manage your class schedules, assigned
                                    subjects, teaching times and sections
                                    at the University of Computer Studies,
                                    Magway.

                                </p>
                            @elseif (auth()->check() && auth()->user()->role === 'user')
                                {{-- =========================
                                STUDENT PORTAL
                            ========================== --}}

                                <div class="portal-badge wow fadeInUp" data-wow-delay=".1s">

                                    <span class="portal-badge-icon">
                                        <i class="lni lni-graduation"></i>
                                    </span>

                                    <span class="portal-badge-text">
                                        STUDENT PORTAL
                                    </span>

                                </div>

                                <h1 class="wow fadeInUp" data-wow-delay=".2s">

                                    Welcome to the

                                    <span>
                                        UCSMGY Student Portal
                                    </span>

                                </h1>

                                <p class="wow fadeInUp" data-wow-delay=".35s">

                                    View your class timetable, subjects,
                                    sections and academic schedule at the
                                    University of Computer Studies,
                                    Magway.

                                </p>
                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                    RIGHT IMAGE
                ================================================== --}}
                    <div class="col-lg-6">

                        <div class="ucsm-portal-image wow fadeInUp" data-wow-delay=".35s">

                            <div class="image-circle"></div>

                            <img src="{{ asset('user/img/hero/hero-5/hero-img.svg') }}" alt="UCSMGY Portal"
                                class="portal-main-image">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    HERO CSS ONLY
========================================================= --}}
    <style>
        /* =========================================================
       HERO
    ========================================================= */

        .ucsm-portal-hero {
            position: relative;
            width: 100%;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden;
        }


        /* =========================================================
       HERO BACKGROUND
    ========================================================= */

        .ucsm-portal-bg {
            position: relative;
            width: 100%;
            min-height: 650px;
            margin: 0 !important;
            padding: 0 !important;

            display: flex;
            align-items: center;

            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


        /* =========================================================
       HERO ROW
    ========================================================= */

        .ucsm-portal-row {
            min-height: 650px;
            margin: 0 !important;
        }


        /* =========================================================
       CONTENT
    ========================================================= */

        .ucsm-content {
            position: relative;
            z-index: 5;
            margin: 0 !important;
            padding: 0 !important;
        }


        /* =========================================================
       ROLE BADGE
    ========================================================= */

        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 24px;
            padding: 6px 15px 6px 6px;

            border-radius: 50px;

            background: rgba(255, 255, 255, .90);
            border: 1px solid #e5ebf3;

            box-shadow:
                0 8px 25px rgba(30, 70, 130, .07);
        }


        .portal-badge-icon {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: #ffffff;
            background: #1769e0;
        }


        .portal-badge-icon i {
            font-size: 14px;
        }


        .portal-badge-text {
            color: #64748b;

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }


        /* =========================================================
       TITLE
    ========================================================= */

        .ucsm-content h1 {
            max-width: 650px;

            margin: 0 0 25px 0 !important;
            padding: 0 !important;

            color: #17253a;

            font-size: clamp(42px, 4.5vw, 62px);
            font-weight: 800;

            line-height: 1.1;
            letter-spacing: -2px;
        }


        .ucsm-content h1 span {
            display: block;
            color: #1769e0;
        }


        /* =========================================================
       DESCRIPTION
    ========================================================= */

        .ucsm-content p {
            max-width: 560px;

            margin: 0 !important;
            padding: 0 !important;

            color: #718096;

            font-size: 15px;
            line-height: 1.85;
        }


        /* =========================================================
       HERO IMAGE
    ========================================================= */

        .ucsm-portal-image {
            position: relative;

            width: 100%;
            min-height: 650px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0;
            padding: 30px 0;
        }


        .image-circle {
            position: absolute;

            width: 470px;
            height: 470px;

            border-radius: 50%;

            background: rgba(23, 105, 224, .045);

            border: 1px solid rgba(23, 105, 224, .08);
        }


        .image-circle::before {
            content: "";

            position: absolute;

            inset: 35px;

            border-radius: 50%;

            border: 1px solid rgba(23, 105, 224, .07);
        }


        .portal-main-image {
            position: relative;

            z-index: 2;

            width: 100%;
            max-width: 560px;
            height: auto;

            display: block;

            filter:
                drop-shadow(0 25px 30px rgba(30, 70, 130, .12));

            animation:
                portalFloat 5s ease-in-out infinite;
        }


        /* =========================================================
       IMAGE ANIMATION
    ========================================================= */

        @keyframes portalFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

        }


        /* =========================================================
       TABLET
    ========================================================= */

        @media (max-width: 991px) {

            .ucsm-portal-bg {
                min-height: auto;
            }

            .ucsm-portal-row {
                min-height: auto;
            }

            .ucsm-content {
                padding: 70px 0 25px !important;
                text-align: center;
            }

            .portal-badge {
                margin-left: auto;
                margin-right: auto;
            }

            .ucsm-content h1 {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .ucsm-content p {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .ucsm-portal-image {
                min-height: 450px;
                padding: 20px 0 60px;
            }

        }


        /* =========================================================
       MOBILE
    ========================================================= */

        @media (max-width: 575px) {

            .ucsm-content {
                padding: 55px 15px 20px !important;
            }

            .ucsm-content h1 {
                font-size: 36px;
                letter-spacing: -1px;
            }

            .ucsm-content p {
                font-size: 13px;
            }

            .ucsm-portal-image {
                min-height: 330px;
            }

            .image-circle {
                width: 300px;
                height: 300px;
            }

            .portal-main-image {
                max-width: 340px;
            }

        }


        /* =========================================================
       SMALL MOBILE
    ========================================================= */

        @media (max-width: 375px) {

            .ucsm-content h1 {
                font-size: 32px;
            }

            .portal-badge-text {
                font-size: 8px;
            }

        }
    </style>
@endsection
