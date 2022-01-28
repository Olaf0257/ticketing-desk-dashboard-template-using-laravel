<?php

namespace App\Models\Services;

use App\Models\KbCategory;
use App\Helpers\AttachmentHelper;

use App\Helpers\Uuid;


class KbCategoryService
{
    public function addCategory($request)
    {
        $kb_category=new  KbCategory();
        $kb_category->uuid = Uuid::getUuid();
        $kb_category->name = $request->name;
        $kb_category->icon = $request->icon;
        $kb_category->description = $request->description;
        $kb_category->save();
    }
}