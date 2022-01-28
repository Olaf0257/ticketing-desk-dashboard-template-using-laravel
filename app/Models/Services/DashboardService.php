<?php

namespace App\Models\Services;
use Carbon\Carbon;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Department;
use App\Models\TicketStatus;
use App\Models\TicketStatusLife;
use App\Models\ImapTicketStatusLife;

class DashboardService
{
    /** 
     * Get dashboard contents
    */ 
    public function dashboard($user, $dep)
    {
        $dashboard = [];
        if (empty($user)) {
            return;
        }
        if ($user->role == "staff") {
            $dashboard['tickets'] = Ticket::whereIn('department_id', $dep)
                ->latest()->take(5)->get();

            $webTicketLife = TicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->groupBy('previous_status_id')
                ->whereHas('ticket', function ($query) use ($dep){
                    $query->whereIn('department_id', $dep);
                })->pluck('total', 'previous_status_id')->all();
            $mailTicketLife = ImapTicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
                ->groupBy('previous_status_id')
                ->whereHas('ticket', function ($query) use ($dep){
                    $query->whereIn('department_id', $dep);
                })->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->pluck('total', 'previous_status_id')->all();
            $dashboard['webTicketLife'] = 0;
            if (isset($webTicketLife[1])){
                $dashboard['webTicketLife'] = $dashboard['webTicketLife'] + $webTicketLife[1];
            }
            if (isset($webTicketLife[6])){
                $dashboard['webTicketLife'] = $dashboard['webTicketLife'] + $webTicketLife[6];
            }
            if ($dashboard['webTicketLife'] != 0){
                $dashboard['webTicketLife'] = round ((($dashboard['webTicketLife'] / 2) / 60), 1);
            }

            $dashboard['mailTicketLife'] = 0;
            if (isset($mailTicketLife[1])){
                $dashboard['mailTicketLife'] = $dashboard['mailTicketLife'] + $mailTicketLife[1];
            }
            if (isset($mailTicketLife[6])){
                $dashboard['mailTicketLife'] = $dashboard['mailTicketLife'] + $mailTicketLife[6];
            }
            if ($dashboard['mailTicketLife'] != 0){
                $dashboard['mailTicketLife'] = round ((($dashboard['mailTicketLife'] / 2) / 60), 1);
            }
            return $dashboard;
        } elseif ($user->role == "admin") {

            $dashboard['tickets'] = Ticket::latest()->take(5)->get();
            $dashboard['users'] =  User::where('role', 'staff')
                ->count();
            $dashboard['departments'] = Department::count();

            $webTicketLife = TicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->groupBy('previous_status_id')
                ->pluck('total', 'previous_status_id')->all();
            $mailTicketLife = ImapTicketStatusLife::selectRaw('avg(life_time) as total, previous_status_id')
                ->groupBy('previous_status_id')
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->pluck('total', 'previous_status_id')->all();
            
            $dashboard['webTicketLife'] = 0;
            if (isset($webTicketLife[1])){
                $dashboard['webTicketLife'] = $dashboard['webTicketLife'] + $webTicketLife[1];
            }
            if (isset($webTicketLife[6])){
                $dashboard['webTicketLife'] = $dashboard['webTicketLife'] + $webTicketLife[6];
            }
            if ($dashboard['webTicketLife'] != 0){
                $dashboard['webTicketLife'] = round ((($dashboard['webTicketLife'] / 2) / 60), 1);
            }
    
            $dashboard['mailTicketLife'] = 0;
            if (isset($mailTicketLife[1])){
                $dashboard['mailTicketLife'] = $dashboard['mailTicketLife'] + $mailTicketLife[1];
            }
            if (isset($mailTicketLife[6])){
                $dashboard['mailTicketLife'] = $dashboard['mailTicketLife'] + $mailTicketLife[6];
            }
            if ($dashboard['mailTicketLife'] != 0){
                $dashboard['mailTicketLife'] = round ((($dashboard['mailTicketLife'] / 2) / 60), 1);
            }
            return $dashboard;
        }
    }

    public function graphData($user, $dep)
    {
        $graphData = [];
        $tickets = Ticket::all();
        if (empty($user)) {
            return;
        }
        if ($user->role == "staff") {
            for ($i=0; $i<7; $i++){
                //Get the date in the format of dd-Month (eg: 02-Jun)
                $dateList = Carbon::now()->subDays($i)->startOfDay()->format('D');
                //Get the start of the day
                $startDate = Carbon::now()->subDays($i)->startOfDay()->format('Y-m-d H:i:s');
                //Get the end of the day
                $endDate = Carbon::now()->subDays($i)->endOfDay()->format('Y-m-d H:i:s');
                //Get that day logs
                $weekDayTickets = $tickets->whereIn('department_id', $dep)
                    ->whereBetween('created_at', [$startDate, $endDate])->count();

                $graphData['date'][] = $dateList;
                $graphData['tickets'][] = $weekDayTickets;
            }
            $statuses = TicketStatus::all();
            foreach ($statuses as $status) {
                $graphData['status'][] = $status->title;
                $graphData['ticketsByStatus'][] = $tickets->whereIn('department_id', $dep)
                    ->where('ticket_status_id', $status->id)->count();
                $graphData['statusColor'][] = $status->color;
            }
        } elseif ($user->role == "admin") {

            for ($i=0; $i<7; $i++){
                //Get the date in the format of dd-Month (eg: 02-Jun)
                $dateList = Carbon::now()->subDays($i)->startOfDay()->format('D');
                //Get the start of the day
                $startDate = Carbon::now()->subDays($i)->startOfDay()->format('Y-m-d H:i:s');
                //Get the end of the day
                $endDate = Carbon::now()->subDays($i)->endOfDay()->format('Y-m-d H:i:s');
                //Get that day logs
                $weekDayTickets = $tickets->whereBetween('created_at', [$startDate, $endDate])->count();

                $graphData['date'][] = $dateList;
                $graphData['tickets'][] = $weekDayTickets;
            }
            $statuses = TicketStatus::all();
            foreach ($statuses as $status) {
                $graphData['status'][] = $status->title;
                $graphData['ticketsByStatus'][] = $tickets->where('ticket_status_id', $status->id)->count();
                $graphData['statusColor'][] = $status->color;
            }
        }
        return $graphData;
    }
}