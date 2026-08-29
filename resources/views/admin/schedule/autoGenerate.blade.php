@extends('admin.layouts.master')

@section('content')

<div class="container-fluid py-4">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="text-center mb-4">

        <div class="generate-icon">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>

        <h2 class="font-weight-bold text-primary mt-3">
            Auto Generate Timetable
        </h2>

        <p class="text-muted mb-0">
            Generate timetable for all sections
        </p>

    </div>


    {{-- =====================================================
        ERROR
    ====================================================== --}}

    @if ($errors->any())

        <div class="alert alert-danger generate-alert">

            <div class="font-weight-bold mb-2">

                <i class="fa-solid fa-circle-exclamation mr-2"></i>

                Auto Generate Failed

            </div>

            <ul class="mb-0 pl-4">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
        SUCCESS
    ====================================================== --}}

    @if (session('success'))

        <div class="alert alert-success generate-alert">

            <i class="fa-solid fa-circle-check mr-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
        FORM
    ====================================================== --}}

    <div class="row justify-content-center">

        <div class="col-xl-8 col-lg-10">

            <div class="card generate-card">

                <div class="card-header">

                    <div class="d-flex align-items-center">

                        <div class="header-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>

                        <div>

                            <h5 class="mb-0 font-weight-bold">
                                Generate Timetable
                            </h5>

                            <small class="text-muted">
                                Select academic information
                            </small>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <form
                        action="{{ route('schedule.createSchedule') }}"
                        method="POST"
                        id="generateForm"
                    >

                        @csrf


                        {{-- =================================================
                            ACADEMIC YEAR
                        ================================================== --}}

                        <div class="form-group">

                            <label>
                                Academic Year
                            </label>

                            <select
                                name="academicYearID"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Academic Year
                                </option>

                                @foreach ($academicYears as $academicYear)

                                    <option
                                        value="{{ $academicYear->id }}"
                                        {{ old('academicYearID') == $academicYear->id ? 'selected' : '' }}
                                    >
                                        {{ $academicYear->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                            SEMESTER
                        ================================================== --}}

                        <div class="form-group">

                            <label>
                                Semester
                            </label>

                            <select
                                name="semesterID"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Semester
                                </option>

                                @foreach ($semesters as $semester)

                                    <option
                                        value="{{ $semester->id }}"
                                        {{ old('semesterID') == $semester->id ? 'selected' : '' }}
                                    >
                                        {{ $semester->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                            YEAR
                        ================================================== --}}

                        <div class="form-group">

                            <label>
                                Year
                            </label>

                            <select
                                name="yearID"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Year
                                </option>

                                @foreach ($years as $year)

                                    <option
                                        value="{{ $year->id }}"
                                        {{ old('yearID') == $year->id ? 'selected' : '' }}
                                    >
                                        {{ $year->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                            MAJOR
                        ================================================== --}}

                        <div class="form-group">

                            <label>
                                Major
                            </label>

                            <select
                                name="majorID"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Major
                                </option>

                                @foreach ($majors as $major)

                                    <option
                                        value="{{ $major->id }}"
                                        {{ old('majorID') == $major->id ? 'selected' : '' }}
                                    >
                                        {{ $major->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                            INFORMATION
                        ================================================== --}}

                        <div class="generate-info">

                            <div class="info-icon">

                                <i class="fa-solid fa-circle-info"></i>

                            </div>

                            <div>

                                <strong>
                                    Generate All Sections
                                </strong>

                                <p class="mb-0">
                                    Selected Year + Major အတွက်
                                    Database ထဲရှိ Section အားလုံးကို
                                    တစ်ခါတည်း timetable generate လုပ်ပေးပါမည်။
                                </p>

                            </div>

                        </div>


                        {{-- =================================================
                            SUBMIT
                        ================================================== --}}

                        <button
                            type="submit"
                            class="btn btn-primary btn-generate"
                            id="generateButton"
                        >

                            <span id="generateNormal">

                                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>

                                Generate All Sections

                            </span>

                            <span
                                id="generateLoading"
                                style="display:none;"
                            >

                                <span
                                    class="spinner-border spinner-border-sm mr-2"
                                ></span>

                                Generating...

                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

.generate-icon {

    width: 75px;
    height: 75px;

    margin: auto;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 20px;

    background: #f0f5ff;

    color: #4e73df;

    font-size: 30px;

}


.generate-card {

    border: 0;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 8px 30px rgba(0,0,0,.08);

}


.generate-card .card-header {

    background: #fff;

    border-bottom: 1px solid #eee;

    padding: 20px 25px;

}


.header-icon {

    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #f0f5ff;

    color: #4e73df;

    margin-right: 12px;

}


.generate-card .card-body {

    padding: 30px;

}


.form-group {

    margin-bottom: 22px;

}


.form-group label {

    display: block;

    font-weight: 600;

    color: #343a40;

    margin-bottom: 8px;

}


.form-control {

    height: 48px;

    border-radius: 10px;

}


.generate-info {

    display: flex;

    gap: 12px;

    padding: 15px;

    margin-top: 10px;

    margin-bottom: 25px;

    border-radius: 12px;

    background: #f8f9fa;

}


.info-icon {

    color: #4e73df;

    font-size: 20px;

}


.generate-info strong {

    color: #343a40;

}


.generate-info p {

    color: #6c757d;

    font-size: 14px;

    margin-top: 3px;

}


.btn-generate {

    width: 100%;

    height: 50px;

    border-radius: 10px;

    font-weight: 600;

    font-size: 15px;

}


.generate-alert {

    max-width: 900px;

    margin: 0 auto 25px;

    border-radius: 12px;

}


</style>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'generateForm'
            );

        const button =
            document.getElementById(
                'generateButton'
            );

        const normal =
            document.getElementById(
                'generateNormal'
            );

        const loading =
            document.getElementById(
                'generateLoading'
            );


        if (!form) {
            return;
        }


        form.addEventListener(
            'submit',
            function () {

                if (button) {

                    button.disabled = true;

                }


                if (normal) {

                    normal.style.display =
                        'none';

                }


                if (loading) {

                    loading.style.display =
                        'inline';

                }

            }
        );

    }
);

</script>

@endsection
