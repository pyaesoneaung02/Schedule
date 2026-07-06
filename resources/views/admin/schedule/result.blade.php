@extends('admin.layouts.master')

@section('content')

    <div class="container mt-5">

        <div class="mb-4 d-flex justify-content-center fw-bold text-dark">
            <h3>University Of Computer Studies (Magway)</h3>
        </div>

        <h3 class="mb-4 text-center fw-bold text-dark">
            {{ $yearData->name }} |
            {{ $room->name }} |
            {{ $major->name }}
        </h3>

        @if ($schedules->isEmpty())
            <div class="text-center text-danger">
                No Schedule Found for this combination
            </div>
        @else
            <!-- TIMETABLE TABLE -->
            <table class="table text-center table-bordered">

                <thead class="table-dark">
                    <tr>
                        <th>Day / Time</th>

                        @foreach ($times as $time)
                            <th>
                                @if ($time->name == '12:00-01:00')
                                    12:00-01:00
                                @else
                                    {{ $time->name }}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($days as $day)
                        <tr>
                            <td class="text-white fw-bold bg-secondary d-flex justify-items-start">
                                {{ $day->name }}
                            </td>

                            @foreach ($times as $time)
                                @php
                                    $schedule = $schedules->firstWhere(function ($item) use ($day, $time) {
                                        return $item->day_id == $day->id && $item->time_id == $time->id;
                                    });
                                @endphp

                                <td class="text-dark fw-bold">

                                    @if ($time->name == '12:00-01:00')
                                        <span class="text-dark">
                                            Lunch Break
                                        </span>
                                    @elseif ($schedule)
                                        <span>
                                            {{ $schedule->subject->short_name }}
                                        </span>
                                    @else
                                        <span>
                                            Extra Curriculum
                                        </span>
                                    @endif

                                </td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <!-- SUBJECT LEGEND -->
            <div class="mt-4">

                <!-- Header -->
                <div class="px-3 py-2 mb-2 fw-bold border-bottom d-flex">
                    <div class="col-3">
                        Subject Code
                    </div>

                    <div class="col-9">
                        Subject Name
                    </div>
                </div>

                <!-- Data -->
                @foreach($schedules->unique('subject_id') as $item)

                    <div class="px-3 py-2 mb-2 rounded d-flex bg-light">

                        <!-- Subject Code -->
                        <div class="col-3 fw-bold text-primary">
                            {{ $item->subject->short_name }}
                        </div>

                        <!-- Subject Name -->
                        <div class="col-9">
                            {{ $item->subject->long_name }}

                            @if($item->teacher)
                                <span class="text-muted">
                                    ({{ $item->teacher->name }})
                                </span>
                            @endif
                        </div>

                    </div>

                @endforeach

            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-4 mb-5 text-center">

                <!-- PRINT BUTTON -->
                <button onclick="window.print()" class="px-4 btn btn-primary me-2">
                    <i class="fa-solid fa-print"></i>Print Timetable
                </button>

                <!-- MANUAL TIMETABLE BUTTON -->
                <a href="{{ route('schedule.pdf', [$yearData->id, $room->id, $major->id]) }}" class="btn btn-danger">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </a>

                <!-- MANUAL TIMETABLE BUTTON -->
                <a href="{{ route('schedule.list', [$yearData->id, $room->id, $major->id]) }}" class="btn btn-success">
                    <i class="fa-solid fa-square-pen"></i>Manual Timetable
                </a>

            </div>
        @endif

    </div>

@endsection
