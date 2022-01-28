<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KbCategory;
use App\Models\KbArticle;
use App\Helpers\Uuid;
use App\Helpers\Logger;
use App\Models\Services\KbArticleService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class KbArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('isNotUser', KbArticle::class);
        $kb_articles = KbArticle::paginate(10);
        $params = [
            'kb_articles' => $kb_articles,
            'request' => $request
        ];
        return view('kb_article.index', $params);
    }

    public function create()
    {
        $this->authorize('isNotUser', KbArticle::class);
        $kb_articles= KbArticle::all();
        $categories= KbCategory::all();
        $params = [
            'categories' => $categories,
            'kb_articles' => $kb_articles 
        ];
        return view('kb_article.create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('isNotUser', KbArticle::class);
        try {
           
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'title' => 'required | max:100 | unique:App\Models\KbArticle,title',
                'status' => 'required',
                'description' => 'required' 
            ]);
            $kbArticleService = new KbArticleService();
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
           
            $kbArticleService= $kbArticleService->addKb( $request);
                return redirect()->route('kb_article.index')
                ->with('success', __('KB Article added'));
        } catch (\Exception $e) {
            Logger::error($e->getMessage());
                return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function edit(Request $request, $uuid)
    {
        $this->authorize('isNotUser', KbArticle::class);
        $kb_article = KbArticle::find($uuid);
        $categories = KbCategory::all();
        $params = [
            'kb_article' => $kb_article,
            'categories' => $categories,
            
        ];
        return view('kb_article.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('isNotUser', KbArticle::class);
        try {
            $kb_article = KbArticle::find($uuid);
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'title' => 'required | max:100 | unique:App\Models\KbArticle,title,'.$kb_article->uuid,
                'status' => 'required',
                'description' => 'required'

            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $kbArticleService = new KbArticleService();
            $kbArticleService= $kbArticleService->updateKb($request, $kb_article);
            return redirect()->route('kb_article.index')
                ->with('success', __('Article updated'));

        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $uuid)
    {
        $this->authorize('isNotUser', KbArticle::class);
        $kb_article = KbArticle::find($uuid);
        $kb_article->delete();
        return redirect()->route('kb_article.index')
            ->with('success', __('Article deleted'));
    }
}
