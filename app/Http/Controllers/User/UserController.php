<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    // direct user home page
    public function userHome()
    {
        return view('user.home.list');
    }

    // landing page route
    public function landingPage()
    {

        $subjects = Subject::with([
            'year',
            'major',
        ])->get();

        $years = Year::all();

        $majors = Major::all();

        $teachers = Teacher::all();

        $selectedYear = null;

        return view('admin.home.landingPage', compact(
            'subjects',
            'years',
            'majors',
            'teachers',
            'selectedYear'
        ));

    }

    // about page route
    public function about()
    {

        return view('admin.home.about');

    }

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

        return view('admin.home.landingPage', compact(
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

        return view('admin.home.detail', compact('subject'));
    }

    public function delete($id)
    {

        $subject = Subject::findOrFail($id);

        if ($subject->image) {
            Storage::disk('public')->delete($subject->image);
        }

        $subject->delete();

        return redirect()->route('landingPage')->with('success', 'Subject removed successfully');

    }

}
