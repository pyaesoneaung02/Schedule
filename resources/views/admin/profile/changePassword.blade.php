@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Change Password</h1>
        </div> --}}

        <div class="">
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="card bg-info text-white mt-5">
                        <div class="card-body shadow">
                            <form action="{{ route('profile#changePassword')}}" method="POST" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                  <label class="form-label">Old Password</label>
                                  <input type="text" name="oldPassword" class="form-control" @error('oldPassword') is-invalid @enderror placeholder="Enter Old Password...">
                                    @error('oldPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">New Password</label>
                                  <input type="text" class="form-control" name="newPassword" @error('newPassword') is-invalid @enderror placeholder="Enter New Password...">
                                    @error('newPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                  <label forss="form-label">Confirm Password</label>
                                  <input type="text" class="form-control" name="confirmPassword" @error('confirmPassword') is-invalid @enderror placeholder="Enter Confirm Password.
                                  ..">
                                    @error('confirmPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="submit" value="Change Password" class="btn btn-danger w-100 shadow-sm rounded">
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('profile.adminList') }}" class="rounded shadow-sm btn btn-success w-100">Department Account List</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
