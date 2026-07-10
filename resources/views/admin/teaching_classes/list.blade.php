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
                            placeholder="Search...">





                        <button type="submit" class="text-white btn btn-primary">


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
                    Teaching List


                </h5>


            </div>






            <div class="card-body">


                <div class="table-responsive">


                    <table class="table align-middle table-hover table-bordered">


                        <thead class="thead-light">


                            <tr class="text-center">


                                <th>ID</th>

                                <th>Name</th>

                                <th>Year</th>

                                <th>Major</th>

                                <th>Room</th>

                                <th>Subject</th>

                                <th>Created Date</th>

                                <th width="120">Action</th>


                            </tr>


                        </thead>







                        <tbody>


                            @if (count($teachings) != 0)
                                @foreach ($teachings as $item)
                                    <tr>


                                        <td class="text-center">
                                            {{ $item->id }}
                                        </td>



                                        <td>
                                            {{ $item->name }}
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

                                            {{ $item->created_at->format('j-F-Y') }}

                                        </td>




                                        <td class="text-center">


                                            <a href="{{ route('teaching.updatePage', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary">


                                                <i class="fa-solid fa-pen-to-square"></i>


                                            </a>





                                            <a href="{{ route('teaching.delete', $item->id) }}"
                                                class="btn btn-sm btn-outline-danger">


                                                <i class="fa-solid fa-trash"></i>


                                            </a>



                                        </td>


                                    </tr>
                                @endforeach
                            @else
                                <tr>


                                    <td colspan="8" class="py-5 text-center text-muted">


                                        <i class="mb-2 fa-solid fa-folder-open fa-3x"></i>


                                        <br>


                                        There is no data


                                    </td>


                                </tr>
                            @endif



                        </tbody>



                    </table>



                </div>






                <div class="mt-3 d-flex justify-content-end">


                    {{ $teachings->links() }}


                </div>




            </div>



        </div>

        <!-- Back Button -->

        <div class="mt-4">


            <a href="{{ route('teaching.create') }}" class="btn btn-outline-primary">


                <i class="mr-2 fa-solid fa-arrow-left"></i>

                Back


            </a>


        </div>



    </div>


@endsection
