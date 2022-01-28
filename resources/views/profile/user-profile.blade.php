@extends('layouts.new_user_theme')

@section('content')

<div class="section-header">
    <h1><a href="{{ route('ticket.index') }}"><i
                class="fas fa-arrow-circle-left custom-back"></i></a> {{ __('Profile') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Profile') }}</div>
    </div>
</div>
<div class="section-body">

    @include('common.demo')
    @include('common.errors')
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="/images/avatar-1.png" class="rounded-circle profile-widget-picture">
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name text-capitalize">{{ $name }}</div>
                    <div class="text-custom d-inline mr-2 text-capitalize">
                        {{ __($role) }}
                    </div>
                    <div>
                        <div>{{ $email }}</div>
                        @if (Auth::check() && Auth::user()->role == 'staff')
                        <div><b>{{ __('Departments:') }}</b></div>

                        @foreach($departments as $department)
                        @if (in_array($department->id, $selected_department))
                        <div class="ml-3">
                            <div>
                                - {{__($department->name)}}<br>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @if (empty($selected_department))
                        <div class="ml-3">- {{__('No departments')}}</div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8 pt-lg-5-custom">
            <div class="card">
                <form method="POST" action="{{ route('profileUpdate') }}">
                    @csrf
                    <div class="card-header">
                        <h4>{{ __('Edit Profile') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>{{ __('Name') }}*</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $name) }}" autocomplete="name" autofocus>
                                @error('name')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>{{ __('Email') }}*</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $email) }}" autocomplete="name" autofocus
                                    {{ ( $role == 'admin' ) ? '' : 'readonly' }}>
                                @error('email')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>{{ __('Old Password') }}*</label>
                                <input id="old_password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                                    value="" autocomplete="old_password" autofocus
                                    placeholder="{{__('Enter if you want to change')}}">
                                @error('old_password')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>{{ __('New password') }}*</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" autocomplete="password" autofocus>
                                @error('password')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>{{ __('Confirm password') }}*</label>
                                <input id="c_password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="c_password"
                                    value="" autocomplete="c_password" autofocus>
                                @error('c_password')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    @if (env('APP_ENV') != 'demo')
                    <div class="card-footer text-right">
                        <button class="btn btn-custom">{{ __('Update') }}</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>

    </div>
</div>
@endsection