<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class Uuid
{
    public static function getUuid()
    {
        return Str::uuid()->toString();
    }
}
