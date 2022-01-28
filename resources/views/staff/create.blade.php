@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Staffs') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('staff.index') }}">{{ __('Staffs') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Add a Staff') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add a Staff') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('staff.store') }}">
                        @csrf
                        <div>
                            <div class="form-group row mb-4">
                                <label for="address"
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}*</label>
                                <div class="col-sm-12 col-md-7">

                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>
                                    @error('name')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}*</label>
                                <div class="col-sm-12 col-md-7">

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="name" autofocus>
                                    @error('email')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Role') }}</label>
                                <div class="col-sm-12 col-md-7">

                                    <input id="role" type="text"
                                        class="form-control @error('role') is-invalid @enderror" name="role"
                                        value="{{ old('role') }}" autocomplete="role" autofocus
                                        placeholder="{{ __('Eg: Marketing Head') }}">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Department(s)') }}*</label>
                                <div class="col-sm-12 col-md-7">
                                    @foreach($department as $key=>$department)
                                    <input type="checkbox" id="department" name="department[]"
                                        value="{{$department->id}}"
                                        {{ is_array(old('department')) && in_array($department->id, old('department')) ? 'checked' : ''}}>
                                    <label for="department"> {{__($department->name)}}</label><br>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Password') }}*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        value="{{ old('password') }}" autocomplete="name" autofocus>
                                    @error('password')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted"><i class="fa fa-exclamation-circle"
                                            aria-hidden="true"></i>
                                        {{ __('Password must be at least 8 charecters') }}.
                                        <br>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Confirm password') }}*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="c_password" type="password"
                                        class="form-control @error('c_password') is-invalid @enderror" name="c_password"
                                        value="{{ old('c_password') }}" autocomplete="name" autofocus>
                                    @error('c_password')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
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