@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-door-open"></i>
                Room Management
            </h2>

            <p class="text-muted">
                Create and manage rooms.
            </p>
        </div>


        <div class="row justify-content-center">

            <div class="col-lg-5">


                <div class="border-0 shadow-sm card">


                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-plus"></i>
                            Add Room

                        </h5>

                    </div>



                    <div class="card-body">


                        <form action="{{ route('room.createRoom') }}" method="POST">

                            @csrf



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Room Number
                                        </label>


                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter Room Name...">


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

                                <div class="col-md-6">
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
                                            Select Section
                                        </label>

                                        <select name="sectionID"
                                            class="form-control @error('sectionID') is-invalid @enderror">

                                            <option value="">Choose Section</option>

                                            @foreach ($sections as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('sectionID') == $item->id ? 'selected' : '' }}>
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
                                </div>
                            </div>



                            <button type="submit" class="mb-3 btn btn-primary w-100">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>
                                Create Room

                            </button>





                            <a href="{{ route('room.list') }}" class="btn btn-outline-primary w-100">

                                <i class="mr-2 fa-solid fa-list"></i>
                                View Room List

                            </a>



                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div>
@endsection
