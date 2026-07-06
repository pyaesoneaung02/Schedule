@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="p-3 mt-3 text-white rounded shadow-sm col-6 offset-3 card bg-info">
                <form action="{{ route('schedule.createSchedule')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Select Years</label>
                                    <select name="yearID" class="form-control @error('yearID') is-invalid @enderror">
                                        <option value="">Choose Year</option>
                                        @foreach ($years as $item)
                                            <option value="{{ $item->id }}" @if (old('yearID') == $item->id) selected @endif>
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
                                            <option value="{{ $item->id }}" @if (old('majorID') == $item->id) selected @endif>
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
                                            <option value="{{ $item->id }}" @if (old('roomID') == $item->id) selected @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roomID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Subjects Long Name</label>
                                    <select name="subjectID" class="form-control @error('subjectID') is-invalid @enderror">
                                        <option value="">Choose Subject</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}" @if (old('subjectID') == $item->id) selected @endif>
                                                {{ $item->long_name }}</option>
                                                {{-- insert long_name or short_name --}}
                                        @endforeach
                                    </select>
                                    @error('subjectID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Select Teachers</label>
                                    <select name="teacherID" class="form-control @error('teacherID') is-invalid @enderror">
                                        <option value="">Choose Teacher</option>
                                    @foreach ($teachers as $item)
                                            <option value="{{ $item->id }}" @if (old('teacherID') == $item->id) selected @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teacherID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Days</label>
                                    <select name="dayID" class="form-control @error('dayID') is-invalid @enderror">
                                        <option value="">Choose Day</option>
                                    @foreach ($days as $item)
                                            <option value="{{ $item->id }}" @if (old('dayID') == $item->id) selected @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('dayID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Times</label>
                                    <select name="timeID" class="form-control @error('timeID') is-invalid @enderror">
                                        <option value="">Choose Time</option>
                                    @foreach ($times as $item)
                                            <option value="{{ $item->id }}" @if (old('timeID') == $item->id) selected @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('timeID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Subjects Short Name</label>
                                    <select name="subjectID" class="form-control @error('subjectID') is-invalid @enderror">
                                        <option value="">Choose Subject</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}" @if (old('subjectID') == $item->id) selected @endif>
                                                {{ $item->short_name }}</option>
                                                {{-- insert long_name or short_name --}}
                                        @endforeach
                                    </select>
                                    @error('subjectID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>
                        <div class="mt-2 mb-3">
                            <input type="submit" value="Create Schedule" class="rounded shadow-sm btn btn-danger w-100">
                        </div>
                        <div class="mt-2 mb-3">
                            <a href="{{ route('schedule.list') }}" class="rounded shadow-sm btn btn-success w-100">View
                                Schedule List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
