@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="p-3 text-white rounded shadow-sm col-6 offset-3 card bg-info">
                <form action="{{ route('teaching.update', $teaching->id)}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Teacher Name</label>
                            <input type="text" name="name" value="{{ old('name', $teaching->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Teacher Name...">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Years</label>
                            <select name="yearID" class="form-control @error('yearID') is-invalid @enderror">
                                <option value="">Choose Year</option>
                                @foreach ($years as $item)
                                    <option value="{{ $item->id }}" @if (old('yearID', $teaching->year_id) == $item->id) selected @endif>
                                        {{ $item->name }}</option>
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
                                    <option value="{{ $item->id }}" @if (old('majorID', $teaching->major_id) == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('majorID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Rooms</label>
                            <select name="roomID" class="form-control @error('roomID') is-invalid @enderror">
                                <option value="">Choose Class</option>
                                @foreach ($rooms as $item)
                                    <option value="{{ $item->id }}" @if (old('roomID', $teaching->room_id) == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('roomID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Subjects</label>
                            <select name="subjectID" class="form-control @error('subjectID') is-invalid @enderror">
                                <option value="">Choose Subject</option>
                                @foreach ($subjects as $item)
                                    <option value="{{ $item->id }}" @if (old('subjectID', $teaching->subject_id) == $item->id) selected @endif>
                                        {{ $item->short_name }}</option>
                                        {{-- insert long_name or short_name --}}
                                @endforeach
                            </select>
                            @error('subjectID')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Update Teaching" class="rounded shadow-sm btn btn-danger w-100">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('teaching.list') }}" class="rounded shadow-sm btn btn-success w-100">View
                                Teaching List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
