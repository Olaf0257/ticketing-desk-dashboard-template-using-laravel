<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Logger;
use App\Models\EmailTemplate;

class MailTicketOpened extends Mailable
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
        $format = 'Re: [%d] %s';
        $subject =  sprintf($format, $this->ticket->tid, $this->ticket->subject);

        $ticket_id = $this->ticket->tid;
        Logger::info("$ticket_id");
        $user = $this->ticket->from_name;
        $app_url = env('APP_URL');
        $value = array('{$ticket_id}', '{$user_name}', '{$app_url}');
        $actual_value = array("$ticket_id", "$user", "$app_url");
        $body = $content->message;

        $message = str_replace($value, $actual_value, $body);

        return $this->subject($subject)
            ->html($message)
            ->withSwiftMessage(function ($message) {
                $messageId = trim($this->ticket->message_id, ">");
                $messageId = trim($this->ticket->message_id, "<");
                $headers = $message->getHeaders();
                $headers->addTextHeader('In-Reply-To', $messageId);
        });
        
    }
}
