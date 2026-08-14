@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="mb-4">

            <h2 class="font-weight-bold text-primary">
                <i class="mr-2 fa-solid fa-calendar-days"></i>
                Update Schedule
            </h2>

            <p class="mb-0 text-muted">
                Update weekly class schedule.
            </p>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">

                <strong>
                    <i class="mr-1 fa-solid fa-circle-exclamation"></i>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif


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

                        <form action="{{ route('schedule.update', $schedule->id) }}" method="POST">

                            @csrf

                            <div class="row">

                                {{-- CENTER --}}
                                <div class="col-md-12">
                                    {{-- Academic Year --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Academic Year
                                        </label>

                                        <select name="academicYearID"
                                            class="form-control @error('academicYearID') is-invalid @enderror">

                                            <option value="">
                                                Choose Academic Year
                                            </option>

                                            @foreach ($academicYears as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('academicYearID', $schedule->academic_year_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('academicYearID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>

                                {{-- LEFT --}}
                                <div class="col-md-6">

                                    {{-- Year --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Year
                                        </label>

                                        <select name="yearID" class="form-control @error('yearID') is-invalid @enderror">

                                            <option value="">
                                                Choose Year
                                            </option>

                                            @foreach ($years as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('yearID', $schedule->year_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('yearID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Major --}}
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
                                                    {{ old('majorID', $schedule->major_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('majorID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Section --}}
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
                                                    {{ old('sectionID', $schedule->section_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('sectionID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Room --}}
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
                                                    {{ old('roomID', $schedule->room_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('roomID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- Semester --}}
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
                                                    {{ old('semesterID', $schedule->semester_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('semesterID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- RIGHT --}}
                                <div class="col-md-6">


                                    {{-- Subject Name --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Subject Name
                                        </label>

                                        <select name="subjectID"
                                            class="form-control @error('subjectID') is-invalid @enderror">

                                            <option value="">
                                                Choose Subject Name
                                            </option>

                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('subjectID', $schedule->subject_id) == $item->id ? 'selected' : '' }}>
                                                    {{-- {{ $item->short_name }}
                                                    - --}}
                                                    {{ $item->long_name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('subjectID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- Subject Name --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Subject Code
                                        </label>

                                        <select name="subjectID"
                                            class="form-control @error('subjectID') is-invalid @enderror">

                                            <option value="">
                                                Choose Subject Code
                                            </option>

                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('subjectID', $schedule->subject_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->short_name }}
                                                    {{-- -
                                                    {{ $item->long_name }} --}}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('subjectID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Teacher --}}
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
                                                    {{ old('teacherID', $schedule->teacher_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('teacherID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Day --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Day
                                        </label>

                                        <select name="dayID" class="form-control @error('dayID') is-invalid @enderror">

                                            <option value="">
                                                Choose Day
                                            </option>

                                            @foreach ($days as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('dayID', $schedule->day_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('dayID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Time --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Time
                                        </label>

                                        <select name="timeID" class="form-control @error('timeID') is-invalid @enderror">

                                            <option value="">
                                                Choose Time
                                            </option>

                                            @foreach ($times as $item)
                                                @if ($item->name !== '12:00-01:00')
                                                    <option value="{{ $item->id }}"
                                                        {{ old('timeID', $schedule->time_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>

                                        @error('timeID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                </div>

                            </div>


                            {{-- Update --}}
                            <button type="submit" class="mb-3 btn btn-primary w-100">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                Update Schedule

                            </button>


                            {{-- List --}}
                            <a href="{{ route('schedule.list') }}" class="btn btn-outline-primary w-100">

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
