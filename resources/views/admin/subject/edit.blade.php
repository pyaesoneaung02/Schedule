@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-book"></i>
                Subject Management
            </h2>

            <p class="mb-0 text-muted">
                Edit and update subject information.
            </p>

        </div>


        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="border-0 shadow-sm card">

                    <!-- Card Header -->
                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-pen-to-square"></i>
                            Update Subject

                        </h5>

                    </div>


                    <div class="card-body">


                        {{-- IMPORTANT:
                             Do NOT use @method('PUT')
                             because route is POST
                        --}}
                        <form action="{{ route('subject.update', $subject->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf


                            <div class="row">


                                <!-- ==============================
                                         IMAGE
                                    =============================== -->
                                <div class="col-md-4">

                                    <div class="mb-4 text-center">

                                        <div class="mb-3">

                                            @if ($subject->image)
                                                <img id="preview" src="{{ asset($subject->image) }}"
                                                    class="rounded-circle shadow" width="150" height="150"
                                                    style="object-fit: cover;">
                                            @else
                                                <img id="preview" src="https://via.placeholder.com/150"
                                                    class="rounded-circle shadow" width="150" height="150"
                                                    style="object-fit: cover;">
                                            @endif

                                        </div>


                                        <label class="btn btn-outline-primary">

                                            <i class="fa-solid fa-image me-2"></i>

                                            Choose Subject Image

                                            <input type="file" name="image" hidden onchange="previewImage(event)">

                                        </label>


                                        @error('image')
                                            <div class="mt-2 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                        <small class="mt-2 d-block text-muted">

                                            Leave empty if you don't want to
                                            change the current image.

                                        </small>

                                    </div>

                                </div>



                                <!-- ==============================
                                         LEFT FORM
                                    =============================== -->
                                <div class="col-md-4">


                                    <!-- Subject Name -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Subject Name
                                        </label>

                                        <input type="text" name="longName"
                                            value="{{ old('longName', $subject->long_name) }}"
                                            class="form-control @error('longName') is-invalid @enderror"
                                            placeholder="Enter Subject Name...">

                                        @error('longName')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>



                                    <!-- Subject Code -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Subject Code
                                        </label>

                                        <input type="text" name="shortName"
                                            value="{{ old('shortName', $subject->short_name) }}"
                                            class="form-control @error('shortName') is-invalid @enderror"
                                            placeholder="Enter Subject Code...">

                                        @error('shortName')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>



                                    <!-- Academic Year -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Academic Year
                                        </label>

                                        <select name="academicID"
                                            class="form-control @error('academicID') is-invalid @enderror">

                                            <option value="">
                                                -- Choose Academic Year --
                                            </option>


                                            @foreach ($academicYears as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('academicID', $subject->academic_year_id) == $item->id ? 'selected' : '' }}>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach

                                        </select>


                                        @error('academicID')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                </div>



                                <!-- ==============================
                                         RIGHT FORM
                                    =============================== -->
                                <div class="col-md-4">


                                    <!-- One Week Teaching -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            One Week Teaching
                                        </label>

                                        <input type="number" name="timeNumber"
                                            value="{{ old('timeNumber', $subject->time_number) }}"
                                            class="form-control @error('timeNumber') is-invalid @enderror"
                                            placeholder="Enter One Week Teaching..." min="1">

                                        @error('timeNumber')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>



                                    <!-- Year -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Year
                                        </label>

                                        <select name="yearID" class="form-control @error('yearID') is-invalid @enderror">

                                            <option value="">
                                                -- Choose Year --
                                            </option>


                                            @foreach ($years as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('yearID', $subject->year_id) == $item->id ? 'selected' : '' }}>

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



                                    <!-- Semester -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Select Semester
                                        </label>

                                        <select name="semesterID"
                                            class="form-control @error('semesterID') is-invalid @enderror">

                                            <option value="">
                                                -- Choose Semester --
                                            </option>


                                            @foreach ($semesters as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('semesterID', $subject->semester_id) == $item->id ? 'selected' : '' }}>

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


                                </div>


                            </div>



                            <!-- ==============================
                                     MAJOR
                                =============================== -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Select Major
                                </label>

                                <select name="majorID" class="form-control @error('majorID') is-invalid @enderror">

                                    <option value="">
                                        -- Choose Major --
                                    </option>


                                    @foreach ($majors as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('majorID', $subject->major_id) == $item->id ? 'selected' : '' }}>

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



                            <!-- ==============================
                                     DESCRIPTION
                                =============================== -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Subject Description
                                </label>


                                <textarea id="editor" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $subject->description) }}</textarea>


                                @error('description')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>



                            <!-- ==============================
                                     UPDATE BUTTON
                                =============================== -->
                            <button type="submit" class="mb-3 btn btn-primary w-100">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                Update Subject

                            </button>



                            <!-- LIST BUTTON -->
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



@push('scripts')
    <script>
        // ==========================================
        // IMAGE PREVIEW
        // ==========================================

        function previewImage(event) {
            let image = document.getElementById('preview');

            if (event.target.files && event.target.files[0]) {
                image.src = URL.createObjectURL(event.target.files[0]);
            }
        }



        // ==========================================
        // TINYMCE
        // ==========================================

        tinymce.init({

            selector: '#editor',

            height: 200,

            menubar: false,

            plugins: [
                'lists',
                'advlist',
                'wordcount'
            ],

            toolbar: 'undo redo | ' +
                'fontfamily fontsize | ' +
                'bold italic underline | ' +
                'forecolor backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist',

            font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt 60pt 72pt 96pt'

        });
    </script>
@endpush
