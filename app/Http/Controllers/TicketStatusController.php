<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TicketStatus;
use App\Models\Services\UserService;

class TicketStatusController extends Controller
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
        $this->authorize('before', TicketStatus::class);

        // Get all ticket statuses
        $statuses = TicketStatus::all();
        // Display ticket statuses page
        return view('ticket_status.index', compact('statuses'));
    }

    public function create(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', TicketStatus::class);

        // Display create ticket status page
        return view('ticket_status.create');
    }

    public function store(Request $request)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', TicketStatus::class);

        // Add a ticket status
        try {
            $validator = Validator::make($request->all(), [
                   'title' => 'required | unique:App\Models\TicketStatus,title',
                   'color' => 'required',
                   'text_color' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $data = $request->only('title', 'color');
            // create object for TicketStatus
            $ticketStatus = new TicketStatus();
            $ticketStatus->title = $request->title;
            $ticketStatus->color = $request->color;
            $ticketStatus->text_color = $request->text_color;
            $ticketStatus->save();

            return redirect()->route('ticket_status.index')
                ->with('success', __('Server added'));
        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function edit(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', TicketStatus::class);

        // Get the ticket status
        $status = TicketStatus::find($id);
        // display update ticket status page
        return view('ticket_status.edit', $status);
    }

    public function update(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', TicketStatus::class);

        try {
            $status = TicketStatus::find($id);
            $validator = Validator::make($request->all(), [
                   'title' => 'required | unique:App\Models\TicketStatus,title,'.$status->id,
                   'color' => 'required',
                   'text_color' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            // Update ticket status
            $status->update($request->all());
            return redirect()->route('ticket_status.index')
                ->with('success', __('Ticket status updated'));

        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }
    }

    public function destroy(Request $request, $id)
    {
        /*
        Check weather the user has access to this function
        */
        $this->authorize('before', TicketStatus::class);

        // Delete ticket status
        $status = TicketStatus::find($id);
        $status->delete();
        return redirect()->route('ticket_status.index')
            ->with('success', __('Ticket status deleted'));
    }
}
