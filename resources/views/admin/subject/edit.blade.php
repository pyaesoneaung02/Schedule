@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-book"></i>

                Update Subject

            </h2>

            <p class="mb-0 text-muted">

                Edit the selected subject information.

            </p>

        </div>


        <div class="row justify-content-center">

            <div class="col-lg-8 col-xl-7">

                <div class="border-0 shadow-sm card">

                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-pen-to-square"></i>

                            Update Subject

                        </h5>

                    </div>


                    <div class="card-body">

                        {{-- IMPORTANT --}}
                        <form action="{{ route('subject.update', $subject->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                {{-- Academic Year --}}
                                <div class="col-md-12">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Select Academic Year

                                        </label>

                                        <select name="academicID"
                                            class="form-control @error('academicID') is-invalid @enderror">

                                            <option value="">
                                                Choose Academic Year
                                            </option>

                                            @foreach ($academicYears as $item)
                                                <option value="{{ $item->id }}" @selected(old('academicID', $subject->academic_year_id) == $item->id)>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach

                                        </select>

                                        @error('academicID')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Subject Name --}}
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Subject Name
                                        </label>

                                        <input type="text" name="longName"
                                            value="{{ old('longName', $subject->long_name) }}"
                                            class="form-control @error('longName') is-invalid @enderror"
                                            placeholder="Enter Subject Name...">

                                        @error('longName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Subject Code --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Subject Code
                                        </label>

                                        <input type="text" name="shortName"
                                            value="{{ old('shortName', $subject->short_name) }}"
                                            class="form-control @error('shortName') is-invalid @enderror"
                                            placeholder="Enter Subject Code...">

                                        @error('shortName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Time Number --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            One Week Teaching
                                        </label>

                                        <input type="number" name="timeNumber"
                                            value="{{ old('timeNumber', $subject->time_number) }}" min="1"
                                            class="form-control @error('timeNumber') is-invalid @enderror"
                                            placeholder="Enter One Week Teaching...">

                                        @error('timeNumber')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Year / Semester / Major --}}
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
                                                <option value="{{ $item->id }}" @selected(old('yearID', $subject->year_id) == $item->id)>

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
                                                <option value="{{ $item->id }}" @selected(old('semesterID', $subject->semester_id) == $item->id)>

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
                                                <option value="{{ $item->id }}" @selected(old('majorID', $subject->major_id) == $item->id)>

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

                                </div>


                                {{-- Description --}}
                                <div class="col-md-12">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Subject Description

                                        </label>

                                        <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description', strip_tags($subject->description)) }}</textarea>

                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Image --}}
                                <div class="col-md-12">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Subject Image

                                        </label>

                                        @if ($subject->image)
                                            <div class="mb-3">

                                                <img src="{{ asset($subject->image) }}" alt="Subject Image"
                                                    class="rounded shadow-sm"
                                                    style="
                                                    width:150px;
                                                    height:100px;
                                                    object-fit:cover;
                                                ">

                                            </div>
                                        @endif


                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept=".jpg,.jpeg,.png,.gif">

                                        <small class="text-muted">

                                            Leave empty if you don't want to
                                            change the current image.

                                        </small>


                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- Update Button --}}
                            <button type="submit" class="mb-3 btn btn-primary w-100">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                Update Subject

                            </button>


                            {{-- List --}}
                            <a href="{{ route('subject.list') }}" class="btn btn-outline-primary w-100">

                                <i class="mr-2 fa-solid fa-list"></i>

                                View Subject List

                            </a>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
