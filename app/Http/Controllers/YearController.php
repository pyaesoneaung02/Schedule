<?php

namespace App\Http\Controllers;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class YearController extends Controller
{
    //year route list
    public function list(){
        $years = Year::orderBy('created_at','desc')->paginate(5);
        return view('admin.year.list', compact('years'));
    }

    //create
    public function create(Request $request){

        // dd('create method reached');

        $this->checkValidation($request);

        Year::create([
            'name' => $request->yearName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Year', 'Year Created Successfully');
        return back();
    }

    //delete
    public function delete($id){
        Year::find($id)->delete();
        Alert::success('Success Year', 'Year Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id){
        $year = Year::where('id', $id)->first();
        return view('admin.year.update', compact('year'));
    }

     //update
    public function update($id, Request $request){
        $this->checkValidation($request);

        Year::where('id', $id)->update([
            'name' =>$request->yearName,
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Year', 'Year Updated Successfully');
        return to_route('year#list');
    }

    //check year validation
    private function checkValidation($request){
        $request->validate([
            'yearName' => 'required|unique:years,name'
        ],[
            'yearName.required' => 'ခုနစ် လိုအပ်သည်။'
        ]);
    }
}
