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
                    ->orWhereHas('teacher.user', function ($teacherQuery) use ($search) {

                        $teacherQuery->where(
                            'phone',
                            'like',
                            "%{$search}%"
                        );

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


    /*
    |--------------------------------------------------------------------------
    | DELETE CONTACT
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | ACCEPT CONTACT
    |--------------------------------------------------------------------------
    */

    public function accept($id)
    {
        Contact::findOrFail($id)->update([
            'status'       => 'accepted',
            'is_user_read' => false,
        ]);

        return back()->with(
            'success',
            'Contact accepted successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT CONTACT
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        Contact::findOrFail($id)->update([
            'status'       => 'rejected',
            'is_user_read' => false,
        ]);

        return back()->with(
            'success',
            'Contact rejected successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW CONTACT
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | STORE CONTACT
    |--------------------------------------------------------------------------
    */

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

        if (!$user) {

            return back()->withErrors([
                'message' => 'You must be logged in to send a message.',
            ]);
        }

        $teacher = Teacher::where(
            'user_id',
            $user->id
        )->first();

        Contact::create([
            'user_id'      => $user->id,
            'teacher_id'   => $teacher?->id,
            'name'         => $request->name,
            'email'        => $request->email,
            'department'   => $request->department,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'status'       => 'pending',
            'is_user_read' => true,
        ]);

        return back()->with(
            'success',
            'Your message has been sent successfully!'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CONTACT
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $notification = Contact::findOrFail($id);

        $notification->delete();

        return redirect()
            ->back()
            ->with('success', 'Message deleted successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | USER NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    public function userNotifications()
    {
        $userId = auth()->id();

        $notifications = Contact::where(
            'user_id',
            $userId
        )
            ->latest()
            ->get();

        Contact::where(
            'user_id',
            $userId
        )
            ->where(
                'is_user_read',
                false
            )
            ->where(function ($query) {

                $query->where(function ($q) {

                    $q->whereNotNull('reply_message')
                        ->where(
                            'reply_message',
                            '!=',
                            ''
                        );

                })
                ->orWhereIn(
                    'status',
                    [
                        'accepted',
                        'rejected',
                    ]
                );

            })
            ->update([
                'is_user_read' => true,
            ]);

        return view(
            'user.component.notification',
            compact('notifications')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | READ CONTACT
    |--------------------------------------------------------------------------
    */

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
    | REPLY PAGE
    |--------------------------------------------------------------------------
    */

    public function reply($id)
    {
        $contact = Contact::findOrFail($id);

        return view(
            'admin.contact.reply',
            compact('contact')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEND REPLY
    |--------------------------------------------------------------------------
    */

    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update([
            'reply_message' => $request->reply_message,
            'is_user_read'  => false,
        ]);

        return redirect()
            ->route(
                'contact.show',
                $contact->id
            )
            ->with(
                'success',
                'Reply sent successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE PAGE
    |--------------------------------------------------------------------------
    */

    public function autoGenerate()
    {
        $academicYears = AcademicYears::orderBy('id')->get();
        $semesters     = Semesters::orderBy('id')->get();
        $years         = Year::orderBy('id')->get();
        $majors        = Major::orderBy('id')->get();
        $sections      = Sections::orderBy('id')->get();
        $rooms         = Room::orderBy('id')->get();

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
    */

    public function createSchedule(Request $request)
    {
        $request->validate([
            'academicYearID' => [
                'required',
                'integer',
                'exists:academic_years,id',
            ],

            'semesterID' => [
                'required',
                'integer',
                'exists:semesters,id',
            ],

            'yearID' => [
                'required',
                'integer',
                'exists:years,id',
            ],

            'majorID' => [
                'required',
                'integer',
                'exists:majors,id',
            ],
        ]);


        $academicYearID = (int) $request->academicYearID;
        $semesterID     = (int) $request->semesterID;
        $yearID         = (int) $request->yearID;
        $majorID        = (int) $request->majorID;


        /*
        |--------------------------------------------------------------------------
        | DAYS
        |--------------------------------------------------------------------------
        */

        $days = Day::orderBy('id')->get();

        if ($days->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' => 'No days found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TIMES
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
                    'generate' => 'No usable time slots found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SECTIONS
        |--------------------------------------------------------------------------
        */

        $sections = Sections::orderBy('id')->get();

        if ($sections->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' => 'No sections found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ROOMS
        |--------------------------------------------------------------------------
        */

        $rooms = Room::query()
            ->where('year_id', $yearID)
            ->where('major_id', $majorID)
            ->orderBy('id')
            ->get();

        if ($rooms->isEmpty()) {

            $rooms = Room::orderBy('id')->get();
        }

        if ($rooms->isEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'generate' => 'No rooms found.',
                ]);
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | LOAD ALL EXISTING SCHEDULES
            |--------------------------------------------------------------------------
            |
            | အရေးကြီး
            |
            | Teacher Conflict စစ်ရန်
            | Year / Major / Section အားလုံးယူမယ်။
            |
            */

            $allExistingSchedules = Schedule::where(
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
            | CURRENT TIMETABLE SHIFTED SCHEDULES
            |--------------------------------------------------------------------------
            */

            $currentShiftedSchedules = $allExistingSchedules
                ->filter(function ($schedule) use (
                    $yearID,
                    $majorID
                ) {

                    return
                        (int) $schedule->year_id === $yearID
                        &&
                        (int) $schedule->major_id === $majorID
                        &&
                        (bool) $schedule->is_shifted === true;

                })
                ->values();


            /*
            |--------------------------------------------------------------------------
            | DELETE OLD AUTO GENERATED SCHEDULE
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
                    'is_shifted',
                    false
                )
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | RELOAD EXISTING SCHEDULES
            |--------------------------------------------------------------------------
            |
            | Current Year/Major auto schedules ဖျက်ပြီးနောက်
            | Database မှာကျန်တဲ့ schedule အားလုံးယူမယ်။
            |
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
            | OCCUPANCY
            |--------------------------------------------------------------------------
            */

            $occupancy = [
                'teacher' => [],
                'room'    => [],
                'class'   => [],
            ];


            /*
            |--------------------------------------------------------------------------
            | LOAD EXISTING OCCUPANCY
            |--------------------------------------------------------------------------
            */

            foreach ($existingSchedules as $schedule) {

                if (
                    !$schedule->day_id
                    ||
                    !$schedule->time_id
                ) {
                    continue;
                }

                $dayID  = (int) $schedule->day_id;
                $timeID = (int) $schedule->time_id;

                $slotKey =
                    $dayID
                    . '_'
                    . $timeID;


                /*
                |--------------------------------------------------------------------------
                | TEACHER
                |--------------------------------------------------------------------------
                |
                | ALL YEAR / MAJOR / SECTION
                |
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
                | ROOM
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
                | CLASS
                |--------------------------------------------------------------------------
                */

                $classKey =
                    (int) $schedule->year_id
                    . '_'
                    . (int) $schedule->major_id
                    . '_'
                    . (int) $schedule->section_id;

                $occupancy['class']
                    [$classKey]
                    [$slotKey] = true;
            }


            /*
            |--------------------------------------------------------------------------
            | TOTAL
            |--------------------------------------------------------------------------
            */

            $generatedTotal = 0;

            $sectionResults = [];


            /*
            |--------------------------------------------------------------------------
            | GENERATE EACH SECTION
            |--------------------------------------------------------------------------
            */

            foreach ($sections as $section) {

                $classKey =
                    $yearID
                    . '_'
                    . $majorID
                    . '_'
                    . $section->id;


                /*
                |--------------------------------------------------------------------------
                | TEACHINGS
                |--------------------------------------------------------------------------
                */

                $teachings = Teaching::with(
                    'subject'
                )
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
                        $section->id
                    )
                    ->get();


                if ($teachings->isEmpty()) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | UNIQUE SUBJECTS
                |--------------------------------------------------------------------------
                */

                $uniqueTeachings = $teachings
                    ->filter(function ($teaching) {

                        return
                            $teaching->subject !== null
                            &&
                            $teaching->teacher_id !== null;

                    })
                    ->unique('subject_id')
                    ->values();


                if ($uniqueTeachings->isEmpty()) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SUBJECT DATA
                |--------------------------------------------------------------------------
                */

                $subjects = [];


                foreach ($uniqueTeachings as $teaching) {

                    $subject = $teaching->subject;

                    if (!$subject) {
                        continue;
                    }


                    $required = max(
                        1,
                        (int) (
                            $subject->time_number ?? 1
                        )
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | EXISTING SHIFTED COUNT
                    |--------------------------------------------------------------------------
                    */

                    $existingCount =
                        $currentShiftedSchedules
                            ->where(
                                'section_id',
                                $section->id
                            )
                            ->where(
                                'subject_id',
                                $teaching->subject_id
                            )
                            ->count();


                    $remaining = max(
                        0,
                        $required - $existingCount
                    );


                    if ($remaining <= 0) {
                        continue;
                    }


                    $subjects[] = [
                        'teaching'   => $teaching,
                        'subject_id' => (int) $teaching->subject_id,
                        'teacher_id' => (int) $teaching->teacher_id,
                        'required'   => $required,
                        'existing'   => $existingCount,
                        'remaining'  => $remaining,
                    ];
                }


                if (empty($subjects)) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | TOTAL REQUIRED CHECK
                |--------------------------------------------------------------------------
                */

                $totalRequired = array_sum(
                    array_column(
                        $subjects,
                        'remaining'
                    )
                );


                $usableSlots =
                    $days->count()
                    *
                    $times->count();


                /*
                |--------------------------------------------------------------------------
                | Shifted schedule already occupied slots
                |--------------------------------------------------------------------------
                */

                $shiftedClassSlots = 0;

                foreach (
                    $occupancy['class'][$classKey]
                    ??
                    []
                    as $slotKey => $value
                ) {
                    $shiftedClassSlots++;
                }


                /*
                |--------------------------------------------------------------------------
                | AVAILABLE CLASS SLOTS
                |--------------------------------------------------------------------------
                */

                $availableSlots =
                    $usableSlots
                    -
                    $shiftedClassSlots;


                if (
                    $totalRequired
                    >
                    $availableSlots
                ) {

                    $sectionName =
                        $section->name
                        ??
                        $section->id;


                    throw new \Exception(
                        'Section '
                        .
                        $sectionName
                        .
                        ' requires '
                        .
                        $totalRequired
                        .
                        ' periods but only '
                        .
                        $availableSlots
                        .
                        ' usable slots are available.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | HARD SUBJECT FIRST
                |--------------------------------------------------------------------------
                */

                usort(
                    $subjects,
                    function ($a, $b) {

                        return
                            $b['remaining']
                            <=>
                            $a['remaining'];

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | BUILD SLOTS
                |--------------------------------------------------------------------------
                */

                $slots = [];

                foreach ($days as $day) {

                    foreach ($times as $time) {

                        $slots[] = [
                            'day_id'  => (int) $day->id,
                            'time_id' => (int) $time->id,
                        ];
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | GENERATED
                |--------------------------------------------------------------------------
                */

                $generated = [];


                $state = [
                    'nodes'    => 0,
                    'maxNodes' => 300000,
                ];


                /*
                |--------------------------------------------------------------------------
                | GENERATE
                |--------------------------------------------------------------------------
                */

                $success = $this->generateSectionTimetable(
                    $subjects,
                    0,
                    $slots,
                    $rooms,
                    $occupancy,
                    $generated,
                    $yearID,
                    $majorID,
                    $section->id,
                    $classKey,
                    $state,
                    $academicYearID,
                    $semesterID
                );


                /*
                |--------------------------------------------------------------------------
                | GENERATION FAILED
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
                            +
                            $assigned;


                        if (
                            $totalAssigned
                            <
                            $subjectData['required']
                        ) {

                            $subjectName =
                                optional(
                                    $subjectData['teaching']->subject
                                )->long_name
                                ??
                                optional(
                                    $subjectData['teaching']->subject
                                )->name
                                ??
                                'Unknown Subject';


                            $details[] =
                                $subjectName
                                .
                                ' => Required: '
                                .
                                $subjectData['required']
                                .
                                ', Assigned: '
                                .
                                $totalAssigned
                                .
                                ', Missing: '
                                .
                                (
                                    $subjectData['required']
                                    -
                                    $totalAssigned
                                );
                        }
                    }


                    $sectionName =
                        $section->name
                        ??
                        $section->id;


                    $message =
                        'Section '
                        .
                        $sectionName
                        .
                        ' timetable could not be completed.';


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
                | SAVE GENERATED SCHEDULE
                |--------------------------------------------------------------------------
                */

                foreach ($generated as $item) {

                    Schedule::create([
                        'academic_year_id' => $academicYearID,
                        'semester_id'      => $semesterID,
                        'year_id'          => $yearID,
                        'major_id'         => $majorID,
                        'section_id'       => $section->id,
                        'room_id'          => $item['room_id'],
                        'subject_id'       => $item['subject_id'],
                        'teacher_id'       => $item['teacher_id'],
                        'day_id'           => $item['day_id'],
                        'time_id'          => $item['time_id'],
                        'is_shifted'       => false,
                    ]);
                }


                $generatedCount =
                    count($generated);

                $generatedTotal +=
                    $generatedCount;


                $sectionResults[] = [
                    'section' =>
                        $section->name,

                    'periods' =>
                        $generatedCount,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | NOTHING GENERATED
            |--------------------------------------------------------------------------
            */

            if ($generatedTotal <= 0) {

                throw new \Exception(
                    'No timetable periods were generated. Please check Teaching data, Subject time_number, Teacher, Year, Major and Section records.'
                );
            }


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
        | REDIRECT
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
            ]
        )->with(
            'success',
            'All sections timetable generated successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE SECTION TIMETABLE
    |--------------------------------------------------------------------------
    */

    private function generateSectionTimetable(
        &$subjects,
        $index,
        $slots,
        $rooms,
        &$occupancy,
        &$generated,
        $yearID,
        $majorID,
        $sectionID,
        $classKey,
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


        /*
        |--------------------------------------------------------------------------
        | ALL SUBJECTS DONE
        |--------------------------------------------------------------------------
        */

        if (
            $index
            >=
            count($subjects)
        ) {
            return true;
        }


        $subjectData =
            &$subjects[$index];


        $subjectID =
            (int) $subjectData['subject_id'];

        $teacherID =
            (int) $subjectData['teacher_id'];

        $required =
            (int) $subjectData['remaining'];


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
                $subjectID
            ) {

                $dayID =
                    (int) $item['day_id'];

                $subjectDayCount[$dayID] =
                    (
                        $subjectDayCount[$dayID]
                        ??
                        0
                    )
                    +
                    1;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TEACHER TIME BALANCE
        |--------------------------------------------------------------------------
        */

        $teacherTimeCount = [];

        foreach (
            $occupancy['teacher'][$teacherID]
            ??
            []
            as $slotKey => $value
        ) {

            $parts = explode(
                '_',
                $slotKey
            );

            if (
                count($parts)
                <
                2
            ) {
                continue;
            }

            $timeID =
                (int) $parts[1];

            $teacherTimeCount[$timeID] =
                (
                    $teacherTimeCount[$timeID]
                    ??
                    0
                )
                +
                1;
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER SLOTS
        |--------------------------------------------------------------------------
        */

        $orderedSlots = $slots;

        usort(
            $orderedSlots,
            function ($a, $b) use (
                &$occupancy,
                $classKey,
                $teacherTimeCount
            ) {

                $aDay =
                    (int) $a['day_id'];

                $bDay =
                    (int) $b['day_id'];

                $aTime =
                    (int) $a['time_id'];

                $bTime =
                    (int) $b['time_id'];


                /*
                |--------------------------------------------------------------------------
                | CLASS DAILY LOAD
                |--------------------------------------------------------------------------
                */

                $aClass =
                    $this->countClassDayPeriods(
                        $occupancy,
                        $classKey,
                        $aDay
                    );

                $bClass =
                    $this->countClassDayPeriods(
                        $occupancy,
                        $classKey,
                        $bDay
                    );


                if (
                    $aClass
                    !==
                    $bClass
                ) {

                    return
                        $aClass
                        <=>
                        $bClass;
                }


                /*
                |--------------------------------------------------------------------------
                | TEACHER TIME BALANCE
                |--------------------------------------------------------------------------
                */

                $aTeacherTime =
                    $teacherTimeCount[$aTime]
                    ??
                    0;

                $bTeacherTime =
                    $teacherTimeCount[$bTime]
                    ??
                    0;


                if (
                    $aTeacherTime
                    !==
                    $bTeacherTime
                ) {

                    return
                        $aTeacherTime
                        <=>
                        $bTeacherTime;
                }


                /*
                |--------------------------------------------------------------------------
                | RANDOMIZE SAME PRIORITY
                |--------------------------------------------------------------------------
                */

                return random_int(
                    -1,
                    1
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | TRY EVERY SLOT
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
                (
                    $subjectDayCount[$dayID]
                    ??
                    0
                )
                >=
                1
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
            | CLASS DAILY MAX
            |--------------------------------------------------------------------------
            */

            if (
                $this->countClassDayPeriods(
                    $occupancy,
                    $classKey,
                    $dayID
                )
                >=
                5
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TEACHER CONFLICT
            |--------------------------------------------------------------------------
            |
            | Year မတူလည်း
            | Major မတူလည်း
            | Section မတူလည်း
            |
            | Teacher တစ်ယောက်တည်းဆို
            | Same Day + Same Time မရ
            |
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
            | FIND AVAILABLE ROOM
            |--------------------------------------------------------------------------
            */

            $availableRoom = null;

            foreach ($rooms as $room) {

                $roomID =
                    (int) $room->id;

                if (
                    isset(
                        $occupancy['room']
                        [$roomID]
                        [$slotKey]
                    )
                ) {
                    continue;
                }

                $availableRoom = $room;

                break;
            }


            if (!$availableRoom) {
                continue;
            }


            $roomID =
                (int) $availableRoom->id;


            /*
            |--------------------------------------------------------------------------
            | ADD GENERATED ITEM
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
            | CHECK SUBJECT ASSIGNED COUNT
            |--------------------------------------------------------------------------
            */

            $assigned =
                $this->countGeneratedSubject(
                    $generated,
                    $subjectID
                );


            /*
            |--------------------------------------------------------------------------
            | NEXT RECURSION
            |--------------------------------------------------------------------------
            */

            if (
                $assigned
                >=
                $required
            ) {

                $success =
                    $this->generateSectionTimetable(
                        $subjects,
                        $index + 1,
                        $slots,
                        $rooms,
                        $occupancy,
                        $generated,
                        $yearID,
                        $majorID,
                        $sectionID,
                        $classKey,
                        $state,
                        $academicYearID,
                        $semesterID
                    );

            } else {

                $success =
                    $this->generateSectionTimetable(
                        $subjects,
                        $index,
                        $slots,
                        $rooms,
                        $occupancy,
                        $generated,
                        $yearID,
                        $majorID,
                        $sectionID,
                        $classKey,
                        $state,
                        $academicYearID,
                        $semesterID
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            if ($success) {
                return true;
            }


            /*
            |--------------------------------------------------------------------------
            | BACKTRACK
            |--------------------------------------------------------------------------
            */

            array_pop(
                $generated
            );


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
    | TEACHER DAILY PERIODS
    |--------------------------------------------------------------------------
    */

    private function countTeacherDayPeriods(
        array $occupancy,
        int $teacherID,
        int $dayID
    ): int {

        $count = 0;

        foreach (
            $occupancy['teacher'][$teacherID]
            ??
            []
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
    | TEACHER WEEKLY PERIODS
    |--------------------------------------------------------------------------
    */

    private function countTeacherWeekPeriods(
        array $occupancy,
        int $teacherID
    ): int {

        return count(
            $occupancy['teacher'][$teacherID]
            ??
            []
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLASS DAILY PERIODS
    |--------------------------------------------------------------------------
    */

    private function countClassDayPeriods(
        array $occupancy,
        string $classKey,
        int $dayID
    ): int {

        $count = 0;

        foreach (
            $occupancy['class'][$classKey]
            ??
            []
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
    | RESULT / SHOW TIMETABLE
    |--------------------------------------------------------------------------
    */

    public function result(Request $request)
    {
        $request->validate([
            'academicYearID' => [
                'required',
                'integer',
                'exists:academic_years,id',
            ],

            'semesterID' => [
                'required',
                'integer',
                'exists:semesters,id',
            ],

            'yearID' => [
                'required',
                'integer',
                'exists:years,id',
            ],

            'majorID' => [
                'required',
                'integer',
                'exists:majors,id',
            ],

            'sectionID' => [
                'nullable',
                'integer',
                'exists:sections,id',
            ],
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
            $request->filled('sectionID')
                ? (int) $request->sectionID
                : null;


        /*
        |--------------------------------------------------------------------------
        | BASIC DATA
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


        $sections =
            Sections::orderBy('id')->get();


        $section = null;

        if ($sectionID !== null) {

            $section =
                Sections::find(
                    $sectionID
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULE QUERY
        |--------------------------------------------------------------------------
        */

        $schedulesQuery =
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
                );


        if ($sectionID !== null) {

            $schedulesQuery->where(
                'section_id',
                $sectionID
            );
        }


        $schedules =
            $schedulesQuery
                ->orderBy('section_id')
                ->orderBy('day_id')
                ->orderBy('time_id')
                ->get();


        $days =
            Day::orderBy('id')->get();

        $times =
            Time::orderBy('id')->get();


        return view(
            'admin.schedule.show',
            compact(
                'schedules',
                'sections',
                'section',
                'academicYear',
                'semester',
                'yearData',
                'major',
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


    /*
    |--------------------------------------------------------------------------
    | SWAP TIMETABLE
    |--------------------------------------------------------------------------
    */

    public function swap(Request $request)
    {
        $request->validate([
            'schedule1_id' => [
                'required',
                'integer',
                'exists:schedules,id',
            ],

            'schedule2_id' => [
                'required',
                'integer',
                'exists:schedules,id',
            ],
        ]);


        $id1 =
            (int) $request->schedule1_id;

        $id2 =
            (int) $request->schedule2_id;


        if ($id1 === $id2) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You cannot swap the same schedule.',
            ], 422);
        }


        try {

            DB::transaction(
                function () use (
                    $id1,
                    $id2
                ) {

                    $schedule1 =
                        Schedule::lockForUpdate()
                            ->findOrFail($id1);

                    $schedule2 =
                        Schedule::lockForUpdate()
                            ->findOrFail($id2);


                    /*
                    |--------------------------------------------------------------------------
                    | SAME TIMETABLE CHECK
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $schedule1->academic_year_id
                        !=
                        $schedule2->academic_year_id

                        ||

                        $schedule1->semester_id
                        !=
                        $schedule2->semester_id

                        ||

                        $schedule1->year_id
                        !=
                        $schedule2->year_id

                        ||

                        $schedule1->major_id
                        !=
                        $schedule2->major_id

                        ||

                        $schedule1->section_id
                        !=
                        $schedule2->section_id
                    ) {

                        throw new \Exception(
                            'These schedules belong to different timetables.'
                        );
                    }


                    $day1 =
                        (int) $schedule1->day_id;

                    $time1 =
                        (int) $schedule1->time_id;

                    $day2 =
                        (int) $schedule2->day_id;

                    $time2 =
                        (int) $schedule2->time_id;


                    /*
                    |--------------------------------------------------------------------------
                    | TEACHER CONFLICT
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        [
                            [
                                'teacher_id' =>
                                    $schedule1->teacher_id,

                                'day_id' =>
                                    $day2,

                                'time_id' =>
                                    $time2,
                            ],

                            [
                                'teacher_id' =>
                                    $schedule2->teacher_id,

                                'day_id' =>
                                    $day1,

                                'time_id' =>
                                    $time1,
                            ],
                        ]
                        as $check
                    ) {

                        if (!$check['teacher_id']) {
                            continue;
                        }

                        $conflict =
                            Schedule::where(
                                'teacher_id',
                                $check['teacher_id']
                            )
                                ->where(
                                    'day_id',
                                    $check['day_id']
                                )
                                ->where(
                                    'time_id',
                                    $check['time_id']
                                )
                                ->whereNotIn(
                                    'id',
                                    [
                                        $id1,
                                        $id2,
                                    ]
                                )
                                ->exists();


                        if ($conflict) {

                            throw new \Exception(
                                'Teacher conflict at destination slot.'
                            );
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ROOM CONFLICT
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        [
                            [
                                'room_id' =>
                                    $schedule1->room_id,

                                'day_id' =>
                                    $day2,

                                'time_id' =>
                                    $time2,
                            ],

                            [
                                'room_id' =>
                                    $schedule2->room_id,

                                'day_id' =>
                                    $day1,

                                'time_id' =>
                                    $time1,
                            ],
                        ]
                        as $check
                    ) {

                        if (!$check['room_id']) {
                            continue;
                        }

                        $conflict =
                            Schedule::where(
                                'room_id',
                                $check['room_id']
                            )
                                ->where(
                                    'day_id',
                                    $check['day_id']
                                )
                                ->where(
                                    'time_id',
                                    $check['time_id']
                                )
                                ->whereNotIn(
                                    'id',
                                    [
                                        $id1,
                                        $id2,
                                    ]
                                )
                                ->exists();


                        if ($conflict) {

                            throw new \Exception(
                                'Room conflict at destination slot.'
                            );
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SWAP
                    |--------------------------------------------------------------------------
                    */

                    $schedule1->update([
                        'day_id' =>
                            $day2,

                        'time_id' =>
                            $time2,

                        'is_shifted' =>
                            true,
                    ]);


                    $schedule2->update([
                        'day_id' =>
                            $day1,

                        'time_id' =>
                            $time1,

                        'is_shifted' =>
                            true,
                    ]);
                }
            );


            return response()->json([
                'success' => true,
                'message' =>
                    'Timetable swapped successfully.',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' =>
                    $e->getMessage(),
            ], 422);
        }
    }
}
