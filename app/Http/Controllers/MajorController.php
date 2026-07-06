<?php

namespace App\Http\Controllers;
use App\Models\Major;
use App\Models\Year;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MajorController extends Controller
{
    //create
    public function create(){
        $years = Year::get();
        return view('admin.major.create',compact('years'));
    }

    //create major
    public function createMajor(Request $request){
        $this->checkValidationMajor($request);
        $major = $this->getMajorData($request);

        Major::create($major);

        Alert::success('Success Major', 'Major Created Successfully');

        return back();
    }

    //updatePage
    public function updatePage($id){
        $years = Year::get();
        $major = Major::where('id', $id)->first();
        return view('admin.major.edit', compact('major','years'));
    }

    //update process
    public function update(Request $request,$id){
        $this->checkValidationMajor($request);
        $major = $this->getMajorData($request);

        Major::where('id', $id)->update($major);

        Alert::success('Success Major', 'Major Updated Successfully');

        return to_route('major.list');
    }

    //delete
    public function delete($id){
        Major::find($id)->delete();
        Alert::success('Success Major', 'Major Deleted Successfully');
        return back();
    }

    //request major data
    private function getMajorData($request){
        return [
            'name' => $request->name,
            'year_id' => $request->yearID
        ];
    }

    //check validation major
    public function checkValidationMajor($request){
        $rules = [
            'name' => 'required',
            'yearID' => 'required'
        ];

        $messages = [];

        $request->validate($rules,$messages);
    }

    //major list
    public function list()
    {
        $majors = Major::select(
                'years.name as year_name',
                'majors.id',
                'majors.name',
                'majors.year_id',
                'majors.created_at'
            )
            ->leftJoin('years', 'majors.year_id', '=', 'years.id')
            ->when(request('searchKey'), function ($query) {
                $query->where('majors.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('years.name', 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('majors.created_at', 'desc')
            ->paginate(5);

        return view('admin.major.list', compact('majors'));
    }
}
