@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Tickets') }}</h1>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('No Ticket') }}</h4>
                </div>
                <div class="card-body">
                    <div class="empty-state pt-3" data-height="400">
                        <div class="empty-state-icon bg-danger">
                            <i class="fas fa-question"></i>
                        </div>
                        <h2>{{ __('No tickets found') }} !!</h2>
                        <p class="lead">
                            {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection