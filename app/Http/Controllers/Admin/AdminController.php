<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Year;
// use Illuminate\Http\Request;

class AdminController extends Controller
{
//direct user home page
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
}
