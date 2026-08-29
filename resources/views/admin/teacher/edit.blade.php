@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-chalkboard-user"></i>
            Update Teacher
        </h2>

        <p class="mb-0 text-muted">
            Edit the selected teacher information.
        </p>

    </div>




    <div class="row justify-content-center">


        <div class="col-lg-5">


            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-pen-to-square"></i>
                        Update Teacher

                    </h5>


                </div>





                <div class="card-body">


                    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST">

                        @csrf





                        <div class="mb-3">


                            <label class="form-label">
                                Teacher Name
                            </label>



                            <input type="text"
                                name="name"
                                value="{{ old('name', $teacher->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Teacher Name...">



                            @error('name')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror



                        </div>







                        <div class="mb-3">


                            <label class="form-label">
                                Select Position
                            </label>



                            <select name="positionID"
                                class="form-control @error('positionID') is-invalid @enderror">


                                <option value="">
                                    Choose Position
                                </option>




                                @foreach ($positions as $item)


                                    <option value="{{ $item->id }}"
                                        @if(old('positionID', $teacher->position_id) == $item->id) selected @endif>

                                        {{ $item->name }}

                                    </option>


                                @endforeach



                            </select>




                            @error('positionID')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror



                        </div>







                        <div class="mb-3">


                            <label class="form-label">
                                Select Department
                            </label>




                            <select name="departmentID"
                                class="form-control @error('departmentID') is-invalid @enderror">


                                <option value="">
                                    Choose Department
                                </option>




                                @foreach ($departments as $item)


                                    <option value="{{ $item->id }}"
                                        @if(old('departmentID', $teacher->department_id) == $item->id) selected @endif>

                                        {{ $item->name }}

                                    </option>


                                @endforeach




                            </select>




                            @error('departmentID')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror



                        </div>







                        <button type="submit" class="mb-3 btn btn-primary w-100">


                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Update Teacher


                        </button>






                        <a href="{{ route('teacher.list') }}"
                            class="btn btn-outline-primary w-100">


                            <i class="mr-2 fa-solid fa-list"></i>
                            View Teacher List


                        </a>





                    </form>



                </div>


            </div>


        </div>


    </div>


</div>


@endsection
