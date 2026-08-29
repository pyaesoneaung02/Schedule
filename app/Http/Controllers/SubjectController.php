<?php
namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Major;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $years         = Year::all();
        $majors        = Major::all();
        $academicYears = AcademicYears::all();
        $semesters     = Semesters::all();

        return view(
            'admin.subject.create',
            compact(
                'years',
                'majors',
                'academicYears',
                'semesters'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE SUBJECT
    |--------------------------------------------------------------------------
    */

    public function createSubject(Request $request)
    {
        $this->checkValidationSubject($request);

        $subjectData = $this->getSubjectData($request);

        Subject::create($subjectData);

        Alert::success(
            'Success Subject',
            'Subject Created Successfully'
        );

        return redirect()->route('subject.list');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PAGE
    |--------------------------------------------------------------------------
    */

    public function updatePage($id)
    {
        $years         = Year::all();
        $majors        = Major::all();
        $academicYears = AcademicYears::all();
        $semesters     = Semesters::all();

        $subject = Subject::findOrFail($id);

        return view(
            'admin.subject.edit',
            compact(
                'subject',
                'years',
                'majors',
                'academicYears',
                'semesters'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SUBJECT
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $this->checkValidationSubject($request);

        $subject = Subject::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Prepare update data
        |--------------------------------------------------------------------------
        */

        $subjectData = $this->getSubjectData(
            $request,
            $subject
        );

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $subject->update($subjectData);

        Alert::success(
            'Success Subject',
            'Subject Updated Successfully'
        );

        return redirect()->route('subject.list');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBJECT DATA
    |--------------------------------------------------------------------------
    */

    private function getSubjectData(
        Request $request,
        ?Subject $subject = null
    ) {

        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        $image = $subject?->image;

        /*
        |--------------------------------------------------------------------------
        | New image uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $imageName = time() . '_' . uniqid() . '.' .
            $request->file('image')->extension();

            $request->file('image')->move(
                public_path('images/subjects'),
                $imageName
            );

            $image = 'images/subjects/' . $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Return data
        |--------------------------------------------------------------------------
        */

        return [

            'image'            => $image,

            'long_name'        => $request->longName,

            'short_name'       => $request->shortName,

            'description'      => Purifier::clean(
                $request->description
            ),

            'time_number'      => $request->timeNumber,

            'year_id'          => $request->yearID,

            'major_id'         => $request->majorID,

            'academic_year_id' => $request->academicID,

            'semester_id'      => $request->semesterID,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    public function checkValidationSubject(Request $request)
    {
        $rules = [

            'image'       => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],

            'longName'    => [
                'required',
                'string',
                'max:255',
            ],

            'shortName'   => [
                'required',
                'string',
                'max:255',
            ],

            'timeNumber'  => [
                'required',
                'integer',
                'min:1',
            ],

            'description' => [
                'required',
                'string',
            ],

            'yearID'      => [
                'required',
                'integer',
            ],

            'majorID'     => [
                'required',
                'integer',
            ],

            'academicID'  => [
                'required',
                'integer',
            ],

            'semesterID'  => [
                'required',
                'integer',
            ],
        ];

        $messages = [

            'longName.required'    =>
            'Please enter Subject Name.',

            'shortName.required'   =>
            'Please enter Subject Code.',

            'timeNumber.required'  =>
            'Please enter One Week Teaching.',

            'timeNumber.integer'   =>
            'One Week Teaching must be a number.',

            'timeNumber.min'       =>
            'One Week Teaching must be at least 1.',

            'description.required' =>
            'Please enter Subject Description.',

            'yearID.required'      =>
            'Please select Year.',

            'majorID.required'     =>
            'Please select Major.',

            'academicID.required'  =>
            'Please select Academic Year.',

            'semesterID.required'  =>
            'Please select Semester.',

            'image.image'          =>
            'The selected file must be an image.',

            'image.max'            =>
            'Image size must not exceed 2MB.',
        ];

        $request->validate(
            $rules,
            $messages
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $subject = Subject::findOrFail($id);

        $subject->delete();

        Alert::success(
            'Success Subject',
            'Subject Deleted Successfully'
        );

        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | SUBJECT LIST
    |--------------------------------------------------------------------------
    */

    public function list(Request $request)
    {
        $years = Year::all(); // Year Filter 

        $subjects = Subject::select(
            'subjects.id',
            'subjects.image',
            'subjects.long_name',
            'subjects.short_name',
            'subjects.time_number',
            'subjects.description',
            'subjects.year_id', // Required for counting subjects per year
            'subjects.major_id',
            'subjects.academic_year_id',
            'subjects.semester_id',
            'subjects.created_at',
            'years.name as year_name',
            'majors.name as major_name',
            'academic_years.name as academic_year_name',
            'semesters.name as semester_name'
        )
            ->leftJoin('years', 'subjects.year_id', '=', 'years.id')
            ->leftJoin('majors', 'subjects.major_id', '=', 'majors.id')
            ->leftJoin('academic_years', 'subjects.academic_year_id', '=', 'academic_years.id')
            ->leftJoin('semesters', 'subjects.semester_id', '=', 'semesters.id')
            // Year Filter 
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->where('subjects.year_id', $request->year);
            })
            // Search Key 
            ->when($request->filled('searchKey'), function ($query) {
                $search = request('searchKey');
                $query->where(function ($q) use ($search) {
                    $q->where('subjects.long_name', 'like', "%{$search}%")
                      ->orWhere('subjects.short_name', 'like', "%{$search}%")
                      ->orWhere('subjects.time_number', 'like', "%{$search}%")
                      ->orWhere('years.name', 'like', "%{$search}%")
                      ->orWhere('majors.name', 'like', "%{$search}%")
                      ->orWhere('academic_years.name', 'like', "%{$search}%")
                      ->orWhere('semesters.name', 'like', "%{$search}%");
                });
            })
            ->orderBy('subjects.created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); 

        // Calculate and append the total number of subjects for each year regardless of pagination
        $subjects->getCollection()->transform(function ($item) {
            $item->total_year_subjects = Subject::where('year_id', $item->year_id)->count();
            return $item;
        });

        return view('admin.subject.list', compact('subjects', 'years'));
    }
}