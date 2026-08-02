<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Subject;
use App\Models\Year;

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

        $subjects = Subject::with('year')->get();

        $years = $subjects->pluck('year')->unique('id');

        $majors = Major::all();

        return view('admin.home.landingPage', compact(
            'subjects',
            'years',
            'majors'
        ));

    }

    // filter subjects by year
    public function filterByYear($id)
    {

        $years = Year::get();


        $selectedYear = Year::find($id);


        $subjects = Subject::with('year')
            ->where('year_id',$id)
            ->get();



        return view('admin.home.landingPage',
        compact(
            'subjects',
            'years',
            'selectedYear'
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

}
