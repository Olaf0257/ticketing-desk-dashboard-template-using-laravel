<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Language;
use App\Models\Services\UserService;

class LanguageController extends Controller
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
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Language::class);

        // List the available languages
        $languages = Language::all();
        return view('language.index', compact('languages'));
    }

    public function store(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Language::class);

        try {
            $validator = Validator::make($request->all(), [
                   'language' => 'required',
                   'code' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
             //Add a new language
            $language = new Language();
            $language->language = $request->language;
            $language->code = $request->code;
            $language->save();

            return redirect()->route('language.index')
                ->with('success', __('Language added'));
        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function destroy($id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Language::class);
        
        /*
        Delete a language
        */
        $language = Language::find($id);
        $language->delete();
        return redirect()->route('language.index')
            ->with('success', __('Language deleted'));
    }

}
