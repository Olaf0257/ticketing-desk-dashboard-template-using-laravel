<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KbCategory;
use App\Models\KbArticle;
use App\Helpers\Uuid;
use DB;

class ArticleController extends Controller
{
  
    public function index()
    {
        $categories = KbCategory::all();
        return view('article.index' ,  compact('categories'));
    }

   public function show($uuid)
    {
        $categories = KbCategory::find($uuid);
        $articles = KbArticle::where('category_id', $uuid)->get();
        $params = [
            'categories' => $categories,
            'articles' => $articles,
        ];
        return view('article.show' , $params);
    }

    public function showArticle($slug)
    {
        $article = KbArticle::where('slug', $slug)->first();
        $article_titles = KbArticle::where('category_id', $article->category_id)->get();
        $categories = KbCategory::all();

        $params = [
            'articles' => $article,
            'categories' => $categories,
            'article_titles' => $article_titles
       ];
        return view('article.view_article', $params);
    }
}