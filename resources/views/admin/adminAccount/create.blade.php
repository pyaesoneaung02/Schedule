@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 card p-3 shadow-sm rounded">
                <div class="card-title d-flex justify-content-center bg-info text-white p-3 h5 rounded">New Admin Account</div>
                <form action="{{ route('profile#createAdminAccount') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                @error('name') is-invalid @enderror placeholder="Enter Name...">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                @error('email') is-invalid @enderror placeholder="Enter Email...">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                @error('password') is-invalid @enderror placeholder="Enter Password...">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ConfirmPassword</label>
                            <input type="password" name="confirmPassword" class="form-control"
                                @error('confirmPassword') is-invalid @enderror placeholder="Enter ConfirmPassword...">
                            @error('confirmPassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Create Account" class="btn btn-danger w-100 shadow-sm rounded">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('profile.adminList') }}" class="rounded shadow-sm btn btn-success w-100">Department Account List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
