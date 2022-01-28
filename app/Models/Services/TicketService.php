<?php

namespace App\Models\Services;
use Carbon\Carbon;

use App\Models\Ticket;
use App\Models\User;
use App\Helpers\Uuid;
use App\Models\TicketReply;
use App\Models\TicketNote;
use App\Models\TicketInternalNote;
use App\Models\TicketStatusLife;
use App\Models\Department;

class TicketService
{
    /*
    For admin allow all action
     */
    public function getTickets($user)
    {
        if (empty($user)) {
            return;
        }
        if ((in_array($user->role, config('roles.staff')))) {
            
            $tickets = Ticket::orderBy('staff_unread', 'DESC')
                ->orderBy('last_touched_at', 'DESC')
                ->paginate(10);

            return $tickets;
        } elseif ($user->role == "user") {
            $tickets = Ticket::where('ticket_user_id', $user->id)
                ->orderBy('user_unread', 'DESC')
                ->orderBy('last_touched_at', 'DESC')
                ->paginate(10);
            return $tickets;
        }
    }

    public function getFilteredTickets($user, $request, $dep)
    {
        if (empty($user)) {
            return;
        }
        if ($user->role == "staff") {

            $query = Ticket::query();
            $query->orderBy('staff_unread', 'DESC');
            $query->orderBy('last_touched_at', 'DESC');

            if ($request->search) {
                $query->where('tid', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            }
            if ($request->ticket_urgency_id) {
                $query->where('ticket_urgency_id', $request->ticket_urgency_id);
            }
            if ($request->ticket_status_id) {
                $query->where('ticket_status_id', $request->ticket_status_id);
            }

            if ($request->assigned_to) {
                $query->where('assigned_to', $request->assigned_to);
            }
            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }
            if ($request->tag_ids) {
                $tags = explode(",", $request->tag_ids);
                foreach ($tags as $tag){
                    $query->whereHas('tags', function ($items) use ($tag){
                    $items->where('tag_uuid', $tag);
                    });
                }
                
            }
            
            $query->whereIn('department_id', $dep);

            $tickets = $query;

            return $tickets;
        } elseif ($user->role == "admin") {

            $query = Ticket::query();
            $query->orderBy('last_touched_at', 'DESC');

            if ($request->search) {
                $query->where('tid', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            }
            if ($request->ticket_urgency_id) {
                $query->where('ticket_urgency_id', $request->ticket_urgency_id);
            }
            if ($request->ticket_status_id) {
                $query->where('ticket_status_id', $request->ticket_status_id);
            }

            if ($request->assigned_to) {
                $query->where('assigned_to', $request->assigned_to);
            }
            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }
            if ($request->tag_ids) {
                $tags = explode(",", $request->tag_ids);
                foreach ($tags as $tag){
                    $query->whereHas('tags', function ($items) use ($tag){
                    $items->where('tag_uuid', $tag);
                    });
                }
                
            }

            $tickets = $query;

            return $tickets;
        } elseif ($user->role == "user") {
            $query = Ticket::query();
            $query->orderBy('user_unread', 'DESC');
            $query->orderBy('last_touched_at', 'DESC');
            $query->where('ticket_user_id', $user->id);
            if ($request->search) {
                $search = $request->search;
                $query = $query->whereHas('department', function ($items) use ($search){
                    $items->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('ticketUrgency', function ($items) use ($search){
                    $items->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('ticketStatus', function ($items) use ($search){
                    $items->where('title', 'like', '%' . $search . '%');
                })->orWhere('title', 'like', '%' . $search . '%')
                ->orWhere('tid', 'like', '%' . $search . '%');
            }
            
            $tickets = $query;
            return $tickets;
        }
    }

    public function myTickets($user, $request, $opened_user)
    {
        if (empty($user)) {
            return;
        }
        if ((in_array($user->role, config('roles.staff')))) {

            $query = Ticket::query();
            $query->orderBy('staff_unread', 'DESC');
            $query->orderBy('last_touched_at', 'DESC');

            if ($request->search) {
                $query->where('tid', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            }
            if ($request->ticket_urgency_id) {
                $query->where('ticket_urgency_id', $request->ticket_urgency_id);
            }
            if ($request->ticket_status_id) {
                $query->where('ticket_status_id', $request->ticket_status_id);
            }

            if ($request->assigned_to) {
                $query->where('assigned_to', $request->assigned_to);
            }
            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }
            if ($request->tag_ids) {
                $tags = explode(",", $request->tag_ids);
                foreach ($tags as $tag){
                    $query->whereHas('tags', function ($items) use ($tag){
                    $items->where('tag_uuid', $tag);
                    });
                }
                
            }

            $query->where('opened_user_id', $opened_user);

            $tickets = $query->paginate(10);
            return $tickets;
        }
    }

    public function assignedToMe($user, $request)
    {
        if (empty($user)) {
            return;
        }
        if ((in_array($user->role, config('roles.staff')))) {

            $query = Ticket::query();
            $query->orderBy('staff_unread', 'DESC');
            $query->orderBy('last_touched_at', 'DESC');
            if ($request->search) {
                $query->where('tid', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            }
            if ($request->ticket_urgency_id) {
                $query->where('ticket_urgency_id', $request->ticket_urgency_id);
            }
            if ($request->ticket_status_id) {
                $query->where('ticket_status_id', $request->ticket_status_id);
            }

            if ($request->assigned_to) {
                $query->where('assigned_to', $request->assigned_to);
            }
            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }
            if ($request->tag_ids) {
                $tags = explode(",", $request->tag_ids);
                foreach ($tags as $tag){
                    $query->whereHas('tags', function ($items) use ($tag){
                    $items->where('tag_uuid', $tag);
                    });
                }
                
            }

            $query->where('assigned_to', $user->id);
            $tickets = $query->paginate(10);

            return $tickets;
        }
    }

    /*
    function to add reply to tickets
    */
    public function addTicketReply($user, $ticket, $reply)
    {
        $ticketReply = new TicketReply();
        $ticketReply->uuid = Uuid::getUuid();
        $ticketReply->ticket_uuid = $ticket->uuid;
        $ticketReply->replied_user_id = $user->id;
        $ticketReply->message = $reply;
        $ticketReply->save();

        return $ticketReply;
    }

    /*
    function to add private notes
    */
    public function addTicketNote($user, $ticket, $note)
    {
        $ticketNote = new TicketNote();
        $ticketNote->uuid = Uuid::getUuid();
        $ticketNote->ticket_uuid = $ticket->uuid;
        $ticketNote->note_user_id = $user->id;
        $ticketNote->message = $note;
        $ticketNote->save();
    }

    /*
    function to add internal notes
    */
    public function addInternalTicketNote($user, $ticket, $note)
    {
        $internalTicketNote = new TicketInternalNote();
        $internalTicketNote->uuid = Uuid::getUuid();
        $internalTicketNote->ticket_uuid = $ticket->uuid;
        $internalTicketNote->note_user_id = $user->id;
        $internalTicketNote->message = $note;
        $internalTicketNote->save();
    }

    // Ticket unread functon
    public function setTicketUnread($ticket, $role)
    {
        if ($role == 'user') {
            $ticket->staff_unread = 1;
            $ticket->user_unread = 0;
        } elseif ($role  == 'staff') {
            $ticket->staff_unread = 0;
            $ticket->user_unread = 1;
        }
        return $ticket;
    }

    // Set ticket read function
    public function setTicketRead($ticket, $role)
    {
        if ($role == 'user') {
            $ticket->user_unread = 0;
        } elseif ($role  == 'staff') {
            $ticket->staff_unread = 0;
        }
        return $ticket;
    }

    /*
    Set ticket unread while modifying department
    */
    public function modifyTicketUnread($ticket, $request)
    {
        if ($ticket->department_id  != $request->department_id) {
            $ticket->staff_unread = 1;
            $ticket->user_unread = 0;
        }
        return $ticket;
    }

    /** 
     * Ticket count by status
    */ 
    public function ticketCount($user, $dep)
    {
        $ticketCount = [];
        if (empty($user)) {
            return;
        }
        if ($user->role == "staff") {
            
            $ticketCount['total'] = Ticket::whereIn('department_id', $dep)->count();
            $ticketCount['status'] = Ticket::selectRaw('count(*) as total , ticket_status_id')
                ->whereIn('department_id', $dep)
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        } elseif ($user->role == "admin") {
            $ticketCount['total'] = Ticket::count();
            $ticketCount['status'] = Ticket::selectRaw('count(*) as total , ticket_status_id')
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        } elseif ($user->role == "user") {
            $ticketCount['total'] = Ticket::where('ticket_user_id', $user->id)
                ->count();
            $ticketCount['status'] = Ticket::selectRaw('count(*) as total , ticket_status_id')
                ->where('ticket_user_id', $user->id)
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        }
    }

    public function ticketStatusLife($ticket, $previous_status, $old_staff, $currentStatus)
    {
        if ($previous_status != $currentStatus) {

            $ticketStatusLife = new TicketStatusLife();
            $ticketStatusLife->uuid = Uuid::getUuid();
            $ticketStatusLife->ticket_uuid = $ticket->uuid;
            $ticketStatusLife->previous_status_id = $previous_status;
            $ticketStatusLife->current_status_id = $currentStatus;
            $currentLifeStatus = TicketStatusLife::where('ticket_uuid', $ticket->uuid)
                ->latest()->first();

            if ($currentLifeStatus) {
                $previous_time = Carbon::parse($currentLifeStatus->created_at);
            } else {
                $previous_time = Carbon::parse($ticket->created_at);
            }
            $current_time = Carbon::now();
            $totalDuration = $current_time->diffInSeconds($previous_time);
            $ticketStatusLife->life_time = $totalDuration;
            $ticketStatusLife->assigned_to = $old_staff;
            $ticketStatusLife->save();
        }
        
    }
}
