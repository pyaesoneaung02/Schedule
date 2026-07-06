<?php
namespace App\Http\Controllers;

use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TimeController extends Controller
{
    //year route list
    public function list()
    {
        $times = Time::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.time.list', compact('times'));
    }

    //create
    public function create(Request $request)
    {

        // dd('create method reached');

        $this->checkValidation($request);

        Time::create([
            'name'       => $request->timeName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Time', 'Time Created Successfully');
        return back();
    }

    //delete
    public function delete($id)
    {
        Time::find($id)->delete();
        Alert::success('Success Time', 'Time Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id)
    {
        $time = Time::where('id', $id)->first();
        return view('admin.time.update', compact('time'));
    }

    //update
    public function update($id, Request $request)
    {
        $this->checkValidation($request);

        Time::where('id', $id)->update([
            'name'       => $request->timeName,
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Time', 'Time Updated Successfully');
        return to_route('time.list');
    }

    //check year validation
    private function checkValidation($request)
    {
        $request->validate([
            'timeName' => 'required',
        ]);
    }
}
