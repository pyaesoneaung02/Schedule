<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About - University Subject Portal</title>


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {

            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;

        }


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


        .about-card {

            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            transition: .3s;

        }


        .about-card:hover {

            transform: translateY(-5px);

        }


        .icon-box {

            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #4b5cff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;

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


            <a class="navbar-brand" href="#">

                🎓 University Subject Portal

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


    <!-- About Section -->


    <div class="container py-5">


        <div class="mb-5 text-center">


            <h2 class="fw-bold">

                🎓 About University Subject Portal

            </h2>


            <p class="text-muted">

                A simple platform to explore and manage university subjects.

            </p>


        </div>



        <div class="row g-4">



            <div class="col-lg-4 col-md-6">


                <div class="p-4 text-center card about-card">


                    <div class="mb-3 icon-box">

                        <i class="bi bi-building"></i>

                    </div>


                    <h5>

                        University Information

                    </h5>


                    <p class="text-muted">

                        This portal provides university subject information
                        for students and teachers.

                    </p>


                </div>


            </div>




            <div class="col-lg-4 col-md-6">


                <div class="p-4 text-center card about-card">


                    <div class="mb-3 icon-box">

                        <i class="bi bi-book"></i>

                    </div>


                    <h5>

                        Subject Management

                    </h5>


                    <p class="text-muted">

                        Students can easily view available subjects,
                        majors, academic years and course details.

                    </p>


                </div>


            </div>




            <div class="col-lg-4 col-md-6">


                <div class="p-4 text-center card about-card">


                    <div class="mb-3 icon-box">

                        <i class="bi bi-people"></i>

                    </div>


                    <h5>

                        Student Support

                    </h5>


                    <p class="text-muted">

                        Helping students find useful academic
                        information quickly and easily.

                    </p>


                </div>


            </div>


        </div>




        <!-- Mission -->

        <div class="p-5 mt-5 card about-card">


            <h3 class="fw-bold">

                🚀 Our Mission

            </h3>


            <p class="mt-3 text-muted">

                University Subject Portal aims to provide a modern,
                user-friendly platform for managing and discovering
                academic subjects. It helps students access subject
                information efficiently and improves academic planning.

            </p>


        </div>



    </div>




    <!-- Footer -->

    <footer class="py-4 text-white" style="background:linear-gradient(90deg,#4b5cff,#7a3cff);">


        <div class="container text-center">


            <h5 class="fw-bold">

                🎓 University Subject Portal

            </h5>


            <p>

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

                © {{ date('Y') }} University Subject Portal. All Rights Reserved.

            </small>


        </div>


    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
