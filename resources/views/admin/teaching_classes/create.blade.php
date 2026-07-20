@extends('admin.layouts.master')


@section('content')

<div class="container-fluid">


    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">

            <i class="fa-solid fa-chalkboard mr-2"></i>

            Add Teaching

        </h2>

        <p class="text-muted">
            Assign teacher, subject and class information.
        </p>

    </div>




    <div class="row justify-content-center">


        <div class="col-lg-8">


            <div class="card shadow border-0">


                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">

                        <i class="fa-solid fa-plus mr-2"></i>

                        Create Teaching

                    </h5>

                </div>



                <div class="card-body">


                    <form action="{{ route('teaching.createTeaching') }}" method="POST">

                        @csrf



                        <div class="row">



                            <!-- Left Column -->

                            <div class="col-md-6">


                                <!-- Academic Year -->

                                <div class="mb-3">

                                    <label>
                                        Academic Year
                                    </label>


                                    <select name="academicYearID"
                                    class="form-control @error('academicYearID') is-invalid @enderror">


                                        <option value="">
                                            Choose Academic Year
                                        </option>


                                        @foreach($academicYears as $item)

                                        <option value="{{ $item->id }}"
                                            {{ old('academicYearID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>

                                        @endforeach


                                    </select>


                                    @error('academicYearID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>




                                <!-- Semester -->

                                <div class="mb-3">

                                    <label>
                                        Semester
                                    </label>


                                    <select name="semesterID"
                                    class="form-control @error('semesterID') is-invalid @enderror">


                                        <option value="">
                                            Choose Semester
                                        </option>


                                        @foreach($semesters as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('semesterID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>

                                        @endforeach


                                    </select>


                                    @error('semesterID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>





                                <!-- Teacher -->

                                <div class="mb-3">

                                    <label>
                                        Teacher
                                    </label>


                                    <select name="teacherID"
                                    class="form-control @error('teacherID') is-invalid @enderror">


                                        <option value="">
                                            Choose Teacher
                                        </option>


                                        @foreach($teachers as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('teacherID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('teacherID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>





                                <!-- Year -->

                                <div class="mb-3">

                                    <label>
                                        Year
                                    </label>


                                    <select name="yearID"
                                    class="form-control @error('yearID') is-invalid @enderror">


                                        <option value="">
                                            Choose Year
                                        </option>


                                        @foreach($years as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('yearID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('yearID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>



                            </div>






                            <!-- Right Column -->


                            <div class="col-md-6">



                                <!-- Major -->

                                <div class="mb-3">

                                    <label>
                                        Major
                                    </label>


                                    <select name="majorID"
                                    class="form-control @error('majorID') is-invalid @enderror">


                                        <option value="">
                                            Choose Major
                                        </option>


                                        @foreach($majors as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('majorID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('majorID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>





                                <!-- Room -->

                                <div class="mb-3">

                                    <label>
                                        Room
                                    </label>


                                    <select name="roomID"
                                    class="form-control @error('roomID') is-invalid @enderror">


                                        <option value="">
                                            Choose Room
                                        </option>


                                        @foreach($rooms as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('roomID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('roomID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>






                                <!-- Subject -->


                                <div class="mb-3">

                                    <label>
                                        Subject
                                    </label>


                                    <select name="subjectID"
                                    class="form-control @error('subjectID') is-invalid @enderror">


                                        <option value="">
                                            Choose Subject
                                        </option>


                                        @foreach($subjects as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('subjectID')==$item->id ? 'selected':'' }}>

                                            {{ $item->short_name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('subjectID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>






                                <!-- Section -->


                                <div class="mb-3">

                                    <label>
                                        Section
                                    </label>


                                    <select name="sectionID"
                                    class="form-control @error('sectionID') is-invalid @enderror">


                                        <option value="">
                                            Choose Section
                                        </option>


                                        @foreach($sections as $item)

                                        <option value="{{ $item->id }}"
                                        {{ old('sectionID')==$item->id ? 'selected':'' }}>

                                            {{ $item->name }}

                                        </option>


                                        @endforeach


                                    </select>


                                    @error('sectionID')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror


                                </div>



                            </div>


                        </div>





                        <button type="submit"
                        class="btn btn-primary w-100 mb-3">


                            <i class="fa fa-save mr-2"></i>

                            Create Teaching


                        </button>



                        <a href="{{ route('teaching.list') }}"
                        class="btn btn-outline-primary w-100">


                            <i class="fa fa-list mr-2"></i>

                            View Teaching List


                        </a>



                    </form>


                </div>


            </div>


        </div>


    </div>


</div>


@endsection
