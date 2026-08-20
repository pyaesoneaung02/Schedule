<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademicYears;
use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Time;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Dashboard
    public function userHome()
    {
        $years     = Year::all();
        $sections  = Sections::all();
        $days      = Day::all();
        $times     = Time::all();
        $schedules = Schedule::with(['subject', 'teacher', 'room', 'day', 'time'])->get();

        $user     = auth()->user();
        $userName = $user ? $user->name : '';

        // search teacher by user_id or name
        $teacher = Teacher::with(['department', 'position', 'teachings.subject.year', 'teachings.year', 'teachings.section'])
            ->where('user_id', $user->id)
            ->first();

        if (! $teacher && $userName) {
            $teacher = Teacher::with(['department', 'position', 'teachings.subject.year', 'teachings.year', 'teachings.section'])
                ->where('name', $userName)
                ->first();
        }

        // set assigned subjects from teachings mapping
        $assignedSubjects = $teacher && $teacher->teachings ? $teacher->teachings->map->subject : collect();

        return view('user.home.list', compact('years', 'sections', 'days', 'times', 'schedules', 'teacher', 'assignedSubjects'));
    }

    //landing page route start

    // landing page route
    public function page()
    {

        $subjects = Subject::with([
            'year',
            'major',
        ])->get();

        // $years = Year::all();
        $years = Year::orderByRaw("
                CASE
                    WHEN name LIKE '%ပထမနှစ်%' THEN 1
                    WHEN name LIKE '%ဒုတိယနှစ်%' THEN 2
                    WHEN name LIKE '%တတိယနှစ်%' THEN 3
                    WHEN name LIKE '%စတုတ္ထနှစ်%' THEN 4
                    WHEN name LIKE '%ပဉ္စမနှစ်%' THEN 5
                    ELSE 999
                END
            ")->get();

        $majors = Major::all();

        $teachers = Teacher::all();

        $selectedYear = null;

        return view('admin.home.page', compact(
            'subjects',
            'years',
            'majors',
            'teachers',
            'selectedYear'
        ));

    }

    // about page route
    // public function about()
    // {

    //     return view('admin.home.about');

    // }

    // filter subjects by year
    public function filterByYear($id)
    {

        $subjects = Subject::with([
            'year',
            'major',
        ])
            ->where('year_id', $id)
            ->get();

        // $years = Year::all();
        $years = Year::orderByRaw("
                CASE
                    WHEN name LIKE '%ပထမနှစ်%' THEN 1
                    WHEN name LIKE '%ဒုတိယနှစ်%' THEN 2
                    WHEN name LIKE '%တတိယနှစ်%' THEN 3
                    WHEN name LIKE '%စတုတ္ထနှစ်%' THEN 4
                    WHEN name LIKE '%ပဉ္စမနှစ်%' THEN 5
                    ELSE 999
                END
            ")->get();

        $selectedYear = Year::findOrFail($id);

        $majors = Major::all();

        $teachers = Teacher::all();

        return view('admin.home.page', compact(
            'subjects',
            'years',
            'majors',
            'selectedYear',
            'teachers'
        ));

    }

    // subject detail page
    public function subjectDetail($id)
    {
        $subject = Subject::with([
            'year',
            'major',
            'academicYear',
            'semester',
        ])->findOrFail($id);

        return view('admin.home.subjectDetail', compact('subject'));
    }

    public function delete($id)
    {

        $subject = Subject::findOrFail($id);
        if ($subject->image) {
            Storage::disk('public')->delete($subject->image);
        }

        $subject->delete();

        return redirect()->route('page')->with('success', 'Subject removed successfully');

    }

    //landing page route end

    // Subject
    public function subjectPage()
    {
        $user = auth()->user();

        // Teacher

        if ($user->role == 'teacher') {
            $teacher   = \App\Models\Teacher::where('user_id', $user->id)->first();
            $teachings = collect();

            if ($teacher) {
                $teachings = \App\Models\Teaching::with(['subject', 'year', 'major', 'section', 'room'])
                    ->where('teacher_id', $teacher->id)
                    ->get();
            }

            return view('user.component.subject', compact('teachings'));
        }

        // Student

        else {

            $allSubjects = \App\Models\Subject::with(['year', 'semester'])->get();

            return view('user.component.allSubject', compact('allSubjects'));
        }
    }

    // Schedule
    public function userSchedule()
    {
        // Extract Year and Section
        $years    = Year::all();
        $sections = Sections::all();

        $days  = Day::all();
        $times = Time::all();

        // Extract all data
        $schedules = Schedule::with(['subject', 'teacher', 'room', 'day', 'time', 'section'])->get();

        return view('user.component.schedule', compact('years', 'sections', 'schedules', 'days', 'times'));
    }

    //contact page
    public function contactPage()
    {
        return view('user.component.contact');
    }

    //  Teacher Profile
    public function profile()
    {
        $user    = Auth::user();
        $teacher = Teacher::with(['department', 'position'])->where('user_id', $user->id)->first();

        return view('user.profile.accountProfile', compact('user', 'teacher'));
    }

    //  Edit Profile
    public function editProfile()
    {
        $user    = Auth::user();
        $teacher = Teacher::with('department')->where('user_id', $user->id)->first();

        return view('user.profile.edit', compact('user', 'teacher'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
        ]);
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($teacher) {
            $teacher->name = $request->name;
            $teacher->save();
        }

        return redirect()->route('user.profile.accountProfile')->with('success', 'Profile updated successfully!');
    }

    // Change Password
    public function changePasswordPage()
    {
        return view('user.profile.changePassword');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        $user           = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    // Download PDF

    public function downloadSchedulePdf(Request $request)
    {

        $academicYear = AcademicYears::find($request->query('academicYearID'));
        $semesters    = Semesters::find($request->query('semesterID'));
        $yearData     = Year::find($request->query('year'));
        $major        = Major::find($request->query('major'));
        $sections     = Sections::find($request->query('sectionID'));
        $room         = Room::find($request->query('room'));

        $days  = Day::all();
        $times = Time::all();

        // Get Subject and Teacher from Schedule
        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('year_id', $yearData->id ?? null)
            ->where('section_id', $sections->id ?? null)
            ->get();

        // PDF View
        $pdf = Pdf::loadView('user.component.pdf', compact(
            'academicYear',
            'semesters',
            'yearData',
            'major',
            'sections',
            'room',
            'days',
            'times',
            'schedules'
        ));

        $pdf->setPaper('a4', 'landscape');

        // File name
        $yearName    = $yearData->name ?? 'Unknown_Year';
        $sectionName = $sections->name ?? 'Unknown_Section';
        $fileName    = 'Timetable_' . $yearName . '_' . $sectionName . '.pdf';

        return $pdf->download($fileName);
    }
}
