<?php

namespace App\Http\Controllers;

use App\Models\Semesters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SemestersController extends Controller
{
    //semester route list
    public function list(){
        $semesters = Semesters::orderBy('created_at','desc')->paginate(5);
        return view('admin.semester.list', compact('semesters'));
    }

    //create
    public function create(Request $request){

        // dd('create method reached');

        $this->checkValidation($request);

        Semesters::create([
            'name' => $request->semesterName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Semester', 'Semester Created Successfully');
        return back();
    }

    //delete
    public function delete($id){
        Semesters::find($id)->delete();
        Alert::success('Success Semester', 'Semester Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id){
        $semester = Semesters::where('id', $id)->first();
        return view('admin.semester.update', compact('semester'));
    }

     //update
    public function update($id, Request $request){
        $this->checkValidation($request);

        Semesters::where('id', $id)->update([
            'name' =>$request->semesterName,
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Semester', 'Semester Updated Successfully');
        return to_route('semester.list');
    }

    //check semester validation
    private function checkValidation($request){
        $request->validate([
            'semesterName' => 'required|unique:semesters,name'
        ]);
    }
}
