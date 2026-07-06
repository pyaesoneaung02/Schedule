<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Time Table PDF</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2, h3 {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #d9d9d9;
            padding: 8px;
            text-align: center;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        .day {
            background: #f2f2f2;
            font-weight: bold;
            padding-left: 10px;
            text-align: left;
        }

        .lunch {
            background: #ffe699;
            font-weight: bold;
        }

        .extra {
            color: #777;
            font-style: italic;
        }

        .space {
            height: 35px;
        }

        .legend {
            margin-top: 50px;
        }

        .legend-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .legend-row {
            margin-bottom: 6px;
        }

        .code {
            display: inline-block;
            width: 160px;
            font-weight: bold;
        }

        .name {
            display: inline-block;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>

</head>

<body>

<h2>University Of Computer Studies (Magway)</h2>

<h3>
    {{ $yearData->name }} |
    {{ $room->name }} |
    {{ $major->name }}
</h3>

@if($schedules->isEmpty())

    <h3>No Schedule Found</h3>

@else

@php
    $scheduleMap = [];

    foreach ($schedules as $schedule) {
        $scheduleMap[$schedule->day_id][$schedule->time_id] = $schedule;
    }

    $lunchTimes = ['12:00-01:00', '01:00-02:00', '02:00-03:00'];
@endphp

<table>

    <thead>
        <tr>
            <th>Day / Time</th>

            @foreach($times as $time)
                <th>{{ $time->name }}</th>
            @endforeach

        </tr>
    </thead>

    <tbody>

    @foreach($days as $day)

        <tr>

            <td class="day">
                {{ $day->name }}
            </td>

            @foreach($times as $time)

                @php
                    $schedule = $scheduleMap[$day->id][$time->id] ?? null;
                @endphp

                <td>

                    @if(in_array($time->name, $lunchTimes))

                        <span class="lunch">
                            Lunch Break
                        </span>

                    @elseif($schedule)

                        {{ $schedule->subject->short_name }}

                    @else

                        <span class="extra">
                            Extra Curriculum
                        </span>

                    @endif

                </td>

            @endforeach

        </tr>

    @endforeach

    </tbody>

</table>

<!-- GAP -->
<div class="space"></div>

<!-- SUBJECT LIST -->
<div class="legend">

    <div class="legend-header">
        <span class="code">Subject Code</span>
        <span class="name">Subject Name</span>
    </div>

    @foreach($schedules->unique('subject_id') as $item)

        <div class="legend-row">
            <span class="code">
                {{ $item->subject->short_name }}
            </span>

            <span class="name">
                {{ $item->subject->long_name }}

                @if($item->teacher)
                    ({{ $item->teacher->name }})
                @endif
            </span>
        </div>

    @endforeach

</div>

<!-- FOOTER -->
<div class="footer">
    Generated on : {{ now()->format('d-m-Y h:i A') }}
</div>

@endif

</body>
</html>
