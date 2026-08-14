@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-lg-8 mt-5">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">
                            <i class="fas fa-magic mr-2"></i>
                            Auto Generate Timetable
                        </h5>

                    </div>


                    <div class="card-body">

                        {{-- Error Message --}}

                        @if ($errors->any())
                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>
                        @endif


                        {{-- Generate Form --}}

                        <form action="{{ route('schedule.createSchedule') }}" method="POST">

                            @csrf


                            <div class="row">

                                {{-- Academic Year --}}

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Academic Year
                                        </label>

                                        <select name="academicYearID" class="form-control" required>

                                            <option value="">
                                                -- Select Academic Year --
                                            </option>

                                            @foreach ($academicYears as $academicYear)
                                                <option value="{{ $academicYear->id }}"
                                                    {{ old('academicYearID') == $academicYear->id ? 'selected' : '' }}>
                                                    {{ $academicYear->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Semester --}}

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Semester
                                        </label>

                                        <select name="semesterID" class="form-control" required>

                                            <option value="">
                                                -- Select Semester --
                                            </option>

                                            @foreach ($semesters as $semester)
                                                <option value="{{ $semester->id }}"
                                                    {{ old('semesterID') == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Year --}}

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Class Year
                                        </label>

                                        <select name="yearID" class="form-control" required>

                                            <option value="">
                                                -- Select Year --
                                            </option>

                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ old('yearID') == $year->id ? 'selected' : '' }}>
                                                    {{ $year->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    {{-- Major --}}

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Major
                                        </label>

                                        <select name="majorID" class="form-control" required>

                                            <option value="">
                                                -- Select Major --
                                            </option>

                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ old('majorID') == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Section --}}

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Section
                                        </label>

                                        <select name="sectionID" class="form-control" required>

                                            <option value="">
                                                -- Select Section --
                                            </option>

                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ old('sectionID') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Room --}}

                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Room
                                        </label>

                                        <select name="roomID" class="form-control" required>

                                            <option value="">
                                                -- Select Room --
                                            </option>

                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}"
                                                    {{ old('roomID') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-12">

                                    {{-- Generate Button --}}

                                    <div class="text-center mt-4">

                                        {{-- <button type="submit" class="btn btn-primary btn-lg px-5">

                                            <i class="fas fa-magic mr-2"></i>

                                            Auto Generate Schedule

                                        </button> --}}

                                        <button type="submit" class="mb-3 btn btn-primary w-100">

                                            <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                            Auto Generate Schedule

                                        </button>

                                        <a href="{{ route('schedule.list') }}" class="btn btn-outline-primary w-100">


                                            <i class="mr-2 fa-solid fa-list"></i>
                                            View Schedule List


                                        </a>

                                        <a href="{{ route('teacher.list') }}" class="btn btn-outline-primary w-100 mt-3">


                                            <i class="mr-2 fa-solid fa-list"></i>
                                            View Teacher List


                                        </a>

                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
