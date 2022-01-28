<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Logger;
use App\Helpers\Uuid;
use Illuminate\Support\Facades\Session;
use DB;

use App\Models\Services\TagService;

class TagController extends Controller
{
    public function __construct()
    {
        /*
        make sure only logged in and verified user has access
        to this controller
         */
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $this->authorize('isNotUser', Tag::class);
        $tags = Tag::all();
        return view(
            'tag.index',
            compact('tags')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isNotUser', Tag::class);
        $tags = Tag::all();
        // Display tags
        return view(
            'tag.create',
            compact('tags')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isNotUser', Tag::class);
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | unique:App\Models\Tag,name',
                'tag_color' => 'required ',
                'text_color' => 'required ',
                             
              ]);
  
              if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
              } 
  
              $tagService = new TagService();
              $tagService->addTag($request);
            
              return redirect()->route('tags.index')
                  ->with('success', __('Tag created'));
  
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
          }
      
    }

    public function edit(Request $request, $uuid)
    {
        $this->authorize('isNotUser', Tag::class);
        $tag = Tag::find($uuid);
        return view('tag.edit', compact('tag'));
    }

    public function update(Request $request, $uuid)
    {
        $this->authorize('isNotUser', Tag::class);
        // Get the tag
        $tag = Tag::find($uuid);
        $validator = Validator::make($request->all(), [
            'name' => 'required | unique:App\Models\Tag,name,'.$tag->uuid,
            'tag_color' => 'required',
            'text_color' => 'required ',                 
                              
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        // Update tag
        $tag->update($request->all());

        return redirect()->route('tags.index')
            ->with('success', __('Tag Updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $this->authorize('isNotUser', Tag::class);
        // Delete tag
        $tag = Tag::find($uuid);
        $tag->delete();

        return redirect()->route('tags.index')
           ->with('success', __('Tag deleted'));
    }

    public function getTagsApi(Request $request)
    {
        $tags = DB::table('tags')->get()->toJson(JSON_PRETTY_PRINT);
        return response($tags, 200);
    }
}
