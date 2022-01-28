@extends('layouts.public')

@section('content')

<div class="section-header col-12 col-md-10 offset-md-1">
    <h1>{{ __('Knowledge Base') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Knowledge Base categories') }}</h4>
                </div>
                <div class="card">
                    @if (!count($categories))
                    <div class="empty-state pt-3" data-height="400">
                        <div class="empty-state-icon bg-custom">
                            <i class="fas fa-question"></i>
                        </div>
                        <h2>{{ __('No data found') }} !!</h2>
                        <p class="lead">
                            {{ __('Sorry we cant find any data') }}.
                        </p>
                    </div>
                    @else
                    <div class="row ml-md-5">
                        @foreach($categories as $category)
                        <div class="col-12 col-md-6 col-lg-4 wizard-steps">
                            <div class="card-body">
                                <a href="{{ route('articles.show', [$category->uuid]) }}">
                                    <div class="wizard-step">
                                        <div class="wizard-step-icon text-custom">
                                            {!! $category->icon !!}
                                        </div>
                                        <div class="wizard-step-label align">
                                            {{ __($category->name) }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection