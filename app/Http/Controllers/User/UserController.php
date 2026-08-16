<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Major;
use App\Models\Schedule;
use App\Models\Sections;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\Time;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    // direct user home page
    public function userHome()
    {
        // return view('user.home.list');
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

        $years = Year::all();

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

        $years = Year::all();

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

    //subject page
    public function subjectPage()
    {

        $userId  = auth()->id();
        $teacher = Teacher::where('user_id', $userId)->first();

        $teachings = collect();

        if ($teacher) {
            $teachings = Teaching::with(['subject', 'year', 'major', 'section', 'room'])
                ->where('teacher_id', $teacher->id)
                ->get();
        }

        return view('user.component.subject', compact('teachings'));
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

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
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

}
