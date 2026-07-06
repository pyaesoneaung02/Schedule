@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Teachers Card Example -->
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-primary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                    Teachers</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $teacherCount }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="text-gray-300 fas fa-calendar fa-2x"></i> --}}
                                <i class="text-gray-950 fa-solid fa-person-chalkboard fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Years Card Example -->
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                    Years</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $yearCount }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="text-gray-300 fas fa-dollar-sign fa-2x"></i> --}}
                                <i class="text-gray-950 fa-solid fa-calendar fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments Card Example -->
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-info h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">Departments
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="mb-0 mr-3 text-gray-800 h5 font-weight-bold">{{ $departmentCount }}</div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="mr-2 progress progress-sm">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="text-gray-300 fas fa-clipboard-list fa-2x"></i> --}}
                                <i class="text-gray-950 fa-solid fa-graduation-cap fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects Card Example -->
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-warning h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-warning text-uppercase">
                                    Subjects</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $subjectCount }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="text-gray-300 fas fa-comments fa-2x"></i> --}}
                                <i class="text-gray-950 fa-solid fa-book-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="rounded scroll-to-top" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>


                </div>
            </div>
        </div>
    @endsection
