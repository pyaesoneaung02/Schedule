@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">

        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="mb-4 text-center">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-building-columns"></i>
                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)
            </h2>

            <h4 class="mt-3 text-dark font-weight-bold">

                @if (isset($room))
                    {{ $academicYear->name }} ပညာသင်နှစ်
                    ({{ $semester->name }})

                    <br><br>

                    {{ $yearData->name }}
                    ({{ $major->name }})

                    -
                    Section({{ $section->name }})
                @else
                    {{ $academicYear->name }} ပညာသင်နှစ်

                    <br><br>

                    Auto Generated Timetable
                @endif

            </h4>

        </div>


        @if ($schedules->isEmpty())
            <!-- =================================================
                 EMPTY
            ================================================== -->

            <div class="py-5 text-center text-muted">

                <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

                <h5>
                    အချိန်ဇယား မရှိပါ။
                </h5>

            </div>
        @else
            <!-- =================================================
                 INFO
            ================================================== -->

            <div class="timetable-info">

                <div>
                    {{ $yearData->name }}
                    ({{ $major->name }})
                </div>

                <div>
                    Section({{ $section->name }})
                    -
                    အခန်း({{ $room->name }})
                </div>

            </div>


            <!-- =================================================
                 TIMETABLE
            ================================================== -->

            <div class="table-responsive print-table">

                <table class="table table-bordered text-center align-middle timetable-table">

                    <thead>

                        <tr>

                            <!-- Day / Time -->
                            <th class="table-header equal-column">
                                Day / Time
                            </th>


                            @foreach ($times as $time)
                                @if ($time->name == '12:00-01:00')
                                    <!-- Lunch -->
                                    <th class="table-header lunch-column">

                                        &nbsp;

                                    </th>
                                @else
                                    <!-- Normal Period -->
                                    <th class="table-header equal-column">

                                        {{ $time->name }}

                                    </th>
                                @endif
                            @endforeach

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($days as $index => $day)
                            <tr>

                                <!-- Day -->
                                <td class="day-cell equal-column">

                                    {{ $day->name }}

                                </td>


                                @foreach ($times as $time)
                                    <!-- =================================================
                                         LUNCH
                                    ================================================== -->

                                    @if ($time->name == '12:00-01:00')
                                        @if ($index == 0)
                                            <td rowspan="{{ count($days) }}" class="lunch-cell lunch-column">

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


                                        <!-- =================================================
                                             NORMAL CELL
                                        ================================================== -->

                                        <td class="schedule-cell equal-column">

                                            @if ($schedule)
                                                <span class="font-weight-bold text-primary subject-code">

                                                    {{ $schedule->subject->short_name }}

                                                </span>
                                            @else
                                                <span class="text-muted extra-text">

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


            <!-- =================================================
                 SUBJECT LIST
            ================================================== -->

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


            <!-- =================================================
                 BUTTONS
            ================================================== -->

            <div class="mt-4 mb-5 text-center print-hide">

                <!-- Print -->

                <button onclick="window.print()" class="px-4 mr-2 btn btn-primary">

                    <i class="mr-1 fa-solid fa-print"></i>

                    Print Timetable

                </button>


                <!-- PDF -->

                @if (isset($room))
                    <a href="{{ route('schedule.pdf', [
                        'year' => $yearData->id,
                        'room' => $room->id,
                        'major' => $major->id,
                        'academicYearID' => $academicYear->id,
                        'semesterID' => $semester->id,
                        'sectionID' => $section->id,
                    ]) }}"
                        class="px-4 mr-2 btn btn-danger">

                        <i class="mr-1 fa-solid fa-file-pdf"></i>

                        Download PDF

                    </a>
                @endif


                <!-- Manual -->

                <a href="{{ route('schedule.list', [$yearData->id, $room->id, $major->id]) }}"
                    class="px-4 btn btn-success">

                    <i class="mr-1 fa-solid fa-pen"></i>

                    Manual Timetable

                </a>

            </div>
        @endif

    </div>

@endsection


