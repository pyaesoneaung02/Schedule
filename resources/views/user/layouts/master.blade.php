<!DOCTYPE html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Teacher Portal - University of Computer Studies, Magway</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/lindy-uikit.css') }}" />

    <style>
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #4a5568;
            border: none;
            padding: 12px 24px;
            margin: 0 5px;
            border-radius: 50px;
            background: #f4f7fc;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: #0067f4;
            box-shadow: 0 4px 10px rgba(0, 103, 244, 0.3);
        }

        .timetable-table th {
            background-color: #0067f4;
            color: #fff;
            font-weight: 500;
        }

        .timetable-table td {
            vertical-align: middle;
            padding: 15px;
            background: #fff;
            border-color: #e2e8f0;
        }

        .subject-title {
            font-weight: 600;
            color: #2d3748;
            display: block;
        }

        .room-no {
            font-size: 13px;
            color: #718096;
        }

        .ucsm-brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-left: 10px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>

    <!-- ========================= Navbar ========================= -->
    <header class="header header-6 bg-white shadow-sm mb-4">
        <div class="navbar-area">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('userHome') }}">
                        <span class="ucsm-brand-text">UCSMGY</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent6">
                        <span class="toggler-icon"></span><span class="toggler-icon"></span><span
                            class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent6">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item"><a class="nav-link" href="{{ route('userHome') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.schedule') }}">Schedule</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.subject') }}">Subject</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.contact') }}">Contact</a></li>

                            <!-- Account Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-semibold text-primary" href="#"
                                    id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="lni lni-user me-1"></i> Account
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2"
                                    aria-labelledby="accountDropdown">
                                    <li><a class="dropdown-item py-2" href="{{ route('user.profile') }}"><i
                                                class="lni lni-user me-2 text-primary"></i> Profile</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('user.password.change') }}"><i
                                                class="lni lni-lock me-2 text-warning"></i> Change Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill"><i
                                                    class="lni lni-power-switch me-1"></i> Logout</button>
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

    <!-- ========================= Main Content Area ========================= -->
    <main>
        @yield('content')
    </main>

    <!-- ========================= Footer ========================= -->
    <footer class="footer footer-style-4 bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">© 2026 University of Computer Studies, Magway. All rights reserved.</p>
        </div>
    </footer>

    <!-- ========================= JS ========================= -->
    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
</body>

</html>
