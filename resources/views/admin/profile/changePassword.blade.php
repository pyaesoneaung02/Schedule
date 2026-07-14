@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-key"></i>

            Change Password

        </h2>


        <p class="mb-0 text-muted">
            Update your account password securely.
        </p>


    </div>




    <div class="row justify-content-center">


        <div class="col-lg-6">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-lock"></i>

                        Change Password

                    </h5>


                </div>




                <div class="card-body">


                    <form action="{{ route('profile#changePassword') }}" method="POST">

                        @csrf



                        <!-- Old Password -->

                        <div class="mb-3">


                            <label class="form-label">

                                Old Password

                            </label>


                            <input type="password"
                                name="oldPassword"
                                class="form-control @error('oldPassword') is-invalid @enderror"
                                placeholder="Enter Old Password...">


                            @error('oldPassword')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>





                        <!-- New Password -->

                        <div class="mb-3">


                            <label class="form-label">

                                New Password

                            </label>


                            <input type="password"
                                name="newPassword"
                                class="form-control @error('newPassword') is-invalid @enderror"
                                placeholder="Enter New Password...">


                            @error('newPassword')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>





                        <!-- Confirm Password -->

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





                        <!-- Button -->

                        <button type="submit"
                            class="mb-3 btn btn-primary w-100">


                            <i class="mr-2 fa-solid fa-key"></i>

                            Change Password


                        </button>





                        <a href="{{ route('profile.adminList') }}"
                            class="btn btn-success w-100">


                            <i class="mr-2 fa-solid fa-users"></i>

                            Admin Account List


                        </a>



                    </form>



                </div>


            </div>


        </div>


    </div>



</div>


@endsection
