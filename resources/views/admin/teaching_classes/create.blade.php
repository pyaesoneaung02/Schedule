@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="mb-4">


        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-chalkboard"></i>
            Teaching Management

        </h2>


        <p class="mb-0 text-muted">
            Assign teachers with subjects and classes.
        </p>


    </div>






    <div class="row justify-content-center">


        <div class="col-lg-7">


            <div class="border-0 shadow-sm card">



                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-plus"></i>
                        Add New Teaching

                    </h5>


                </div>







                <div class="card-body">


                    <form action="{{ route('teaching.createTeaching') }}" method="POST">

                        @csrf






                        <div class="row">



                            <div class="col-md-6">



                                <div class="mb-3">


                                    <label class="form-label">
                                        Teacher Name
                                    </label>




                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
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
                                        Select Year
                                    </label>




                                    <select name="yearID"
                                        class="form-control @error('yearID') is-invalid @enderror">


                                        <option value="">
                                            Choose Year
                                        </option>



                                        @foreach ($years as $item)


                                            <option value="{{ $item->id }}"
                                                @if(old('yearID') == $item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>


                                        @endforeach



                                    </select>





                                    @error('yearID')

                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>

                                    @enderror



                                </div>



                            </div>








                            <div class="col-md-6">



                                <div class="mb-3">


                                    <label class="form-label">
                                        Select Major
                                    </label>




                                    <select name="majorID"
                                        class="form-control @error('majorID') is-invalid @enderror">


                                        <option value="">
                                            Choose Major
                                        </option>




                                        @foreach ($majors as $item)


                                            <option value="{{ $item->id }}"
                                                @if(old('majorID') == $item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>



                                        @endforeach



                                    </select>




                                    @error('majorID')

                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>

                                    @enderror



                                </div>








                                <div class="mb-3">


                                    <label class="form-label">
                                        Select Room
                                    </label>




                                    <select name="roomID"
                                        class="form-control @error('roomID') is-invalid @enderror">


                                        <option value="">
                                            Choose Class
                                        </option>




                                        @foreach ($rooms as $item)


                                            <option value="{{ $item->id }}"
                                                @if(old('roomID') == $item->id) selected @endif>

                                                {{ $item->name }}

                                            </option>



                                        @endforeach



                                    </select>





                                    @error('roomID')

                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>

                                    @enderror



                                </div>



                            </div>





                        </div>








                        <div class="mb-3">


                            <label class="form-label">
                                Select Subject
                            </label>




                            <select name="subjectID"
                                class="form-control @error('subjectID') is-invalid @enderror">


                                <option value="">
                                    Choose Subject
                                </option>




                                @foreach ($subjects as $item)


                                    <option value="{{ $item->id }}"
                                        @if(old('subjectID') == $item->id) selected @endif>

                                        {{ $item->short_name }}

                                    </option>



                                @endforeach



                            </select>




                            @error('subjectID')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror



                        </div>







                        <button type="submit" class="mb-3 btn btn-primary w-100">


                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Create Teaching


                        </button>







                        <a href="{{ route('teaching.list') }}"
                            class="btn btn-outline-primary w-100">


                            <i class="mr-2 fa-solid fa-list"></i>
                            View Teaching List


                        </a>





                    </form>



                </div>



            </div>



        </div>



    </div>




</div>


@endsection
