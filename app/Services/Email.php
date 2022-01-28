<?php
namespace App\Services;

use Exception;
use App\Helpers\Logger;
use App\Models\ErrorLog;
use App\Models\User;
use App\Models\Department;
use App\Models\EmailTemplate;
use App\Mail\TicketOpened;
use App\Mail\TicketReplyAdded;
use App\Mail\MailTicketOpened;
use App\Mail\AssignedToReplyMail;
use App\Mail\AssignedToMail;
use App\Mail\DepartmentMail;
use App\Mail\DepartmentStaffReplyMail;
use App\Mail\DepartmentUserReplyMail;
use Illuminate\Support\Facades\Mail;

class Email
{
    public function ticketOpened($ticket)
    {
        $content = EmailTemplate::where('name', 'ticket_opened')->first();
        if ($content->status == true) {
            Logger::info('Sending ticket opened mail to ' . $ticket->ticketUser->email);
            $mail = new TicketOpened($ticket, $content);
            Mail::to($ticket->ticketUser->email)
                ->queue($mail);
        }
    }

    public function ticketReplyAdded($ticket)
    {
        $content = EmailTemplate::where('name', 'ticket_reply')->first();
        if ($content->status == true) {
            $mail = new TicketReplyAdded($ticket, $content);
            Mail::to($ticket->ticketUser->email)
                ->queue($mail);
        }

    }

    public function mailTicketOpened($ticket, $department)
    {
        $content = EmailTemplate::where('name', 'mail_ticket_opened')->first();
        if ($content->status == true) {
            $mail = new MailTicketOpened($ticket, $content);
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
        }

    }

    public function departmentEmail($ticket, $dept_id)
    {
        $content = EmailTemplate::where('name', 'ticket_opened_department')->first();
        if ($content->status == true) {
            $department = Department::where('id', $dept_id)->first();
            $user_ids = $department->users()->pluck('user_id')->toArray();
            if (!empty($user_ids)) {
                $staffs = User::whereIn('id', $user_ids)->get();
                Logger::info('Sending ticket opened mail to department staffs');
                foreach ($staffs as $staff) {
                    $mail = new DepartmentMail($ticket, $content, $staff);
                    Mail::to($staff->email)
                        ->queue($mail); 
                }
                
            }
        }
        
    }

    public function assignedToEmail($ticket, $staff_id)
    {
        $content = EmailTemplate::where('name', 'ticket_assigned')->first();
        if ($content->status == true) {
            $staff = User::where('id', $staff_id)->pluck('email');
            if (!empty($staff)) {
                Logger::info('Sending ticket assigned mail to assigned staff');
                $data = [];
                $mail = new AssignedToMail($ticket, $content);
                Mail::to($staff)
                    ->queue($mail);
            }
        }
    }

    public function assignedToReplyMail($ticket, $user)
    {
        $content = EmailTemplate::where('name', 'assigned_to_reply_mail')->first();
        if ($content->status == true) {
            $staff_email = User::where('id', $ticket->assigned_to)->value('email');
            if (!empty($staff_email) && ($user != $staff_email)) {
                Logger::info('Sending ticket reply mail to assigned staff');
                $data = [];
                $mail = new AssignedToReplyMail($ticket, $content);
                Mail::to($staff_email)
                    ->queue($mail);
            }
        }
    }

    public function departmentStaffReply($ticket, $replied_staff)
    {
        $content = EmailTemplate::where('name', 'department_staff_reply_mail')->first();
        if ($content->status == true) {
            $department = Department::where('id', $ticket->department_id)->first();
            $user_ids = $department->users()->pluck('user_id')->toArray();
            if (!empty($user_ids)) {
                $staffs = User::whereIn('id', $user_ids)
                    ->where('id', '!=', $replied_staff->id)  
                    ->get();
                Logger::info('Sending ticket reply mail to department staffs when staff replied');
                foreach ($staffs as $staff) {
                    $mail = new DepartmentStaffReplyMail($ticket, $content, $staff, $replied_staff);
                    Mail::to($staff->email)
                        ->queue($mail);
                }
                
            }
        }
        
    }

    public function departmentUserReply($ticket)
    {
        $content = EmailTemplate::where('name', 'department_user_reply_mail')->first();
        if ($content->status == true) {
            $department = Department::where('id', $ticket->department_id)->first();
            $user_ids = $department->users()->pluck('user_id')->toArray();
            if (!empty($user_ids)) {
                $staffs = User::whereIn('id', $user_ids) 
                    ->get();
                Logger::info('Sending ticket reply mail to department staffs when client replied');
                foreach ($staffs as $staff) {
                    $mail = new DepartmentUserReplyMail($ticket, $content, $staff);
                    Mail::to($staff->email)
                        ->queue($mail);
                }
                
            }
        }
        
    }
}
