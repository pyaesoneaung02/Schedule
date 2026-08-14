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

    {{-- <style>
        .timetable-info{
            width:100%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:10px;
        }

        .left-info{
            text-align:left;
            font-weight:bold;
        }

        .right-info{
            text-align:right;
            font-weight:bold;
        }

        .table-header th {
            background-color: #6c757d !important;
            color: white !important;
        }


        .day-cell {
            background-color: #6c757d !important;
            color: white !important;
        }


        .lunch-cell {
            background-color: #dee2e6 !important;
        }


        @media print {

            .table-header th {
                background-color: #6c757d !important;
                color: white !important;
            }


            .day-cell {
                background-color: #6c757d !important;
                color: white !important;
            }


            .lunch-cell {
                background-color: #dee2e6 !important;
            }

        }


        @media print{

            .timetable-info{
                display:flex !important;
                justify-content:space-between !important;
                width:100% !important;
            }

            .left-info{
                float:left;
            }

            .right-info{
                float:right;
            }

        }

        @media print {

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            th,
            td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

        }
    </style> --}}

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
                <a class="nav-link" href="{{ route('adminHome') }}"><i class="mr-3 fa-solid fa-gauge-high"></i><span>Dashboard</span></a>
            </li>

            <li class="nav-item">

                <a class="nav-link d-flex align-items-center justify-content-between collapsed"
                    href="#"
                    data-toggle="collapse"
                    data-target="#componentMenu"
                    aria-expanded="false"
                    aria-controls="componentMenu">

                    <span>
                        <i class="mr-2 fa-solid fa-puzzle-piece"></i>
                        Academic Setup
                    </span>

                    <span>
                        {{-- <span class="badge badge-danger">6</span> --}}
                        <i class="ml-2 fas fa-chevron-down small"></i>
                    </span>

                </a>


                <ul id="componentMenu"
                    class="collapse list-unstyled"
                    aria-labelledby="headingComponent"
                    data-parent="#accordionSidebar">

                     <li>
                        <a class="text-white nav-link small" href="{{(route('academicYear.list'))}}">
                            <i class="mr-3 fa-solid fa-calendar"></i>
                            Academic Years
                        </a>
                    </li>


                    <li>
                        <a class="text-white nav-link small" href="{{ route('year#list') }}">
                            <i class="mr-3 fa-solid fa-calendar"></i>
                            Class Years
                        </a>
                    </li>

                     <li>
                        <a class="text-white nav-link small" href="{{ route('semester.list') }}">
                            <i class="mr-3 fa-solid fa-table-columns"></i>
                            Semesters
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{{ route('major.list')}}}"><i class="mr-3 fa-solid fa-building-columns"></i><span>Majors</span></a>
                    </li>

                    <li>
                        <a class="text-white nav-link small" href="{{ route('section.list') }}">
                            <i class="mr-3 fa-solid fa-layer-group"></i>
                            Sections
                        </a>
                    </li>

                    <li>
                        <a class="text-white nav-link small" href="{{ route('day.list') }}">
                            <i class="mr-3 fa-solid fa-calendar-days"></i>
                            Days
                        </a>
                    </li>

                    <li>
                        <a class="text-white nav-link small" href="{{ route('time.list') }}">
                            <i class="mr-3 fa-solid fa-clock"></i>
                            Time Slots
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

                    <span class="mr-3">
                        <i class="mr-2 fa-solid fa-toolbox"></i>
                        Configuration
                    </span>

                    <span>
                        {{-- <span class="badge badge-danger">3</span> --}}
                        <i class="ml-2 fas fa-chevron-down small"></i>
                    </span>

                </a>


                <ul id="accessoriesMenu"
                    class="collapse list-unstyled"
                    aria-labelledby="headingAccessories"
                    data-parent="#accordionSidebar">

                    <li>
                        <a class="text-white nav-link small" href="{{ route('department.list') }}">
                            <i class="mr-3 fa-solid fa-graduation-cap"></i>
                            Departments
                        </a>
                    </li>

                    <li>
                        <a class="text-white nav-link small" href="{{ route('position.list') }}">
                            <i class="mr-3 fa-solid fa-user-tie"></i>
                            Positions
                        </a>
                    </li>

                    <li>
                        <a class="text-white nav-link small" href="{{{ route('room.create')}}}">
                            <i class="mr-3 fa-solid fa-door-open"></i>
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

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{{ route('room.create')}}}"><i class="mr-3 fa-solid fa-door-open"></i><span>Room</span></a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('department.list') }}"><i class="fa-solid fa-graduation-cap"></i><span>Department</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('position.list') }}"><i class="fa-solid fa-user-tie"></i><span>Position</span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.create') }}"><i class="mr-3 fa-solid fa-chalkboard-user"></i><span>Teachers</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('subject.create') }}"><i class="mr-3 fa-solid fa-book"></i><span>Subjects</span></a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('time.list') }}"><i class="fa-solid fa-clock"></i><span>Time</span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teaching.create') }}"><i class="mr-3 fa-solid fa-chalkboard"></i><span>Teaching Assignments</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('schedule.autoGenerate') }}"><i class="mr-3 fa-solid fa-calendar-days"></i><span>Auto Generate Timetable</span></a>
            </li>

            @if (auth()->check() && auth()->user()->role == 'superadmin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('schedule.create') }}"><i class="mr-3 fa-solid fa-calendar-days"></i><span>Schedule Management</span></a>
            </li>

             <li class="nav-item">
                <a class="nav-link" href="{{ route('schedule.timeTable') }}"><i class="mr-3 fa-solid fa-calendar-days"></i>Timetables</span></a>
            </li>
            @endif

             <li class="nav-item">
                <a class="nav-link" href="{{ route('contact.list') }}"><i class="mr-3 fa-solid fa-comment"></i><span>Contact Messages</span></a>
            </li>

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

                <!-- ================= TOPBAR ================= -->
                <nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">

                    <!-- Topbar Navbar -->
                    <ul class="ml-auto navbar-nav">


                        <!-- notification start-->
                        @php
                            $unreadContacts = \App\Models\Contact::where('status', 'pending')
                                ->latest()
                                ->take(5)
                                ->get();

                            $unreadCount = \App\Models\Contact::where('status', 'pending')
                                ->count();
                        @endphp

                        <li class="nav-item dropdown no-arrow mx-2">

                            <a class="nav-link dropdown-toggle"
                               href="#"
                               id="notificationDropdown"
                               role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">

                                <i class="fas fa-bell fa-fw"></i>

                                @if($unreadCount > 0)
                                    <span class="badge badge-danger badge-counter">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif

                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="notificationDropdown">

                                <h6 class="dropdown-header bg-primary text-white">
                                    <i class="fas fa-bell mr-2"></i>
                                    Notifications
                                </h6>

                                @forelse($unreadContacts as $contact)

                                    <a class="dropdown-item d-flex align-items-center"
                                       href="{{ route('contact.read', $contact->id) }}">

                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-comment text-white"></i>
                                            </div>
                                        </div>

                                        <div>

                                            <div class="small text-gray-500">
                                                {{ $contact->created_at->format('d M Y, h:i A') }}
                                            </div>

                                            <span class="font-weight-bold">
                                                {{ $contact->name }}
                                            </span>

                                            <div class="small text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($contact->message, 40) }}
                                            </div>

                                        </div>

                                    </a>

                                @empty

                                    <div class="text-center dropdown-item">
                                        <span class="text-muted">
                                            No new notifications
                                        </span>
                                    </div>

                                @endforelse

                                <a href="{{ route('contact.list') }}"
                                   class="text-center dropdown-item small text-primary">

                                    View All Messages

                                </a>

                            </div>

                        </li>

                        <!-- notification end-->

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
                                        Create Administrator
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile.adminList') }}">
                                        <i class="mr-2 text-dark fa-solid fa-graduation-cap fa-sm fa-fw"></i>
                                        Administrators
                                    </a>
                                @endif
                                   <a class="dropdown-item" href="{{ route('profile.userList')}}">
                                    {{-- <i class="mr-2 text-dark fa-solid fa-user-graduate fa-sm fa-fw"></i> --}}
                                    <i class="mr-2 text-dark fa-solid fa-users fa-sm fa-fw"></i>
                                    Users
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
                <!-- ================= END TOPBAR ================= -->

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

    <!-- Word Editor -->
    <script src="https://cdn.tiny.cloud/1/cxfmq7z44c9ld3ajd9mhnol91kopl886kwjehdhk0ompr4nj/tinymce/8/tinymce.min.js"
        referrerpolicy="origin"></script>
    @stack('scripts')

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
