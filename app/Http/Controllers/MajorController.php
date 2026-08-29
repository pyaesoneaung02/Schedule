<?php
namespace App\Http\Controllers;

use App\Models\Major;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MajorController extends Controller
{
    //major route list
    public function list()
    {
        $majors = Major::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.major.list', compact('majors'));
    }

    //create
    public function create(Request $request)
    {

        // dd('create method reached');

        $this->checkValidation($request);

        Major::create([
            'name'       => $request->majorName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Major', 'Major Created Successfully');
        return back();
    }

    //delete
    public function delete($id)
    {
        Major::find($id)->delete();
        Alert::success('Success Major', 'Major Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id)
    {
        $major = Major::where('id', $id)->first();
        return view('admin.major.update', compact('major'));
    }

    //update
    public function update($id, Request $request)
    {
        $this->checkValidation($request);

        Major::where('id', $id)->update([
            'name'       => $request->majorName,
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Major', 'Major Updated Successfully');
        return to_route('major.list');
    }

    //check major validation
    private function checkValidation($request)
    {
        $request->validate([
            'majorName' => 'required|unique:majors,name',
        ]);
    }
}
