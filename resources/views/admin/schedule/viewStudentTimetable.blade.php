@extends('admin.layouts.master')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | CURRENT FILTERS
    |--------------------------------------------------------------------------
    */
    $selectedMajorID = request()->query('majorID');
    $selectedSectionID = request()->query('sectionID');

    /*
    |--------------------------------------------------------------------------
    | AVAILABLE MAJORS
    |--------------------------------------------------------------------------
    */
    $availableMajors = $schedules
        ->filter(fn($item) => $item->major)
        ->pluck('major')
        ->unique('id')
        ->sortBy('name')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | SELECTED MAJOR
    |--------------------------------------------------------------------------
    */
    $selectedMajor = null;

    if ($selectedMajorID) {
        $selectedMajor = $availableMajors
            ->firstWhere('id', (int) $selectedMajorID);
    }

    /*
    |--------------------------------------------------------------------------
    | FILTERED SCHEDULES
    |--------------------------------------------------------------------------
    */
    $displaySchedules = $schedules;

    if ($selectedMajor) {
        $displaySchedules = $displaySchedules
            ->where('major_id', $selectedMajor->id);
    }

    /*
    |--------------------------------------------------------------------------
    | DISPLAY MAJOR
    |--------------------------------------------------------------------------
    */
    $displayMajor =
        $selectedMajor
        ?? $displaySchedules->first()?->major
        ?? $major;

    /*
    |--------------------------------------------------------------------------
    | DISPLAY SECTIONS
    |--------------------------------------------------------------------------
    */
    $displaySectionIDs = $displaySchedules
        ->whereNotNull('section_id')
        ->pluck('section_id')
        ->unique()
        ->values();

    $displaySections = $sections
        ->whereIn('id', $displaySectionIDs)
        ->sortBy('name')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | DISPLAY ROOM
    |--------------------------------------------------------------------------
    */
    $displayRoom =
        $displaySchedules->first()?->room
        ?? $room;

    /*
    |--------------------------------------------------------------------------
    | DISPLAY ACADEMIC YEAR
    |--------------------------------------------------------------------------
    */
    $displayAcademicYear =
        $displaySchedules->first()?->academicYear
        ?? $academicYear;

    /*
    |--------------------------------------------------------------------------
    | DISPLAY SEMESTER
    |--------------------------------------------------------------------------
    */
    $displaySemester =
        $displaySchedules->first()?->semester
        ?? $semester;
@endphp


