<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Weekly Timetable</title>


    <style>
        @page {

            size: A4 landscape;

            margin: 10mm;

        }


        body {

            font-family: DejaVu Sans, sans-serif;

            font-size: 10px;

            color: #000;

        }


        /* ================= HEADER ================= */


        .header {

            text-align: center;

            margin-bottom: 15px;

        }


        .university {

            font-size: 18px;

            font-weight: bold;

            color: #007bff;

        }


        .title {

            margin-top: 8px;

            font-size: 12px;

            font-weight: bold;

            line-height: 18px;

        }



        /* ================= INFO ================= */


        .info-table {

            width: 100%;

            margin-bottom: 10px;

            border-collapse: collapse;

        }


        .info-table td {

            border: none;

            font-weight: bold;

        }



        /* ================= TIMETABLE ================= */


        .timetable {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

        }


        .timetable th {

            background: #6c757d;

            color: white;

            border: 1px solid #000;

            padding: 6px;

            text-align: center;

            font-size: 10px;

        }



        .timetable td {

            border: 1px solid #000;

            height: 38px;

            text-align: center;

            vertical-align: middle;

        }



        .timetable th:first-child,

        .timetable td:first-child {

            width: 70px;

        }



        .day {

            background: #6c757d;

            color: white;

            font-weight: bold;

        }



        .subject {

            color: #007bff;

            font-weight: bold;

        }



        .extra {

            color: #777;

            font-style: italic;

        }



        .lunch {

            background: #dee2e6;

            font-weight: bold;

            text-align: center;

            vertical-align: middle;

        }



        /* ================= SUBJECT LIST ================= */


        .subject-area {

            margin-top: 20px;

        }



        .subject-table {

            width: 100%;

            border-collapse: collapse;

        }



        .subject-table td {

            border: none;

            padding: 4px;

        }



        .subject-table .code {

            width: 120px;

            color: #007bff;

            font-weight: bold;

        }



        .subject-header {

            font-weight: bold;

        }



        /* ================= FOOTER ================= */


        .footer {

            margin-top: 15px;

            text-align: right;

            font-size: 9px;

        }
    </style>


</head>


<body>



    <!-- HEADER -->


    <div class="header">


        <div class="university">

            ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

        </div>



        <div class="title">


            {{ $academicYear->name }} ပညာသင်နှစ်

            ({{ $semesters->name }})


            <br>


            {{ $yearData->name }}

            ({{ $major->name }})

            - Section({{ $sections->name }})


        </div>



    </div>





    <!-- INFORMATION -->


    <table class="info-table">


        <tr>


            <td>

                {{ $yearData->name }}

                ({{ $major->name }})

            </td>


            <td style="text-align:right">

                Section({{ $sections->name }})

                -

                အခန်း({{ $room->name }})

            </td>


        </tr>


    </table>






    <!-- TIMETABLE -->


    <table class="timetable">


        <thead>


            <tr>


                <th>

                    Day / Time

                </th>



                @foreach ($times as $time)
                    @if (str_replace(' ', '', $time->name) == '12:00-01:00')
                        <th></th>
                    @else
                        <th>

                            {{ $time->name }}

                        </th>
                    @endif
                @endforeach



            </tr>


        </thead>





        <tbody>



            @foreach ($days as $day)
                <tr>



                    <td class="day">

                        {{ $day->name }}

                    </td>




                    @foreach ($times as $time)
                        @if (str_replace(' ', '', $time->name) == '12:00-01:00')
                            @if ($day->id == $days->first()->id)
                                <td rowspan="{{ $days->count() }}" class="lunch">


                                    ထမင်းစားနားချိန်


                                </td>
                            @endif
                        @else
                            @php

                                $schedule = $schedules->where('day_id', $day->id)->where('time_id', $time->id)->first();

                            @endphp




                            @if ($schedule)
                                <td class="subject">


                                    {{ $schedule->subject?->short_name }}


                                </td>
                            @else
                                <td class="extra">


                                    Extra Curriculum


                                </td>
                            @endif
                        @endif
                    @endforeach



                </tr>
            @endforeach



        </tbody>


    </table>







    <!-- SUBJECT CODE / NAME -->


    <div class="subject-area">



        <table class="subject-table">


            <tr>


                <td class="code">

                    Subject Code

                </td>



                <td>

                    Subject Name

                </td>


            </tr>




            @foreach ($schedules->unique('subject_id') as $schedule)
                <tr>


                    <td class="code">


                        {{ $schedule->subject?->short_name }}


                    </td>



                    <td>


                        {{ $schedule->subject?->long_name }}


                        ({{ $schedule->teacher?->name }})
                    </td>


                </tr>
            @endforeach



        </table>



    </div>







    <!-- FOOTER -->


    <!--

<div class="footer">

Generated Date :

{{ now()->format('d-m-Y h:i A') }}

</div>

-->



</body>


</html>
