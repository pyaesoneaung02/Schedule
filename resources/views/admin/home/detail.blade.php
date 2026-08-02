<!DOCTYPE html>
<html>

<head>

    <title>
        {{ $subject->long_name }}
    </title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">


    <style>
        body {

            background: #f5f7fb;

        }


        .detail-card {

            border-radius: 30px;

            overflow: hidden;

        }



        .subject-image {

            height: 400px;

            object-fit: cover;

            width: 100%;

        }


        .info-box {

            background: #f8f9fa;

            padding: 15px;

            border-radius: 15px;

            margin-bottom: 15px;

        }
    </style>


</head>


<body>


    <nav class="navbar navbar-dark bg-primary">

        <div class="container">

            <a href="{{ route('landingPage') }}" class="navbar-brand fw-bold">


                🎓 UCSMGY


            </a>

        </div>

    </nav>




    <div class="container py-5">



        <div class="card shadow border-0 detail-card">



            @if ($subject->image)
                <img src="{{ asset($subject->image) }}" class="subject-image">
            @else
                <img src="https://picsum.photos/1200/500" class="subject-image">
            @endif




            <div class="card-body p-5">



                <span class="badge bg-primary rounded-pill px-4 py-2">


                    {{ $subject->year->name ?? '' }}


                </span>




                <h1 class="fw-bold mt-3">


                    {{ $subject->long_name }}


                </h1>



                <p class="text-muted fs-5">


                    {!! $subject->description !!}


                </p>




                <div class="row mt-4">



                    <div class="col-md-6">


                        <div class="info-box">


                            <i class="fa-solid fa-code text-primary"></i>


                            <b>Subject Code</b>


                            <br>


                            {{ $subject->short_name }}


                        </div>


                    </div>





                    <div class="col-md-6">


                        <div class="info-box">


                            <i class="fa-solid fa-clock text-primary"></i>


                            <b>Weekly Period</b>


                            <br>


                            {{ $subject->time_number }}


                        </div>


                    </div>





                    <div class="col-md-6">


                        <div class="info-box">


                            <i class="fa-solid fa-building-columns text-primary"></i>


                            <b>Major</b>


                            <br>


                            {{ $subject->major->name ?? '' }}


                        </div>


                    </div>





                    <div class="col-md-6">


                        <div class="info-box">


                            <i class="fa-solid fa-calendar text-primary"></i>


                            <b>Semester</b>


                            <br>


                            {{ $subject->semester->name ?? '' }}


                        </div>


                    </div>



                </div>




                <a href="{{ route('landingPage') }}" class="btn btn-outline-primary rounded-pill px-5 mt-4">


                    <i class="fa-solid fa-arrow-left"></i>

                    Back


                </a>



            </div>


        </div>



    </div>



</body>

</html>
