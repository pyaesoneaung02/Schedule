@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-weight-bold" style="color: #000 !important;">
                    <i class="mr-2 fa-solid fa-chalkboard-user text-primary"></i>
                    Teacher List
                </h2>
                <p class="mb-0 font-weight-bold" style="color: #000 !important;">
                    Manage university teachers.
                </p>
            </div>

            <div>
                <form action="{{ route('teacher.list') }}" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="department" value="{{ request('department') }}">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control font-weight-bold"
                            placeholder="Search..." style="color: #000 !important;">
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

       <!-- Select Department Filter Buttons -->
        <div class="mb-4 border-0 shadow-sm card">
            <div class="card-body">
                <div class="mb-3 font-weight-bold" style="font-size: 1.05rem; color: #000 !important;">
                    <i class="mr-2 fa-solid fa-layer-group text-primary"></i> Select Department
                </div>

                @php
                    $currentDepartment = request('department');
                @endphp

                <div class="row">
                    <!-- All Button -->
                    <div class="mb-2 col-md-6">
                        <a href="{{ route('teacher.list', array_merge(request()->except('department', 'page'), ['department' => ''])) }}" 
                           class="btn {{ empty($currentDepartment) ? 'btn-primary shadow-sm font-weight-bold' : 'btn-outline-primary font-weight-bold' }} w-100 text-left">
                            <i class="mr-2 fa-solid fa-border-all"></i> All
                        </a>
                    </div>

                    <!-- Department Buttons -->
                    @foreach ($departments as $dept)
                        <div class="mb-2 col-md-6">
                            <a href="{{ route('teacher.list', array_merge(request()->except('department', 'page'), ['department' => $dept->id])) }}" 
                               class="btn {{ $currentDepartment == $dept->id ? 'btn-primary shadow-sm font-weight-bold' : 'btn-outline-primary font-weight-bold' }} w-100 text-left text-truncate"
                               title="{{ $dept->name }}">
                                <i class="mr-2 fa-solid fa-building-columns"></i> {{ $dept->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @php
            $groupedTeachers = $teachers->getCollection()->groupBy('department_name');
        @endphp

        @forelse ($groupedTeachers as $departmentName => $departmentTeachers)
            <div class="mb-4 border-0 shadow-sm card">
                <div class="text-white card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="mr-2 fa-solid fa-building-columns"></i>
                        {{ $departmentName ?: 'Unassigned Department' }}
                    </h5>
                   <span class="badge badge-light text-primary font-weight-bold" style="font-size: 0.9rem;">
    {{ $departmentTeachers->first()->total_department_teachers ?? $departmentTeachers->count() }} Teachers
</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-bordered">
                            <thead class="thead-light">
                                <tr class="text-center font-weight-bold" style="color: #000 !important;">
                                    <th width="70">No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th width="180">Created Date</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentTeachers as $index => $item)
                                    <tr class="font-weight-bold" style="color: #000 !important;">
                                        <td class="text-center" style="color: #000 !important;">
                                            {{ $teachers->firstItem() + $index }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->name }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->email }}
                                        </td>
                                        <td style="color: #000 !important;">
                                            {{ $item->position_name }}
                                        </td>
                                        <td class="text-center" style="color: #000 !important;">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('teacher.updatePage', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('teacher.delete', $item->id) }}"
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
                        There is no data
                    </div>
                </div>
            </div>
        @endforelse

        <!-- Pagination Links -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $teachers->links() }}
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('teacher.create') }}" class="btn btn-outline-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-arrow-left"></i>
                Back
            </a>
        </div>

    </div>
@endsection