<style>
    /* =========================================================
   TIMETABLE INFO
========================================================= */

    .timetable-info {

        width: 100%;

        display: flex;

        justify-content: space-between;

        align-items: center;

        font-weight: bold;

        margin-bottom: 10px;

    }


    /* =========================================================
   MAIN TABLE
========================================================= */

    .timetable-table {

        width: 100% !important;

        table-layout: fixed !important;

        border-collapse: collapse !important;

    }


    /* =========================================================
   ALL NORMAL COLUMNS
   Day / Time + Periods
   ALL SAME WIDTH
========================================================= */

    .timetable-table .equal-column {

        width: 18% !important;

    }


    /* =========================================================
   LUNCH COLUMN
   ONLY LUNCH IS NARROW
========================================================= */

    .timetable-table .lunch-column {

        width: 8% !important;

    }


    /*
   Because there are 5 normal columns:
   Day/Time + 4 Periods

   They stay equal.
*/


    /* =========================================================
   TABLE HEADER
========================================================= */

    .print-table thead th.table-header {

        background-color: #6c757d !important;

        color: #ffffff !important;

        text-align: center;

        vertical-align: middle;

        height: 42px;

        padding: 6px 4px !important;

        font-size: 13px;

    }


    /* =========================================================
   DAY CELL
========================================================= */

    .print-table td.day-cell {

        background-color: #6c757d !important;

        color: #ffffff !important;

        font-weight: bold;

        text-align: center;

        vertical-align: middle;

        height: 42px;

        padding: 5px !important;

    }


    /* =========================================================
   NORMAL SCHEDULE CELL
========================================================= */

    .print-table td.schedule-cell {

        height: 42px !important;

        padding: 5px 3px !important;

        text-align: center;

        vertical-align: middle;

    }


    /* =========================================================
   SUBJECT CODE
========================================================= */

    .print-table .subject-code {

        font-size: 14px;

    }


    /* =========================================================
   EXTRA CURRICULUM
========================================================= */

    .print-table .extra-text {

        font-size: 12px;

    }


    /* =========================================================
   LUNCH CELL
========================================================= */

    .print-table td.lunch-cell {

        width: 8% !important;

        padding: 0 !important;

        text-align: center !important;

        vertical-align: middle !important;

    }


    /* =========================================================
   LUNCH TEXT
========================================================= */

    .lunch-text {

        writing-mode: vertical-rl;

        text-orientation: mixed;

        white-space: nowrap;

        font-weight: bold;

        font-size: 13px;

        display: inline-block;

    }


    /* =========================================================
   BORDER
========================================================= */

    .print-table table,
    .print-table th,
    .print-table td {

        border: 1px solid #000 !important;

    }


    /* =========================================================
   SUBJECT TABLE
========================================================= */

    .subject-table,
    .subject-table th,
    .subject-table td {

        border: none !important;

    }


    .subject-table th {

        font-weight: bold;

    }


    /* =========================================================
   PRINT
========================================================= */

    @media print {

        @page {

            size: A4 landscape;

            margin: 8mm;

        }


        /* Hide buttons */

        .print-hide {

            display: none !important;

        }


        /* Hide sidebar */

        #accordionSidebar,
        .sidebar,
        .topbar,
        .navbar {

            display: none !important;

        }


        /* Content */

        #content-wrapper {

            width: 100% !important;

            margin: 0 !important;

        }


        .container-fluid {

            width: 100% !important;

            padding: 0 !important;

            margin: 0 !important;

        }


        /* Responsive */

        .table-responsive {

            overflow: visible !important;

        }


        /* Force colors */

        html,
        body,
        * {

            -webkit-print-color-adjust: exact !important;

            print-color-adjust: exact !important;

        }


        /* =====================================================
       PRINT TABLE
    ================================================== */

        .timetable-table {

            width: 100% !important;

            table-layout: fixed !important;

            border-collapse: collapse !important;

        }


        /* Normal columns */

        .timetable-table .equal-column {

            width: 18% !important;

        }


        /* Lunch */

        .timetable-table .lunch-column {

            width: 8% !important;

        }


        /* Header */

        .print-table thead th.table-header {

            background-color: #6c757d !important;

            color: #ffffff !important;

            height: 38px !important;

            padding: 4px !important;

        }


        /* Day */

        .print-table td.day-cell {

            background-color: #6c757d !important;

            color: #ffffff !important;

            height: 40px !important;

            padding: 4px !important;

        }


        /* Schedule */

        .print-table td.schedule-cell {

            height: 40px !important;

            padding: 4px 2px !important;

        }


        /* Lunch */

        .print-table td.lunch-cell {

            width: 8% !important;

            padding: 0 !important;

        }


        /* Lunch text */

        .lunch-text {

            writing-mode: vertical-rl;

            font-size: 12px;

            font-weight: bold;

            white-space: nowrap;

        }


        /* Border */

        .print-table table,
        .print-table th,
        .print-table td {

            border: 1px solid #000 !important;

        }


        /* Subject table */

        .subject-table,
        .subject-table th,
        .subject-table td {

            border: none !important;

        }

    }
</style>
