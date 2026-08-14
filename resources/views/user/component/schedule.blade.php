@extends('user.layouts.master')

@section('content')
    <section id="schedule" class="feature-section feature-style-5 pb-100 pt-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10">
                    <div class="section-title text-center mb-50">
                        <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Weekly Timetable (By Year & Section)</h3>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInUp" data-wow-delay=".5s">
                <div class="col-12">
                    <!-- Main Year Tabs -->
                    <ul class="nav nav-tabs justify-content-center border-0 mb-4" id="timetableTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="first-year-tab" data-bs-toggle="tab"
                                data-bs-target="#first-year" type="button" role="tab">First Year</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="second-year-tab" data-bs-toggle="tab" data-bs-target="#second-year"
                                type="button" role="tab">Second Year</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="third-year-tab" data-bs-toggle="tab" data-bs-target="#third-year"
                                type="button" role="tab">Third Year</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content shadow-sm p-4 rounded bg-white" id="timetableTabContent">

                        <!-- First Year Timetable -->
                        <div class="tab-pane fade show active" id="first-year" role="tabpanel">

                            <!-- Inner Section Tabs for First Year -->
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab-1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active btn-sm px-4 py-2 me-2 rounded-pill" id="pills-1A-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-1A" type="button"
                                        role="tab">Section A</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn-sm px-4 py-2 rounded-pill" id="pills-1B-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-1B" type="button"
                                        role="tab">Section B</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent-1">
                                <!-- Section A Timetable -->
                                <div class="tab-pane fade show active" id="pills-1A" role="tabpanel">
                                    <h5 class="text-center text-primary mb-3">First Year - Section (A) Timetable</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center timetable-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 15%;">Time / Day</th>
                                                    <th scope="col">Monday</th>
                                                    <th scope="col">Tuesday</th>
                                                    <th scope="col">Wednesday</th>
                                                    <th scope="col">Thursday</th>
                                                    <th scope="col">Friday</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">09:00 - 10:30 AM</th>
                                                    <td><span class="subject-title">C++ Programming</span><span
                                                            class="room-no">Room 101</span></td>
                                                    <td><span class="subject-title">Calculus I</span><span
                                                            class="room-no">Room 102</span></td>
                                                    <td><span class="subject-title">English</span><span class="room-no">Room
                                                            104</span></td>
                                                    <td><span class="subject-title">Physics</span><span class="room-no">Room
                                                            103</span></td>
                                                    <td><span class="subject-title">Myanmar</span><span class="room-no">Room
                                                            102</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">10:45 - 12:15 PM</th>
                                                    <td><span class="subject-title">IT Fundamentals</span><span
                                                            class="room-no">Room 105</span></td>
                                                    <td><span class="subject-title">- Free Period -</span></td>
                                                    <td><span class="subject-title">Physics</span><span class="room-no">Lab
                                                            B</span></td>
                                                    <td><span class="subject-title">IT Fundamentals</span><span
                                                            class="room-no">Room 105</span></td>
                                                    <td><span class="subject-title">English</span><span class="room-no">Room
                                                            104</span></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="bg-light text-muted fw-bold py-3">LUNCH
                                                        BREAK (12:15 PM - 01:15 PM)</th>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">01:15 - 03:00 PM</th>
                                                    <td><span class="subject-title">C++ Practical Lab</span><span
                                                            class="room-no">Computer Lab 1</span></td>
                                                    <td><span class="subject-title">C++ Practical Lab</span><span
                                                            class="room-no">Computer Lab 1</span></td>
                                                    <td><span class="subject-title">Physics Lab</span><span
                                                            class="room-no">Physics Lab</span></td>
                                                    <td><span class="subject-title">- Free Period -</span></td>
                                                    <td><span class="subject-title">Library</span><span
                                                            class="room-no">Library</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Section B Timetable -->
                                <div class="tab-pane fade" id="pills-1B" role="tabpanel">
                                    <h5 class="text-center text-primary mb-3">First Year - Section (B) Timetable</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center timetable-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 15%;">Time / Day</th>
                                                    <th scope="col">Monday</th>
                                                    <th scope="col">Tuesday</th>
                                                    <th scope="col">Wednesday</th>
                                                    <th scope="col">Thursday</th>
                                                    <th scope="col">Friday</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">09:00 - 10:30 AM</th>
                                                    <td><span class="subject-title">Calculus I</span><span
                                                            class="room-no">Room 102</span></td>
                                                    <td><span class="subject-title">C++ Programming</span><span
                                                            class="room-no">Room 101</span></td>
                                                    <td><span class="subject-title">Physics</span><span
                                                            class="room-no">Room 103</span></td>
                                                    <td><span class="subject-title">English</span><span
                                                            class="room-no">Room 104</span></td>
                                                    <td><span class="subject-title">Myanmar</span><span
                                                            class="room-no">Room 102</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">10:45 - 12:15 PM</th>
                                                    <td><span class="subject-title">IT Fundamentals</span><span
                                                            class="room-no">Room 105</span></td>
                                                    <td><span class="subject-title">English</span><span
                                                            class="room-no">Room 104</span></td>
                                                    <td><span class="subject-title">- Free Period -</span></td>
                                                    <td><span class="subject-title">IT Fundamentals</span><span
                                                            class="room-no">Room 105</span></td>
                                                    <td><span class="subject-title">Physics</span><span
                                                            class="room-no">Lab B</span></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="bg-light text-muted fw-bold py-3">LUNCH
                                                        BREAK (12:15 PM - 01:15 PM)</th>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="bg-light text-dark">01:15 - 03:00 PM</th>
                                                    <td><span class="subject-title">Physics Lab</span><span
                                                            class="room-no">Physics Lab</span></td>
                                                    <td><span class="subject-title">- Free Period -</span></td>
                                                    <td><span class="subject-title">C++ Practical Lab</span><span
                                                            class="room-no">Computer Lab 2</span></td>
                                                    <td><span class="subject-title">C++ Practical Lab</span><span
                                                            class="room-no">Computer Lab 2</span></td>
                                                    <td><span class="subject-title">Library</span><span
                                                            class="room-no">Library</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Second Year Timetable (Placeholder for Section A/B setup) -->
                        <div class="tab-pane fade" id="second-year" role="tabpanel">
                            <div class="text-center p-4">
                                <h5 class="text-muted">Second Year sections (Section A & B) can be structured similarly
                                    here.</h5>
                            </div>
                        </div>

                        <!-- Third Year Timetable -->
                        <div class="tab-pane fade" id="third-year" role="tabpanel">
                            <div class="text-center p-4">
                                <h5 class="text-muted">Third Year sections (CS & CT specializations/sections) can be added
                                    here.</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
