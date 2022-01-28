<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use App\Helpers\Uuid;
use App\Helpers\Logger;
use App\Models\Services\FaqCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class FaqCategoryController extends Controller
{
    public function __construct()
    {
        /*
        make sure only logged in and verified user has access
        to this controller
         */
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('isNotUser', FaqCategory::class);
        $faqCategories = FaqCategory::paginate(10);
        $params = [
            'faqCategories' => $faqCategories,
            'request' => $request
        ];
        return view('faq_category.index', $params);
    }

    /**
     * Show the form for creating a new resource.

     */
    public function create()
    { 
        $this->authorize('isNotUser', FaqCategory::class);
        return view('faq_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('isNotUser', FaqCategory::class);
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | unique:App\Models\FaqCategory,name',
            ]);
            $faqCategoryService = new FaqCategoryService();
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $faq_category= $faqCategoryService->addFaq( $request);
            return redirect()->route('faq_category.index')
                ->with('success', __('FAQ category added'));
        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $uuid)
    {
        $this->authorize('isNotUser', FaqCategory::class);
        $faq_category = FaqCategory::find($uuid);
        return view('faq_category.edit', $faq_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('isNotUser', FaqCategory::class);
        try {
            $faq_category = FaqCategory::find($uuid); 
            $validator = Validator::make($request->all(), [
                'name' => 'required | unique:App\Models\FaqCategory,name,'.$faq_category->uuid,
                   
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $faq_category->update($request->all());
            return redirect()->route('faq_category.index')
                ->with('success', __('FAQ category updated'));

        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function destroy(Request $request, $uuid)
    {
        $this->authorize('isNotUser', FaqCategory::class);
        $faq_category = FaqCategory::find($uuid);
        $faq_category->delete();
        return redirect()->route('faq_category.index')
            ->with('success', __('FAQ category deleted'));
    }
}
