<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DB;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Models\TicketUrgency;
use App\Models\Department;
use App\Models\Tag;
use App\Models\User;
use App\Models\TicketInternalNote;
use App\Models\Setting;
use App\Helpers\Uuid;
use App\Helpers\Random;
use App\Helpers\TicketHelper;
use App\Mail\TicketOpened;
use App\Mail\TicketReplyAdded;
use App\Models\Services\TicketService;
use App\Models\Services\UserService;
use App\Helpers\Logger;
use App\Helpers\AttachmentHelper;
use App\Models\TicketAttachment;
use App\Models\TicketReplyAttachment;
use App\Models\TicketStatusLife;
use App\Services\Email;
use Illuminate\Support\Facades\Storage;
use Auth;

class TicketController extends Controller
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
        // get the logged in user
        $user = User::find(auth()->id());
        // Get all departments of the logged in user
        $dep = $user->departments()->pluck('department_id')->toArray();
        /*
        Create an object of TicketService,
        TicketService has functions that inteact with the
        Ticket model
         */
        $ticketService = new TicketService();
        // get all ticket status
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // get all departments
        $department = Department::all();
        // service class that interact with the user model.
        $userService = new UserService();
        // get the staff list
        $staffs = $userService->getStaffs();
        /*
        Get tickets based on the filter option.
         */
        $tickets = $ticketService->getFilteredTickets($user, $request, $dep)->paginate(10);

        /*
        Tickets by status count.
         */
        $ticketCount = $ticketService->ticketCount($user, $dep);

        /*
        Display the tickets
         */
        $params = [
            'tickets' => $tickets,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department,
            'ticketCount' => $ticketCount
        ];
        if ($user->role == 'user'){
            return view('ticket/user.index', $params);
        } else {
            return view('ticket.index', $params);
        }
    }

    /*
    Get tickets based on ticket status.
    */
    public function ticketByStatus(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $dep = $user->departments()->pluck('department_id')->toArray();

        $ticketService = new TicketService();
        $ticketStatuses = TicketStatus::all();
        $ticketUrgency = TicketUrgency::all();
        $department = Department::all();
        $userService = new UserService();
        $staffs = $userService->getStaffs();

        $tickets = $ticketService->getFilteredTickets($user, $request, $dep)
            ->where('ticket_status_id', $id)->paginate(10);

        /*
        Tickets by status count.
         */
        $ticketCount = $ticketService->ticketCount($user, $dep);

        $params = [
            'tickets' => $tickets,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department,
            'ticketCount' => $ticketCount
        ];
        if ($user->role == 'user'){
            return view('ticket/user.ticket_by_status', $params);
        } else {
            return view('ticket.ticket_by_status', $params);
        }
    }

    /*
    Get tickets bopened by the logged in user.
    */
    public function myTicket(Request $request)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isStaff', Ticket::class);

        $user = User::find(auth()->id());
        $opened_user = $user->id;
        $ticketService = new TicketService();
        $ticketStatuses = TicketStatus::all();
        $ticketUrgency = TicketUrgency::all();
        $department = Department::all();
        $userService = new UserService();
        $staffs = $userService->getStaffs();

        $tickets = $ticketService->myTickets($user, $request, $opened_user);
        $params = [
            'tickets' => $tickets,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department
        ];
        return view('ticket.my_ticket', $params);
    }

    /*
    Get tickets assigned to the logged in user.
    */
    public function assignedToMe(Request $request)
    {
        $user = User::find(auth()->id());
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isStaff', Ticket::class);

        $ticketService = new TicketService();
        $ticketStatuses = TicketStatus::all();
        $ticketUrgency = TicketUrgency::all();
        $department = Department::all();
        $userService = new UserService();
        $staffs = $userService->getStaffs();

        $tickets = $ticketService->assignedToMe($user, $request);

        $params = [
            'tickets' => $tickets,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department,
        ];
        return view('ticket.tickets_assigned_me', $params);
    }

    public function create(Request $request)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isNotAdmin', Ticket::class);

        // Get all departments
        $department = Department::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // get all users with user role
        $users = User::where('role', 'user')
               ->get();
        // get the logged in user
        $user = User::find(auth()->id());
        // Display open ticket page
        $params = [
            'department' => $department,
            'ticketUrgency' => $ticketUrgency,
            'users' => $users,
            'user_id' => $user->id,
            'role' => $user->role,
        ];
        if ($user->role == 'user'){
            return view('ticket/user.create', $params);
        } else {
            return view('ticket.create', $params);
        }
    }

    public function store(Request $request)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isNotAdmin', Ticket::class);

        try {

            // get the logged in user
            $user = User::find(auth()->id());
            if ($user->role == 'staff' && empty($request->ticket_user_id)){
                return redirect()->back()
                ->with('error', __('Add a user first'));
            }
            $ticketService = new TicketService();
            $validator = Validator::make($request->all(), [
                   'title' => 'required',
                   'message' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            // save ticket to database
            $ticket = new Ticket();
            $ticket->uuid = Uuid::getUuid();
            $ticket->ticket_user_id = $request->ticket_user_id;
            $ticket->department_id = $request->department_id;
            $ticket->ticket_urgency_id = $request->ticket_urgency_id;
            $ticket->opened_user_id = $user->id;
            $ticket->title = $request->title;
            $ticket->message = $request->message;
            $ticket->last_touched_at = Carbon::now()->format('Y-m-d H:i:s');

            /*
            Set ticket unread to the ticket
            */
            $ticket = $ticketService->setTicketUnread($ticket, Auth::user()->role);
            // Get allowed attachment extensions
            $extension = Setting::where('id', 2)->value('value');
            // Check for attachments
            if ($request->hasFile('attachments')) {
                $validator = Validator::make($request->all(), [
                    'attachments.*' => "required|mimes:$extension"
                ]);
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', __('Invalid file format'));
                }
            }
            $ticket->save();

            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');

                // Set attachment name store to database
                $attachmentHelper = new AttachmentHelper();
                $storedFilenames = $attachmentHelper->privateStore($files, 'attachments');
                foreach ($storedFilenames as $fileName) {
                    $attachment = new TicketAttachment();
                    $attachment->name = $fileName;
                    $attachment->uuid = Uuid::getUuid();
                    $attachment->ticket_uuid = $ticket->uuid;
                    $attachment->save();
                }
            }


            $emailService = new Email();
            // Sent ticket opened mail to user's Email
            if (!empty($ticket->ticketUser) && !empty($ticket->ticketUser->email)) {
                $emailService->ticketOpened($ticket);
            }

            // Sent ticket opened mail to staffs under the ticket department
            $emailService->departmentEmail($ticket, $request->department_id);

            return redirect()->route('ticket.index')
                ->with('success', __('Ticket created'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function show($uuid)
    {
        $statuses = TicketStatus::all();
        $statusLife = TicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
            ->where('ticket_uuid', $uuid)
            ->groupBy('previous_status_id')
            ->pluck('total', 'previous_status_id')->all();
        $ticket = Ticket::find($uuid);
        $params = [
            'statuses' => $statuses,
            'statusLife' => $statusLife,
            'ticket' => $ticket
        ];
        return view('ticket.show', $params);
    }

    public function reply(Request $request, $uuid)
    {

        // get the logged in user
        $user = auth()->user();
        // Get the ticket
        $ticket = Ticket::find($uuid);
        // get all ticket status
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();

        /*
        Check weather the user has access to this function
        */
        if (!$user->can('view', $ticket)) {
            return view('ticket.no_ticket');
        }

        if ($request->isMethod('POST')) {

            //if modifying the ticket
            if ($request->action && $request->action == "modify_ticket") {
                /*
                TODO: one confusion here.
                Are we using this for ticket modify ?
                If so why we need the modify function ?
                 */
                // $validator = Validator::make($request->all(), [
                //     'title' => 'required',
                //     'ticket_urgency_id' => 'required',
                //     'ticket_status_id' => 'required',
                // ]);
                // if ($validator->fails()) {
                //     $errors = $validator->errors()->first();
                //     return redirect()
                //     ->back()
                //     ->withInput()
                //     ->withErrors($validator);
                // }
                // $ticket->title = $request->title;
                // $ticket->ticket_urgency_id = $request->ticket_urgency_id;
                // $ticket->ticket_status_id = $request->ticket_status_id;
                // $ticket->save();
            } else {
                /*
                If replying to ticket
                */
                $validator = Validator::make($request->all(), [
                    'reply' => 'required'
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors()->first();
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
                }
            }

            $user = User::find(auth()->id());

            /*
            Check weather the ticket reply has attachments
            service class that interact with the Imapticket model.
            */
            $ticketService = new TicketService();
            if ($request->reply) {

                //ajax request

                // Get the allowed extensions
                // TODO: getting $extension should be from a function
                $extension = setting::where('id', 2)->value('value');
                if ($request->hasFile('attachments')) {
                    $validator = Validator::make($request->all(), [
                        'attachments.*' => "required|mimes:$extension"
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['error' => __('Invalid file format')], 400);
                    }
                }

                // Save ticket reply from TicketService
                $ticketReply = $ticketService->addTicketReply($user, $ticket, $request->reply);

                if ($request->hasFile('attachments')) {
                    $files = $request->file('attachments');
                    /*
                    Change the file name of attachment.
                    save attachment to database
                    */
                    $attachmentHelper = new AttachmentHelper();
                    $storedFilenames = $attachmentHelper->privateStore($files, 'attachments');
                    foreach ($storedFilenames as $fileName) {
                        $replyAttachment = new TicketReplyAttachment();
                        $replyAttachment->name = $fileName;
                        $replyAttachment->uuid = Uuid::getUuid();
                        $replyAttachment->ticket_reply_uuid = $ticketReply->uuid;
                        $replyAttachment->save();
                    }
                }

                $previous_status = $ticket->ticket_status_id;
                $old_staff = $ticket->assigned_to;
                $ticket->last_touched_at = Carbon::now()->format('Y-m-d H:i:s');
                // Change ticket status
                if ($user->role == 'staff'){
                    $ticket->ticket_status_id = 4;
                }elseif ($user->role == 'user'){
                    $ticket->ticket_status_id = 6;
                }
                $ticketService->ticketStatusLife($ticket, $previous_status, $old_staff, $ticket->ticket_status_id);
                /*
                set ticket unread.
                */
                $ticket = $ticketService->setTicketUnread($ticket, Auth::user()->role);
                $ticket->save();

                // Send ticket reply added mail to user's Email
                $emailService = new Email();
                if (TicketHelper::isStaffReply($user, $ticket)) {
                    $emailService->ticketReplyAdded($ticket);
                    $emailService->departmentStaffReply($ticket, $user);
                } else {
                    $emailService->departmentUserReply($ticket);
                }
                $emailService->assignedToReplyMail($ticket, $user->email);

                $request->session()->flash('success', __('Reply Added'));
                //TODO: Add language
                return response()->json(['message' => __('Reply Added')], 200);
            } else {
                $request->session()->flash('error', __('Please enter a reply'));
                return response()->json(['error' => __('Please enter a reply')], 400);
            }

        } else {
            /*
            set ticket read.
            */
            $ticketService = new TicketService();
            $ticket = $ticketService->setTicketRead($ticket, Auth::user()->role);
            $ticket->save();
        }
        // Display ticket replies
        $params = [
            'ticket' => $ticket,
            'ticket_reply' => $ticket->replies()->paginate(10),
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
        ];

        if ($user->role == 'user'){
            return view('ticket/user.reply', $params);
        } else {
            return view('ticket.reply', $params);
        }
    }


    /*
    TODO: We are uisng this methods?
    Or ticket modify too is going to reply function and uisng the action
    modify_ticket ?
     */
    public function modify(Request $request, $uuid)
    {
        // Get logged in user
        $user = auth()->user();
        // Get the ticket
        $ticket = Ticket::find($uuid);

        /*
        service class that interact with the Ticket model.
        */
        $ticketService = new TicketService();
        // Get all the ticket statuses
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // Get all of the user departments
        $departments = Department::all();
        // Get all of the tags
        $tags = Tag::all();
        $selected_tags = $ticket->tags()->pluck('uuid')->toArray();

        /*
        service class that interact with the User model.
        */
        $userService = new UserService();
        $department_id = $ticket->department_id;
        // Get staffs
        $staffs = $userService->getDepartmentStaffs($department_id);

        /*
        Check weather the user has access to this function
         */
        if (!$user->can('view', $ticket)) {
            return view('ticket.no_ticket');
        }

        if ($request->isMethod('POST')) {

            if ($request->action && $request->action == "modify_ticket") {
                $validator = Validator::make($request->all(), [
                            'title' => 'required',
                        ]);
                if ($validator->fails()) {
                    $errors = $validator->errors()->first();
                    return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors($validator);
                }
                $previous_status = $ticket->ticket_status_id;
                $previous_dpt = $ticket->department_id;
                $old_staff = $ticket->assigned_to;
                $ticket->title = $request->title;
                $emailService = new Email();
                if (!empty($request->ticket_urgency_id)){
                    $ticket->ticket_urgency_id = $request->ticket_urgency_id;
                }
                if (!empty($request->ticket_status_id)){
                    $ticket->ticket_status_id = $request->ticket_status_id;
                    $ticketService->ticketStatusLife($ticket, $previous_status, $old_staff, $request->ticket_status_id);
                }
                if (!empty($request->assigned_to)){
                    $ticket->assigned_to = $request->assigned_to;
                    if ($request->assigned_to != $old_staff) {
                       $emailService->assignedToEmail($ticket, $request->assigned_to);
                    }
                }
                if (!empty($request->department_id)){
                    $ticket->department_id = $request->department_id;
                    if ($request->department_id != $previous_dpt) {
                        // Sent ticket opened mail to staffs under the ticket department
                        $emailService->departmentEmail($ticket, $request->department_id);
                    }
                }
                // Set ticket unread
                $ticket = $ticketService->modifyTicketUnread($ticket, $request);
                $ticket->save();
                $tagIdArray = explode(",", $request->tag_ids);
                $ticket->tags()->sync($tagIdArray);
                return redirect()
                    ->route('ticket.index')
                    ->with('success', __('Ticket updated'));
                //  return response()->json($ticket ,200);

            }
        }
        // Display modify ticket page
        $params = [
            'ticket' => $ticket,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'staffs' => $staffs,
            'tags' => $tags,
            'departments' => $departments,
            'selected_tags' =>  $selected_tags,
        ];

        if ($user->role == 'user'){
            return view('ticket/user.modify', $params);
        } else {
            return view('ticket.modify', $params);
        }
    }

    /*
    Add private notes
    */
    public function note(Request $request, $uuid)
    {
        // Get logged in user
        $user = auth()->user();
        // Get the ticket
        $ticket = Ticket::find($uuid);

        /*
        Check weather the user has access to this function
         */
        if (!$user->can('view', $ticket)) {
            return view('ticket.no_ticket');
        }

        if ($request->isMethod('POST')) {

            $validator = Validator::make($request->all(), [
                    'note' => 'required',
                ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            /*
            Create an object of TicketService,
            TicketService has function to add ticket notes
            */
            $ticketService = new TicketService();
            $ticketService->addTicketNote($user, $ticket, $request->note);
        }
        // Display privte notes
        $params = [
            'ticket' => $ticket,
            'ticket_notes' => $ticket->notes()->paginate(10),
        ];

        if ($user->role == 'user'){
            return view('ticket/user.note', $params);
        } else {
            return view('ticket.note', $params);
        }
    }

    /*
    Add internal notes
    */
    public function internalNote(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isNotUser', Ticket::class);

        // Get the logged in user
        $user = auth()->user();
        // get the Ticket
        $ticket = Ticket::find($uuid);

        /*
        Check weather the user has access to this function
         */
        if (!$user->can('view', $ticket)) {
            return view('ticket.no_ticket');
        }

        if ($request->isMethod('POST')) {

            $validator = Validator::make($request->all(), [
                    'internal_note' => 'required',
                ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            /*
            Create an object of ImapTicketService,
            ImapTicketService has function to add internal ticket notes
            */
            $ticketService = new TicketService();
            $ticketService->addInternalTicketNote($user, $ticket, $request->internal_note);
        }

        // Display internal notes
        $params = [
            'ticket' => $ticket,
            'ticket_notes' => $ticket->internalNotes()->paginate(10),
        ];
        return view('ticket.internal_note', $params);
    }

    /*
    Delete ticket
    */
    public function destroy($uuid)
    {
        $ticket = Ticket::find($uuid);
        $ticket->delete();
        return redirect()
            ->back()
            ->with('success', __('Ticket deleted'));
    }

    /*
    Download attachment
    */
    public function download($filename)
    {
        $attachmentHelper = new AttachmentHelper();
        return $attachmentHelper->privateDownload('attachments', $filename);
    }

    /*
    Delete a reply
    */
    public function replyDelete(Request $request, $uuid)
    {
        $reply = TicketReply::find($uuid);
        $ticketId = $reply->ticket_uuid;
        $reply->delete();
        return redirect()->route('ticket.reply', $ticketId)
            ->with('success', __('Reply deleted'));
    }

    /*
    Delete a private note
    */
    public function noteDelete(Request $request, $uuid)
    {
        $note = TicketNote::find($uuid);
        $ticketId = $note->ticket_uuid;
        $note->delete();
        return redirect()->route('ticket.note', $ticketId)
            ->with('success', __('Note deleted'));
    }

     /*
    Delete an internal note
    */
    public function internalNoteDelete(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('isNotUser', Ticket::class);

        $note = TicketInternalNote::find($uuid);
        $ticketId = $note->ticket_uuid;
        $note->delete();
        return redirect()->route('ticket.internal_note', $ticketId)
            ->with('success', __('Note deleted'));
    }


}
