@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid timetable-page">

        {{-- =========================================================
         HEADER
    ========================================================== --}}

        <div class="mb-4 text-center">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-building-columns"></i>

                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

            </h2>

            <h4 class="mt-3 text-dark font-weight-bold">

                {{ $academicYear->name ?? '' }}

                ပညာသင်နှစ်

                @if ($semesters)
                    ({{ $semesters->name }})
                @endif

                <br><br>

                {{ $yearData->name }}

                ({{ $major->name }})

                -

                Section({{ $sections->name }})

            </h4>

        </div>


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
            {{-- =========================================================
         INFO
    ========================================================== --}}

            <div class="timetable-info">

                <div>

                    အတန်း - {{ $yearData->name }}

                    ({{ $major->name }})

                </div>

                <div>

                    Section({{ $sections->name }})

                    -

                    အခန်း({{ $room->name }})

                </div>

            </div>


            {{-- =========================================================
         HELP
    ========================================================== --}}

            {{-- <div class="mb-3 alert alert-info timetable-help">

                <i class="mr-2 fa-solid fa-hand-pointer"></i>

                <strong>Tip:</strong>

                Subject ကို mouse နဲ့ ဖိဆွဲပြီး

                အခြား Subject ပေါ်ကို ချပါ။

                <strong>
                    Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်ပေးပါမယ်။
                </strong>

            </div> --}}


            {{-- =========================================================
         TIMETABLE
    ========================================================== --}}

            <div class="table-responsive print-table">

                <table class="table table-bordered text-center">

                    <thead>

                        <tr>

                            <th class="table-header">
                                Day / Time
                            </th>

                            @foreach ($times as $time)
                                <th class="table-header">

                                    @if ($time->name === '12:00-01:00')
                                        &nbsp;
                                    @else
                                        {{ $time->name }}
                                    @endif

                                </th>
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
                                    {{-- LUNCH --}}

                                    @if ($time->name === '12:00-01:00')
                                        @if ($dayIndex === 0)
                                            <td rowspan="{{ $days->count() }}" class="lunch-cell">

                                                <span class="lunch-text">

                                                    ထမင်းစားနားချိန်

                                                </span>

                                            </td>
                                        @endif
                                    @else
                                        @php

                                            $schedule = $schedules->first(function ($item) use ($day, $time) {
                                                return (int) $item->day_id === (int) $day->id &&
                                                    (int) $item->time_id === (int) $time->id;
                                            });
                                        @endphp


                                        {{-- EMPTY --}}

                                        @if (!$schedule)
                                            <td class="schedule-cell empty-slot" data-day-id="{{ $day->id }}"
                                                data-time-id="{{ $time->id }}">

                                                <span class="text-muted">

                                                    Extra Curriculum

                                                </span>

                                            </td>


                                            {{-- SUBJECT --}}
                                        @else
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
                                        @endif
                                    @endif
                                @endforeach

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =========================================================
         SUBJECT LIST
    ========================================================== --}}

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


            {{-- =========================================================
         BUTTONS
    ========================================================== --}}

            <div class="mt-4 mb-5 text-center print-hide">

                <button type="button" onclick="window.print()" class="px-4 mr-2 btn btn-primary">

                    <i class="mr-1 fa-solid fa-print"></i>

                    Print Timetable

                </button>


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


                <a href="{{ route('schedule.create', [$yearData->id, $room->id, $major->id]) }}"
                    class="px-4 btn btn-success">

                    <i class="mr-1 fa-solid fa-pen"></i>

                    Manual Timetable

                </a>

            </div>
        @endif

    </div>


    {{-- =========================================================
     LOADING
========================================================= --}}

    <div id="swapLoading" class="swap-loading" style="display:none;">

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
    .timetable-info {

        display: flex;

        justify-content: space-between;

        align-items: center;

        font-weight: bold;

        margin-bottom: 10px;

    }


    .timetable-help {

        border-left: 5px solid #17a2b8;

    }


    .print-table .table-header {

        background-color: #6c757d !important;

        color: #fff !important;

        vertical-align: middle;

    }


    .print-table .day-cell {

        background-color: #6c757d !important;

        color: #fff !important;

        font-weight: bold;

        vertical-align: middle;

    }


    .print-table .lunch-cell {

        background-color: #dee2e6 !important;

        vertical-align: middle;

    }


    .lunch-text {

        writing-mode: vertical-rl;

        font-weight: bold;

    }


    .print-table table {

        border-collapse: collapse !important;

    }


    .print-table th,
    .print-table td {

        border: 1px solid #000 !important;

    }


    .schedule-cell {

        min-width: 150px;

        height: 90px;

        vertical-align: middle !important;

    }


    .subject-slot {

        cursor: grab;

        background: #fff;

        user-select: none;

        transition: background .15s ease;

    }


    .subject-slot:hover {

        background: #f0f7ff;

    }


    .subject-slot:active {

        cursor: grabbing;

    }


    .subject-content {

        min-height: 65px;

        display: flex;

        flex-direction: column;

        justify-content: center;

        align-items: center;

    }


    .subject-code {

        font-size: 16px;

        font-weight: bold;

        color: #007bff;

    }


    .teacher-name {

        margin-top: 5px;

        color: #6c757d;

    }


    .empty-slot {

        background: #fafafa;

    }


    .dragging {

        opacity: .4;

    }


    .drag-over {

        background: #dbeafe !important;

        border: 3px dashed #007bff !important;

    }


    /* =========================================================
   LOADING
========================================================= */

    .swap-loading {

        position: fixed;

        top: 0;

        left: 0;

        right: 0;

        bottom: 0;

        z-index: 999999;

        background: rgba(0, 0, 0, .45);

        display: flex;

        justify-content: center;

        align-items: center;

    }


    .swap-loading-box {

        background: #fff;

        padding: 35px 55px;

        border-radius: 12px;

        text-align: center;

        box-shadow: 0 10px 30px rgba(0, 0, 0, .25);

    }


    .swap-loading-box .spinner-border {

        width: 45px;

        height: 45px;

    }


    /* =========================================================
   PRINT
========================================================= */

    @media print {

        @page {

            size: A4 landscape;

            margin: 10mm;

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


        .print-table table,
        .print-table th,
        .print-table td {

            border: 1px solid #000 !important;

        }

    }
</style>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        'use strict';


        // =========================================================
        // CONFIG
        // =========================================================

        const swapUrl = @json(route('schedule.swap'));

        /*
         * IMPORTANT:
         * CSRF token ကို meta tag ကနေ မယူတော့ဘူး။
         *
         * Blade ကနေ တိုက်ရိုက်ထည့်ထားတယ်။
         */

        const csrfToken = @json(csrf_token());


        // =========================================================
        // VARIABLES
        // =========================================================

        let draggedCell = null;

        let isSwapping = false;


        const subjectCells = document.querySelectorAll(
            '.subject-slot'
        );


        const allCells = document.querySelectorAll(
            '.schedule-cell'
        );


        const loading = document.getElementById(
            'swapLoading'
        );


        // =========================================================
        // CHECK
        // =========================================================

        if (!subjectCells.length) {

            return;

        }


        // =========================================================
        // DRAG START
        // =========================================================

        subjectCells.forEach(function(cell) {

            cell.addEventListener(
                'dragstart',
                function(event) {

                    if (isSwapping) {

                        event.preventDefault();

                        return;

                    }


                    const scheduleId =
                        this.dataset.scheduleId;


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


            // =====================================================
            // DRAG END
            // =====================================================

            cell.addEventListener(
                'dragend',
                function() {

                    this.classList.remove(
                        'dragging'
                    );


                    allCells.forEach(
                        function(item) {

                            item.classList.remove(
                                'drag-over'
                            );

                        }
                    );


                    draggedCell = null;

                }
            );

        });


        // =========================================================
        // DROP TARGETS
        // =========================================================

        allCells.forEach(function(cell) {


            // =====================================================
            // DRAG OVER
            // =====================================================

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


                    /*
                     * Subject -> Subject only
                     */

                    if (
                        !this.classList.contains(
                            'subject-slot'
                        )
                    ) {

                        return;

                    }


                    this.classList.add(
                        'drag-over'
                    );


                    event.dataTransfer.dropEffect =
                        'move';

                }
            );


            // =====================================================
            // DRAG LEAVE
            // =====================================================

            cell.addEventListener(
                'dragleave',
                function() {

                    this.classList.remove(
                        'drag-over'
                    );

                }
            );


            // =====================================================
            // DROP
            // =====================================================

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


                    /*
                     * Subject -> Subject only
                     */

                    if (
                        !draggedCell.classList.contains(
                            'subject-slot'
                        ) ||
                        !this.classList.contains(
                            'subject-slot'
                        )
                    ) {

                        return;

                    }


                    // =================================================
                    // ONLY USE SCHEDULE IDs
                    // =================================================

                    const schedule1Id =
                        parseInt(
                            draggedCell.dataset.scheduleId,
                            10
                        );


                    const schedule2Id =
                        parseInt(
                            this.dataset.scheduleId,
                            10
                        );


                    // =================================================
                    // Validate
                    // =================================================

                    if (
                        !Number.isInteger(schedule1Id) ||
                        !Number.isInteger(schedule2Id) ||
                        schedule1Id <= 0 ||
                        schedule2Id <= 0
                    ) {

                        alert(
                            'Invalid schedule ID. Please refresh the page.'
                        );

                        return;

                    }


                    if (
                        schedule1Id === schedule2Id
                    ) {

                        return;

                    }


                    // =================================================
                    // Confirm
                    // =================================================

                    const confirmed = confirm(
                        'ဒီ Subject နှစ်ခုရဲ့ Time Slot ကို Swap လုပ်မှာ သေချာပါသလား?'
                    );


                    if (!confirmed) {

                        return;

                    }


                    // =================================================
                    // SEND
                    // =================================================

                    swapSchedules(
                        schedule1Id,
                        schedule2Id
                    );

                }
            );

        });


        // =========================================================
        // SWAP
        // =========================================================

        async function swapSchedules(
            schedule1Id,
            schedule2Id
        ) {

            if (isSwapping) {

                return;

            }


            isSwapping = true;


            showLoading();


            try {

                // =================================================
                // FETCH
                // =================================================

                const response = await fetch(
                    swapUrl, {

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
                );


                // =================================================
                // RESPONSE TEXT
                // =================================================

                const text =
                    await response.text();


                let result;


                try {

                    result =
                        JSON.parse(text);

                } catch (error) {

                    console.error(
                        'SERVER RESPONSE:',
                        text
                    );

                    throw new Error(
                        'Server returned an invalid response.'
                    );

                }


                // =================================================
                // HTTP ERROR
                // =================================================

                if (!response.ok) {

                    throw new Error(
                        result.message ||
                        'Swap failed.'
                    );

                }


                // =================================================
                // APPLICATION ERROR
                // =================================================

                if (!result.success) {

                    throw new Error(
                        result.message ||
                        'Swap failed.'
                    );

                }


                // =================================================
                // SUCCESS
                // =================================================

                /*
                 * Database update ပြီးပြီ။
                 *
                 * Loading ပြပြီး page reload လုပ်မယ်။
                 */

                window.location.reload();

            } catch (error) {

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


        // =========================================================
        // SHOW LOADING
        // =========================================================

        function showLoading() {

            if (!loading) {

                return;

            }


            loading.style.display =
                'flex';

        }


        // =========================================================
        // HIDE LOADING
        // =========================================================

        function hideLoading() {

            if (!loading) {

                return;

            }


            loading.style.display =
                'none';

        }

    });
</script>
