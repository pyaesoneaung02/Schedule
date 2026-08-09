<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $subject->long_name }} - Subject Detail</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {

            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;

        }


        .navbar {

            background: linear-gradient(90deg, #4b5cff, #7a3cff);

        }


        .navbar-brand,
        .nav-link {

            color: white !important;

        }


        .subject-detail-card {

            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);

        }



        .subject-image {

            width: 100%;
            height: 400px;
            object-fit: cover;

        }



        .info-card {

            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

        }


        .info-title {

            color: #4b5cff;
            font-weight: bold;

        }


        footer a {

            text-decoration: none;

        }
    </style>


</head>


<body>



    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg">


        <div class="container">


            <a class="navbar-brand fw-bold" href="{{ route('landingPage') }}">

                🎓 University Subject Portal

            </a>


            <div>

                {{-- <a href="{{ route('landingPage') }}" class="px-4 btn btn-light rounded-pill">

                    <i class="bi bi-arrow-left"></i>

                    Back

                </a> --}}

                <a href="{{ route('login') }}" class="px-4 btn btn-light rounded-pill">

                    <i class="bi bi-box-arrow-in-right"></i>

                    Login

                </a>

            </div>


        </div>


    </nav>

    <div class="container py-5">



        <div class="row g-4 align-items-center">



            <!-- Image -->


            <div class="col-lg-5">


                <div class="card subject-detail-card">


                    @if ($subject->image)
                        <img src="{{ asset($subject->image) }}" class="subject-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3" class="subject-image">
                    @endif


                </div>


            </div>

            <!-- Detail -->


            <div class="col-lg-7">


                <div class="p-4 card info-card">



                    <h2 class="mb-3 fw-bold">

                        {{ $subject->long_name }}

                    </h2>



                    <h6 class="mb-4 text-muted">

                        {{ $subject->short_name }}

                    </h6>

                    <div class="row g-3">



                        <div class="col-md-6">


                            <div class="p-3 border rounded">


                                <h6 class="info-title">

                                    <i class="bi bi-mortarboard"></i>

                                    Year

                                </h6>


                                <p class="mb-0">

                                    {{ $subject->year->name ?? 'N/A' }}

                                </p>


                            </div>


                        </div>

                        <div class="col-md-6">


                            <div class="p-3 border rounded">


                                <h6 class="info-title">

                                    <i class="bi bi-diagram-3"></i>

                                    Major

                                </h6>


                                <p class="mb-0">

                                    {{ $subject->major->name ?? 'N/A' }}

                                </p>


                            </div>


                        </div>

                        <div class="col-md-6">


                            <div class="p-3 border rounded">


                                <h6 class="info-title">

                                    <i class="bi bi-clock"></i>

                                    Credit Hours

                                </h6>


                                <p class="mb-0">

                                    {{ $subject->time_number }}

                                </p>


                            </div>


                        </div>

                        <div class="col-md-6">


                            <div class="p-3 border rounded">


                                <h6 class="info-title">

                                    <i class="bi bi-calendar"></i>

                                    Academic Year

                                </h6>


                                <p class="mb-0">

                                    {{ $subject->academicYear->name ?? 'N/A' }}

                                </p>


                            </div>


                        </div>



                    </div>

                    <hr>

                    <h5 class="fw-bold">

                        Description

                    </h5>



                    <p class="text-muted">

                        {{-- {{ $subject->description ?? 'No description available.' }} --}}
                        {!! $subject->description !!}

                    </p>

                    <div class="gap-2 mt-4 d-flex">


                        <a href="{{ route('landingPage') }}" class="px-4 btn btn-secondary rounded-pill">


                            <i class="bi bi-arrow-left"></i>

                            Back


                        </a>

                        {{-- <a href="#" class="px-4 btn btn-primary rounded-pill">


                            <i class="bi bi-book"></i>

                            Enroll Subject


                        </a> --}}


                    </div>



                </div>



            </div>



        </div>



    </div>


    <!-- Footer -->

    <footer class="py-4 mt-5 text-white" style="background:linear-gradient(90deg,#4b5cff,#7a3cff);">


        <div class="container text-center">


            <h5 class="fw-bold">

                🎓 University Subject Portal

            </h5>


            <p>

                University of Computer Studies (Magway)

            </p>


            <hr class="border-light">


            <small>

                © {{ date('Y') }} University Subject Portal. All Rights Reserved.

            </small>


        </div>


    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
