<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services\TicketService;
use App\Models\Services\ImapTicketService;
use App\Models\Services\DashboardService;

class DashboardController extends Controller
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
        $user = auth()->user();
        if ($user->role != 'user'){
            // Get all departments of the logged in user
            $dep = $user->departments()->pluck('department_id')->toArray();

            /*
            Create an object of TicketService,
            TicketService has functions that interact with the
            Ticket model
            */
            $ticketService = new TicketService();
            $emailTicketService = new ImapTicketService();

            /*
            Create an object of DashboardService,
            */
            $dashboardService = new DashboardService();

            /**
             * Call ticketCount() function from TicketService to get the count of tickets
             */
            $ticketCount = $ticketService->ticketCount($user, $dep);
            $emailTicketCount = $emailTicketService->ticketCount($user, $dep);

            /**
             * Call dashboard() function from DashboardService to get the dashboard data
             */
            $dashboard = $dashboardService->dashboard($user, $dep);
            $graphData = $dashboardService->graphData($user, $dep);

            $params = [
                'ticketCount' => $ticketCount,
                'dashboard' => $dashboard,
                'emailTicketCount' => $emailTicketCount,

                // line graph params
                'line_labels' => $graphData['date'],
                'line_data' => $graphData['tickets'],

                // doughnut graph
                'doughnut_labels' => $graphData['status'],
                'doughnut_data' => $graphData['ticketsByStatus'],
                'doughnut_bgColors' => $graphData['statusColor']

            ];
            return view('dashboard.index', $params);
        } else {
            return redirect()->route('ticket.index');
        }
    }
}
