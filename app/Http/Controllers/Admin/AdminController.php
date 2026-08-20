<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Department;
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
    public function viewStudentTimetable(Request $request, $yearID)
    {

        $days = Day::orderBy('id')->get();

        $times = Time::orderBy('id')->get();


        $yearData = Year::find($yearID);

        $sections = Sections::orderBy('id')->get();


        $sectionID = $request->query('sectionID');

        $section = null;

        if ($sectionID) {

            $section = Sections::find($sectionID);

        }


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
            ->where('year_id', $yearID)
            ->orderBy('day_id')
            ->orderBy('time_id');

        if ($sectionID) {

            $scheduleQuery->where('section_id', $sectionID);

        }

        $schedules = $scheduleQuery->get();

        $firstSchedule = $schedules->first();

        $major = $firstSchedule?->major;

        $room = $firstSchedule?->room;

        $academicYear = $firstSchedule?->academicYear;

        $semester = $firstSchedule?->semester;

        if (!$section && $firstSchedule) {

            $section = $firstSchedule->section;

        }

        $years = Year::orderBy('id')->get();

        $rooms = Room::orderBy('id')->get();

        $teachers = Teacher::orderBy('id')->get();

        return view(
            'admin.schedule.viewStudentTimetable',
            compact(
                'years',
                'rooms',
                'teachers',
                'days',
                'times',
                'schedules',
                'yearData',
                'major',
                'section',
                'room',
                'academicYear',
                'sections',
                'semester'
            )
        );
    }

}
