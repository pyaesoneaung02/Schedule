@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-graduation-cap"></i>
            Department Management
        </h2>

        <p class="mb-0 text-muted">
            Create and manage departments.
        </p>

    </div>


    <div class="row">


        <!-- Create Form -->
        <div class="col-lg-4">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">

                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-plus"></i>
                        Add Department
                    </h5>

                </div>



                <div class="card-body">


                    <form action="{{ route('department.create')}}" method="POST">

                        @csrf



                        <div class="mb-3">

                            <label class="form-label">
                                Department Name
                            </label>


                            <input type="text"
                                name="departmentName"
                                value="{{ old('departmentName')}}"
                                class="form-control @error('departmentName') is-invalid @enderror"
                                placeholder="Department Name...">


                            @error('departmentName')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>



                        <button type="submit" class="btn btn-primary w-100">

                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Create

                        </button>



                    </form>


                </div>


            </div>


        </div>




        <!-- Department List -->
        <div class="col-lg-8">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">

                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-list"></i>
                        Department List

                    </h5>

                </div>



                <div class="card-body">


                    <div class="table-responsive">


                        <table class="table align-middle table-hover table-bordered">


                            <thead class="thead-light">


                                <tr class="text-center">

                                    <th width="70">ID</th>
                                    <th>Name</th>
                                    <th width="180">Created Date</th>
                                    <th width="120">Action</th>

                                </tr>


                            </thead>



                            <tbody>


                                @forelse ($departments as $item)


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


                                            <a href="{{ route('department.updatePage', $item->id)}}"
                                                class="btn btn-sm btn-outline-primary">

                                                <i class="fa-solid fa-pen-to-square"></i>

                                            </a>



                                            <a href="{{ route('department.delete', $item->id)}}"
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

                                            There is no data

                                        </td>

                                    </tr>


                                @endforelse


                            </tbody>


                        </table>


                    </div>



                    <div class="mt-3 d-flex justify-content-end">

                        {{ $departments->links() }}

                    </div>



                </div>


            </div>


        </div>


    </div>


</div>

@endsection
