@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Years Update</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4 offset-2">

                    <a href="{{ route('year#list') }}" class="mb-3 btn btn-sm btn-outline-danger">Back</a>

                    <div class="text-white rounded card bg-info">
                        <div class="shadow card-body">
                            <form action="{{ route('year#update', $year->id) }}" method="POST" class="p-3 rounded">
                                @csrf
                                <label class="form-label">Year</label>
                                <input type="text" name="yearName" value="{{ old('yearName', $year->name) }}"
                                    class="form-control @error('yearName') is-invalid @enderror" placeholder="Year Name...">
                                @error('yearName')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <input type="submit" value="Update" class="mt-3 btn btn-outline-danger">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
