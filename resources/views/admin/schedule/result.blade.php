@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">


    <!-- Header -->
    <div class="mb-4 text-center">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-building-columns"></i>

            University Of Computer Studies (Magway)

        </h2>


        <h4 class="mt-3 text-dark font-weight-bold">

            {{ $yearData->name }}
            |
            {{ $room->name }}
            |
            {{ $major->name }}

        </h4>


    </div>




    @if ($schedules->isEmpty())


        <div class="py-5 text-center text-muted">

            <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

            <h5>
                No Schedule Found for this combination
            </h5>

        </div>


    @else



    <!-- Timetable Card -->

    <div class="border-0 shadow-sm card">


        <div class="text-white card-header bg-primary">


            <h5 class="mb-0">

                <i class="mr-2 fa-solid fa-calendar-days"></i>

                Weekly Timetable

            </h5>


        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table class="table text-center align-middle table-bordered table-hover">


                    <thead class="text-white bg-dark">


                        <tr>

                            <th>
                                Day / Time
                            </th>


                            @foreach ($times as $time)

                                <th>

                                    {{ $time->name }}

                                </th>

                            @endforeach


                        </tr>


                    </thead>




                    <tbody>


                    @foreach ($days as $day)


                        <tr>


                            <td class="text-white font-weight-bold bg-primary">


                                {{ $day->name }}


                            </td>




                            @foreach ($times as $time)


                                @php

                                    $schedule = $schedules->firstWhere(function ($item) use ($day,$time){

                                        return $item->day_id == $day->id
                                        &&
                                        $item->time_id == $time->id;

                                    });

                                @endphp




                                <td>


                                    @if ($time->name == '12:00-01:00')


                                        <span class="text-danger font-weight-bold">

                                            Lunch Break

                                        </span>



                                    @elseif($schedule)



                                        <span class="text-primary font-weight-bold">

                                            {{ $schedule->subject->short_name }}

                                        </span>



                                    @else


                                        <span class="text-muted">

                                            Extra Curriculum

                                        </span>



                                    @endif



                                </td>



                            @endforeach



                        </tr>


                    @endforeach



                    </tbody>



                </table>



            </div>


        </div>


    </div>






    <!-- Subject Legend -->


    <div class="mt-4 border-0 shadow-sm card">


        <div class="text-white card-header bg-primary">


            <h5 class="mb-0">

                <i class="mr-2 fa-solid fa-book"></i>

                Subject List

            </h5>


        </div>



        <div class="card-body">



            <div class="px-3 py-2 mb-2 text-white bg-dark d-flex">


                <div class="col-3">
                    Subject Code
                </div>


                <div class="col-9">
                    Subject Name
                </div>


            </div>





            @foreach($schedules->unique('subject_id') as $item)


                <div class="px-3 py-3 mb-2 border rounded d-flex">


                    <div class="col-3 font-weight-bold text-primary">


                        {{ $item->subject->short_name }}


                    </div>



                    <div class="col-9">


                        {{ $item->subject->long_name }}



                        @if($item->teacher)


                            <span class="text-muted">

                                ({{ $item->teacher->name }})

                            </span>


                        @endif


                    </div>


                </div>


            @endforeach




        </div>


    </div>





    <!-- Buttons -->


    <div class="mt-4 mb-5 text-center">


        <button onclick="window.print()"
            class="px-4 btn btn-primary">


            <i class="mr-1 fa-solid fa-print"></i>

            Print Timetable


        </button>




        <a href="{{ route('schedule.pdf', [$yearData->id, $room->id, $major->id]) }}"
            class="px-4 btn btn-danger">


            <i class="mr-1 fa-solid fa-file-pdf"></i>

            Download PDF


        </a>




        <a href="{{ route('schedule.list', [$yearData->id, $room->id, $major->id]) }}"
            class="px-4 btn btn-success">


            <i class="mr-1 fa-solid fa-pen-to-square"></i>

            Manual Timetable


        </a>



    </div>



    @endif



</div>


@endsection
