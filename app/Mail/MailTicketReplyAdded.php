<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Logger;
use App\Models\EmailTemplate;

class MailTicketReplyAdded extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticketReply;
    protected $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticketReply)
    {
        Logger::info('MailTicketReplyAdded initialize...');
        $this->ticketReply = $ticketReply;
        $this->ticket = $ticketReply->ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ticket = $this->ticketReply->ticket;
        $format = '[%d] %s';
        $subject =  sprintf($format, $ticket->tid, $ticket->subject);
        
        Logger::info('again sending the reply mail.');

        $attachments = $this->ticketReply->attachments;
        
        $mail= $this->subject($subject)
            ->html($this->ticketReply->message)
            ->withSwiftMessage(function ($message) {
                $messageId = $this->ticket->message_id;
                $messageId = $this->ticket->message_id;
                $headers = $message->getHeaders();
                $headers->addTextHeader('In-Reply-To', $messageId);
            });
        if (count($attachments)>0){
            foreach ($attachments as $attachment){
                $mail->attach(storage_path("app/attachments/" . $attachment->name));
            }
        }
        return $mail;
    }
}