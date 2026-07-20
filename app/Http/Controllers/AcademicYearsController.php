<?php
namespace App\Http\Controllers;

use App\Models\AcademicYears;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AcademicYearsController extends Controller
{

    // Academic Year List
    public function list()
    {
        $academicYears = AcademicYears::orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.academicYear.list', compact('academicYears'));
    }

    // Create Academic Year
    public function create(Request $request)
    {

        $this->checkValidation($request);

        AcademicYears::create([

            'name'       => $request->name,

            'start_date' => $request->start_date,

            'end_date'   => $request->end_date,

            'status'     => $request->status,

            'created_at' => Carbon::now(),

            'updated_at' => Carbon::now(),

        ]);

        Alert::success(
            'Success Academic Year',
            'Academic Year Created Successfully'
        );

        return back();
    }

    // Delete
    public function delete($id)
    {

        AcademicYears::findOrFail($id)->delete();

        Alert::success(
            'Success Academic Year',
            'Academic Year Deleted Successfully'
        );

        return back();

    }

    // Update Page
    public function updatePage($id)
    {

        $academicYear = AcademicYears::findOrFail($id);

        return view(
            'admin.academicYear.update',
            compact('academicYear')
        );

    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required',
        ]);

        $academicYear = AcademicYears::findOrFail($id);

        $academicYear->update([
            'name'       => $request->name,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status,
        ]);

        Alert::success('Success', 'Academic Year Updated Successfully');

        return redirect()->route('academicYear.list');
    }

    // Validation
    private function checkValidation($request, $id = null)
    {

        $request->validate([

            'name'       =>
            'required|unique:academic_years,name,' . $id,

            'start_date' =>
            'required|date',

            'end_date'   =>
            'required|date|after:start_date',

            'status'     =>
            'required|in:Active,Inactive',

        ]);

    }

}
