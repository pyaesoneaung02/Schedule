<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Department;
use App\Models\Major;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Time;
use App\Models\Year;
use Illuminate\Http\Request;

class AdminController extends Controller
{
//direct admin home page
    public function adminHome()
    {
        // return view('admin.home.list');

        //each count
        $teacherCount = Teacher::count();
        $yearCount = Year::count();
        $departmentCount = Department::count();
        $subjectCount = Subject::count();

        return view('admin.home.list', compact(
            'teacherCount',
            'yearCount',
            'departmentCount',
            'subjectCount'
        ));
    }


    //student timetable
    // public function viewStudentTimetable(Request $request, $yearID)
    // {

    //     $days = Day::orderBy('id')->get();

    //     $times = Time::orderBy('id')->get();


    //     $yearData = Year::find($yearID);

    //     $sections = Sections::orderBy('id')->get();


    //     $sectionID = $request->query('sectionID');

    //     $section = null;

    //     if ($sectionID) {

    //         $section = Sections::find($sectionID);

    //     }


    //     $scheduleQuery = Schedule::with([
    //         'subject',
    //         'teacher',
    //         'room',
    //         'day',
    //         'time',
    //         'section',
    //         'year',
    //         'major',
    //         'semester',
    //         'academicYear',
    //     ])
    //         ->where('year_id', $yearID)
    //         ->orderBy('day_id')
    //         ->orderBy('time_id');

    //     if ($sectionID) {

    //         $scheduleQuery->where('section_id', $sectionID);

    //     }

    //     $schedules = $scheduleQuery->get();

    //     $firstSchedule = $schedules->first();

    //     $major = $firstSchedule?->major;

    //     $room = $firstSchedule?->room;

    //     $academicYear = $firstSchedule?->academicYear;

    //     $semester = $firstSchedule?->semester;

    //     if (!$section && $firstSchedule) {

    //         $section = $firstSchedule->section;

    //     }

    //     $years = Year::orderBy('id')->get();

    //     $rooms = Room::orderBy('id')->get();

    //     $teachers = Teacher::orderBy('id')->get();

    //     return view(
    //         'admin.schedule.viewStudentTimetable',
    //         compact(
    //             'years',
    //             'rooms',
    //             'teachers',
    //             'days',
    //             'times',
    //             'schedules',
    //             'yearData',
    //             'major',
    //             'section',
    //             'room',
    //             'academicYear',
    //             'sections',
    //             'semester'
    //         )
    //     );
    // }

