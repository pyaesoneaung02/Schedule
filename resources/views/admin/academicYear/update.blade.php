@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

        <div class="mb-4">

            <h2 class="font-weight-bold text-primary">
                <i class="mr-2 fa-solid fa-pen-to-square"></i>
                Update Academic Year
            </h2>

            <p class="text-muted">
                Edit the selected academic year information.
            </p>

        </div>


        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8 col-sm-12">

                {{-- =========================================================
                BACK BUTTON
            ========================================================== --}}

                <div class="mb-3">

                    <a href="{{ route('academicYear.list') }}" class="btn btn-outline-secondary btn-sm">

                        <i class="mr-1 fa-solid fa-arrow-left"></i>
                        Back

                    </a>

                </div>


                {{-- =========================================================
                UPDATE CARD
            ========================================================== --}}

                <div class="border-0 shadow-sm card">

                    {{-- CARD HEADER --}}

                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0 font-weight-bold">

                            <i class="mr-2 fa-solid fa-calendar-days"></i>

                            Update Academic Year

                        </h5>

                    </div>


                    {{-- CARD BODY --}}

                    <div class="card-body">

                        <form action="{{ route('academicYear.update', $academicYear->id) }}" method="POST">

                            @csrf


                            {{-- =================================================
                            ACADEMIC YEAR NAME
                        ================================================== --}}

                            <div class="form-group">

                                <label for="name" class="font-weight-bold">

                                    Academic Year Name

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $academicYear->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Example: 2025-2026" autocomplete="off" required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- =================================================
                            START DATE
                        ================================================== --}}

                            <div class="form-group">

                                <label for="start_date" class="font-weight-bold">

                                    Start Date

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="date" id="start_date" name="start_date"
                                    value="{{ old('start_date', $academicYear->start_date) }}"
                                    class="form-control @error('start_date') is-invalid @enderror" required>

                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- =================================================
                            END DATE
                        ================================================== --}}

                            <div class="form-group">

                                <label for="end_date" class="font-weight-bold">

                                    End Date

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="date" id="end_date" name="end_date"
                                    value="{{ old('end_date', $academicYear->end_date) }}"
                                    class="form-control @error('end_date') is-invalid @enderror" required>

                                @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- =================================================
                            UPDATE BUTTON
                        ================================================== --}}

                            <button type="submit" class="btn btn-primary btn-block">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                Update Academic Year

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
