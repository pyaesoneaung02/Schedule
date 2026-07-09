@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-user-tie"></i>
            Update Position
        </h2>

        <p class="mb-0 text-muted">
            Edit the selected position information.
        </p>

    </div>



    <div class="row justify-content-center">


        <div class="col-lg-5">


            <a href="{{ route('position.list') }}"
                class="mb-3 btn btn-outline-secondary btn-sm">

                <i class="mr-1 fa-solid fa-arrow-left"></i>
                Back

            </a>





            <div class="border-0 shadow-sm card">



                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-pen-to-square"></i>
                        Update Position

                    </h5>


                </div>





                <div class="card-body">


                    <form action="{{ route('position.update', $position->id) }}"
                        method="POST">

                        @csrf




                        <div class="mb-3">


                            <label class="form-label">
                                Position Name
                            </label>




                            <input type="text"
                                name="positionName"
                                value="{{ old('positionName', $position->name) }}"
                                class="form-control @error('positionName') is-invalid @enderror"
                                placeholder="Position Name...">



                            @error('positionName')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror



                        </div>






                        <button type="submit" class="btn btn-primary w-100">


                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Update


                        </button>




                    </form>


                </div>


            </div>



        </div>


    </div>


</div>


@endsection
