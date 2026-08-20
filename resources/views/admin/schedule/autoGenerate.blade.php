@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="mt-4 mb-5 col-xl-8 col-lg-9 col-md-11">

                {{-- =========================
                PAGE HEADER
            ========================== --}}
                <div class="mb-4">

                    <div class="d-flex align-items-center">

                        <div class="mr-3 d-flex align-items-center justify-content-center"
                            style="
                            width:48px;
                            height:48px;
                            border-radius:14px;
                            background:#eef3ff;
                        ">
                            <i class="fa-solid fa-bolt text-primary" style="font-size:20px;"></i>
                        </div>

                        <div>

                            <h3 class="mb-1 font-weight-bold text-dark">
                                Auto Generate Timetable
                            </h3>

                            <p class="mb-0 text-muted">
                                Select the academic information and room
                                to generate a timetable automatically.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =========================
                ERROR MESSAGE
            ========================== --}}
                @if ($errors->any())
                    <div class="border-0 shadow-sm alert alert-danger">

                        <div class="d-flex align-items-start">

                            <i class="mt-1 mr-3 fas fa-circle-exclamation"></i>

                            <div>

                                <strong>
                                    Please check the following errors:
                                </strong>

                                <ul class="mt-2 mb-0">

                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>
                @endif


                {{-- =========================
                MAIN CARD
            ========================== --}}
                <div class="border-0 shadow-sm card"
                    style="
                    border-radius:22px;
                    overflow:hidden;
                ">

                    {{-- Card Header --}}
                    <div class="px-4 pt-4 pb-3 bg-white border-0 card-header">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="mb-1 font-weight-bold text-dark">

                                    <i class="mr-2 fa-solid fa-sliders text-primary"></i>

                                    Schedule Configuration

                                </h5>

                                <small class="text-muted">

                                    Choose all required information before generating.

                                </small>

                            </div>


                            <div>

                                <span class="px-3 py-2 badge badge-light text-primary" style="border-radius:10px;">
                                    <i class="mr-1 fa-solid fa-wand-magic-sparkles"></i>
                                    Automatic
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Card Body --}}
                    <div class="px-4 pb-4 card-body">

                        <form action="{{ route('schedule.createSchedule') }}" method="POST" id="autoGenerateForm">

                            @csrf


                            {{-- =========================
                            FIRST ROW
                        ========================== --}}
                            <div class="row">

                                {{-- Academic Year --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-calendar-days text-primary"></i>

                                            Academic Year

                                        </label>


                                        <select name="academicYearID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Academic Year --
                                            </option>

                                            @foreach ($academicYears as $academicYear)
                                                <option value="{{ $academicYear->id }}"
                                                    {{ old('academicYearID') == $academicYear->id ? 'selected' : '' }}>
                                                    {{ $academicYear->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- Semester --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-layer-group text-primary"></i>

                                            Semester

                                        </label>


                                        <select name="semesterID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Semester --
                                            </option>

                                            @foreach ($semesters as $semester)
                                                <option value="{{ $semester->id }}"
                                                    {{ old('semesterID') == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- =========================
                                SECOND ROW
                            ========================== --}}

                                {{-- Class Year --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-graduation-cap text-primary"></i>

                                            Class Year

                                        </label>


                                        <select name="yearID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Year --
                                            </option>

                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ old('yearID') == $year->id ? 'selected' : '' }}>
                                                    {{ $year->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- Major --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-building-columns text-primary"></i>

                                            Major

                                        </label>


                                        <select name="majorID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Major --
                                            </option>

                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ old('majorID') == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- =========================
                                THIRD ROW
                            ========================== --}}

                                {{-- Section --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-table-cells text-primary"></i>

                                            Section

                                        </label>


                                        <select name="sectionID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Section --
                                            </option>

                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ old('sectionID') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- Room --}}
                                <div class="col-md-6">

                                    <div class="mb-4 form-group">

                                        <label class="font-weight-bold text-dark">

                                            <i class="mr-2 fa-solid fa-door-open text-primary"></i>

                                            Room

                                        </label>


                                        <select name="roomID" id="roomID" class="form-control" required
                                            style="height:48px;border-radius:12px;">

                                            <option value="">
                                                -- Select Room --
                                            </option>

                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}"
                                                    {{ old('roomID') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- =========================
                            ROOM STATUS
                        ========================== --}}
                            <div id="roomSelectedMessage" class="mb-4 d-none">

                                <div class="p-3"
                                    style="
                                    background:#f0f7ff;
                                    border:1px solid #d8e9ff;
                                    border-radius:14px;
                                ">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-3 d-flex align-items-center justify-content-center"
                                            style="
                                            width:40px;
                                            height:40px;
                                            border-radius:12px;
                                            background:#e5f0ff;
                                        ">

                                            <i class="fa-solid fa-door-open text-primary"></i>

                                        </div>


                                        <div>

                                            <div class="font-weight-bold text-dark" id="selectedRoomName">
                                            </div>

                                            <small class="text-muted">
                                                Room selected successfully.
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- =========================
                            ACTION BUTTONS
                        ========================== --}}
                            <div class="mt-2">

                                {{-- Auto Generate --}}
                                {{-- <button type="submit" id="generateBtn" class="py-3 btn btn-primary btn-block"
                                    style="
                                    border-radius:13px;
                                    font-weight:700;
                                ">

                                    <i class="mr-2 fa-solid fa-bolt"></i>

                                    Auto Generate Schedule

                                </button> --}}


                                {{-- TEMPORARILY Auto Generate WHILE TESTING --}}


                                <button type="submit" class="py-3 btn btn-primary btn-block"
                                    style="
                                    border-radius:13px;
                                    font-weight:700;
                                ">

                                    <i class="mr-2 fa-solid fa-bolt"></i>

                                    Auto Generate Schedule

                                </button>



                                {{-- View Schedule --}}
                                <a href="{{ route('schedule.list') }}"
                                    class="py-3 mt-3 btn btn-outline-primary btn-block"
                                    style="
                                    border-radius:13px;
                                    font-weight:600;
                                ">

                                    <i class="mr-2 fa-solid fa-list"></i>

                                    View Schedule List

                                </a>


                                {{-- View Teacher --}}
                                <a href="{{ route('teacher.list') }}"
                                    class="py-3 mt-3 btn btn-outline-secondary btn-block"
                                    style="
                                    border-radius:13px;
                                    font-weight:600;
                                ">

                                    <i class="mr-2 fa-solid fa-chalkboard-user"></i>

                                    View Teacher List

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
    ROOM BUTTON SCRIPT
========================== --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const roomSelect = document.getElementById('roomID');

                const generateBtn = document.getElementById('generateBtn');

                const roomMessage = document.getElementById('roomSelectedMessage');

                const selectedRoomName =
                    document.getElementById('selectedRoomName');


                function checkRoomSelection() {

                    if (roomSelect.value !== '') {

                        /*
                        ==========================================
                        Room Selected
                        ==========================================
                        */

                        generateBtn.style.display = 'none';

                        roomMessage.classList.remove('d-none');


                        const selectedOption =
                            roomSelect.options[
                                roomSelect.selectedIndex
                            ];


                        selectedRoomName.textContent =
                            selectedOption.text;


                    } else {

                        /*
                        ==========================================
                        No Room Selected
                        ==========================================
                        */

                        generateBtn.style.display = 'block';

                        roomMessage.classList.add('d-none');

                        selectedRoomName.textContent = '';

                    }

                }


                /*
                ==========================================
                Room Change Event
                ==========================================
                */

                roomSelect.addEventListener(
                    'change',
                    checkRoomSelection
                );


                /*
                ==========================================
                Check Old Value After Validation Error
                ==========================================
                */

                checkRoomSelection();

            });
        </script>
    @endpush

@endsection
