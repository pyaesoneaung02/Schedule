@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-calendar-days"></i>
            Day Management
        </h2>
        <p class="text-muted">Create and manage day names.</p>
    </div>

    <div class="row">

        <!-- Create Form -->
        <div class="col-lg-4">

            <div class="border-0 shadow-sm card">

                <div class="text-white card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-plus"></i>
                        Add New Day
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('day.create') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Day Name</label>

                            <input
                                type="text"
                                name="dayName"
                                value="{{ old('dayName') }}"
                                class="form-control @error('dayName') is-invalid @enderror"
                                placeholder="Enter day name">

                            @error('dayName')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-block">
                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Create
                        </button>

                    </form>

                </div>

            </div>

        </div>

        <!-- Day List -->
        <div class="col-lg-8">

            <div class="border-0 shadow-sm card">

                <div class="text-white card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-list"></i>
                        Day List
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle table-hover table-bordered">

                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="70">ID</th>
                                    <th>Day Name</th>
                                    <th width="180">Created Date</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($days as $item)

                                    <tr>

                                        <td class="text-center">
                                            {{ $item->id }}
                                        </td>

                                        <td>
                                            {{ $item->name }}
                                        </td>

                                        <td class="text-center">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>

                                        <td class="text-center">

                                            <a href="{{ route('day.updatePage',$item->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <a href="{{ route('day.delete',$item->id) }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="py-5 text-center text-muted">
                                            <i class="mb-2 fa-solid fa-folder-open fa-3x"></i>
                                            <br>
                                            There is no data.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $days->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
