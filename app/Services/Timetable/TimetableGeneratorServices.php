<?php

namespace App\Services\Timetable;

use App\Models\Day;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Teaching;
use App\Models\Time;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TimetableGeneratorService
{
    /*
    |--------------------------------------------------------------------------
    | CONFIGURATION
    |--------------------------------------------------------------------------
    */

    protected int $maxTeacherDaily = 4;

    protected int $maxTeacherWeekly = 20;

    protected int $maxClassDaily = 5;

    /*
    |--------------------------------------------------------------------------
    | Subject can appear only once per day
    |--------------------------------------------------------------------------
    */

    protected int $maxSubjectDaily = 1;

    /*
    |--------------------------------------------------------------------------
    | Prevent endless recursive processing
    |--------------------------------------------------------------------------
    */

    protected int $maxBacktracks = 15000;

    protected int $backtracks = 0;

    /*
    |--------------------------------------------------------------------------
    | OCCUPANCY
    |--------------------------------------------------------------------------
    */

    protected array $occupancy = [
        'teacher' => [],
        'room'    => [],
        'class'   => [],
    ];

    /*
    |--------------------------------------------------------------------------
    | GENERATED SCHEDULES
    |--------------------------------------------------------------------------
    */

    protected array $generated = [];

    protected array $subjects = [];

    protected array $slots = [];

    /*
    |--------------------------------------------------------------------------
    | TIME GROUPS
    |--------------------------------------------------------------------------
    */

    protected array $morningTimeIDs = [];

    protected array $afternoonTimeIDs = [];

    protected Collection $rooms;

    protected int $academicYearID;

    protected int $semesterID;

    protected int $yearID;

    protected int $majorID;

    /*
    |--------------------------------------------------------------------------
    | CACHE EXISTING SUBJECT DAILY COUNTS
    |--------------------------------------------------------------------------
    */

    protected array $existingSubjectDaily = [];

    /*
    |--------------------------------------------------------------------------
    | MAIN GENERATOR
    |--------------------------------------------------------------------------
    */

    public function generate(
        int $academicYearID,
        int $semesterID,
        int $yearID,
        int $majorID,
        ?int $selectedRoomID = null
    ): array {

        $this->academicYearID = $academicYearID;
        $this->semesterID     = $semesterID;
        $this->yearID         = $yearID;
        $this->majorID        = $majorID;

        $this->resetState();

        /*
        |--------------------------------------------------------------------------
        | DAYS
        |--------------------------------------------------------------------------
        */

        $days = Day::query()
            ->orderBy('id')
            ->get();

        if ($days->isEmpty()) {
            throw new RuntimeException(
                'No days found in database.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TIMES
        |--------------------------------------------------------------------------
        */

        $allTimes = Time::query()
            ->orderBy('id')
            ->get();

        if ($allTimes->isEmpty()) {
            throw new RuntimeException(
                'No time slots found in database.'
            );
        }

        $times = $allTimes
            ->filter(function ($time) {

                return !$this->isLunchTime(
                    (string) $time->name
                );
            })
            ->values();

        if ($times->isEmpty()) {
            throw new RuntimeException(
                'No usable time slots found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BUILD MORNING / AFTERNOON TIME IDS ONCE
        |--------------------------------------------------------------------------
        */

        $this->buildTimeGroups(
            $times
        );

        /*
        |--------------------------------------------------------------------------
        | SECTIONS
        |--------------------------------------------------------------------------
        */

        $sections = Sections::query()
            ->orderBy('id')
            ->get();

        if ($sections->isEmpty()) {
            throw new RuntimeException(
                'No sections found in database.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TEACHINGS
        |--------------------------------------------------------------------------
        */

        $teachings = Teaching::query()
            ->with([
                'subject',
            ])
            ->where(
                'academic_year_id',
                $academicYearID
            )
            ->where(
                'semester_id',
                $semesterID
            )
            ->where(
                'year_id',
                $yearID
            )
            ->where(
                'major_id',
                $majorID
            )
            ->get();

        if ($teachings->isEmpty()) {
            throw new RuntimeException(
                'No teaching data found for this Year and Major.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ROOMS
        |--------------------------------------------------------------------------
        */

        $this->rooms = $this->getAvailableRooms(
            $selectedRoomID
        );

        if ($this->rooms->isEmpty()) {
            throw new RuntimeException(
                'No rooms are available.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD EXISTING SCHEDULE OCCUPANCY
        |--------------------------------------------------------------------------
        */

        $this->loadExistingOccupancy();

        /*
        |--------------------------------------------------------------------------
        | BUILD AVAILABLE SLOTS
        |--------------------------------------------------------------------------
        */

        foreach ($days as $day) {

            foreach ($times as $time) {

                $this->slots[] = [

                    'day_id' =>
                        (int) $day->id,

                    'time_id' =>
                        (int) $time->id,

                    'period' =>
                        $this->getTimePeriod(
                            (int) $time->id
                        ),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BUILD TASKS
        |--------------------------------------------------------------------------
        */

        $tasks = $this->buildSubjectTasks(
            $teachings,
            $sections
        );

        if (empty($tasks)) {

            throw new RuntimeException(
                'No subjects need to be generated.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK CAPACITY BEFORE SOLVING
        |--------------------------------------------------------------------------
        */

        $this->validateCapacity(
            $tasks,
            $days,
            $times
        );

        /*
        |--------------------------------------------------------------------------
        | HARDEST TASKS FIRST
        |--------------------------------------------------------------------------
        */

        usort(
            $tasks,
            function ($a, $b) {

                /*
                |--------------------------------------------------------------------------
                | Higher remaining periods first
                |--------------------------------------------------------------------------
                */

                $compare =
                    $b['remaining']
                    <=>
                    $a['remaining'];

                if ($compare !== 0) {
                    return $compare;
                }

                /*
                |--------------------------------------------------------------------------
                | Teacher with more workload first
                |--------------------------------------------------------------------------
                */

                $compare =
                    $b['teacher_weekly']
                    <=>
                    $a['teacher_weekly'];

                if ($compare !== 0) {
                    return $compare;
                }

                /*
                |--------------------------------------------------------------------------
                | Section order
                |--------------------------------------------------------------------------
                */

                return
                    $a['section_id']
                    <=>
                    $b['section_id'];
            }
        );

        $this->subjects = $tasks;

        /*
        |--------------------------------------------------------------------------
        | GENERATE
        |--------------------------------------------------------------------------
        */

        $success = $this->solve(0);

        if (!$success) {

            $details =
                $this->buildFailureDetails();

            throw new RuntimeException(
                'Unable to generate complete timetable. '
                . implode(' | ', $details)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () {

                foreach (
                    $this->generated
                    as $item
                ) {

                    Schedule::create([

                        'academic_year_id' =>
                            $item['academic_year_id'],

                        'semester_id' =>
                            $item['semester_id'],

                        'year_id' =>
                            $item['year_id'],

                        'major_id' =>
                            $item['major_id'],

                        'section_id' =>
                            $item['section_id'],

                        'room_id' =>
                            $item['room_id'],

                        'subject_id' =>
                            $item['subject_id'],

                        'teacher_id' =>
                            $item['teacher_id'],

                        'day_id' =>
                            $item['day_id'],

                        'time_id' =>
                            $item['time_id'],

                        'is_shifted' =>
                            false,
                    ]);
                }

                return $this->generated;
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESET STATE
    |--------------------------------------------------------------------------
    */

    protected function resetState(): void
    {
        $this->occupancy = [
            'teacher' => [],
            'room'    => [],
            'class'   => [],
        ];

        $this->generated = [];

        $this->subjects = [];

        $this->slots = [];

        $this->morningTimeIDs = [];

        $this->afternoonTimeIDs = [];

        $this->existingSubjectDaily = [];

        $this->backtracks = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | LUNCH CHECK
    |--------------------------------------------------------------------------
    */

    protected function isLunchTime(
        string $timeName
    ): bool {

        $normalized = str_replace(
            [' ', '–', '—'],
            ['', '-', '-'],
            trim($timeName)
        );

        return in_array(
            $normalized,
            [
                '12:00-01:00',
                '12:00-1:00',
                '12:00-13:00',
            ],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BUILD MORNING / AFTERNOON GROUPS
    |--------------------------------------------------------------------------
    */

    protected function buildTimeGroups(
        Collection $times
    ): void {

        foreach ($times as $time) {

            $timeID =
                (int) $time->id;

            $name =
                trim(
                    (string) $time->name
                );

            /*
            |--------------------------------------------------------------------------
            | Afternoon detection
            |--------------------------------------------------------------------------
            */

            $isAfternoon =
                str_contains(
                    $name,
                    '01:'
                )
                ||
                str_contains(
                    $name,
                    '1:'
                )
                ||
                str_contains(
                    $name,
                    '02:'
                )
                ||
                str_contains(
                    $name,
                    '2:'
                )
                ||
                str_contains(
                    $name,
                    '03:'
                )
                ||
                str_contains(
                    $name,
                    '3:'
                )
                ||
                str_contains(
                    $name,
                    '04:'
                )
                ||
                str_contains(
                    $name,
                    '4:'
                );

            if ($isAfternoon) {

                $this->afternoonTimeIDs[] =
                    $timeID;

            } else {

                $this->morningTimeIDs[] =
                    $timeID;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->morningTimeIDs)
            ||
            empty($this->afternoonTimeIDs)
        ) {

            $ids =
                $times
                    ->pluck('id')
                    ->map(
                        fn ($id) => (int) $id
                    )
                    ->values()
                    ->all();

            $middle =
                (int) ceil(
                    count($ids) / 2
                );

            $this->morningTimeIDs =
                array_slice(
                    $ids,
                    0,
                    $middle
                );

            $this->afternoonTimeIDs =
                array_slice(
                    $ids,
                    $middle
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET TIME PERIOD
    |--------------------------------------------------------------------------
    */

    protected function getTimePeriod(
        int $timeID
    ): string {

        if (
            in_array(
                $timeID,
                $this->morningTimeIDs,
                true
            )
        ) {

            return 'morning';
        }

        return 'afternoon';
    }

    /*
    |--------------------------------------------------------------------------
    | GET ROOMS
    |--------------------------------------------------------------------------
    */

    protected function getAvailableRooms(
        ?int $selectedRoomID
    ): Collection {

        $query =
            Room::query();

        if ($selectedRoomID) {

            $query->orderByRaw(
                'CASE WHEN id = ? THEN 0 ELSE 1 END',
                [$selectedRoomID]
            );
        }

        return $query
            ->orderBy('id')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD EXISTING OCCUPANCY
    |--------------------------------------------------------------------------
    */

    protected function loadExistingOccupancy(): void
    {
        $schedules = Schedule::query()
            ->where(
                'academic_year_id',
                $this->academicYearID
            )
            ->where(
                'semester_id',
                $this->semesterID
            )
            ->get();

        foreach ($schedules as $schedule) {

            if (
                !$schedule->day_id
                ||
                !$schedule->time_id
            ) {
                continue;
            }

            $dayID =
                (int) $schedule->day_id;

            $timeID =
                (int) $schedule->time_id;

            $slotKey =
                $dayID
                . '_'
                . $timeID;

            if ($schedule->teacher_id) {

                $teacherID =
                    (int) $schedule->teacher_id;

                $this->occupancy['teacher']
                    [$teacherID]
                    [$slotKey] = true;
            }

            if ($schedule->room_id) {

                $roomID =
                    (int) $schedule->room_id;

                $this->occupancy['room']
                    [$roomID]
                    [$slotKey] = true;
            }

            if ($schedule->section_id) {

                $classKey =
                    $schedule->year_id
                    . '_'
                    . $schedule->major_id
                    . '_'
                    . $schedule->section_id;

                $this->occupancy['class']
                    [$classKey]
                    [$slotKey] = true;
            }

            /*
            |--------------------------------------------------------------------------
            | Existing subject daily cache
            |--------------------------------------------------------------------------
            */

            if (
                $schedule->section_id
                &&
                $schedule->subject_id
            ) {

                $key =
                    $schedule->section_id
                    . '_'
                    . $schedule->subject_id
                    . '_'
                    . $dayID;

                $this->existingSubjectDaily[$key] =
                    ($this->existingSubjectDaily[$key] ?? 0)
                    + 1;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | BUILD SUBJECT TASKS
    |--------------------------------------------------------------------------
    */

    protected function buildSubjectTasks(
        Collection $teachings,
        Collection $sections
    ): array {

        $tasks = [];

        /*
        |--------------------------------------------------------------------------
        | Existing subject counts in ONE query
        |--------------------------------------------------------------------------
        */

        $existingSchedules = Schedule::query()
            ->select(
                'section_id',
                'subject_id',
                DB::raw('COUNT(*) as total')
            )
            ->where(
                'academic_year_id',
                $this->academicYearID
            )
            ->where(
                'semester_id',
                $this->semesterID
            )
            ->where(
                'year_id',
                $this->yearID
            )
            ->where(
                'major_id',
                $this->majorID
            )
            ->groupBy(
                'section_id',
                'subject_id'
            )
            ->get();

        $existingCounts = [];

        foreach ($existingSchedules as $schedule) {

            $key =
                $schedule->section_id
                . '_'
                . $schedule->subject_id;

            $existingCounts[$key] =
                (int) $schedule->total;
        }

        foreach ($sections as $section) {

            $sectionID =
                (int) $section->id;

            $sectionTeachings =
                $teachings
                    ->where(
                        'section_id',
                        $sectionID
                    )
                    ->filter(
                        function ($teaching) {

                            return
                                $teaching->subject !== null
                                &&
                                $teaching->teacher_id !== null;
                        }
                    )
                    ->unique('subject_id')
                    ->values();

            foreach (
                $sectionTeachings
                as $teaching
            ) {

                $subject =
                    $teaching->subject;

                if (!$subject) {
                    continue;
                }

                $required =
                    (int) (
                        $subject->time_number
                        ?? 3
                    );

                /*
                |--------------------------------------------------------------------------
                | Allow 1-5 periods
                |--------------------------------------------------------------------------
                */

                $required =
                    max(
                        1,
                        min(
                            5,
                            $required
                        )
                    );

                $key =
                    $sectionID
                    . '_'
                    . $teaching->subject_id;

                $existingCount =
                    $existingCounts[$key]
                    ?? 0;

                $remaining =
                    max(
                        0,
                        $required - $existingCount
                    );

                if ($remaining <= 0) {
                    continue;
                }

                $teacherID =
                    (int) $teaching->teacher_id;

                $tasks[] = [

                    'section_id' =>
                        $sectionID,

                    'subject_id' =>
                        (int) $teaching->subject_id,

                    'teacher_id' =>
                        $teacherID,

                    'required' =>
                        $required,

                    'existing' =>
                        $existingCount,

                    'remaining' =>
                        $remaining,

                    'teacher_weekly' =>
                        $this->countTeacherWeekly(
                            $teacherID
                        ),

                    'subject_name' =>
                        $subject->long_name
                        ?? $subject->name
                        ?? 'Unknown Subject',
                ];
            }
        }

        return $tasks;
    }

    /*
    |--------------------------------------------------------------------------
    | CAPACITY VALIDATION
    |--------------------------------------------------------------------------
    */

    protected function validateCapacity(
        array $tasks,
        Collection $days,
        Collection $times
    ): void {

        $maxPeriods =
            $days->count()
            *
            $times->count();

        $sectionRequired = [];

        foreach ($tasks as $task) {

            $sectionID =
                (int) $task['section_id'];

            $sectionRequired[$sectionID] =
                ($sectionRequired[$sectionID] ?? 0)
                +
                (int) $task['remaining'];
        }

        foreach (
            $sectionRequired
            as $sectionID => $required
        ) {

            if ($required > $maxPeriods) {

                throw new RuntimeException(
                    'Section '
                    . $sectionID
                    . ' requires '
                    . $required
                    . ' periods but only '
                    . $maxPeriods
                    . ' usable slots are available.'
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SOLVER
    |--------------------------------------------------------------------------
    */

    protected function solve(
        int $index
    ): bool {

        if (
            $this->backtracks
            >=
            $this->maxBacktracks
        ) {

            return false;
        }

        if (
            $index
            >=
            count($this->subjects)
        ) {

            return true;
        }

        $task =
            $this->subjects[$index];

        $assigned =
            $this->countGeneratedTask(
                $task
            );

        if (
            $assigned
            >=
            $task['remaining']
        ) {

            return $this->solve(
                $index + 1
            );
        }

        $candidates =
            $this->getCandidateSlots(
                $task
            );

        if (empty($candidates)) {
            return false;
        }

        usort(
            $candidates,
            function ($a, $b) use ($task) {

                $scoreA =
                    $this->calculateScore(
                        $task,
                        $a
                    );

                $scoreB =
                    $this->calculateScore(
                        $task,
                        $b
                    );

                return
                    $scoreB
                    <=>
                    $scoreA;
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Limit candidate attempts
        |--------------------------------------------------------------------------
        */

        $candidates =
            array_slice(
                $candidates,
                0,
                12
            );

        foreach ($candidates as $candidate) {

            if (
                !$this->canAssign(
                    $task,
                    $candidate
                )
            ) {
                continue;
            }

            $item =
                $this->assign(
                    $task,
                    $candidate
                );

            if (
                $this->solve(
                    $index
                )
            ) {

                return true;
            }

            $this->unassign(
                $task,
                $item
            );

            $this->backtracks++;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | CANDIDATE SLOTS
    |--------------------------------------------------------------------------
    */

    protected function getCandidateSlots(
        array $task
    ): array {

        $candidates = [];

        foreach ($this->slots as $slot) {

            if (
                $this->canAssign(
                    $task,
                    $slot
                )
            ) {

                $candidates[] =
                    $slot;
            }
        }

        return $candidates;
    }

    /*
    |--------------------------------------------------------------------------
    | CAN ASSIGN
    |--------------------------------------------------------------------------
    */

    protected function canAssign(
        array $task,
        array $slot
    ): bool {

        $dayID =
            (int) $slot['day_id'];

        $timeID =
            (int) $slot['time_id'];

        $slotKey =
            $dayID
            . '_'
            . $timeID;

        $teacherID =
            (int) $task['teacher_id'];

        $sectionID =
            (int) $task['section_id'];

        $classKey =
            $this->yearID
            . '_'
            . $this->majorID
            . '_'
            . $sectionID;

        /*
        |--------------------------------------------------------------------------
        | Teacher conflict
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $this->occupancy['teacher']
                [$teacherID]
                [$slotKey]
            )
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Teacher daily limit
        |--------------------------------------------------------------------------
        */

        if (
            $this->countTeacherDaily(
                $teacherID,
                $dayID
            )
            >=
            $this->maxTeacherDaily
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Teacher weekly limit
        |--------------------------------------------------------------------------
        */

        if (
            $this->countTeacherWeekly(
                $teacherID
            )
            >=
            $this->maxTeacherWeekly
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Section conflict
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $this->occupancy['class']
                [$classKey]
                [$slotKey]
            )
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Class daily limit
        |--------------------------------------------------------------------------
        */

        if (
            $this->countClassDaily(
                $classKey,
                $dayID
            )
            >=
            $this->maxClassDaily
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Subject daily limit
        |--------------------------------------------------------------------------
        */

        if (
            $this->countSubjectDaily(
                $task,
                $dayID
            )
            >=
            $this->maxSubjectDaily
        ) {

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Room availability
        |--------------------------------------------------------------------------
        */

        if (
            !$this->findAvailableRoom(
                $slot
            )
        ) {

            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND AVAILABLE ROOM
    |--------------------------------------------------------------------------
    */

    protected function findAvailableRoom(
        array $slot
    ): ?Room {

        $slotKey =
            $slot['day_id']
            . '_'
            . $slot['time_id'];

        foreach ($this->rooms as $room) {

            $roomID =
                (int) $room->id;

            if (
                isset(
                    $this->occupancy['room']
                    [$roomID]
                    [$slotKey]
                )
            ) {
                continue;
            }

            return $room;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | CALCULATE SCORE
    |--------------------------------------------------------------------------
    */

    protected function calculateScore(
        array $task,
        array $slot
    ): int {

        $score = 0;

        $dayID =
            (int) $slot['day_id'];

        $timeID =
            (int) $slot['time_id'];

        $period =
            $slot['period'];

        $classKey =
            $this->yearID
            . '_'
            . $this->majorID
            . '_'
            . $task['section_id'];

        /*
        |--------------------------------------------------------------------------
        | CLASS DAILY BALANCE
        |--------------------------------------------------------------------------
        */

        $classDaily =
            $this->countClassDaily(
                $classKey,
                $dayID
            );

        $score +=
            (5 - $classDaily)
            * 25;

        /*
        |--------------------------------------------------------------------------
        | CLASS MORNING / AFTERNOON BALANCE
        |--------------------------------------------------------------------------
        */

        $classMorning =
            $this->countClassMorning(
                $classKey
            );

        $classAfternoon =
            $this->countClassAfternoon(
                $classKey
            );

        if ($period === 'morning') {

            if (
                $classMorning
                <=
                $classAfternoon
            ) {

                $score += 40;

            } else {

                $score -= 25;
            }

        } else {

            if (
                $classAfternoon
                <=
                $classMorning
            ) {

                $score += 40;

            } else {

                $score -= 25;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUBJECT MORNING / AFTERNOON BALANCE
        |--------------------------------------------------------------------------
        */

        $subjectMorning =
            $this->countSubjectPeriod(
                $task,
                'morning'
            );

        $subjectAfternoon =
            $this->countSubjectPeriod(
                $task,
                'afternoon'
            );

        if ($period === 'morning') {

            if (
                $subjectMorning
                <=
                $subjectAfternoon
            ) {

                $score += 60;

            } else {

                $score -= 40;
            }

        } else {

            if (
                $subjectAfternoon
                <=
                $subjectMorning
            ) {

                $score += 60;

            } else {

                $score -= 40;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUBJECT DAY SPACING
        |--------------------------------------------------------------------------
        */

        if (
            $this->countSubjectDaily(
                $task,
                $dayID
            )
            ===
            0
        ) {

            $score += 30;
        }

        /*
        |--------------------------------------------------------------------------
        | TEACHER DAILY BALANCE
        |--------------------------------------------------------------------------
        */

        $teacherDaily =
            $this->countTeacherDaily(
                (int) $task['teacher_id'],
                $dayID
            );

        $score +=
            (4 - $teacherDaily)
            * 10;

        /*
        |--------------------------------------------------------------------------
        | SMALL RANDOM VARIATION
        |--------------------------------------------------------------------------
        */

        $score +=
            random_int(
                0,
                5
            );

        return $score;
    }

    /*
    |--------------------------------------------------------------------------
    | ASSIGN
    |--------------------------------------------------------------------------
    */

    protected function assign(
        array $task,
        array $slot
    ): array {

        $room =
            $this->findAvailableRoom(
                $slot
            );

        if (!$room) {

            throw new RuntimeException(
                'No room available.'
            );
        }

        $dayID =
            (int) $slot['day_id'];

        $timeID =
            (int) $slot['time_id'];

        $roomID =
            (int) $room->id;

        $teacherID =
            (int) $task['teacher_id'];

        $sectionID =
            (int) $task['section_id'];

        $slotKey =
            $dayID
            . '_'
            . $timeID;

        $classKey =
            $this->yearID
            . '_'
            . $this->majorID
            . '_'
            . $sectionID;

        $item = [

            'academic_year_id' =>
                $this->academicYearID,

            'semester_id' =>
                $this->semesterID,

            'year_id' =>
                $this->yearID,

            'major_id' =>
                $this->majorID,

            'section_id' =>
                $sectionID,

            'room_id' =>
                $roomID,

            'subject_id' =>
                (int) $task['subject_id'],

            'teacher_id' =>
                $teacherID,

            'day_id' =>
                $dayID,

            'time_id' =>
                $timeID,

            'period' =>
                $slot['period'],

            'is_shifted' =>
                false,
        ];

        $this->generated[] =
            $item;

        $this->occupancy['teacher']
            [$teacherID]
            [$slotKey] = true;

        $this->occupancy['room']
            [$roomID]
            [$slotKey] = true;

        $this->occupancy['class']
            [$classKey]
            [$slotKey] = true;

        return $item;
    }

    /*
    |--------------------------------------------------------------------------
    | UNASSIGN
    |--------------------------------------------------------------------------
    */

    protected function unassign(
        array $task,
        array $item
    ): void {

        $dayID =
            (int) $item['day_id'];

        $timeID =
            (int) $item['time_id'];

        $teacherID =
            (int) $item['teacher_id'];

        $roomID =
            (int) $item['room_id'];

        $sectionID =
            (int) $item['section_id'];

        $slotKey =
            $dayID
            . '_'
            . $timeID;

        $classKey =
            $this->yearID
            . '_'
            . $this->majorID
            . '_'
            . $sectionID;

        unset(
            $this->occupancy['teacher']
            [$teacherID]
            [$slotKey]
        );

        unset(
            $this->occupancy['room']
            [$roomID]
            [$slotKey]
        );

        unset(
            $this->occupancy['class']
            [$classKey]
            [$slotKey]
        );

        array_pop(
            $this->generated
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT GENERATED TASK
    |--------------------------------------------------------------------------
    */

    protected function countGeneratedTask(
        array $task
    ): int {

        return count(
            array_filter(
                $this->generated,
                function ($item) use ($task) {

                    return
                        (int) $item['subject_id']
                        ===
                        (int) $task['subject_id']

                        &&

                        (int) $item['section_id']
                        ===
                        (int) $task['section_id'];
                }
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT SUBJECT PERIOD
    |--------------------------------------------------------------------------
    */

    protected function countSubjectPeriod(
        array $task,
        string $period
    ): int {

        $count = 0;

        foreach (
            $this->generated
            as $item
        ) {

            if (
                (int) $item['subject_id']
                !==
                (int) $task['subject_id']
            ) {
                continue;
            }

            if (
                (int) $item['section_id']
                !==
                (int) $task['section_id']
            ) {
                continue;
            }

            if (
                ($item['period'] ?? '')
                ===
                $period
            ) {

                $count++;
            }
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT TEACHER DAILY
    |--------------------------------------------------------------------------
    */

    protected function countTeacherDaily(
        int $teacherID,
        int $dayID
    ): int {

        $count = 0;

        foreach (
            $this->occupancy['teacher']
            [$teacherID]
            ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );

            if (
                (int) ($parts[0] ?? 0)
                ===
                $dayID
            ) {

                $count++;
            }
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT TEACHER WEEKLY
    |--------------------------------------------------------------------------
    */

    protected function countTeacherWeekly(
        int $teacherID
    ): int {

        return count(
            $this->occupancy['teacher']
            [$teacherID]
            ?? []
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT CLASS DAILY
    |--------------------------------------------------------------------------
    */

    protected function countClassDaily(
        string $classKey,
        int $dayID
    ): int {

        $count = 0;

        foreach (
            $this->occupancy['class']
            [$classKey]
            ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );

            if (
                (int) ($parts[0] ?? 0)
                ===
                $dayID
            ) {

                $count++;
            }
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT SUBJECT DAILY
    |--------------------------------------------------------------------------
    */

    protected function countSubjectDaily(
        array $task,
        int $dayID
    ): int {

        $count = 0;

        foreach (
            $this->generated
            as $item
        ) {

            if (
                (int) $item['subject_id']
                ===
                (int) $task['subject_id']

                &&

                (int) $item['section_id']
                ===
                (int) $task['section_id']

                &&

                (int) $item['day_id']
                ===
                $dayID
            ) {

                $count++;
            }
        }

        $key =
            $task['section_id']
            . '_'
            . $task['subject_id']
            . '_'
            . $dayID;

        $count +=
            $this->existingSubjectDaily[$key]
            ?? 0;

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT CLASS MORNING
    |--------------------------------------------------------------------------
    */

    protected function countClassMorning(
        string $classKey
    ): int {

        $count = 0;

        foreach (
            $this->occupancy['class']
            [$classKey]
            ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );

            $timeID =
                (int) ($parts[1] ?? 0);

            if (
                in_array(
                    $timeID,
                    $this->morningTimeIDs,
                    true
                )
            ) {

                $count++;
            }
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT CLASS AFTERNOON
    |--------------------------------------------------------------------------
    */

    protected function countClassAfternoon(
        string $classKey
    ): int {

        $count = 0;

        foreach (
            $this->occupancy['class']
            [$classKey]
            ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );

            $timeID =
                (int) ($parts[1] ?? 0);

            if (
                in_array(
                    $timeID,
                    $this->afternoonTimeIDs,
                    true
                )
            ) {

                $count++;
            }
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | FAILURE DETAILS
    |--------------------------------------------------------------------------
    */

    protected function buildFailureDetails(): array
    {
        $details = [];

        foreach (
            $this->subjects
            as $task
        ) {

            $assigned =
                $this->countGeneratedTask(
                    $task
                );

            if (
                $assigned
                <
                $task['remaining']
            ) {

                $missing =
                    $task['remaining']
                    -
                    $assigned;

                $details[] =
                    'Section '
                    . $task['section_id']
                    . ' - '
                    . $task['subject_name']
                    . ': Required '
                    . $task['remaining']
                    . ', Assigned '
                    . $assigned
                    . ', Missing '
                    . $missing;
            }
        }

        if (empty($details)) {

            $details[] =
                'No valid combination of slots, teachers and rooms was found.';
        }

        return $details;
    }
}
