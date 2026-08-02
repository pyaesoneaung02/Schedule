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


                        <div class="col-md-6">


                            <label class="form-label">
                                Subject
                            </label>


                            <input type="text" class="form-control" value="{{ $schedule->subject->long_name }}" readonly>


                        </div>




                        <div class="col-md-6">


                            <label class="form-label">
                                Day
                            </label>


                            <select name="dayID" class="form-control">


                                @foreach ($days as $day)
                                    <option value="{{ $day->id }}" @if ($schedule->day_id == $day->id) selected @endif>

                                        {{ $day->name }}

                                    </option>
                                @endforeach


                            </select>


                        </div>



                        <div class="col-md-6 mt-3">


                            <label class="form-label">
                                Time
                            </label>


                            <select name="timeID" class="form-control">


                                @foreach ($times as $time)
                                    <option value="{{ $time->id }}" @if ($schedule->time_id == $time->id) selected @endif>

                                        {{ $time->name }}

                                    </option>
                                @endforeach


                            </select>


                        </div>





                        <div class="col-md-6 mt-3">


                            <label class="form-label">
                                Teacher
                            </label>


                            <select name="teacherID" class="form-control">


                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @if ($schedule->teacher_id == $teacher->id) selected @endif>

                                        {{ $teacher->name }}

                                    </option>
                                @endforeach


                            </select>


                        </div>





                        <div class="col-md-6 mt-3">


                            <label class="form-label">
                                Room
                            </label>


                            <select name="roomID" class="form-control">


                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @if ($schedule->room_id == $room->id) selected @endif>

                                        {{ $room->name }}

                                    </option>
                                @endforeach


                            </select>


                        </div>



                    </div>



                    <button class="btn btn-primary w-100 mt-4">

                        <i class="fa-solid fa-arrows-up-down-left-right"></i>

                        {{-- <i class="fa-solid fa-save"></i> --}}

                        Shift Schedule

                    </button>


                    <a href="{{ route('schedule.list') }}" class="btn btn-outline-primary w-100 mt-3">


                        <i class="mr-2 fa-solid fa-list"></i>

                        View Schedule List


                    </a>



                </form>


            </div>


        </div>


    </div>
@endsection
