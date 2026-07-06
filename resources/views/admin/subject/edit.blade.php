@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="p-3 text-white rounded shadow-sm col-6 offset-3 card bg-info">
                <form action="{{ route('subject.update', $subject->id)}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Long Name</label>
                            <input type="text" name="longName" value="{{ old('longName', $subject->long_name) }}"
                                class="form-control @error('longName') is-invalid @enderror"
                                placeholder="Enter Long Name...">
                            @error('longName')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Short Name</label>
                            <input type="text" name="shortName" value="{{ old('shortName', $subject->short_name) }}"
                                class="form-control @error('shortName') is-invalid @enderror"
                                placeholder="Enter Short Name...">
                            @error('shortName')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">One Week Teaching</label>
                            <input type="text" name="timeNumber" value="{{ old('timeNumber', $subject->time_number) }}"
                                class="form-control @error('timeNumber') is-invalid @enderror "
                                placeholder="Enter One Week Teaching...">
                            @error('timeNumber')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Years</label>
                            <select name="yearID" class="form-control @error('yearID') is-invalid @enderror">
                                <option value="">Choose Year</option>
                                @foreach ($years as $item)
                                    <option value="{{ $item->id }}" @if (old('yearID', $subject->year_id) == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('yearID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Majors</label>
                            <select name="majorID" class="form-control  @error('majorID') is-invalid @enderror">
                                <option value="">Choose Major</option>
                                @foreach ($majors as $item)
                                    <option value="{{ $item->id }}" @if (old('majorID', $subject->major_id) == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('majorID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Update Subject" class="rounded shadow-sm btn btn-danger w-100">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('subject.list') }}" class="rounded shadow-sm btn btn-success w-100">View Subject List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
