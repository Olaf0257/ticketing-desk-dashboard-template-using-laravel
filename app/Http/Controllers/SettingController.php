<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;
use App\Models\Services\UserService;
use App\Helpers\AttachmentHelper;



use App\Helpers\Logger;

class SettingController extends Controller
{
    public function __construct()
    {
        /*
        make sure only logged in and verified user has access
        to this controller
        */
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Setting::class);

        // Display the settings page
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function edit(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Setting::class);

        $setting = Setting::find($id);
        // Display imap enable page
        if ($setting->type == 'radio') {
            return view('settings.radio', $setting);
        // Display add extension page
        } elseif ($setting->type == 'text') {
            return view('settings.text', $setting);
        }
        elseif ($setting->type == 'attachment') {
            return view('settings.attachment', $setting);
        }
        elseif ($setting->type == 'text_area') {
            return view('settings.textarea', $setting);
        }
    }

    public function update(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', Setting::class);

        // Get the settings
        $setting = Setting::find($id);

        // Enable Imap
        if ($setting->type == 'radio') {
            $updateArray = [];
            if ($request->Enable == "enable") {
                $updateArray['value'] = 1;
            } else {
                $updateArray['value'] = 0;
            }
            $setting->update($updateArray);
        // Add extensions
        } elseif ($setting->type == 'text') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'text' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
            }
            
            // update settings
            $updateArray = [];
            $updateArray['value'] = $request->text;
            $setting->update($updateArray);
        } elseif ($setting->type == 'text_area') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'textarea' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
            }
            
            // update settings
            $updateArray = [];
            $updateArray['value'] = $request->textarea;
            $setting->update($updateArray);

        } elseif ($setting->type == 'attachment') {
           $validator = Validator::make($request->all(), [
              'name' => 'required',
           ]);
           if ($validator->fails()) {
                return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
            }
           $updateArray = [];
           if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $validator = Validator::make($request->all(), [
                    'attachment' => "required|mimes:png,svg,"
                ]);

               if ($validator->fails()) {
                    return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', __('Invalid file format'));
                }
             
               // Set attachment name store to database
                $attachmentHelper = new AttachmentHelper();
                $fileName = $attachmentHelper->privateIconStore($file, 'system_logo');
                $updateArray['value']  = $fileName;     
            }
            // Update settings 
            // $updateArray['value'] = $request->attachment;          
            $setting->update($updateArray);
             
        }
        return redirect()->route('settings.index')
            ->with('success', __('Settings updated'));
    } 
}
        
  