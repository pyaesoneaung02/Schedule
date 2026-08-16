@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid timetable-page">

        {{-- =====================================================
         HEADER
    ====================================================== --}}

        <div class="mb-4 text-center">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-building-columns"></i>
                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)
            </h2>

            <h4 class="mt-3 text-dark font-weight-bold">

                @if (isset($room))
                    {{ $academicYear->name ?? '' }}
                    ပညာသင်နှစ်

                    @if (isset($semester))
                        ({{ $semester->name }})
                    @endif

                    <br><br>

                    {{ $yearData->name ?? '' }}
                    ({{ $major->name ?? '' }})

                    -

                    Section({{ $section->name ?? '' }})
                @else
                    {{ $academicYear->name ?? '' }}
                    ပညာသင်နှစ်

                    <br><br>

                    Auto Generated Timetable
                @endif

            </h4>

        </div>


        {{-- =====================================================
         EMPTY
    ====================================================== --}}

        @if ($schedules->isEmpty())
            <div class="py-5 text-center text-muted">

                <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

                <h5>
                    အချိန်ဇယား မရှိပါ။
                </h5>

            </div>
        @else
            {{-- =====================================================
             INFO
        ====================================================== --}}

            <div class="timetable-info">

                <div>

                    အတန်း - {{ $yearData->name ?? '' }}

                    ({{ $major->name ?? '' }})

                </div>

                <div>

                    Section({{ $section->name ?? '' }})

                    -

                    အခန်း({{ $room->name ?? '' }})

                </div>

            </div>


            {{-- =====================================================
             DRAG DROP HELP
        ====================================================== --}}

            {{-- <div class="mb-3 alert alert-info timetable-help">

                <i class="mr-2 fa-solid fa-hand-pointer"></i>

                <strong>Drag & Drop:</strong>

                Subject ကို mouse နဲ့ ဖိဆွဲပြီး

                အခြား Subject ပေါ်ကို ချပါ။

                <strong>
                    Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်ပေးပါမယ်။
                </strong>

            </div> --}}


            {{-- =====================================================
             TIMETABLE
        ====================================================== --}}

            <div class="table-responsive print-table">

                <table class="table table-bordered text-center align-middle timetable-table">

                    <thead>

                        <tr>

                            <th class="table-header equal-column">
                                Day / Time
                            </th>

                            @foreach ($times as $time)
                                @if ($time->name == '12:00-01:00')
                                    <th class="table-header lunch-column">
                                        &nbsp;
                                    </th>
                                @else
                                    <th class="table-header equal-column">

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

                                <td class="day-cell equal-column">

                                    {{ $day->name }}

                                </td>


                                @foreach ($times as $time)
                                    {{-- =================================================
                                     LUNCH
                                ================================================== --}}

                                    @if ($time->name == '12:00-01:00')
                                        @if ($dayIndex == 0)
                                            <td rowspan="{{ $days->count() }}" class="lunch-cell lunch-column">

                                                <span class="lunch-text">
                                                    ထမင်းစားနားချိန်
                                                </span>

                                            </td>
                                        @endif
                                    @else
                                        {{-- =================================================
                                         FIND SCHEDULE
                                    ================================================== --}}

                                        @php

                                            $schedule = $schedules->first(function ($item) use ($day, $time) {
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
                                                data-day-id="{{ $schedule->day_id }}"
                                                data-time-id="{{ $schedule->time_id }}">

                                                <div class="subject-content">

                                                    <span class="subject-code">

                                                        {{ $schedule->subject->short_name ?? '' }}

                                                    </span>


                                                    @if ($schedule->teacher)
                                                        <small class="teacher-name">

                                                            {{ $schedule->teacher->name }}

                                                        </small>
                                                    @endif

                                                </div>

                                            </td>
                                        @else
                                            {{-- =================================================
                                             EMPTY
                                        ================================================== --}}

                                            {{-- <td class="schedule-cell empty-slot">

                                                <span class="text-muted extra-text">

                                                    Extra Curriculum

                                                </span>

                                            </td> --}}


                                            <td class="schedule-cell empty-slot" data-day-id="{{ $day->id }}"
                                                data-time-id="{{ $time->id }}">
                                                <span class="text-muted extra-text">
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


            {{-- =====================================================
             SUBJECT LIST
        ====================================================== --}}

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

                                    {{ $item->subject->short_name ?? '' }}

                                </td>

                                <td>

                                    {{ $item->subject->long_name ?? '' }}

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


            {{-- =====================================================
             BUTTONS
        ====================================================== --}}

            <div class="mt-4 mb-5 text-center print-hide">

                {{-- PRINT --}}

                <button type="button" onclick="window.print()" class="px-4 mr-2 btn btn-primary">

                    <i class="mr-1 fa-solid fa-print"></i>

                    Print Timetable

                </button>


                {{-- PDF --}}

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


                {{-- MANUAL --}}

                @if (isset($room))
                    <a href="{{ route('schedule.create', [$yearData->id, $room->id, $major->id]) }}"
                        class="px-4 btn btn-success">

                        <i class="mr-1 fa-solid fa-pen"></i>

                        Manual Timetable

                    </a>
                @endif

            </div>
        @endif

    </div>


    {{-- =====================================================
     LOADING
====================================================== --}}

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


{{-- =====================================================
     CSS
====================================================== --}}

<style>
    .timetable-info {

        width: 100%;

        display: flex;

        justify-content: space-between;

        align-items: center;

        font-weight: bold;

        margin-bottom: 10px;

    }


    .timetable-help {

        border-left: 5px solid #17a2b8;

    }


    .timetable-table {

        width: 100% !important;

        table-layout: fixed !important;

        border-collapse: collapse !important;

    }


    .timetable-table .equal-column {

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


    .empty-slot {

        background-color: #fafafa;

    }


    .extra-text {

        font-size: 12px;

    }


    .dragging {

        opacity: .4;

    }


    .drag-over {

        background-color: #dbeafe !important;

        border: 3px dashed #007bff !important;

    }


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


    .print-table table,
    .print-table th,
    .print-table td {

        border: 1px solid #000 !important;

    }


    .subject-table,
    .subject-table th,
    .subject-table td {

        border: none !important;

    }


    /* =====================================================
   LOADING
===================================================== */

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

        box-shadow: 0 10px 30px rgba(0, 0, 0, .2);

    }


    .swap-loading-box .spinner-border {

        width: 45px;

        height: 45px;

    }


    /* =====================================================
   PRINT
===================================================== */

    @media print {

        @page {

            size: A4 landscape;

            margin: 8mm;

        }


        .print-hide,
        .timetable-help {

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


        .timetable-table {

            width: 100% !important;

            table-layout: fixed !important;

            border-collapse: collapse !important;

        }


        .timetable-table .equal-column {

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

    }
</style>


{{-- =====================================================
     JAVASCRIPT
====================================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrfMeta = document.querySelector(
            'meta[name="csrf-token"]'
        );


        if (!csrfMeta) {

            console.error('CSRF token meta tag not found.');

            alert(
                'CSRF token မတွေ့ပါ။ admin.layouts.master ထဲမှာ csrf-token meta tag ထည့်ပါ။'
            );

            return;
        }


        const csrfToken = csrfMeta.getAttribute('content');


        if (!csrfToken) {

            console.error('CSRF token is empty.');

            alert(
                'CSRF token မရှိပါ။ Page ကို refresh လုပ်ပါ။'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VARIABLES
        |--------------------------------------------------------------------------
        */

        let draggedCell = null;

        let isSwapping = false;


        const subjectCells = document.querySelectorAll(
            '.subject-slot'
        );


        const allScheduleCells = document.querySelectorAll(
            '.schedule-cell'
        );


        /*
        |--------------------------------------------------------------------------
        | DRAG START
        |--------------------------------------------------------------------------
        */

        subjectCells.forEach(function(cell) {

            cell.addEventListener('dragstart', function(event) {

                if (isSwapping) {

                    event.preventDefault();

                    return;
                }


                const scheduleId =
                    this.getAttribute('data-schedule-id');


                if (!scheduleId) {

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

            });


            /*
            |--------------------------------------------------------------------------
            | DRAG END
            |--------------------------------------------------------------------------
            */

            cell.addEventListener('dragend', function() {

                this.classList.remove('dragging');


                allScheduleCells.forEach(function(item) {

                    item.classList.remove('drag-over');

                });


                draggedCell = null;

            });

        });


        /*
        |--------------------------------------------------------------------------
        | DRAG OVER
        |--------------------------------------------------------------------------
        */

        subjectCells.forEach(function(cell) {

            cell.addEventListener('dragover', function(event) {

                event.preventDefault();


                if (!draggedCell || isSwapping) {

                    return;
                }


                if (this === draggedCell) {

                    return;
                }


                event.dataTransfer.dropEffect = 'move';


                this.classList.add('drag-over');

            });


            /*
            |--------------------------------------------------------------------------
            | DRAG LEAVE
            |--------------------------------------------------------------------------
            */

            cell.addEventListener('dragleave', function() {

                this.classList.remove('drag-over');

            });


            /*
            |--------------------------------------------------------------------------
            | DROP
            |--------------------------------------------------------------------------
            */

            cell.addEventListener('drop', function(event) {

                event.preventDefault();


                this.classList.remove('drag-over');


                if (!draggedCell || isSwapping) {

                    return;
                }


                if (this === draggedCell) {

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Get IDs
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Validate IDs
                |--------------------------------------------------------------------------
                */

                if (
                    !Number.isInteger(schedule1Id) ||
                    !Number.isInteger(schedule2Id) ||
                    schedule1Id <= 0 ||
                    schedule2Id <= 0
                ) {

                    alert(
                        'Invalid Schedule ID. Please refresh the page.'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Confirm
                |--------------------------------------------------------------------------
                */

                const confirmed = confirm(
                    'ဒီ Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်မှာ သေချာပါသလား?'
                );


                if (!confirmed) {

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | SWAP
                |--------------------------------------------------------------------------
                */

                swapSchedules(
                    schedule1Id,
                    schedule2Id
                );

            });

        });


        /*
        |--------------------------------------------------------------------------
        | AJAX SWAP
        |--------------------------------------------------------------------------
        */

        function swapSchedules(
            schedule1Id,
            schedule2Id
        ) {

            if (isSwapping) {

                return;
            }


            isSwapping = true;


            showLoading();


            /*
            |--------------------------------------------------------------------------
            | POST
            |--------------------------------------------------------------------------
            */

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


                /*
                |--------------------------------------------------------------------------
                | RESPONSE
                |--------------------------------------------------------------------------
                */

                .then(async function(response) {

                    let data;


                    try {

                        data = await response.json();

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

                })


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                .then(function(data) {

                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Swap failed.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reload
                    |--------------------------------------------------------------------------
                    */

                    window.location.reload();

                })


                /*
                |--------------------------------------------------------------------------
                | ERROR
                |--------------------------------------------------------------------------
                */

                .catch(function(error) {

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

                });

        }


        /*
        |--------------------------------------------------------------------------
        | SHOW LOADING
        |--------------------------------------------------------------------------
        */

        function showLoading() {

            const loading =
                document.getElementById(
                    'swapLoading'
                );


            if (!loading) {

                return;
            }


            loading.style.display = 'flex';

        }


        /*
        |--------------------------------------------------------------------------
        | HIDE LOADING
        |--------------------------------------------------------------------------
        */

        function hideLoading() {

            const loading =
                document.getElementById(
                    'swapLoading'
                );


            if (!loading) {

                return;
            }


            loading.style.display = 'none';

        }

    });
</script>
