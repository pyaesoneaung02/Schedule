@extends('user.layouts.master')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | PREPARE SCHEDULE LOOKUP
    |--------------------------------------------------------------------------
    */

    $scheduleMap = $schedules->keyBy(function ($schedule) {

        return $schedule->year_id
            . '-' .
            $schedule->section_id
            . '-' .
            $schedule->day_id
            . '-' .
            $schedule->time_id;

    });


    /*
    |--------------------------------------------------------------------------
    | FIND LUNCH TIME
    |--------------------------------------------------------------------------
    */

    $lunchTime = $times->first(function ($time) {

        return str_replace(
            ' ',
            '',
            trim($time->name)
        ) === '12:00-01:00';

    });

    $lunchTimeId = $lunchTime?->id;

@endphp


<style>

/* =========================================================
   SUBJECT LIST
========================================================= */

.subject-list-wrapper {

    margin-top: 30px;

    padding: 0;

}

.subject-list-header {

    display: flex;

    align-items: center;

    width: 100%;

    margin-bottom: 10px;

}


/* =========================================================
   SUBJECT CODE HEADER
========================================================= */

.subject-code-header {

    width: 20%;

    padding-bottom: 7px;

    border-bottom: 2px solid #6c757d;

    font-size: 13px;

    font-weight: 600;

    color: #343a40;

    text-align: left;

}


/* =========================================================
   SUBJECT NAME HEADER
========================================================= */

.subject-name-header {

    width: 80%;

    padding-bottom: 7px;

    border-bottom: 2px solid #6c757d;

    font-size: 13px;

    font-weight: 600;

    color: #343a40;

    text-align: left;

}


/* =========================================================
   SUBJECT ROW
========================================================= */

.subject-list-row {

    display: flex;

    align-items: center;

    width: 100%;

    min-height: 35px;

}


/* =========================================================
   SUBJECT CODE
========================================================= */

.subject-code-item {

    width: 20%;

    padding: 7px 12px;

    font-size: 15px;

    font-weight: 600;

    color: #007bff;

    text-align: left;

}


/* =========================================================
   SUBJECT NAME
========================================================= */

.subject-name-item {

    width: 80%;

    padding: 7px 12px;

    font-size: 15px;

    color: #000000;

    text-align: left;

}


/* =========================================================
   TEACHER
========================================================= */

.teacher-text {

    color: #000000;

    font-size: 15px;

}


/* =========================================================
   EMPTY
========================================================= */

.subject-list-empty {

    padding: 25px;

    text-align: center;

    color: #6c757d;

    border-top: 1px solid #dee2e6;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .subject-code-header,
    .subject-name-header {

        font-size: 12px;

    }

    .subject-code-item,
    .subject-name-item {

        padding: 7px 8px;

        font-size: 12px;

    }

    .teacher-text {

        font-size: 11px;

    }

}

</style>


<section
    id="schedule"
    class="pb-100 pt-35 feature-section feature-style-5"
>


