<!DOCTYPE html>
<html lang="my">

<head>

    <meta charset="UTF-8">

    <title>Weekly Timetable</title>

    @php

        /*
        |--------------------------------------------------------------------------
        | UNIQUE SUBJECTS
        |--------------------------------------------------------------------------
        */

        $uniqueSubjects = $schedules->unique('subject_id');

        $subjectCount = $uniqueSubjects->count();


        /*
        |--------------------------------------------------------------------------
        | AUTO COMPACT
        |--------------------------------------------------------------------------
        */

        if ($subjectCount <= 6) {

            $compactClass = 'compact-normal';

        } elseif ($subjectCount <= 8) {

            $compactClass = 'compact-medium';

        } elseif ($subjectCount <= 10) {

            $compactClass = 'compact-small';

        } else {

            $compactClass = 'compact-ultra';

        }

    @endphp


    <style>

        /* =========================================================
           PAGE
        ========================================================== */

        @page {

            size: A4 landscape;

            /*
            |--------------------------------------------------------------------------
            | TOP    = 8mm
            | RIGHT  = 12mm
            | BOTTOM = 8mm
            | LEFT   = 12mm
            |--------------------------------------------------------------------------
            */

            margin: 8mm 12mm 8mm 12mm;
        }


        /* =========================================================
           RESET
        ========================================================== */

        * {

            box-sizing: border-box;

        }


        html,
        body {

            margin: 0;

            padding: 0;

        }


        /* =========================================================
           BODY
        ========================================================== */

        body {

            font-family: 'NotoSansMyanmar', sans-serif;

            font-size: 9px;

            color: #4b5563;

        }


        /* =========================================================
           MAIN WRAPPER
        ========================================================== */

        .pdf-wrapper {

            width: 96%;

            margin: 0 auto;

            padding: 0;

        }


        /* =========================================================
           HEADER
        ========================================================== */

        .header {

            width: 100%;

            text-align: center;

            margin-bottom: 7px;

        }


        .university-name {

            margin: 0;

            font-size: 17px;

            font-weight: bold;

            color: #007bff;

            line-height: 1.25;

        }


        .academic-info {

            margin-top: 4px;

            font-size: 10px;

            font-weight: bold;

            line-height: 1.35;

            color: #343a40;

        }


        /* =========================================================
           TIMETABLE INFORMATION
        ========================================================== */

        .timetable-info {

            width: 100%;

            margin: 0 auto 4px;

            font-size: 8.5px;

            font-weight: bold;

        }


        .timetable-info table {

            width: 100%;

            border-collapse: collapse;

        }


        .timetable-info td {

            border: none;

            padding: 0;

        }


        .info-left {

            text-align: left;

        }


        .info-right {

            text-align: right;

        }


        /* =========================================================
           TIMETABLE
        ========================================================== */

        .timetable {

            width: 100%;

            margin: 0 auto;

            border-collapse: collapse;

            table-layout: fixed;

            page-break-inside: avoid;

        }


        /* =========================================================
           TABLE HEADER
        ========================================================== */

        .timetable th {

            height: 31px;

            padding: 2px;

            border: 1px solid #222;

            background-color: #6c757d;

            color: #ffffff;

            text-align: center;

            vertical-align: middle;

            font-size: 8px;

            font-weight: bold;

            line-height: 1.1;

        }


        /* =========================================================
           TABLE BODY
        ========================================================== */

        .timetable td {

            height: 55px;

            padding: 2px;

            border: 1px solid #222;

            text-align: center;

            vertical-align: middle;

            font-size: 8px;

            line-height: 1.15;

        }


        /* =========================================================
           DAY
        ========================================================== */

        .day-header {

            width: 14%;

        }


        .day-cell {

            width: 14%;

            background-color: #6c757d;

            color: #ffffff;

            font-weight: bold;

            font-size: 9px;

            text-align: center;

            vertical-align: middle;

        }


        /* =========================================================
           TIME
        ========================================================== */

        .time-header {

            width: 19.75%;

        }


        /* =========================================================
           LUNCH HEADER
        ========================================================== */

        .lunch-header {

            width: 7%;

            padding: 0 !important;

        }


        /* =========================================================
           LUNCH CELL
        ========================================================== */

        .lunch-cell {

            width: 7%;

            padding: 0 !important;

            background-color: #dee2e6;

            text-align: center;

            vertical-align: middle;

        }


        /* =========================================================
           LUNCH TEXT
        ========================================================== */

        .lunch-text {

            display: inline-block;

            font-family: 'NotoSansMyanmar', sans-serif;

            font-size: 8px;

            font-weight: bold;

            color: #6c757d;

            white-space: nowrap;

            text-align: center;

            transform: rotate(-90deg);

            -webkit-transform: rotate(-90deg);

        }


        /* =========================================================
           SUBJECT
        ========================================================== */

        .subject-cell {

            background-color: #ffffff;

            text-align: center;

            vertical-align: middle;

        }


        .subject-code {

            display: block;

            margin-bottom: 2px;

            font-size: 9px;

            font-weight: bold;

            color: #007bff;

            line-height: 1.1;

        }


        .teacher-name {

            display: block;

            font-size: 7px;

            color: #6c757d;

            line-height: 1.1;

        }


        /* =========================================================
           EMPTY
        ========================================================== */

        .empty-slot {

            background-color: #fafafa;

            text-align: center;

            vertical-align: middle;

        }


        .extra-curriculum {

            font-size: 7px;

            color: #6c757d;

        }


        /* =========================================================
           SUBJECT LIST
        ========================================================== */

        .subject-list {

            width: 100%;

            margin: 7px auto 0;

            page-break-inside: auto;

        }


        .subject-list table {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

        }


        .subject-list thead {

            display: table-header-group;

        }


        .subject-list tr {

            page-break-inside: avoid;

            page-break-after: auto;

        }


        /* =========================================================
           SUBJECT LIST HEADER
        ========================================================== */

        .subject-list th {

            padding: 3px 6px;

            border-bottom: 1px solid #bfc3c8;

            text-align: left;

            font-size: 8px;

            font-weight: bold;

            color: #374151;

            line-height: 1.1;

        }


        /* =========================================================
           SUBJECT LIST BODY
        ========================================================== */

        .subject-list td {

            padding: 3px 6px;

            border-bottom: 1px solid #e5e7eb;

            vertical-align: middle;

            font-size: 7.5px;

            line-height: 1.15;

        }


        .subject-code-list {

            width: 15%;

            font-weight: bold;

            color: #007bff;

            white-space: nowrap;

        }


        .subject-name-list {

            width: 85%;

            color: #6b7280;

            white-space: normal;

        }


        .teacher-text {

            color: #6c757d;

        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .footer {

            width: 100%;

            margin: 5px auto 0;

            text-align: right;

            font-size: 6.5px;

            color: #9ca3af;

        }


        /* =========================================================
           COMPACT MEDIUM
        ========================================================== */

        .compact-medium .header {

            margin-bottom: 5px;

        }


        .compact-medium .university-name {

            font-size: 16px;

        }


        .compact-medium .academic-info {

            font-size: 9px;

        }


        .compact-medium .timetable th {

            height: 29px;

            font-size: 7.5px;

        }


        .compact-medium .timetable td {

            height: 51px;

            font-size: 7.5px;

        }


        .compact-medium .subject-code {

            font-size: 8px;

            margin-bottom: 1px;

        }


        .compact-medium .teacher-name {

            font-size: 6.5px;

        }


        .compact-medium .subject-list {

            margin-top: 5px;

        }


        .compact-medium .subject-list th {

            padding: 2px 5px;

            font-size: 7.5px;

        }


        .compact-medium .subject-list td {

            padding: 2px 5px;

            font-size: 7px;

        }


        /* =========================================================
           COMPACT SMALL
        ========================================================== */

        .compact-small .header {

            margin-bottom: 4px;

        }


        .compact-small .university-name {

            font-size: 15px;

        }


        .compact-small .academic-info {

            font-size: 8.5px;

            line-height: 1.2;

        }


        .compact-small .timetable-info {

            margin-bottom: 3px;

            font-size: 7.5px;

        }


        .compact-small .timetable th {

            height: 27px;

            padding: 1px;

            font-size: 7px;

        }


        .compact-small .timetable td {

            height: 47px;

            padding: 1px;

            font-size: 7px;

        }


        .compact-small .day-cell {

            font-size: 8px;

        }


        .compact-small .subject-code {

            font-size: 7.5px;

            margin-bottom: 1px;

        }


        .compact-small .teacher-name {

            font-size: 6px;

        }


        .compact-small .extra-curriculum {

            font-size: 6px;

        }


        .compact-small .lunch-text {

            font-size: 7px;

        }


        .compact-small .subject-list {

            margin-top: 4px;

        }


        .compact-small .subject-list th {

            padding: 2px 4px;

            font-size: 7px;

        }


        .compact-small .subject-list td {

            padding: 2px 4px;

            font-size: 6.5px;

        }


        .compact-small .footer {

            margin-top: 3px;

            font-size: 6px;

        }


        /* =========================================================
           COMPACT ULTRA
        ========================================================== */

        .compact-ultra .header {

            margin-bottom: 3px;

        }


        .compact-ultra .university-name {

            font-size: 14px;

        }


        .compact-ultra .academic-info {

            font-size: 8px;

            line-height: 1.15;

        }


        .compact-ultra .timetable-info {

            margin-bottom: 2px;

            font-size: 7px;

        }


        .compact-ultra .timetable th {

            height: 25px;

            padding: 1px;

            font-size: 6.5px;

        }


        .compact-ultra .timetable td {

            height: 43px;

            padding: 1px;

            font-size: 6.5px;

        }


        .compact-ultra .day-cell {

            font-size: 7px;

        }


        .compact-ultra .subject-code {

            font-size: 7px;

            margin-bottom: 0;

        }


        .compact-ultra .teacher-name {

            font-size: 5.5px;

        }


        .compact-ultra .extra-curriculum {

            font-size: 5.5px;

        }


        .compact-ultra .lunch-text {

            font-size: 6.5px;

        }


        .compact-ultra .subject-list {

            margin-top: 3px;

        }


        .compact-ultra .subject-list th {

            padding: 1.5px 3px;

            font-size: 6.5px;

        }


        .compact-ultra .subject-list td {

            padding: 1.5px 3px;

            font-size: 6px;

            line-height: 1.05;

        }


        .compact-ultra .footer {

            margin-top: 2px;

            font-size: 5.5px;

        }

    </style>

</head>


<body>


<div class="pdf-wrapper">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="header">

        <div class="university-name">

            ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

        </div>


        <div class="academic-info">

            {{ $academicYear->name ?? '' }}

            ပညာသင်နှစ်

            @if ($semesters)

                ({{ $semesters->name }})

            @endif

            <br>

            {{ $yearData->name ?? '' }}

            ({{ $major->name ?? '' }})

            -

            Section({{ $sections->name ?? '' }})

        </div>

    </div>


    {{-- =========================================================
        INFORMATION
    ========================================================== --}}

    <div class="timetable-info">

        <table>

            <tr>

                <td class="info-left">

                    အတန်း -

                    {{ $yearData->name ?? '' }}

                    ({{ $major->name ?? '' }})

                </td>


                <td class="info-right">

                    Section({{ $sections->name ?? '' }})

                    -

                    အခန်း({{ $room->name ?? '' }})

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
        TIMETABLE
    ========================================================== --}}

    <table class="timetable">

        <thead>

        <tr>

            <th class="day-header">

                Day / Time

            </th>


            @foreach ($times as $time)

                @php

                    $timeName = trim($time->name);

                    $isLunch =
                        str_replace(' ', '', $timeName)
                        === '12:00-01:00';

                @endphp


                @if ($isLunch)

                    <th class="lunch-header">

                        &nbsp;

                    </th>

                @else

                    <th class="time-header">

                        {{ $time->name }}

                    </th>

                @endif

            @endforeach

        </tr>

        </thead>


        <tbody>

        @foreach ($days as $dayIndex => $day)

            <tr>

                {{-- DAY --}}

                <td class="day-cell">

                    {{ $day->name }}

                </td>


                @foreach ($times as $time)

                    @php

                        $timeName = trim($time->name);

                        $isLunch =
                            str_replace(' ', '', $timeName)
                            === '12:00-01:00';

                    @endphp


                    {{-- =================================================
                        LUNCH
                    ================================================== --}}

                    @if ($isLunch)

                        @if ($dayIndex === 0)

                            <td
                                rowspan="{{ $days->count() }}"
                                class="lunch-cell"
                            >

                                <span class="lunch-text">

                                    ထမင်းစားနားချိန်

                                </span>

                            </td>

                        @endif


                    {{-- =================================================
                        NORMAL TIME
                    ================================================== --}}

                    @else

                        @php

                            $schedule = $schedules
                                ->where('day_id', $day->id)
                                ->where('time_id', $time->id)
                                ->first();

                        @endphp


                        @if (!$schedule)

                            <td class="empty-slot">

                                <span class="extra-curriculum">

                                    Extra Curriculum

                                </span>

                            </td>


                        @else

                            <td class="subject-cell">

                                <span class="subject-code">

                                    {{ $schedule->subject->short_name ?? '' }}

                                </span>


                                @if ($schedule->teacher)

                                    <span class="teacher-name">

                                        {{ $schedule->teacher->name }}

                                    </span>

                                @endif

                            </td>

                        @endif

                    @endif

                @endforeach

            </tr>

        @endforeach

        </tbody>

    </table>


    {{-- =========================================================
        SUBJECT LIST
    ========================================================== --}}

    <div class="subject-list">

        <table>

            <thead>

            <tr>

                <th style="width: 15%;">

                    Subject Code

                </th>


                <th style="width: 85%;">

                    Subject Name

                </th>

            </tr>

            </thead>


            <tbody>

            @foreach ($uniqueSubjects as $item)

                <tr>

                    <td class="subject-code-list">

                        {{ $item->subject->short_name ?? '' }}

                    </td>


                    <td class="subject-name-list">

                        {{ $item->subject->long_name ?? '' }}


                        @if ($item->teacher)

                            <span class="teacher-text">

                                ({{ $item->teacher->name }})

                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}

    <div class="footer">

        Generated Timetable

    </div>


</div>


</body>

</html>
