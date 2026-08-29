<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DayController extends Controller
{
    //day route list
    public function list(){
        $days = Day::orderBy('created_at','desc')->paginate(5);
        return view('admin.day.list', compact('days'));
    }

    //create
    public function create(Request $request){

        // dd('create method reached');

        $this->checkValidation($request);

        Day::create([
            'name' => $request->dayName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Day', 'Day Created Successfully');
        return back();
    }

    //delete
    public function delete($id){
        Day::find($id)->delete();
        Alert::success('Success Day', 'Day Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id){
        $day = Day::where('id', $id)->first();
        return view('admin.day.update', compact('day'));
    }

     //update
    public function update($id, Request $request){
        $this->checkValidation($request);

        Day::where('id', $id)->update([
            'name' =>$request->dayName,
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Day', 'Day Updated Successfully');
        return to_route('day.list');
    }

    //check day validation
    private function checkValidation($request){
        $request->validate([
            'dayName' => 'required|unique:days,name'
        ]);
    }
}
