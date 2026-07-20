@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">


        <!-- Header -->
        <div class="mb-4 text-center">

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-building-columns"></i>

                ကွန်ပျူတာတက္ကသိုလ် (မကွေး)

            </h2>


            <h4 class="mt-3 text-dark font-weight-bold">


                @if (isset($room))
                    {{ $academicYear->name }} ပညာသင်နှစ်
                    <br><br>

                    {{ $yearData->name }}
                    ({{ $major->name }})
                    -
                    Section({{ $sections->name }})
                    -
                    အခန်း ({{ $room->name }})
                @else
                    {{ $academicYear->name }} ပညာသင်နှစ်

                    <br><br>

                    Auto Generated Timetable
                @endif


            </h4>


        </div>




        @if ($schedules->isEmpty())
            <div class="py-5 text-center text-muted">

                <i class="mb-3 fa-solid fa-calendar-xmark fa-3x"></i>

                <h5>
                    ရွေးချယ်ထားသော ပညာသင်နှစ်၊ အတန်းနှင့် အခန်းအတွက် အချိန်ဇယား မရှိပါ။
                </h5>

            </div>
        @else
            <!-- Timetable Card -->

            <div class="border-0 shadow-sm card">


                <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-calendar-days"></i>

                        အပတ်စဉ်အချိန်ဇယား

                    </h5>


                </div>



                <div class="card-body">


                    <div class="table-responsive">


                        <table class="table text-center align-middle table-bordered table-hover">


                            <thead class="text-white bg-dark">


                                <tr>

                                    <th>
                                        Day / Time
                                    </th>


                                    @foreach ($times as $time)
                                        <th>

                                            @if ($time->name == '12:00-01:00')
                                                &nbsp;
                                            @else
                                                {{ $time->name }}
                                            @endif

                                        </th>
                                    @endforeach


                                </tr>


                            </thead>

                            <tbody>

                                @foreach ($days as $index => $day)
                                    <tr>

                                        <td class="text-white font-weight-bold bg-primary">
                                            {{ $day->name }}
                                        </td>


                                        @foreach ($times as $time)
                                            @if ($time->name == '12:00-01:00')
                                                @if ($index == 0)
                                                    <td rowspan="{{ count($days) }}" class="align-middle bg-gray-300">

                                                        <span class="font-weight-bold text-dark"
                                                            style="writing-mode: vertical-rl;">
                                                            ထမင်းစားနားချိန်
                                                        </span>

                                                    </td>
                                                @endif
                                            @else
                                                @php
                                                    $schedule = $schedules->firstWhere(function ($item) use (
                                                        $day,
                                                        $time,
                                                    ) {
                                                        return $item->day_id == $day->id && $item->time_id == $time->id;
                                                    });
                                                @endphp



                                                <td>

                                                    @if ($schedule)
                                                        <span class="font-weight-bold text-primary">
                                                            {{ $schedule->subject->short_name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">
                                                            Extra Curriculum
                                                        </span>
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


            </div>


            <!-- Subject Legend -->


            <div class="mt-4 border-0 shadow-sm card">


                {{-- <div class="text-white card-header bg-primary">


                    <h5 class="mb-0">

                        <i class="mr-2 fa-solid fa-book"></i>

                        Subject List

                    </h5>


                </div> --}}



                <div class="card-body">



                    <div class="px-1 py-2 mb-2 text-white bg-dark d-flex">


                        <div class="col-2">
                            Subject Code
                        </div>


                        <div class="col-10">
                            Subject Name
                        </div>


                    </div>





                    @foreach ($schedules->unique('subject_id') as $item)
                        <div class="px-1 py-3 mb-2 border rounded d-flex">


                            <div class="col-2 font-weight-bold text-primary">


                                @if ($item->subject)
                                    {{ $item->subject->short_name }}
                                @endif


                            </div>



                            <div class="col-10">


                                @if ($item->subject)
                                    {{ $item->subject->long_name }}
                                @endif



                                @if ($item->teacher)
                                    <span class="text-muted">

                                        ({{ $item->teacher->name }})
                                    </span>
                                @endif


                            </div>


                        </div>
                    @endforeach




                </div>


            </div>





            <!-- Buttons -->


            <div class="mt-4 mb-5 text-center">


                <button onclick="window.print()" class="px-4 btn btn-primary">


                    <i class="mr-1 fa-solid fa-print"></i>

                    Print Timetable


                </button>


                @if (isset($room))
                    <a href="{{ route('schedule.pdf', [
                        'year' => $yearData->id,
                        'room' => $room->id,
                        'major' => $major->id,
                        'semesterID' => $semesters->id,
                        'sectionID' => $sections->id,
                    ]) }}"
                        class="px-4 btn btn-danger">


                        <i class="mr-1 fa-solid fa-file-pdf"></i>
                        Download PDF


                    </a>
                @endif


                @if (isset($room))
                    <a href="{{ route('schedule.list', [$yearData->id, $room->id, $major->id]) }}"
                        class="px-4 btn btn-success">

                        <i class="mr-1 fa-solid fa-pen-to-square"></i>

                        Manual Timetable

                    </a>
                @endif



            </div>
        @endif



    </div>


@endsection
