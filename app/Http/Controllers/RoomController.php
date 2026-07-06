<?php
namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Room;
use App\Models\Year;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    //create
    public function create()
    {
        $years  = Year::get();
        $majors = Major::get();
        return view('admin.room.create', compact('years', 'majors'));
    }

    //create room
    public function createRoom(Request $request)
    {
        $this->checkValidationRoom($request);
        $room = $this->getRoomData($request);

        Room::create($room);

        Alert::success('Success Room', 'Room Created Successfully');

        return back();
    }

    //updatePage
    public function updatePage($id){
        $years = Year::get();
        $majors = Major::get();
        $room = Room::where('id', $id)->first();
        return view('admin.room.edit', compact('room','majors','years'));
    }

    //update process
    public function update(Request $request,$id){
        $this->checkValidationRoom($request);
        $room = $this->getRoomData($request);

        Room::where('id', $id)->update($room);

        Alert::success('Success Room', 'Room Updated Successfully');

        return to_route('room.list');
    }

    //delete
    public function delete($id){
        Room::find($id)->delete();
        Alert::success('Success Room', 'Room Deleted Successfully');
        return back();
    }

    //request room data
    private function getRoomData($request)
    {
        return [
            'name'     => $request->name,
            'year_id'  => $request->yearID,
            'major_id' => $request->majorID,
        ];
    }

    //check validation room
    public function checkValidationRoom($request)
    {
        $rules = [
            'name'    => 'required',
            'yearID'  => 'required',
            'majorID' => 'required',
        ];

        $messages = [];

        $request->validate($rules, $messages);
    }

    //room list
    public function list()
    {
        $rooms = Room::select(
                'majors.name as major_name',
                'years.name as year_name',
                'rooms.id',
                'rooms.name',
                'rooms.year_id',
                'rooms.major_id',
                'rooms.created_at'
            )
            ->leftJoin('years', 'rooms.year_id', '=', 'years.id')
            ->leftJoin('majors', 'rooms.major_id', '=', 'majors.id')
            ->when(request('searchKey'), function ($query) {
                $query->where('rooms.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('majors.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('years.name', 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('rooms.created_at', 'desc')
            ->paginate(5);

        return view('admin.room.list', compact('rooms'));
    }
}
