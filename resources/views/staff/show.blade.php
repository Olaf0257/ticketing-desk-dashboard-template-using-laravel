@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Staffs') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('staff.index') }}">{{ __('Staffs') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Life Time Statistics') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card col-12">
                <div class="row">
                    <div class="card col-md-6">
                        <div class="col-11 mt-5">
                            <div class="card card-statistic-1">
                                <a href="{{ route('ticket.index') }}">
                                    <div>
                                        <div class="card-wrap">
                                            <div class="card-body">
                                                <h4>{{ __($staff->name) }}</h4>
                                                <h5 class="text-secondary">{{ __($staff->email) }}</h5> <br>
                                                {{ __("Departments") }}: <br>
                                                @foreach ($staff->departments as $department)
                                                &emsp;&emsp;<small>{{ $department->name }}</small><br>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-6">
                        <div class="mt-5">
                            <div class="col-11">
                                <div class="card card-statistic-1 box-shadow-all">
                                    <div>
                                        <div class="custom-card-icon bg-custom">
                                            <i class="fas fa-bolt"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>{{ __('Avg. Response Time') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ ($avg_response_time != 0) ? "$avg_response_time Min" : "NA"}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-11">
                                <div class="card card-statistic-1 box-shadow-all">
                                    <div>
                                        <div class="custom-card-icon bg-custom">
                                            <i class="far fa-building"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>{{ __('Departments') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ count($staff->departments) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="inline-block">{{ __('Life Time Statistics') }}</h4>
                </div>
                <div class="card-body">
                    {{-- <a href="{{ route('imap_ticket.reply', [$ticket->uuid]) }}"> --}}
                    {{-- <h4>#{{$ticket->tid}} - {{ $ticket->title }}</h4> --}}
                    </a>
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
                                    <td>{{ $status->title }}</td>
                                    <td>{{ isset($lifeTime[$status->id]) ? round($lifeTime[$status->id] / 60, 2) : "NA" }}
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