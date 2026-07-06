@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="p-3 mt-5 text-white rounded shadow-sm col-6 offset-3 card bg-info">
                <form action="{{ route('major.createMajor') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Major</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter Major Name...">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
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
                            <input type="submit" value="Create Major" class="rounded shadow-sm btn btn-danger w-100">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('major.list') }}" class="rounded shadow-sm btn btn-success w-100">View Major List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
