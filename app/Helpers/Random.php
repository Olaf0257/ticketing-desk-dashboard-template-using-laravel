<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Helpers\Logger;

class Random
{
    public static function getTicketNumber()
    {
        while (1) {
            $tid = rand(1000000, 9999999);
            Logger::info("Generating the ticket id");
            Logger::info("tid generated: " . $tid);
            $count = Ticket::where('tid', $tid)->count();

            if ($count > 0) {
                Logger::info("tid $tid already exist.");
                continue;
            }
            return $tid;
        }
    }
}
