<!DOCTYPE html>
<html class="no-js" lang="">

<head>

    <meta charset="utf-8" />

    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <title>
        UCSMGY Portal - University of Computer Studies, Magway
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />


    {{-- =========================================================
        CSS
    ========================================================== --}}

    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />

    <link rel="stylesheet" href="{{ asset('user/css/tiny-slider.css') }}" />

    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}" />

    <link rel="stylesheet" href="{{ asset('user/css/lindy-uikit.css') }}" />


    {{-- =========================================================
        GLOBAL CUSTOM CSS
    ========================================================== --}}

    <style>
        /* =====================================================
           RESET
        ===================================================== */

        html,
        body {

            margin: 0 !important;

            padding: 0 !important;

            width: 100%;

            overflow-x: hidden;

        }


        body {

            background: #ffffff;

        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .ucsm-navbar {

            width: 100%;

            height: 78px;

            margin: 0 !important;

            padding: 0 !important;

            background: #ffffff;

            border-bottom: 1px solid #edf1f6;

            box-shadow:
                0 4px 20px rgba(20, 50, 90, .04);

            position: relative;

            z-index: 1000;

        }


        .ucsm-navbar .navbar-area {

            height: 100%;

            margin: 0 !important;

            padding: 0 !important;

        }


        .ucsm-navbar .navbar {

            min-height: 78px;

            margin: 0 !important;

            padding: 0 !important;

        }


        /* =====================================================
           BRAND
        ===================================================== */

        .ucsm-brand {

            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

        }


        .ucsm-brand-logo {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            color: #ffffff;

            background:
                linear-gradient(135deg,
                    #1769e0,
                    #0b4ca8);

            box-shadow:
                0 7px 18px rgba(23, 105, 224, .20);

        }


        .ucsm-brand-logo i {

            font-size: 20px;

        }


        .ucsm-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.1;

        }


        .ucsm-brand-text strong {

            color: #17253a;

            font-size: 18px;

            font-weight: 800;

            letter-spacing: 1px;

        }


        .ucsm-brand-text span {

            margin-top: 4px;

            color: #8a96a6;

            font-size: 7px;

            font-weight: 700;

            letter-spacing: .8px;

        }


        /* =====================================================
           NAV LINKS
        ===================================================== */

        .ucsm-navbar .nav-link {

            position: relative;

            display: flex;

            align-items: center;

            min-height: 78px;

            padding:
                0 15px !important;

            margin: 0 2px;

            color: #64748b !important;

            font-size: 12px;

            font-weight: 600;

            text-decoration: none;

            transition:
                color .25s ease;

        }


        .ucsm-navbar .nav-link::after {

            content: "";

            position: absolute;

            left: 15px;

            right: 15px;

            bottom: 0;

            height: 2px;

            border-radius: 10px;

            background: #1769e0;

            transform:
                scaleX(0);

            transition:
                transform .25s ease;

        }


        .ucsm-navbar .nav-link:hover {

            color: #1769e0 !important;

        }


        .ucsm-navbar .nav-link:hover::after {

            transform:
                scaleX(1);

        }


        /* =====================================================
           ACCOUNT
        ===================================================== */

        .ucsm-account-link {

            color: #1769e0 !important;

        }


        .ucsm-account-link::after {

            display: none;

        }


        /* =====================================================
           NOTIFICATION
        ===================================================== */

        .ucsm-notification {

            width: 38px;

            height: 38px;

            display: flex !important;

            align-items: center;

            justify-content: center;

            min-height: 38px !important;

            padding: 0 !important;

            margin-left: 8px;

            border-radius: 50%;

            background: #f5f8fc;

        }


        .ucsm-notification::after {

            display: none;

        }


        .ucsm-notification:hover {

            background: #edf5ff;

        }


        /* =====================================================
           DROPDOWN
        ===================================================== */

        .ucsm-navbar .dropdown-menu {

            margin-top: 10px !important;

            padding: 7px;

            border: 1px solid #edf1f6 !important;

            border-radius: 14px !important;

            box-shadow:
                0 18px 45px rgba(20, 50, 90, .10) !important;

        }


        .ucsm-navbar .dropdown-item {

            border-radius: 9px;

            color: #475569;

            font-size: 11px;

            transition:
                all .2s ease;

        }


        .ucsm-navbar .dropdown-item:hover {

            color: #1769e0;

            background: #f3f7fd;

        }


        /* =====================================================
           MAIN
        ===================================================== */

        main {

            margin: 0 !important;

            padding: 0 !important;

        }


        /* =====================================================
           HERO DIRECTLY UNDER NAVBAR
        ===================================================== */

        .ucsm-portal-hero {

            margin: 0 !important;

            padding: 0 !important;

        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .ucsm-footer {

            margin: 0 !important;

            padding:
                30px 0;

            background: #101c2d;

            color: rgba(255, 255, 255, .55);

        }


        .ucsm-footer p {

            margin: 0;

            font-size: 11px;

        }


        /* =====================================================
           MOBILE NAVBAR
        ===================================================== */

        @media (max-width: 991px) {

            .ucsm-navbar {

                height: auto;

                min-height: 70px;

            }


            .ucsm-navbar .navbar {

                min-height: 70px;

            }


            .ucsm-navbar .nav-link {

                min-height: 48px;

                padding:
                    0 15px !important;

            }


            .ucsm-navbar .nav-link::after {

                display: none;

            }


            .ucsm-navbar .navbar-collapse {

                padding:
                    12px 0 15px;

            }


            .ucsm-navbar .nav-item {

                width: 100%;

            }


            .ucsm-brand-text strong {

                font-size: 16px;

            }

        }
    </style>

</head>


<body>


    {{-- =========================================================
        NAVBAR
    ========================================================== --}}

    <header class="ucsm-navbar">

        <div class="navbar-area">

            <div class="container">

                <nav class="navbar navbar-expand-lg">


                    {{-- =================================================
                        BRAND
                    ================================================== --}}

                    <a class="ucsm-brand" href="{{ route('userHome') }}">

                        <div class="ucsm-brand-logo">

                            <i class="lni lni-graduation"></i>

                        </div>

                        <div class="ucsm-brand-text">

                            <strong>
                                UCSMGY
                            </strong>

                            <span>
                                UNIVERSITY PORTAL
                            </span>

                        </div>

                    </a>


                    {{-- =================================================
                        MOBILE TOGGLE
                    ================================================== --}}

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent6" aria-controls="navbarSupportedContent6"
                        aria-expanded="false" aria-label="Toggle navigation">

                        <span class="toggler-icon"></span>

                        <span class="toggler-icon"></span>

                        <span class="toggler-icon"></span>

                    </button>


                    {{-- =================================================
                        NAVIGATION
                    ================================================== --}}

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent6">

                        <ul class="navbar-nav ms-auto align-items-center">


                            {{-- HOME --}}

                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('userHome') }}">

                                    Home

                                </a>

                            </li>


                            {{-- SCHEDULE --}}

                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('user.schedule') }}">

                                    Schedule

                                </a>

                            </li>


                            {{-- SUBJECT --}}

                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('user.subject') }}">

                                    Subject

                                </a>

                            </li>


                            {{-- =================================================
                                TEACHER ONLY
                            ================================================== --}}

                            @if (auth()->check() && auth()->user()->role === 'teacher')


                                {{-- CONTACT --}}

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('user.contact') }}">

                                        Contact

                                    </a>

                                </li>


                                {{-- =================================================
                                    NOTIFICATION
                                ================================================== --}}

                                <li class="nav-item dropdown">

                                    <a class="nav-link ucsm-notification position-relative" href="#"
                                        id="notificationDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        <i class="lni lni-alarm"></i>


                                        @php

                                            $unreadCount = \App\Models\Contact::where('user_id', auth()->id())
                                                ->where('status', 'success')
                                                ->where('is_user_read', false)
                                                ->count();

                                        @endphp


                                        @if ($unreadCount > 0)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                style="font-size:8px;">

                                                {{ $unreadCount }}

                                            </span>
                                        @endif

                                    </a>


                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown"
                                        style="width:300px;">


                                        <li>

                                            <h6 class="dropdown-header fw-bold">

                                                Notifications

                                            </h6>

                                        </li>


                                        @php

                                            $recentNotis = \App\Models\Contact::where('user_id', auth()->id())
                                                ->latest()
                                                ->take(5)
                                                ->get();

                                        @endphp


                                        @forelse ($recentNotis as $noti)
                                            <li>

                                                <a class="dropdown-item py-2" href="{{ route('user.notifications') }}">

                                                    <div class="d-flex justify-content-between align-items-center">

                                                        <small class="fw-semibold">

                                                            {{ $noti->name ?? 'Unknown Name' }}

                                                        </small>


                                                        <span
                                                            class="badge bg-{{ $noti->status == 'success' ? 'success' : 'warning text-dark' }}">

                                                            {{ ucfirst($noti->status) }}

                                                        </span>

                                                    </div>


                                                    <small class="text-muted">

                                                        {{ Str::limit($noti->subject, 30) }}

                                                    </small>

                                                </a>

                                            </li>

                                        @empty

                                            <li>

                                                <span class="dropdown-item text-center py-3 text-muted">

                                                    No notifications

                                                </span>

                                            </li>
                                        @endforelse


                                        <li>

                                            <a class="dropdown-item text-center text-primary fw-semibold"
                                                href="{{ route('user.notifications') }}">

                                                View All Notifications

                                            </a>

                                        </li>

                                    </ul>

                                </li>

                            @endif


                            {{-- =================================================
                                ACCOUNT
                            ================================================== --}}

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle ucsm-account-link" href="#"
                                    id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    <i class="lni lni-user me-1"></i>

                                    Account

                                </a>


                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">


                                    <li>

                                        <a class="dropdown-item py-2" href="{{ route('user.profile') }}">

                                            <i class="lni lni-user me-2 text-primary"></i>

                                            Profile

                                        </a>

                                    </li>


                                    <li>

                                        <a class="dropdown-item py-2" href="{{ route('user.password.change') }}">

                                            <i class="lni lni-lock me-2 text-warning"></i>

                                            Change Password

                                        </a>

                                    </li>


                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>


                                    <li>

                                        <form action="{{ route('logout') }}" method="POST" class="px-2 py-1">

                                            @csrf

                                            <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill">

                                                <i class="lni lni-power-switch me-1"></i>

                                                Logout

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </li>


                        </ul>

                    </div>

                </nav>

            </div>

        </div>

    </header>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <main>

        @yield('content')

    </main>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}

    <footer class="ucsm-footer">

        <div class="container text-center">

            <p>

                © 2026 University of Computer Studies, Magway.
                All rights reserved.

            </p>

        </div>

    </footer>


    {{-- =========================================================
        JAVASCRIPT
    ========================================================== --}}

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>

    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>

    <script src="{{ asset('user/js/wow.min.js') }}"></script>

    <script src="{{ asset('user/js/main.js') }}"></script>

    @stack('scripts')


</body>

</html>
