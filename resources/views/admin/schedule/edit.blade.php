@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-calendar-days"></i>
            Update Schedule

        </h2>


        <p class="mb-0 text-muted">
            Update weekly class schedule.
        </p>

    </div>




    <div class="row justify-content-center">


        <div class="col-lg-8">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-pen-to-square"></i>
                        Update Schedule Information

                    </h5>


                </div>



                <div class="card-body">


                    <form action="{{ route('schedule.update', $schedule->id) }}"
                        method="POST">

                        @csrf


                        <div class="row">


                            <div class="col-md-6">


                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Year
                                    </label>

                                    <select name="yearID"
                                        class="form-control @error('yearID') is-invalid @enderror">

                                        <option value="">
                                            Choose Year
                                        </option>

                                        @foreach ($years as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('yearID',$schedule->year_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>

                                        @endforeach

                                    </select>


                                    @error('yearID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>



                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Major
                                    </label>

                                    <select name="majorID"
                                        class="form-control @error('majorID') is-invalid @enderror">


                                        <option value="">
                                            Choose Major
                                        </option>


                                        @foreach ($majors as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('majorID',$schedule->major_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>

                                        @endforeach


                                    </select>


                                    @error('majorID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>





                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Room
                                    </label>


                                    <select name="roomID"
                                        class="form-control @error('roomID') is-invalid @enderror">


                                        <option value="">
                                            Choose Class
                                        </option>


                                        @foreach ($rooms as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('roomID',$schedule->room_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>

                                        @endforeach


                                    </select>


                                    @error('roomID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Subject
                                    </label>


                                    <select name="subjectID"
                                        class="form-control @error('subjectID') is-invalid @enderror">


                                        <option value="">
                                            Choose Subject
                                        </option>


                                        @foreach ($subjects as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('subjectID',$schedule->subject_id)==$item->id) selected @endif>

                                                {{ $item->long_name }}

                                            </option>


                                        @endforeach


                                    </select>


                                    @error('subjectID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>



                            </div>


                            <div class="col-md-6">



                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Teacher
                                    </label>


                                    <select name="teacherID"
                                        class="form-control @error('teacherID') is-invalid @enderror">


                                        <option value="">
                                            Choose Teacher
                                        </option>


                                        @foreach ($teachers as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('teacherID',$schedule->teacher_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>


                                        @endforeach


                                    </select>


                                    @error('teacherID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>






                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Day
                                    </label>


                                    <select name="dayID"
                                        class="form-control @error('dayID') is-invalid @enderror">


                                        <option value="">
                                            Choose Day
                                        </option>


                                        @foreach ($days as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('dayID',$schedule->day_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>


                                        @endforeach


                                    </select>


                                    @error('dayID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>







                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Time
                                    </label>


                                    <select name="timeID"
                                        class="form-control @error('timeID') is-invalid @enderror">


                                        <option value="">
                                            Choose Time
                                        </option>


                                        @foreach ($times as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('timeID',$schedule->time_id)==$item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>


                                        @endforeach


                                    </select>


                                    @error('timeID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>

                                <div class="mb-3">

                                    <label class="form-label">
                                        Select Subject
                                    </label>


                                    <select name="subjectID"
                                        class="form-control @error('subjectID') is-invalid @enderror">


                                        <option value="">
                                            Choose Subject
                                        </option>


                                        @foreach ($subjects as $item)

                                            <option value="{{ $item->id }}"
                                                @if(old('subjectID',$schedule->subject_id)==$item->id) selected @endif>

                                                {{ $item->short_name }}

                                            </option>


                                        @endforeach


                                    </select>


                                    @error('subjectID')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror


                                </div>


                            </div>


                        </div>





                        <button type="submit"
                            class="mb-3 btn btn-primary w-100">


                            <i class="mr-2 fa-solid fa-floppy-disk"></i>

                            Update Schedule


                        </button>




                        <a href="{{ route('schedule.list') }}"
                            class="btn btn-outline-primary w-100">


                            <i class="mr-2 fa-solid fa-list"></i>

                            View Schedule List


                        </a>




                    </form>


                </div>


            </div>


        </div>


    </div>


</div>


@endsection
