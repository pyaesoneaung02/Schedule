<?php
namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Sections;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SectionsController extends Controller
{
    //section route list
    public function list()
    {
        $sections = Sections::select(
            'sections.id',
            'sections.name',
            'sections.year_id',
            'sections.major_id',
            'sections.created_at',
            'years.name as year_name',
            'majors.name as major_name'
        )
        ->leftJoin('years', 'sections.year_id', '=', 'years.id')
        ->leftJoin('majors', 'sections.major_id', '=', 'majors.id')
        ->orderBy('sections.created_at', 'desc')
        ->paginate(5);


        $years = Year::get();
        $majors = Major::get();

        return view('admin.section.list', compact(
            'sections',
            'years',
            'majors'
        ));
    }

    //create
    public function create(Request $request)
    {

        // dd('create method reached');

        $this->checkValidation($request);

        Sections::create([
            'name'       => $request->sectionName,
            'year_id'    => $request->yearID,
            'major_id'   => $request->majorID,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Section', 'Section Created Successfully');
        return back();
    }

    //delete
    public function delete($id)
    {
        $section = Sections::findOrFail($id);

        $section->delete();

        Alert::success('Success Section','Section Deleted Successfully'
        );

        return back();
    }

    //update page
    public function updatePage($id)
    {
        $section = Sections::where('id', $id)->first();
        return view('admin.section.update', compact('section'));
    }

    //update
    public function update($id, Request $request)
    {
        $this->checkValidation($request, $id);

        Sections::where('id', $id)->update([
            'name'       => $request->sectionName,
            'year_id'    => $request->yearID,
            'major_id'   => $request->majorID,
            'updated_at' => Carbon::now(),
        ]);

        Alert::success('Success Section','Section Updated Successfully'
        );

        return to_route('section.list');
    }

    //check section validation
    private function checkValidation($request)
    {
        $request->validate([
            'sectionName' => 'required|unique:sections,name',
            'yearID'     => 'required',
            'majorID'    => 'required',
        ]);
    }
}
