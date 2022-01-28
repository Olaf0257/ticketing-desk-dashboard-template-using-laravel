<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Helpers\Uuid;
use Illuminate\Support\Str;
use App\Helpers\Logger;
use App\Models\Services\FaqService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
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
        $this->authorize('isNotUser', Faq::class);
        $faqs = Faq::paginate(10);
        $params = [
            'faqs' => $faqs,
            'request' => $request
        ];
        return view('faq.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $this->authorize('isNotUser', Faq::class);
        $faq = Faq::all();
        $categories = FaqCategory::all();
        $params = [
            'categories' => $categories,
            'faq' => $faq
        ];
        return view('faq.create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('isNotUser', Faq::class);
        try {
           
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'question' => 'required|max:200',
                'answer' => 'required'
            ]);
            $faqService = new FaqService();
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
           
            $faq= $faqService->addFaq( $request);
                return redirect()->route('faq.index')
                ->with('success', __('FAQ added'));
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
        $this->authorize('isNotUser', Faq::class);
        $faq = Faq::find($uuid);
        $categories = FaqCategory::all();
        return view('faq.edit', compact('faq','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('isNotUser', Faq::class);
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'question' => 'required',
                'answer' => 'required'
                   
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $faq = Faq::find($uuid);
            $categories = FaqCategory::all();
            $faq->update($request->all());
            return redirect()->route('faq.index')
                ->with('success', __('FAQ updated'));

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
        $this->authorize('isNotUser', Faq::class);
        $faq = Faq::find($uuid);
        $faq->delete();
        return redirect()->route('faq.index')
            ->with('success', __('FAQ deleted'));
    }
}







    