<div class="container-fluid timetable-page">

    {{-- =========================================================
        FILTER
    ========================================================== --}}
    <div class="filter-card print-hide">

        <div class="filter-title font-weight-bold"
             style="color: #1e3a8a !important;">

            <i class="mr-2 fa-solid fa-filter text-primary"></i>

            Timetable Filter
        </div>


        <form method="GET"
              action="{{ url()->current() }}"
              class="filter-form">

            {{-- YEAR --}}
            <div class="filter-group">

                <label class="font-weight-bold"
                       style="color: #1e3a8a !important;">
                    Year
                </label>

                <select name="yearID"
                        class="form-control font-weight-bold"
                        onchange="this.form.submit()"
                        style="color: #1e3a8a !important;">

                    @foreach($years as $year)

                        <option value="{{ $year->id }}"
                            {{ (int)$year->id === (int)$yearData->id ? 'selected' : '' }}>

                            {{ $year->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- MAJOR --}}
            <div class="filter-group">

                <label class="font-weight-bold"
                       style="color: #1e3a8a !important;">
                    Major
                </label>

                <select name="majorID"
                        class="form-control font-weight-bold"
                        onchange="this.form.submit()"
                        style="color: #1e3a8a !important;">

                    <option value="">
                        All Major
                    </option>

                    @foreach($availableMajors as $majorItem)

                        <option value="{{ $majorItem->id }}"
                            {{ $selectedMajorID && (int)$selectedMajorID === (int)$majorItem->id ? 'selected' : '' }}>

                            {{ $majorItem->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- SECTION --}}
            <div class="filter-group">

                <label class="font-weight-bold"
                       style="color: #1e3a8a !important;">
                    Section
                </label>

                <select name="sectionID"
                        class="form-control font-weight-bold"
                        onchange="this.form.submit()"
                        style="color: #1e3a8a !important;">

                    <option value="">
                        All Section
                    </option>

                    @foreach($displaySections as $sectionItem)

                        <option value="{{ $sectionItem->id }}"
                            {{ $selectedSectionID && (int)$selectedSectionID === (int)$sectionItem->id ? 'selected' : '' }}>

                            Section {{ $sectionItem->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- RESET --}}
            <div class="filter-group filter-button-group">

                <a href="{{ url()->current() }}"
                   class="reset-btn font-weight-bold">

                    <i class="mr-1 fa-solid fa-rotate-left"></i>

                    Reset

                </a>

            </div>

        </form>

    </div>



    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="mb-4 text-center timetable-header">

        <h2 class="font-weight-bold text-primary">

            <i class="mr-2 fa-solid fa-building-columns"></i>

            ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

        </h2>


        <h4 class="mt-3 font-weight-bold"
            style="color: #1e3a8a !important;">

            {{ $displayAcademicYear->name ?? '' }}
            ပညာသင်နှစ်

            @if($displaySemester)

                ({{ $displaySemester->name ?? '' }})

            @endif

            <br><br>

            {{ $yearData->name ?? '' }}

            @if($displayMajor)

                ({{ $displayMajor->name }})

            @endif

            @if($selectedSectionID)

                @php

                    $headerSection = $displaySections
                        ->firstWhere('id', (int)$selectedSectionID);

                @endphp

                @if($headerSection)

                    - Section {{ $headerSection->name }}

                @endif

            @endif

        </h4>

    </div>



    {{-- =========================================================
        EMPTY
    ========================================================== --}}
    @if($displaySchedules->isEmpty())

        <div class="empty-timetable font-weight-bold"
             style="color: #1e3a8a !important;">

            <i class="text-primary fa-solid fa-calendar-xmark"></i>

            <h5 class="font-weight-bold"
                style="color: #1e3a8a !important;">

                အချိန်ဇယား မရှိပါ။

            </h5>

            <p class="font-weight-bold"
               style="color: #1e3a8a !important;">

                ရွေးချယ်ထားသော Major / Section အတွက် timetable မရှိသေးပါ။

            </p>

        </div>

    @else


        {{-- =====================================================
            SECTION FILTER BUTTONS
        ====================================================== --}}
        <div class="section-filter print-hide">

            <div class="section-filter-title font-weight-bold"
                 style="color: #1e3a8a !important;">

                <i class="mr-2 fa-solid fa-layer-group text-primary"></i>

                Select Section

            </div>


            <div class="section-buttons">

                <button type="button"
                        class="section-btn active font-weight-bold"
                        data-section-filter="all"
                        data-section-name="">

                    All

                </button>


                @foreach($displaySections as $sectionItem)

                    @php

                        $hasSchedule =
                            $displaySchedules
                                ->where('section_id', $sectionItem->id)
                                ->count() > 0;

                    @endphp


                    @if($hasSchedule)

                        <button type="button"
                                class="section-btn font-weight-bold"
                                data-section-filter="{{ $sectionItem->id }}"
                                data-section-name="{{ $sectionItem->name }}">

                            Section {{ $sectionItem->name }}

                        </button>

                    @endif

                @endforeach

            </div>

        </div>



        {{-- =====================================================
            SECTION TIMETABLES
        ====================================================== --}}
        @foreach($displaySections as $sectionItem)

            @php

                $sectionSchedules =
                    $displaySchedules
                        ->where('section_id', $sectionItem->id);

                if($sectionSchedules->isEmpty()) {
                    continue;
                }

                $sectionRoom =
                    $sectionSchedules->first()?->room;

                $sectionRoomId =
                    $sectionSchedules->first()?->room_id;

            @endphp


            <div class="section-timetable"
                 data-section="{{ $sectionItem->id }}">


                {{-- =================================================
                    SECTION TITLE
                    SCREEN ONLY
                ================================================== --}}
                <div class="section-title print-hide">

                    <div>

                        <span class="section-title-icon">

                            <i class="fa-solid fa-layer-group"></i>

                        </span>


                        <span class="font-weight-bold"
                              style="color: #1e3a8a !important;">

                            Section {{ $sectionItem->name }}

                        </span>

                    </div>


                    <div class="section-title-info font-weight-bold"
                         style="color: #1e3a8a !important;">

                        {{ $yearData->name ?? '' }}
                        -
                        {{ $displayMajor->name ?? '' }}

                    </div>

                </div>



                {{-- =================================================
                    INFO
                ================================================== --}}
                <div class="timetable-info font-weight-bold"
                     style="color: #1e3a8a !important;">

                    <div>

                        အတန်း -

                        <strong style="color: #1e3a8a !important;">

                            {{ $yearData->name ?? '-' }}

                        </strong>

                        @if($displayMajor)

                            ({{ $displayMajor->name }})

                        @endif

                    </div>


                    <div>

                        Section

                        <strong style="color: #1e3a8a !important;">

                            {{ $sectionItem->name }}

                        </strong>

                        -

                        အခန်း

                        <strong style="color: #1e3a8a !important;">

                            {{ $sectionRoom->name ?? '-' }}

                        </strong>

                    </div>

                </div>



                {{-- =================================================
                    TIMETABLE
                ================================================== --}}
                <div class="table-responsive print-table">

                    <table class="table text-center align-middle table-bordered timetable-table">

                        <thead>

                            <tr>

                                <th class="table-header day-column font-weight-bold"
                                    style="color: #fff !important;">

                                    Day / Time

                                </th>


                                @foreach($times as $time)

                                    @if($time->name === '12:00-01:00')

                                        <th class="table-header lunch-column">
                                            &nbsp;
                                        </th>

                                    @else

                                        <th class="table-header time-column font-weight-bold"
                                            style="color: #fff !important;">

                                            {{ $time->name }}

                                        </th>

                                    @endif

                                @endforeach

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($days as $dayIndex => $day)

                                <tr>

                                    <td class="day-cell day-column font-weight-bold"
                                        style="color: #fff !important;">

                                        {{ $day->name }}

                                    </td>


                                    @foreach($times as $time)

                                        @if($time->name === '12:00-01:00')

                                            @if($dayIndex === 0)

                                                <td rowspan="{{ $days->count() }}"
                                                    class="lunch-cell lunch-column">

                                                    <span class="lunch-text font-weight-bold"
                                                          style="color: #1e3a8a !important;">

                                                        ထမင်းစားနားချိန်

                                                    </span>

                                                </td>

                                            @endif

                                        @else

                                            @php

                                                $schedule =
                                                    $sectionSchedules->first(
                                                        function($item) use($day, $time) {

                                                            return
                                                                (int)$item->day_id === (int)$day->id
                                                                &&
                                                                (int)$item->time_id === (int)$time->id;

                                                        }
                                                    );

                                            @endphp


                                            @if(!$schedule)

                                                <td class="schedule-cell empty-slot"
                                                    data-section-id="{{ $sectionItem->id }}"
                                                    data-day-id="{{ $day->id }}"
                                                    data-time-id="{{ $time->id }}">

                                                    <span class="extra-text font-weight-bold"
                                                          style="color: #64748b !important;">

                                                        Extra Curriculum

                                                    </span>

                                                </td>

                                            @else

                                                <td class="schedule-cell subject-slot"
                                                    draggable="true"
                                                    data-schedule-id="{{ $schedule->id }}"
                                                    data-section-id="{{ $sectionItem->id }}"
                                                    data-day-id="{{ $schedule->day_id }}"
                                                    data-time-id="{{ $schedule->time_id }}">

                                                    <div class="subject-content">

                                                        <span class="subject-code font-weight-bold"
                                                              style="color: #1d4ed8 !important;">

                                                            {{ $schedule->subject->short_name ?? '' }}

                                                        </span>


                                                        @if($schedule->teacher)

                                                            <small class="teacher-name font-weight-bold"
                                                                   style="color: #1e3a8a !important;">

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

                                <th width="15%"
                                    class="font-weight-bold"
                                    style="color: #1e3a8a !important;">

                                    Subject Code

                                </th>


                                <th width="85%"
                                    class="font-weight-bold"
                                    style="color: #1e3a8a !important;">

                                    Subject Name

                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach(
                                $sectionSchedules
                                    ->unique('subject_id')
                                    ->sortBy(
                                        fn($item) =>
                                            $item->subject->short_name ?? ''
                                    )
                                as $subjectItem
                            )

                                <tr>

                                    <td class="font-weight-bold text-primary"
                                        style="color: #1d4ed8 !important;">

                                        {{ $subjectItem->subject->short_name ?? '' }}

                                    </td>


                                    <td class="font-weight-bold"
                                        style="color: #1e3a8a !important;">

                                        {{ $subjectItem->subject->long_name ?? '' }}


                                        @if($subjectItem->teacher)

                                            <span class="font-weight-bold"
                                                  style="color: #475569 !important;">

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
                    ACTIONS
                ================================================== --}}
                <div class="mt-4 mb-5 text-center timetable-actions print-hide">

                    {{-- PRINT --}}
                    <button type="button"
                            onclick="printSection('{{ $sectionItem->id }}')"
                            class="action-btn print-btn font-weight-bold">

                        <i class="mr-2 fa-solid fa-print"></i>

                        Print Timetable

                    </button>


                    {{-- PDF --}}
                    @if(
                        $displayAcademicYear &&
                        $displaySemester &&
                        $yearData &&
                        $displayMajor &&
                        $sectionRoomId
                    )

                        <a href="{{ route('schedule.pdf', [
                            'year' => $yearData->id,
                            'room' => $sectionRoomId,
                            'major' => $displayMajor->id,
                            'academicYearID' => $displayAcademicYear->id,
                            'semesterID' => $displaySemester->id,
                            'sectionID' => $sectionItem->id,
                        ]) }}"
                           class="action-btn pdf-btn font-weight-bold">

                            <i class="mr-2 fa-solid fa-file-pdf"></i>

                            Download PDF

                        </a>

                    @endif


                    {{-- MANUAL --}}
                    @if(
                        $yearData &&
                        $displayMajor &&
                        $sectionRoomId
                    )

                        <a href="{{ route(
                            'schedule.create',
                            [
                                $yearData->id,
                                $sectionRoomId,
                                $displayMajor->id
                            ]
                        ) }}"
                           class="action-btn manual-btn font-weight-bold">

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
<div id="swapLoading"
     class="swap-loading">

    <div class="swap-loading-box">

        <div class="spinner-border text-primary"></div>

        <h5 class="mt-3 mb-1 font-weight-bold"
            style="color: #1e3a8a !important;">

            Swapping Timetable...

        </h5>

        <small class="font-weight-bold text-muted">

            Please wait...

        </small>

    </div>

</div>

@endsection



{{-- =========================================================
    CSS
========================================================= --}}
<style>

/* =========================================================
   PAGE
========================================================= */

.timetable-page {

    padding-top: 15px;

    padding-bottom: 40px;

}


/* =========================================================
   FILTER
========================================================= */

.filter-card {

    margin-bottom: 25px;

    padding: 20px;

    background: #ffffff;

    border-radius: 12px;

    box-shadow: 0 4px 18px rgba(0,0,0,.07);

}


.filter-title {

    margin-bottom: 18px;

    font-size: 16px;

    font-weight: 700;

    color: #1e3a8a !important;

}


.filter-form {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 15px;

    align-items: end;

}


.filter-group label {

    display: block;

    margin-bottom: 7px;

    font-size: 13px;

    font-weight: 700;

    color: #1e3a8a !important;

}


.filter-group .form-control {

    height: 42px;

    border-radius: 7px;

    color: #1e3a8a !important;

    font-weight: 700;

}


.filter-button-group {

    display: flex;

    align-items: flex-end;

}


.reset-btn {

    width: 100%;

    height: 42px;

    display: inline-flex;

    justify-content: center;

    align-items: center;

    border-radius: 7px;

    background: #64748b;

    color: #ffffff !important;

    text-decoration: none !important;

    font-weight: 700;

}


