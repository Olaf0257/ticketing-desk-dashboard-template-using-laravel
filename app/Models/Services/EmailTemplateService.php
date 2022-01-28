<?php

namespace App\Models\Services;
use App\Models\EmailTemplate;

use App\Helpers\Uuid;


class EmailTemplateService
{
    public function addEmailTemplate($request)
    {
        $email = new EmailTemplate();
        $email->uuid = Uuid::getUuid();
        $email->name = $request->name;
        $email->subject = $request->subject;
        $email->message = $request->message;
        $email->status = $request->status;
        $email->language_id = $request->language_id;
        $email->save();
    }
}