@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">

            <div class="mx-auto mt-5 col-md-6">

                <!-- Title -->
                <div class="mb-3 text-center">
                    <h3 class="fw-bold text-dark">
                        <i class="text-info fa-solid fa-users me-2"></i>
                        {{ $years->name }}
                    </h3>
                </div>

                <!-- Card -->
                <div class="p-3 text-white shadow-sm card bg-info">

                    <form action="{{ route('schedule.result', $years->id) }}" method="POST">
                        @csrf

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Select Rooms</label>
                                <select name="roomID" class="form-control @error('roomID') is-invalid @enderror">
                                    <option value="">Choose Room</option>

                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('roomID') == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('roomID')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Majors</label>
                                <select name="majorID" class="form-control @error('majorID') is-invalid @enderror">
                                    <option value="">Choose Major</option>

                                    @foreach ($majors as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('majorID') == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('majorID')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="submit" value="Auto Generate Time Table"
                                    class="rounded shadow-sm btn btn-danger w-100">
                            </div>

                            <div class="mb-3">
                                <a href="{{ route('schedule.timeTable') }}" class="rounded shadow-sm btn btn-success w-100">
                                    View Year List
                                </a>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
@endsection
