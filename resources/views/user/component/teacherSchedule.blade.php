@extends('user.layouts.master')

@section('content')

    <div class="teacher-schedule-page">

        <div class="container">

            {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}

            <div class="teacher-header">

                <div class="teacher-header-left">

                    <div class="teacher-icon">
                        <i class="lni lni-user"></i>
                    </div>

                    <div>

                        <div class="teacher-label">
                            Teacher Schedule
                        </div>

                        <h2 class="teacher-name">
                            {{ $teacher->name ?? 'Teacher' }}
                        </h2>

                        @if (!empty($teacher->email))
                            <div class="teacher-email">
                                <i class="lni lni-envelope"></i>
                                {{ $teacher->email }}
                            </div>
                        @endif

                    </div>


                </div>

                <button type="button" class="teacher-print-btn" onclick="window.print()">
                    <i class="lni lni-printer"></i>
                    Print Schedule
                </button>

            </div>


            {{-- =========================================================
            SUMMARY
        ========================================================== --}}

            @php

                $totalPeriods = $schedules->count();

                $subjectCount = $schedules->whereNotNull('subject_id')->unique('subject_id')->count();

                $dayCount = $schedules->whereNotNull('day_id')->unique('day_id')->count();

            @endphp


            <div class="teacher-summary">

                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="lni lni-calendar"></i>
                    </div>

                    <div>

                        <span>
                            Weekly Periods
                        </span>

                        <strong>
                            {{ $totalPeriods }}
                        </strong>

                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="lni lni-book"></i>
                    </div>

                    <div>

                        <span>
                            Subjects
                        </span>

                        <strong>
                            {{ $subjectCount }}
                        </strong>

                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="lni lni-calendar"></i>
                    </div>

                    <div>

                        <span>
                            Teaching Days
                        </span>

                        <strong>
                            {{ $dayCount }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            EMPTY
        ========================================================== --}}

            @if ($schedules->isEmpty())

                <div class="empty-schedule">

                    <div class="empty-icon">
                        <i class="lni lni-calendar"></i>
                    </div>

                    <h4>
                        No Schedule Available
                    </h4>

                    <p>
                        သင်ကြားရန် အချိန်ဇယား မရှိသေးပါ။
                    </p>

                </div>
            @else
                {{-- =====================================================
                ONLY THIS SECTION WILL BE PRINTED
            ====================================================== --}}

                <div class="schedule-card">

                    {{-- SCREEN ONLY HEADER --}}

                    <div class="schedule-card-header screen-only">

                        <div>

                            <h4>

                                <i class="lni lni-calendar"></i>

                                Weekly Timetable

                            </h4>

                            <span>
                                Monday - Friday
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                    TIMETABLE
                ================================================== --}}

                    <div class="table-scroll">

                        <table class="teacher-timetable">

                            <thead>

                                <tr>

                                    <th class="day-header">
                                        Day / Time
                                    </th>


                                    @foreach ($times as $time)
                                        @php

                                            $isLunch = strtolower(trim($time->name)) === '12:00-01:00';

                                        @endphp


                                        @if ($isLunch)
                                            <th class="lunch-header">
                                                &nbsp;
                                            </th>
                                        @else
                                            <th>
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

                                        <td class="day-name">

                                            {{ $day->name }}

                                        </td>


                                        @foreach ($times as $time)
                                            @php

                                                $isLunch = strtolower(trim($time->name)) === '12:00-01:00';

                                            @endphp


                                            {{-- =================================================
                                            LUNCH
                                        ================================================== --}}

                                            @if ($isLunch)
                                                @if ($dayIndex === 0)
                                                    <td rowspan="{{ $days->count() }}" class="lunch-cell">

                                                        <div class="lunch-content">

                                                            <span>
                                                                ထမင်းစားနားချိန်
                                                            </span>

                                                        </div>

                                                    </td>
                                                @endif


                                                {{-- =================================================
                                            NORMAL PERIOD
                                        ================================================== --}}
                                            @else
                                                @php

                                                    $schedule = $schedules->first(function ($item) use ($day, $time) {
                                                        return (int) $item->day_id === (int) $day->id &&
                                                            (int) $item->time_id === (int) $time->id;
                                                    });
                                                @endphp


                                                @if ($schedule)
                                                    <td class="schedule-slot">

                                                        <div class="subject-box">

                                                            {{-- SUBJECT CODE --}}

                                                            @if ($schedule->subject)
                                                                <div class="subject-code">

                                                                    {{ $schedule->subject->short_name ?? ($schedule->subject->name ?? '-') }}

                                                                </div>
                                                            @endif


                                                            {{-- SUBJECT NAME --}}

                                                            @if ($schedule->subject)
                                                                <div class="subject-name">

                                                                    {{ $schedule->subject->long_name ?? ($schedule->subject->name ?? '') }}

                                                                </div>
                                                            @endif


                                                            {{-- YEAR / MAJOR / SECTION --}}

                                                            <div class="class-info">

                                                                @if ($schedule->year)
                                                                    <span>
                                                                        {{ $schedule->year->name }}
                                                                    </span>
                                                                @endif


                                                                @if ($schedule->major)
                                                                    <span>
                                                                        {{ $schedule->major->name }}
                                                                    </span>
                                                                @endif


                                                                @if ($schedule->section)
                                                                    <span>

                                                                        Section
                                                                        {{ $schedule->section->name }}

                                                                    </span>
                                                                @endif

                                                            </div>


                                                            {{-- ROOM --}}

                                                            @if ($schedule->room)
                                                                <div class="room-info">

                                                                    <i class="lni lni-map-marker"></i>

                                                                    {{ $schedule->room->name }}

                                                                </div>
                                                            @endif

                                                        </div>

                                                    </td>
                                                @else
                                                    <td class="empty-slot">

                                                        <span>
                                                            စာသင်ချိန်လွတ်
                                                        </span>

                                                    </td>
                                                @endif
                                            @endif
                                        @endforeach

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =================================================
                SUBJECT LIST
                SCREEN ONLY
            ================================================== --}}

                @php

                    $teacherSubjects = $schedules
                        ->filter(function ($schedule) {
                            return $schedule->subject !== null;
                        })
                        ->unique('subject_id');

                @endphp


                @if ($teacherSubjects->count() > 0)
                    <div class="subject-card screen-only">

                        <div class="subject-card-header">

                            <h4>

                                <i class="lni lni-book"></i>

                                Teaching Subjects

                            </h4>

                        </div>


                        <div class="subject-table-wrapper">

                            <table class="subject-table">

                                <thead>

                                    <tr>

                                        <th width="18%">
                                            Code
                                        </th>

                                        <th width="42%">
                                            Subject
                                        </th>

                                        <th width="20%">
                                            Class
                                        </th>

                                        <th width="20%">
                                            Room
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach ($teacherSubjects as $schedule)
                                        <tr>

                                            <td>

                                                <span class="code-badge">

                                                    {{ $schedule->subject->short_name ?? '-' }}

                                                </span>

                                            </td>


                                            <td>

                                                <strong>

                                                    {{ $schedule->subject->long_name ?? ($schedule->subject->name ?? '-') }}

                                                </strong>

                                            </td>


                                            <td>

                                                <div class="class-list">

                                                    @if ($schedule->year)
                                                        <span>
                                                            {{ $schedule->year->name }}
                                                        </span>
                                                    @endif


                                                    @if ($schedule->major)
                                                        <span>
                                                            {{ $schedule->major->name }}
                                                        </span>
                                                    @endif


                                                    @if ($schedule->section)
                                                        <span>
                                                            Section
                                                            {{ $schedule->section->name }}
                                                        </span>
                                                    @endif

                                                </div>

                                            </td>


                                            <td>

                                                @if ($schedule->room)
                                                    <span class="room-badge">

                                                        <i class="lni lni-map-marker"></i>

                                                        {{ $schedule->room->name }}

                                                    </span>
                                                @else
                                                    -
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                @endif

            @endif

        </div>

    </div>

