@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">


            <div>

                <h2 class="text-primary font-weight-bold">

                    <i class="mr-2 fa-solid fa-book"></i>
                    Subject List

                </h2>


                <p class="mb-0 text-muted">
                    Manage university subjects.
                </p>


            </div>


            <div>


                <form action="{{ route('subject.list') }}" method="GET">


                    <div class="input-group">


                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Search...">



                        <button type="submit" class="btn btn-primary">

                            <i class="fa-solid fa-magnifying-glass"></i>

                        </button>



                    </div>


                </form>


            </div>

        </div>

        <div class="border-0 shadow-sm card">


            <div class="text-white card-header bg-primary">


                <h5 class="mb-0">

                    <i class="mr-2 fa-solid fa-list"></i>
                    Subjects


                </h5>


            </div>

            <div class="card-body">


                <div class="table-responsive">


                    <table class="table align-middle table-hover table-bordered">


                        <thead class="thead-light">


                            <tr class="text-center">


                                <th width="60">ID</th>

                                <th>Long Name</th>

                                <th width="120">Short Name</th>

                                <th width="150">Time Number</th>

                                <th>Year</th>

                                <th>Major</th>

                                <th width="150">Created Date</th>

                                <th width="120">Action</th>


                            </tr>


                        </thead>





                        <tbody>



                            @forelse ($subjects as $item)
                                <tr>


                                    <td class="text-center">
                                        {{ $item->id }}
                                    </td>



                                    <td>
                                        {{ $item->long_name }}
                                    </td>




                                    <td class="text-center">
                                        {{ $item->short_name }}
                                    </td>




                                    <td class="text-center">
                                        {{ $item->time_number }}
                                    </td>




                                    <td>
                                        {{ $item->year_name }}
                                    </td>




                                    <td>
                                        {{ $item->major_name }}
                                    </td>




                                    <td class="text-center">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>




                                    <td class="text-center">


                                        <a href="{{ route('subject.updatePage', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">


                                            <i class="fa-solid fa-pen-to-square"></i>


                                        </a>





                                        <a href="{{ route('subject.delete', $item->id) }}"
                                            class="btn btn-sm btn-outline-danger">


                                            <i class="fa-solid fa-trash"></i>


                                        </a>



                                    </td>



                                </tr>




                            @empty



                                <tr>


                                    <td colspan="8" class="py-5 text-center text-muted">


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


                    {{ $subjects->links() }}


                </div>



            </div>



        </div>



    </div>
@endsection
