<?php
namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Major;
use App\Models\Room;
use App\Models\Sections;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\Year;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TeachingController extends Controller
{

    // Create page
    public function create()
    {
        $academicYears = AcademicYears::all();
        $semesters     = Semesters::all();
        $sections      = Sections::all();
        $teachers      = Teacher::all();

        $years    = Year::all();
        $majors   = Major::all();
        $rooms    = Room::all();
        $subjects = Subject::all();

        return view(
            'admin.teaching_classes.create',
            compact(
                'academicYears',
                'semesters',
                'sections',
                'teachers',
                'years',
                'majors',
                'rooms',
                'subjects'
            )
        );
    }

    // Store teaching class
    public function createTeaching(Request $request)
    {
        $this->checkValidationTeaching($request);

        Teaching::create(
            $this->getTeachingData($request)
        );

        Alert::success(
            'Success',
            'Teaching Created Successfully'
        );

        return back();
    }

    // Update page
    public function updatePage($id)
    {
        $academicYears = AcademicYears::all();
        $semesters     = Semesters::all();
        $sections      = Sections::all();
        $teachers      = Teacher::all();

        $years    = Year::all();
        $majors   = Major::all();
        $rooms    = Room::all();
        $subjects = Subject::all();

        $teaching = Teaching::findOrFail($id);

        return view(
            'admin.teaching_classes.edit',
            compact(
                'teaching',
                'academicYears',
                'semesters',
                'sections',
                'teachers',
                'years',
                'majors',
                'rooms',
                'subjects'
            )
        );
    }

    // Update process
    public function update(Request $request, $id)
    {
        $this->checkValidationTeaching($request);

        Teaching::where('id', $id)
            ->update(
                $this->getTeachingData($request)
            );

        Alert::success(
            'Success',
            'Teaching Updated Successfully'
        );

        return to_route('teaching.list');
    }

    // Delete
    public function delete($id)
    {
        Teaching::findOrFail($id)->delete();

        Alert::success(
            'Success',
            'Teaching Deleted Successfully'
        );

        return back();
    }

    // Map request data
    private function getTeachingData($request)
    {
        return [
            'academic_year_id' => $request->academicYearID,
            'semester_id'      => $request->semesterID,
            'teacher_id'       => $request->teacherID,
            'year_id'          => $request->yearID,
            'major_id'         => $request->majorID,
            'room_id'          => $request->roomID,
            'subject_id'       => $request->subjectID,
            'section_id'       => $request->sectionID,
        ];
    }

    // Validation
    public function checkValidationTeaching($request)
    {
        $request->validate([
            'academicYearID' => 'required',
            'semesterID'     => 'required',
            'teacherID'      => 'required',
            'yearID'         => 'required',
            'majorID'        => 'required',
            'roomID'         => 'required',
            'subjectID'      => 'required',
            'sectionID'      => 'required',
        ]);
    }

    // List teaching classes with search, filter, pagination, and total count per year
    public function list(Request $request)
    {
        $query = Teaching::select(
            'teachings.id',
            'teachings.academic_year_id',
            'teachings.semester_id',
            'teachings.teacher_id',
            'teachings.year_id', // Required for counting teachings per year
            'teachings.major_id',
            'teachings.room_id',
            'teachings.subject_id',
            'teachings.section_id',
            'academic_years.name as academic_year_name',
            'semesters.name as semester_name',
            'teachers.name as teacher_name',
            'years.name as year_name',
            'majors.name as major_name',
            'rooms.name as room_name',
            'subjects.short_name as subject_short_name',
            'sections.name as section_name'
        )
        ->leftJoin('academic_years', 'teachings.academic_year_id', '=', 'academic_years.id')
        ->leftJoin('semesters', 'teachings.semester_id', '=', 'semesters.id')
        ->leftJoin('teachers', 'teachings.teacher_id', '=', 'teachers.id')
        ->leftJoin('years', 'teachings.year_id', '=', 'years.id')
        ->leftJoin('majors', 'teachings.major_id', '=', 'majors.id')
        ->leftJoin('rooms', 'teachings.room_id', '=', 'rooms.id')
        ->leftJoin('subjects', 'teachings.subject_id', '=', 'subjects.id')
        ->leftJoin('sections', 'teachings.section_id', '=', 'sections.id');

        // Search Teacher Name or Subject Short Name
        if ($request->has('searchKey') && !empty($request->searchKey)) {
            $search = $request->searchKey;
            $query->where(function($q) use ($search) {
                $q->where('teachers.name', 'like', '%' . $search . '%')
                  ->orWhere('subjects.short_name', 'like', '%' . $search . '%');
            });
        }

        // Filter by Year
        if ($request->has('year') && !empty($request->year)) {
            $query->where('teachings.year_id', $request->year);
        }

        // Paginate results
        $teachings = $query->orderBy('teachings.created_at', 'desc')->paginate(10)->withQueryString();

        // Calculate and append the total number of teachings for each year regardless of pagination
        $teachings->getCollection()->transform(function ($item) {
            $item->total_year_teachings = Teaching::where('year_id', $item->year_id)->count();
            return $item;
        });

        // Fetch all years for the filter buttons
        $years = Year::all();

        return view(
            'admin.teaching_classes.list',
            compact('teachings', 'years')
        );
    }
}