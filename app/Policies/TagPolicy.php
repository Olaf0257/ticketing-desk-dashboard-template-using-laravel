<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    public function isNotUser($user){
        $permission = Permission::where('name', 'tags_management')
            ->where('role', 'staff')
            ->value('status');
        if ($user->role != 'user') {
            if ($user->role == 'admin' || $permission == true)
            {
                return true;  
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}