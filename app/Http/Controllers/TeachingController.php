<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Teaching;
use App\Models\Year;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TeachingController extends Controller
{
    // create page
    public function create()
    {
        $years    = Year::get();
        $majors   = Major::get();
        $rooms    = Room::get();
        $subjects = Subject::get();

        return view('admin.teaching_classes.create', compact(
            'years', 'majors', 'rooms', 'subjects'
        ));
    }

    // store teaching class
    public function createTeaching(Request $request)
    {
        $this->checkValidationTeaching($request);

        $teaching = $this->getTeachingData($request);

        Teaching::create($teaching);

        Alert::success('Success', 'Teaching Created Successfully');

        return back();
    }

    //updatePage
    public function updatePage($id){
        $years = Year::get();
        $majors = Major::get();
        $rooms = Room::get();
        $subjects = Subject::get();
        $teaching = Teaching::where('id', $id)->first();
        return view('admin.teaching_classes.edit', compact('teaching','rooms','subjects','years','majors'));
    }

    //update process
    public function update(Request $request,$id){
        $this->checkValidationTeaching($request);
        $subject = $this->getTeachingData($request);

        Teaching::where('id', $id)->update($subject);

        Alert::success('Success Teaching', 'Teaching Updated Successfully');

        return to_route('teaching.list');
    }

    //delete
    public function delete($id){
        Teaching::find($id)->delete();
        Alert::success('Success Teaching', 'Teaching Deleted Successfully');
        return back();
    }

    // map request data
    private function getTeachingData($request)
    {
        return [
            'name'       => $request->name,
            'year_id'    => $request->yearID,
            'major_id'   => $request->majorID,
            'room_id'    => $request->roomID,
            'subject_id' => $request->subjectID,
        ];
    }

    // validation
    public function checkValidationTeaching($request)
    {
        $rules = [
            'name'      => 'required|unique:teachings,name',
            'yearID'    => 'required',
            'majorID'   => 'required',
            'subjectID' => 'required',
            'roomID'    => 'required',
        ];

        $request->validate($rules);
    }

    // list teaching classes
    public function list()
    {
        $teachings = Teaching::select(
            'teachings.id',
            'teachings.name',
            'teachings.year_id',
            'teachings.major_id',
            'teachings.room_id',
            'teachings.subject_id',
            'teachings.created_at',

            'years.name as year_name',
            'majors.name as major_name',
            'rooms.name as room_name',
            'subjects.short_name as subject_short_name'
        )
            ->leftJoin('years', 'teachings.year_id', '=', 'years.id')
            ->leftJoin('majors', 'teachings.major_id', '=', 'majors.id')
            ->leftJoin('rooms', 'teachings.room_id', '=', 'rooms.id')
            ->leftJoin('subjects', 'teachings.subject_id', '=', 'subjects.id')
            ->when(request('searchKey'), function ($query) {
                $query->where('teachings.name', 'like', '%' . request('searchKey') . '%')
                      ->orwhere('subjects.short_name', 'like', '%' . request('searchKey') . '%')
                      ->orwhere('rooms.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('years.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('majors.name', 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('teachings.created_at', 'desc')
            ->paginate(5);

        return view('admin.teaching_classes.list', compact('teachings'));
    }
}
