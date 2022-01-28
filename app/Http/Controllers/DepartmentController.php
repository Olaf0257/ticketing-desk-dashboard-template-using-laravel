<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use App\Services\Imap;
use App\Helpers\Logger;
use App\Models\Services\UserService;
use App\Jobs\ImapConnection;
use App\Jobs\SmtpConnection;
use Illuminate\Support\Facades\App;

class DepartmentController extends Controller
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
        $environment = App::environment();
        /*
        Check weather the user has access to this controller
         */
        $this->authorize('before', Department::class);
        // Get all departments
        $departments = Department::all();
        // Display the departments
        return view(
            'department.index',
            compact('departments')
        );
    }

    public function create(Request $request)
    {
        /*
        Check weather the user has access to this controller
         */
        $this->authorize('before', Department::class);
        // Display the create form
        return view('department.create');
    }

    public function store(Request $request)
    {
        /*
        Check weather the user has access to this controller
         */
        $this->authorize('before', Department::class);

        try {
            // $imap is a flag.
            $imap = false;
            // Check weather imap is enabled or not
            $setting = Setting::where('name', 'imap')
                ->first();
            if ($setting->value == '1') {
                // if imap is enabled.
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:App\Models\Department,name',
                    'email' => 'required | unique:App\Models\Department,email',
                    'host' => 'required',
                    'port' => 'required',
                    'password' => 'required',
                    'smtp_host' => 'required',
                    'smtp_port' => 'required',
                    'smtp_password' => 'required',
                ]);

                $flags = "";
                if (!empty($request->input('flags'))) {
                    $flags = $request->input('flags');
                }

                $mail_box = "";
                if (!empty($request->input('mail_box'))) {
                    $mail_box = $request->input('mail_box');
                }

                $pass = $request->input('password');
                $host = $request->input('host');
                $port = $request->input('port');
                $imap = true;
            } else {
                //if imap is not enabled.
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:App\Models\Department,name',
                    'email' => 'required | unique:App\Models\Department,email',
             ]);
            }

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            //create a new department
            $department = Department::create(
                $request->all()
            );

            /*
            if imap is enabled, run two jobs
            ImapConnection check weather the
            imap server details are valid or not.

            SmtpConnection job check weather the
            smtp server details are valid or not.
            */
            if ($imap) {
                ImapConnection::dispatch($department);
                SmtpConnection::dispatch($department);
            }
            if ($setting->value == '1'){
                return redirect()->route('department.index')
                ->with('error', __('We are validating your IMAP and SMTP details. Please check this page after 2 minutes. If status is still inactive please check the error logs.'));
            }else{
                return redirect()->route('department.index')
                ->with('success', __('Department added'));
            }
            
        } catch (\Exception $e) {
            //TODO: add the error to the error log ?
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    /*
    Department edit
     */
    public function edit(Request $request, $id)
    {
        //check permission
        $this->authorize('before', Department::class);
        // get the department
        $department = Department::find($id);
        // display the edit form.
        return view('department.edit', $department);
    }

    /*
    Update the department
     */
    public function update(Request $request, $id)
    {
        // check the user permission
        $this->authorize('before', Department::class);

        // imap flag
        $imap = false;
        try {
            /*
            Check weather imap is enabled or not
             */
            $setting = Setting::where('name', 'imap')->first();
            if ($setting->value == '1') {
                //if imap is enabled.
                $imap = true;
                $department = Department::find($id);
                // validate the form
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:App\Models\Department,name,'.$department->id,
                    'email' => 'required | unique:App\Models\Department,email,'.$department->id,
                    'host' => 'required',
                    'port' => 'required',
                    'password' => 'required',
                    'smtp_host' => 'required',
                    'smtp_port' => 'required',
                    'smtp_password' => 'required',
                ]);
            } else {
                //if imap is not enabled.
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:App\Models\Department,name',
                    'email' => 'required | unique:App\Models\Department,email',
                ]);
            }

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            /*
            Update the department.
             */
            $department = Department::find($id);
            $department->update($request->all());

            if ($imap) {
                /*
                If imap is enabled, run two jobs.
                 */
                ImapConnection::dispatch($department);
                SmtpConnection::dispatch($department);
            }

            if ($setting->value == '1'){
                return redirect()->route('department.index')
                ->with('error', __('We are validating your IMAP and SMTP details. Please check this page after 2 minutes. If status is still inactive please check the error logs.'));
            }else{
                return redirect()->route('department.index')
                ->with('success', __('Department updated'));
            }
        } catch (\Exception $e) {
            Logger::error("IMAP error");
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    /*
    Delete a department
     */
    public function destroy(Request $request, $id)
    {
        // check the user permission
        $this->authorize('before', Department::class);

        /*
        Delete the department
         */
        $department = Department::find($id);
        $department->delete();
        return redirect()->route('department.index')
            ->with('success', __('Department deleted'));
    }
}
