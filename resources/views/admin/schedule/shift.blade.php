@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <h2 class="text-primary mb-4">
            <i class="fa-solid fa-arrows-up-down-left-right"></i>
            Shift Schedule
        </h2>

        <div class="card shadow border-0">

            <div class="card-body">

                <form action="{{ route('schedule.shift', $schedule->id) }}" method="POST">

                    @csrf

                    <div class="row">

                        {{-- Subject --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Subject
                            </label>

                            <input type="text" class="form-control" value="{{ $schedule->subject->long_name }}" readonly>

                        </div>


                        {{-- Current Teacher --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Teacher
                            </label>

                            <input type="text" class="form-control" value="{{ $schedule->teacher->name }}" readonly>

                        </div>


                        {{-- Day --}}
                        <div class="col-md-6 mt-3">

                            <label class="form-label">
                                Shift Day
                            </label>

                            <select name="dayID" class="form-control" required>

                                @foreach ($days as $day)
                                    <option value="{{ $day->id }}" @selected($schedule->day_id == $day->id)>
                                        {{ $day->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Time --}}
                        <div class="col-md-6 mt-3">

                            <label class="form-label">
                                Shift Time
                            </label>

                            <select name="timeID" class="form-control" required>

                                @foreach ($times as $time)
                                    <option value="{{ $time->id }}" @selected($schedule->time_id == $time->id)>
                                        {{ $time->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Current Room --}}
                        <div class="col-md-6 mt-3">

                            <label class="form-label">
                                Room
                            </label>

                            <input type="text" class="form-control" value="{{ $schedule->room->name }}" readonly>

                        </div>

                    </div>


                    <button type="submit" class="btn btn-primary w-100 mt-4">

                        <i class="fa-solid fa-arrows-up-down-left-right me-2"></i>

                        Shift / Swap Schedule

                    </button>


                    <a href="{{ route('schedule.list') }}" class="btn btn-outline-primary w-100 mt-3">

                        <i class="fa-solid fa-list me-2"></i>

                        View Schedule List

                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection
