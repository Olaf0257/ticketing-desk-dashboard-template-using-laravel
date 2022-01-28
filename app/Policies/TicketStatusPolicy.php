<?php

namespace App\Policies;

use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Permission;

class TicketStatusPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $permission = Permission::where('name', 'ticket_status_management')
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

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TicketStatus  $ticketStatus
     * @return mixed
     */
    public function view(User $user, TicketStatus $ticketStatus)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TicketStatus  $ticketStatus
     * @return mixed
     */
    public function update(User $user, TicketStatus $ticketStatus)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TicketStatus  $ticketStatus
     * @return mixed
     */
    public function delete(User $user, TicketStatus $ticketStatus)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TicketStatus  $ticketStatus
     * @return mixed
     */
    public function restore(User $user, TicketStatus $ticketStatus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TicketStatus  $ticketStatus
     * @return mixed
     */
    public function forceDelete(User $user, TicketStatus $ticketStatus)
    {
        //
    }
}
