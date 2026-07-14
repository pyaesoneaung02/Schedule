<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Schedule Admin</title>
    <link rel="icon" type="image/jfif" href="{{ asset('admin/img/icon.jfif') }}">

    <!-- Font Awesome (load only one version) -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="mx-3 sidebar-brand-text">Schedule Admin</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('adminHome') }}"><i class="fa-solid fa-gauge-high mr-3"></i><span>Dashboard</span></a>
            </li>

            <li class="nav-item">

                <a class="nav-link d-flex align-items-center justify-content-between collapsed"
                    href="#"
                    data-toggle="collapse"
                    data-target="#componentMenu"
                    aria-expanded="false"
                    aria-controls="componentMenu">

                    <span>
                        <i class="fa-solid fa-puzzle-piece mr-2"></i>
                        Component
                    </span>

                    <span>
                        <span class="badge badge-danger">5</span>
                        {{-- <i class="fas fa-chevron-down small ml-2"></i> --}}
                    </span>

                </a>


                <ul id="componentMenu"
                    class="collapse list-unstyled"
                    aria-labelledby="headingComponent"
                    data-parent="#accordionSidebar">

                    <li>
                        <a class="nav-link text-white small" href="{{ route('day.list') }}">
                            <i class="fa-solid fa-calendar-days mr-3"></i>
                            Days
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{ route('year#list') }}">
                            <i class="fa-solid fa-calendar mr-3"></i>
                            Years
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{ route('department.list') }}">
                            <i class="fa-solid fa-graduation-cap mr-3"></i>
                            Departments
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{ route('position.list') }}">
                            <i class="fa-solid fa-user-tie mr-3"></i>
                            Positions
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{ route('time.list') }}">
                            <i class="fa-solid fa-clock mr-3"></i>
                            Times
                        </a>
                    </li>

                </ul>

            </li>

            <li class="nav-item">

                <a class="nav-link d-flex align-items-center justify-content-between collapsed"
                    href="#"
                    data-toggle="collapse"
                    data-target="#accessoriesMenu"
                    aria-expanded="false"
                    aria-controls="accessoriesMenu">

                    <span>
                        <i class="fa-solid fa-toolbox mr-2"></i>
                        Accessories
                    </span>

                    <span>
                        <span class="badge badge-danger">3</span>
                        {{-- <i class="fas fa-chevron-down small ml-2"></i> --}}
                    </span>

                </a>


                <ul id="accessoriesMenu"
                    class="collapse list-unstyled"
                    aria-labelledby="headingAccessories"
                    data-parent="#accordionSidebar">

                    <li>
                        <a class="nav-link text-white small" href="{{ route('semester.list') }}">
                            <i class="fa-solid fa-table-columns mr-3"></i>
                            Semesters
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{ route('section.list') }}">
                            <i class="fa-solid fa-layer-group mr-3"></i>
                            Sections
                        </a>
                    </li>

                    <li>
                        <a class="nav-link text-white small" href="{{{ route('room.create')}}}">
                            <i class="fa-solid fa-door-open mr-3"></i>
                            Rooms
                        </a>
                    </li>

                </ul>

            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('day.list') }}"><i class="fa-solid fa-calendar-days"></i><span>Day
                    </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('year#list') }}"><i class="fa-solid fa-calendar"></i><span>Year
                    </span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{{ route('major.create')}}}"><i class="fa-solid fa-building-columns mr-3"></i><span>Majors</span></a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{{ route('room.create')}}}"><i class="fa-solid fa-door-open mr-3"></i><span>Room</span></a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('department.list') }}"><i class="fa-solid fa-graduation-cap"></i><span>Department</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('position.list') }}"><i class="fa-solid fa-user-tie"></i><span>Position</span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.create') }}"><i class="fa-solid fa-chalkboard-user mr-3"></i><span>Teachers</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('subject.create') }}"><i class="fa-solid fa-book mr-3"></i><span>Subjects</span></a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('time.list') }}"><i class="fa-solid fa-clock"></i><span>Time</span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teaching.create') }}"><i class="fa-solid fa-chalkboard mr-3"></i><span>Teaching Classes</span></a>
            </li>

            @if (auth()->check() && auth()->user()->role == 'superadmin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('schedule.create') }}"><i class="fa-solid fa-calendar-days mr-3"></i><span>Schedules</span></a>
            </li>

             <li class="nav-item">
                <a class="nav-link" href="{{ route('schedule.timeTable') }}"><i class="fa-solid fa-calendar-days mr-3"></i>Time Tables</span></a>
            </li>
            @endif

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <span class="nav-link">
                        <button type="submit" class="text-white btn bg-dark"><i
                                class="fa-solid fa-right-from-bracket"></i>Logout</button>
                    </span>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">

                    <!-- Topbar Navbar -->
                    <ul class="ml-auto navbar-nav">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 text-gray-600 d-none d-lg-inline small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->profile != null ? 'profile/' . Auth::user()->profile : 'admin/img/default-profile.jpg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="shadow dropdown-menu dropdown-menu-right animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.accountProfile') }}">
                                    <i class="mr-2 text-dark fas fa-user fa-sm fa-fw"></i>
                                    Profile
                                </a>
                                @if (auth()->check() && auth()->user()->role == 'superadmin')
                                    <a class="dropdown-item" href="{{ route('profile#createNewAdminAccount') }}">
                                        <i class="mr-2 text-dark fa-solid fa-graduation-cap fa-sm fa-fw"></i>
                                        Add Admin Account
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile.adminList') }}">
                                        <i class="mr-2 text-dark fa-solid fa-graduation-cap fa-sm fa-fw"></i>
                                        Admin Account List
                                    </a>
                                @endif
                                   <a class="dropdown-item" href="{{ route('profile.userList')}}">
                                    {{-- <i class="mr-2 text-dark fa-solid fa-user-graduate fa-sm fa-fw"></i> --}}
                                    <i class="mr-2 text-dark fa-solid fa-users fa-sm fa-fw"></i>
                                    User List
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.changePassword.page') }}">
                                    <i class="mr-2 text-dark fa-solid fa-lock fa-sm fa-fw"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <span class="nav-link">
                                            <button type="submit" class="text-white btn bg-dark w-100"><i
                                                    class="fa-solid fa-right-from-bracket"></i>Logout</button>
                                        </span>
                                    </form>
                                </span>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Page Content -->
                @yield('content')

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script> --}}

    <!-- Page level custom scripts -->
    {{-- <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script> --}}

    @include('sweetalert::alert')

    <script>
        function loadFile(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById("output");
                output.src = reader.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>
