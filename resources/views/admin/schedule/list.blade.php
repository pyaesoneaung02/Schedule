@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="mb-4 d-flex justify-content-between align-items-center">


        <div>

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-calendar-days"></i>

                Schedule List

            </h2>


            <p class="mb-0 text-muted">

                Manage university weekly schedules.

            </p>


        </div>



        <div>


            <form action="{{ route('schedule.list') }}" method="GET">


                <div class="input-group">


                    <input type="text"
                        name="searchKey"
                        value="{{ request('searchKey') }}"
                        class="form-control"
                        placeholder="Search...">


                    <button type="submit"
                        class="btn btn-primary">

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

                Schedules


            </h5>


        </div>

        <div class="card-body">


            <div class="table-responsive">


                <table class="table align-middle table-hover table-bordered">


                    <thead class="thead-light">


                        <tr class="text-center">


                            <th width="80">Day</th>

                            <th>Year</th>

                            <th>Major</th>

                            <th>Room</th>

                            <th>Subject Name</th>

                            <th width="150">Subject Code</th>

                            <th>Time</th>

                            <th>Teacher</th>

                            <th width="150">Created Date</th>

                            <th width="100">Action</th>


                        </tr>


                    </thead>


                    <tbody>



                        @forelse ($schedules as $item)



                            <tr>


                                <td class="text-center">

                                    {{ $item->day_name }}

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

                                    {{ $item->subject_long_name }}

                                </td>



                                <td class="text-center">

                                    {{ $item->subject_short_name }}

                                </td>



                                <td class="text-center">

                                    {{ $item->time_name }}

                                </td>



                                <td>

                                    {{ $item->teacher_name }}

                                </td>



                                <td class="text-center">

                                    {{ $item->created_at->format('d M Y') }}

                                </td>



                                <td class="text-center">


                                    <a href="{{ route('schedule.updatePage', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </a>



                                    <a href="{{ route('schedule.delete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger">

                                        <i class="fa-solid fa-trash"></i>

                                    </a>



                                </td>



                            </tr>



                        @empty



                            <tr>


                                <td colspan="10"
                                    class="py-5 text-center text-muted">


                                    <i class="mb-2 fa-solid fa-calendar-xmark fa-3x"></i>

                                    <br>

                                    There is no data


                                </td>


                            </tr>



                        @endforelse



                    </tbody>



                </table>



            </div>





            <div class="mt-3 d-flex justify-content-end">


                {{ $schedules->links() }}


            </div>




        </div>


    </div>



</div>


@endsection
