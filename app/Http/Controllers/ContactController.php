<?php

namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Contact;
use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Semesters;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\Time;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONTACT LIST
    |--------------------------------------------------------------------------
    */

    public function contactList(Request $request)
    {
        $query = Contact::with([
            'teacher.user',
            'user',
        ]);

        if ($request->filled('searchKey')) {

            $search = trim($request->searchKey);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('teacher.user', function ($q) use ($search) {
                        $q->where('phone', 'like', "%{$search}%");
                    });
            });
        }

        $contacts = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'admin.contact.list',
            compact('contacts')
        );
    }


    //contact delete
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        Alert::success(
            'Success',
            'Contact message deleted successfully!'
        );

        return back();
    }


    //contact accept
    public function accept($id)
    {
        Contact::findOrFail($id)->update([
            'status' => 'accepted',
        ]);

        return back()->with(
            'success',
            'Contact accepted successfully!'
        );
    }


    //contact reject
    public function reject($id)
    {
        Contact::findOrFail($id)->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Contact rejected successfully!'
        );
    }


    //contact show
    public function show($id)
    {
        $contact = Contact::with([
            'teacher.user',
            'user',
        ])->findOrFail($id);

        return view(
            'admin.contact.detail',
            compact('contact')
        );
    }


    //contact store
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'department' => 'nullable|string|max:255',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        $user = auth()->user();

        $teacher = Teacher::where(
            'user_id',
            $user->id
        )->first();

        Contact::create([
            'user_id'     => $user->id,
            'teacher_id'  => $teacher?->id,
            'name'        => $request->name,
            'email'       => $request->email,
            'department'  => $request->department,
            'subject'     => $request->subject,
            'message'     => $request->message,
        ]);

        return back()->with(
            'success',
            'Your message has been sent successfully!'
        );
    }

    //notification

    // public function userNotifications()
    // {
    //     $userId = auth()->id();
    
    //     // For read message
    //     Contact::where('user_id', $userId)
    //            ->where('status', 'success')
    //            ->where('is_user_read', false)
    //            ->update(['is_user_read' => true]);

    //     $notifications = Contact::where('user_id', $userId)->latest()->get();

    //     return view('user.component.notification', compact('notifications'));
    // }


    //contact read
    public function read($id)
    {
        Contact::findOrFail($id)->update([
            'status' => 'read',
        ]);

        return redirect()->route(
            'contact.list'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE PAGE
    |--------------------------------------------------------------------------
    */

    public function autoGenerate()
    {
        $academicYears = AcademicYears::all();
        $semesters     = Semesters::all();
        $years         = Year::all();
        $majors        = Major::all();
        $sections      = Sections::all();
        $rooms         = Room::all();

        return view(
            'admin.schedule.autoGenerate',
            compact(
                'academicYears',
                'semesters',
                'years',
                'majors',
                'sections',
                'rooms'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE AUTO SCHEDULE
    |--------------------------------------------------------------------------
    |
    | IMPORTANT RULE
    |
    | Subject time_number is NOT used here.
    |
    | One subject for one section:
    |
    |       3 times / week
    |       1 period each time
    |
    | Therefore:
    |
    |       required = 3
    |
    |--------------------------------------------------------------------------
    */

    public function createSchedule(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'academicYearID' => 'required|integer',
            'semesterID'     => 'required|integer',
            'yearID'         => 'required|integer',
            'majorID'        => 'required|integer',
            'sectionID'      => 'required|integer',
            'roomID'         => 'required|integer',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. IDS
        |--------------------------------------------------------------------------
        */

        $academicYearID = (int) $request->academicYearID;
        $semesterID     = (int) $request->semesterID;
        $yearID         = (int) $request->yearID;
        $majorID        = (int) $request->majorID;
        $sectionID      = (int) $request->sectionID;
        $selectedRoomID = (int) $request->roomID;


        /*
        |--------------------------------------------------------------------------
        | 3. SELECTED ROOM
        |--------------------------------------------------------------------------
        */

        $selectedRoom = Room::find($selectedRoomID);

        if (!$selectedRoom) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        'Selected room does not exist.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 4. DAYS
        |--------------------------------------------------------------------------
        */

        $days = Day::orderBy('id')->get();

        if ($days->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        'No days found in database.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 5. TIMES
        |
        | Lunch break excluded.
        |--------------------------------------------------------------------------
        */

        $times = Time::where(
            'name',
            '!=',
            '12:00-01:00'
        )
        ->orderBy('id')
        ->get();

        if ($times->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        'No usable time slots found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 6. GET TEACHINGS
        |--------------------------------------------------------------------------
        */

        $teachings = Teaching::where(
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
        ->where(
            'section_id',
            $sectionID
        )
        ->with([
            'subject',
        ])
        ->get();


        if ($teachings->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        'No teaching data found for this class.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 7. REMOVE DUPLICATE SUBJECTS
        |--------------------------------------------------------------------------
        |
        | If Teaching table contains the same subject more than once,
        | we still generate only ONE subject for this section.
        |
        |--------------------------------------------------------------------------
        */

        $uniqueTeachings = $teachings
            ->filter(function ($teaching) {

                return $teaching->subject !== null;
            })
            ->unique('subject_id')
            ->values();


        if ($uniqueTeachings->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        'No valid subjects found for this class.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 8. ROOMS
        |--------------------------------------------------------------------------
        |
        | Selected room gets first priority.
        |
        |--------------------------------------------------------------------------
        */

        $rooms = Room::query()
            ->where(function ($query) use (
                $yearID,
                $majorID,
                $selectedRoomID
            ) {

                $query
                    ->where(function ($q) use (
                        $yearID,
                        $majorID
                    ) {

                        $q->where(
                            'year_id',
                            $yearID
                        )
                        ->where(
                            'major_id',
                            $majorID
                        );
                    })
                    ->orWhere(
                        'id',
                        $selectedRoomID
                    );
            })
            ->orderByRaw(
                'CASE WHEN id = ? THEN 0 ELSE 1 END',
                [$selectedRoomID]
            )
            ->orderBy('id')
            ->get();


        if ($rooms->isEmpty()) {

            $rooms = collect([
                $selectedRoom,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 9. TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 10. DELETE OLD AUTO GENERATED RECORDS
            |--------------------------------------------------------------------------
            |
            | Shifted schedules are preserved.
            |
            |--------------------------------------------------------------------------
            */

            Schedule::where(
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
            ->where(
                'section_id',
                $sectionID
            )
            ->where(
                'is_shifted',
                false
            )
            ->delete();


            /*
            |--------------------------------------------------------------------------
            | 11. EXISTING SCHEDULES
            |--------------------------------------------------------------------------
            */

            $existingSchedules = Schedule::where(
                'academic_year_id',
                $academicYearID
            )
            ->where(
                'semester_id',
                $semesterID
            )
            ->get();


            /*
            |--------------------------------------------------------------------------
            | 12. OCCUPANCY
            |--------------------------------------------------------------------------
            */

            $occupancy = [
                'teacher'       => [],
                'room'          => [],
                'class'         => [],
                'teacher_room'  => [],
            ];


            foreach ($existingSchedules as $schedule) {

                if (
                    !$schedule->day_id ||
                    !$schedule->time_id
                ) {
                    continue;
                }


                $dayID  = (int) $schedule->day_id;
                $timeID = (int) $schedule->time_id;

                $slotKey = $dayID . '_' . $timeID;


                /*
                |--------------------------------------------------------------------------
                | TEACHER + SLOT
                |--------------------------------------------------------------------------
                */

                if ($schedule->teacher_id) {

                    $teacherID =
                        (int) $schedule->teacher_id;

                    $occupancy['teacher']
                        [$teacherID]
                        [$slotKey] = true;
                }


                /*
                |--------------------------------------------------------------------------
                | ROOM + SLOT
                |--------------------------------------------------------------------------
                */

                if ($schedule->room_id) {

                    $roomID =
                        (int) $schedule->room_id;

                    $occupancy['room']
                        [$roomID]
                        [$slotKey] = true;
                }


                /*
                |--------------------------------------------------------------------------
                | CLASS + SLOT
                |--------------------------------------------------------------------------
                */

                $classKey =
                    $schedule->year_id
                    . '_'
                    . $schedule->major_id
                    . '_'
                    . $schedule->section_id;


                $occupancy['class']
                    [$classKey]
                    [$slotKey] = true;


                /*
                |--------------------------------------------------------------------------
                | TEACHER + ROOM + DAY
                |--------------------------------------------------------------------------
                |
                | RULE:
                |
                | One teacher cannot teach the SAME ROOM
                | more than once on the same day.
                |
                |--------------------------------------------------------------------------
                */

                if (
                    $schedule->teacher_id &&
                    $schedule->room_id
                ) {

                    $teacherRoomDayKey =
                        $schedule->teacher_id
                        . '_'
                        . $schedule->room_id
                        . '_'
                        . $dayID;

                    $occupancy['teacher_room']
                        [$teacherRoomDayKey] = true;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 13. PREPARE SUBJECTS
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | DO NOT USE subject->time_number
            |
            | Every subject:
            |
            |       3 periods / week / section
            |
            |--------------------------------------------------------------------------
            */

            $subjects = [];


            foreach ($uniqueTeachings as $teaching) {

                $subject = $teaching->subject;

                if (!$subject) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | REQUIRED PERIODS
                |--------------------------------------------------------------------------
                |
                | FIXED = 3
                |
                |--------------------------------------------------------------------------
                */

                $required = 3;


                /*
                |--------------------------------------------------------------------------
                | EXISTING SHIFTED PERIODS
                |--------------------------------------------------------------------------
                */

                $existingCount = $existingSchedules
                    ->where(
                        'subject_id',
                        $teaching->subject_id
                    )
                    ->where(
                        'year_id',
                        $yearID
                    )
                    ->where(
                        'major_id',
                        $majorID
                    )
                    ->where(
                        'section_id',
                        $sectionID
                    )
                    ->count();


                /*
                |--------------------------------------------------------------------------
                | REMAINING
                |--------------------------------------------------------------------------
                */

                $remaining = max(
                    0,
                    $required - $existingCount
                );


                if ($remaining <= 0) {
                    continue;
                }


                $subjects[] = [

                    'teaching' =>
                        $teaching,

                    'subject_id' =>
                        (int) $teaching->subject_id,

                    'teacher_id' =>
                        (int) $teaching->teacher_id,

                    'required' =>
                        $required,

                    'existing' =>
                        $existingCount,

                    'remaining' =>
                        $remaining,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | 14. TOTAL REQUIRED
            |--------------------------------------------------------------------------
            */

            $totalRequired = collect($subjects)
                ->sum('remaining');


            /*
            |--------------------------------------------------------------------------
            | 15. WEEKLY CLASS CAPACITY
            |--------------------------------------------------------------------------
            */

            $maxClassPeriods =
                $days->count()
                * $times->count();


            /*
            |--------------------------------------------------------------------------
            | CAPACITY CHECK
            |--------------------------------------------------------------------------
            */

            if ($totalRequired > $maxClassPeriods) {

                $subjectDetails = [];

                foreach ($subjects as $subjectData) {

                    $subjectDetails[] =
                        $subjectData['teaching']
                            ->subject
                            ->long_name
                        . ' = '
                        . $subjectData['required']
                        . ' period(s)';
                }


                throw new \Exception(

                    'This section requires '
                    . $totalRequired
                    . ' periods, but only '
                    . $maxClassPeriods
                    . ' usable periods are available ('
                    . $days->count()
                    . ' days × '
                    . $times->count()
                    . ' periods). '
                    . 'Subjects: '
                    . implode(
                        ', ',
                        $subjectDetails
                    )
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 16. SORT SUBJECTS
            |--------------------------------------------------------------------------
            */

            usort(
                $subjects,
                function ($a, $b) {

                    /*
                    |--------------------------------------------------------------
                    | Subjects with fewer available teachers/constraints
                    | can be placed first.
                    |--------------------------------------------------------------
                    */

                    return
                        $b['remaining']
                        <=>
                        $a['remaining'];
                }
            );


            /*
            |--------------------------------------------------------------------------
            | 17. BUILD SLOTS
            |--------------------------------------------------------------------------
            */

            $slots = [];


            foreach ($days as $day) {

                foreach ($times as $time) {

                    $slots[] = [

                        'day_id' =>
                            (int) $day->id,

                        'time_id' =>
                            (int) $time->id,
                    ];
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 18. GENERATE
            |--------------------------------------------------------------------------
            */

            $generated = [];


            /*
            |--------------------------------------------------------------------------
            | BACKTRACKING STATE
            |--------------------------------------------------------------------------
            */

            $state = [

                'nodes' =>
                    0,

                /*
                | 30,000 is enough for this type of timetable
                | and prevents 60-second PHP timeout.
                */
                'maxNodes' =>
                    30000,
            ];


            $success = $this->generateTimetable(
                $subjects,
                0,
                $slots,
                $rooms,
                $occupancy,
                $generated,
                $yearID,
                $majorID,
                $sectionID,
                $state,
                $academicYearID,
                $semesterID
            );


            /*
            |--------------------------------------------------------------------------
            | 19. GENERATION FAILED
            |--------------------------------------------------------------------------
            */

            if (!$success) {

                $details = [];


                foreach ($subjects as $subjectData) {

                    $assigned =
                        $this->countGeneratedSubject(
                            $generated,
                            $subjectData['subject_id']
                        );


                    $totalAssigned =
                        $subjectData['existing']
                        + $assigned;


                    if (
                        $totalAssigned
                        <
                        $subjectData['required']
                    ) {

                        $details[] =
                            $subjectData['teaching']
                                ->subject
                                ->long_name
                            . ' => Required: '
                            . $subjectData['required']
                            . ', Assigned: '
                            . $totalAssigned
                            . ', Missing: '
                            . (
                                $subjectData['required']
                                -
                                $totalAssigned
                            );
                    }
                }


                $message =
                    'Unable to generate complete timetable.';


                if (!empty($details)) {

                    $message .=
                        ' '
                        .
                        implode(
                            ' | ',
                            $details
                        );
                }


                throw new \Exception(
                    $message
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 20. SAVE GENERATED SCHEDULE
            |--------------------------------------------------------------------------
            */

            foreach ($generated as $item) {

                Schedule::create([

                    'academic_year_id' =>
                        $academicYearID,

                    'semester_id' =>
                        $semesterID,

                    'year_id' =>
                        $yearID,

                    'major_id' =>
                        $majorID,

                    'section_id' =>
                        $sectionID,

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


            /*
            |--------------------------------------------------------------------------
            | 21. COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'generate' =>
                        $e->getMessage(),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 22. RESULT
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'schedule.show',
            [
                'academicYearID' =>
                    $academicYearID,

                'semesterID' =>
                    $semesterID,

                'yearID' =>
                    $yearID,

                'majorID' =>
                    $majorID,

                'sectionID' =>
                    $sectionID,
            ]
        )->with(
            'success',
            'Schedule generated successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE TIMETABLE
    |--------------------------------------------------------------------------
    */

    private function generateTimetable(
        &$subjects,
        $index,
        $slots,
        $rooms,
        &$occupancy,
        &$generated,
        $yearID,
        $majorID,
        $sectionID,
        &$state,
        $academicYearID,
        $semesterID
    ) {

        /*
        |--------------------------------------------------------------------------
        | NODE LIMIT
        |--------------------------------------------------------------------------
        */

        $state['nodes']++;

        if (
            $state['nodes']
            >
            $state['maxNodes']
        ) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | ALL SUBJECTS COMPLETE
        |--------------------------------------------------------------------------
        */

        if (
            $index
            >=
            count($subjects)
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT SUBJECT
        |--------------------------------------------------------------------------
        */

        $subjectData =
            &$subjects[$index];


        $subjectID =
            $subjectData['subject_id'];


        $teacherID =
            $subjectData['teacher_id'];


        $remaining =
            $subjectData['remaining'];


        $classKey =
            $yearID
            . '_'
            . $majorID
            . '_'
            . $sectionID;


        /*
        |--------------------------------------------------------------------------
        | SUBJECT DAY COUNT
        |--------------------------------------------------------------------------
        |
        | A subject can be taught only ONCE per day.
        |
        | Because required = 3,
        | it will naturally be distributed over 3 days.
        |
        |--------------------------------------------------------------------------
        */

        $subjectDayCount = [];


        foreach ($generated as $item) {

            if (
                (int) $item['subject_id']
                ===
                (int) $subjectID
            ) {

                $dayID =
                    (int) $item['day_id'];

                $subjectDayCount[$dayID] =
                    ($subjectDayCount[$dayID] ?? 0)
                    + 1;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER SLOTS
        |--------------------------------------------------------------------------
        |
        | Prefer days with fewer class periods.
        |
        |--------------------------------------------------------------------------
        */

        $orderedSlots = $slots;


        usort(
            $orderedSlots,
            function ($a, $b)
            use (
                &$occupancy,
                $classKey
            ) {

                $aCount =
                    $this->countClassDayPeriods(
                        $occupancy,
                        $classKey,
                        $a['day_id']
                    );


                $bCount =
                    $this->countClassDayPeriods(
                        $occupancy,
                        $classKey,
                        $b['day_id']
                    );


                return
                    $aCount
                    <=>
                    $bCount;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | TRY SLOTS
        |--------------------------------------------------------------------------
        */

        foreach ($orderedSlots as $slot) {

            $state['nodes']++;


            if (
                $state['nodes']
                >
                $state['maxNodes']
            ) {
                return false;
            }


            $dayID =
                (int) $slot['day_id'];


            $timeID =
                (int) $slot['time_id'];


            $slotKey =
                $dayID
                . '_'
                . $timeID;


            /*
            |--------------------------------------------------------------------------
            | SUBJECT DAILY MAX = 1
            |--------------------------------------------------------------------------
            */

            if (
                ($subjectDayCount[$dayID] ?? 0)
                >= 1
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CLASS CONFLICT
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $occupancy['class']
                    [$classKey]
                    [$slotKey]
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CLASS DAILY MAX = 4
            |--------------------------------------------------------------------------
            */

            $classDaily =
                $this->countClassDayPeriods(
                    $occupancy,
                    $classKey,
                    $dayID
                );


            if (
                $classDaily
                >=
                4
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER CONFLICT
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $occupancy['teacher']
                    [$teacherID]
                    [$slotKey]
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER DAILY MAX = 4
            |--------------------------------------------------------------------------
            */

            $teacherDaily =
                $this->countTeacherDayPeriods(
                    $occupancy,
                    $teacherID,
                    $dayID
                );


            if (
                $teacherDaily
                >=
                4
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER WEEKLY MAX = 20
            |--------------------------------------------------------------------------
            */

            $teacherWeekly =
                $this->countTeacherWeekPeriods(
                    $occupancy,
                    $teacherID
                );


            if (
                $teacherWeekly
                >=
                20
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | FIND ROOM
            |--------------------------------------------------------------------------
            */

            $availableRoom = null;


            foreach ($rooms as $room) {

                $roomID =
                    (int) $room->id;


                /*
                |--------------------------------------------------------------
                | ROOM + SLOT
                |--------------------------------------------------------------
                */

                if (
                    isset(
                        $occupancy['room']
                        [$roomID]
                        [$slotKey]
                    )
                ) {
                    continue;
                }


                /*
                |--------------------------------------------------------------
                | TEACHER + ROOM + DAY
                |--------------------------------------------------------------
                |
                | Same teacher cannot teach the same room
                | more than once in one day.
                |
                |--------------------------------------------------------------
                */

                $teacherRoomDayKey =
                    $teacherID
                    . '_'
                    . $roomID
                    . '_'
                    . $dayID;


                if (
                    isset(
                        $occupancy['teacher_room']
                        [$teacherRoomDayKey]
                    )
                ) {
                    continue;
                }


                $availableRoom =
                    $room;

                break;
            }


            if (!$availableRoom) {
                continue;
            }


            $roomID =
                (int) $availableRoom->id;


            /*
            |--------------------------------------------------------------------------
            | ADD TEMPORARY SCHEDULE
            |--------------------------------------------------------------------------
            */

            $generated[] = [

                'academic_year_id' =>
                    $academicYearID,

                'semester_id' =>
                    $semesterID,

                'year_id' =>
                    $yearID,

                'major_id' =>
                    $majorID,

                'section_id' =>
                    $sectionID,

                'room_id' =>
                    $roomID,

                'subject_id' =>
                    $subjectID,

                'teacher_id' =>
                    $teacherID,

                'day_id' =>
                    $dayID,

                'time_id' =>
                    $timeID,

                'is_shifted' =>
                    false,
            ];


            /*
            |--------------------------------------------------------------------------
            | UPDATE OCCUPANCY
            |--------------------------------------------------------------------------
            */

            $occupancy['teacher']
                [$teacherID]
                [$slotKey] = true;


            $occupancy['room']
                [$roomID]
                [$slotKey] = true;


            $occupancy['class']
                [$classKey]
                [$slotKey] = true;


            /*
            |--------------------------------------------------------------------------
            | TEACHER + ROOM + DAY
            |--------------------------------------------------------------------------
            */

            $teacherRoomDayKey =
                $teacherID
                . '_'
                . $roomID
                . '_'
                . $dayID;


            $occupancy['teacher_room']
                [$teacherRoomDayKey] = true;


            /*
            |--------------------------------------------------------------------------
            | CHECK ASSIGNED
            |--------------------------------------------------------------------------
            */

            $assignedNow =
                $this->countGeneratedSubject(
                    $generated,
                    $subjectID
                );


            /*
            |--------------------------------------------------------------------------
            | SUBJECT COMPLETE
            |--------------------------------------------------------------------------
            */

            if (
                $assignedNow
                >=
                $remaining
            ) {

                $success =
                    $this->generateTimetable(
                        $subjects,
                        $index + 1,
                        $slots,
                        $rooms,
                        $occupancy,
                        $generated,
                        $yearID,
                        $majorID,
                        $sectionID,
                        $state,
                        $academicYearID,
                        $semesterID
                    );


                if ($success) {
                    return true;
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | CONTINUE SAME SUBJECT
                |--------------------------------------------------------------------------
                */

                $success =
                    $this->generateTimetablePeriods(
                        $subjects,
                        $index,
                        $slots,
                        $rooms,
                        $occupancy,
                        $generated,
                        $yearID,
                        $majorID,
                        $sectionID,
                        $state,
                        $academicYearID,
                        $semesterID
                    );


                if ($success) {
                    return true;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | BACKTRACK
            |--------------------------------------------------------------------------
            */

            array_pop($generated);


            unset(
                $occupancy['teacher']
                    [$teacherID]
                    [$slotKey]
            );


            unset(
                $occupancy['room']
                    [$roomID]
                    [$slotKey]
            );


            unset(
                $occupancy['class']
                    [$classKey]
                    [$slotKey]
            );


            unset(
                $occupancy['teacher_room']
                    [$teacherRoomDayKey]
            );
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE REMAINING PERIODS
    |--------------------------------------------------------------------------
    */

    private function generateTimetablePeriods(
        &$subjects,
        $index,
        $slots,
        $rooms,
        &$occupancy,
        &$generated,
        $yearID,
        $majorID,
        $sectionID,
        &$state,
        $academicYearID,
        $semesterID
    ) {

        $state['nodes']++;


        if (
            $state['nodes']
            >
            $state['maxNodes']
        ) {
            return false;
        }


        $subjectData =
            &$subjects[$index];


        $subjectID =
            $subjectData['subject_id'];


        $teacherID =
            $subjectData['teacher_id'];


        $required =
            $subjectData['remaining'];


        $assigned =
            $this->countGeneratedSubject(
                $generated,
                $subjectID
            );


        /*
        |--------------------------------------------------------------------------
        | SUBJECT COMPLETE
        |--------------------------------------------------------------------------
        */

        if (
            $assigned
            >=
            $required
        ) {

            return $this->generateTimetable(
                $subjects,
                $index + 1,
                $slots,
                $rooms,
                $occupancy,
                $generated,
                $yearID,
                $majorID,
                $sectionID,
                $state,
                $academicYearID,
                $semesterID
            );
        }


        $classKey =
            $yearID
            . '_'
            . $majorID
            . '_'
            . $sectionID;


        /*
        |--------------------------------------------------------------------------
        | SUBJECT DAY COUNT
        |--------------------------------------------------------------------------
        */

        $subjectDayCount = [];


        foreach ($generated as $item) {

            if (
                (int) $item['subject_id']
                ===
                (int) $subjectID
            ) {

                $dayID =
                    (int) $item['day_id'];

                $subjectDayCount[$dayID] =
                    ($subjectDayCount[$dayID] ?? 0)
                    + 1;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TRY SLOTS
        |--------------------------------------------------------------------------
        */

        foreach ($slots as $slot) {

            $state['nodes']++;


            if (
                $state['nodes']
                >
                $state['maxNodes']
            ) {
                return false;
            }


            $dayID =
                (int) $slot['day_id'];


            $timeID =
                (int) $slot['time_id'];


            $slotKey =
                $dayID
                . '_'
                . $timeID;


            /*
            |--------------------------------------------------------------------------
            | SUBJECT DAILY MAX = 1
            |--------------------------------------------------------------------------
            */

            if (
                ($subjectDayCount[$dayID] ?? 0)
                >= 1
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CLASS CONFLICT
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $occupancy['class']
                    [$classKey]
                    [$slotKey]
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CLASS DAILY MAX = 4
            |--------------------------------------------------------------------------
            */

            if (
                $this->countClassDayPeriods(
                    $occupancy,
                    $classKey,
                    $dayID
                )
                >=
                4
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER CONFLICT
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $occupancy['teacher']
                    [$teacherID]
                    [$slotKey]
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER DAILY MAX = 4
            |--------------------------------------------------------------------------
            */

            if (
                $this->countTeacherDayPeriods(
                    $occupancy,
                    $teacherID,
                    $dayID
                )
                >=
                4
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER WEEKLY MAX = 20
            |--------------------------------------------------------------------------
            */

            if (
                $this->countTeacherWeekPeriods(
                    $occupancy,
                    $teacherID
                )
                >=
                20
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | FIND ROOM
            |--------------------------------------------------------------------------
            */

            $room = null;


            foreach ($rooms as $candidateRoom) {

                $candidateRoomID =
                    (int) $candidateRoom->id;


                /*
                |--------------------------------------------------------------
                | ROOM + SLOT
                |--------------------------------------------------------------
                */

                if (
                    isset(
                        $occupancy['room']
                        [$candidateRoomID]
                        [$slotKey]
                    )
                ) {
                    continue;
                }


                /*
                |--------------------------------------------------------------
                | TEACHER + ROOM + DAY
                |--------------------------------------------------------------
                */

                $teacherRoomDayKey =
                    $teacherID
                    . '_'
                    . $candidateRoomID
                    . '_'
                    . $dayID;


                if (
                    isset(
                        $occupancy['teacher_room']
                        [$teacherRoomDayKey]
                    )
                ) {
                    continue;
                }


                $room =
                    $candidateRoom;

                break;
            }


            if (!$room) {
                continue;
            }


            $roomID =
                (int) $room->id;


            /*
            |--------------------------------------------------------------------------
            | ADD
            |--------------------------------------------------------------------------
            */

            $generated[] = [

                'academic_year_id' =>
                    $academicYearID,

                'semester_id' =>
                    $semesterID,

                'year_id' =>
                    $yearID,

                'major_id' =>
                    $majorID,

                'section_id' =>
                    $sectionID,

                'room_id' =>
                    $roomID,

                'subject_id' =>
                    $subjectID,

                'teacher_id' =>
                    $teacherID,

                'day_id' =>
                    $dayID,

                'time_id' =>
                    $timeID,

                'is_shifted' =>
                    false,
            ];


            /*
            |--------------------------------------------------------------------------
            | UPDATE OCCUPANCY
            |--------------------------------------------------------------------------
            */

            $occupancy['teacher']
                [$teacherID]
                [$slotKey] = true;


            $occupancy['room']
                [$roomID]
                [$slotKey] = true;


            $occupancy['class']
                [$classKey]
                [$slotKey] = true;


            /*
            |--------------------------------------------------------------------------
            | TEACHER + ROOM + DAY
            |--------------------------------------------------------------------------
            */

            $teacherRoomDayKey =
                $teacherID
                . '_'
                . $roomID
                . '_'
                . $dayID;


            $occupancy['teacher_room']
                [$teacherRoomDayKey] = true;


            /*
            |--------------------------------------------------------------------------
            | RECURSION
            |--------------------------------------------------------------------------
            */

            $success =
                $this->generateTimetablePeriods(
                    $subjects,
                    $index,
                    $slots,
                    $rooms,
                    $occupancy,
                    $generated,
                    $yearID,
                    $majorID,
                    $sectionID,
                    $state,
                    $academicYearID,
                    $semesterID
                );


            if ($success) {
                return true;
            }


            /*
            |--------------------------------------------------------------------------
            | BACKTRACK
            |--------------------------------------------------------------------------
            */

            array_pop($generated);


            unset(
                $occupancy['teacher']
                    [$teacherID]
                    [$slotKey]
            );


            unset(
                $occupancy['room']
                    [$roomID]
                    [$slotKey]
            );


            unset(
                $occupancy['class']
                    [$classKey]
                    [$slotKey]
            );


            unset(
                $occupancy['teacher_room']
                    [$teacherRoomDayKey]
            );
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | COUNT GENERATED SUBJECT
    |--------------------------------------------------------------------------
    */

    private function countGeneratedSubject(
        array $generated,
        int $subjectID
    ): int {

        $count = 0;


        foreach ($generated as $item) {

            if (
                (int) $item['subject_id']
                ===
                $subjectID
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

    private function countTeacherDayPeriods(
        array $occupancy,
        int $teacherID,
        int $dayID
    ): int {

        $count = 0;


        foreach (
            $occupancy['teacher'][$teacherID] ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );


            if (
                isset($parts[0])
                &&
                (int) $parts[0]
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

    private function countTeacherWeekPeriods(
        array $occupancy,
        int $teacherID
    ): int {

        return count(
            $occupancy['teacher'][$teacherID]
            ?? []
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COUNT CLASS DAILY
    |--------------------------------------------------------------------------
    */

    private function countClassDayPeriods(
        array $occupancy,
        string $classKey,
        int $dayID
    ): int {

        $count = 0;


        foreach (
            $occupancy['class'][$classKey] ?? []
            as $slotKey => $value
        ) {

            $parts =
                explode(
                    '_',
                    $slotKey
                );


            if (
                isset($parts[0])
                &&
                (int) $parts[0]
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
    | RESULT
    |--------------------------------------------------------------------------
    */

    public function result(Request $request)
    {
        $request->validate([

            'academicYearID' =>
                'required|integer',

            'semesterID' =>
                'required|integer',

            'yearID' =>
                'required|integer',

            'majorID' =>
                'required|integer',

            'sectionID' =>
                'required|integer',
        ]);


        $academicYearID =
            (int) $request->academicYearID;


        $semesterID =
            (int) $request->semesterID;


        $yearID =
            (int) $request->yearID;


        $majorID =
            (int) $request->majorID;


        $sectionID =
            (int) $request->sectionID;


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $academicYear =
            AcademicYears::findOrFail(
                $academicYearID
            );


        $semester =
            Semesters::findOrFail(
                $semesterID
            );


        $yearData =
            Year::findOrFail(
                $yearID
            );


        $major =
            Major::findOrFail(
                $majorID
            );


        $section =
            Sections::findOrFail(
                $sectionID
            );


        /*
        |--------------------------------------------------------------------------
        | SCHEDULES
        |--------------------------------------------------------------------------
        */

        $schedules =
            Schedule::with([
                'academicYear',
                'semester',
                'year',
                'major',
                'section',
                'room',
                'teacher',
                'subject',
                'day',
                'time',
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
            ->where(
                'section_id',
                $sectionID
            )
            ->orderBy('day_id')
            ->orderBy('time_id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DAYS
        |--------------------------------------------------------------------------
        */

        $days =
            Day::orderBy('id')->get();


        /*
        |--------------------------------------------------------------------------
        | TIMES
        |--------------------------------------------------------------------------
        */

        $times =
            Time::orderBy('id')->get();


        /*
        |--------------------------------------------------------------------------
        | ROOM
        |--------------------------------------------------------------------------
        */

        $room =
            $schedules
                ->first()?->room;


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.schedule.show',
            compact(
                'schedules',
                'academicYear',
                'semester',
                'yearData',
                'major',
                'section',
                'room',
                'days',
                'times',
                'academicYearID',
                'semesterID',
                'yearID',
                'majorID',
                'sectionID'
            )
        );
    }


    // =====================================================
    // Drag & Drop Swap
    // =====================================================

    public function swap(Request $request)
    {
        // =====================================================
        // 1. Validate Request
        // =====================================================

        $request->validate([
            'schedule1_id' => [
                'required',
                'integer',
                'min:1',
                'exists:schedules,id',
            ],

            'schedule2_id' => [
                'required',
                'integer',
                'min:1',
                'exists:schedules,id',
            ],
        ]);


        $id1 = (int) $request->schedule1_id;
        $id2 = (int) $request->schedule2_id;


        // =====================================================
        // 2. Same Schedule
        // =====================================================

        if ($id1 === $id2) {

            return response()->json([
                'success' => false,
                'message' => 'You cannot swap the same subject.',
            ], 422);
        }


        try {

            DB::transaction(function () use ($id1, $id2) {

                // =================================================
                // 3. Get Schedule 1
                // =================================================

                $schedule1 = Schedule::lockForUpdate()
                    ->findOrFail($id1);


                // =================================================
                // 4. Get Schedule 2
                // =================================================

                $schedule2 = Schedule::lockForUpdate()
                    ->findOrFail($id2);


                // =================================================
                // 5. Same Timetable Check
                // =================================================
                //
                // Drag & Drop Swap ကို
                // Year + Major + Room + Semester + Section
                // တူတဲ့ timetable ထဲမှာပဲ ခွင့်ပြုမယ်
                //

                if (
                    (int) $schedule1->year_id !==
                    (int) $schedule2->year_id

                    ||

                    (int) $schedule1->major_id !==
                    (int) $schedule2->major_id

                    ||

                    (int) $schedule1->room_id !==
                    (int) $schedule2->room_id

                    ||

                    (int) $schedule1->semester_id !==
                    (int) $schedule2->semester_id

                    ||

                    (int) $schedule1->section_id !==
                    (int) $schedule2->section_id
                ) {

                    throw new \Exception(
                        'These subjects belong to different timetables.'
                    );
                }


                // =================================================
                // 6. Check Day / Time IDs
                // =================================================

                if (
                    empty($schedule1->day_id) ||
                    empty($schedule1->time_id) ||
                    empty($schedule2->day_id) ||
                    empty($schedule2->time_id)
                ) {

                    throw new \Exception(
                        'Invalid timetable position.'
                    );
                }


                $day1  = (int) $schedule1->day_id;
                $time1 = (int) $schedule1->time_id;

                $day2  = (int) $schedule2->day_id;
                $time2 = (int) $schedule2->time_id;


                // =================================================
                // 7. Teacher Conflict - Subject 1
                // =================================================
                //
                // Subject 1 ရဲ့ Teacher က
                // Subject 2 ရဲ့ Day + Time မှာ
                // အခြား Room / Section မှာ ရှိနေသလား?
                //

                if (!empty($schedule1->teacher_id)) {

                    $teacherConflict1 = Schedule::query()

                        ->where(
                            'teacher_id',
                            $schedule1->teacher_id
                        )

                        ->where('day_id', $day2)

                        ->where('time_id', $time2)

                        // Swap လုပ်နေတဲ့ schedule ၂ ခုကို
                        // conflict ထဲက ဖယ်မယ်
                        ->whereNotIn('id', [
                            $id1,
                            $id2,
                        ])

                        ->exists();


                    if ($teacherConflict1) {

                        $teacherName =
                            optional($schedule1->teacher)->name
                            ?? 'Unknown Teacher';


                        throw new \Exception(
                            "Swap မလုပ်နိုင်ပါ။ {$teacherName} ဆရာ/မသည် အခြားအခန်း သို့မဟုတ် Section တွင် ထိုနေ့၊ ထိုအချိန်၌ သင်ကြားနေပါသည်။"
                        );
                    }
                }


                // =================================================
                // 8. Teacher Conflict - Subject 2
                // =================================================
                //
                // Subject 2 ရဲ့ Teacher က
                // Subject 1 ရဲ့ Day + Time မှာ
                // အခြား Room / Section မှာ ရှိနေသလား?
                //

                if (!empty($schedule2->teacher_id)) {

                    $teacherConflict2 = Schedule::query()

                        ->where(
                            'teacher_id',
                            $schedule2->teacher_id
                        )

                        ->where('day_id', $day1)

                        ->where('time_id', $time1)

                        ->whereNotIn('id', [
                            $id1,
                            $id2,
                        ])

                        ->exists();


                    if ($teacherConflict2) {

                        $teacherName =
                            optional($schedule2->teacher)->name
                            ?? 'Unknown Teacher';


                        throw new \Exception(
                            "Swap မလုပ်နိုင်ပါ။ {$teacherName} ဆရာ/မသည် အခြားအခန်း သို့မဟုတ် Section တွင် ထိုနေ့၊ ထိုအချိန်၌ သင်ကြားနေပါသည်။"
                        );
                    }
                }


                // =================================================
                // 9. Room Conflict
                // =================================================
                //
                // Same room + same day + same time
                // တခြား schedule ရှိမရှိစစ်
                //

                $roomConflict1 = Schedule::query()

                    ->where(
                        'room_id',
                        $schedule1->room_id
                    )

                    ->where('day_id', $day2)

                    ->where('time_id', $time2)

                    ->whereNotIn('id', [
                        $id1,
                        $id2,
                    ])

                    ->exists();


                if ($roomConflict1) {

                    throw new \Exception(
                        'Destination room is already occupied at this time.'
                    );
                }


                // =================================================
                // 10. Room Conflict - Subject 2
                // =================================================

                $roomConflict2 = Schedule::query()

                    ->where(
                        'room_id',
                        $schedule2->room_id
                    )

                    ->where('day_id', $day1)

                    ->where('time_id', $time1)

                    ->whereNotIn('id', [
                        $id1,
                        $id2,
                    ])

                    ->exists();


                if ($roomConflict2) {

                    throw new \Exception(
                        'Destination room is already occupied at this time.'
                    );
                }


                // =================================================
                // 11. Swap
                // =================================================

                $schedule1->day_id = $day2;
                $schedule1->time_id = $time2;

                $schedule1->save();


                $schedule2->day_id = $day1;
                $schedule2->time_id = $time1;

                $schedule2->save();


            });


            // =====================================================
            // 12. Success
            // =====================================================

            return response()->json([
                'success' => true,
                'message' => 'Timetable swapped successfully.',
            ]);


        } catch (\Throwable $e) {

            // =====================================================
            // 13. Error
            // =====================================================

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
