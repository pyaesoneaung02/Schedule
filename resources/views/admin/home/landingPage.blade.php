<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UCSMGY | University Subject Portal</title>


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">


    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">


    <style>
        body {

            font-family: 'Segoe UI', sans-serif;

            background: #f5f7fb;

            color: #212529;

            transition: .3s;

        }


        /* ================= Navbar ================= */

        .navbar {

            background: rgba(13, 110, 253, .9);

            backdrop-filter: blur(15px);

        }


        .navbar-brand {

            font-size: 25px;

            letter-spacing: 1px;

        }


        .nav-link {

            font-weight: 500;

        }


        .nav-link:hover {

            color: #ffc107 !important;

        }


        /* ================= Hero ================= */

        .hero {

            min-height: 650px;

            display: flex;

            align-items: center;

            color: white;


            background:

                linear-gradient(rgba(0, 0, 0, .6),
                    rgba(0, 0, 0, .6)),

                url("https://images.unsplash.com/photo-1564981797816-1043664bf78d") center/cover;

        }


        .hero h1 {

            font-size: 60px;

            font-weight: 800;

        }


        .hero span {

            color: #ffc107;

        }


        .hero p {

            font-size: 22px;

        }


        .hero .btn {

            padding: 14px 45px;

        }


        /* ================= Statistics ================= */


        .stat-box {

            background: white;

            padding: 35px;

            border-radius: 25px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);

            transition: .3s;

        }


        .stat-box:hover {

            transform: translateY(-10px);

        }


        .stat-box i {

            font-size: 45px;

            color: #0d6efd;

        }



        /* ================= Section Title ================= */


        .section-title {

            font-size: 40px;

            font-weight: 800;

        }



        /* ================= Subject Card ================= */


        .card {

            transition: .3s;

        }


        .card:hover {

            transform: translateY(-8px);

        }


        .card img {

            height: 240px;

            object-fit: cover;

        }



        /* ================= Dark Mode ================= */


        body.dark-mode {

            background: #121212;

            color: white;

        }


        /* Card */

        body.dark-mode .card,
        body.dark-mode .stat-box {

            background: #1e1e1e;

            color: white;

        }



        /* Card Text */

        body.dark-mode .card h1,
        body.dark-mode .card h2,
        body.dark-mode .card h3,
        body.dark-mode .card h4,
        body.dark-mode .card h5,
        body.dark-mode .card h6 {

            color: white;

        }



        body.dark-mode .card p {

            color: #cccccc;

        }



        /* Statistics */

        body.dark-mode .stat-box h2 {

            color: white;

        }



        body.dark-mode .stat-box p {

            color: #cccccc !important;

        }

        /* Navbar */

        body.dark-mode .navbar {

            background: #000 !important;

        }


        /* Section Title */

        body.dark-mode .section-title {

            color: white;

        }


        /* Bootstrap bg-light Fix */

        body.dark-mode .bg-light {

            background: #2a2a2a !important;

            color: white !important;

        }


        /* Bootstrap bg-white Fix */

        body.dark-mode .bg-white {

            background: #121212 !important;

        }


        /* Strong Text */

        body.dark-mode strong {

            color: white;

        }

        /* Paragraph */

        body.dark-mode p {

            color: #cccccc;

        }


        /* Muted Text */

        body.dark-mode .text-muted {

            color: #bbbbbb !important;

        }

        /* Dropdown */

        body.dark-mode .dropdown-menu {

            background: #222;

        }



        body.dark-mode .dropdown-item {

            color: white;

        }



        body.dark-mode .dropdown-item:hover {

            background: #0d6efd;

        }


        /* Button */

        body.dark-mode .btn-light {

            background: white;

            color: black;

        }

        /* Footer */

        body.dark-mode footer {

            background: #000 !important;

        }


        #themeToggle {

            width: 45px;

            height: 45px;

        }
    </style>


</head>



