<?php

namespace App\Models\Services;

use App\Models\FaqCategory;

use App\Helpers\Uuid;


class FaqCategoryService
{
    public function addFaq($request)
    {
        $faq_category=new  FaqCategory();
        $faq_category->uuid= Uuid::getUuid();
        $faq_category->name=$request->name;
       
        $faq_category->save();

       
    }
}