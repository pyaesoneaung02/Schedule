@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 shadow card col">
            <div class="py-3 card-header">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( <span
                                class="text-danger">{{ Auth::user()->role }} Account</span> ) </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('profile.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            {{-- <input type="hidden" name="oldImage"> --}}
                            <img src="{{ asset(Auth::user()->profile != null ? 'profile/' . Auth::user()->profile : 'admin/img/default-profile.jpg') }}"
                                id="output" class="img-profile w-100 h-60" alt="">

                            <input type="file" name="image"
                                class="form-control mt-1 @error('image') is-invalid @enderror" onchange="loadFile(event)">
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col">
                            <div class="row">

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                                        <input type="text" name="name" id="exampleFormControlInput1"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}"
                                            placeholder="Enter Name...">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                                        <input type="text" name="email" id="exampleFormControlInput1"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Email...">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                        <input type="text" name="phone" id="exampleFormControlInput1"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="Enter Phone...">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Address</label>
                                        <input type="text" name="address" id="exampleFormControlInput1"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', Auth::user()->address) }}"
                                            placeholder="Enter Address...">
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Update Profile" class="mt-3 rounded shadow-sm btn btn-danger">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
