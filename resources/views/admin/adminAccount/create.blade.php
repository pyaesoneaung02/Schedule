@extends('admin.layouts.master')

@section('content')

<div class="mt-5 container-fluid">


    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-user-plus"></i>

            New Admin Account

        </h2>


        <p class="mb-0 text-muted">

            Create a new administrator account.

        </p>

    </div>





    <div class="row justify-content-center">


        <div class="col-lg-6">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-user-shield"></i>

                        Create Admin


                    </h5>


                </div>





                <div class="card-body">


                    <form action="{{ route('profile#createAdminAccount') }}"
                        method="POST">

                        @csrf



                        <div class="mb-3">

                            <label class="form-label">
                                Name
                            </label>


                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Name...">


                            @error('name')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>





                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>


                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email...">


                            @error('email')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>






                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>


                            <input type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password...">


                            @error('password')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>






                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>


                            <input type="password"
                                name="confirmPassword"
                                class="form-control @error('confirmPassword') is-invalid @enderror"
                                placeholder="Enter Confirm Password...">


                            @error('confirmPassword')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>






                        <button type="submit"
                            class="mb-3 btn btn-primary w-100">

                            <i class="mr-2 fa-solid fa-floppy-disk"></i>

                            Create Account

                        </button>





                        <a href="{{ route('profile.adminList') }}"
                            class="btn btn-outline-primary w-100">


                            <i class="mr-2 fa-solid fa-list"></i>

                            User Account List


                        </a>



                    </form>



                </div>


            </div>


        </div>


    </div>



</div>

@endsection