    // =========================================================
// STUDENT TIMETABLE
// =========================================================
public function viewStudentTimetable(Request $request, $yearID)
{
    /*
    |--------------------------------------------------------------------------
    | YEAR
    |--------------------------------------------------------------------------
    */
    $yearData = Year::findOrFail($yearID);


    /*
    |--------------------------------------------------------------------------
    | DAYS / TIMES
    |--------------------------------------------------------------------------
    */
    $days = Day::orderBy('id')->get();

    $times = Time::orderBy('id')->get();


    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    $years = Year::orderBy('id')->get();

    $rooms = Room::orderBy('id')->get();

    $teachers = Teacher::orderBy('id')->get();

    $sections = Sections::orderBy('name')->get();

    $majors = Major::orderBy('name')->get();


    /*
    |--------------------------------------------------------------------------
    | SELECTED MAJOR
    |--------------------------------------------------------------------------
    */
    $majorID = $request->query('majorID');

    $major = null;

    if ($majorID) {

        $major = Major::find($majorID);

    }


    /*
    |--------------------------------------------------------------------------
    | SELECTED SECTION
    |--------------------------------------------------------------------------
    */
    $sectionID = $request->query('sectionID');

    $section = null;

    if ($sectionID) {

        $section = Sections::find($sectionID);

    }


    /*
    |--------------------------------------------------------------------------
    | SCHEDULE QUERY
    |--------------------------------------------------------------------------
    */
    $scheduleQuery = Schedule::with([
        'subject',
        'teacher',
        'room',
        'day',
        'time',
        'section',
        'year',
        'major',
        'semester',
        'academicYear',
    ])
    ->where('year_id', $yearID);


    /*
    |--------------------------------------------------------------------------
    | MAJOR FILTER
    |
    | CS / CT ကို ဒီနေရာမှာခွဲမယ်
    |--------------------------------------------------------------------------
    */
    if ($major) {

        $scheduleQuery->where(
            'major_id',
            $major->id
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SECTION FILTER
    |--------------------------------------------------------------------------
    */
    if ($section) {

        $scheduleQuery->where(
            'section_id',
            $section->id
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GET SCHEDULES
    |--------------------------------------------------------------------------
    */
    $schedules = $scheduleQuery
        ->orderBy('day_id')
        ->orderBy('time_id')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | FALLBACK DATA
    |
    | Major မရွေးထားရင် schedule ထဲက ပထမဆုံး major ကိုယူ
    |--------------------------------------------------------------------------
    */
    $firstSchedule = $schedules->first();


    if (!$major && $firstSchedule) {

        $major = $firstSchedule->major;

    }


    /*
    |--------------------------------------------------------------------------
    | ROOM
    |--------------------------------------------------------------------------
    */
    $room = $firstSchedule?->room;


    /*
    |--------------------------------------------------------------------------
    | ACADEMIC YEAR
    |--------------------------------------------------------------------------
    */
    $academicYear = $firstSchedule?->academicYear;


    /*
    |--------------------------------------------------------------------------
    | SEMESTER
    |--------------------------------------------------------------------------
    */
    $semester = $firstSchedule?->semester;


    /*
    |--------------------------------------------------------------------------
    | SECTION FALLBACK
    |--------------------------------------------------------------------------
    */
    if (!$section && $firstSchedule) {

        $section = $firstSchedule->section;

    }


    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */
    return view('admin.schedule.viewStudentTimetable',
        compact(
            'years',
            'rooms',
            'teachers',
            'days',
            'times',
            'schedules',
            'yearData',
            'major',
            'majors',
            'section',
            'sections',
            'room',
            'academicYear',
            'semester'
        )
    );
}

// =========================================================
// TEACHER SCHEDULE
// =========================================================
public function teacherSchedule(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN USER
    |--------------------------------------------------------------------------
    */

    $user = auth()->user();

    if (!$user) {
        abort(403, 'Unauthorized.');
    }


    /*
    |--------------------------------------------------------------------------
    | FIND TEACHER PROFILE
    |--------------------------------------------------------------------------
    */

    $teacher = Teacher::where('user_id', $user->id)->first();

    if (!$teacher) {
        abort(404, 'Teacher profile not found.');
    }


    /*
    |--------------------------------------------------------------------------
    | DAYS
    |--------------------------------------------------------------------------
    */

    $days = Day::orderBy('id')->get();


    /*
    |--------------------------------------------------------------------------
    | TIMES
    |--------------------------------------------------------------------------
    */

    $times = Time::orderBy('id')->get();


    /*
    |--------------------------------------------------------------------------
    | TEACHER SCHEDULE
    |--------------------------------------------------------------------------
    */

    $schedules = Schedule::with([
        'subject',
        'teacher',
        'room',
        'day',
        'time',
        'section',
        'year',
        'major',
        'semester',
        'academicYear',
    ])
    ->where('teacher_id', $teacher->id)
    ->orderBy('day_id')
    ->orderBy('time_id')
    ->get();


    /*
    |--------------------------------------------------------------------------
    | ACADEMIC YEAR
    |--------------------------------------------------------------------------
    */

    $academicYear = $schedules
        ->first()
        ?->academicYear;


    /*
    |--------------------------------------------------------------------------
    | SEMESTER
    |--------------------------------------------------------------------------
    */

    $semester = $schedules
        ->first()
        ?->semester;


    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'user.component.teacherSchedule',
        compact(
            'teacher',
            'days',
            'times',
            'schedules',
            'academicYear',
            'semester'
        )
    );
}

}
