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
                Create and manage subjects.
            </p>

        </div>

        <div class="row justify-content-center">


            <div class="col-lg-6">


                <div class="border-0 shadow-sm card">


                    <div class="text-white card-header bg-primary">


                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-plus"></i>
                            Add New Subject

                        </h5>


                    </div>

                    <div class="card-body">


                        <form action="{{ route('subject.createSubject') }}" method="POST">

                            @csrf

                            <div class="row">


                                <div class="col-md-6">


                                    <div class="mb-3">


                                        <label class="form-label">
                                            Long Name
                                        </label>



                                        <input type="text" name="longName" value="{{ old('longName') }}"
                                            class="form-control @error('longName') is-invalid @enderror"
                                            placeholder="Enter Long Name...">



                                        @error('longName')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror


                                    </div>

                                    <div class="mb-3">


                                        <label class="form-label">
                                            Short Name
                                        </label>


                                        <input type="text" name="shortName" value="{{ old('shortName') }}"
                                            class="form-control @error('shortName') is-invalid @enderror"
                                            placeholder="Enter Short Name...">

                                        @error('shortName')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror


                                    </div>


                                </div>

                                <div class="col-md-6">


                                    <div class="mb-3">


                                        <label class="form-label">
                                            One Week Teaching
                                        </label>



                                        <input type="text" name="timeNumber" value="{{ old('timeNumber') }}"
                                            class="form-control @error('timeNumber') is-invalid @enderror"
                                            placeholder="Enter One Week Teaching...">



                                        @error('timeNumber')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror



                                    </div>


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
                                                    @if (old('yearID') == $item->id) selected @endif>

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


                                </div>



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
                                    Subject Description
                                </label>

                                <textarea id="editor" name="description" class="form-control @error('description') is-invalid @enderror">
                                    {{ old('description') }}
                                </textarea>

                                {{-- {!! $subject->description !!} --}}


                                @error('description')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <button type="submit" class="mb-3 btn btn-primary w-100">


                                <i class="mr-2 fa-solid fa-floppy-disk"></i>
                                Create Subject


                            </button>

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
        tinymce.init({

            selector: '#editor',

            height: 300,

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
