<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Logger;
use App\Services\Imap;
use App\Models\ErrorLog;

class ImapConnection implements ShouldQueue
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
        Logger::info("**** ImapConnection Job Starting ****");
        // create an object of IMAP class with the department imap details.
        $imap = new Imap(
            $this->department->email,
            $this->department->password,
            $this->department->host,
            $this->department->port,
            $this->department->flags,
            $this->department->mail_box
        );
        Logger::info("IMAP object is created");
        if (!$imap->getStatus()) {
            // if imap connection failed.
            Logger::error("IMAP initilaization failed");
            // set department's imap_status as false
            $this->department->imap_status = false ;
            $this->department->save();
            // add the error to the logs table.
            $error_log = new ErrorLog();
            $error_log->section = 'Imap';
            $error_log->title = 'Error creating IMAP object';
            $error_log->error_text = $imap->getErrorMessage();
            $error_log->save();
            Logger::error("IMAP error");
            Logger::error($imap->getErrorMessage());
        } else {
            Logger::info("IMAP initilaization success");
            // imap worked.
            // get the next mail id
            $nextUid = $imap->getNextUid();
            $this->department->next_message_id = $nextUid;
            $this->department->imap_status = true;
            // save imap status and next mail id to the department table.
            $this->department->save();
            Logger::info("IMAP next uid = $nextUid");
        }
    }
}
