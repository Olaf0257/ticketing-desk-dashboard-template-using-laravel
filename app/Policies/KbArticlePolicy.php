<?php

namespace App\Policies;

use App\Models\KbArticle;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class KbArticlePolicy
{
    public function isNotUser($user){
        $permission = Permission::where('name', 'knowledge_base_management')
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