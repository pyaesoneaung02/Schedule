@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h2 class="font-weight-bold" style="color: #000 !important;">
                <i class="mr-2 fa-solid fa-layer-group text-primary"></i>
                Section Management
            </h2>
            <p class="font-weight-bold" style="color: #000 !important;">Create and manage section names.</p>
        </div>

        <div class="row">

            <!-- Create Form -->
            <div class="col-lg-4">

                <div class="border-0 shadow-sm card">

                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="mr-2 fa-solid fa-plus"></i>
                            Add Section
                        </h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('section.create') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold" style="color: #000 !important;">Section Name</label>

                                <input type="text" name="sectionName" value="{{ old('sectionName') }}"
                                    class="form-control font-weight-bold @error('sectionName') is-invalid @enderror"
                                    placeholder="Enter section name" style="color: #000 !important;">

                                @error('sectionName')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">

                                <label class="form-label font-weight-bold" style="color: #000 !important;">
                                    Select Year
                                </label>


                                <select name="yearID" class="form-control font-weight-bold @error('yearID') is-invalid @enderror" style="color: #000 !important;">


                                    <option value="">
                                        -- Choose Year --
                                    </option>


                                    @foreach ($years as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('yearID') == $item->id) selected @endif>

                                            {{ $item->name }}

                                        </option>
                                    @endforeach


                                </select>


                                @error('yearID')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="mb-3">

                                <label class="form-label font-weight-bold" style="color: #000 !important;">
                                    Select Major
                                </label>


                                <select name="majorID" class="form-control font-weight-bold @error('majorID') is-invalid @enderror" style="color: #000 !important;">


                                    <option value="">
                                        -- Choose Major --
                                    </option>


                                    @foreach ($majors as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('majorID') == $item->id) selected @endif>

                                            {{ $item->name }}

                                        </option>
                                    @endforeach


                                </select>


                                @error('majorID')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror


                            </div>

                            <button class="btn btn-primary btn-block font-weight-bold">
                                <i class="mr-2 fa-solid fa-floppy-disk"></i>
                                Create
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            <!-- Section List -->
            <div class="col-lg-8">

                <div class="border-0 shadow-sm card">

                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="mr-2 fa-solid fa-list"></i>
                            Section List
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table align-middle table-hover table-bordered">

                                <thead class="thead-light">
                                    <tr class="text-center font-weight-bold" style="color: #000 !important;">
                                        <th width="70">No.</th>
                                        <th>Section Name</th>
                                        <th>Years</th>
                                        <th>Majors</th>
                                        <th width="180">Created Date</th>
                                        <th width="120">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($sections as $index => $item)
                                        <tr class="font-weight-bold" style="color: #000 !important;">

                                            <td class="text-center" style="color: #000 !important;">
                                                {{ $sections->firstItem() + $index }}
                                            </td>

                                            <td style="color: #000 !important;">
                                                {{ $item->name }}
                                            </td>

                                            <td style="color: #000 !important;">
                                                {{ $item->year_name}}
                                            </td>

                                            <td style="color: #000 !important;">
                                                {{ $item->major_name}}
                                            </td>

                                            <td class="text-center" style="color: #000 !important;">
                                                {{ $item->created_at->format('d M Y') }}
                                            </td>

                                            <td class="text-center">

                                                <a href="{{ route('section.updatePage', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <a href="{{ route('section.delete', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6" class="py-5 text-center font-weight-bold" style="color: #000 !important; font-size: 1.1rem;">
                                                <i class="mb-2 text-primary fa-solid fa-folder-open fa-3x"></i>
                                                <br>
                                                There is no data.
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            {{ $sections->links() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection