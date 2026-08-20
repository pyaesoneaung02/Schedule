@extends('user.layouts.master')

@section('content')
    <section id="schedule" class="pb-100 pt-100 feature-section feature-style-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10">
            <div class="mb-50 text-center section-title">
              <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Weekly Timetable (By Year & Section)</h3>
            </div>
          </div>
        </div>

        <div class="row wow fadeInUp" data-wow-delay=".5s">
          <div class="col-12">

            <!-- Main Year Tabs (Dynamic) -->
            <ul class="mb-4 border-0 nav nav-tabs justify-content-center" id="timetableTabs" role="tablist">
              @foreach($years as $year)
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                          id="year-{{ $year->id }}-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#year-{{ $year->id }}"
                          type="button"
                          role="tab">
                    {{ $year->name }}
                  </button>
                </li>
              @endforeach
            </ul>

            <!-- Tabs Content for Years -->
            <div class="p-4 bg-white rounded shadow-sm tab-content" id="timetableTabContent">

              @foreach($years as $year)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                     id="year-{{ $year->id }}"
                     role="tabpanel">

                  @php
                      $yearSections = $sections->where('year_id', $year->id);
                  @endphp

                  <!-- Inner Section Tabs for current Year (Dynamic) -->
                  <ul class="mb-3 nav nav-pills justify-content-center" id="pills-tab-year-{{ $year->id }}" role="tablist">
                    @foreach($yearSections as $section)
                      <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }} btn-sm px-4 py-2 me-2 rounded-pill"
                                id="pills-year-{{ $year->id }}-sec-{{ $section->id }}-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-year-{{ $year->id }}-sec-{{ $section->id }}"
                                type="button"
                                role="tab">
                          {{ $section->name }}
                        </button>
                      </li>
                    @endforeach
                  </ul>

                  <!-- Tab Content for Sections -->
                  <div class="tab-content" id="pills-tabContent-year-{{ $year->id }}">
                    @foreach($yearSections as $section)
                      <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                           id="pills-year-{{ $year->id }}-sec-{{ $section->id }}"
                           role="tabpanel">

                        <h5 class="mb-3 text-center text-primary">{{ $year->name }} - {{ $section->name }} Timetable</h5>

                        <!-- Download Button  Start -->
                        <div class="mb-3 text-end">
                            <a href="{{ route('schedule.pdf', [
                                    'year' => $year->id,
                                    'sectionID' => $section->id,
                                    'academicYearID' => $academicYear->id ?? 1,
                                    'semesterID' => $semesters->id ?? 1,
                                    'major' => $major->id ?? 1,
                                    'room' => $room->id ?? 1
                                ]) }}"
                               class="px-3 btn btn-danger btn-sm">
                                <i class="me-1 fa-solid fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                        <!-- Download Button End -->

                        <div class="table-responsive">
                          <table class="table mb-0 text-center table-bordered timetable-table">
                            <thead>
                              <tr>
                                <th scope="col" style="width: 15%;">Time / Day</th>
                                @foreach($days as $day)
                                  <th scope="col">{{ $day->name }}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($times as $time)
                                <tr>
                                  <th scope="row" class="bg-light text-dark">{{ $time->name }}</th>

                                  @foreach($days as $day)
                                    <td>
                                      @php
                                          // Filter the specific schedule dynamically
                                          $class = $schedules->where('year_id', $year->id)
                                                             ->where('section_id', $section->id)
                                                             ->where('day_id', $day->id)
                                                             ->where('time_id', $time->id)
                                                             ->first();
                                      @endphp

                                      @if($class)
                                          <span class="fw-bold d-block subject-title">{{ $class->subject->short_name ?? $class->subject->name ?? '' }}</span>
                                          <span class="small text-muted room-no">{{ $class->room->name ?? '' }}</span>
                                      @else
                                          <span class="small text-black-50 subject-title">- Free -</span>
                                      @endif
                                    </td>
                                  @endforeach

                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                      </div>
                    @endforeach
                  </div> <!-- End Section Tab Content -->

                </div>
              @endforeach

            </div> <!-- End Year Tabs Content -->

          </div>
        </div>

      </div>
    </section>
@endsection
