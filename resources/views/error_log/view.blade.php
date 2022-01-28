@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Error Logs') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('error_log.index') }}">{{ __('Error Logs') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Error Log') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block text-capitalize">{{ __('Section') }} : {{ __($error_log->section) }}</h4>
                </div>
                <div class="card-body">
                    <div class="col-12 mb-4">
                        <div class="hero bg-white p-1">
                            <div class="hero-inner">
                                <h2>{{ $error_log->title }}</h2><br>
                                <p class="lead">{{ $error_log->error_text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection