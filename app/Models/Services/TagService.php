<?php

namespace App\Models\Services;
use App\Models\Tag;

use App\Helpers\Uuid;


class TagService
{
   

    public function addTag($request)
    {
                $tags = new Tag();
                $tags->uuid = Uuid::getUuid();
                $tags->name = $request->name;
                $tags->tag_color = $request->tag_color;
                $tags->text_color = $request->text_color;
                 $tags->save();
    
    }
}