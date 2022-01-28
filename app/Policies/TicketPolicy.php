<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /*
    For admin allow all action
     */
    public function isAdmin($user){
        if ($user->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function isNotAdmin($user){
        if ($user->role != 'admin') {
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

    public function isNotuser($user){
        if ($user->role != 'user') {
            return true;
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
        
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        $dep = $user->departments()->pluck('department_id')->toArray();
        //dd($ticket->opened_user_id);exit;
        if (empty($user->id)) {
            return false;
        }
        if ($user->role == "admin") {
            return true;
        }elseif($ticket->opened_user_id == $user->id) {
            return true;
        }elseif ($user->role == "staff" && in_array($ticket->department_id, $dep)) {
            return true;
        }elseif ($user->id ==  $ticket->ticket_user_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return mixed
     */
    public function restore(User $user, Ticket $ticket)
    {
        
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return mixed
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        
    }
}