.reset-btn:hover {

    background: #475569;

}


/* =========================================================
   SECTION FILTER
========================================================= */

.section-filter {

    margin-bottom: 25px;

    padding: 18px;

    background: #ffffff;

    border-radius: 12px;

    box-shadow: 0 4px 15px rgba(0,0,0,.06);

}


.section-filter-title {

    margin-bottom: 12px;

    color: #1e3a8a !important;

    font-weight: 700;

}


.section-buttons {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

}


.section-btn {

    border: 1px solid #1d4ed8;

    background: #ffffff;

    color: #1d4ed8;

    border-radius: 6px;

    padding: 7px 16px;

    font-size: 13px;

    font-weight: 700;

    cursor: pointer;

    transition: all .2s ease;

}


.section-btn:hover {

    background: #1d4ed8;

    color: #ffffff;

}


.section-btn.active {

    background: #1d4ed8;

    color: #ffffff;

}


/* =========================================================
   HEADER
========================================================= */

.timetable-header {

    margin-bottom: 25px;

}


/* =========================================================
   SECTION
========================================================= */

.section-timetable {

    margin-bottom: 45px;

    padding: 18px;

    background: #ffffff;

    border-radius: 12px;

    box-shadow: 0 4px 18px rgba(0,0,0,.07);

}


