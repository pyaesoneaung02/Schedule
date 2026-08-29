@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">

            <div>
                <h2 class="font-weight-bold" style="color: #000 !important;">
                    <i class="mr-2 fa-solid fa-door-open text-primary"></i>
                    Room List
                </h2>

                <p class="mb-0 font-weight-bold" style="color: #000 !important;">
                    Manage university rooms.
                </p>
            </div>

            <div>

                <form action="{{ route('room.list') }}" method="GET">

                    <div class="input-group">

                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control font-weight-bold"
                            placeholder="Search..." style="color: #000 !important;">

                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <div class="border-0 shadow-sm card">

            <div class="text-white card-header bg-primary">

                <h5 class="mb-0 font-weight-bold">
                    <i class="mr-2 fa-solid fa-list"></i>
                    Rooms
                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle table-hover table-bordered">

                        <thead class="thead-light">

                            <tr class="text-center font-weight-bold" style="color: #000 !important;">

                                <th width="70">No.</th>
                                <th>Room Name</th>
                                <th>Year</th>
                                <th>Major</th>
                                <th>Section</th>
                                <th width="180">Created Date</th>
                                <th width="120">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($rooms as $index => $item)
                                <tr class="font-weight-bold" style="color: #000 !important;">

                                    <td class="text-center" style="color: #000 !important;">
                                        {{ $rooms->firstItem() + $index }}
                                    </td>

                                    <td style="color: #000 !important;">
                                        {{ $item->name }}
                                    </td>

                                    <td style="color: #000 !important;">
                                        {{ $item->year_name }}
                                    </td>

                                    <td style="color: #000 !important;">
                                        {{ $item->major_name }}
                                    </td>

                                    <td style="color: #000 !important;">
                                        {{ $item->section_name }}
                                    </td>

                                    <td class="text-center" style="color: #000 !important;">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('room.updatePage', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <a href="{{ route('room.delete', $item->id) }}"
                                            class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="py-5 text-center font-weight-bold" style="color: #000 !important; font-size: 1.1rem;">

                                        <i class="mb-2 text-primary fa-solid fa-folder-open fa-3x"></i>
                                        <br>

                                        There is no data

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3 d-flex justify-content-end">

                    {{ $rooms->links() }}

                </div>

            </div>

        </div>

        <!-- Back Button -->

        <div class="mt-4">


            <a href="{{ route('room.create') }}" class="btn btn-outline-primary font-weight-bold">


                <i class="mr-2 fa-solid fa-arrow-left"></i>

                Back


            </a>


        </div>

    </div>
@endsection