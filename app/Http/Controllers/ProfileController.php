<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\UserDepartment;
use Illuminate\Support\Facades\Hash;
use App\Models\Services\UserService;

class ProfileController extends Controller
{
    public function __construct()
    {
        /*
        make sure only logged in and verified user has access
        to this controller
        */
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        // get the logged in user
        $user = auth()->user();
        // get the departments of logged in user
        $selected_department = $user->departments()->pluck('department_id')->toArray();
        $departments = Department::all();
        // Display the profile page
        $param = [
            'departments' => $departments,
            'selected_department' => $selected_department,
        ];
        if ($user->role == 'user'){
            return view('profile.user-profile', $user, $param);
        } else {
            return view('profile.staff-profile', $user, $param);
        }
    }

    public function update(Request $request)
    {
        try {
            // get the logged in user
            $user = auth()->user();
            $validator = Validator::make($request->all(), [
                   'name' => 'required',
                   'email' => 'required | unique:App\Models\User,email,'.$user->id,
            ]);

            /*
            Update password
            */
            $updateArray = [];
            $check = $request->old_password;
            if (isset($check)) {
                // If old password is incorrect
                if (!Hash::check($check, $user->password)) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', __('Please check your password'));

                // If old password is correct
                } elseif (Hash::check($check, $user->password)) {
                    $validator = Validator::make($request->all(), [
                        'password' => 'required|min:8',
                        'c_password'=> 'required|same:password'
                ]);
                    $updateArray['password'] = Hash::make($request->password);
                }
            }
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            // update profile
            $updateArray['name'] = $request->name;
            if ($user->role == 'admin'){
                $updateArray['email'] = $request->email;
            }
            $user->update($updateArray);
            return redirect()->back()
                ->with('success', __('Profile updated'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }
}
