@extends('user.layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if ($errors->any())
                    <div
                        class="alert alert-danger border-0 rounded-4 bg-danger bg-opacity-10 text-danger px-4 py-3 mb-4 small fw-medium shadow-sm">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border-0 shadow-lg rounded-4 p-5">

                    <div class="mb-4 pb-3 border-bottom">
                        <h5 class="fw-bold text-dark mb-0">Edit Profile</h5>
                    </div>

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Full
                                Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control rounded-3 py-2 px-3 border-light bg-light" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Email
                                Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control rounded-3 py-2 px-3 border-light bg-light" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                class="form-control rounded-3 py-2 px-3 border-light bg-light"
                                placeholder="Enter phone number">
                        </div>

                        <div class="mb-4">
                            <label
                                class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Department</label>
                            <input type="text" value="{{ $teacher->department->name ?? 'N/A' }}"
                                class="form-control rounded-3 py-2 px-3 border-light bg-light text-muted" disabled>
                        </div>

                        <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.profile') }}"
                                class="text-secondary small text-decoration-none fw-semibold">
                                <i class="lni lni-arrow-left me-1"></i> Back to Profile
                            </a>
                            <button type="submit"
                                class="btn btn-primary rounded-pill px-5 py-2 small fw-semibold shadow-sm transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <style>
        .tracking-wider {
            letter-spacing: 0.1em;
        }

        .form-control:focus {
            background-color: #fff !important;
            border-color: #0d6efd !important;
            box-shadow: none;
        }
    </style>
@endsection
