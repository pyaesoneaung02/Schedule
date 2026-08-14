<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UCSMG</title>


    <!-- Bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {

            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;

        }


        /* Navbar */

        .navbar {

            background: linear-gradient(90deg, #4b5cff, #7a3cff);

        }


        .navbar-brand {

            color: white;
            font-weight: bold;
            font-size: 22px;

        }


        .nav-link {

            color: white !important;

        }

        /* Statistic Card */


        .stat-card {

            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            transition: .3s;

        }


        .stat-card:hover {

            transform: translateY(-5px);

        }

        .stat-number {

            font-size: 35px;
            font-weight: bold;
            color: #4b5cff;

        }

        /* Subject Card */


        .subject-card {

            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            transition: .3s;
            height: 100%;

        }


        .subject-card:hover {

            transform: translateY(-8px);

        }

        /* Same Image Size */


        .subject-card img {

            width: 100%;
            height: 180px;
            object-fit: cover;
            object-position: center;

        }

        .subject-card .card-body {

            display: flex;
            flex-direction: column;

        }

        .subject-card .card-body .btn-group {

            margin-top: auto;

        }

        .section-title {

            font-weight: 700;
            color: #444;

        }

        footer a {

            text-decoration: none;
            transition: .3s;

        }


        footer a:hover {

            opacity: .7;
            transform: translateY(-3px);

        }
    </style>


</head>



<body>




    <!-- Navbar -->


    <nav class="navbar navbar-expand-lg">


        <div class="container">


            <a class="navbar-brand" href="#">

                🎓 UCSMG

            </a>



            <button class="bg-white navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">


                <span class="navbar-toggler-icon"></span>


            </button>



            <div class="collapse navbar-collapse" id="navbarMenu">


                <ul class="navbar-nav ms-auto">


                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('landingPage') }}">

                            <i class="bi bi-house-fill"></i>

                            Home

                        </a>

                    </li>



                    <li class="nav-item">

                        <a class="nav-link active" href="{{ route('about') }}">

                            <i class="bi bi-info-circle"></i>

                            About Us

                        </a>

                    </li>


                    <li class="mt-2 nav-item ms-lg-3 mt-lg-0">

                        <a href="{{ route('login') }}" class="px-4 btn btn-light rounded-pill">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Login

                        </a>

                    </li>



                </ul>


            </div>



        </div>


    </nav>

    <div class="container py-5">



        <h3 class="mb-4 section-title">

            📚 Learning Subjects

        </h3>

        <!-- Statistics -->


        <div class="mb-5 row g-4">



            <div class="col-lg-3 col-md-6">


                <div class="p-4 text-center card stat-card">


                    <div class="stat-number">

                        {{ count($subjects) }}

                    </div>


                    <small>

                        Total Subjects

                    </small>


                </div>


            </div>

            <div class="col-lg-3 col-md-6">


                <div class="p-4 text-center card stat-card">


                    <div class="stat-number">

                        {{ $teachers->count() }}

                    </div>


                    <small>

                        Teachers

                    </small>


                </div>


            </div>

            <div class="col-lg-3 col-md-6">


                <div class="p-4 text-center card stat-card">


                    <div class="stat-number">

                        {{ count($majors ?? []) }}

                    </div>


                    <small>

                        Total Majors

                    </small>


                </div>


            </div>

            <div class="col-lg-3 col-md-6">


                <div class="p-4 text-center card stat-card">


                    <div class="stat-number">

                        {{ count($years) }}

                    </div>


                    <small>

                        Years

                    </small>


                </div>


            </div>




        </div>

        <!-- Filter -->

        <div class="mb-4">

            <!-- All -->
            <a href="{{ route('landingPage') }}"
                class="px-4 btn rounded-pill
               {{ $selectedYear == null ? 'btn-primary' : 'btn-outline-secondary' }}">

                📚 All

            </a>


            @foreach ($years as $year)
                <a href="{{ route('subject.filter.year', $year->id) }}"
                    class="px-4 btn rounded-pill
                   {{ $selectedYear && $selectedYear->id == $year->id ? 'btn-primary' : 'btn-outline-secondary' }}">

                    🎓 {{ $year->name }}

                </a>
            @endforeach

        </div>

        <!-- Subject Cards -->

        <div class="row g-4">


            @foreach ($subjects as $subject)
                <div class="col-lg-2 col-md-4 col-sm-6">


                    <div class="card subject-card h-100">


                        @if ($subject->image)
                            <img src="{{ asset($subject->image) }}" class="card-img-top">
                        @else
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3"
                                class="card-img-top">
                        @endif



                        <div class="card-body d-flex flex-column">


                            <h6>

                                {{ $subject->long_name }}

                            </h6>



                            <small class="text-muted mb-3">

                                {{ $subject->year->name ?? 'Year' }}
                                |
                                {{ $subject->major->name ?? 'Major' }}

                            </small>




                            {{-- <div class="my-3 text-primary">


                                <i class="bi bi-clock"></i>

                                {{ $subject->time_number }} Credit Hours


                            </div> --}}



                            <div class="gap-2 mt-auto d-grid">


                                <a href="{{ route('subject.detail', $subject->id) }}"
                                    class="btn btn-outline-primary btn-sm">


                                    <i class="bi bi-book"></i>

                                    View Subject


                                </a>





                                <form action="{{ route('subject.delete', $subject->id) }}" method="POST">


                                    @csrf

                                    @method('DELETE')



                                    {{-- <button type="submit" class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Delete this subject?')">


                                        <i class="bi bi-trash"></i>

                                        Remove


                                    </button> --}}



                                </form>



                            </div>



                        </div>



                    </div>


                </div>
            @endforeach


        </div>



    </div>


    <!-- Footer -->

    <footer class="py-4 mt-5 text-white" style="background:linear-gradient(90deg,#4b5cff,#7a3cff);">

        <div class="container text-center">

            <h5 class="fw-bold">
                🎓 University Subject Portal
            </h5>

            <p class="mb-2">
                University of Computer Studies (Magway)
            </p>

            <div class="mb-3">

                <a href="#" class="mx-2 text-white">
                    <i class="bi bi-facebook fs-5"></i>
                </a>

                <a href="#" class="mx-2 text-white">
                    <i class="bi bi-github fs-5"></i>
                </a>

                <a href="#" class="mx-2 text-white">
                    <i class="bi bi-envelope fs-5"></i>
                </a>

            </div>


            <hr class="border-light">


            <small>

                © {{ now()->year }} University Subject Portal. All Rights Reserved.

            </small>


        </div>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
