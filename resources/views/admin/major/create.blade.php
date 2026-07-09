@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-building-columns"></i>
            Major Management
        </h2>
        <p class="text-muted">Create a new major and assign it to a year.</p>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="border-0 shadow-sm card">

                <div class="text-white card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-plus"></i>
                        Add New Major
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('major.createMajor') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Major Name
                            </label>

                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Major Name...">

                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>


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
                                        @if(old('yearID') == $item->id) selected @endif>
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


                        <button type="submit" class="mb-3 btn btn-primary w-100">
                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Create Major
                        </button>


                        <a href="{{ route('major.list') }}"
                            class="btn btn-outline-primary w-100">

                            <i class="mr-2 fa-solid fa-list"></i>
                            View Major List

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
