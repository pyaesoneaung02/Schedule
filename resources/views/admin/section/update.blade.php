@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-pen-to-square"></i>
            Update Section
        </h2>
        <p class="text-muted">Edit the selected section name.</p>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <a href="{{ route('section.list') }}" class="mb-3 btn btn-outline-secondary btn-sm">
                <i class="mr-1 fa-solid fa-arrow-left"></i>
                Back
            </a>

            <div class="border-0 shadow-sm card">

                <div class="text-white card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-calendar-days"></i>
                        Update Section
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('section.update', $section->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Section Name</label>

                            <input type="text"
                                name="sectionName"
                                value="{{ old('sectionName', $section->name) }}"
                                class="form-control @error('sectionName') is-invalid @enderror"
                                placeholder="Enter section name">

                            @error('sectionName')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Update
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
