<?php

namespace App\Models\Services;

use App\Models\KbArticle;
use Illuminate\Support\Str;
use App\Helpers\Uuid;

class KbArticleService
{
    public function addKb($request)
    {
        $kb_article = new  KbArticle();
        $kb_article->uuid = Uuid::getUuid();
        $kb_article->category_id = $request->category_id;
        $kb_article->title = $request->title;
        $kb_article->status = $request->status;
        $kb_article->description = $request->description;
        $kb_article->page_title = $request->page_title;
        $kb_article->meta_description = $request->meta_description;
        $kb_article->meta_keyword = $request->meta_keyword;
        $kb_article->slug = Str::slug($request->post('title'), '-');
        $kb_article->save(); 
    }

    public function updateKb($request, $kb_article)
    {
        $updateArray = [];
        $updateArray['category_id'] = $request->category_id;
        $updateArray['title'] = $request->title;
        $updateArray['status'] = $request->status;
        $updateArray['description'] = $request->description;
        $updateArray['page_title'] = $request->page_title;
        $updateArray['meta_description'] = $request->meta_description;
        $updateArray['meta_keyword'] = $request->meta_keyword;
        $updateArray['slug'] = Str::slug($request->post('title'), '-');
        $kb_article->update($updateArray); 
    }
}