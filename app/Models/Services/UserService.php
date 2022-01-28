<?php

namespace App\Models\Services;

use App\Models\User;
use App\Models\Department;
use App\Helpers\Uuid;
use Auth;

class UserService
{
    public function getUserByEmail()
    {
    }

    public function getStaffs()
    {
        // staff list
        $staffs = User::where('role', 'staff')
            ->get();
        return $staffs;
    }

    public function getDepartmentStaffs($department_id)
    {
        $department = Department::find($department_id);
        $staffs = $department->users;
        return $staffs;
    }

    public function isAdmin()
    {
        $user = User::find(auth()->id());
        if($user->role == "admin"){
            return true;
        }
        return false;
        
    }

    public function isStaff()
    {
        $user = User::find(auth()->id());
        if($user->role == "staff"){
            return true;
        }
        return false;
        
    }

    public function isUser()
    {
        $user = User::find(auth()->id());
        if($user->role == "user"){
            return true;
        }
        return false;
        
    }
}
