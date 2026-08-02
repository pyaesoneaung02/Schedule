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

    //updatePage
    public function updatePage($id)
    {
        $academicYears = AcademicYears::all();
        $years         = Year::get();
        $majors        = Major::get();
        $rooms         = Room::get();
        $subjects      = Subject::get();
        $days          = Day::get();
        $times         = Time::get();
        $teachers      = Teacher::get();
        $semesters     = Semesters::get();
        $sections      = Sections::get();
        $schedule      = Schedule::where('id', $id)->first();
        return view('admin.schedule.edit', compact('schedule', 'rooms', 'subjects', 'years', 'majors', 'days', 'times', 'teachers', 'semesters', 'sections', 'academicYears'));
    }

    //update process
    public function update(Request $request, $id)
    {
        $this->checkValidationSchedule($request);
        $schedule = $this->getScheduleData($request);

        Schedule::where('id', $id)->update($schedule);

        Alert::success('Success Schedule', 'Schedule Updated Successfully');

        return to_route('schedule.list');
    }

    //delete
    public function delete($id)
    {
        Schedule::find($id)->delete();
        Alert::success('Success Schedule', 'Schedule Deleted Successfully');
        return back();
    }

    // map request data
    private function getScheduleData($request)
    {
        return [
            'academic_year_id' => $request->academicYearID,
            'year_id'          => $request->yearID,
            'major_id'         => $request->majorID,
            'room_id'          => $request->roomID,
            'subject_id'       => $request->subjectID,
            'day_id'           => $request->dayID,
            'time_id'          => $request->timeID,
            'teacher_id'       => $request->teacherID,
            'semester_id'      => $request->semesterID,
            'section_id'       => $request->sectionID,
        ];
    }

    // Validation
    public function checkValidationSchedule($request)
    {

        /*
        |--------------------------------------------------------------------------
        | 1. Required Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'academicYearID' => 'required',
            'yearID'         => 'required',
            'majorID'        => 'required',
            'roomID'         => 'required',
            'subjectID'      => 'required',
            'teacherID'      => 'required',
            'dayID'          => 'required',
            'timeID'         => 'required',
            'semesterID'     => 'required',
            'sectionID'      => 'required',

        ], [

            'academicYearID.required' => 'Please select Academic Year.',
            'yearID.required'         => 'Please select Year.',
            'majorID.required'        => 'Please select Major.',
            'roomID.required'         => 'Please select Room.',
            'subjectID.required'      => 'Please select Subject.',
            'teacherID.required'      => 'Please select Teacher.',
            'dayID.required'          => 'Please select Day.',
            'timeID.required'         => 'Please select Time.',
            'semesterID.required'     => 'Please select Semester.',
            'sectionID.required'      => 'Please select Section.',

        ]);

        $subject = Subject::find($request->subjectID);

        /*
        |--------------------------------------------------------------------------
        | First Year Major Validation
        |--------------------------------------------------------------------------
        */

        $year  = Year::find($request->yearID);
        $major = Major::find($request->majorID);

        if ($year && $major) {

            if ($year->name == 'First Year' && $major->name != 'CST') {
                return back()
                    ->withErrors([
                        'majorID' => 'First Year must have CST major.',
                    ])
                    ->withInput();
            }

        }

        /*
        |--------------------------------------------------------------------------
        | 2. Lunch Break Validation
        |--------------------------------------------------------------------------
        */

        $time = Time::find($request->timeID);

        if ($time && $time->name == '12:00-01:00') {

            return back()->withErrors([
                'timeID' => 'Lunch Break cannot be scheduled.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 3. Class Conflict
        |
        | Same Year + Major + Room + Day + Time
        |
        |--------------------------------------------------------------------------
        */

        $classConflict = Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('room_id', $request->roomID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists();

        if ($classConflict) {

            return back()->withErrors([
                'timeID' => 'This class already has another subject at this time.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 4. Teacher Conflict
        |
        | Same Teacher + Day + Time
        |
        |--------------------------------------------------------------------------
        */

        $teacherConflict = Schedule::where('teacher_id', $request->teacherID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists();

        if ($teacherConflict) {

            return back()->withErrors([
                'teacherID' => 'Teacher already has another class at this time.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 5. Room Conflict
        |
        | Same Room + Day + Time
        |
        | Different Day / Different Time = Allowed
        |
        |--------------------------------------------------------------------------
        */

        $roomConflict = Schedule::where('room_id', $request->roomID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists();

        if ($roomConflict) {

            return back()->withErrors([
                'roomID' => 'Room already occupied at this time.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 6. Same Subject Same Day
        |--------------------------------------------------------------------------
        */

        $subjectSameDay = Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('room_id', $request->roomID)
            ->where('subject_id', $request->subjectID)
            ->where('day_id', $request->dayID)
            ->exists();

        if ($subjectSameDay) {

            return back()->withErrors([
                'subjectID' => 'This subject already exists today.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 7. Subject Weekly Period Limit
        |--------------------------------------------------------------------------
        */

        if ($subject) {

            $subjectWeekly = Schedule::where('year_id', $request->yearID)
                ->where('major_id', $request->majorID)
                ->where('room_id', $request->roomID)
                ->where('subject_id', $request->subjectID)
                ->count();

            if ($subjectWeekly >= $subject->time_number) {

                return back()->withErrors([
                    'subjectID' => 'Subject weekly period limit reached.',
                ])->withInput();

            }

        }

        /*
        |--------------------------------------------------------------------------
        | 8. Subject Daily Maximum
        |
        | Same subject max 1 period/day
        |
        |--------------------------------------------------------------------------
        */

        $subjectDaily = Schedule::where('subject_id', $request->subjectID)
            ->where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('day_id', $request->dayID)
            ->count();

        if ($subjectDaily >= 1) {

            return back()->withErrors([
                'subjectID' => 'This subject cannot repeat more than once per day.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 9. Teacher Daily Maximum
        |
        | Maximum 4 periods/day
        |
        |--------------------------------------------------------------------------
        */

        $teacherDaily = Schedule::where('teacher_id', $request->teacherID)
            ->where('day_id', $request->dayID)
            ->count();

        if ($teacherDaily >= 4) {

            return back()->withErrors([
                'teacherID' => 'Teacher daily maximum reached.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 10. Teacher Weekly Maximum
        |
        | Maximum 20 periods/week
        |
        |--------------------------------------------------------------------------
        */

        $teacherWeekly = Schedule::where('teacher_id', $request->teacherID)
            ->count();

        if ($teacherWeekly >= 20) {

            return back()->withErrors([
                'teacherID' => 'Teacher weekly maximum reached.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 11. Class Daily Maximum
        |
        | Maximum 5 periods/day
        |
        |--------------------------------------------------------------------------
        */

        $classDaily = Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('room_id', $request->roomID)
            ->where('day_id', $request->dayID)
            ->count();

        if ($classDaily >= 5) {

            return back()->withErrors([
                'dayID' => 'Class daily maximum reached.',
            ])->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | 12. Subject Teacher Consistency
        |
        | One subject = One teacher
        |
        |--------------------------------------------------------------------------
        */

        $differentTeacher = Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('subject_id', $request->subjectID)
            ->where('teacher_id', '!=', $request->teacherID)
            ->exists();

        if ($differentTeacher) {

            return back()->withErrors([
                'teacherID' => 'This subject already assigned to another teacher.',
            ])->withInput();

        }

        return null;

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
    public function viewSchedule($id)
    {
        $years = Year::findOrFail($id);

        $majors    = Major::all();
        $rooms     = Room::all();
        $semesters = Semesters::all();
        $sections  = Sections::all();

        return view('admin.schedule.viewSchedule', compact('years', 'majors', 'rooms', 'semesters', 'sections'));
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

    // generate

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

            'dayID'     => 'required',

            'timeID'    => 'required',

            'teacherID' => 'required',

            'roomID'    => 'required',

        ]);

        Schedule::where('id', $id)->update([

            'day_id'     => $request->dayID,

            'time_id'    => $request->timeID,

            'teacher_id' => $request->teacherID,

            'room_id'    => $request->roomID,

        ]);

        Alert::success(
            'Success',
            'Schedule Shift Successfully'
        );

        return to_route('schedule.list');

    }

}
