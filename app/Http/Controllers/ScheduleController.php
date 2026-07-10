<?php
namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Time;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    // create page
    public function create()
    {
        $years    = Year::get();
        $majors   = Major::get();
        $rooms    = Room::get();
        $subjects = Subject::get();
        $times    = Time::get();
        $teachers = Teacher::get();
        $days     = Day::get();

        return view('admin.schedule.create', compact(
            'years', 'majors', 'rooms', 'subjects', 'times', 'teachers', 'days'
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
        $years    = Year::get();
        $majors   = Major::get();
        $rooms    = Room::get();
        $subjects = Subject::get();
        $days     = Day::get();
        $times    = Time::get();
        $teachers = Teacher::get();
        $schedule = Schedule::where('id', $id)->first();
        return view('admin.schedule.edit', compact('schedule', 'rooms', 'subjects', 'years', 'majors', 'days', 'times', 'teachers'));
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
            'year_id'    => $request->yearID,
            'major_id'   => $request->majorID,
            'room_id'    => $request->roomID,
            'subject_id' => $request->subjectID,
            'day_id'     => $request->dayID,
            'time_id'    => $request->timeID,
            'teacher_id' => $request->teacherID,
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

            'yearID'    => 'required',
            'majorID'   => 'required',
            'roomID'    => 'required',
            'subjectID' => 'required',
            'teacherID' => 'required',
            'dayID'     => 'required',
            'timeID'    => 'required',

        ], [

            'yearID.required'    => 'Please select Year.',
            'majorID.required'   => 'Please select Major.',
            'roomID.required'    => 'Please select Room.',
            'subjectID.required' => 'Please select Subject.',
            'teacherID.required' => 'Please select Teacher.',
            'dayID.required'     => 'Please select Day.',
            'timeID.required'    => 'Please select Time.',

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
            'times.name as time_name'
        )

            ->join('teachers', 'teachers.id', '=', 'schedules.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'schedules.subject_id')
            ->join('rooms', 'rooms.id', '=', 'schedules.room_id')
            ->join('years', 'years.id', '=', 'schedules.year_id')
            ->join('majors', 'majors.id', '=', 'schedules.major_id')
            ->join('days', 'days.id', '=', 'schedules.day_id')
            ->join('times', 'times.id', '=', 'schedules.time_id')

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
                        ->orWhere('majors.name', 'like', '%' . $search . '%');

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
            'schedules.year_id',
            'schedules.major_id',
            'schedules.room_id',
            'schedules.subject_id',
            'schedules.created_at',
            'years.name as year_name',
            'majors.name as major_name',
            'rooms.name as room_name',
            'subjects.short_name as subject_short_name',
            'subjects.long_name as subject_long_name',
            'days.name as day_name',
            'times.name as time_name',
            'teachers.name as teacher_name'
        )
            ->leftJoin('years', 'schedules.year_id', '=', 'years.id')
            ->leftJoin('majors', 'schedules.major_id', '=', 'majors.id')
            ->leftJoin('rooms', 'schedules.room_id', '=', 'rooms.id')
            ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->leftJoin('days', 'schedules.day_id', '=', 'days.id')
            ->leftJoin('times', 'schedules.time_id', '=', 'times.id')
            ->leftJoin('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->when(request('searchKey'), function ($query) {
                $query->where('schedules.id', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('teachers.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('times.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('days.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('subjects.short_name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('subjects.long_name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('rooms.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('years.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('majors.name', 'like', '%' . request('searchKey') . '%');
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

        $majors = Major::all();
        $rooms  = Room::all();

        return view('admin.schedule.viewSchedule', compact('years', 'majors', 'rooms'));
    }

    // result schedule
    public function result(Request $request, $year)
    {
        $request->validate([
            'roomID'  => 'required',
            'majorID' => 'required',
        ]);

        // EXACT MATCH (Year + Room + Major)
        $days     = Day::all();
        $times    = Time::all();
        $teachers = Teacher::all();

        $schedules = Schedule::with(['day', 'subject', 'time', 'teacher'])
            ->where('year_id', $year)
            ->where('room_id', $request->roomID)
            ->where('major_id', $request->majorID)
            ->get();

        $yearData = Year::findOrFail($year);
        $room     = Room::findOrFail($request->roomID);
        $major    = Major::findOrFail($request->majorID);

        return view('admin.schedule.result', compact(
            'schedules',
            'yearData',
            'room',
            'major',
            'days',
            'times',
            'teachers'
        ));
    }

    //create PDF
    public function downloadPdf($yearId, $roomId, $majorId)
    {
        $yearData = Year::findOrFail($yearId);
        $room     = Room::findOrFail($roomId);
        $major    = Major::findOrFail($majorId);

        $days  = Day::all();
        $times = Time::all();

        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('year_id', $yearId)
            ->where('room_id', $roomId)
            ->where('major_id', $majorId)
            ->get();

        $pdf = Pdf::loadView('admin.schedule.pdf', compact(
            'yearData',
            'room',
            'major',
            'days',
            'times',
            'schedules'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('TimeTable.pdf');
    }
}
