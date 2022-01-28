@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Dashboard') }}</h1>
</div>

<div class="section-body">
@if (($imap_enables->value) == '1')
<h2 class="section-title">{{ __('Web Tickets') }}</h2>
@endif
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
                                <h4>{{ __('Total Tickets') }}</h4>
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
                                <h4>{{ __('Open Tickets') }}</h4>
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
                                <h4>{{ __('Awaiting Tickets') }}</h4>
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
                    <div>
                        <div class="custom-card-icon bg-warning">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Response Time') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $dashboard['webTicketLife'] }} <small>{{ __('min') }}</small>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    @if (($imap_enables->value) == '1')
    <h2 class="section-title">{{ __('Email Tickets') }}</h2>
    <div class="row">
        
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('imap_ticket.index') }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-1">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total Tickets') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $emailTicketCount['total'] }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('imapTickets', 1) }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-2">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Open Tickets') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ !empty($emailTicketCount['status'][1]) ? $emailTicketCount['status'][1] : "0" }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <a href="{{ route('imapTickets', 6) }}">
                    <div>
                        <div class="custom-card-icon bg-card-dash-3">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Awaiting Tickets') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ !empty($emailTicketCount['status'][6]) ? $emailTicketCount['status'][6] : "0" }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                    <div>
                        <div class="custom-card-icon bg-warning">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Response Time') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $dashboard['mailTicketLife'] }} <small>{{ __('min') }}</small>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Week Status') }}</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Tickets By Status') }}</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">

                <div class="card-header">
                    <h4 class="inline-block">{{ __('Latest Tickets') }}</h4>
                    <a href="{{ route('ticket.index') }}" class="btn btn-icon btn-custom float-right inline-block"><i
                            class="far fa-edit"></i>{{ __('See All') }}</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive pt-1">
                        @if (!count($dashboard['tickets']))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No tickets found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                            <a href="" class="btn btn-custom mt-4">{{ __('Create new One') }}</a>
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
                                @foreach ($dashboard['tickets'] as $ticket)

                                @if ($ticket->ticketUnread )
                                <tr class="bg-table-custom font-weight-bold-custom">
                                    <td>#{{ ($ticket->tid) }}</td>
                                    <td><a class="font-weight-bold-custom"
                                            href="{{ route('ticket.reply', [$ticket->uuid]) }}">{{ Str::limit($ticket->title, 30) }}</a>
                                    </td>
                                    <td><span class="badge text-white"
                                            style="color: {{$ticket->ticketStatus->text_color}} !important;background-color: {{$ticket->ticketStatus->color}} !important;">{{ __($ticket->ticketStatus->title) }}</span>
                                    </td>
                                    <td>{{ __($ticket->ticketUrgency->name)}}
                                    </td>
                                    <td>{{ __($ticket->department->name) }}
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
                                    <td>{{ __($ticket->department->name) }}
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
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Graph releated script starts here -->
<script>
    var line_labels = <?php echo json_encode($line_labels) ?>;
    var line_data = <?php echo json_encode($line_data) ?>;

    var doughnut_labels = <?php echo json_encode($doughnut_labels) ?>;
    var doughnut_data = <?php echo json_encode($doughnut_data) ?>;
    var doughnut_bgColors = <?php echo json_encode($doughnut_bgColors) ?>;
</script>

<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/ticket_graphs.js') }}"></script>
<!-- Graph releated script ends here -->
@endsection
