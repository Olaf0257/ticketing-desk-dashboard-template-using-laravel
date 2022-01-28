@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Ticket Statuses') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('ticket_status.index') }}">{{ __('Ticket Statuses') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Add Status') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add Status') }}</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('ticket_status.store') }}">
                        @csrf
                        <div>
                            <div class="form-group row mb-4">
                                <label for="address"
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status title') }}*</label>
                                <div class="col-sm-12 col-md-7">

                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" autocomplete="title" autofocus>
                                    @error('title')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status color') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="color" type="text"
                                        class="form-control @error('color') is-invalid @enderror" name="color"
                                        value="{{ old('color') }}" autocomplete="color" autofocus placeholder="Eg: #fff">
                                    @error('color')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror

                                    <small class="text-secondary"><i class="fa fa-exclamation-circle"
                                            aria-hidden="true"></i>
                                        {{ __('The color code must be in hexadecimal format') }}.<br>
                                        {{ __('Reference: ') }} <a href="https://htmlcolorcodes.com/"
                                            target="_blank" rel="noopener noreferrer">
                                            {{ __('Color picker') }} </a>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Text color') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="text_color" type="text"
                                        class="form-control @error('color') is-invalid @enderror" name="text_color"
                                        value="{{ old('text_color') }}" autocomplete="text_color" autofocus placeholder="Eg: #fff">
                                    @error('text_color')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror

                                    <small class="text-secondary"><i class="fa fa-exclamation-circle"
                                            aria-hidden="true"></i>
                                        {{ __('The color code must be in hexadecimal format') }}.<br>
                                        {{ __('Reference: ') }} <a href="https://htmlcolorcodes.com/"
                                            target="_blank" rel="noopener noreferrer">
                                            {{ __('Color picker') }} </a>
                                    </small>
                                </div>
                            </div>

                            @if (env('APP_ENV') != 'demo')

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-custom">{{ __('Add') }}</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection