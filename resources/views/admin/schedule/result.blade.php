@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">


        <!-- Header -->

        <div class="mb-4 text-center">


            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-building-columns"></i>

                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

            </h2>



            <h4 class="mt-3 text-dark font-weight-bold">


                @if (isset($room))
                    {{ $academicYear->name }} ပညာသင်နှစ်

                    ({{ $semesters->name }})

                    <br><br>

                    {{ $yearData->name }}
                    ({{ $major->name }})

                    -

                    Section({{ $sections->name }})
                @else
                    {{ $academicYear->name }} ပညာသင်နှစ်

                    <br><br>

                    Auto Generated Timetable
                @endif



            </h4>


        </div>


        @if ($schedules->isEmpty())
            <div class="py-5 text-center text-muted">

                <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

                <h5>

                    အချိန်ဇယား မရှိပါ။

                </h5>


            </div>
        @else
            <!-- Info -->


            <div class="timetable-info">


                <div>

                    {{ $yearData->name }}

                    ({{ $major->name }})

                </div>


                <div>

                    Section({{ $sections->name }})

                    -

                    အခန်း({{ $room->name }})

                </div>


            </div>

            <!-- Timetable -->


            <div class="table-responsive print-table">


                <table class="table table-bordered text-center align-middle">


                    <thead>


                        <tr>


                            <th class="table-header">

                                Day / Time

                            </th>




                            @foreach ($times as $time)
                                <th class="table-header">


                                    @if ($time->name == '12:00-01:00')
                                        &nbsp;
                                    @else
                                        {{ $time->name }}
                                    @endif


                                </th>
                            @endforeach



                        </tr>


                    </thead>





                    <tbody>



                        @foreach ($days as $index => $day)
                            <tr>


                                <td class="day-cell">

                                    {{ $day->name }}

                                </td>



                                @foreach ($times as $time)
                                    @if ($time->name == '12:00-01:00')
                                        @if ($index == 0)
                                            <td rowspan="{{ count($days) }}" class="lunch-cell">


                                                <span class="lunch-text">

                                                    ထမင်းစားနားချိန်

                                                </span>


                                            </td>
                                        @endif
                                    @else
                                        @php

                                            $schedule = $schedules->firstWhere(function ($item) use ($day, $time) {
                                                return $item->day_id == $day->id && $item->time_id == $time->id;
                                            });

                                        @endphp





                                        <td>


                                            @if ($schedule)
                                                <span class="font-weight-bold text-primary">


                                                    {{ $schedule->subject->short_name }}


                                                </span>
                                            @else
                                                <span class="text-muted">

                                                    Extra Curriculum

                                                </span>
                                            @endif


                                        </td>
                                    @endif
                                @endforeach



                            </tr>
                        @endforeach



                    </tbody>



                </table>



            </div>







            <!-- Subject List -->


            <div class="mt-4">


                <table class="table table-borderless subject-table">



                    <thead>


                        <tr>


                            <th width="15%">

                                Subject Code

                            </th>



                            <th width="85%">

                                Subject Name

                            </th>


                        </tr>



                    </thead>




                    <tbody>



                        @foreach ($schedules->unique('subject_id') as $item)
                            <tr>



                                <td class="font-weight-bold text-primary">


                                    @if ($item->subject)
                                        {{ $item->subject->short_name }}
                                    @endif



                                </td>





                                <td>


                                    @if ($item->subject)
                                        {{ $item->subject->long_name }}
                                    @endif




                                    @if ($item->teacher)
                                        <span class="text-muted">

                                            ({{ $item->teacher->name }})
                                        </span>
                                    @endif



                                </td>



                            </tr>
                        @endforeach



                    </tbody>



                </table>



            </div>

            <!-- Buttons -->


            <div class="mt-4 mb-5 text-center print-hide">



                <button onclick="window.print()" class="px-4 mr-2 btn btn-primary">


                    <i class="mr-1 fa-solid fa-print"></i>

                    Print Timetable


                </button>

                    @if (isset($room))

                    <a href="{{ route('schedule.pdf', [
                        'year' => $yearData->id,
                        'room' => $room->id,
                        'major' => $major->id,
                        'academicYearID' => $academicYear->id,
                        'semesterID' => $semesters->id,
                        'sectionID' => $sections->id,
                    ]) }}"
                    class="px-4 mr-2 btn btn-danger">

                        <i class="mr-1 fa-solid fa-file-pdf"></i>
                        Download PDF

                    </a>

                    @endif


                    <a href="{{ route('schedule.list', [$yearData->id, $room->id, $major->id]) }}"
                        class="px-4 btn btn-success">


                        <i class="mr-1 fa-solid fa-pen"></i>

                        Manual Timetable


                    </a>
                @endif



            </div>


    </div>


@endsection

<style>
    /* =========================
   Timetable Info
========================= */

    .timetable-info {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
        margin-bottom: 10px;
    }


    /* =========================
   Timetable Header Color
========================= */

    .print-table thead th.table-header {

        background-color: #6c757d !important;
        color: #ffffff !important;

    }


    /* =========================
   Day Column Color
========================= */

    .print-table td.day-cell {

        background-color: #6c757d !important;
        color: #ffffff !important;

    }



    /* =========================
   Lunch
========================= */

    .print-table td.lunch-cell {

        background-color: #dee2e6 !important;

    }


    .lunch-text {

        writing-mode: vertical-rl;
        font-weight: bold;
        display:inline-block;
        transform: translateY(60px);

    }



    /* =========================
   Timetable Border
========================= */

    .print-table table {

        border-collapse: collapse !important;

    }


    .print-table th,
    .print-table td {

        border: 1px solid #000 !important;

    }



    /* =========================
   Subject List No Border
========================= */

    .subject-table,
    .subject-table th,
    .subject-table td {

        border: none !important;

    }



    /* =========================
   PRINT
========================= */

    @media print {


        @page {

            size: A4 landscape;

            margin: 10mm;

        }



        /* Hide Button */

        .print-hide {

            display: none !important;

        }



        /* Hide Sidebar */

        #accordionSidebar,
        .sidebar,
        .topbar,
        .navbar {

            display: none !important;

        }



        #content-wrapper {

            width: 100% !important;

            margin: 0 !important;

        }



        .container-fluid {

            width: 100% !important;

            padding: 0 !important;

        }



        .table-responsive {

            overflow: visible !important;

        }



        /* Force Color */

        html,
        body,
        * {

            -webkit-print-color-adjust: exact !important;

            print-color-adjust: exact !important;

        }





        /* Header */

        .print-table thead th.table-header {

            background-color: #6c757d !important;

            color: white !important;

        }




        /* Day */

        .print-table td.day-cell {

            background-color: #6c757d !important;

            color: white !important;

        }





        /* Lunch */

        .print-table td.lunch-cell {

            background-color: #dee2e6 !important;

        }






        /* Border */

        .print-table table,
        .print-table th,
        .print-table td {

            border: 1px solid black !important;

        }





        /* Subject no border */

        .subject-table,
        .subject-table th,
        .subject-table td {

            border: none !important;

        }


    }
</style>
