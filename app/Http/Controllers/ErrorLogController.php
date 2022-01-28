<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ErrorLog;

class ErrorLogController extends Controller
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
        Check weather the user has access to this controller
         */
        $this->authorize( 'before', ErrorLog::class);
        // Get all error logs order by time.
        $error_logs = ErrorLog::orderBy('created_at', 'DESC')->paginate(10);
        $params = [
            'request' => $request,
            'error_logs' => $error_logs,
        ];
        // Display the error logs
        return view('error_log.index', $params);
    }

    public function show($id)
    {
        /*
        Check weather the user has access to this controller
         */
        $this->authorize( 'before', ErrorLog::class);
        // Get the error log
        $error_log = ErrorLog::find($id);
        // View the selected error log
        return view('error_log.view', compact('error_log'));

    }
}
