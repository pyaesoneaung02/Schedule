@extends('user.layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-4 bg-danger bg-opacity-10 text-danger px-4 py-3 mb-4 small fw-medium shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 bg-success bg-opacity-10 text-success px-4 py-3 mb-4 small fw-medium shadow-sm">
                    <i class="lni lni-checkmark-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border-0 shadow-lg rounded-4 p-5">

                <div class="mb-4 pb-3 border-bottom">
                     <h5 class="fw-bold text-dark mb-0">Change Password</h5>
                </div>

                <form action="{{ route('user.password.update') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Current Password</label>
                        <input type="password" name="current_password" class="form-control rounded-3 py-2 px-3 border-light bg-light" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">New Password</label>
                        <input type="password" name="password" class="form-control rounded-3 py-2 px-3 border-light bg-light" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3 py-2 px-3 border-light bg-light" required>
                    </div>

                    <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">

                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 small fw-semibold shadow-sm transition-all">
                            Update Password
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.1em; }
    .form-control:focus { background-color: #fff !important; border-color: #0d6efd !important; box-shadow: none; }
</style>
@endsection
