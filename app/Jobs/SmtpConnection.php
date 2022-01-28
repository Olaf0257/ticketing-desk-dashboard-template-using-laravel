<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Logger;
use App\Models\ErrorLog;

class SmtpConnection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $department = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($department)
    {
        $this->department = $department;
        Logger::info("Class: " . __CLASS__);
        Logger::info("Function: " . __FUNCTION__);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Logger::info("**** SmtpConnection Job Starting ****");
        try {
            //TODO: not tested this code
            $security = ($this->department->smtp_encryption != '') ? $this->department->smtp_encryption : null;
            $transport = (new \Swift_SmtpTransport($this->department->smtp_host, $this->department->smtp_port, $security))
                  ->setUsername($this->department->email)
                  ->setPassword($this->department->smtp_password);
            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();
            $this->department->smtp_status = true;
            Logger::info("Smtp test connection worked");
        } catch (\Swift_TransportException $e) {
            $this->department->smtp_status = false;
            $error_log = new ErrorLog();
            $error_log->section = 'SMTP';
            $error_log->title = 'Error creating SMTP object';
            $error_log->error_text = $e->getMessage();
            $error_log->save();
            Logger::error("Error creating SMTP object");
            Logger::error($e->getMessage());
        }
        $this->department->save();
    }
}
