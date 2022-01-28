<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Logger;
use App\Services\Imap;
use Exception;
use App\Models\Department;
use App\Models\ImapTicket;
use App\Helpers\Uuid;
use App\Helpers\Random;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\ImapTicketAttachment;
use App\Models\ImapReplyAttachment;
use App\Models\ErrorLog;
use App\Services\Email;
use Illuminate\Support\Facades\Mail;
use App\Models\Services\ImapTicketService;

class ImapImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'impa:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import mails using Imap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $departments = Department::all();
        $emailService = new Email();
        Logger::info('**** Starting IMAP import ****');
        foreach ($departments as $department) {
            Logger::info("Starting IMAP object initialization for " . $department->name );
            if ($department->next_message_id > 0) {
                try {
                    $imap = new Imap(
                        $department->email,
                        $department->password,
                        $department->host,
                        $department->port,
                        $department->flags
                    );
                    Logger::info("IMAP object initialization completed");
                    Logger::info("Importing emails from the department: " . $department->name);
                    $nextUid = $imap->getNextUid();
                } catch (Exception $e) {
                    $error_log = new ErrorLog();
                    $error_log->section = 'Imap';
                    $error_log->title = 'IMAP not worked for: ' . $department->name;
                    $error_log->error_text = $e->getMessage();
                    $error_log->save();
                    Logger::info('Message: ' . $e->getMessage());
                    Logger::info('Line: ' . $e->getLine());
                    Logger::info('File: ' . $e->getFile());
                    continue;
                }
                if ($nextUid > 0) {
                    Logger::info("IMAP connection worked with nextUid = $nextUid");
                    Logger::info("Get emails since " . $department->next_message_id);
                    $emails = $imap->getEmails($department->next_message_id, $nextUid);

                    foreach ($emails as $email) {
                        try {
                            // Logger::info("IMAPEmail array");
                            // Logger::info(print_r($email, true));
                            if (isset($email['tid'])) {
                                Logger::info("tid: " . $email['tid']);
                            }
                            if (isset($email['tid'])) {
                                Logger::info("This is a reply for tid: " . $email['tid']);
                                $ticketService = new ImapTicketService();
                                $ticket = ImapTicket::where('tid', $email['tid'])
                                    ->first();

                                if ($ticket) {
                                    $from_name  = $this->getEmailNameFromRfc($email['from']);
                                    $to_address = $this->getEmailFromRfc($email['to']);
                                    $ticketService->addEmailReply($ticket, $email, $from_name, $to_address);

                                    $previous_status = $ticket->ticket_status_id;
                                    $ticket->staff_unread = 1;
                                    $ticket->ticket_status_id = 6;
                                    $ticketService->ticketStatusLife($ticket, $previous_status, $ticket->assigned_to, $ticket->ticket_status_id);
                                    $ticket->save();

                                    // Send ticket reply mail to assigned staff
                                    $emailService->assignedToReplyMail($ticket, $ticket->from_email);
                                    // Send ticket reply mail to staffs under the department
                                    $emailService->departmentUserReply($ticket);
                                }
                            } else {
                                Logger::info("This is a new mail");
                                $ticket = new ImapTicket();
                                $ticket->uuid = Uuid::getUuid();
                                // $ticket->tid = Random::getTicketNumber();
                                $ticket->department_id = $department->id;
                                if (empty($email['subject'])) {
                                    $ticket->subject = "No Subject" ;
                                } else {
                                    $ticket->subject = $email['subject'];
                                }
                                if (empty($email['message'])) {
                                    $ticket->message = "" ;
                                } else {
                                    $ticket->message = $email['message'];
                                }
                                $ticket->from_name  = $this->getEmailNameFromRfc($email['from']);
                                $ticket->from_email = $this->getEmailFromRfc($email['from']);
                                $ticket->staff_unread = 1;
                                $ticket->last_touched_at = Carbon::now()->format('Y-m-d H:i:s');
                                $ticket->message_id = $email['message_id'];
                                $ticket->save();

                                $attachments = $email['attachments'];
                                if (count($attachments) > 0) {
                                    Logger::info("This mail has attachment");
                                    foreach ($attachments as $attachment) {
                                        Logger::info("attachment name ." . $attachment['filename']);
                                        $localFile = storage_path("app/attachments/" . $attachment['filename']);
                                        file_put_contents($localFile, $attachment['content']);

                                        $ticketAttachment = new ImapTicketAttachment();
                                        $ticketAttachment->name = $attachment['filename'];
                                        $ticketAttachment->uuid = Uuid::getUuid();
                                        $ticketAttachment->imap_ticket_uuid = $ticket->uuid;
                                        $ticketAttachment->save();
                                    }
                                }

                                $ticket_new = ImapTicket::find($ticket->uuid);
                                Logger::info("Sending ticket opened mail to user's email.");
                                // Send ticket opened mail to clients email address
                                $emailService->mailTicketOpened($ticket_new, $department);
                                // Send ticket opened mail to staffs under department
                                $emailService->departmentEmail($ticket, $department->id);

                            }
                        } catch (Exception $e) {
                            $error_log = new ErrorLog();
                            $error_log->section = 'Imap';
                            $error_log->title = 'IMAP not worked for: ' . $department->name;
                            $error_log->error_text = $e->getMessage();
                            $error_log->save();
                            Logger::info('Message: ' . $e->getMessage());
                            Logger::info('Line: ' . $e->getLine());
                            Logger::info('File: ' . $e->getFile());
                        }
                    } // end of emails

                    $department->next_message_id = $nextUid;
                    $department->save();
                } else {
                    $error_log = new ErrorLog();
                    $error_log->section = 'Imap';
                    $error_log->title = 'IMAP getNextUid not worked';
                    $error_log->error_text = "IMAP getNextUid not worked and nextUid = $nextUid";
                    $error_log->save();
                    Logger::error("IMAP getNextUid not worked and nextUid = $nextUid");
                }
            }
        } // end of department foreach
        Logger::info('**** IMAP import completed successfully ****');
        return 0;
    }

    private function getEmailNameFromRfc($string)
    {
        Logger::info('getEmailNameFromRfc : ' . $string );
        /*
        If this email already in the format
        modulespanel@gmail.com, then no need to get from RFC format.
         */
        if(filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return $string ;
        }

        $name = preg_match('/[\w\s]+/', $string, $matches);
        $matches[0] = trim($matches[0]);
        return $matches[0];
    }

    private function getEmailFromRfc($string)
    {

        Logger::info('getEmailFromRfc for: ' . $string );
        /*
        If this email already in the format
        modulespanel@gmail.com, then no need to get from RFC format.
         */
        if(filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return $string ;
        }
        /*
        If the email is in the RFC format (eg: Modules Panel <modulespanel@gmail.com>),
        then get email id from it.
         */
        $mailAddress = preg_match('/(?:<)(.+)(?:>)$/', $string, $matches);
        return $matches[1];
    }
}
