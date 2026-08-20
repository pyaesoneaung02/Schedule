<!DOCTYPE html>
<html class="no-js" lang="">

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>
        UCSMGY Portal - University of Computer Studies, Magway
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">


    {{-- =========================================================
        CSS
    ========================================================== --}}

    <link rel="stylesheet"
        href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('user/css/LineIcons.2.0.css') }}">

    <link rel="stylesheet"
        href="{{ asset('user/css/tiny-slider.css') }}">

    <link rel="stylesheet"
        href="{{ asset('user/css/animate.css') }}">

    <link rel="stylesheet"
        href="{{ asset('user/css/lindy-uikit.css') }}">



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
                linear-gradient(
                    135deg,
                    #1769e0,
                    #0b4ca8
                );

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

            padding: 0 15px !important;

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

            transform: scaleX(0);

            transition:
                transform .25s ease;

        }


        .ucsm-navbar .nav-link:hover {

            color: #1769e0 !important;

        }


        .ucsm-navbar .nav-link:hover::after {

            transform: scaleX(1);

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
           NOTIFICATION BUTTON
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

            position: relative;

        }


        .ucsm-notification::after {

            display: none;

        }


        .ucsm-notification:hover {

            background: #edf5ff;

        }


        .ucsm-notification i {

            font-size: 18px;

            color: #1769e0;

        }



        /* =====================================================
           NOTIFICATION BADGE
        ===================================================== */

        .ucsm-notification-badge {

            position: absolute;

            top: -3px;

            right: -3px;

            min-width: 17px;

            height: 17px;

            padding: 0 4px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50px;

            background: #dc3545;

            color: #ffffff;

            font-size: 8px;

            font-weight: 700;

            border: 2px solid #ffffff;

        }



        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        .ucsm-notification-dropdown {

            width: 340px;

            margin-top: 10px !important;

            padding: 0 !important;

            overflow: hidden;

            border: 1px solid #edf1f6 !important;

            border-radius: 14px !important;

            box-shadow:
                0 18px 45px rgba(20, 50, 90, .12) !important;

        }


        .ucsm-notification-header {

            padding: 15px 17px;

            background: #ffffff;

            border-bottom: 1px solid #edf1f6;

        }


        .ucsm-notification-header h6 {

            margin: 0;

            color: #17253a;

            font-size: 13px;

            font-weight: 700;

        }


        .ucsm-notification-header small {

            color: #8a96a6;

            font-size: 10px;

        }



        /* =====================================================
           NOTIFICATION ITEM
        ===================================================== */

        .ucsm-notification-item {

            display: block;

            padding: 13px 15px;

            text-decoration: none !important;

            border-bottom: 1px solid #f0f2f5;

            background: #ffffff;

            transition:
                background .2s ease;

        }


        .ucsm-notification-item:hover {

            background: #f7faff;

        }


        .ucsm-notification-item.unread {

            background: #f3f8ff;

        }


        .ucsm-notification-title {

            color: #26364d;

            font-size: 11px;

            font-weight: 700;

        }


        .ucsm-notification-message {

            margin-top: 4px;

            color: #64748b;

            font-size: 10px;

            line-height: 1.5;

        }


        .ucsm-notification-date {

            margin-top: 5px;

            color: #9aa5b4;

            font-size: 9px;

        }



        /* =====================================================
           STATUS BADGES
        ===================================================== */

        .ucsm-status {

            display: inline-flex;

            align-items: center;

            padding: 4px 8px;

            border-radius: 50px;

            font-size: 8px;

            font-weight: 700;

        }


        .ucsm-status-pending {

            color: #856404;

            background: #fff3cd;

        }


        .ucsm-status-accepted {

            color: #155724;

            background: #d4edda;

        }


        .ucsm-status-rejected {

            color: #721c24;

            background: #f8d7da;

        }



        /* =====================================================
           REPLY LABEL
        ===================================================== */

        .ucsm-reply-label {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            margin-top: 5px;

            color: #198754;

            font-size: 9px;

            font-weight: 700;

        }



        /* =====================================================
           VIEW ALL
        ===================================================== */

        .ucsm-notification-footer {

            padding: 12px;

            text-align: center;

            background: #ffffff;

        }


        .ucsm-notification-footer a {

            color: #1769e0;

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

        }


        .ucsm-notification-footer a:hover {

            color: #0b4ca8;

        }



        /* =====================================================
           DROPDOWN
        ===================================================== */

        .ucsm-navbar .dropdown-menu {

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
           HERO
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

            padding: 30px 0;

            background: #101c2d;

            color: rgba(255, 255, 255, .55);

        }


        .ucsm-footer p {

            margin: 0;

            font-size: 11px;

        }



        /* =====================================================
           MOBILE
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

                padding: 0 15px !important;

            }


            .ucsm-navbar .nav-link::after {

                display: none;

            }


            .ucsm-navbar .navbar-collapse {

                padding: 12px 0 15px;

            }


            .ucsm-navbar .nav-item {

                width: 100%;

            }


            .ucsm-brand-text strong {

                font-size: 16px;

            }


            .ucsm-notification {

                margin-left: 0;

            }


            .ucsm-notification-dropdown {

                width: 100%;

                max-width: 340px;

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

                    <a class="ucsm-brand"
                       href="{{ route('userHome') }}">

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

                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent6"
                        aria-controls="navbarSupportedContent6"
                        aria-expanded="false"
                        aria-label="Toggle navigation">

                        <span class="toggler-icon"></span>

                        <span class="toggler-icon"></span>

                        <span class="toggler-icon"></span>

                    </button>



                    {{-- =================================================
                        NAVIGATION
                    ================================================== --}}

                    <div
                        class="collapse navbar-collapse sub-menu-bar"
                        id="navbarSupportedContent6">

                        <ul class="navbar-nav ms-auto align-items-center">


                            {{-- =================================================
                                HOME
                            ================================================== --}}

                            <li class="nav-item">

                                <a class="nav-link"
                                   href="{{ route('userHome') }}">

                                    Home

                                </a>

                            </li>



                            {{-- =================================================
                                SCHEDULE
                            ================================================== --}}

                            <li class="nav-item">

                                <a class="nav-link"
                                   href="{{ route('user.schedule') }}">

                                    Schedule

                                </a>

                            </li>



                            {{-- =================================================
                                SUBJECT
                            ================================================== --}}

                            <li class="nav-item">

                                <a class="nav-link"
                                   href="{{ route('user.subject') }}">

                                    Subject

                                </a>

                            </li>



                            {{-- =================================================
                                TEACHER ONLY
                            ================================================== --}}

                            @if (auth()->check() && auth()->user()->role === 'teacher')


                                {{-- =================================================
                                    CONTACT
                                ================================================== --}}

                                <li class="nav-item">

                                    <a class="nav-link"
                                       href="{{ route('user.contact') }}">

                                        Contact

                                    </a>

                                </li>



                                {{-- =================================================
                                    NOTIFICATION
                                ================================================== --}}

                                @php

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Unread Notification Count
                                    |--------------------------------------------------------------------------
                                    |
                                    | Do NOT check status = success.
                                    | Your actual statuses are:
                                    |
                                    | pending
                                    | accepted
                                    | rejected
                                    |
                                    */

                                    $unreadCount = \App\Models\Contact::where(
                                            'user_id',
                                            auth()->id()
                                        )
                                        ->where(
                                            'is_user_read',
                                            false
                                        )
                                        ->count();


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Recent Notifications
                                    |--------------------------------------------------------------------------
                                    */

                                    $recentNotis = \App\Models\Contact::where(
                                            'user_id',
                                            auth()->id()
                                        )
                                        ->latest()
                                        ->take(5)
                                        ->get();

                                @endphp


                                <li class="nav-item dropdown">


                                    {{-- =================================================
                                        BELL BUTTON
                                    ================================================== --}}

                                    <a
                                        class="nav-link ucsm-notification position-relative"
                                        href="#"
                                        id="notificationDropdown"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        <i class="lni lni-alarm"></i>


                                        {{-- UNREAD BADGE --}}

                                        @if ($unreadCount > 0)

                                            <span class="ucsm-notification-badge">

                                                @if ($unreadCount > 99)
                                                    99+
                                                @else
                                                    {{ $unreadCount }}
                                                @endif

                                            </span>

                                        @endif

                                    </a>



                                    {{-- =================================================
                                        NOTIFICATION DROPDOWN
                                    ================================================== --}}

                                    <ul
                                        class="dropdown-menu dropdown-menu-end ucsm-notification-dropdown"
                                        aria-labelledby="notificationDropdown">


                                        {{-- HEADER --}}

                                        <li>

                                            <div class="ucsm-notification-header">

                                                <div class="d-flex justify-content-between align-items-center">

                                                    <h6>

                                                        <i class="lni lni-alarm me-1"></i>

                                                        Notifications

                                                    </h6>


                                                    @if ($unreadCount > 0)

                                                        <small>

                                                            {{ $unreadCount }}
                                                            unread

                                                        </small>

                                                    @endif

                                                </div>

                                            </div>

                                        </li>



                                        {{-- =================================================
                                            NOTIFICATION LIST
                                        ================================================== --}}

                                        @forelse ($recentNotis as $noti)

                                            <li>

                                                <a
                                                    href="{{ route('user.notifications') }}"
                                                    class="ucsm-notification-item
                                                        {{ !$noti->is_user_read ? 'unread' : '' }}">


                                                    {{-- TOP --}}

                                                    <div class="d-flex justify-content-between align-items-center">

                                                        <span class="ucsm-notification-title">

                                                            {{ $noti->subject ?? 'Contact Message' }}

                                                        </span>


                                                        {{-- STATUS --}}

                                                        @if ($noti->status === 'pending')

                                                            <span class="ucsm-status ucsm-status-pending">

                                                                Pending

                                                            </span>

                                                        @elseif ($noti->status === 'accepted')

                                                            <span class="ucsm-status ucsm-status-accepted">

                                                                Accepted

                                                            </span>

                                                        @elseif ($noti->status === 'rejected')

                                                            <span class="ucsm-status ucsm-status-rejected">

                                                                Rejected

                                                            </span>

                                                        @else

                                                            <span class="ucsm-status">

                                                                {{ ucfirst($noti->status ?? 'Unknown') }}

                                                            </span>

                                                        @endif

                                                    </div>



                                                    {{-- =================================================
                                                        REPLY
                                                    ================================================== --}}

                                                    @if (!empty($noti->reply_message))

                                                        <div class="ucsm-reply-label">

                                                            <i class="lni lni-reply"></i>

                                                            Admin replied to your message

                                                        </div>

                                                    @endif



                                                    {{-- MESSAGE --}}

                                                    <div class="ucsm-notification-message">

                                                        {{ Str::limit(
                                                            $noti->message ?? '',
                                                            55
                                                        ) }}

                                                    </div>



                                                    {{-- DATE --}}

                                                    <div class="ucsm-notification-date">

                                                        <i class="lni lni-calendar"></i>

                                                        {{ $noti->created_at
                                                            ? $noti->created_at->format('d M Y, h:i A')
                                                            : 'N/A'
                                                        }}

                                                    </div>

                                                </a>

                                            </li>

                                        @empty

                                            <li>

                                                <div class="py-4 text-center text-muted">

                                                    <i
                                                        class="mb-2 lni lni-envelope"
                                                        style="font-size: 24px;">
                                                    </i>

                                                    <div>

                                                        No notifications

                                                    </div>

                                                </div>

                                            </li>

                                        @endforelse



                                        {{-- =================================================
                                            VIEW ALL
                                        ================================================== --}}

                                        <li>

                                            <div class="ucsm-notification-footer">

                                                <a href="{{ route('user.notifications') }}">

                                                    View All Notifications

                                                    <i class="lni lni-arrow-right"></i>

                                                </a>

                                            </div>

                                        </li>

                                    </ul>

                                </li>

                            @endif



                            {{-- =================================================
                                ACCOUNT
                            ================================================== --}}

                            <li class="nav-item dropdown">

                                <a
                                    class="nav-link dropdown-toggle ucsm-account-link"
                                    href="#"
                                    id="accountDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                    <i class="lni lni-user me-1"></i>

                                    Account

                                </a>


                                <ul
                                    class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="accountDropdown">


                                    {{-- PROFILE --}}

                                    <li>

                                        <a
                                            class="dropdown-item py-2"
                                            href="{{ route('user.profile') }}">

                                            <i class="lni lni-user me-2 text-primary"></i>

                                            Profile

                                        </a>

                                    </li>



                                    {{-- CHANGE PASSWORD --}}

                                    <li>

                                        <a
                                            class="dropdown-item py-2"
                                            href="{{ route('user.password.change') }}">

                                            <i class="lni lni-lock me-2 text-warning"></i>

                                            Change Password

                                        </a>

                                    </li>



                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>



                                    {{-- LOGOUT --}}

                                    <li>

                                        <form
                                            action="{{ route('logout') }}"
                                            method="POST"
                                            class="px-2 py-1">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm w-100 rounded-pill">

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
