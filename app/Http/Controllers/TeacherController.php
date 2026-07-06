<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Teacher;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    //create
    public function create(){
        $positions = Position::get();
        $departments = Department::get();
        return view('admin.teacher.create',compact('positions','departments'));
    }

    //create teacher
    public function createTeacher(Request $request)
    {
        $this->checkValidationTeacher($request);
        $teacher = $this->getTeacherData($request);

        Teacher::create($teacher);

        Alert::success('Success Teacher', 'Teacher Created Successfully');

        return back();
    }

    //updatePage
    public function updatePage($id){
        $positions = Position::get();
        $departments = Department::get();
        $teacher = Teacher::where('id', $id)->first();
        return view('admin.teacher.edit', compact('teacher','positions','departments'));
    }

    //update process
    public function update(Request $request,$id){
        $this->checkValidationTeacher($request);
        $teacher = $this->getTeacherData($request);

        Teacher::where('id', $id)->update($teacher);

        Alert::success('Success Teacher', 'Teacher Updated Successfully');

        return to_route('teacher.list');
    }

     //delete
    public function delete($id){
        Teacher::find($id)->delete();
        Alert::success('Success Teacher', 'Teacher Deleted Successfully');
        return back();
    }

    //request teacher data
    private function getTeacherData($request)
    {
        return [
            'name'     => $request->name,
            'position_id'  => $request->positionID,
            'department_id' => $request->departmentID,
        ];
    }

    //check validation teacher
    public function checkValidationTeacher($request)
    {
        $rules = [
            'name'    => 'required',
            'positionID'  => 'required',
            'departmentID' => 'required',
        ];

        $messages = [];

        $request->validate($rules, $messages);
    }

    //room list
    public function list()
    {
        $teachers = Teacher::select(
            'positions.name as position_name',
            'departments.name as department_name',
            'teachers.id',
            'teachers.name',
            'teachers.position_id',
            'teachers.department_id',
            'teachers.created_at'
        )
        ->leftJoin('positions', 'teachers.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'teachers.department_id', '=', 'departments.id')
        ->when(request('searchKey'), function ($query) {
            $query->where('teachers.name', 'like', '%' . request('searchKey') . '%')
                  ->orWhere('positions.name', 'like', '%' . request('searchKey') . '%')
                  ->orWhere('departments.name', 'like', '%' . request('searchKey') . '%');
        })
        ->orderBy('teachers.created_at', 'desc')
        ->paginate(5);
        return view('admin.teacher.list', compact('teachers'));
    }
}
