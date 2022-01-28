@extends('layouts.new_user_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Tickets') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Tickets') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('ticket.index') }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-1">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('ALL TICKETS') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $ticketCount['total'] }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('tickets', 1) }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-2">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('OPEN') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ !empty($ticketCount['status'][1]) ? $ticketCount['status'][1] : "0" }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('tickets', 6) }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-3">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('AWAITING') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ !empty($ticketCount['status'][6]) ? $ticketCount['status'][6] : "0" }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('tickets', 4) }}">
                    <div>
                        <div class="custom-card-icon bg-success-dark">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('ANSWERED') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ !empty($ticketCount['status'][4]) ? $ticketCount['status'][4] : "0" }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">

                <div class="card-header">
                    <h4 class="inline-block">{{ __('List of Tickets') }}</h4>
                    <a href="{{ route('ticket.create') }}" class="btn btn-icon btn-custom float-right inline-block"><i
                            class="far fa-edit"></i>{{ __('Open Ticket') }}</a>
                </div>
                <div class="card-body">
                    <div class="search-bar">
                        <form action="/ticket" method="get">
                            @csrf
                            <input type="hidden" name="action" value="modify_ticket" />
                            <div class="input-group mb-2">
                                <input type="text" name="search" class="form-control search-bar-input"
                                    placeholder="Search" value="{{ request()->input('search') }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-custom search-bar-button"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive pt-1">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('ticket.index') }}"></i><span>{{ __('All Tickets') }}</span></a>
                            </li>
                            @foreach ($statuses as $status)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->route('id') == $status->id ? 'active' : '' }}"
                                    href="{{ route('tickets', [$status->id]) }}"><span>{{ __($status->title) }}</span></a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="user-ticket-divider"></div>
                        @if (!count($tickets))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No tickets found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                        </div>
                        @else
                        <table class="table table-striped pt-3" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Ticket ID') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Priority') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Last action') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)

                                @if ($ticket->ticketUnread )
                                <tr class="bg-table-custom font-weight-bold-custom">
                                    <td>#{{ ($ticket->tid) }}</td>
                                    <td><a class="font-weight-bold-custom"
                                            href="{{ route('ticket.reply', [$ticket->uuid]) }}">{{ Str::limit($ticket->title, 30) }}</a>
                                    </td>
                                    <td><span class="badge text-white"
                                            style="color: {{$ticket->ticketStatus->text_color}} !important;background-color: {{$ticket->ticketStatus->color}} !important;">{{ __($ticket->ticketStatus->title) }}</span>
                                    </td>
                                    <td>{{ __($ticket->ticketUrgency->name) }}
                                    </td>
                                    <td>{{__($ticket->department->name)}}
                                    </td>
                                    <td>{{$ticket->last_touched_at->diffForHumans()}}
                                    </td>
                                    @if (env('APP_ENV') != 'demo')
                                    <td>
                                        <form action="{{ route('ticket.destroy', [$ticket->uuid]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn bg-transparent"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash text-danger" aria-hidden="true"
                                                    title="{{ __('Delete') }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @else
                                <tr>
                                    <td>#{{ ($ticket->tid) }}</td>
                                    <td><a
                                            href="{{ route('ticket.reply', [$ticket->uuid]) }}">{{ Str::limit($ticket->title, 30) }}</a>
                                    </td>
                                    <td><span class="badge text-white"
                                            style="color: {{$ticket->ticketStatus->text_color}} !important;background-color: {{$ticket->ticketStatus->color}} !important;">{{ __($ticket->ticketStatus->title) }}</span>
                                    </td>
                                    <td>{{ __($ticket->ticketUrgency->name) }}
                                    </td>
                                    <td>{{__($ticket->department->name)}}
                                    </td>
                                    <td>{{$ticket->last_touched_at->diffForHumans()}}
                                    </td>
                                    @if (env('APP_ENV') != 'demo')
                                    <td>
                                        <form action="{{ route('ticket.destroy', [$ticket->uuid]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn bg-transparent"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash text-danger" aria-hidden="true"
                                                    title="{{ __('Delete') }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $tickets->appends($request->all())->links("pagination::bootstrap-4") }}

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection