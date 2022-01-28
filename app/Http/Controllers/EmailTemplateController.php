<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Logger;
use App\Helpers\Uuid;
use App\Models\Services\EmailTemplateService;
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $languages = Language::all();
        $system_emails = EmailTemplate::where('system_template', true)->get();
        $custom_emails = EmailTemplate::where('system_template', false)->get();
        // Display the emailtemplate
        $params = [
            'languages' => $languages,
            'system_emails' => $system_emails,
            'custom_emails' => $custom_emails,
        ];
        return view('email_template.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
     {
        $languages = Language::all();
     
        $email = EmailTemplate::all();
        return view(
            'email_template.create',
            compact('email','languages')
        );
     }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $email  = EmailTemplate::all();
            $validator = Validator::make($request->all(), [
                   'name' => 'required',
                   'subject' => 'required ',
                   'message' => 'required',
                   'status'=> 'required'  ,
                   'language_id' => 'required'  ,                 
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            } 

            $emailTemplateService = new EmailTemplateService();
            $emailTemplateService->addEmailTemplate($request);
          
            return redirect()->route('email_template.index')
                ->with('success', __('Email template added'));

        } catch (\Exception $e) {
            dd($e->getMessage());
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
        $email = EmailTemplate::find($uuid);
        return view('email_template.edit', compact('email'));
    }


    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, $uuid)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'subject' => 'required ',
                'message' => 'required',
                'status'=> 'required',              
            ]);     
    
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            // Get the emailTemplate
            $email = EmailTemplate::find($uuid);
            $language = Language::all();
            
            // Update emailTemplate
            $email->update($request->all());
            return redirect()->route('email_template.index')
                ->with('success', __('Email Template Updated'));
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        // Delete emailtemplate
        $email = EmailTemplate::find($uuid);
        $email->delete();

        return redirect()->route('email_template.index')
            ->with('success', __('Email template deleted'));
    }
    
}