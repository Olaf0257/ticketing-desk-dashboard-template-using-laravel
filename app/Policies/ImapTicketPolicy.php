<?php

namespace App\Policies;

use App\Models\ImapTicket;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImapTicketPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $imap_enable = Setting::where('id', 1)->first();
        if ($user->role != 'user' && $imap_enable->value == "1") {
            return true;
        } else {
            return false;
        }
    }

    public function isStaff($user){
        if ($user->role == 'staff') {
            return true;
        } else {
            return false;
        }
    }
}