.section-title {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 12px;

    padding: 12px 16px;

    border-radius: 8px;

    background: #f8f9fa;

    color: #1e3a8a !important;

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

    background: #1d4ed8;

    color: #ffffff;

}


.section-title-info {

    color: #1e3a8a !important;

    font-size: 13px;

    font-weight: 700;

}


/* =========================================================
   TIMETABLE INFO
========================================================= */

.timetable-info {

    display: flex;

    justify-content: space-between;

    align-items: center;

    width: 100%;

    margin-bottom: 10px;

    padding: 5px 2px;

    font-weight: 700;

    color: #1e3a8a !important;

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

    border: 1px solid #cbd5e1 !important;

}


.print-table thead th.table-header {

    background-color: #475569 !important;

    color: #ffffff !important;

    text-align: center;

    vertical-align: middle;

    height: 42px;

    padding: 6px 4px !important;

    font-size: 13px;

    font-weight: 700;

}


.print-table td.day-cell {

    background-color: #475569 !important;

    color: #ffffff !important;

    font-weight: 700;

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

    color: #1d4ed8 !important;

    font-size: 14px;

    font-weight: 700;

}


.teacher-name {

    margin-top: 5px;

    color: #1e3a8a !important;

    font-weight: 700;

}


/* =========================================================
   EMPTY
========================================================= */

.empty-slot {

    background-color: #fafafa;

}


.extra-text {

    font-size: 12px;

    color: #64748b !important;

    font-weight: 700;

}


.empty-timetable {

    padding: 70px 20px;

    text-align: center;

    color: #1e3a8a !important;

    font-weight: 700;

}


.empty-timetable i {

    margin-bottom: 15px;

    font-size: 50px;

}


/* =========================================================
   DRAG
========================================================= */

.dragging {

    opacity: .4;

}


