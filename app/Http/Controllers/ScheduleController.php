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
        $request->validate([
            'yearID'    => 'required',
            'majorID'   => 'required',
            'subjectID' => 'required',
            'roomID'    => 'required',
            'dayID'     => 'required',
            'timeID'    => 'required',
            'teacherID' => 'required',
        ], [
            'yearID.required'    => 'Please select Year.',
            'majorID.required'   => 'Please select Major.',
            'subjectID.required' => 'Please select Subject.',
            'roomID.required'    => 'Please select Room.',
            'dayID.required'     => 'Please select Day.',
            'timeID.required'    => 'Please select Time.',
            'teacherID.required' => 'Please select Teacher.',
        ]);

        // 1. Same Section (Year + Major + Section + Day + Time)
        if (Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('room_id', $request->roomID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists()) {

            return back()->withErrors([
                'timeID' => '',
            ])->withInput();
        }

        // 2. Same Teacher (Day + Time)
        if (Schedule::where('teacher_id', $request->teacherID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists()) {

            return back()->withErrors([
                'teacherID' => '',
            ])->withInput();
        }

        // 3. Same Room (Day + Time)
        if (Schedule::where('room_id', $request->roomID)
            ->where('day_id', $request->dayID)
            ->where('time_id', $request->timeID)
            ->exists()) {

            return back()->withErrors([
                'roomID' => '',
            ])->withInput();
        }

        // 4. Same Subject + Room + Time
        if (Schedule::where('year_id', $request->yearID)
            ->where('major_id', $request->majorID)
            ->where('subject_id', $request->subjectID)
            ->where('day_id', $request->dayID)
            ->where('room_id', $request->roomID)
            ->where('time_id', $request->timeID)
            ->exists()) {

            return back()->withErrors([
                'subjectID' => '',
            ])->withInput();
        }
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

    //print & PDF
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
