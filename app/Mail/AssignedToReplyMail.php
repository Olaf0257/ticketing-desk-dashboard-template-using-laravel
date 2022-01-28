<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Logger;
use App\Models\EmailTemplate;

class AssignedToReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticket;
    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $content)
    {
        $this->ticket = $ticket;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = $this->content;
        $ticket_id = $this->ticket->tid;
        $user = $this->ticket->assignedUser->name;
        $department = $this->ticket->department->name;
        if ($this->ticket->source == "imap"){
            $subject = $this->ticket->subject;
            $ticket_url = env('APP_URL')."/{$this->ticket->uuid}/imap_ticket_reply";
        } else {
            $subject = $this->ticket->title;
            $ticket_url = env('APP_URL')."/{$this->ticket->uuid}/ticket_reply";
        }
        $app_url = env('APP_URL');
        $value = array('{$ticket_id}', '{$user_name}', '{$subject}', '{$department}', '{$ticket_url}', '{$app_url}');
        $actual_value = array($ticket_id, $user, $subject, $department, $ticket_url, $app_url);
        $body = $content->message;

        $message = str_replace($value, $actual_value, $body);
        Logger::info('');
        return $this->subject($content->subject)
            ->html($message);
        
    }
}