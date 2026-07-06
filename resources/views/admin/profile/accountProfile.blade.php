@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">
    <div class="mb-4 shadow card col">
        <div class="py-3 card-header">
            <div class="">
                <div class="">
                    <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3 offset-1">
                        <img  src="{{ asset( Auth::user()->profile != null ? 'profile/'.Auth::user()->profile : 'admin/img/default-profile.jpg' )}}" id="output" class="img-profile w-100 h-60" alt="">
                    </div>
                    <div class="col offset-1">
                        <div class="mt-3 row">
                            <div class="col-2 h5">Name:</div>
                            <div class="col h5">{{ Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name}}</div>
                        </div>

                        <div class="mt-3 row">
                            <div class="col-2 h5">Email:</div>
                            <div class="col h5">{{ Auth::user()->email}}</div>
                        </div>

                        <div class="mt-3 row">
                            <div class="col-2 h5">Phone:</div>
                            <div class="col h5">{{ Auth::user()->phone}}</div>
                        </div>

                        <div class="mt-3 row">
                            <div class="col-2 h5">Address:</div>
                            <div class="col h5">{{ Auth::user()->address}}</div>
                        </div>

                        <div class="mt-3 row">
                            <div class="col-2 h5">Role:</div>
                            <div class="col h5 text-danger">{{ Auth::user()->role}}</div>
                        </div>

                        <a href="{{ route('profile.changePassword.page') }}" class="mt-3 text-white rounded shadow-sm btn bg-dark btn-sm"><i class="fa-solid fa-key"></i> Change Password</a>
                        <a href="{{ route('profile.editProfile')}}" class="mt-3 text-white rounded shadow-sm btn bg-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Update Profile</a>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
