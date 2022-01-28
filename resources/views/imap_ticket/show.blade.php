@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Email Tickets') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('imap_ticket.index') }}">{{ __('Email Tickets') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Life Time Statistics') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">

                <div class="card-header">
                    <h4 class="inline-block">{{ __('Life Time Statistics') }}</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('imap_ticket.reply', [$ticket->uuid]) }}"><h4>#{{$ticket->tid}} - {{ $ticket->subject }}</h4></a>
                    <div class="table-responsive pt-1">
                        <table class="table table-striped pt-3" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Ticket Status') }}</th>
                                    <th>{{ __('Avg. Life Time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statuses as $key => $status)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ __($status->title) }}</td>
                                    <td>{{ isset($statusLife[$status->id]) ? round($statusLife[$status->id] / 60, 2) : "NA" }}
                                        {{ isset($statusLife[$status->id]) ? "Min" : "" }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection