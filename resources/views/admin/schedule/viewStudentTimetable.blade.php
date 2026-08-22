@extends('admin.layouts.master')

@section('content')

<div class="container-fluid timetable-page">

    {{-- =========================================================
        SECTION FILTER
    ========================================================== --}}

    <div class="section-filter print-hide">

        <div class="section-filter-title">
            <i class="mr-2 fa-solid fa-layer-group"></i>
            Select Section
        </div>

        <div class="section-buttons">

            {{-- ALL --}}
            <button
                type="button"
                class="section-btn active"
                data-section-filter="all"
                data-section-name=""
            >
                All
            </button>


            {{-- SECTIONS --}}
            @foreach($sections as $sectionItem)

                @php
                    $hasSchedule = $schedules
                        ->where('section_id', $sectionItem->id)
                        ->count() > 0;
                @endphp

                @if($hasSchedule)

                    <button
                        type="button"
                        class="section-btn"
                        data-section-filter="{{ $sectionItem->id }}"
                        data-section-name="{{ $sectionItem->name }}"
                    >
                        Section {{ $sectionItem->name }}
                    </button>

                @endif

            @endforeach

        </div>

    </div>



    {{-- =========================================================
        MAIN HEADER
    ========================================================== --}}

    <div class="mb-4 text-center timetable-header">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-building-columns"></i>

            ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

        </h2>


        <h4 class="mt-3 text-dark font-weight-bold">

            {{ $academicYear->name ?? '' }}

            ပညာသင်နှစ်

            @if(isset($semester) && $semester)

                ({{ $semester->name ?? '' }})

            @endif

            <br><br>

            {{ $yearData->name ?? '' }}

            ({{ $major->name ?? '' }})

            <span id="selectedSectionHeader"></span>

        </h4>

    </div>



    {{-- =========================================================
        SUCCESS
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show print-hide">

            <i class="mr-2 fa-solid fa-circle-check"></i>

            {{ session('success') }}

            <button
                type="button"
                class="close"
                data-dismiss="alert"
            >
                <span>&times;</span>
            </button>

        </div>

    @endif



    {{-- =========================================================
        ERROR
    ========================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger print-hide">

            <strong>

                <i class="mr-2 fa-solid fa-triangle-exclamation"></i>

                Error

            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- =========================================================
        EMPTY
    ========================================================== --}}

    @if($schedules->isEmpty())

        <div class="py-5 text-center text-muted empty-timetable">

            <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

            <h5>
                အချိန်ဇယား မရှိပါ။
            </h5>

        </div>

    @else


        {{-- =====================================================
            SECTION TIMETABLES
        ====================================================== --}}

        @foreach($sections as $sectionItem)

            @php

                /*
                |--------------------------------------------------------------------------
                | CURRENT SECTION SCHEDULES
                |--------------------------------------------------------------------------
                */

                $sectionSchedules = $schedules
                    ->where('section_id', $sectionItem->id);


                /*
                |--------------------------------------------------------------------------
                | SKIP EMPTY SECTION
                |--------------------------------------------------------------------------
                */

                if($sectionSchedules->count() === 0) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SECTION ROOM
                |
                | Room ကို ဒီ Section ရဲ့ Schedule ထဲကနေယူမယ်။
                |--------------------------------------------------------------------------
                */

                $sectionRoom =
                    $sectionSchedules
                        ->first()
                        ?->room;


                /*
                |--------------------------------------------------------------------------
                | ROOM ID
                |--------------------------------------------------------------------------
                */

                $sectionRoomId =
                    $sectionSchedules
                        ->first()
                        ?->room_id;

            @endphp



            {{-- =================================================
                SECTION CONTAINER
            ================================================== --}}

            <div
                class="section-timetable"
                data-section="{{ $sectionItem->id }}"
            >


                {{-- =================================================
                    SECTION HEADER
                ================================================== --}}

                <div class="section-title">

                    <div>

                        <span class="section-title-icon">

                            <i class="fa-solid fa-layer-group"></i>

                        </span>

                        <span>
                            Section {{ $sectionItem->name }}
                        </span>

                    </div>


                    <div class="section-title-info">

                        {{ $yearData->name ?? '' }}

                        -

                        {{ $major->name ?? '' }}

                    </div>

                </div>



                {{-- =================================================
                    SECTION INFO
                ================================================== --}}

                <div class="timetable-info">

                    <div>

                        အတန်း -

                        <strong>

                            {{ $yearData->name ?? '-' }}

                        </strong>

                        ({{ $major->name ?? '-' }})

                    </div>


                    <div>

                        Section

                        <strong>

                            {{ $sectionItem->name }}

                        </strong>

                        -

                        အခန်း

                        <strong>

                            {{ $sectionRoom->name ?? '-' }}

                        </strong>

                    </div>

                </div>



                {{-- =================================================
                    TIMETABLE
                ================================================== --}}

                <div class="table-responsive print-table">

                    <table
                        class="table table-bordered text-center align-middle timetable-table"
                    >

                        <thead>

                            <tr>

                                <th class="table-header day-column">

                                    Day / Time

                                </th>


                                @foreach($times as $time)

                                    @if($time->name === '12:00-01:00')

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

                            @foreach($days as $dayIndex => $day)

                                <tr>

                                    {{-- =================================
                                        DAY
                                    ================================== --}}

                                    <td class="day-cell day-column">

                                        {{ $day->name }}

                                    </td>



                                    @foreach($times as $time)

                                        {{-- =================================
                                            LUNCH
                                        ================================== --}}

                                        @if($time->name === '12:00-01:00')

                                            @if($dayIndex === 0)

                                                <td
                                                    rowspan="{{ $days->count() }}"
                                                    class="lunch-cell lunch-column"
                                                >

                                                    <span class="lunch-text">

                                                        ထမင်းစားနားချိန်

                                                    </span>

                                                </td>

                                            @endif


                                        @else

                                            {{-- =================================
                                                FIND SECTION SCHEDULE
                                            ================================== --}}

                                            @php

                                                $schedule =
                                                    $sectionSchedules->first(
                                                        function($item) use(
                                                            $day,
                                                            $time
                                                        ) {

                                                            return
                                                                (int)$item->day_id
                                                                ===
                                                                (int)$day->id

                                                                &&

                                                                (int)$item->time_id
                                                                ===
                                                                (int)$time->id;

                                                        }
                                                    );

                                            @endphp



                                            {{-- =================================
                                                EMPTY SLOT
                                            ================================== --}}

                                            @if(!$schedule)

                                                <td
                                                    class="schedule-cell empty-slot"
                                                    data-section-id="{{ $sectionItem->id }}"
                                                    data-day-id="{{ $day->id }}"
                                                    data-time-id="{{ $time->id }}"
                                                >

                                                    <span class="text-muted extra-text">

                                                        Extra Curriculum

                                                    </span>

                                                </td>


                                            {{-- =================================
                                                SUBJECT SLOT
                                            ================================== --}}

                                            @else

                                                <td
                                                    class="schedule-cell subject-slot"
                                                    draggable="true"

                                                    data-schedule-id="{{ $schedule->id }}"

                                                    data-section-id="{{ $sectionItem->id }}"

                                                    data-day-id="{{ $schedule->day_id }}"

                                                    data-time-id="{{ $schedule->time_id }}"
                                                >

                                                    <div class="subject-content">

                                                        <span class="subject-code">

                                                            {{ $schedule->subject->short_name ?? '' }}

                                                        </span>


                                                        @if($schedule->teacher)

                                                            <small class="teacher-name">

                                                                {{ $schedule->teacher->name }}

                                                            </small>

                                                        @endif

                                                    </div>

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

                <div class="mt-4 subject-list">

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

                            @foreach(
                                $sectionSchedules->unique('subject_id')
                                as $subjectItem
                            )

                                <tr>

                                    <td class="font-weight-bold text-primary">

                                        {{ $subjectItem->subject->short_name ?? '' }}

                                    </td>


                                    <td>

                                        {{ $subjectItem->subject->long_name ?? '' }}


                                        @if($subjectItem->teacher)

                                            <span class="text-muted">

                                                ({{ $subjectItem->teacher->name }})

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                {{-- =================================================
                    ACTION BUTTONS
                ================================================== --}}

                <div class="mt-4 mb-5 text-center timetable-actions print-hide">


                    {{-- PRINT --}}

                    <button
                        type="button"
                        onclick="printSection('{{ $sectionItem->id }}')"
                        class="action-btn print-btn"
                    >

                        <i class="mr-2 fa-solid fa-print"></i>

                        Print Timetable

                    </button>



                    {{-- PDF --}}

                    @if(
                        isset($academicYear) &&
                        $academicYear &&
                        isset($semester) &&
                        $semester &&
                        isset($yearData) &&
                        $yearData &&
                        isset($major) &&
                        $major &&
                        $sectionRoomId
                    )

                        <a
                            href="{{ route('schedule.pdf', [

                                'year' =>
                                    $yearData->id,

                                'room' =>
                                    $sectionRoomId,

                                'major' =>
                                    $major->id,

                                'academicYearID' =>
                                    $academicYear->id,

                                'semesterID' =>
                                    $semester->id,

                                'sectionID' =>
                                    $sectionItem->id,

                            ]) }}"

                            class="action-btn pdf-btn"
                        >

                            <i class="mr-2 fa-solid fa-file-pdf"></i>

                            Download PDF

                        </a>

                    @endif



                    {{-- MANUAL --}}

                    @if(
                        isset($yearData) &&
                        $yearData &&
                        isset($major) &&
                        $major &&
                        $sectionRoomId
                    )

                        <a
                            href="{{ route(
                                'schedule.create',
                                [
                                    $yearData->id,
                                    $sectionRoomId,
                                    $major->id
                                ]
                            ) }}"

                            class="action-btn manual-btn"
                        >

                            <i class="mr-2 fa-solid fa-pen"></i>

                            Manual Timetable

                        </a>

                    @endif

                </div>

            </div>

        @endforeach

    @endif

</div>



{{-- =========================================================
    LOADING
========================================================= --}}

<div
    id="swapLoading"
    class="swap-loading"
>

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
    padding-top: 15px;
    padding-bottom: 40px;
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
        0 4px 15px rgba(0,0,0,.06);
}


.section-filter-title {

    margin-bottom: 12px;

    color: #343a40;

    font-weight: 700;
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

    transition: all .2s ease;
}


.section-btn:hover {

    background: #007bff;

    color: #ffffff;

    transform: translateY(-1px);
}


.section-btn.active {

    background: #007bff;

    color: #ffffff;

    box-shadow:
        0 4px 10px rgba(0,123,255,.20);
}



/* =========================================================
   HEADER
========================================================= */

.timetable-header {

    margin-bottom: 25px;
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
        0 4px 18px rgba(0,0,0,.07);
}


.section-title {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 12px;

    padding: 12px 16px;

    border-radius: 8px;

    background: #f8f9fa;

    color: #343a40;

    font-size: 17px;

    font-weight: 700;
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

    color: #6c757d;

    font-size: 13px;

    font-weight: 600;
}



/* =========================================================
   INFO
========================================================= */

.timetable-info {

    display: flex;

    justify-content: space-between;

    align-items: center;

    width: 100%;

    margin-bottom: 10px;

    padding: 5px 2px;

    font-weight: bold;
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


.print-table th,
.print-table td {

    border: 1px solid #000 !important;
}


.print-table thead th.table-header {

    background-color: #6c757d !important;

    color: #ffffff !important;

    text-align: center;

    vertical-align: middle;

    height: 42px;

    padding: 6px 4px !important;

    font-size: 13px;
}


.print-table td.day-cell {

    background-color: #6c757d !important;

    color: #ffffff !important;

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

    background-color: #ffffff;

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

    color: #007bff;

    font-size: 14px;

    font-weight: bold;
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

    display: inline-block;

    font-weight: bold;

    font-size: 13px;
}



/* =========================================================
   SUBJECT LIST
========================================================= */

.subject-table,
.subject-table th,
.subject-table td {

    border: none !important;
}


.subject-table {

    margin-bottom: 0;
}


.subject-table thead {

    border-bottom: 2px solid #dee2e6;
}


.subject-table th {

    color: #495057;

    font-size: 14px;
}


.subject-table td {

    padding: 8px 10px;
}



/* =========================================================
   ACTION BUTTONS
========================================================= */

.timetable-actions {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 10px;

    flex-wrap: wrap;
}


.action-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 190px;

    padding: 11px 22px;

    border: none;

    border-radius: 7px;

    font-size: 14px;

    font-weight: 600;

    text-decoration: none !important;

    cursor: pointer;

    transition: all .2s ease;
}


.action-btn:hover {

    transform: translateY(-1px);

    box-shadow:
        0 5px 12px rgba(0,0,0,.12);
}


.print-btn {

    background: #0d6efd;

    color: #ffffff;
}


.print-btn:hover {

    background: #0b5ed7;

    color: #ffffff;
}


.pdf-btn {

    background: #dc3545;

    color: #ffffff;
}


.pdf-btn:hover {

    background: #bb2d3b;

    color: #ffffff;
}


.manual-btn {

    background: #198754;

    color: #ffffff;
}


.manual-btn:hover {

    background: #157347;

    color: #ffffff;
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

    background: rgba(0,0,0,.45);

    justify-content: center;

    align-items: center;
}


.swap-loading-box {

    background: #ffffff;

    padding: 35px 55px;

    border-radius: 12px;

    text-align: center;

    box-shadow:
        0 10px 30px rgba(0,0,0,.25);
}



/* =========================================================
   MOBILE
========================================================= */

@media(max-width:768px) {

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


    .timetable-actions {

        flex-direction: column;
    }


    .action-btn {

        width: 100%;

        max-width: 300px;
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

        color: #ffffff !important;

        height: 38px !important;
    }


    .print-table td.day-cell {

        background-color: #6c757d !important;

        color: #ffffff !important;
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

document.addEventListener(
    'DOMContentLoaded',
    function () {

        'use strict';



        /* =====================================================
           SECTION FILTER
        ====================================================== */

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



        sectionButtons.forEach(
            function(button) {

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



                        /* =========================================
                           ACTIVE BUTTON
                        ========================================== */

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



                        /* =========================================
                           HEADER
                        ========================================== */

                        if(selectedSectionHeader) {

                            if(
                                selected === 'all' ||
                                !sectionName
                            ) {

                                selectedSectionHeader.textContent =
                                    '';

                            }
                            else {

                                selectedSectionHeader.textContent =
                                    ' - Section ' +
                                    sectionName;

                            }

                        }



                        /* =========================================
                           SHOW / HIDE
                        ========================================== */

                        sectionTables.forEach(
                            function(table) {

                                const tableSection =
                                    table.getAttribute(
                                        'data-section'
                                    );


                                if(
                                    selected === 'all'
                                ) {

                                    table.style.display =
                                        '';

                                }
                                else if(
                                    tableSection ===
                                    selected
                                ) {

                                    table.style.display =
                                        '';

                                }
                                else {

                                    table.style.display =
                                        'none';

                                }

                            }
                        );

                    }
                );

            }
        );



        /* =====================================================
           DRAG & DROP
        ====================================================== */

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


        const loading =
            document.getElementById(
                'swapLoading'
            );


        const swapUrl =
            @json(route('schedule.swap'));


        const csrfToken =
            @json(csrf_token());



        /* =====================================================
           DRAG START
        ====================================================== */

        subjectCells.forEach(
            function(cell) {

                cell.addEventListener(
                    'dragstart',
                    function(event) {

                        if(isSwapping) {

                            event.preventDefault();

                            return;

                        }


                        const scheduleId =
                            this.getAttribute(
                                'data-schedule-id'
                            );


                        if(!scheduleId) {

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
                ================================================== */

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



        /* =====================================================
           DRAG OVER
        ====================================================== */

        subjectCells.forEach(
            function(cell) {

                cell.addEventListener(
                    'dragover',
                    function(event) {

                        event.preventDefault();


                        if(
                            !draggedCell ||
                            isSwapping ||
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
                ================================================== */

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
                ================================================== */

                cell.addEventListener(
                    'drop',
                    function(event) {

                        event.preventDefault();


                        this.classList.remove(
                            'drag-over'
                        );


                        if(
                            !draggedCell ||
                            isSwapping ||
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


                        if(
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


                        if(
                            schedule1Id ===
                            schedule2Id
                        ) {

                            return;

                        }


                        const confirmed =
                            confirm(
                                'ဒီ Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်မှာ သေချာပါသလား?'
                            );


                        if(!confirmed) {

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



        /* =====================================================
           AJAX SWAP
        ====================================================== */

        async function swapSchedules(
            schedule1Id,
            schedule2Id
        ) {

            if(isSwapping) {

                return;

            }


            isSwapping = true;


            showLoading();


            try {

                const response =
                    await fetch(
                        swapUrl,
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,

                                'X-Requested-With':
                                    'XMLHttpRequest'

                            },

                            body:
                                JSON.stringify({

                                    schedule1_id:
                                        schedule1Id,

                                    schedule2_id:
                                        schedule2Id

                                })

                        }
                    );


                const text =
                    await response.text();


                let data;


                try {

                    data =
                        JSON.parse(text);

                }
                catch(error) {

                    console.error(
                        'SERVER RESPONSE:',
                        text
                    );

                    throw new Error(
                        'Server က JSON response မပြန်ပါ။'
                    );

                }


                if(!response.ok) {

                    throw new Error(
                        data.message ||
                        'Swap failed.'
                    );

                }


                if(!data.success) {

                    throw new Error(
                        data.message ||
                        'Swap failed.'
                    );

                }


                window.location.reload();

            }
            catch(error) {

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

        }



        /* =====================================================
           LOADING
        ====================================================== */

        function showLoading() {

            if(loading) {

                loading.style.display =
                    'flex';

            }

        }


        function hideLoading() {

            if(loading) {

                loading.style.display =
                    'none';

            }

        }

    }
);



/* =========================================================
   PRINT SINGLE SECTION
========================================================= */

function printSection(sectionId)
{

    const allSections =
        document.querySelectorAll(
            '.section-timetable'
        );


    const selectedSection =
        document.querySelector(
            '.section-timetable[data-section="' +
            sectionId +
            '"]'
        );


    if(!selectedSection) {

        return;

    }


    allSections.forEach(
        function(section) {

            if(
                section.getAttribute(
                    'data-section'
                ) === sectionId
            ) {

                section.classList.add(
                    'print-selected'
                );

            }
            else {

                section.classList.add(
                    'print-hidden'
                );

            }

        }
    );


    window.print();


    setTimeout(
        function() {

            allSections.forEach(
                function(section) {

                    section.classList.remove(
                        'print-selected'
                    );

                    section.classList.remove(
                        'print-hidden'
                    );

                }
            );

        },
        500
    );

}

</script>



<style>

@media print {

    .section-timetable.print-hidden {

        display: none !important;

    }


    .section-timetable.print-selected {

        display: block !important;

    }

}

</style>
