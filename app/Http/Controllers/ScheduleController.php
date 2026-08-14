<?php
namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\Time;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    // create page
    public function create()
    {
        $academicYears = AcademicYears::all();
        $years         = Year::get();
        $majors        = Major::get();
        $rooms         = Room::get();
        $subjects      = Subject::get();
        $times         = Time::get();
        $teachers      = Teacher::get();
        $days          = Day::get();
        $semesters     = Semesters::get();
        $sections      = Sections::get();

        return view('admin.schedule.create', compact(
            'years', 'majors', 'rooms', 'subjects', 'times', 'teachers', 'days', 'semesters', 'sections', 'academicYears'
        ));
    }

    // Store Schedule
    public function createSchedule(Request $request)
    {
        $validation = $this->checkValidationSchedule($request);

        if ($validation) {
            return $validation;
        }

        $schedule = $this->getScheduleData($request);

        Schedule::create($schedule);

        Alert::success('Success Schedule', 'Schedule Created Successfully');

        return back();
    }

    // ============================================================
    // UPDATE PAGE
    // ============================================================

    public function updatePage($id)
    {
        $academicYears = AcademicYears::orderBy('id')->get();
        $years         = Year::orderBy('id')->get();
        $majors        = Major::orderBy('id')->get();
        $rooms         = Room::orderBy('id')->get();
        $subjects      = Subject::orderBy('id')->get();
        $days          = Day::orderBy('id')->get();
        $times         = Time::orderBy('id')->get();
        $teachers      = Teacher::orderBy('id')->get();
        $semesters     = Semesters::orderBy('id')->get();
        $sections      = Sections::orderBy('id')->get();

        $schedule = Schedule::findOrFail($id);

        return view(
            'admin.schedule.edit',
            compact(
                'schedule',
                'rooms',
                'subjects',
                'years',
                'majors',
                'days',
                'times',
                'teachers',
                'semesters',
                'sections',
                'academicYears'
            )
        );
    }

    // ============================================================
    // UPDATE
    // ============================================================

    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Find existing schedule
        |--------------------------------------------------------------------------
        */

        $schedule = Schedule::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | 2. Validate
        |--------------------------------------------------------------------------
        */

        $this->checkValidationSchedule(
            $request,
            $schedule->id
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Prepare data
        |--------------------------------------------------------------------------
        */

        $data = $this->getScheduleData($request);

        /*
        |--------------------------------------------------------------------------
        | 4. Update
        |--------------------------------------------------------------------------
        */

        $schedule->update($data);

        Alert::success(
            'Success Schedule',
            'Schedule Updated Successfully'
        );

        return redirect()->route(
            'schedule.list'
        );
    }

    // ============================================================
    // MAP REQUEST DATA
    // ============================================================

    private function getScheduleData(Request $request)
    {
        return [

            'academic_year_id' =>
            (int) $request->academicYearID,

            'year_id'          =>
            (int) $request->yearID,

            'major_id'         =>
            (int) $request->majorID,

            'room_id'          =>
            (int) $request->roomID,

            'subject_id'       =>
            (int) $request->subjectID,

            'day_id'           =>
            (int) $request->dayID,

            'time_id'          =>
            (int) $request->timeID,

            'teacher_id'       =>
            (int) $request->teacherID,

            'semester_id'      =>
            (int) $request->semesterID,

            'section_id'       =>
            (int) $request->sectionID,
        ];
    }

    // ============================================================
    // VALIDATION
    // ============================================================

    public function checkValidationSchedule(
        Request $request,
        $ignoreScheduleId = null
    ) {

        /*
        |--------------------------------------------------------------------------
        | 1. Required
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'academicYearID' => 'required|integer',
            'yearID'         => 'required|integer',
            'majorID'        => 'required|integer',
            'roomID'         => 'required|integer',
            'subjectID'      => 'required|integer',
            'teacherID'      => 'required|integer',
            'dayID'          => 'required|integer',
            'timeID'         => 'required|integer',
            'semesterID'     => 'required|integer',
            'sectionID'      => 'required|integer',

        ], [

            'academicYearID.required' =>
            'Please select Academic Year.',

            'yearID.required'         =>
            'Please select Year.',

            'majorID.required'        =>
            'Please select Major.',

            'roomID.required'         =>
            'Please select Room.',

            'subjectID.required'      =>
            'Please select Subject.',

            'teacherID.required'      =>
            'Please select Teacher.',

            'dayID.required'          =>
            'Please select Day.',

            'timeID.required'         =>
            'Please select Time.',

            'semesterID.required'     =>
            'Please select Semester.',

            'sectionID.required'      =>
            'Please select Section.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Get data
        |--------------------------------------------------------------------------
        */

        $subject = Subject::find(
            $request->subjectID
        );

        $year = Year::find(
            $request->yearID
        );

        $major = Major::find(
            $request->majorID
        );

        $time = Time::find(
            $request->timeID
        );

        /*
        |--------------------------------------------------------------------------
        | 3. First Year Major
        |--------------------------------------------------------------------------
        */

        if ($year && $major) {

            if (
                $year->name === 'First Year'
                &&
                $major->name !== 'CST'
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'majorID' =>
                        'First Year must have CST major.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Lunch Break
        |--------------------------------------------------------------------------
        */

        if (
            $time
            &&
            $time->name === '12:00-01:00'
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'timeID' =>
                    'Lunch Break cannot be scheduled.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Helper
        |
        | Ignore current schedule while checking conflicts.
        |--------------------------------------------------------------------------
        */

        $withoutCurrent = function ($query) use (
            $ignoreScheduleId
        ) {

            if ($ignoreScheduleId) {

                $query->where(
                    'id',
                    '!=',
                    $ignoreScheduleId
                );
            }

            return $query;
        };

        /*
        |--------------------------------------------------------------------------
        | 5. CLASS / SECTION CONFLICT
        |
        | Same:
        | Academic Year
        | Semester
        | Year
        | Major
        | Section
        | Day
        | Time
        |--------------------------------------------------------------------------
        */

        $classConflict = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'year_id',
                $request->yearID
            )
            ->where(
                'major_id',
                $request->majorID
            )
            ->where(
                'section_id',
                $request->sectionID
            )
            ->where(
                'day_id',
                $request->dayID
            )
            ->where(
                'time_id',
                $request->timeID
            );

        $withoutCurrent($classConflict);

        if ($classConflict->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'timeID' =>
                    'This section already has another subject at this time.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. TEACHER CONFLICT
        |
        | Same Teacher + Day + Time
        |--------------------------------------------------------------------------
        */

        $teacherConflict = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'teacher_id',
                $request->teacherID
            )
            ->where(
                'day_id',
                $request->dayID
            )
            ->where(
                'time_id',
                $request->timeID
            );

        $withoutCurrent($teacherConflict);

        if ($teacherConflict->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'teacherID' =>
                    'Teacher already has another class at this time.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. ROOM CONFLICT
        |
        | Same Room + Day + Time
        |--------------------------------------------------------------------------
        */

        $roomConflict = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'room_id',
                $request->roomID
            )
            ->where(
                'day_id',
                $request->dayID
            )
            ->where(
                'time_id',
                $request->timeID
            );

        $withoutCurrent($roomConflict);

        if ($roomConflict->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'roomID' =>
                    'Room is already occupied at this time.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 8. SAME SUBJECT SAME DAY
        |
        | One subject cannot appear twice on same day
        |--------------------------------------------------------------------------
        */

        $subjectSameDay = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'year_id',
                $request->yearID
            )
            ->where(
                'major_id',
                $request->majorID
            )
            ->where(
                'section_id',
                $request->sectionID
            )
            ->where(
                'subject_id',
                $request->subjectID
            )
            ->where(
                'day_id',
                $request->dayID
            );

        $withoutCurrent($subjectSameDay);

        if ($subjectSameDay->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'subjectID' =>
                    'This subject already exists on this day.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 9. SUBJECT WEEKLY LIMIT
        |
        | IMPORTANT:
        |
        | time_number = number of times this subject is taught
        | for ONE SECTION per week.
        |
        | It is NOT multiplied by number of sections.
        |--------------------------------------------------------------------------
        */

        if ($subject) {

            $subjectWeekly = Schedule::query()
                ->where(
                    'academic_year_id',
                    $request->academicYearID
                )
                ->where(
                    'semester_id',
                    $request->semesterID
                )
                ->where(
                    'year_id',
                    $request->yearID
                )
                ->where(
                    'major_id',
                    $request->majorID
                )
                ->where(
                    'section_id',
                    $request->sectionID
                )
                ->where(
                    'subject_id',
                    $request->subjectID
                );

            $withoutCurrent($subjectWeekly);

            $count = $subjectWeekly->count();

            /*
            |--------------------------------------------------------------------------
            | Example:
            |
            | time_number = 3
            |
            | Monday = 1
            | Wednesday = 1
            | Friday = 1
            |
            | Total = 3
            |--------------------------------------------------------------------------
            */

            if (
                $count >=
                (int) $subject->time_number
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'subjectID' =>
                        'This subject has already reached its weekly limit of '
                        . $subject->time_number
                        . ' periods for this section.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 10. SUBJECT DAILY MAXIMUM
        |
        | One subject = maximum 1 period per day
        |--------------------------------------------------------------------------
        */

        $subjectDaily = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'year_id',
                $request->yearID
            )
            ->where(
                'major_id',
                $request->majorID
            )
            ->where(
                'section_id',
                $request->sectionID
            )
            ->where(
                'subject_id',
                $request->subjectID
            )
            ->where(
                'day_id',
                $request->dayID
            );

        $withoutCurrent($subjectDaily);

        if ($subjectDaily->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'subjectID' =>
                    'This subject can only be scheduled once per day.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 11. TEACHER DAILY MAXIMUM
        |
        | Maximum 4 periods per day
        |--------------------------------------------------------------------------
        */

        $teacherDaily = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'teacher_id',
                $request->teacherID
            )
            ->where(
                'day_id',
                $request->dayID
            );

        $withoutCurrent($teacherDaily);

        if (
            $teacherDaily->count() >= 4
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'teacherID' =>
                    'Teacher daily maximum of 4 periods has been reached.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 12. TEACHER WEEKLY MAXIMUM
        |
        | Maximum 20 periods per week
        |--------------------------------------------------------------------------
        */

        $teacherWeekly = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'teacher_id',
                $request->teacherID
            );

        $withoutCurrent($teacherWeekly);

        if (
            $teacherWeekly->count() >= 20
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'teacherID' =>
                    'Teacher weekly maximum of 20 periods has been reached.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 13. CLASS DAILY MAXIMUM
        |
        | Maximum 4 usable periods per day
        |
        | Because timetable:
        |
        | 09:00 - 10:30
        | 10:30 - 12:00
        | Lunch
        | 01:00 - 02:30
        | 02:30 - 04:00
        |
        | = 4 usable periods
        |--------------------------------------------------------------------------
        */

        $classDaily = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'year_id',
                $request->yearID
            )
            ->where(
                'major_id',
                $request->majorID
            )
            ->where(
                'section_id',
                $request->sectionID
            )
            ->where(
                'day_id',
                $request->dayID
            );

        $withoutCurrent($classDaily);

        if (
            $classDaily->count() >= 4
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'dayID' =>
                    'This section already has 4 periods on this day.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 14. SUBJECT + TEACHER CONSISTENCY
        |
        | Same subject in same section should use same teacher.
        |--------------------------------------------------------------------------
        */

        $differentTeacher = Schedule::query()
            ->where(
                'academic_year_id',
                $request->academicYearID
            )
            ->where(
                'semester_id',
                $request->semesterID
            )
            ->where(
                'year_id',
                $request->yearID
            )
            ->where(
                'major_id',
                $request->majorID
            )
            ->where(
                'section_id',
                $request->sectionID
            )
            ->where(
                'subject_id',
                $request->subjectID
            )
            ->where(
                'teacher_id',
                '!=',
                $request->teacherID
            );

        $withoutCurrent($differentTeacher);

        if ($differentTeacher->exists()) {

            return back()
                ->withInput()
                ->withErrors([
                    'teacherID' =>
                    'This subject is already assigned to another teacher for this section.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return null;
    }

    //delete
    public function delete($id)
    {
        Schedule::find($id)->delete();
        Alert::success('Success Schedule', 'Schedule Deleted Successfully');
        return back();
    }

    //teacher time table lists
    public function teacherTimeTable(Request $request, $yearID)
    {

        $years = Year::findOrFail($yearID);

        $schedules = Schedule::select(
            'schedules.*',
            'teachers.name as teacher_name',
            'subjects.short_name',
            'subjects.long_name',
            'rooms.name as room_name',
            'years.name as year_name',
            'majors.name as major_name',
            'days.name as day_name',
            'times.name as time_name',
            'semesters.name as semester_name',
            'sections.name as section_name'
        )

            ->join('teachers', 'teachers.id', '=', 'schedules.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'schedules.subject_id')
            ->join('rooms', 'rooms.id', '=', 'schedules.room_id')
            ->join('years', 'years.id', '=', 'schedules.year_id')
            ->join('majors', 'majors.id', '=', 'schedules.major_id')
            ->join('days', 'days.id', '=', 'schedules.day_id')
            ->join('times', 'times.id', '=', 'schedules.time_id')
            ->join('semesters', 'semesters.id', '=', 'schedules.semester_id')
            ->join('sections', 'sections.id', '=', 'schedules.section_id')

            ->where('schedules.year_id', $yearID)

            ->when(request('searchKey'), function ($query) {

                $search = request('searchKey');

                $query->where(function ($q) use ($search) {

                    $q->where('teachers.name', 'like', '%' . $search . '%')
                        ->orWhere('times.name', 'like', '%' . $search . '%')
                        ->orWhere('days.name', 'like', '%' . $search . '%')
                        ->orWhere('subjects.short_name', 'like', '%' . $search . '%')
                        ->orWhere('subjects.long_name', 'like', '%' . $search . '%')
                        ->orWhere('rooms.name', 'like', '%' . $search . '%')
                        ->orWhere('majors.name', 'like', '%' . $search . '%')
                        ->orWhere('semesters.name', 'like', '%' . $search . '%')
                        ->orWhere('sections.name', 'like', '%' . $search . '%');

                });

            })

            ->orderBy('schedules.created_at', 'desc')

            ->paginate(5);
        // ->withQueryString();

        return view(
            'admin.schedule.teacherTimeTable',
            compact(
                'years',
                'schedules'
            )
        );

    }

    // list schedules
    public function list()
    {
        $schedules = Schedule::select(
            'schedules.id',
            'schedules.academic_year_id',
            'schedules.year_id',
            'schedules.major_id',
            'schedules.room_id',
            'schedules.subject_id',
            'schedules.created_at',
            'academic_years.name as academic_year_name',
            'years.name as year_name',
            'majors.name as major_name',
            'rooms.name as room_name',
            'subjects.short_name as subject_short_name',
            'subjects.long_name as subject_long_name',
            'days.name as day_name',
            'times.name as time_name',
            'teachers.name as teacher_name',
            'semesters.name as semester_name',
            'sections.name as section_name'
        )
            ->leftJoin('academic_years', 'schedules.academic_year_id', '=', 'academic_years.id')
            ->leftJoin('years', 'schedules.year_id', '=', 'years.id')
            ->leftJoin('majors', 'schedules.major_id', '=', 'majors.id')
            ->leftJoin('rooms', 'schedules.room_id', '=', 'rooms.id')
            ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->leftJoin('days', 'schedules.day_id', '=', 'days.id')
            ->leftJoin('times', 'schedules.time_id', '=', 'times.id')
            ->leftJoin('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->leftJoin('semesters', 'schedules.semester_id', '=', 'semesters.id')
            ->leftJoin('sections', 'schedules.section_id', '=', 'sections.id')
            ->when(request('searchKey'), function ($query) {
                $query->where('schedules.id', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('academic_years.name', 'like', '%' . $search . '%')
                    ->orWhere('teachers.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('times.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('days.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('subjects.short_name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('subjects.long_name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('rooms.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('years.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('majors.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('semesters.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('sections.name', 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('schedules.created_at', 'desc')
            ->paginate(5);

        return view('admin.schedule.list', compact('schedules'));
    }

    // timetable
    public function timetable()
    {
        $years = Year::get();

        return view('admin.schedule.timeTable', compact('years'));
    }

    // view schedule
    // public function viewSchedule($id)
    // {
    //     $years = Year::findOrFail($id);

    //     $majors    = Major::all();
    //     $rooms     = Room::all();
    //     $semesters = Semesters::all();
    //     $sections  = Sections::all();

    //     return view('admin.schedule.viewSchedule', compact('years', 'majors', 'rooms', 'semesters', 'sections'));
    // }

    public function viewSchedule($id)
    {
        $years = Year::findOrFail($id);

        $academicYears = AcademicYears::all();
        $majors        = Major::all();
        $rooms         = Room::all();
        $semesters     = Semesters::all();
        $sections      = Sections::all();

        return view('admin.schedule.viewSchedule', compact(
            'years',
            'academicYears',
            'majors',
            'rooms',
            'semesters',
            'sections'
        )
        );
    }

    // result schedule
    public function result(Request $request, $year)
    {
        $request->validate([

            'roomID'     => 'required',
            'majorID'    => 'required',
            'semesterID' => 'required',
            'sectionID'  => 'required',

        ], [

            'roomID.required'     => 'Please select Room.',
            'majorID.required'    => 'Please select Major.',
            'semesterID.required' => 'Please select Semester.',
            'sectionID.required'  => 'Please select Section.',

        ]);

        $days  = Day::all();
        $times = Time::all();

        $schedules = Schedule::with([
            'day',
            'subject',
            'time',
            'teacher',
            'academicYear',
            'semester',
        ])
            ->where('year_id', $year)
            ->where('room_id', $request->roomID)
            ->where('major_id', $request->majorID)
            ->where('semester_id', $request->semesterID)
            ->where('section_id', $request->sectionID)
            ->get();

        $yearData = Year::findOrFail($year);

        $room = Room::findOrFail($request->roomID);

        $major = Major::findOrFail($request->majorID);

        $semesters = Semesters::findOrFail($request->semesterID);

        $sections = Sections::findOrFail($request->sectionID);

        $academicYear = AcademicYears::where('status', 'Active')->first();

        return view('admin.schedule.result',
            compact(
                'schedules',
                'yearData',
                'room',
                'major',
                'days',
                'times',
                'semesters',
                'sections',
                'academicYear'
            )
        );
    }

    //create PDF
    public function downloadPDF($yearId, $roomId, $majorId, $academicYearID)
    {
        $yearData = Year::findOrFail($yearId);
        $room     = Room::findOrFail($roomId);
        $major    = Major::findOrFail($majorId);

        $academicYear = AcademicYears::findOrFail($academicYearID);

        $semesters = Semesters::findOrFail(request('semesterID'));
        $sections  = Sections::findOrFail(request('sectionID'));

        $days  = Day::all();
        $times = Time::all();

        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('academic_year_id', $academicYearID)
            ->where('year_id', $yearId)
            ->where('room_id', $roomId)
            ->where('major_id', $majorId)
            ->where('semester_id', $semesters->id)
            ->where('section_id', $sections->id)
            ->get();

        $pdf = Pdf::loadView('admin.schedule.pdf', compact(
            'yearData',
            'room',
            'major',
            'academicYear',
            'semesters',
            'sections',
            'days',
            'times',
            'schedules'
        ));

        return $pdf->setPaper('a4', 'landscape')
            ->download('TimeTable.pdf');
    }

    // generate schedule

    public function generate(Request $request)
    {

        // dd('Generate');

        $year = Teaching::value('year_id');

        DB::transaction(function () {

            /*
        |--------------------------------------------------------------------------
        | Clear Old Generate Data
        |--------------------------------------------------------------------------
        */

            Teaching::query()
                ->update([

                    'day_id'  => null,

                    'time_id' => null,

                ]);

            /*
        |--------------------------------------------------------------------------
        | Get Teaching Data
        |--------------------------------------------------------------------------
        */

            $teachings = Teaching::all()
                ->shuffle();

            /*
        |--------------------------------------------------------------------------
        | Days
        |--------------------------------------------------------------------------
        */

            $days = Day::pluck('id')
                ->toArray();

            /*
        |--------------------------------------------------------------------------
        | Times
        | Remove Lunch
        |--------------------------------------------------------------------------
        */

            $times = Time::where(
                'name',
                '!=',
                '12:00-01:00'
            )
                ->pluck('id')
                ->toArray();

            foreach ($teachings as $teaching) {

                $assigned = false;

                /*
            |--------------------------------------------------------------------------
            | Random Slot
            |--------------------------------------------------------------------------
            */

                $slots = collect($days)

                    ->crossJoin($times)

                    ->shuffle();

                foreach ($slots as $slot) {

                    $dayID = $slot[0];

                    $timeID = $slot[1];

                    /*
                |--------------------------------------------------------------------------
                | Teacher Conflict
                |--------------------------------------------------------------------------
                */

                    $teacherBusy = Teaching::where(
                        'teacher_id',
                        $teaching->teacher_id
                    )
                        ->where(
                            'day_id',
                            $dayID
                        )
                        ->where(
                            'time_id',
                            $timeID
                        )
                        ->exists();

                    /*
                |--------------------------------------------------------------------------
                | Room Conflict
                |--------------------------------------------------------------------------
                */

                    $roomBusy = Teaching::where(
                        'room_id',
                        $teaching->room_id
                    )
                        ->where(
                            'day_id',
                            $dayID
                        )
                        ->where(
                            'time_id',
                            $timeID
                        )
                        ->exists();

                    /*
                |--------------------------------------------------------------------------
                | Class Conflict
                |--------------------------------------------------------------------------
                */

                    $classBusy = Teaching::where(
                        'year_id',
                        $teaching->year_id
                    )
                        ->where(
                            'major_id',
                            $teaching->major_id
                        )
                        ->where(
                            'section_id',
                            $teaching->section_id
                        )
                        ->where(
                            'day_id',
                            $dayID
                        )
                        ->where(
                            'time_id',
                            $timeID
                        )
                        ->exists();

                    if (
                        ! $teacherBusy &&
                        ! $roomBusy &&
                        ! $classBusy
                    ) {

                        $teaching->update([

                            'day_id'  => $dayID,

                            'time_id' => $timeID,

                        ]);

                        $assigned = true;

                        break;

                    }

                }

            }

        });

        return redirect()->route('schedule.result', [
            'year' => $year,
        ]);

    }

    // shift page
    public function shiftPage($id)
    {
        $schedule = Schedule::with([
            'subject',
            'teacher',
            'room',
            'day',
            'time',
        ])->findOrFail($id);

        $days = Day::get();

        $times = Time::get();

        $teachers = Teacher::get();

        $rooms = Room::get();

        return view('admin.schedule.shift', compact(
            'schedule',
            'days',
            'times',
            'teachers',
            'rooms'
        ));
    }

    // shift update page
    public function shift(Request $request, $id)
    {
        $request->validate([
            'dayID'  => 'required|integer',
            'timeID' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {

            // =============================================
            // Current Schedule
            // =============================================

            $schedule = Schedule::findOrFail($id);

            // =============================================
            // Target Schedule
            // =============================================

            $targetSchedule = Schedule::where(
                'academic_year_id',
                $schedule->academic_year_id
            )
                ->where('semester_id', $schedule->semester_id)
                ->where('year_id', $schedule->year_id)
                ->where('major_id', $schedule->major_id)
                ->where('section_id', $schedule->section_id)
                ->where('day_id', $request->dayID)
                ->where('time_id', $request->timeID)
                ->where('id', '!=', $schedule->id)
                ->first();

            // =============================================
            // Same Slot
            // =============================================

            if (
                $schedule->day_id == $request->dayID &&
                $schedule->time_id == $request->timeID
            ) {

                DB::rollBack();

                Alert::warning(
                    'Warning',
                    'This schedule is already in this time slot.'
                );

                return back();
            }

            // =============================================
            // Target has Schedule → SWAP
            // =============================================

            if ($targetSchedule) {

                // Save current position
                $oldDayID  = $schedule->day_id;
                $oldTimeID = $schedule->time_id;

                // -----------------------------------------
                // Target → Current position
                // -----------------------------------------

                $targetSchedule->update([
                    'day_id'     => $oldDayID,
                    'time_id'    => $oldTimeID,

                    'is_shifted' => true,
                ]);

                // -----------------------------------------
                // Current → Target position
                // -----------------------------------------

                $schedule->update([
                    'day_id'     => $request->dayID,
                    'time_id'    => $request->timeID,

                    'is_shifted' => true,
                ]);
            }

            // =============================================
            // Target Empty → Normal Shift
            // =============================================

            else {

                $schedule->update([
                    'day_id'     => $request->dayID,
                    'time_id'    => $request->timeID,

                    'is_shifted' => true,
                ]);
            }

            // =============================================
            // Commit
            // =============================================

            DB::commit();

            Alert::success(
                'Success',
                'Schedule shifted successfully.'
            );

            return to_route('schedule.list');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error(
                'Error',
                $e->getMessage()
            );

            return back();
        }
    }

}
