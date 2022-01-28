<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Auth;

use App\Models\ImapTicket;
use App\Models\ImapReply;
use App\Models\ImapTicketNote;
use App\Models\ImapTicketInternalNote;
use App\Models\Setting;
use App\Models\TicketStatus;
use App\Models\ImapTicketStatusLife;
use App\Models\TicketUrgency;
use App\Models\Department;
use App\Models\User;
use App\Helpers\Uuid;
use App\Helpers\Random;
use App\Helpers\TicketHelper;
use App\Models\Services\ImapTicketService;
use App\Models\Services\UserService;
use App\Helpers\Logger;
use App\Helpers\AttachmentHelper;
use App\Models\ImapReplyAttachment;
use App\Models\Tag;
use App\Mail\MailTicketReplyAdded;
use App\Services\Email;

class ImapTicketController extends Controller
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
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        // get the logged in user
        $user = User::find(auth()->id());
        // Get all departments of the logged in user
        $dep = $user->departments()->pluck('department_id')->toArray();
        /*
        Create an object of ImapTicketService,
        ImapTicketService has functions that inteact with the
        ImapTicket model
         */
        $ticketService = new ImapTicketService();
        // get all ticket status
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // get all departments
        $department = Department::all();
        /*
        Get tickets based on the filter option.
         */
        $imap_tickets = $ticketService->getFilteredTickets($user, $request, $dep)->paginate(10);
        // service class that interact with the user model.
        $userService = new UserService();
        // get the staff list
        $staffs = $userService->getStaffs();

        /*
        Display the imap tickets
         */
        $params = [
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department,
            'imap_tickets' => $imap_tickets,
        ];

        return view('imap_ticket.index', $params);
    }

    public function ticketByStatus(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        // get the logged in user
        $user = User::find(auth()->id());
        // Get all departments of the logged in user
        $dep = $user->departments()->pluck('department_id')->toArray();
        /*
        Create an object of ImapTicketService,
        ImapTicketService has functions that inteact with the
        ImapTicket model
         */
        $ticketService = new ImapTicketService();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // get all departments
        $department = Department::all();
        /*
        Get tickets based on the filter option.
         */
        $imap_tickets = $ticketService->getFilteredTickets($user, $request, $dep)
            ->where('ticket_status_id', $id)->paginate(10);

        // service class that interact with the user model.
        $userService = new UserService();
        // get the staff list
        $staffs = $userService->getStaffs();

        /*
        Display the imap tickets
         */
        $params = [
            'ticket_urgency' => $ticketUrgency,
            'request' => $request,
            'staffs' => $staffs,
            'department' => $department,
            'imap_tickets' => $imap_tickets,
        ];

        return view('imap_ticket.ticket_by_status', $params);
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
        $this->authorize('isStaff', ImapTicket::class);

        $ticketService = new ImapTicketService();
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
        return view('imap_ticket.tickets_assigned_me', $params);
    }

    public function show($uuid)
    {
        $statuses = TicketStatus::all();
        $statusLife = ImapTicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
            ->where('ticket_uuid', $uuid)
            ->groupBy('previous_status_id')
            ->pluck('total', 'previous_status_id')->all();
        $ticket = ImapTicket::find($uuid);
        $params = [
            'statuses' => $statuses,
            'statusLife' => $statusLife,
            'ticket' => $ticket
        ];
        return view('imap_ticket.show', $params);
    }
    public function reply(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        // get the logged in user
        $user = auth()->user();
        // get the Ticket
        $ticket = ImapTicket::find($uuid);
        // get all ticket status
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();

        if ($request->isMethod('POST')) {
            //if modify the ticket
            if ($request->action && $request->action == "modify_ticket") {
                $validator = Validator::make($request->all(), [
                    'subject' => 'required',
                    'ticket_urgency_id' => 'required',
                    'ticket_status_id' => 'required',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors()->first();
                    return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
                }
                // Modify ticket
                $ticket->subject = $request->subject;
                $ticket->ticket_urgency_id = $request->ticket_urgency_id;
                $ticket->ticket_status_id = $request->ticket_status_id;
                $ticket->save();
            } else {
                 /*
                If replying to ticket
                */
                $validator = Validator::make($request->all(), [
                    'reply' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json(['error' => __('Invalid file format')], 400);
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
            $ticketService = new ImapTicketService();
            if ($request->reply) {
                // Get the allowed extensions
                $extension = setting::where('id', 2)->value('value');
                if ($request->hasFile('attachments')) {
                    $validator = Validator::make($request->all(), [
                        'attachments.*' => "required|mimes:$extension"
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['error' => __('Invalid file format')], 400);
                    }
                }
                // Save ticket reply from ImapTicketService
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
                        $replyAttachment = new ImapReplyAttachment();
                        $replyAttachment->name = $fileName;
                        $replyAttachment->uuid = Uuid::getUuid();
                        $replyAttachment->imap_reply_uuid = $ticketReply->uuid;
                        $replyAttachment->save();
                    }
                }
                $ticket->last_touched_at = Carbon::now()->format('Y-m-d H:i:s');
                // Change ticket status
                $previous_status = $ticket->ticket_status_id;
                $old_staff = $ticket->assigned_to;
                $ticket->ticket_status_id = 4;
                $ticketService->ticketStatusLife($ticket, $previous_status, $old_staff, $ticket->ticket_status_id);
                $ticket->save();

                // Send ticket reply added mail to user's Email
                $mail = new MailTicketReplyAdded($ticketReply);
                $department = Department::where('id', $ticket->department_id)->first();
                if($department->smtp_status == 1){

                    // Fix for the  Your domain gmail.com is not allowed in header error
                    $mail->from($department->email);

                    $backup = Mail::getSwiftMailer();
                    $security = ($department->smtp_encryption != '') ? $department->smtp_encryption : null;
                    $transport = (new \Swift_SmtpTransport($department->smtp_host, $department->smtp_port, $security))
                        ->setUsername($department->email)
                        ->setPassword($department->smtp_password);
                    $mailer = new \Swift_Mailer($transport);

                    Mail::setSwiftMailer($mailer);
                    Mail::to($ticket->from_email)
                        ->send($mail);
                    Mail::setSwiftMailer($backup);
                }else{
                    Mail::to($ticket->from_email)
                    ->send($mail);
                }
                $emailService = new Email();
                $emailService->departmentStaffReply($ticket, $user);
                $emailService->assignedToReplyMail($ticket, $user);

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
            if ($user->role == 'staff'){
                $ticket->staff_unread = 0;
            }
            $ticket->save();
        }
        // view ticket replies
        $params = [
            'ticket' => $ticket,
            'ticket_reply' => $ticket->replies()->paginate(10),
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
        ];
        return view('imap_ticket.reply', $params);
    }

    /*
    Add private notes
    */
    public function note(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        // get the logged in user
        $user = auth()->user();
        // get the Ticket
        $ticket = ImapTicket::find($uuid);
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
            Create an object of ImapTicketService,
            ImapTicketService has function to add ticket notes
            */
            $ticketService = new ImapTicketService();
            $ticketService->addTicketNote($user, $ticket, $request->note);
        }
        // Display private notes
        $params = [
            'ticket' => $ticket,
            'ticket_notes' => $ticket->notes()->paginate(10),
        ];
        return view('imap_ticket.note', $params);
    }

    /*
    Add internal notes
    */
    public function internalNote(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        $user = auth()->user();
        // get the Ticket
        $ticket = ImapTicket::find($uuid);

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
            $ticketService = new ImapTicketService();
            $ticketService->addInternalTicketNote($user, $ticket, $request->internal_note);
        }

        // Display internal notes
        $params = [
            'ticket' => $ticket,
            'ticket_notes' => $ticket->internalNotes()->paginate(10),
        ];
        return view('imap_ticket.internal_note', $params);
    }

    public function modify(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        $user = auth()->user();
        $ticket = ImapTicket::find($uuid);
        /*
        Create an object of ImapTicketService,
        ImapTicketService has functions that interact with the
        ImapTicket model
         */
        $ticketService = new ImapTicketService();
        // Get all of the user departments with imap server details
        $departments = Department::whereNotNull('host')->get();
        // Get all the ticket statuses
        $ticketStatuses = TicketStatus::all();
        // get all ticket urgency list
        $ticketUrgency = TicketUrgency::all();
        // Get all of the tags
        $tags = Tag::all();
        $selected_tags = $ticket->tags()->pluck('uuid')->toArray();

        /*
        Create an object of UserService,
        UserService has functions that inteact with the
        ImapTicket model
         */
        $userService = new UserService();
        $department_id = $ticket->department_id;
        // Get staffs in the current ticket department
        $staffs = $userService->getDepartmentStaffs($department_id);

        if ($request->isMethod('POST')) {
            if ($request->action && $request->action == "modify_ticket") {
                $validator = Validator::make($request->all(), [
                            'subject' => 'required',
                            'ticket_urgency_id' => 'required',
                            'ticket_status_id' => 'required',
                        ]);
                if ($validator->fails()) {
                    $errors = $validator->errors()->first();
                    return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors($validator);
                }
                $previous_status = $ticket->ticket_status_id;
                $ticket->subject = $request->subject;
                $old_staff = $ticket->assigned_to;
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

                $ticket = $ticketService->modifyTicketUnread($ticket, $request);
                $ticket->save();
                $tagIdArray = explode(",", $request->tag_ids);
                $ticket->tags()->sync($tagIdArray);
                
                return redirect()->route('imap_ticket.index')
                ->with('success', __('Ticket updated'));
            }
        }
        // View modify ticket page
        $params = [
            'ticket' => $ticket,
            'ticket_statuses' => $ticketStatuses,
            'ticket_urgency' => $ticketUrgency,
            'staffs' => $staffs,
            'departments' => $departments,
            'tags' => $tags,
            'selected_tags' => $selected_tags
        ];
        return view('imap_ticket.modify', $params);
    }

    /*
    Delete ticket
    */
    public function destroy($uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        $ticket = ImapTicket::find($uuid);
        $ticket->delete();
        return redirect()->route('imap_ticket.index')
            ->with('success', __('Ticket deleted'));
    }

    public function download($filename)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        /*
        Download attachment
        Create an object of AttachmentHelper,
        AttachmentHelper has functions that help to download attachments
        */
        $attachmentHelper = new AttachmentHelper();
        return $attachmentHelper->privateDownload('attachments', $filename);
    }

    public function replyDelete(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        /*
        Delete a reply
        */
        $reply = ImapReply::find($uuid);
        $ticketId = $reply->imap_ticket_uuid;
        $reply->delete();
        return redirect()->route('imap_ticket.reply', $ticketId)
            ->with('success', __('Reply deleted'));
    }

    public function noteDelete(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        /*
        Delete a private note
        */
        $note = ImapTicketNote::find($uuid);
        $ticketId = $note->imap_ticket_uuid;
        $note->delete();
        return redirect()->route('imap_ticket.note', $ticketId)
            ->with('success', __('Note deleted'));
    }

    public function internalNoteDelete(Request $request, $uuid)
    {
        /*
        Check weather the user has access to this function
         */
        $this->authorize('before', ImapTicket::class);

        /*
        Delete an internal note
        */
        $note = ImapTicketInternalNote::find($uuid);
        $ticketId = $note->imap_ticket_uuid;
        $note->delete();
        return redirect()->route('imap_ticket.internal_note', $ticketId)
            ->with('success', __('Note deleted'));
    }
}
