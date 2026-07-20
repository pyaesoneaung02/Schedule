@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-pen-to-square"></i>
            Update Academic Year
        </h2>

        <p class="text-muted">
            Edit the selected academic year information.
        </p>
    </div>


    <div class="row justify-content-center">

        <div class="col-lg-5">

            <a href="{{ route('academicYear.list') }}"
               class="mb-3 btn btn-outline-secondary btn-sm">

                <i class="mr-1 fa-solid fa-arrow-left"></i>
                Back

            </a>


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">

                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-calendar-days"></i>
                        Update Academic Year
                    </h5>

                </div>


                <div class="card-body">


                    <form action="{{ route('academicYear.update', $academicYear->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')


                        <div class="form-group">

                            <label>
                                Academic Year Name
                            </label>


                            <input type="text"
                                name="name"
                                value="{{ old('name', $academicYear->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Example: 2025-2026">


                            @error('name')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>



                        <div class="form-group">

                            <label>
                                Start Date
                            </label>

                            <input type="date"
                                name="start_date"
                                value="{{ old('start_date', $academicYear->start_date) }}"
                                class="form-control @error('start_date') is-invalid @enderror">


                            @error('start_date')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>



                        <div class="form-group">

                            <label>
                                End Date
                            </label>


                            <input type="date"
                                name="end_date"
                                value="{{ old('end_date', $academicYear->end_date) }}"
                                class="form-control @error('end_date') is-invalid @enderror">


                            @error('end_date')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>



                        <div class="form-group">

                            <label>
                                Status
                            </label>


                            <select name="status"
                                class="form-control @error('status') is-invalid @enderror">


                                <option value="Active"
                                    {{ old('status',$academicYear->status) == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>


                                <option value="Inactive"
                                    {{ old('status',$academicYear->status) == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>


                            </select>


                            @error('status')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>



                        <button type="submit"
                            class="btn btn-primary btn-block">

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
