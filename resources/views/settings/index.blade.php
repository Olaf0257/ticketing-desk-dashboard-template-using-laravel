@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Settings') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Settings') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Value') }}</th>
                                     <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                    <tr>
                                        <td class="text-capitalize">{{ str_replace("_", " ", __($setting->name)) }}</td>
                                        <td>
                                        @if($setting->value != null)
                                            @if($setting->type == 'radio')
                                            @if (($setting->value) == '1')
                                            <span class="text-success-dark">{{ __('Enabled') }}</span>
                                            @elseif (($setting->value) == '0')
                                            <span class="text-danger">{{ __('Disabled') }}</span>
                                            @endif
                                            @elseif ($setting->type == 'attachment')
                                            <img src="/system_logo/{{ __($setting->value) }}" height="30px" width="180px" />
                                            @else
                                            {!! Str::limit(strip_tags($setting->value), 60) !!}
                                            @endif
                                        @else
                                        <i class="text-secondary">{{ __('Null') }}</i>
                                        @endif
                                        </td>
                                        <td class="justify-content-center form-inline">
                                            <a href="{{ route('settings.edit', [$setting->id]) }}"
                                                class="btn btn-sm bg-transparent"><i class="far fa-edit text-primary"
                                                    aria-hidden="true" title="{{ __('Edit') }}"></i></a>
                                        </td>
                                    </tr>
                                 @endforeach
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection