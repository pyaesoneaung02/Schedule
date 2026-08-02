@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-pen-to-square"></i>
            Update Major
        </h2>
        <p class="text-muted">Edit the selected major name.</p>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <a href="{{ route('major.list') }}" class="mb-3 btn btn-outline-secondary btn-sm">
                <i class="mr-1 fa-solid fa-arrow-left"></i>
                Back
            </a>

            <div class="border-0 shadow-sm card">

                <div class="text-white card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-building-columns"></i>
                        Update Major
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('major.update', $major->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Major Name</label>

                            <input type="text"
                                name="majorName"
                                value="{{ old('majorName', $major->name) }}"
                                class="form-control @error('majorName') is-invalid @enderror"
                                placeholder="Enter major name">

                            @error('majorName')
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
