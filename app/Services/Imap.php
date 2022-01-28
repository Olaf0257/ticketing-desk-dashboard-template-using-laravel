<?php
namespace App\Services;

use Exception;
use App\Helpers\Logger;
use App\Models\ErrorLog;

class Imap
{
    private $email;
    private $password;
    private $host;
    private $port;
    private $flags = "";
    private $mailBox = "";
    private $nextUid = 0;
    private $mBox;
    private $status = false;
    private $errorMessage = '';

    public function __construct($email, $password, $host, $port, $flags = "", $mailBox = "")
    {
        Logger::info("Class: " . __CLASS__);
        Logger::info("Function: " . __FUNCTION__);

        if (!function_exists('imap_open')) {
            Logger::error("imap_open function does not exist");
            $error_log = new ErrorLog();
            $error_log->section = 'Imap';
            $error_log->title = 'function imap_open not found';
            $error_log->error_text = 'function imap_open not found';
            $error_log->save();
            throw new Exception('imap_open not found');
        }
        $this->email = $email;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->flags = $flags;
        $this->mailBox = $mailBox;

        $fp = @fsockopen($this->host, $this->port, $errno, $errstr, 1);
        if (!$fp) {
            $format = 'fsockopen failed. Tried to connect to %s:%s';
            $this->errorMessage = sprintf($format, $this->host, $this->port);
            Logger::error($this->errorMessage);
            $this->status = false;
            return false;
        } else {
            try {
                $this->mBox = imap_open($this->getFullUri(), $this->email, $this->password);
                if ($this->getNextUid() > 0) {
                    Logger::info("imap_open worked successfully");
                    $this->status = true;
                }
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
                Logger::error($this->errorMessage);
                $this->status = false;
                return false;
            }
        }
    }

    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    public function setMailBox($mailBox)
    {
        $this->mailBox = $mailBox;
    }

    public function getNextUid()
    {
	if (strpos($this->getHost(), 'office365') !== false) {
		$uids   = imap_search($this->mBox, 'ALL',  SE_UID);
		$end = end($uids);
		$nextuid = $end + 1;
		return $nextuid;
	} else {
        	$status = imap_status($this->mBox, $this->getHost(), SA_ALL);
		return $status->uidnext;
	}
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEmails($sinceUid, $maxUid)
    {
        Logger::info("**** IMAP Email import started ****");
        $format = 'Get emails from %d to %d';
        Logger::info(sprintf($format, $sinceUid, $maxUid));
        $emails = imap_fetch_overview($this->mBox, "$sinceUid:$maxUid", FT_UID);
        $data = [];
        $i = 0;
        Logger::info("Loop through the emails");
        foreach ($emails as $emailNumber) {
            try {
                $imapEmail = new ImapEmail($this->mBox, $emailNumber);
            } catch (Exception $e) {
                Logger::info("ImapEmail class exception");
                Logger::info($e->getMessage());
                continue;
            }
            $isReply = false;
            if (isset($emailNumber->in_reply_to) && !empty($emailNumber->in_reply_to)) {
                $isReply = true;
            }
            $uid = $emailNumber->uid;
            $overview = imap_fetch_overview($this->mBox, $emailNumber->msgno, 0);
            $data[$i]['message'] = $imapEmail->getMessage();
            $data[$i]['subject'] = $imapEmail->getSubject($overview);
            $data[$i]['message_id'] = $imapEmail->getMessageId();
            $data[$i]['from'] = $imapEmail->getFrom();
            $data[$i]['attachments'] = $imapEmail->getAttachments();
            $data[$i]['to'] = $imapEmail->getTo($overview);
            $data[$i]['uid'] = $imapEmail->getUid();
            if ($isReply) {
                $data[$i]['tid'] = $imapEmail->getReplyTid($overview);
            }
            $i++;
        }
        Logger::info("End of the email loop");
        return $data;
    }

    private function getFullUri()
    {
        $format = '{%s:%d%s}%s';
        return sprintf($format, $this->host, $this->port, $this->flags, $this->mailBox);
    }

    private function getHost()
    {
        $format = '{%s}';
        return sprintf($format, $this->host);
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
