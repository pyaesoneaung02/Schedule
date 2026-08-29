@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">


        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-chalkboard"></i>
                Update Teaching

            </h2>

            <p class="text-muted">
                Edit teacher subject assignment information.
            </p>

        </div>




        <div class="row justify-content-center">


            <div class="col-lg-8">


                <a href="{{ route('teaching.list') }}" class="btn btn-outline-secondary btn-sm mb-3">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>




                <div class="card shadow-sm border-0">


                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="fa-solid fa-pen"></i>
                            Update Teaching

                        </h5>

                    </div>




                    <div class="card-body">


                        <form action="{{ route('teaching.update', $teaching->id) }}" method="POST">

                            @csrf



                            <div class="row">



                                <div class="col-md-6">


                                    <div class="mb-3">

                                        <label>
                                            Academic Year
                                        </label>


                                        <select name="academicYearID" class="form-control">


                                            <option value="">
                                                Choose Academic Year
                                            </option>


                                            @foreach ($academicYears as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('academicYearID', $teaching->academic_year_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>

                                    </div>






                                    <div class="mb-3">

                                        <label>
                                            Semester
                                        </label>


                                        <select name="semesterID" class="form-control">


                                            <option value="">
                                                Choose Semester
                                            </option>


                                            @foreach ($semesters as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('semesterID', $teaching->semester_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>





                                    <div class="mb-3">

                                        <label>
                                            Teacher
                                        </label>


                                        <select name="teacherID" class="form-control">


                                            <option value="">
                                                Choose Teacher
                                            </option>


                                            @foreach ($teachers as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('teacherID', $teaching->teacher_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>






                                    <div class="mb-3">

                                        <label>
                                            Year
                                        </label>


                                        <select name="yearID" class="form-control">


                                            <option value="">
                                                Choose Year
                                            </option>


                                            @foreach ($years as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('yearID', $teaching->year_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>




                                </div>









                                <div class="col-md-6">





                                    <div class="mb-3">

                                        <label>
                                            Major
                                        </label>


                                        <select name="majorID" class="form-control">


                                            <option value="">
                                                Choose Major
                                            </option>


                                            @foreach ($majors as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('majorID', $teaching->major_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>






                                    <div class="mb-3">

                                        <label>
                                            Room
                                        </label>


                                        <select name="roomID" class="form-control">


                                            <option value="">
                                                Choose Room
                                            </option>


                                            @foreach ($rooms as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('roomID', $teaching->room_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>






                                    <div class="mb-3">

                                        <label>
                                            Subject
                                        </label>


                                        <select name="subjectID" class="form-control">


                                            <option value="">
                                                Choose Subject
                                            </option>


                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('subjectID', $teaching->subject_id) == $item->id) selected @endif>

                                                    {{ $item->short_name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>







                                    <div class="mb-3">

                                        <label>
                                            Section
                                        </label>


                                        <select name="sectionID" class="form-control">


                                            <option value="">
                                                Choose Section
                                            </option>


                                            @foreach ($sections as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('sectionID', $teaching->section_id) == $item->id) selected @endif>

                                                    {{ $item->name }}

                                                </option>
                                            @endforeach


                                        </select>


                                    </div>




                                </div>


                            </div>






                            <button type="submit" class="btn btn-primary w-100 mb-3">


                                <i class="fa-solid fa-save"></i>

                                Update Teaching


                            </button>





                            <a href="{{ route('teaching.list') }}" class="btn btn-outline-primary w-100">


                                <i class="fa-solid fa-list"></i>

                                View Teaching List


                            </a>




                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div>
@endsection