@endsection


<style>
    /* =========================================================
   PAGE
========================================================= */

    .teacher-schedule-page {
        min-height: calc(100vh - 78px);
        padding: 45px 0 70px;
        background: #f7f9fc;
    }


    /* =========================================================
   HEADER
========================================================= */

    .teacher-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
        padding: 24px 28px;
        background: #ffffff;
        border: 1px solid #edf1f6;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .05);
    }

    .teacher-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .teacher-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 15px;
        background: #eef5ff;
        color: #1769e0;
    }

    .teacher-icon i {
        font-size: 25px;
    }

    .teacher-label {
        margin-bottom: 4px;
        color: #8a96a6;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .teacher-name {
        margin: 0;
        color: #17253a;
        font-size: 23px;
        font-weight: 800;
    }

    .teacher-email {
        margin-top: 5px;
        color: #8a96a6;
        font-size: 11px;
    }

    .teacher-email i {
        margin-right: 4px;
    }

    .teacher-print-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 18px;
        border: none;
        border-radius: 9px;
        background: #1769e0;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .teacher-print-btn:hover {
        background: #0b4ca8;
        color: #ffffff;
        transform: translateY(-1px);
    }


    /* =========================================================
   SUMMARY
========================================================= */

    .teacher-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .summary-card {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #edf1f6;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(20, 50, 90, .04);
    }

    .summary-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #f2f6fc;
        color: #1769e0;
    }

    .summary-icon i {
        font-size: 18px;
    }

    .summary-card span {
        display: block;
        margin-bottom: 3px;
        color: #8a96a6;
        font-size: 10px;
        font-weight: 600;
    }

    .summary-card strong {
        color: #17253a;
        font-size: 20px;
        font-weight: 800;
    }


    /* =========================================================
   SCHEDULE CARD
========================================================= */

    .schedule-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #edf1f6;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .05);
    }

    .schedule-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 22px;
        border-bottom: 1px solid #edf1f6;
    }

    .schedule-card-header h4 {
        margin: 0;
        color: #17253a;
        font-size: 16px;
        font-weight: 800;
    }

    .schedule-card-header h4 i {
        margin-right: 7px;
        color: #1769e0;
    }

    .schedule-card-header span {
        display: block;
        margin-top: 4px;
        color: #9aa5b4;
        font-size: 10px;
    }


    /* =========================================================
   TABLE SCROLL
========================================================= */

    .table-scroll {
        width: 100%;
        overflow-x: auto;
    }


    /* =========================================================
   TIMETABLE
========================================================= */

    .teacher-timetable {
        width: 100%;
        min-width: 1050px;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .teacher-timetable th,
    .teacher-timetable td {
        border: 1px solid #dfe5ed;
    }


    /* =========================================================
   TABLE HEADER
========================================================= */

    .teacher-timetable thead th {
        height: 48px;
        padding: 7px 5px;
        background: #000000;
        color: #ffffff;
        text-align: center;
        vertical-align: middle;
        font-size: 11px;
        font-weight: 700;
    }

    .teacher-timetable thead th:first-child {
        width: 15%;
    }

    .teacher-timetable thead th:not(:first-child) {
        width: 17%;
    }

    .teacher-timetable .day-header {
        background: #000000;
    }


    /* =========================================================
   LUNCH HEADER
========================================================= */

    .teacher-timetable .lunch-header {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
        padding: 0 !important;
        background: #000000;
    }


    /* =========================================================
   DAY
========================================================= */

    .day-name {
        height: 85px;
        padding: 8px;
        background: #000000;
        color: #ffffff;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
        font-weight: 800;
    }


    /* =========================================================
   NORMAL SCHEDULE SLOT
========================================================= */

    .schedule-slot {
        height: 100px;
        padding: 6px;
        background: #ffffff;
        text-align: center;
        vertical-align: middle;
    }

    .subject-box {
        display: flex;
        min-height: 82px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .subject-code {
        color: #1769e0;
        font-size: 13px;
        font-weight: 800;
    }

    .subject-name {
        max-width: 180px;
        margin-top: 4px;
        color: #34445a;
        font-size: 10px;
        font-weight: 600;
        line-height: 1.35;
    }

    .class-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 3px;
        margin-top: 5px;
    }

    .class-info span {
        padding: 2px 5px;
        border-radius: 4px;
        background: #f1f5fa;
        color: #64748b;
        font-size: 8px;
        font-weight: 600;
    }

    .room-info {
        margin-top: 5px;
        color: #7b8796;
        font-size: 9px;
        font-weight: 600;
    }

    .room-info i {
        margin-right: 2px;
        color: #1769e0;
    }


    /* =========================================================
   EMPTY SLOT
========================================================= */

    .empty-slot {
        height: 100px;
        padding: 5px;
        background: #fbfcfe;
        text-align: center;
        vertical-align: middle;
    }

    .empty-slot span {
        color: #000000;
        font-size: 15px;
    }


    /* =========================================================
   LUNCH CELL
========================================================= */

    .lunch-cell {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
        padding: 0 !important;
        background: #eef1f4 !important;
        text-align: center;
        vertical-align: middle;
    }

    .lunch-content {
        display: flex;
        height: 100%;
        min-height: 100px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .lunch-content span {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        color: #6f7b89;
        font-size: 10px;
        font-weight: 700;
    }


    /* =========================================================
   SUBJECT LIST
========================================================= */

    .subject-card {
        margin-top: 25px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #edf1f6;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .05);
    }

    .subject-card-header {
        padding: 19px 22px;
        border-bottom: 1px solid #edf1f6;
    }

    .subject-card-header h4 {
        margin: 0;
        color: #17253a;
        font-size: 15px;
        font-weight: 800;
    }

    .subject-card-header i {
        margin-right: 7px;
        color: #1769e0;
    }

    .subject-table-wrapper {
        overflow-x: auto;
    }

    .subject-table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
    }

    .subject-table th {
        padding: 12px 15px;
        background: #f7f9fc;
        color: #64748b;
        text-align: left;
        font-size: 10px;
        font-weight: 800;
        border-bottom: 1px solid #edf1f6;
    }

    .subject-table td {
        padding: 13px 15px;
        color: #475569;
        font-size: 11px;
        border-bottom: 1px solid #f0f2f5;
    }

    .subject-table tbody tr:last-child td {
        border-bottom: none;
    }

    .subject-table tbody tr:hover {
        background: #fafcff;
    }

    .code-badge {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 6px;
        background: #eef5ff;
        color: #1769e0;
        font-size: 10px;
        font-weight: 800;
    }

    .class-list {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }

    .class-list span {
        padding: 4px 6px;
        border-radius: 5px;
        background: #f4f6f9;
        color: #64748b;
        font-size: 8px;
    }

    .room-badge {
        color: #64748b;
        font-size: 10px;
        font-weight: 600;
    }

    .room-badge i {
        margin-right: 3px;
        color: #1769e0;
    }


    /* =========================================================
   EMPTY SCHEDULE
========================================================= */

    .empty-schedule {
        padding: 80px 20px;
        background: #ffffff;
        border: 1px solid #edf1f6;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .05);
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #f2f6fc;
        color: #8a96a6;
    }

    .empty-icon i {
        font-size: 26px;
    }

    .empty-schedule h4 {
        margin-bottom: 6px;
        color: #34445a;
        font-size: 17px;
        font-weight: 800;
    }

    .empty-schedule p {
        margin: 0;
        color: #9aa5b4;
        font-size: 11px;
    }


    /* =========================================================
   MOBILE
========================================================= */

    @media (max-width: 768px) {

        .teacher-schedule-page {
            padding-top: 25px;
        }

        .teacher-header {
            flex-direction: column;
            align-items: stretch;
            padding: 20px;
        }

        .teacher-header-left {
            align-items: flex-start;
        }

        .teacher-name {
            font-size: 19px;
        }

        .teacher-print-btn {
            width: 100%;
        }

        .teacher-summary {
            grid-template-columns: 1fr;
        }

        .summary-card {
            padding: 15px;
        }

        .schedule-card-header {
            padding: 17px;
        }
    }


    /* =========================================================
   PRINT
   ONLY TIMETABLE
========================================================= */

    @media print {

        /* -----------------------------------------------------
       PAGE
    ----------------------------------------------------- */

        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        html,
        body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
        }


        /* -----------------------------------------------------
       HIDE EVERYTHING
    ----------------------------------------------------- */

        body * {
            visibility: hidden !important;
        }


        /* -----------------------------------------------------
       SHOW ONLY TIMETABLE
    ----------------------------------------------------- */

        .schedule-card,
        .schedule-card * {
            visibility: visible !important;
        }


        /* -----------------------------------------------------
       PAGE CONTAINER
    ----------------------------------------------------- */

        .teacher-schedule-page {
            width: 100% !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
        }

        .container {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }


        /* -----------------------------------------------------
       SCHEDULE CARD
    ----------------------------------------------------- */

        .schedule-card {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;

            width: 100% !important;

            margin: 0 !important;
            padding: 0 !important;

            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;

            overflow: visible !important;

            background: #ffffff !important;
        }


        /* -----------------------------------------------------
       HIDE TIMETABLE TITLE
    ----------------------------------------------------- */

        .schedule-card-header {
            display: none !important;
            visibility: hidden !important;
        }


        /* -----------------------------------------------------
       TABLE SCROLL
    ----------------------------------------------------- */

        .table-scroll {
            width: 100% !important;
            overflow: visible !important;
            margin: 0 !important;
            padding: 0 !important;
        }


        /* -----------------------------------------------------
       TABLE
    ----------------------------------------------------- */

        .teacher-timetable {
            width: 100% !important;
            min-width: 0 !important;
            max-width: none !important;

            table-layout: fixed !important;
            border-collapse: collapse !important;

            margin: 0 !important;
            padding: 0 !important;

            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }


        /* -----------------------------------------------------
       TABLE BORDER
    ----------------------------------------------------- */

        .teacher-timetable th,
        .teacher-timetable td {
            border: 1px solid #222222 !important;

            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }


        /* -----------------------------------------------------
       HEADER
    ----------------------------------------------------- */

        .teacher-timetable thead th {
            height: 34px !important;

            padding: 3px !important;

            background: #68778a !important;
            color: #ffffff !important;

            text-align: center !important;
            vertical-align: middle !important;

            font-size: 8px !important;
            font-weight: 700 !important;
        }


        /* -----------------------------------------------------
       DAY / FIRST COLUMN
    ----------------------------------------------------- */

        .teacher-timetable thead th:first-child {
            width: 13% !important;
            min-width: 13% !important;
            max-width: 13% !important;
        }


        .day-name {
            width: 13% !important;
            min-width: 13% !important;
            max-width: 13% !important;

            height: 62px !important;

            padding: 3px !important;

            background: #68778a !important;
            color: #ffffff !important;

            text-align: center !important;
            vertical-align: middle !important;

            font-size: 8px !important;
            font-weight: 800 !important;
        }


        /* -----------------------------------------------------
       NORMAL TIME COLUMNS
    ----------------------------------------------------- */

        .teacher-timetable thead th:not(:first-child):not(.lunch-header) {
            width: auto !important;
        }


        /* -----------------------------------------------------
       LUNCH HEADER
       VERY NARROW
    ----------------------------------------------------- */

        .teacher-timetable .lunch-header {
            width: 3% !important;
            min-width: 3% !important;
            max-width: 3% !important;

            padding: 0 !important;

            background: #8a96a6 !important;
        }


        /* -----------------------------------------------------
       NORMAL SLOT
    ----------------------------------------------------- */

        .schedule-slot,
        .empty-slot {
            height: 62px !important;

            padding: 2px !important;

            text-align: center !important;
            vertical-align: middle !important;

            font-size: 7px !important;
        }


        /* -----------------------------------------------------
       SUBJECT BOX
    ----------------------------------------------------- */

        .subject-box {
            display: flex !important;

            width: 100% !important;

            min-height: 52px !important;
            height: 52px !important;

            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }


        /* -----------------------------------------------------
       SUBJECT CODE
    ----------------------------------------------------- */

        .subject-code {
            color: #1769e0 !important;

            font-size: 8px !important;
            font-weight: 800 !important;

            line-height: 1.1 !important;
        }


        /* -----------------------------------------------------
       SUBJECT NAME
    ----------------------------------------------------- */

        .subject-name {
            max-width: 115px !important;

            margin-top: 1px !important;

            color: #34445a !important;

            font-size: 6px !important;
            font-weight: 600 !important;

            line-height: 1.1 !important;
        }


        /* -----------------------------------------------------
       CLASS INFO
    ----------------------------------------------------- */

        .class-info {
            display: flex !important;

            flex-wrap: wrap !important;

            justify-content: center !important;

            gap: 1px !important;

            margin-top: 1px !important;
        }


        .class-info span {
            padding: 1px 2px !important;

            border-radius: 2px !important;

            background: #f1f5fa !important;
            color: #64748b !important;

            font-size: 5px !important;
            line-height: 1 !important;
        }


        /* -----------------------------------------------------
       ROOM
    ----------------------------------------------------- */

        .room-info {
            margin-top: 1px !important;

            color: #7b8796 !important;

            font-size: 5.5px !important;
            line-height: 1 !important;
        }

        .room-info i {
            margin-right: 1px !important;
            color: #1769e0 !important;
        }


        /* -----------------------------------------------------
       EMPTY SLOT
    ----------------------------------------------------- */

        .empty-slot {
            background: #fbfcfe !important;
        }

        .empty-slot span {
            color: #000000 !important;

            font-size: 6px !important;
        }


        /* -----------------------------------------------------
       LUNCH CELL
       VERY NARROW
    ----------------------------------------------------- */

        .lunch-cell {
            width: 3% !important;
            min-width: 3% !important;
            max-width: 3% !important;

            padding: 0 !important;

            background: #eef1f4 !important;

            text-align: center !important;
            vertical-align: middle !important;
        }


        /* -----------------------------------------------------
       LUNCH CONTENT
    ----------------------------------------------------- */

        .lunch-content {
            display: flex !important;

            width: 100% !important;

            min-height: 62px !important;
            height: 100% !important;

            padding: 0 !important;

            flex-direction: column !important;

            align-items: center !important;
            justify-content: center !important;
        }


        /* -----------------------------------------------------
       LUNCH TEXT
    ----------------------------------------------------- */

        .lunch-content span {
            writing-mode: vertical-rl !important;
            text-orientation: mixed !important;

            color: #6f7b89 !important;

            font-size: 6px !important;
            font-weight: 700 !important;

            white-space: nowrap !important;
        }


        /* -----------------------------------------------------
       DO NOT PRINT SUBJECT LIST
    ----------------------------------------------------- */

        .subject-card,
        .subject-card * {
            display: none !important;
            visibility: hidden !important;
        }


        /* -----------------------------------------------------
       HIDE OTHER UI
    ----------------------------------------------------- */

        .teacher-header,
        .teacher-summary,
        .teacher-print-btn,
        .empty-schedule,
        .ucsm-navbar,
        .ucsm-footer {
            display: none !important;
            visibility: hidden !important;
        }


        /* -----------------------------------------------------
       PREVENT PAGE BREAK
    ----------------------------------------------------- */

        .schedule-card,
        .teacher-timetable,
        .teacher-timetable tbody,
        .teacher-timetable tr {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }


        /* -----------------------------------------------------
       REMOVE EXTRA SPACE
    ----------------------------------------------------- */

        .teacher-schedule-page,
        .container,
        .schedule-card,
        .table-scroll {
            box-sizing: border-box !important;
        }

    }
</style>