.drag-over {

    background-color: #dbeafe !important;

    border: 3px dashed #1d4ed8 !important;

}


/* =========================================================
   LUNCH
========================================================= */

.lunch-cell {

    width: 8% !important;

    padding: 0 !important;

    text-align: center !important;

    vertical-align: middle !important;

    background-color: #e2e8f0 !important;

}


.lunch-text {

    writing-mode: vertical-rl;

    text-orientation: mixed;

    white-space: nowrap;

    display: inline-block;

    font-weight: 700;

    font-size: 13px;

    color: #334155 !important;

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

    border-bottom: 2px solid #cbd5e1;

}


.subject-table th {

    color: #1e3a8a !important;

    font-size: 14px;

    font-weight: 700;

}


.subject-table td {

    padding: 8px 10px;

    color: #1e3a8a !important;

    font-weight: 700;

}


/* =========================================================
   ACTIONS
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

    font-weight: 700;

    text-decoration: none !important;

    cursor: pointer;

    transition: all .2s ease;

}


.action-btn:hover {

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(0,0,0,.12);

}


.print-btn {

    background: #1d4ed8;

    color: #ffffff;

}


.print-btn:hover {

    background: #1e40af;

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

    box-shadow: 0 10px 30px rgba(0,0,0,.25);

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:768px) {

    .filter-form {

        grid-template-columns: 1fr;

    }


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


    /* Hide normal UI controls */
    .print-hide {

        display: none !important;

    }


    /* Hide sidebar / navbar */
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


    /* =====================================================
       SECTION CARD
    ====================================================== */

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


    /* =====================================================
       IMPORTANT
       Section A / Section B + Year - Major
       HEADER WILL NOT PRINT
    ====================================================== */

    .section-title {

        display: none !important;

        visibility: hidden !important;

    }


    /* =====================================================
       INFO
       Keep both items in one horizontal row
    ====================================================== */

    .timetable-info {

        display: flex !important;

        flex-direction: row !important;

        justify-content: space-between !important;

        align-items: center !important;

        width: 100% !important;

        margin-bottom: 8px !important;

        padding: 3px 2px !important;

        font-size: 10px !important;

        line-height: 1.2 !important;

        white-space: nowrap !important;

    }


    .timetable-info > div {

        width: auto !important;

        display: block !important;

    }


    .timetable-info > div:first-child {

        text-align: left !important;

    }


    .timetable-info > div:last-child {

        text-align: right !important;

    }


    /* =====================================================
       TABLE
    ====================================================== */

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

        background-color: #475569 !important;

        color: #ffffff !important;

        height: 38px !important;

        padding: 4px !important;

        font-size: 9px !important;

        font-weight: 700 !important;

    }


    .print-table td.day-cell {

        background-color: #475569 !important;

        color: #ffffff !important;

        height: 40px !important;

        padding: 4px !important;

        font-size: 9px !important;

    }


    .print-table td.schedule-cell {

        height: 40px !important;

        padding: 3px !important;

    }


    .print-table table,
    .print-table th,
    .print-table td {

        border: 1px solid #000 !important;

    }


    /* =====================================================
       SUBJECT
    ====================================================== */

    .subject-content {

        min-height: 30px !important;

        height: 30px !important;

    }


    .subject-code {

        color: #1d4ed8 !important;

        font-size: 8px !important;

        font-weight: 700 !important;

    }


    .teacher-name {

        margin-top: 2px !important;

        color: #1e3a8a !important;

        font-size: 6px !important;

    }


    .extra-text {

        color: #64748b !important;

        font-size: 6px !important;

    }


    /* =====================================================
       LUNCH
    ====================================================== */

    .lunch-cell {

        width: 8% !important;

        min-width: 8% !important;

        max-width: 8% !important;

        padding: 0 !important;

        background-color: #e2e8f0 !important;

    }


    .lunch-text {

        writing-mode: vertical-rl !important;

        text-orientation: mixed !important;

        white-space: nowrap !important;

        font-size: 7px !important;

        font-weight: 700 !important;

        color: #334155 !important;

    }


    /* =====================================================
       SUBJECT LIST
    ====================================================== */

    .subject-list {

        margin-top: 5px !important;

    }


    .subject-table {

        margin-top: 5px !important;

        margin-bottom: 0 !important;

    }


    .subject-table th {

        font-size: 8px !important;

        padding: 4px 6px !important;

    }


    .subject-table td {

        font-size: 7px !important;

        padding: 3px 6px !important;

    }


    /* =====================================================
       ACTIONS
    ====================================================== */

    .timetable-actions {

        display: none !important;

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
            document.querySelectorAll('[data-section-filter]');

        const sectionTables =
            document.querySelectorAll('.section-timetable');


        sectionButtons.forEach(
            function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const selected =
                            this.getAttribute('data-section-filter');


                        sectionButtons.forEach(
                            function(item) {

                                item.classList.remove('active');

                            }
                        );


                        this.classList.add('active');


                        sectionTables.forEach(
                            function(table) {

                                const tableSection =
                                    table.getAttribute('data-section');


                                if (
                                    selected === 'all' ||
                                    tableSection === selected
                                ) {

                                    table.style.display = '';

                                } else {

                                    table.style.display = 'none';

                                }

                            }
                        );

                    }
                );

            }
        );



        /* =====================================================
           DRAG / DROP SWAP
        ====================================================== */

        let draggedCell = null;

        let isSwapping = false;


        const subjectCells =
            document.querySelectorAll('.subject-slot');

        const allScheduleCells =
            document.querySelectorAll('.schedule-cell');

        const loading =
            document.getElementById('swapLoading');

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
                            this.getAttribute('data-schedule-id');


                        if(!scheduleId) {

                            event.preventDefault();

                            return;

                        }


                        draggedCell = this;

                        this.classList.add('dragging');


                        event.dataTransfer.effectAllowed = 'move';

                        event.dataTransfer.setData(
                            'text/plain',
                            scheduleId
                        );

                    }
                );


                cell.addEventListener(
                    'dragend',
                    function() {

                        this.classList.remove('dragging');


                        allScheduleCells.forEach(
                            function(item) {

                                item.classList.remove('drag-over');

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


                        if (
                            !draggedCell ||
                            isSwapping ||
                            this === draggedCell
                        ) {

                            return;

                        }


                        event.dataTransfer.dropEffect = 'move';

                        this.classList.add('drag-over');

                    }
                );


                cell.addEventListener(
                    'dragleave',
                    function() {

                        this.classList.remove('drag-over');

                    }
                );


                /* =================================================
                   DROP
                ================================================== */

                cell.addEventListener(
                    'drop',
                    function(event) {

                        event.preventDefault();


                        this.classList.remove('drag-over');


                        if (
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


                        if (
                            !Number.isInteger(schedule1Id) ||
                            !Number.isInteger(schedule2Id)
                        ) {

                            alert('Invalid Schedule ID.');

                            return;

                        }


                        if(schedule1Id === schedule2Id) {

                            return;

                        }


                        if(
                            !confirm(
                                'ဒီ Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်မှာ သေချာပါသလား?'
                            )
                        ) {

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
           SWAP
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


                const data =
                    await response.json();


                if(
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'Swap failed.'
                    );

                }


                window.location.reload();

            }
            catch(error) {

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

                loading.style.display = 'flex';

            }

        }


        function hideLoading() {

            if(loading) {

                loading.style.display = 'none';

            }

        }

    }
);



/* =========================================================
   PRINT SECTION
========================================================= */

function printSection(sectionId) {

    const allSections =
        document.querySelectorAll('.section-timetable');

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
                section.getAttribute('data-section') ===
                sectionId
            ) {

                section.classList.add(
                    'print-selected'
                );

            } else {

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
