@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-weight-bold" style="color: #000 !important;">
                    <i class="mr-2 fa-solid fa-chalkboard text-primary"></i>
                    Teachings List
                </h2>
                <p class="mb-0 font-weight-bold" style="color: #000 !important;">
                    Manage teacher subject assignments.
                </p>
            </div>

            <div>
                <form action="{{ route('teaching.list') }}" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="year" value="{{ request('year') }}">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control font-weight-bold"
                            placeholder="Search Teaching..." style="color: #000 !important;">
                        <button type="submit" class="btn btn-primary text-white font-weight-bold">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Select Year Filter Buttons -->
        <div class="mb-4 border-0 shadow-sm card">
            <div class="card-body">
                <div class="mb-2 font-weight-bold" style="font-size: 1.05rem; color: #000 !important;">
                    <i class="mr-2 fa-solid fa-layer-group text-primary"></i> Select Year
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $currentYear = request('year');
                    @endphp

                    <!-- All Button -->
                    <a href="{{ route('teaching.list', array_merge(request()->except('year', 'page'), ['year' => ''])) }}" 
                       class="btn {{ empty($currentYear) ? 'btn-primary shadow-sm font-weight-bold' : 'btn-outline-primary font-weight-bold' }} mr-2 mb-2">
                        All
                    </a>

                    <!-- Year Buttons -->
                    @foreach ($years as $yr)
                        <a href="{{ route('teaching.list', array_merge(request()->except('year', 'page'), ['year' => $yr->id])) }}" 
                           class="btn {{ $currentYear == $yr->id ? 'btn-primary shadow-sm font-weight-bold' : 'btn-outline-primary font-weight-bold' }} mr-2 mb-2">
                            {{ $yr->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @php
            $groupedTeachings = $teachings->getCollection()->groupBy('year_name');
        @endphp

        @forelse ($groupedTeachings as $yearName => $yearTeachings)
            <div class="mb-4 border-0 shadow-sm card">
                <div class="text-white card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="mr-2 fa-solid fa-calendar-days"></i>
                        {{ $yearName ?: 'Unassigned Year' }}
                    </h5>
                    <span class="badge badge-light text-primary font-weight-bold" style="font-size: 0.9rem;">
                        {{ $yearTeachings->first()->total_year_teachings ?? $yearTeachings->count() }} Teachings
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-bordered">
                            <thead class="thead-light">
                                <tr class="text-center font-weight-bold" style="color: #000 !important;">
                                    <th width="60">No.</th>
                                    <th>Academic Year</th>
                                    <th>Semester</th>
                                    <th>Teacher</th>
                                    <th>Major</th>
                                    <th>Room</th>
                                    <th>Subject</th>
                                    <th>Section</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yearTeachings as $index => $item)
                                    <tr class="font-weight-bold" style="color: #000 !important;">
                                        <td class="text-center" style="color: #000 !important;">
                                            {{ $teachings->firstItem() + $index }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->academic_year_name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->semester_name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->teacher_name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->major_name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->room_name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->subject_short_name }}
                                        </td>
                                        <td class="text-center" style="color: #000 !important;">
                                            {{ $item->section_name }}
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="border-0 shadow-sm card">
                <div class="card-body">
                    <div class="py-5 text-center font-weight-bold" style="font-size: 1.1rem; color: #000 !important;">
                        <i class="mb-2 text-primary fa-solid fa-folder-open fa-3x"></i>
                        <br>
                        No Teaching Data Found
                    </div>
                </div>
            </div>
        @endforelse

        <!-- Pagination Links -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $teachings->links() }}
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('teaching.create') }}" class="btn btn-outline-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-arrow-left"></i>
                Back
            </a>
        </div>

    </div>
@endsection