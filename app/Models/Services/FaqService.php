<?php

namespace App\Models\Services;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Helpers\Uuid;
use Illuminate\Support\Str;

class FaqService
{
    public function addFaq( $request)
    { 
      $faq = new  Faq();
      $faq->uuid = Uuid::getUuid();
      $faq->category_id = $request->category_id;
      $faq->question = $request->question;
      $faq->answer = $request->answer;
      $faq->save();
    }
}