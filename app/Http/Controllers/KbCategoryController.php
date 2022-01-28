<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KbCategory;
use App\Helpers\Uuid;
use App\Helpers\Logger;
use App\Models\Services\KbCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AttachmentHelper;

class KbCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('isNotUser', KbCategory::class);
        $kb_categories = KbCategory::paginate(10);
        $params = [
            'kb_categories' => $kb_categories,
            'request' => $request
        ];
        return view('kb_category.index', $params);
    }

    public function create()
    {
        $this->authorize('isNotUser', KbCategory::class);
        return view('kb_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('isNotUser', KbCategory::class);
        try {
            $kb_category = KbCategory::all();
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:App\Models\KbCategory,name|max:15',
                'description' => 'required',
                'icon' => 'required',
            ]);
           
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $kbCategoryService = new KbCategoryService();
            $kbCategoryService->addCategory( $request);

            return redirect()->route('kb_category.index')
                ->with('success', __('KB Category added'));
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
        $this->authorize('isNotUser', KbCategory::class);
        $kb_category = KbCategory::find($uuid);
        return view('kb_category.edit', $kb_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('isNotUser', KbCategory::class);
        try {
            $kb_category = KbCategory::find($uuid);
            $validator = Validator::make($request->all(), [
                'name' => 'required | max:15 | unique:App\Models\KbCategory,name,'.$kb_category->uuid,
                'description' => 'required',
                'icon' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $updateArray = [];

            $updateArray['icon'] = $request->icon;
            $updateArray['name'] = $request->name;
            $updateArray['description'] = $request->description;
            $kb_category->update($updateArray);
            return redirect()->route('kb_category.index')
                ->with('success', __('KB category updated'));

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
        $this->authorize('isNotUser', KbCategory::class);
        $kb_category = KbCategory::find($uuid);
        $kb_category->delete();
        return redirect()->route('kb_category.index')
            ->with('success', __('KB category deleted'));
    }
}
