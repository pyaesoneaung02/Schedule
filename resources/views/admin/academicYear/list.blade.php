@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-calendar-days"></i>
                Academic Year Management
            </h2>

            <p class="text-muted">
                Create and manage academic years.
            </p>

        </div>


        <div class="row">


            <!-- Create Form -->
            <div class="col-lg-4">

                <div class="border-0 shadow-sm card">

                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">
                            <i class="mr-2 fa-solid fa-plus"></i>
                            Add Academic Year
                        </h5>

                    </div>


                    <div class="card-body">

                        <form action="{{ route('academicYear.create') }}" method="POST">

                            @csrf


                            <!-- Academic Year Name -->
                            <div class="form-group">

                                <label class="font-weight-bold">
                                    Academic Year Name
                                </label>

                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Example: 2025-2026">

                                @error('name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            <!-- Start Date -->
                            <div class="form-group">

                                <label class="font-weight-bold">
                                    Start Date
                                </label>

                                <input type="date" name="start_date" value="{{ old('start_date') }}"
                                    class="form-control @error('start_date') is-invalid @enderror">

                                @error('start_date')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            <!-- End Date -->
                            <div class="form-group">

                                <label class="font-weight-bold">
                                    End Date
                                </label>

                                <input type="date" name="end_date" value="{{ old('end_date') }}"
                                    class="form-control @error('end_date') is-invalid @enderror">

                                @error('end_date')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            <!-- Create Button -->
                            <button type="submit" class="btn btn-primary btn-block">

                                <i class="mr-2 fa-solid fa-floppy-disk"></i>

                                Create Academic Year

                            </button>


                        </form>

                    </div>

                </div>

            </div>



            <!-- Academic Year List -->
            <div class="col-lg-8">

                <div class="border-0 shadow-sm card">


                    <div class="text-white card-header bg-primary">

                        <h5 class="mb-0">

                            <i class="mr-2 fa-solid fa-list"></i>

                            Academic Year List

                        </h5>

                    </div>



                    <div class="card-body">


                        <div class="table-responsive">

                            <table class="table align-middle table-hover table-bordered">


                                <thead class="thead-light">

                                    <tr class="text-center">

                                        <th width="70">
                                            ID
                                        </th>

                                        <th>
                                            Academic Year
                                        </th>

                                        <th>
                                            Period
                                        </th>

                                        <th width="180">
                                            Created Date
                                        </th>

                                        <th width="120">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    @forelse ($academicYears as $item)
                                        <tr>


                                            <!-- ID -->
                                            <td class="text-center">

                                                {{ $item->id }}

                                            </td>



                                            <!-- Academic Year -->
                                            <td>

                                                <span class="font-weight-bold">

                                                    {{ $item->name }}

                                                </span>

                                            </td>



                                            <!-- Period -->
                                            <td class="text-center">

                                                <div>

                                                    <span class="font-weight-bold">
                                                        {{ $item->start_date }}
                                                    </span>

                                                </div>

                                                <div class="text-muted small">
                                                    to
                                                </div>

                                                <div>

                                                    <span class="font-weight-bold">
                                                        {{ $item->end_date }}
                                                    </span>

                                                </div>

                                            </td>



                                            <!-- Created Date -->
                                            <td class="text-center">

                                                {{ $item->created_at->format('d M Y') }}

                                            </td>



                                            <!-- Action -->
                                            <td class="text-center">


                                                <a href="{{ route('academicYear.updatePage', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">

                                                    <i class="fa-solid fa-pen-to-square"></i>

                                                </a>


                                                <a href="{{ route('academicYear.delete', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Delete">

                                                    <i class="fa-solid fa-trash"></i>

                                                </a>


                                            </td>


                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="5" class="py-5 text-center text-muted">

                                                <i class="mb-2 fa-solid fa-folder-open fa-3x"></i>

                                                <br>

                                                There is no academic year data.

                                            </td>

                                        </tr>
                                    @endforelse


                                </tbody>


                            </table>

                        </div>



                        <!-- Pagination -->
                        <div class="mt-3 d-flex justify-content-end">

                            {{ $academicYears->links() }}

                        </div>


                    </div>


                </div>

            </div>


        </div>


    </div>
@endsection