<div class="container">


    {{-- =========================================================
         PAGE TITLE
    ========================================================== --}}

    <div class="row justify-content-center">

        <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10">

            <div
                class="text-center mb-50 section-title"
            >

                <h3
                    class="mb-15 wow fadeInUp"
                    data-wow-delay=".2s"
                >

                    Weekly Timetable (By Year & Section)

                </h3>

            </div>

        </div>

    </div>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <div
        class="row wow fadeInUp"
        data-wow-delay=".5s"
    >

        <div class="col-12">


            {{-- =================================================
                 CHECK YEARS
            ================================================== --}}

            @if($years->isNotEmpty())


                {{-- =================================================
                     YEAR TABS
                ================================================== --}}

                <ul
                    class="mb-4 border-0 nav nav-tabs justify-content-center"
                    id="timetableTabs"
                    role="tablist" style="gap: 15px;"
                >

                    @foreach($years as $year)

                        <li
                            class="nav-item"
                            role="presentation"
                        >

                            <button
                                class="nav-link {{ $loop->first ? 'active' : '' }}"
                                id="year-{{ $year->id }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#year-{{ $year->id }}"
                                type="button"
                                role="tab"
                                aria-controls="year-{{ $year->id }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            >

                                {{ $year->name }}

                            </button>

                        </li>

                    @endforeach

                </ul>


                {{-- =================================================
                     YEAR TAB CONTENT
                ================================================== --}}

                <div
                    class="p-4 bg-white rounded shadow-sm tab-content"
                    id="timetableTabContent"
                >


                    @foreach($years as $year)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | SECTIONS FOR CURRENT YEAR
                            |--------------------------------------------------------------------------
                            */

                            $yearSections = $sections
                                ->where('year_id', $year->id)
                                ->values();

                        @endphp


                        {{-- =================================================
                             YEAR TAB
                        ================================================== --}}

                        <div
                            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="year-{{ $year->id }}"
                            role="tabpanel"
                            aria-labelledby="year-{{ $year->id }}-tab"
                        >


                            @if($yearSections->isNotEmpty())


                                {{-- =================================================
                                     SECTION TABS
                                ================================================== --}}

                                <ul
                                    class="mb-3 nav nav-pills justify-content-center"
                                    id="pills-tab-year-{{ $year->id }}"
                                    role="tablist"
                                >

                                    @foreach($yearSections as $section)

                                        <li
                                            class="nav-item"
                                            role="presentation"
                                        >

                                            <button
                                                class="nav-link {{ $loop->first ? 'active' : '' }} btn-sm px-4 py-2 me-2 rounded-pill"
                                                id="pills-year-{{ $year->id }}-sec-{{ $section->id }}-tab"
                                                data-bs-toggle="pill"
                                                data-bs-target="#pills-year-{{ $year->id }}-sec-{{ $section->id }}"
                                                type="button"
                                                role="tab"
                                                aria-controls="pills-year-{{ $year->id }}-sec-{{ $section->id }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                            >

                                                {{ $section->name }}

                                            </button>

                                        </li>

                                    @endforeach

                                </ul>


                                {{-- =================================================
                                     SECTION TAB CONTENT
                                ================================================== --}}

                                <div
                                    class="tab-content"
                                    id="pills-tabContent-year-{{ $year->id }}"
                                >


                                    @foreach($yearSections as $section)

                                        @php

                                            /*
                                            |--------------------------------------------------------------------------
                                            | CURRENT SECTION SCHEDULES
                                            |--------------------------------------------------------------------------
                                            */

                                            $sectionSchedules = $schedules
                                                ->where('year_id', $year->id)
                                                ->where('section_id', $section->id)
                                                ->values();


                                            /*
                                            |--------------------------------------------------------------------------
                                            | UNIQUE SUBJECTS
                                            |--------------------------------------------------------------------------
                                            */

                                            $subjectList = $sectionSchedules
                                                ->filter(function ($schedule) {

                                                    return $schedule->subject !== null;

                                                })
                                                ->unique('subject_id')
                                                ->values();


                                            /*
                                            |--------------------------------------------------------------------------
                                            | FIRST SCHEDULE
                                            |--------------------------------------------------------------------------
                                            */

                                            $firstSchedule = $sectionSchedules->first();

                                        @endphp


                                        {{-- =================================================
                                             SECTION TAB
                                        ================================================== --}}

                                        <div
                                            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="pills-year-{{ $year->id }}-sec-{{ $section->id }}"
                                            role="tabpanel"
                                            aria-labelledby="pills-year-{{ $year->id }}-sec-{{ $section->id }}-tab"
                                        >


                                            {{-- =================================================
                                                 SECTION TITLE
                                            ================================================== --}}

                                            <h5
                                                class="mb-3 text-center"
                                                style="color: #6c757d;"
                                            >

                                                {{ $year->name }}

                                                -

                                                Section ({{ $section->name }})

                                                Timetable

                                            </h5>


                                            {{-- =================================================
                                                 PDF DOWNLOAD
                                            ================================================== --}}

                                            <div
                                                class="mb-3 text-end"
                                            >

                                                @if($firstSchedule)

                                                    <a
                                                        href="{{ route('schedule.pdf', [
                                                            'year' => $year->id,
                                                            'room' => $firstSchedule->room_id,
                                                            'major' => $firstSchedule->major_id,
                                                            'academicYearID' => $firstSchedule->academic_year_id,
                                                            'semesterID' => $firstSchedule->semester_id,
                                                            'sectionID' => $section->id,
                                                        ]) }}"
                                                        class="px-4 btn btn-danger"
                                                        target="_blank"
                                                        rel="noopener"
                                                    >

                                                        <i
                                                            class="me-1 fa-solid fa-file-pdf"
                                                        ></i>

                                                        Download PDF

                                                    </a>

                                                @else

                                                    <button
                                                        type="button"
                                                        class="px-4 btn btn-secondary"
                                                        disabled
                                                    >

                                                        <i
                                                            class="me-1 fa-solid fa-file-pdf"
                                                        ></i>

                                                        PDF Not Available

                                                    </button>

                                                @endif

                                            </div>


                                            {{-- =================================================
                                                 TIMETABLE
                                            ================================================== --}}

                                            <div class="table-responsive">

                                                <table
                                                    class="table mb-0 text-center shadow-sm table-bordered timetable-table"
                                                >

                                                    <thead class="align-middle">

                                                    <tr>

                                                        <th
                                                            scope="col"
                                                            style="
                                                                width: 15%;
                                                                background-color: #6c757d;
                                                                color: #fff;
                                                                border-color: #6c757d;
                                                            "
                                                        >

                                                            Day / Time

                                                        </th>


                                                        @foreach($times as $time)

                                                            @php

                                                                $isLunch =
                                                                    $time->id === $lunchTimeId;

                                                            @endphp


                                                            <th
                                                                scope="col"
                                                                style="
                                                                    background-color: #6c757d;
                                                                    color: #fff;
                                                                    border-color: #6c757d;
                                                                "
                                                            >

                                                                @if($isLunch)

                                                                    &nbsp;

                                                                @else

                                                                    {{ $time->name }}

                                                                @endif

                                                            </th>

                                                        @endforeach

                                                    </tr>

                                                    </thead>


                                                    <tbody>


                                                    @foreach($days as $dayIndex => $day)

                                                        <tr>


                                                            {{-- DAY --}}

                                                            <th
                                                                scope="row"
                                                                class="align-middle"
                                                                style="
                                                                    background-color: #6c757d;
                                                                    color: #fff;
                                                                    border-color: #6c757d;
                                                                "
                                                            >

                                                                {{ $day->name }}

                                                            </th>


                                                            {{-- TIMES --}}

                                                            @foreach($times as $time)

                                                                @php

                                                                    $isLunch =
                                                                        $time->id === $lunchTimeId;

                                                                @endphp


                                                                {{-- LUNCH --}}

                                                                @if($isLunch)


                                                                    @if($dayIndex === 0)

                                                                        <td
                                                                            rowspan="{{ $days->count() }}"
                                                                            class="align-middle bg-light"
                                                                        >

                                                                            <span
                                                                                class="fw-bold d-block text-secondary"
                                                                                style="
                                                                                    writing-mode: vertical-rl;
                                                                                    transform: rotate(180deg);
                                                                                    margin: 0 auto;
                                                                                    letter-spacing: 2px;
                                                                                "
                                                                            >

                                                                                ထမင်းစားနားချိန်

                                                                            </span>

                                                                        </td>

                                                                    @endif


                                                                {{-- NORMAL PERIOD --}}

                                                                @else

                                                                    @php

                                                                        $scheduleKey =
                                                                            $year->id
                                                                            . '-'
                                                                            . $section->id
                                                                            . '-'
                                                                            . $day->id
                                                                            . '-'
                                                                            . $time->id;

                                                                        $class =
                                                                            $scheduleMap->get(
                                                                                $scheduleKey
                                                                            );

                                                                    @endphp


                                                                    <td class="align-middle">


                                                                        @if($class)

                                                                            {{-- SUBJECT --}}

                                                                            <span
                                                                                class="fw-bold d-block subject-title"
                                                                            >

                                                                                {{
                                                                                    $class->subject->short_name
                                                                                    ?? $class->subject->name
                                                                                    ?? $class->subject->long_name
                                                                                    ?? ''
                                                                                }}

                                                                            </span>


                                                                            {{-- TEACHER --}}

                                                                            @if($class->teacher)

                                                                                <span
                                                                                    class="small text-muted room-no"
                                                                                >

                                                                                    {{ $class->teacher->name }}

                                                                                </span>

                                                                            @endif


                                                                        @else

                                                                            {{-- EMPTY SLOT --}}

                                                                            <span
                                                                                class="small text-black-50 subject-title"
                                                                            >

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


                                            {{-- =================================================
                                                 SUBJECT LIST
                                            ================================================== --}}

                                            <div class="subject-list-wrapper">


                                                @if($subjectList->isNotEmpty())


                                                    {{-- =================================================
                                                         SUBJECT HEADINGS
                                                    ================================================== --}}

                                                    <div class="subject-list-header">

                                                        <div class="subject-code-header">

                                                            Subject Code

                                                        </div>


                                                        <div class="subject-name-header">

                                                            Subject Name

                                                        </div>

                                                    </div>


                                                    {{-- =================================================
                                                         SUBJECT ITEMS
                                                    ================================================== --}}

                                                    @foreach($subjectList as $subjectSchedule)

                                                        <div class="subject-list-row">


                                                            {{-- SUBJECT CODE --}}

                                                            <div class="subject-code-item">

                                                                {{
                                                                    $subjectSchedule->subject->short_name
                                                                    ?? $subjectSchedule->subject->code
                                                                    ?? '-'
                                                                }}

                                                            </div>


                                                            {{-- SUBJECT NAME --}}

                                                            <div class="subject-name-item">

                                                                {{
                                                                    $subjectSchedule->subject->long_name
                                                                    ?? $subjectSchedule->subject->name
                                                                    ?? '-'
                                                                }}


                                                                @if($subjectSchedule->teacher)

                                                                    <span class="teacher-text">

                                                                        ({{ $subjectSchedule->teacher->name }})

                                                                    </span>

                                                                @endif

                                                            </div>

                                                        </div>

                                                    @endforeach


                                                @else


                                                    {{-- =================================================
                                                         NO SUBJECT
                                                    ================================================== --}}

                                                    <div class="subject-list-empty">

                                                        <i
                                                            class="mb-2 fa-solid fa-book-open text-muted"
                                                        ></i>

                                                        <div>

                                                            No subjects available
                                                            for this section.

                                                        </div>

                                                    </div>

                                                @endif


                                            </div>


                                        </div>

                                    @endforeach


                                </div>


                            @else


                                {{-- =================================================
                                     NO SECTION
                                ================================================== --}}

                                <div class="py-5 text-center">

                                    <i
                                        class="mb-3 fa-solid fa-calendar-xmark fa-2x text-muted"
                                    ></i>


                                    <h5 class="text-muted">

                                        No sections available for
                                        {{ $year->name }}.

                                    </h5>


                                    <p class="mb-0 text-muted">

                                        There is no timetable section
                                        available for this year.

                                    </p>

                                </div>


                            @endif


                        </div>

                    @endforeach


                </div>


            @else


                {{-- =================================================
                     NO YEAR
                ================================================== --}}

                <div class="py-5 text-center">

                    <i
                        class="mb-3 fa-solid fa-calendar-xmark fa-2x text-muted"
                    ></i>


                    <h5 class="text-muted">

                        No academic year available.

                    </h5>


                    <p class="mb-0 text-muted">

                        There is no timetable available at the moment.

                    </p>

                </div>


            @endif


        </div>

    </div>

</div>

</section>

@endsection
