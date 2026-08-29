@extends('user.layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if (session('success'))
                    <div
                        class="alert alert-success border-0 rounded-4 bg-success bg-opacity-10 text-success px-4 py-3 mb-4 small fw-medium shadow-sm">
                        <i class="lni lni-checkmark-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Card -->
                <div class="bg-white border-0 shadow-lg rounded-4 p-5">

                    <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom">
                        <div>
                            <h2 class="fw-bold text-dark mb-1">{{ $user->name }}</h2>
                            <span class="text-muted small"><i class="lni lni-envelope me-1"></i> {{ $user->email }}</span>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <div class="row mb-3 align-items-center">
                            <div class="col-4 text-muted small text-uppercase tracking-wider fw-semibold">Phone</div>
                            <div class="col-8 text-dark fw-medium">{{ $user->phone ?? '—' }}</div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-4 text-muted small text-uppercase tracking-wider fw-semibold">Department</div>
                            <div class="col-8 text-dark fw-medium">{{ $teacher->department->name ?? '—' }}</div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-4 text-muted small text-uppercase tracking-wider fw-semibold">Position</div>
                            <div class="col-8 text-dark fw-medium">{{ $teacher->position->name ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">

                        <a href="{{ route('user.password.change') }}"
                            class="text-primary small text-decoration-none fw-semibold">
                            <i class="lni lni-lock me-1"></i> Change Password
                        </a>
                        <a href="{{ route('user.profile.edit') }}"
                            class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 small fw-semibold transition-all">
                            <i class="lni lni-pencil me-1"></i> Edit
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <style>
        .tracking-wider {
            letter-spacing: 0.1em;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .transition-all:hover {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
    </style>
@endsection