<body>

    <!-- ================= Navbar ================= -->


    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow">


        <div class="container">


            <a class="navbar-brand fw-bold" href="{{ route('landingPage') }}">

                <i class="fa-solid fa-graduation-cap"></i>

                UCSMGY

            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">


                <ul class="navbar-nav ms-auto align-items-lg-center">



                    <li class="nav-item">

                        <a class="nav-link active" href="{{ route('landingPage') }}">

                            <i class="fa-solid fa-house"></i>

                            Home

                        </a>

                    </li>

                    <li class="nav-item dropdown">


                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">

                            <i class="fa-solid fa-layer-group"></i>

                            Years

                        </a>

                        <ul class="dropdown-menu shadow rounded-4">


                            @foreach ($years as $year)
                                <li>

                                    <a class="dropdown-item" href="{{ route('subjects.byYear', $year->id) }}">

                                        <i class="fa-solid fa-graduation-cap text-primary"></i>

                                        {{ $year->name }}

                                    </a>

                                </li>
                            @endforeach


                        </ul>


                    </li>

                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">


                        <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-4">


                            <i class="fa-solid fa-right-to-bracket"></i>

                            Login


                        </a>


                    </li>

                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">


                        <button id="themeToggle" class="btn btn-outline-light rounded-pill">


                            <i class="fa-solid fa-moon"></i>


                        </button>


                    </li>



                </ul>


            </div>


        </div>


    </nav>

    <!-- ================= Hero Section ================= -->

    <section class="hero">

        <div class="container text-center" data-aos="fade-up">


            <h1>

                University of Computer Studies

                <br>

                <span>Magway</span>

            </h1>


            <p class="lead mt-4">

                Explore Computer Science & Technology Courses

            </p>



            <a href="#subjects" class="btn btn-warning rounded-pill mt-3">


                <i class="fa-solid fa-book-open"></i>

                Explore Subjects


            </a>



        </div>


    </section>

    <!-- ================= Statistics Section ================= -->


    <section class="py-5">


        <div class="container">


            <div class="row g-4">

                <!-- Total Subjects -->

                <div class="col-md-4" data-aos="fade-up">


                    <div class="stat-box text-center">


                        <i class="fa-solid fa-book"></i>


                        <h2 class="fw-bold mt-3">


                            {{ count($subjects) }}


                        </h2>



                        <p class="text-muted mb-0">

                            Total Subjects

                        </p>



                    </div>


                </div>

                <!-- Academic Years -->

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">


                    <div class="stat-box text-center">


                        <i class="fa-solid fa-calendar-days"></i>


                        <h2 class="fw-bold mt-3">


                            {{ count($years) }}


                        </h2>



                        <p class="text-muted mb-0">

                            Academic Years

                        </p>



                    </div>


                </div>

                <!-- Department -->

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">


                    <div class="stat-box text-center">


                        <i class="fa-solid fa-laptop-code"></i>


                        <h2 class="fw-bold mt-3">


                            {{ count($majors ?? []) }}


                        </h2>



                        <p class="text-muted mb-0">

                            Total Majors

                        </p>



                    </div>


                </div>



            </div>


        </div>


    </section>

    <!-- ================= Subject Section ================= -->


    <section id="subjects" class="py-5">


        <div class="container">



            <div class="text-center mb-5" data-aos="fade-up">


                <h2 class="section-title">


                    @if (isset($selectedYear))
                        {{ $selectedYear->name }} Subjects
                    @else
                        Available Subjects
                    @endif


                </h2>



                <p class="text-muted">

                    Computer Science and Technology Courses Collection

                </p>


            </div>

            <div class="row g-4">

                @forelse($subjects as $subject)
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">



                        <div class="card border-0 shadow rounded-5 overflow-hidden h-100">



                            <!-- Subject Image -->


                            @if ($subject->image)
                                <img src="{{ asset($subject->image) }}" class="card-img-top">
                            @else
                                <img src="https://picsum.photos/600/400" class="card-img-top">
                            @endif

                            <div class="card-body p-4">

                                <span class="badge bg-primary rounded-pill px-3 py-2">


                                    {{ $subject->year->name ?? 'N/A' }}


                                </span>

                                <h4 class="fw-bold mt-3">


                                    {{ $subject->long_name }}


                                </h4>


                                <p class="text-muted">


                                    {!! Str::limit($subject->description, 120) !!}


                                </p>


                                {{-- <div class="bg-light rounded-4 p-3 mb-3">


                                    <i class="fa-solid fa-code text-primary"></i>


                                    <strong>

                                        Subject Code:

                                    </strong>


                                    {{ $subject->short_name }}



                                </div> --}}


                                {{-- <div class="bg-light rounded-4 p-3 mb-3">


                                    <i class="fa-solid fa-clock text-primary"></i>


                                    <strong>

                                        Weekly Period:

                                    </strong>


                                    {{ $subject->time_number }}


                                </div> --}}


                                <a href="{{ route('subject.detail', $subject->id) }}"
                                    class="btn btn-primary rounded-pill w-100">


                                    <i class="fa-solid fa-eye"></i>


                                    View Detail


                                </a>






                            </div>



                        </div>



                    </div>




                @empty



                    <div class="col-12 text-center">


                        <h5 class="text-muted">


                            No Subject Available


                        </h5>


                    </div>
                @endforelse




            </div>



        </div>


    </section>

    <!-- ================= About Section ================= -->


    <section class="py-5 bg-white">


        <div class="container">


            <div class="row align-items-center g-5">



                <!-- Image -->


                <div class="col-lg-6" data-aos="fade-right">


                    <img src="https://images.unsplash.com/photo-1564981797816-1043664bf78d"
                        class="img-fluid rounded-5 shadow">


                </div>





                <!-- Content -->


                <div class="col-lg-6" data-aos="fade-left">



                    <h2 class="fw-bold mb-4">


                        About UCSMGY


                    </h2>





                    <p class="text-muted fs-5">


                        University of Computer Studies (Magway)
                        provides high quality education in
                        Computer Science and Technology.
                        Students can explore subjects,
                        courses and academic information
                        through this portal.


                    </p>







                    <div class="mt-4">





                        <!-- Feature 1 -->


                        <div class="d-flex mb-4">



                            <div class="me-3">


                                <i class="fa-solid fa-circle-check text-primary fs-3"></i>


                            </div>



                            <div>


                                <h5 class="fw-bold mb-1">


                                    Modern Education


                                </h5>


                                <p class="text-muted mb-0">


                                    Computer Science & Computer Technology for IT Programs


                                </p>


                            </div>



                        </div>







                        <!-- Feature 2 -->


                        <div class="d-flex mb-4">



                            <div class="me-3">


                                <i class="fa-solid fa-circle-check text-primary fs-3"></i>


                            </div>



                            <div>


                                <h5 class="fw-bold mb-1">


                                    Quality Learning


                                </h5>


                                <p class="text-muted mb-0">


                                    Professional Academic Environment


                                </p>


                            </div>



                        </div>








                        <!-- Feature 3 -->


                        <div class="d-flex">



                            <div class="me-3">


                                <i class="fa-solid fa-circle-check text-primary fs-3"></i>


                            </div>



                            <div>


                                <h5 class="fw-bold mb-1">


                                    Technology Focus


                                </h5>


                                <p class="text-muted mb-0">


                                    Software Development and Innovation


                                </p>


                            </div>



                        </div>


                    </div>



                </div>

            </div>


        </div>


    </section>


    <!-- ================= Footer ================= -->


    <footer class="bg-dark text-white py-5">


        <div class="container">



            <div class="row align-items-center">

                <!-- Logo -->


                <div class="col-md-6 mb-4 mb-md-0">


                    <h4 class="fw-bold">


                        <i class="fa-solid fa-graduation-cap"></i>


                        UCSMGY


                    </h4>




                    <p class="text-white-50">


                        University Subject Management System


                    </p>



                </div>


                <!-- Social -->


                <div class="col-md-6 text-md-end">


                    <h5 class="mb-3">


                        Follow Us


                    </h5>

                    <a href="#" class="text-white fs-4 me-3">


                        <i class="fa-brands fa-facebook"></i>


                    </a>


                    <a href="#" class="text-white fs-4 me-3">


                        <i class="fa-brands fa-youtube"></i>


                    </a>

                    <a href="#" class="text-white fs-4">


                        <i class="fa-solid fa-envelope"></i>


                    </a>

                </div>

            </div>

            <hr class="my-4">

            <div class="text-center text-white-50">


                © {{ date('Y') }}

                University of Computer Studies (Magway)


            </div>

        </div>


    </footer>

    <!-- ================= Bootstrap JS ================= -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


    <!-- ================= AOS Animation JS ================= -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>


    <script>
        AOS.init({

            duration: 1000,

            once: true

        });
    </script>


    <!-- ================= Dark Mode Script ================= -->


    <script>
        const themeButton = document.getElementById("themeToggle");

        const body = document.body;

        // Load saved theme


        if (localStorage.getItem("theme") === "dark") {


            body.classList.add("dark-mode");


            themeButton.innerHTML =
                '<i class="fa-solid fa-sun"></i>';


        }


        // Change Theme


        themeButton.addEventListener("click", function() {



            body.classList.toggle("dark-mode");


            if (body.classList.contains("dark-mode")) {


                localStorage.setItem("theme", "dark");


                themeButton.innerHTML =
                    '<i class="fa-solid fa-sun"></i>';



            } else {


                localStorage.setItem("theme", "light");


                themeButton.innerHTML =
                    '<i class="fa-solid fa-moon"></i>';


            }

        });
    </script>


</body>


</html>
