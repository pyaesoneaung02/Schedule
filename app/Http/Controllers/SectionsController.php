<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SectionsController extends Controller
{
    //section route list
    public function list(){
        $sections = Sections::orderBy('created_at','desc')->paginate(5);
        return view('admin.section.list', compact('sections'));
    }

    //create
    public function create(Request $request){

        // dd('create method reached');

        $this->checkValidation($request);

        Sections::create([
            'name' => $request->sectionName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Section', 'Section Created Successfully');
        return back();
    }

    //delete
    public function delete($id){
        Sections::find($id)->delete();
        Alert::success('Success Section', 'Section Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id){
        $section = Sections::where('id', $id)->first();
        return view('admin.section.update', compact('section'));
    }

     //update
    public function update($id, Request $request){
        $this->checkValidation($request);

        Sections::where('id', $id)->update([
            'name' =>$request->sectionName,
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Section', 'Section Updated Successfully');
        return to_route('section.list');
    }

    //check section validation
    private function checkValidation($request){
        $request->validate([
            'sectionName' => 'required|unique:sections,name'
        ]);
    }
}
