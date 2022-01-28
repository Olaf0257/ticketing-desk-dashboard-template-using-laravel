<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Logger;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Services\UserService;

class UserController extends Controller
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
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        // Display user's list
        $users = User::where('role', 'user')
            ->paginate(10);
        $params = [
            'users' => $users,
            'request' => $request
        ];
        return view('users.index', $params);
    }

    public function create(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        return view('users.create');
    }

    public function store(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        try {

            $validator = Validator::make($request->all(), [
                   'name' => 'required',
                   'email' => 'required | unique:App\Models\User,email',
                   'password' => 'required|min:8',
                   'c_password'=> 'required|same:password'                     
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            } 
            /*
            Make an object for user,
            Add a user
            */
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->save();

            return redirect()->route('user.index')
                ->with('success', __('User created'));

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function edit(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        // Get the user
        $user = User::find($id);
        return view('users.edit', $user);
    }

    public function update(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        try {
            $validator = Validator::make($request->all(), [
                   'name' => 'required',
                   'email' => 'required',                   
            ]);
            
            // Get the user
            $user = User::find($id);
            // Update password

            $updateArray = [];
            $check = $request->old_password;
            if (isset($check))
            {
                // If old password is incorrect
                if (!Hash::check($check, $user->password)){
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

            // Update user
            $updateArray['name'] = $request->name;
            $updateArray['email'] = $request->email;          
            $user->update($updateArray);
            $user->departments()->sync($request->department);
            return redirect()->route('user.index')
                ->with('success', __('User updated'));
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function destroy($id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('viewUser', User::class);

        // Delete user
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')
            ->with('success', __('User deleted'));
    }
}



