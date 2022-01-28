<?php

namespace App\Helpers;

use App\Models\Ticket;
use App\Models\User;

class TicketHelper
{
    public static function isStaffReply($user, $ticket)
    {
        if (empty($user)) {
            return false;
        }

        if ((in_array($user->role, config('roles.staff')))) {
            if (!empty($ticket->ticketUser) && !empty($ticket->ticketUser->email)) {
                return true;
            }
        }
        return false;
    }
}
