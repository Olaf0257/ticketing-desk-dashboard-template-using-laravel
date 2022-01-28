@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Permissions') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Update Permissions') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Update Permissions') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('permissionUpdate') }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">

                        @foreach ($permissions as $permission)
                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3 text-capitalize">{{str_replace("_", " ", __("$permission->name"))}}:*</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="row">
                                    <div class="custom-radio custom-control ml-3">
                                        <input class="custom-control-input" type="radio"
                                            name="status[{{ $permission->uuid }}]" id="enable[{{ $permission->uuid }}]"
                                            value=1 {{ ($permission->status == 1)? "checked" : "" }}>
                                        <label class="custom-control-label" for="enable[{{ $permission->uuid }}]">
                                            {{ __('Enable') }}
                                        </label>
                                    </div>
                                    <div class="custom-radio custom-control ml-3">
                                        <input class="custom-control-input" type="radio"
                                            name="status[{{ $permission->uuid }}]" id="disable[{{ $permission->uuid }}]"
                                            value=0 {{ ($permission->status == 0)? "checked" : "" }}>
                                        <label class="custom-control-label" for="disable[{{ $permission->uuid }}]">
                                            {{ __('Disable') }}
                                        </label>
                                    </div>
                                </div>

                                <small id="address_help3" class="form-text text-muted"><i
                                        class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    {{ __("$permission->description") }}
                                </small>
                            </div>
                        </div>
                        <br>
                        @endforeach
                        @if (env('APP_ENV') != 'demo')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-custom"> {{ __('Update') }}</button>
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