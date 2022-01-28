<?php

namespace App\Models\Services;
use Carbon\Carbon;

use App\Models\ImapTicket;
use App\Models\User;
use App\Helpers\Uuid;
use App\Helpers\Logger;
use App\Models\ImapReply;
use App\Models\ImapTicketNote;
use App\Models\ImapTicketInternalNote;
use App\Models\ImapReplyAttachment;
use App\Models\ImapTicketStatusLife;
use App\Services\Email;

class ImapTicketService
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
            $tickets = ImapTicket::orderBy('staff_unread', 'DESC')
                ->orderBy('last_touched_at', 'DESC')
                ->paginate(10);

            return $tickets;
        }
    }

    /*
    Get imap tickets by filter
    */
    public function getFilteredTickets($user, $request, $dep)
    {
        if (empty($user)) {
            return;
        }
        if ((in_array($user->role, config('roles.staff')))) {
            // Querying imap tickets
            $query = ImapTicket::query();
            if ($user->role == "staff") {
                $query->orderBy('staff_unread', 'DESC');
            }
            $query->orderBy('last_touched_at', 'DESC');
            
            if ($request->search) {
                $query->where('tid', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%');
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
            if ($user->role == "staff") {
                $query->whereIn('department_id', $dep);
            }
            if ($request->tag_ids) {
                $tags = explode(",", $request->tag_ids);
                foreach ($tags as $tag){
                    $query->whereHas('tags', function ($items) use ($tag){
                    $items->where('tag_uuid', $tag);
                    });
                }
                
            }

            $imap_tickets = $query;
            return $imap_tickets;
        }
    }

    public function assignedToMe($user, $request)
    {
        if (empty($user)) {
            return;
        }
        if ((in_array($user->role, config('roles.staff')))) {

            $query = ImapTicket::query();
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
    Add reply  through Email to database
    */
    public function addEmailReply($ticket, $email, $from_name, $to_address)
    {
        $ticketReply = new ImapReply();
        $ticketReply->uuid = Uuid::getUuid();
        $ticketReply->imap_ticket_uuid = $ticket->uuid;
        $ticketReply->replied_to = $to_address;
        $ticketReply->replied_user_name = $from_name;
        if (empty($email['message'])) {
            $ticketReply->message = "" ;
        } else {
            $ticketReply->message = $email['message'];
        }
        $ticketReply->save();

        // Check for attachments in reply
        $attachments = $email['attachments'];
        if (count($attachments) > 0) {
            Logger::info("This mail has attahment");
            foreach ($attachments as $attachment) {
                Logger::info("attachment name ." . $attachment['filename']);
                // Set storage path and name to attachments
                $localFile = storage_path("app/attachments/" . $attachment['filename']);
                file_put_contents($localFile, $attachment['content']);

                    $ticketAttachment = new ImapReplyAttachment();
                    $ticketAttachment->name = $attachment['filename'];
                    $ticketAttachment->uuid = Uuid::getUuid();
                    $ticketAttachment->imap_reply_uuid = $ticketReply->uuid;
                    $ticketAttachment->save();

                    return $ticketAttachment;
            }
        }
        return $ticketReply;
    }

    /*
    Add Reply to Imap tickets
    */
    public function addTicketReply($user, $ticket, $reply)
    {
        $ticketReply = new ImapReply();
        $ticketReply->uuid = Uuid::getUuid();
        $ticketReply->imap_ticket_uuid = $ticket->uuid;
        $ticketReply->replied_staff_id = $user->id;
        $ticketReply->replied_to = $ticket->from_email;
        $ticketReply->replied_user_name = $user->name;
        $ticketReply->message = $reply;
        $ticketReply->save();

        return $ticketReply;
    }

    // Add ticket private notes
    public function addTicketNote($user, $ticket, $note)
    {
        $ticketNote = new ImapTicketNote();
        $ticketNote->uuid = Uuid::getUuid();
        $ticketNote->imap_ticket_uuid = $ticket->uuid;
        $ticketNote->note_staff_id = $user->id;
        $ticketNote->message = $note;
        $ticketNote->save();
    }

    // Add ricket internal notes
    public function addInternalTicketNote($user, $ticket, $note)
    {
        $internalTicketNote = new ImapTicketInternalNote();
        $internalTicketNote->uuid = Uuid::getUuid();
        $internalTicketNote->imap_ticket_uuid = $ticket->uuid;
        $internalTicketNote->note_staff_id = $user->id;
        $internalTicketNote->message = $note;
        $internalTicketNote->save();
    }

    // Set tcket unread when modifying ticket
    public function modifyTicketUnread($ticket, $request)
    {
        if ($ticket->department_id  != $request->department_id) {
            $ticket->staff_unread = 1;
            // $ticket->user_unread = 0;
        }
        return $ticket;
    }

    public function ticketStatusLife($ticket, $previous_status, $old_staff, $currentStatus)
    {
        if ($previous_status != $currentStatus) {

            $ticketStatusLife = new ImapTicketStatusLife();
            $ticketStatusLife->uuid = Uuid::getUuid();
            $ticketStatusLife->ticket_uuid = $ticket->uuid;
            $ticketStatusLife->previous_status_id = $previous_status;
            $ticketStatusLife->current_status_id = $currentStatus;
            $currentLifeStatus = ImapTicketStatusLife::where('ticket_uuid', $ticket->uuid)
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

    public function ticketCount($user, $dep)
    {
        $ticketCount = [];
        if (empty($user)) {
            return;
        }
        if ($user->role == "staff") {
            
            $ticketCount['total'] = ImapTicket::whereIn('department_id', $dep)->count();
            $ticketCount['status'] = ImapTicket::selectRaw('count(*) as total , ticket_status_id')
                ->whereIn('department_id', $dep)
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        } elseif ($user->role == "admin") {
            $ticketCount['total'] = ImapTicket::count();
            $ticketCount['status'] = ImapTicket::selectRaw('count(*) as total , ticket_status_id')
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        } elseif ($user->role == "user") {
            $ticketCount['total'] = ImapTicket::where('ticket_user_id', $user->id)
                ->count();
            $ticketCount['status'] = ImapTicket::selectRaw('count(*) as total , ticket_status_id')
                ->where('ticket_user_id', $user->id)
                ->groupBy('ticket_status_id')
                ->pluck('total', 'ticket_status_id')->all();
            return $ticketCount;
        }
    }
}
