@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-gauge-high"></i>
                Dashboard

            </h2>

            <p class="mb-0 text-muted">
                University Schedule Management Dashboard.
            </p>

        </div>


        <!-- Cards Row -->
        <div class="row">


            <!-- Teachers -->
            <div class="mb-4 col-xl-3 col-md-6">

                <div class="border-0 shadow-sm card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="mb-2 text-uppercase text-primary fw-bold">
                                    Teachers
                                </h6>

                                <h3 class="mb-0 fw-bold">
                                    {{ $teacherCount }}
                                </h3>

                            </div>

                            <div>
                                <i class="text-primary fa-solid fa-person-chalkboard fa-3x"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>




            <!-- Years -->
            <div class="mb-4 col-xl-3 col-md-6">

                <div class="border-0 shadow-sm card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="mb-2 text-uppercase text-success fw-bold">
                                    Years
                                </h6>

                                <h3 class="mb-0 fw-bold">
                                    {{ $yearCount }}
                                </h3>

                            </div>


                            <div>

                                <i class="text-success fa-solid fa-calendar-days fa-3x"></i>

                            </div>


                        </div>

                    </div>

                </div>

            </div>





            <!-- Departments -->
            <div class="mb-4 col-xl-3 col-md-6">

                <div class="border-0 shadow-sm card h-100">

                    <div class="card-body">


                        <div class="d-flex justify-content-between align-items-center">


                            <div>

                                <h6 class="mb-2 text-uppercase text-info fw-bold">
                                    Departments
                                </h6>


                                <h3 class="mb-0 fw-bold">
                                    {{ $departmentCount }}
                                </h3>


                            </div>


                            <div>

                                <i class="text-info fa-solid fa-graduation-cap fa-3x"></i>

                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <!-- Subjects -->
            <div class="mb-4 col-xl-3 col-md-6">


                <div class="border-0 shadow-sm card h-100">


                    <div class="card-body">


                        <div class="d-flex justify-content-between align-items-center">


                            <div>

                                <h6 class="mb-2 text-uppercase text-warning fw-bold">
                                    Subjects
                                </h6>


                                <h3 class="mb-0 fw-bold">
                                    {{ $subjectCount }}
                                </h3>


                            </div>



                            <div>
                                <i class="text-warning fa-solid fa-book fa-3x"></i>
                            </div>



                        </div>


                    </div>


                </div>


            </div>


        </div>





        <!-- Quick Menu -->

        <div class="mt-4 row">


            <div class="mb-4 col-md-4">

                <a href="{{ route('teacher.create') }}" class="text-decoration-none">

                    <div class="text-white shadow-sm card bg-primary">

                        <div class="py-4 text-center card-body">

                            <i class="mb-2 fa-solid fa-person-chalkboard fa-2x"></i>

                            <h5 class="mb-0">
                                Manage Teachers
                            </h5>

                        </div>

                    </div>

                </a>

            </div>



            <div class="mb-4 col-md-4">

                <a href="{{ route('subject.create') }}" class="text-decoration-none">

                    <div class="text-white shadow-sm card bg-success">


                        <div class="py-4 text-center card-body">


                            <i class="mb-2 fa-solid fa-book fa-2x"></i>


                            <h5 class="mb-0">
                                Manage Subjects
                            </h5>


                        </div>


                    </div>


                </a>

            </div>




            <div class="mb-4 col-md-4">


                <a href="{{ route('schedule.create') }}" class="text-decoration-none">


                    <div class="text-white shadow-sm card bg-info">


                        <div class="py-4 text-center card-body">


                            <i class="mb-2 fa-solid fa-calendar-days fa-2x"></i>


                            <h5 class="mb-0">
                                Create Schedule
                            </h5>


                        </div>


                    </div>


                </a>


            </div>


        </div>


    </div>
@endsection
