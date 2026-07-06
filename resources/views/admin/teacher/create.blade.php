@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="p-3 mt-5 text-white rounded shadow-sm col-6 offset-3 card bg-info">
                <form action="{{ route('teacher.createTeacher')}}" method="POST">
                    @csrf
                    <div class="card-body">
                         <div class="mb-3">
                            <label class="form-label">Teacher</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control  @error('name') is-invalid @enderror"
                                placeholder="Enter Teacher Name...">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Positions</label>
                            <select name="positionID" class="form-control @error('positionID') is-invalid @enderror">
                            <option value="">Choose Position</option>
                            @foreach ($positions as $item)
                            <option value="{{ $item->id}}" @if (old('positionID') == $item->id) selected @endif>{{ $item->name}}</option>
                            @endforeach
                        </select>
                            @error('positionID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Departments</label>
                            <select name="departmentID" class="form-control @error('departmentID') is-invalid @enderror">
                            <option value="">Choose Department</option>
                            @foreach ($departments as $item)
                            <option value="{{ $item->id}}" @if (old('departmentID') == $item->id) selected @endif>{{ $item->name}}</option>
                            @endforeach
                        </select>
                            @error('departmentID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Create Teacher" class="rounded shadow-sm btn btn-danger w-100">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('teacher.list') }}" class="rounded shadow-sm btn btn-success w-100">View Teacher List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
