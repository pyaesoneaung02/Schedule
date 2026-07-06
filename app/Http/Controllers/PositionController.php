<?php
namespace App\Http\Controllers;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    //position route list
    public function list()
    {
        $positions = Position::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.position.list', compact('positions'));
    }

    //create
    public function create(Request $request)
    {

        // dd('create method reached');

        $this->checkValidation($request);

            Position::create([
            'name'       => $request->positionName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Position', 'Position Created Successfully');
        return back();
    }

    //delete
    public function delete($id)
    {
        Position::find($id)->delete();
        Alert::success('Success Position', 'Position Deleted Successfully');
        return back();
    }

    //update page
    public function updatePage($id)
    {
        $position = Position::where('id', $id)->first();
        return view('admin.position.update', compact('position'));
    }

    //update
    public function update($id, Request $request)
    {
        $this->checkValidation($request);

            Position::where('id', $id)->update([
            'name'       => $request->positionName,
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Position', 'Position Updated Successfully');
        return to_route('position.list');
    }

    //check year validation
    private function checkValidation($request)
    {
        $request->validate([
            'positionName' => 'required',
        ]);
    }
}
