@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">


            <div>

                <h2 class="mb-1 text-primary font-weight-bold">

                    <i class="mr-2 fa-solid fa-chalkboard"></i>
                    Teachings List

                </h2>


                <p class="mb-0 text-muted">
                    Manage teacher subject assignments.
                </p>


            </div>



            <div>

                <form action="{{ route('teaching.list') }}" method="GET">

                    <div class="input-group">

                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Search Teaching...">


                        <button class="btn btn-primary text-white">

                            <i class="fa-solid fa-search"></i>

                        </button>


                    </div>


                </form>


            </div>


        </div>





        <div class="card shadow-sm border-0">


            <div class="card-header bg-primary text-white">


                <h5 class="mb-0">

                    <i class="mr-2 fa-solid fa-list"></i>

                    Teaching List

                </h5>


            </div>




            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-bordered table-hover align-middle">


                        <thead class="table-light">


                            <tr class="text-center">

                                <th>ID</th>

                                <th>Academic Year</th>

                                <th>Semester</th>

                                <th>Teacher</th>

                                <th>Year</th>

                                <th>Major</th>

                                <th>Room</th>

                                <th>Subject</th>

                                <th>Action</th>


                            </tr>


                        </thead>



                        <tbody>


                            @forelse($teachings as $item)
                                <tr>


                                    <td class="text-center">

                                        {{ $item->id }}

                                    </td>



                                    <td>

                                        {{ $item->academic_year_name }}

                                    </td>



                                    <td>

                                        {{ $item->semester_name }}

                                    </td>



                                    <td>

                                        {{ $item->teacher_name }}

                                    </td>



                                    <td>

                                        {{ $item->year_name }}

                                    </td>



                                    <td>

                                        {{ $item->major_name }}

                                    </td>



                                    <td>

                                        {{ $item->room_name }}

                                    </td>



                                    <td>

                                        {{ $item->subject_short_name }}

                                    </td>



                                    <td class="text-center">


                                        <a href="{{ route('teaching.updatePage', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">


                                            <i class="fa-solid fa-pen"></i>


                                        </a>



                                        <a href="{{ route('teaching.delete', $item->id) }}"
                                            class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">


                                            <i class="fa-solid fa-trash"></i>


                                        </a>


                                    </td>



                                </tr>


                            @empty


                                <tr>


                                    <td colspan="9" class="text-center py-5 text-muted">


                                        <i class="fa-solid fa-folder-open fa-3x mb-2"></i>

                                        <br>

                                        No Teaching Data Found


                                    </td>


                                </tr>
                            @endforelse



                        </tbody>


                    </table>



                </div>




                <div class="mt-3 d-flex justify-content-end">

                    {{ $teachings->links() }}

                </div>



            </div>



        </div>




        <div class="mt-4">


            <a href="{{ route('teaching.create') }}" class="btn btn-outline-primary">


                <i class="fa-solid fa-arrow-left mr-2"></i>

                Back


            </a>


        </div>



    </div>
@endsection
