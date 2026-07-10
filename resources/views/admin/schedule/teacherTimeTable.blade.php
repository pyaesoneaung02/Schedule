@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->


        <div class="d-flex justify-content-between align-items-center mb-4">


            <div>

                <h2 class="text-primary font-weight-bold mb-1">

                    <i class="mr-2 fa-solid fa-chalkboard-user"></i>

                    {{ $years->name }} Teacher Time Table

                </h2>


                <p class="mb-0 text-muted">
                    View teacher teaching schedule.
                </p>

            </div>

            <div>


                <form action="{{ route('schedule.teacherTimeTable', $years->id) }}" method="GET">


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


        <!-- Table Card -->

        <div class="border-0 shadow-sm card">


            <div class="text-white card-header bg-primary">


                <h5 class="mb-0">

                    <i class="mr-2 fa-solid fa-table"></i>

                    Teacher Schedule List

                </h5>


            </div>

            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-bordered table-hover">


                        <thead class="table-primary">


                            <tr>


                                <th>
                                    No
                                </th>


                                <th>
                                    Year
                                </th>


                                <th>
                                    Major
                                </th>


                                <th>
                                    Room
                                </th>


                                <th>
                                    Day
                                </th>


                                <th>
                                    Time
                                </th>


                                <th>
                                    Subject
                                </th>


                                <th>
                                    Teacher
                                </th>


                            </tr>


                        </thead>





                        <tbody>


                            @forelse($schedules as $key=>$item)
                                <tr>


                                    <td>
                                        {{ $schedules->firstItem() + $key }}
                                    </td>


                                    <td>
                                        {{ $item->year->name }}
                                    </td>


                                    <td>
                                        {{ $item->major->name }}
                                    </td>


                                    <td>
                                        {{ $item->room->name }}
                                    </td>


                                    <td>
                                        {{ $item->day->name }}
                                    </td>


                                    <td>
                                        {{ $item->time->name }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $item->subject->short_name }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $item->subject->long_name }}
                                        </small>

                                    </td>


                                    <td>

                                        <span class="text-dark">

                                            {{ $item->teacher->name }}

                                        </span>

                                    </td>


                                </tr>

                            @empty


                                <tr>

                                    <td colspan="8" class="py-5 text-center text-muted">


                                        <i class="mb-2 fa-solid fa-folder-open fa-3x"></i>


                                        <h5>
                                            No Teacher Schedule Found
                                        </h5>


                                    </td>

                                </tr>
                            @endforelse



                        </tbody>


                    </table>


                </div>





                <!-- Pagination -->

                <div class="mt-3 d-flex justify-content-end">


                    {{ $schedules->withQueryString()->links() }}


                </div>


            </div>


        </div>






        <!-- Back Button -->

        <div class="mt-3">


            <a href="{{ route('schedule.viewSchedule', $years->id) }}" class="btn btn-outline-primary">


                <i class="mr-2 fa-solid fa-arrow-left"></i>

                Back


            </a>


        </div>



    </div>
@endsection
