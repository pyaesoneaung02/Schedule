@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Times Update</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4 offset-2">

                    <a href="{{ route('time.list') }}" class="mb-3 btn btn-sm btn-outline-danger">Back</a>

                    <div class="card">
                        <div class="text-white shadow card-body bg-info">
                            <form action="{{ route('time.update', $time->id) }}" method="POST" class="p-3 rounded">
                                @csrf
                                <label class="form-label">Time</label>
                                <input type="text" name="timeName" value="{{ old('timeName', $time->name) }}"
                                    class="form-control @error('timeName') is-invalid @enderror" placeholder="Enter Time...">
                                @error('timeName')
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
