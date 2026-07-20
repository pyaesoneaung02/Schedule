<?php

namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Major;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
{
    //create
    public function create(){
        $years = Year::get();
        $majors = Major::get();
        $academicYears = AcademicYears::get();
        $semesters = Semesters::get();
        return view('admin.subject.create',compact('years','majors','academicYears','semesters'));
    }

    //create subject
    public function createSubject(Request $request)
    {
        $this->checkValidationSubject($request);
        $subject = $this->getSubjectData($request);

        Subject::create($subject);

        Alert::success('Success Subject', 'Subject Created Successfully');

        return back();
    }

    //updatePage
    public function updatePage($id){
        $years = Year::get();
        $majors = Major::get();
        $academicYears = AcademicYears::get();
        $semesters = Semesters::get();
        $subject = Subject::where('id', $id)->first();
        return view('admin.subject.edit', compact('subject','years','majors','academicYears','semesters'));
    }

    //update process
    public function update(Request $request,$id){
        $this->checkValidationSubject($request);
        $subject = $this->getSubjectData($request);

        Subject::where('id', $id)->update($subject);

        Alert::success('Success Subject', 'Subject Updated Successfully');

        return to_route('subject.list');
    }

    //delete
    public function delete($id){
        Subject::find($id)->delete();
        Alert::success('Success Subject', 'Subject Deleted Successfully');
        return back();
    }

    //request subject data
    private function getSubjectData($request)
    {
        return [
            'long_name' => $request->longName,
            'short_name' => $request->shortName,
            'description' => Purifier::clean($request->description),
            'time_number' => $request->timeNumber,
            'year_id'  => $request->yearID,
            'major_id' => $request->majorID,
            'academic_year_id' => $request->academicID,
            'semester_id' => $request->semesterID
        ];
    }

    //check validation subject
    public function checkValidationSubject($request)
    {
        $rules = [
            'longName' => 'required',
            'shortName' => 'required',
            'timeNumber' => 'required',
            'description' => 'required',
            'yearID'  => 'required',
            'majorID' => 'required',
            'academicID' => 'required',
            'semesterID' => 'required'
        ];

        $messages = [];

        $request->validate($rules, $messages);
    }

    //subject list
    public function list()
    {
        $subjects = Subject::select(
            'majors.name as major_name',
            'years.name as year_name',
            'academic_years.name as academic_year_name',
            'semesters.name as semester_name',
            'subjects.id',
            'subjects.long_name',
            'subjects.short_name',
            'subjects.time_number',
            'subjects.description',
            'subjects.year_id',
            'subjects.major_id',
            'subjects.academic_year_id',
            'subjects.semester_id',
            'subjects.created_at'
        )
        ->leftJoin('years', 'subjects.year_id', '=', 'years.id')
        ->leftJoin('majors', 'subjects.major_id', '=', 'majors.id')
        ->leftJoin('academic_years', 'subjects.academic_year_id', '=', 'academic_years.id')
        ->leftJoin('semesters', 'subjects.semester_id', '=', 'semesters.id')
        ->when(request('searchKey'), function ($query) {
            $query->where('subjects.long_name', 'like', '%' . request('searchKey') . '%')
                  ->orwhere('subjects.short_name', 'like', '%' . request('searchKey') . '%')
                  ->orwhere('subjects.time_number', 'like', '%' . request('searchKey') . '%')
                  ->orWhere('years.name', 'like', '%' . request('searchKey') . '%')
                  ->orWhere('majors.name', 'like', '%' . request('searchKey') . '%')
                  ->orwhere('academic_years.name', 'like', '%'. request('searchKey') . '%')
                  ->orwhere('semesters.name', 'like', '%'. request('searchKey') . '%');
        })
        ->orderBy('subjects.created_at', 'desc')
        ->paginate(5);
        return view('admin.subject.list', compact('subjects'));
    }
}
