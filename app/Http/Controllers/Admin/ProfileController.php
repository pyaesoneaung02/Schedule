<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //direct change password page
    public function changePasswordPage(){
        return view('admin.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);

        $currentLoginPassword = auth()->user()->password;

        if(Hash::check($request->oldPassword, $currentLoginPassword)){
            User::where('id', auth()->user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            Alert::success('Success ChangePassword', 'Password Changed Successfully');

            return to_route('adminHome');

            //direct logout
            // Auth::logout();
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
            // return redirect('/');

        }else{
            Alert::error('Error Message', 'Old Password Do Not Match! | Try Again...');
            return back();
        }

    }

    //direct profile page
    public function accountProfile(){
        return view('admin.profile.accountProfile');
    }

    //direct edit profile page
    public function editProfile(){
        return view('admin.profile.edit');
    }

    //update profile
    public function updateProfile(Request $request)
    {
        $this->profileValidationCheck($request);

        $data = $this->requestProfileData($request);

        if ($request->hasFile('image')) {

            // Delete old image
            if (Auth::user()->profile != null) {
                if (file_exists(public_path('profile/' . Auth::user()->profile))) {
                    unlink(public_path('profile/' . Auth::user()->profile));
                }
            }

            // Store new image
            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('profile'), $fileName);

            $data['profile'] = $fileName;

        } else {
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id', Auth::id())->update($data);

        Alert::success('Success Profile', 'Profile Changed Successfully');

        return to_route('profile.accountProfile');
    }

    //create new admin account
    public function createNewAdminAccount(){
        return view('admin.adminAccount.create');
    }

    //crate admin account
    public function createAdminAccount(Request $request){
        $this->checkNewAdminAccountValidation($request);
        $data = $this->requestAdminAccountData($request);

        User::create($data);

        Alert::success('Success Account', 'Account Created Successfully');
        return to_route('profile.adminList');
    }

    //admin account list
    public function adminList(){
        $admin = User::select('id', 'name', 'email', 'address', 'phone', 'role', 'created_at')
                ->whereIn('role', ['admin','superadmin'])
                ->when( request('searchKey'), function($query){
                $query->whereAny( ['name','email','address','phone','role'],'like', '%' . request('searchKey') . '%');
            })
            ->paginate(5);
            // ->get();
        return view('admin.adminAccount.list',compact('admin'));
    }

    //admin account delete
    public function delete($id){
        User::where('id',$id)->delete();

        Alert::success('Success Account Delete', 'Account Deleted Successfully');
        return back();
    }

     //change password validation check
    private function passwordValidationCheck($request){
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:15',
            'confirmPassword' => 'required|same:newPassword|min:6|max:15'
        ]);
    }

    //request user profile data
    private function requestProfileData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }

    //change profile validation check
    private function profileValidationCheck($request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|min:8|max:15|unique:users,phone,' . Auth::user()->id,
            // 'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg,jfif,svg|file'
        ]);
    }

    //request new admin account validation
    private function requestAdminAccountData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin' // if user change 'role' => 'user'
            ];
    }

    //check new admin account validation
    private function checkNewAdminAccountValidation($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:15',
            'confirmPassword' => 'required|same:password|min:6|max:15'
            ]);
    }
}
