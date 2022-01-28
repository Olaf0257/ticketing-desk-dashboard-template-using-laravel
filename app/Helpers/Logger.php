<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    public static function emergency($message)
    {
        Log::emergency($message);
    }

    public static function info($message)
    {
        Log::info($message);
    }

    public static function error($message)
    {
        Log::error($message);
    }
}
