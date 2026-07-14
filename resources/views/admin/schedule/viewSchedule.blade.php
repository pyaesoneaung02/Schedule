@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-calendar-days"></i>

                {{ $years->name }} Schedule

            </h2>


            <p class="mb-0 text-muted">
                Select room and major to generate timetable.
            </p>


        </div>



        <div class="row justify-content-center">


            <div class="col-lg-6">


                <div class="border-0 shadow-sm card">


                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-wand-magic-sparkles"></i>

                            Auto Generate Time Table

                        </h5>

                    </div>



                    <div class="card-body">


                        <form action="{{ route('schedule.result', $years->id) }}" method="POST">

                            @csrf



                            <div class="mb-3">


                                <label class="form-label">
                                    Select Room
                                </label>


                                <select name="roomID" class="form-control @error('roomID') is-invalid @enderror">


                                    <option value="">
                                        Choose Room
                                    </option>


                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('roomID') == $item->id) selected @endif>

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
                                    Select Major
                                </label>


                                <select name="majorID" class="form-control @error('majorID') is-invalid @enderror">


                                    <option value="">
                                        Choose Major
                                    </option>


                                    @foreach ($majors as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('majorID') == $item->id) selected @endif>

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
                                    Select Semester
                                </label>


                                <select name="semesterID"
                                    class="form-control @error('semesterID') is-invalid @enderror">


                                    <option value="">
                                        Choose Semester
                                    </option>


                                    @foreach ($semesters as $item)

                                        <option value="{{ $item->id }}"
                                            @if(old('semesterID') == $item->id) selected @endif>

                                            {{ $item->name }}

                                        </option>

                                    @endforeach


                                </select>


                                @error('semesterID')

                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Select Section
                                </label>


                                <select name="sectionID"
                                    class="form-control @error('sectionID') is-invalid @enderror">


                                    <option value="">
                                        Choose Section
                                    </option>


                                    @foreach ($sections as $item)

                                        <option value="{{ $item->id }}"
                                            @if(old('sectionID') == $item->id) selected @endif>

                                            {{ $item->name }}

                                        </option>

                                    @endforeach


                                </select>


                                @error('sectionID')

                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            <button type="submit" class="mb-3 btn btn-primary w-100">


                                <i class="mr-2 fa-solid fa-gears"></i>

                                Auto Generate Time Table


                            </button>


                            <a href="{{ route('schedule.teacherTimeTable', $years->id) }}"
                                class="mb-3 btn btn-success w-100">

                                <i class="mr-2 fa-solid fa-chalkboard-user"></i>

                                View Teacher Time Table

                            </a>


                            <a href="{{ route('schedule.timeTable') }}" class="btn btn-outline-primary w-100">


                                <i class="mr-2 fa-solid fa-list"></i>

                                View Year List


                            </a>



                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div>
@endsection
