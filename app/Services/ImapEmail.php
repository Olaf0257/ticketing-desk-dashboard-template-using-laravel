<?php
namespace App\Services;

use Exception;
use App\Helpers\Logger;

class ImapEmail
{
    private $replyMail = false;
    private $attachments = [];
    private $message = null;
    private $subject;
    private $mBox;
    private $from;
    private $messageId;
    private $uid;

    public function __construct($mBox, $emailNumber)
    {
        $this->mBox = $mBox;
        if (isset($emailNumber->in_reply_to) && !empty($emailNumber->in_reply_to)) {
            $this->replyMail = true;
        }
        $this->uid = $emailNumber->uid;
        $overview = imap_fetch_overview($this->mBox, $emailNumber->msgno, 0);
        $format = 'Starting to process email with uid =  %d';
        Logger::info(sprintf($format, $overview[0]->uid));
        $structure = imap_fetchstructure($this->mBox, $emailNumber->msgno);
        $message = null;
        $this->parseMailStructure($structure, $emailNumber);
    }

    private function parseMailStructure($structure, $emailNumber)
    {
        Logger::info("Starting email structure parsing");
        $this->from = $emailNumber->from;
        $this->messageId = $emailNumber->message_id;

        $attachments = array();
        if (isset($structure->parts) && count($structure->parts)) {

            /*
            Check attachment
             */
            for ($i = 0; $i < count($structure->parts); $i++) {
                $part = $structure->parts[$i];

                $isAttachment = false;
                if ($structure->parts[$i]->ifdparameters) {
                    foreach ($structure->parts[$i]->dparameters as $object) {
                        if (strtolower($object->attribute) == 'filename') {
                            Logger::info("attachment details");
                            Logger::info(print_r($object, true));
                            $isAttachment = true;
                            $this->attachments[$i]['is_attachment'] = true;
                            $fileName = sprintf("%s-%s", time(), $object->value);
                            $this->attachments[$i]['filename'] = $fileName;
                        }
                    }
                } elseif ($structure->parts[$i]->ifparameters) {
                    foreach ($structure->parts[$i]->parameters as $object) {
                        if (strtolower($object->attribute) == 'name') {
                            Logger::info("attachment details");
                            Logger::info(print_r($object, true));
                            $isAttachment = true;
                            $this->attachments[$i]['is_attachment'] = true;
                            $fileName = sprintf("%s-%s.", time(), $object->value);
                            $this->attachments[$i]['filename'] = $fileName;
                        }
                    }
                }

                if (isset($this->attachments[$i]) && $this->attachments[$i]['is_attachment']) {
                    $content = imap_fetchbody($this->mBox, $emailNumber->msgno, $i+1);

                    /* 3 = BASE64 encoding */
                    if ($structure->parts[$i]->encoding == 3) {
                        $this->attachments[$i]['content'] = base64_decode($content);
                    }
                    /* 4 = QUOTED-PRINTABLE encoding */
                    elseif ($structure->parts[$i]->encoding == 4) {
                        $this->attachments[$i]['content'] = quoted_printable_decode($content);
                    }
                }
            } // end of all parts

            /*
            Get mail content starts here
             */
            if ($isAttachment) {
                Logger::info("This email has attachment");
                $message = imap_fetchbody($this->mBox, $emailNumber->msgno, 1.1);
                $part = $structure->parts[0]->parts[0];

                if (empty($message)) {
                    $part = $structure->parts[0]->parts[1];
                    $message = imap_fetchbody($this->mBox, $emailNumber->msgno, 1.2);
                }
                if ($part->encoding == 3) {
                    $this->message = imap_base64($message);
                } elseif ($part->encoding == 1) {
                    $this->message = imap_8bit($message);
                } else {
                    $this->message = imap_qprint($message);
                }

                Logger::info("attachment part details");
                Logger::info(print_r($part, true));
            } else {
                Logger::info("This email has no attachment");
                $message = imap_fetchbody($this->mBox, $emailNumber->msgno, 2);
                $part = $structure->parts[1];
                Logger::info("email part details");
                Logger::info(print_r($part, true));

                if ($part->subtype == "DELIVERY-STATUS") {
                    Logger::info("It's a delivery status mail");
                    throw new Exception("Some error message", 30);
                }

                if ($part->encoding == 3) {
                    $this->message = imap_base64($message);
                } elseif ($part->encoding == 1) {
                    $this->message = imap_8bit($message);
                } else {
                    $this->message = imap_qprint($message);
                }
            }
            /*
            Mail content end here
             */
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSubject($overview)
    {
        $subject = '';
        if ($overview[0] && $overview[0]->subject) {
            $subject = imap_utf8($overview[0]->subject);
        }
        return $subject;
    }

    public function getTo($overview)
    {
        $to = [];
        foreach ($overview as $toAddress) {
            $to[] = $toAddress->to;
        }
        return $to[0];
    }

    public function getReplyTid($overview)
    {
        if ($overview[0] && $overview[0]->subject) {
            $subject = imap_utf8($overview[0]->subject);
            preg_match_all("/\\[(.*?)\\]/", $subject, $matches);
            if ($matches && count($matches[1]) > 0) {
                return $matches[1][0];
            }
        }
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getUid()
    {
        return $this->uid;
    }
}
