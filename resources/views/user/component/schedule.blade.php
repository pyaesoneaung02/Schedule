@extends('user.layouts.master')

@section('content')
    <section id="schedule" class="pb-100 pt-100 feature-section feature-style-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10">
            <div class="text-center mb-50 section-title">
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

                        <h5 class="mb-3 text-center" style="color: #6c757d;">{{ $year->name }} - Section ({{ $section->name }}) Timetable</h5>

                        <!-- Download Button Start -->
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
                          <table class="table mb-0 text-center shadow-sm table-bordered timetable-table">
                            <thead class="align-middle">
                              <tr>
                                <th scope="col" style="width: 15%; background-color: #6c757d; color: #fff; border-color: #6c757d;">Day / Time</th>
                                @foreach($times as $time)
                                    <th scope="col" style="background-color: #6c757d; color: #fff; border-color: #6c757d;">
                                        @if($time->name === '12:00-01:00')
                                            &nbsp;
                                        @else
                                            {{ $time->name }}
                                        @endif
                                    </th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($days as $dayIndex => $day)
                                <tr>
                                  <!-- DAY -->
                                  <th scope="row" class="align-middle" style="background-color: #6c757d; color: #fff; border-color: #6c757d;">{{ $day->name }}</th>

                                  @foreach($times as $time)
                                      {{-- LUNCH BREAK --}}
                                      @if($time->name === '12:00-01:00')
                                          @if($dayIndex === 0)
                                              <td rowspan="{{ $days->count() }}" class="align-middle bg-light">
                                                  <span class="fw-bold d-block text-secondary" style="writing-mode: vertical-rl; transform: rotate(180deg); margin: 0 auto; letter-spacing: 2px;">
                                                      ထမင်းစားနားချိန်
                                                  </span>
                                              </td>
                                          @endif
                                      @else
                                          @php
                                              $class = $schedules->where('year_id', $year->id)
                                                                 ->where('section_id', $section->id)
                                                                 ->where('day_id', $day->id)
                                                                 ->where('time_id', $time->id)
                                                                 ->first();
                                          @endphp

                                          <td class="align-middle">
                                              @if($class)
                                                  <span class="fw-bold d-block subject-title">{{ $class->subject->short_name ?? $class->subject->name ?? '' }}</span>
                                                  <span class="small text-muted room-no">{{ $class->teacher->name ?? '' }}</span>
                                              @else
                                                  <span class="small text-black-50 subject-title">Extra Curriculum</span>
                                              @endif
                                          </td>
                                      @endif
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
