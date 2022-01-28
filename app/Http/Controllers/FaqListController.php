<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Helpers\Uuid;
use DB; 
class FaqListController extends Controller
{
    public function index()
    {
        $faq_categories = FaqCategory::all();

        $faqs = [];
        foreach($faq_categories as $faq_category){
           $faqs[$faq_category->uuid] = Faq::where('category_id', $faq_category->uuid)->get();
        }
        $params = [
            'faqs' => $faqs,
            'faq_categories' => $faq_categories
        ];
        return view('faq.show', $params);
    }
}