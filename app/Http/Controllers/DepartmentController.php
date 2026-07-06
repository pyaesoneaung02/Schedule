<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    //year route list
    public function list(){
        $departments = Department::orderBy('created_at','desc')->paginate(5);
        return view('admin.department.list', compact('departments'));
    }

    //create
    public function create(Request $request){

        // dd('create method reached');

        $this->checkValidation($request);

        Department::create([
            'name' => $request->departmentName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Department', 'Department Created Successfully');
        return back();
    }

    //delete
    public function delete($id){
        Department::find($id)->delete();
        Alert::success('Success Department', 'Department Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id){
        $department = Department::where('id', $id)->first();
        return view('admin.department.update', compact('department'));
    }

     //update
    public function update($id, Request $request){
        $this->checkValidation($request);

            Department::where('id', $id)->update([
            'name' =>$request->departmentName,
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Department', 'Department Updated Successfully');
        return to_route('department.list');
    }

    //check year validation
    private function checkValidation($request){
        $request->validate([
            'departmentName' => 'required'
        ]);
    }
}
