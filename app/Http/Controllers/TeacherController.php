<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{

    // Create page
    public function create()
    {
        $positions   = Position::get();
        $departments = Department::get();

        return view('admin.teacher.create', compact(
            'positions',
            'departments'
        ));
    }

    // Create teacher
    public function createTeacher(Request $request)
    {
        $this->checkValidationTeacher($request);

        // Create User Account
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'teacher',
        ]);

        // Create Teacher Profile
        Teacher::create([
            'user_id'       => $user->id,
            'name'          => $request->name,
            'position_id'   => $request->positionID,
            'department_id' => $request->departmentID,
        ]);

        Alert::success(
            'Success Teacher',
            'Teacher Created Successfully'
        );

        return back();
    }

    // Update page
    public function updatePage($id)
    {
        $positions = Position::get();
        $departments = Department::get();
        $teacher = Teacher::where('id', $id)->first();

        return view(
            'admin.teacher.edit',
            compact(
                'teacher',
                'positions',
                'departments'
            )
        );
    }

    // Update teacher
    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        $request->validate([
            'name'         => 'required',
            'positionID'   => 'required',
            'departmentID' => 'required',
        ]);

        Teacher::where('id', $id)->update([
            'name'          => $request->name,
            'position_id'   => $request->positionID,
            'department_id' => $request->departmentID,
        ]);

        // Update user account
        if ($teacher->user) {
            $teacher->user->update([
                'name' => $request->name,
            ]);
        }

        Alert::success('Success Teacher', 'Teacher Updated Successfully');

        return to_route('teacher.list');
    }

    // Delete teacher
    public function delete($id)
    {
        $teacher = Teacher::find($id);

        if ($teacher->user) {
            $teacher->user->delete();
        }

        $teacher->delete();

        Alert::success(
            'Success Teacher',
            'Teacher Deleted Successfully'
        );

        return back();
    }

    // Validation rules and custom messages
    private function checkValidationTeacher($request)
    {
        $rules = [
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'positionID'   => 'required',
            'departmentID' => 'required',
        ];

        $messages = [
            'email.unique'       => 'Email already exists.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];

        $request->validate($rules, $messages);
    }

    // Teacher list page with search, filter, pagination, and total department count
    public function list(Request $request)
    {
        // Fetch all departments for the filter buttons
        $departments = Department::get();

        // Build query to retrieve teachers with related user, position, and department details
        $teachers = Teacher::select(
            'teachers.id',
            'teachers.name',
            'users.email',
            'positions.name as position_name',
            'departments.name as department_name',
            'teachers.department_id', // Required for counting teachers per department
            'teachers.created_at'
        )
            ->leftJoin('users', 'teachers.user_id', '=', 'users.id')
            ->leftJoin('positions', 'teachers.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'teachers.department_id', '=', 'departments.id')
            ->when($request->searchKey, function ($query) use ($request) {
                // Apply search filter across name, email, position, and department
                $query->where(function ($q) use ($request) {
                    $q->where('teachers.name', 'like', '%' . $request->searchKey . '%')
                      ->orWhere('users.email', 'like', '%' . $request->searchKey . '%')
                      ->orWhere('positions.name', 'like', '%' . $request->searchKey . '%')
                      ->orWhere('departments.name', 'like', '%' . $request->searchKey . '%');
                });
            })
            ->when($request->department, function ($query) use ($request) {
                // Filter by specific department if selected
                $query->where('teachers.department_id', $request->department);
            })
            ->orderBy('teachers.created_at', 'desc')
            ->paginate(10);

        // Calculate and append the total number of teachers for each department regardless of pagination
        $teachers->getCollection()->transform(function ($teacher) {
            $teacher->total_department_teachers = Teacher::where('department_id', $teacher->department_id)->count();
            return $teacher;
        });

        // Preserve all query parameters for pagination links
        $teachers->appends($request->all());

        return view(
            'admin.teacher.list',
            compact('teachers', 'departments')
        );
    }
}