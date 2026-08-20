@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-calendar-days"></i>

                {{ $years->name }} အတန်းအချိန်ဇယား

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


                        <form action="{{ route('schedule.result', ['year' => $years->id]) }}" method="POST">

                            @csrf

                            {{-- Academic Year --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Academic Year
                                </label>

                                <select name="academicYearID"
                                    class="form-control @error('academicYearID') is-invalid @enderror" required>

                                    <option value="">
                                        -- Choose Academic Year --
                                    </option>

                                    @foreach ($academicYears as $item)
                                        <option value="{{ $item->id }}" @selected(old('academicYearID') == $item->id)>

                                            {{ $item->name }}

                                        </option>
                                    @endforeach

                                </select>

                                @error('academicYearID')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Room --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Room
                                </label>

                                <select name="roomID" class="form-control @error('roomID') is-invalid @enderror" required>

                                    <option value="">
                                        -- Choose Room --
                                    </option>

                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}" @selected(old('roomID') == $item->id)>

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


                            {{-- Major --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Major
                                </label>

                                <select name="majorID" class="form-control @error('majorID') is-invalid @enderror" required>

                                    <option value="">
                                        -- Choose Major --
                                    </option>

                                    @foreach ($majors as $item)
                                        <option value="{{ $item->id }}" @selected(old('majorID') == $item->id)>

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


                            {{-- Semester --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Semester
                                </label>

                                <select name="semesterID" class="form-control @error('semesterID') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Choose Semester --
                                    </option>

                                    @foreach ($semesters as $item)
                                        <option value="{{ $item->id }}" @selected(old('semesterID') == $item->id)>

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


                            {{-- Section --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Section
                                </label>

                                <select name="sectionID" class="form-control @error('sectionID') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Choose Section --
                                    </option>

                                    @foreach ($sections as $item)
                                        <option value="{{ $item->id }}" @selected(old('sectionID') == $item->id)>

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


                            {{-- Submit --}}
                            <button type="submit" class="mb-3 btn btn-primary w-100">

                                <i class="mr-2 fa-solid fa-gears"></i>

                                Auto Generate Time Table

                            </button>


                            {{-- Teacher Timetable --}}
                            <a href="{{ route('schedule.teacherTimeTable', $years->id) }}"
                                class="mb-3 btn btn-success w-100">

                                <i class="mr-2 fa-solid fa-chalkboard-user"></i>

                                View Teacher Time Table

                            </a>

                            <!-- Student Timetable -->
                            <a href="{{ route('schedule.viewStudentTimetable', [
                                'yearID' => $years->id,
                            ]) }}"
                                class="mb-3 btn btn-danger w-100">

                                <i class="mr-2 fa-solid fa-user-graduate"></i>

                                View Student Time Table

                            </a>


                            {{-- Year List --}}
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
