@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Settings') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('settings.index') }}">{{ __('Settings') }}</a>
        </div>
        <div class="breadcrumb-item text-capitalize">{{ str_replace("_", " ", __("$name")) }} {{ __('Settings') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4 class="text-capitalize">{{ str_replace("_", " ", __("$name")) }} {{ __('Settings') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.update', $id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ str_replace("_", " ", __("$name")) }}:</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-radio custom-control">
                                    <input class="custom-control-input" type="radio" name="Enable" id="Enable"
                                        value="enable" {{ ($value == 1)? "checked" : "" }}>
                                    <label class="custom-control-label" for="Enable">
                                        {{ __('Enable') }}
                                    </label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input class="custom-control-input" type="radio" name="Enable" id="Disable"
                                        value="disble" {{ ($value == 0)? "checked" : "" }}>
                                    <label class="custom-control-label" for="Disable">
                                        {{ __('Disable') }}
                                    </label>
                                </div>
                                <small class="form-text text-muted"><i class="fa fa-exclamation-circle"
                                        aria-hidden="true"></i>
                                    {{ __($description) }}.
                                    <br>
                                </small>
                            </div>
                        </div>

                        @if (env('APP_ENV') != 'demo')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-custom">{{ __('Save') }}</button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection