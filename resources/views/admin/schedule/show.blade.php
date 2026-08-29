@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid timetable-page">

        {{-- =====================================================
        SECTION FILTER
    ====================================================== --}}

        <div class="section-filter">

            <div class="section-filter-title" style="color: #010408 !important;">

                <i class="mr-2 fa-solid fa-layer-group"></i>

                Select Section

            </div>


            <div class="section-buttons">


                {{-- =================================================
                ALL BUTTON
            ================================================== --}}

                <button type="button" class="section-btn active" data-section-filter="all" data-section-name="">

                    All

                </button>


                {{-- =================================================
                SECTION BUTTONS
            ================================================== --}}

                @foreach ($sections as $sectionItem)
                    @php

                        $hasSchedule = $schedules->where('section_id', $sectionItem->id)->count() > 0;

                    @endphp


                    @if ($hasSchedule)
                        <button type="button" class="section-btn" data-section-filter="{{ $sectionItem->id }}"
                            data-section-name="{{ $sectionItem->name }}">

                            Section {{ $sectionItem->name }}

                        </button>
                    @endif
                @endforeach

            </div>

        </div>

        {{-- =========================================================
        HEADER
    ========================================================== --}}

        <div class="mb-4 text-center">

            <h2 class="font-weight-bold" style="color: #010408 !important;">

                <i class="mr-2 fa-solid fa-building-columns"></i>

                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

            </h2>


            <h4 class="mt-3 font-weight-bold" style="color: #010408 !important;">

                {{ $academicYear->name ?? '' }}

                ပညာသင်နှစ်

                @if (isset($semester) && $semester)
                    ({{ $semester->name ?? '' }})
                @endif

                <br><br>

                {{ $yearData->name ?? '' }}

                ({{ $major->name ?? '' }})

                {{-- =================================================
                DYNAMIC SECTION NAME
            ================================================== --}}

                <span id="selectedSectionHeader"></span>

            </h4>

        </div>



        {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <i class="mr-2 fa-solid fa-circle-check"></i>

                {{ session('success') }}

                <button type="button" class="close" data-dismiss="alert">

                    <span>&times;</span>

                </button>

            </div>
        @endif



        {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}

        @if ($errors->any())
            <div class="alert alert-danger">

                <strong>

                    <i class="mr-2 fa-solid fa-triangle-exclamation"></i>

                    Error

                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif



        {{-- =========================================================
        EMPTY
    ========================================================== --}}

        @if ($schedules->isEmpty())
            <div class="py-5 text-center text-muted">

                <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

                <h5>

                    အချိန်ဇယား မရှိပါ။

                </h5>

            </div>
        @else
            {{-- =====================================================
            TIMETABLES
        ====================================================== --}}

            @foreach ($sections as $sectionItem)
                @php

                    $sectionSchedules = $schedules->where('section_id', $sectionItem->id);

                @endphp


                @if ($sectionSchedules->count() > 0)
                    <div class="section-timetable" data-section="{{ $sectionItem->id }}">


                        {{-- =================================================
                        SECTION HEADER
                    ================================================== --}}

                        <div class="section-title" style="color: #010408 !important;">

                            <div>

                                <span class="section-title-icon">

                                    <i class="fa-solid fa-layer-group"></i>

                                </span>


                                <span>

                                    Section {{ $sectionItem->name }}

                                </span>

                            </div>


                            <div class="section-title-info" style="color: #010408 !important;">

                                {{ $yearData->name ?? '' }}

                                -

                                {{ $major->name ?? '' }}

                            </div>

                        </div>



                        {{-- =================================================
                        INFO
                    ================================================== --}}

                        <div class="timetable-info" style="color: #010408 !important;">

                            <div>

                                အတန်း -

                                <strong>

                                    {{ $yearData->name ?? '' }}

                                </strong>

                                ({{ $major->name ?? '' }})
                            </div>


                            <div>

                                Section

                                <strong>

                                    {{ $sectionItem->name }}

                                </strong>

                                -

                                အခန်း

                                <strong>

                                    {{ optional($sectionSchedules->first())->room->name ?? ($room->name ?? '') }}

                                </strong>

                            </div>

                        </div>



                        {{-- =================================================
                        TIMETABLE
                    ================================================== --}}

                        <div class="table-responsive print-table">

                            <table class="table table-bordered text-center align-middle timetable-table">

                                <thead>

                                    <tr>

                                        <th class="table-header day-column">

                                            Day / Time

                                        </th>


                                        @foreach ($times as $time)
                                            @if ($time->name == '12:00-01:00')
                                                <th class="table-header lunch-column">

                                                    &nbsp;

                                                </th>
                                            @else
                                                <th class="table-header time-column">

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

                                            <td class="day-cell day-column">

                                                {{ $day->name }}

                                            </td>


                                            @foreach ($times as $time)
                                                {{-- =================================================
                                                LUNCH
                                            ================================================== --}}

                                                @if ($time->name == '12:00-01:00')
                                                    @if ($dayIndex == 0)
                                                        <td rowspan="{{ $days->count() }}" class="lunch-cell lunch-column">

                                                            <span class="lunch-text" style="color: #010408 !important;">

                                                                ထမင်းစားနားချိန်

                                                            </span>

                                                        </td>
                                                    @endif
                                                @else
                                                    {{-- =================================================
                                                    FIND SCHEDULE
                                                ================================================== --}}

                                                    @php

                                                        $schedule = $sectionSchedules->first(function ($item) use (
                                                            $day,
                                                            $time,
                                                        ) {
                                                            return (int) $item->day_id === (int) $day->id &&
                                                                (int) $item->time_id === (int) $time->id;
                                                        });
                                                    @endphp



                                                    {{-- =================================================
                                                    SUBJECT
                                                ================================================== --}}

                                                    @if ($schedule)
                                                        <td class="schedule-cell subject-slot" draggable="true"
                                                            data-schedule-id="{{ $schedule->id }}"
                                                            data-section-id="{{ $sectionItem->id }}"
                                                            data-day-id="{{ $schedule->day_id }}"
                                                            data-time-id="{{ $schedule->time_id }}">

                                                            <div class="subject-content">


                                                                <span class="subject-code" style="color: #010408 !important;">

                                                                    {{ $schedule->subject->short_name ?? '' }}

                                                                </span>


                                                                @if ($schedule->teacher)
                                                                    <small class="teacher-name" style="color: #010408 !important;">

                                                                        {{ $schedule->teacher->name }}

                                                                    </small>
                                                                @endif

                                                            </div>

                                                        </td>
                                                    @else
                                                        {{-- EMPTY --}}

                                                        <td class="schedule-cell empty-slot"
                                                            data-section-id="{{ $sectionItem->id }}"
                                                            data-day-id="{{ $day->id }}"
                                                            data-time-id="{{ $time->id }}">

                                                            <span class="text-muted extra-text" style="color: #010408 !important;">

                                                                Extra Curriculum

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



                        {{-- =================================================
                        SUBJECT LIST
                    ================================================== --}}

                        <div class="mt-4">

                            <table class="table table-borderless subject-table">

                                <thead>

                                    <tr>

                                        <th class="font-weight-bold" width="15%" style="color: #010408 !important;">

                                            Subject Code

                                        </th>

                                        <th class="font-weight-bold" width="85%" style="color: #010408 !important;">

                                            Subject Name

                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach ($sectionSchedules->unique('subject_id') as $item)
                                        <tr>

                                            <td class="font-weight-bold" style="color: #010408 !important;">

                                                {{ $item->subject->short_name ?? '' }}

                                            </td>


                                            <td class="font-weight-bold" style="color: #010408 !important;">

                                                {{ $item->subject->long_name ?? '' }}


                                                @if ($item->teacher)
                                                    <span class="font-weight-bold" style="color: #010408 !important;">

                                                        ({{ $item->teacher->name }})
                                                    </span>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>



                        {{-- =================================================
                        BUTTONS
                    ================================================== --}}

                        <div class="mt-4 mb-5 text-center print-hide">


                            {{-- PRINT --}}

                            <button type="button" onclick="window.print()" class="px-4 mr-2 btn btn-primary">

                                <i class="mr-1 fa-solid fa-print"></i>

                                Print Timetable

                            </button>



                            {{-- PDF --}}

                            @if (isset($academicYear, $semester, $yearData, $major))
                                <a href="{{ route('schedule.pdf', [
                                    'year' => $yearData->id,

                                    'room' => optional($sectionSchedules->first())->room_id,

                                    'major' => $major->id,

                                    'academicYearID' => $academicYear->id,

                                    'semesterID' => $semester->id,

                                    'sectionID' => $sectionItem->id,
                                ]) }}"
                                    class="px-4 mr-2 btn btn-danger">

                                    <i class="mr-1 fa-solid fa-file-pdf"></i>

                                    Download PDF

                                </a>
                            @endif



                            {{-- MANUAL --}}

                            @if (isset($yearData, $major) && optional($sectionSchedules->first())->room_id)
                                <a href="{{ route('schedule.create', [$yearData->id, optional($sectionSchedules->first())->room_id, $major->id]) }}"
                                    class="px-4 btn btn-success">

                                    <i class="mr-1 fa-solid fa-pen"></i>

                                    Manual Timetable

                                </a>
                            @endif

                        </div>

                    </div>
                @endif
            @endforeach
        @endif

    </div>



    {{-- =========================================================
    LOADING
========================================================= --}}

    <div id="swapLoading" class="swap-loading">

        <div class="swap-loading-box">

            <div class="spinner-border text-primary"></div>

            <h5 class="mt-3 mb-1">

                Swapping Timetable...

            </h5>

            <small class="text-muted">

                Please wait...

            </small>

        </div>

    </div>

@endsection



{{-- =========================================================
    CSS
========================================================= --}}

<style>
    .timetable-page {
        padding-bottom: 30px;
    }


    /* =========================================================
   SECTION FILTER
========================================================= */

    .section-filter {

        margin-bottom: 25px;
        padding: 18px;
        background: #ffffff;
        border-radius: 12px;

        box-shadow:
            0 4px 15px rgba(0, 0, 0, .06);
    }


    .section-filter-title {

        margin-bottom: 12px;

        font-weight: 700;

        color: #343a40;
    }


    .section-buttons {

        display: flex;

        flex-wrap: wrap;

        gap: 8px;
    }


    .section-btn {

        border: 1px solid #007bff;

        background: #ffffff;

        color: #007bff;

        border-radius: 6px;

        padding: 7px 16px;

        font-size: 13px;

        font-weight: 600;

        cursor: pointer;

        transition: .2s;
    }


    .section-btn:hover {

        background: #007bff;

        color: #ffffff;
    }


    .section-btn.active {

        background: #007bff;

        color: #ffffff;
    }


    /* =========================================================
   SECTION TIMETABLE
========================================================= */

    .section-timetable {

        margin-bottom: 45px;

        padding: 18px;

        background: #ffffff;

        border-radius: 12px;

        box-shadow:
            0 4px 18px rgba(0, 0, 0, .07);
    }


    .section-title {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 12px;

        padding: 12px 16px;

        border-radius: 8px;

        background: #f8f9fa;

        font-size: 17px;

        font-weight: 700;

        color: #343a40;
    }


    .section-title-icon {

        display: inline-flex;

        justify-content: center;

        align-items: center;

        width: 34px;

        height: 34px;

        margin-right: 8px;

        border-radius: 8px;

        background: #007bff;

        color: #ffffff;
    }


    .section-title-info {

        font-size: 13px;

        color: #6c757d;

        font-weight: 600;
    }


    /* =========================================================
   INFO
========================================================= */

    .timetable-info {

        width: 100%;

        display: flex;

        justify-content: space-between;

        align-items: center;

        font-weight: bold;

        margin-bottom: 10px;

        padding: 5px 2px;
    }


    /* =========================================================
   TABLE
========================================================= */

    .timetable-table {

        width: 100% !important;

        table-layout: fixed !important;

        border-collapse: collapse !important;

        margin-bottom: 0 !important;
    }


    .timetable-table .day-column {

        width: 18% !important;
    }


    .timetable-table .time-column {

        width: 18% !important;
    }


    .timetable-table .lunch-column {

        width: 8% !important;
    }


    .print-table thead th.table-header {

        background-color: #6c757d !important;

        color: #fff !important;

        text-align: center;

        vertical-align: middle;

        height: 42px;

        padding: 6px 4px !important;

        font-size: 13px;
    }


    .print-table td.day-cell {

        background-color: #6c757d !important;

        color: #fff !important;

        font-weight: bold;

        text-align: center;

        vertical-align: middle;

        height: 42px;

        padding: 5px !important;
    }


    .print-table td.schedule-cell {

        height: 70px !important;

        padding: 5px 3px !important;

        text-align: center;

        vertical-align: middle;
    }


    /* =========================================================
   SUBJECT
========================================================= */

    .subject-slot {

        cursor: grab;

        background-color: #fff;

        user-select: none;

        transition: all .15s ease;
    }


    .subject-slot:hover {

        background-color: #f0f7ff;
    }


    .subject-slot:active {

        cursor: grabbing;
    }


    .subject-content {

        min-height: 55px;

        display: flex;

        flex-direction: column;

        justify-content: center;

        align-items: center;
    }


    .subject-code {

        font-size: 14px;

        font-weight: bold;

        color: #007bff;
    }


    .teacher-name {

        margin-top: 5px;

        color: #6c757d;
    }


    /* =========================================================
   EMPTY
========================================================= */

    .empty-slot {

        background-color: #fafafa;
    }


    .extra-text {

        font-size: 12px;
    }


    /* =========================================================
   DRAG
========================================================= */

    .dragging {

        opacity: .4;
    }


    .drag-over {

        background-color: #dbeafe !important;

        border: 3px dashed #007bff !important;
    }


    /* =========================================================
   LUNCH
========================================================= */

    .lunch-cell {

        width: 8% !important;

        padding: 0 !important;

        text-align: center !important;

        vertical-align: middle !important;

        background-color: #dee2e6 !important;
    }


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


    /* =========================================================
   LOADING
========================================================= */

    .swap-loading {

        display: none;

        position: fixed;

        z-index: 999999;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        background: rgba(0, 0, 0, .45);

        justify-content: center;

        align-items: center;
    }


    .swap-loading-box {

        background: #fff;

        padding: 35px 55px;

        border-radius: 12px;

        text-align: center;

        box-shadow:
            0 10px 30px rgba(0, 0, 0, .2);
    }


    .swap-loading-box .spinner-border {

        width: 45px;

        height: 45px;
    }


    /* =========================================================
   MOBILE
========================================================= */

    @media(max-width: 768px) {

        .section-title {

            flex-direction: column;

            align-items: flex-start;

            gap: 8px;
        }


        .timetable-info {

            flex-direction: column;

            align-items: flex-start;

            gap: 5px;
        }


        .section-timetable {

            padding: 10px;
        }


        .print-table {

            overflow-x: auto;
        }


        .timetable-table {

            min-width: 900px !important;
        }

    }


    /* =========================================================
   PRINT
========================================================= */

    @media print {

        @page {

            size: A4 landscape;

            margin: 8mm;
        }


        .print-hide {

            display: none !important;
        }


        .section-filter {

            display: none !important;
        }


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

            margin: 0 !important;
        }


        .table-responsive {

            overflow: visible !important;
        }


        html,
        body,
        * {

            -webkit-print-color-adjust: exact !important;

            print-color-adjust: exact !important;
        }


        .section-timetable {

            box-shadow: none !important;

            border-radius: 0 !important;

            padding: 0 !important;

            margin-bottom: 20mm !important;

            page-break-after: always;
        }


        .section-timetable:last-child {

            page-break-after: auto;
        }


        .section-title {

            box-shadow: none !important;

            border-radius: 0 !important;
        }


        .timetable-table {

            width: 100% !important;

            table-layout: fixed !important;

            border-collapse: collapse !important;
        }


        .timetable-table .day-column {

            width: 18% !important;
        }


        .timetable-table .time-column {

            width: 18% !important;
        }


        .timetable-table .lunch-column {

            width: 8% !important;
        }


        .print-table thead th.table-header {

            background-color: #6c757d !important;

            color: #fff !important;

            height: 38px !important;
        }


        .print-table td.day-cell {

            background-color: #6c757d !important;

            color: #fff !important;
        }


        .print-table td.schedule-cell {

            height: 40px !important;
        }


        .print-table table,
        .print-table th,
        .print-table td {

            border: 1px solid #000 !important;
        }


        .subject-table {

            margin-top: 8px !important;
        }

    }
</style>



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {


        /* =========================================================
           CSRF
        ========================================================== */

        const csrfMeta =
            document.querySelector(
                'meta[name="csrf-token"]'
            );


        if (!csrfMeta) {

            console.error(
                'CSRF token meta tag not found.'
            );

            return;

        }


        const csrfToken =
            csrfMeta.getAttribute('content');


        if (!csrfToken) {

            console.error(
                'CSRF token is empty.'
            );

            return;

        }



        /* =========================================================
           SECTION FILTER + HEADER
        ========================================================== */

        const sectionButtons =
            document.querySelectorAll(
                '[data-section-filter]'
            );


        const sectionTables =
            document.querySelectorAll(
                '.section-timetable'
            );


        const selectedSectionHeader =
            document.getElementById(
                'selectedSectionHeader'
            );


        /*
        |--------------------------------------------------------------------------
        | DEFAULT = ALL
        |--------------------------------------------------------------------------
        |
        | All ဖြစ်တဲ့အချိန် Section မပြပါ။
        |
        */

        if (selectedSectionHeader) {

            selectedSectionHeader.textContent = '';

        }


        sectionButtons.forEach(function(button) {


            button.addEventListener(
                'click',
                function() {


                    const selected =
                        this.getAttribute(
                            'data-section-filter'
                        );


                    const sectionName =
                        this.getAttribute(
                            'data-section-name'
                        );


                    /* =====================================================
                       ACTIVE BUTTON
                    ====================================================== */

                    sectionButtons.forEach(
                        function(item) {

                            item.classList.remove(
                                'active'
                            );

                        }
                    );


                    this.classList.add(
                        'active'
                    );



                    /* =====================================================
                       HEADER SECTION
                    ====================================================== */

                    if (selectedSectionHeader) {


                        if (
                            selected === 'all' ||
                            !sectionName
                        ) {

                            /*
                            | All => Section မပြ
                            */

                            selectedSectionHeader.textContent =
                                '';

                        } else {

                            /*
                            | A => - Section A
                            | B => - Section B
                            */

                            selectedSectionHeader.textContent =
                                ' - Section ' +
                                sectionName;

                        }

                    }



                    /* =====================================================
                       SHOW / HIDE TIMETABLE
                    ====================================================== */

                    sectionTables.forEach(
                        function(table) {


                            if (
                                selected === 'all'
                            ) {

                                table.style.display =
                                    '';

                            } else {


                                const sectionID =
                                    table.getAttribute(
                                        'data-section'
                                    );


                                if (
                                    sectionID === selected
                                ) {

                                    table.style.display =
                                        '';

                                } else {

                                    table.style.display =
                                        'none';

                                }

                            }

                        }
                    );

                }
            );

        });



        /* =========================================================
           DRAG & DROP
        ========================================================== */

        let draggedCell = null;

        let isSwapping = false;


        const subjectCells =
            document.querySelectorAll(
                '.subject-slot'
            );


        const allScheduleCells =
            document.querySelectorAll(
                '.schedule-cell'
            );



        /* =========================================================
           DRAG START
        ========================================================== */

        subjectCells.forEach(
            function(cell) {


                cell.addEventListener(
                    'dragstart',
                    function(event) {


                        if (isSwapping) {

                            event.preventDefault();

                            return;

                        }


                        const scheduleId =
                            this.getAttribute(
                                'data-schedule-id'
                            );


                        if (!scheduleId) {

                            event.preventDefault();

                            return;

                        }


                        draggedCell = this;


                        this.classList.add(
                            'dragging'
                        );


                        event.dataTransfer.effectAllowed =
                            'move';


                        event.dataTransfer.setData(
                            'text/plain',
                            scheduleId
                        );

                    }
                );



                /* =================================================
                   DRAG END
                ================================================= */

                cell.addEventListener(
                    'dragend',
                    function() {


                        this.classList.remove(
                            'dragging'
                        );


                        allScheduleCells.forEach(
                            function(item) {

                                item.classList.remove(
                                    'drag-over'
                                );

                            }
                        );


                        draggedCell = null;

                    }
                );

            }
        );



        /* =========================================================
           DRAG OVER
        ========================================================== */

        subjectCells.forEach(
            function(cell) {


                cell.addEventListener(
                    'dragover',
                    function(event) {


                        event.preventDefault();


                        if (
                            !draggedCell ||
                            isSwapping
                        ) {

                            return;

                        }


                        if (
                            this === draggedCell
                        ) {

                            return;

                        }


                        event.dataTransfer.dropEffect =
                            'move';


                        this.classList.add(
                            'drag-over'
                        );

                    }
                );



                /* =================================================
                   DRAG LEAVE
                ================================================= */

                cell.addEventListener(
                    'dragleave',
                    function() {

                        this.classList.remove(
                            'drag-over'
                        );

                    }
                );



                /* =================================================
                   DROP
                ================================================= */

                cell.addEventListener(
                    'drop',
                    function(event) {


                        event.preventDefault();


                        this.classList.remove(
                            'drag-over'
                        );


                        if (
                            !draggedCell ||
                            isSwapping
                        ) {

                            return;

                        }


                        if (
                            this === draggedCell
                        ) {

                            return;

                        }


                        const schedule1Id =
                            parseInt(
                                draggedCell.getAttribute(
                                    'data-schedule-id'
                                ),
                                10
                            );


                        const schedule2Id =
                            parseInt(
                                this.getAttribute(
                                    'data-schedule-id'
                                ),
                                10
                            );


                        if (
                            !Number.isInteger(
                                schedule1Id
                            ) ||
                            !Number.isInteger(
                                schedule2Id
                            ) ||
                            schedule1Id <= 0 ||
                            schedule2Id <= 0
                        ) {

                            alert(
                                'Invalid Schedule ID. Please refresh the page.'
                            );

                            return;

                        }


                        const confirmed =
                            confirm(
                                'ဒီ Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်မှာ သေချာပါသလား?'
                            );


                        if (!confirmed) {

                            return;

                        }


                        swapSchedules(
                            schedule1Id,
                            schedule2Id
                        );

                    }
                );

            }
        );



        /* =========================================================
           AJAX SWAP
        ========================================================== */

        function swapSchedules(
            schedule1Id,
            schedule2Id
        ) {


            if (isSwapping) {

                return;

            }


            isSwapping = true;


            showLoading();


            fetch(
                    "{{ route('schedule.swap') }}", {

                        method: 'POST',

                        headers: {

                            'Content-Type': 'application/json',

                            'Accept': 'application/json',

                            'X-CSRF-TOKEN': csrfToken,

                            'X-Requested-With': 'XMLHttpRequest'

                        },

                        body: JSON.stringify({

                            schedule1_id: schedule1Id,

                            schedule2_id: schedule2Id

                        })

                    }
                )


                .then(
                    async function(response) {


                        let data;


                        try {

                            data =
                                await response.json();

                        } catch (error) {

                            throw new Error(
                                'Server က JSON response မပြန်ပါ။'
                            );

                        }


                        if (!response.ok) {

                            throw new Error(
                                data.message ||
                                'Swap failed.'
                            );

                        }


                        return data;

                    }
                )


                .then(
                    function(data) {


                        if (!data.success) {

                            throw new Error(
                                data.message ||
                                'Swap failed.'
                            );

                        }


                        window.location.reload();

                    }
                )


                .catch(
                    function(error) {


                        console.error(
                            'SWAP ERROR:',
                            error
                        );


                        hideLoading();


                        isSwapping = false;


                        alert(
                            error.message ||
                            'Unable to swap timetable.'
                        );

                    }
                );

        }



        /* =========================================================
           SHOW LOADING
        ========================================================== */

        function showLoading() {

            const loading =
                document.getElementById(
                    'swapLoading'
                );


            if (!loading) {

                return;

            }


            loading.style.display =
                'flex';

        }



        /* =========================================================
           HIDE LOADING
        ========================================================== */

        function hideLoading() {

            const loading =
                document.getElementById(
                    'swapLoading'
                );


            if (!loading) {

                return;

            }


            loading.style.display =
                'none';

        }

    });
</script>
