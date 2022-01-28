@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Departments') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('department.index') }}">{{ __('Departments') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Add Department') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add Department') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('department.store') }}">
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
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control" id="description" name="description"
                                        autocomplete="name" autofocus>{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="name" autofocus>
                                    @error('email')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            @if (($imap_enables->value) == '1')
                            <label class=" text-danger col-md-4-offset col-md-8 col-form-label text-md-right">
                                {{ __('IMAP Server Details') }}
                            </label>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('IMAP Host') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="host" type="text"
                                        class="form-control @error('host') is-invalid @enderror" name="host"
                                        value="{{ old('host') }}" autocomplete="host" autofocus>
                                    @error('host')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">eg: imap.gmail.com</small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('IMAP Port') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="port" type="text"
                                        class="form-control @error('port') is-invalid @enderror" name="port"
                                        value="{{ old('port') }}" autocomplete="port" autofocus>
                                    @error('port')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">eg: 993</small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('IMAP Password') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        value="{{ old('password') }}" autocomplete="password" autofocus>
                                    @error('password')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mailbox') }}:</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="mail_box" type="text"
                                        class="form-control @error('mail_box') is-invalid @enderror" name="mail_box"
                                        value="{{ old('mail_box') }}" autocomplete="mail_box" autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Flags') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="flags" type="text"
                                        class="form-control @error('flags') is-invalid @enderror" name="flags"
                                        value="{{ old('flags') }}" autocomplete="flags" autofocus>
                                    <small class="form-text text-muted">eg: /imap/ssl/novalidate-cert</small>
                                </div>
                            </div>

                            <label class=" text-danger col-md-4-offset col-md-8 col-form-label text-md-right">
                                {{ __('SMTP Details') }}
                            </label>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('SMTP Host') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="smtp_host" type="text"
                                        class="form-control @error('smtp_host') is-invalid @enderror" name="smtp_host"
                                        value="{{ old('smtp_host') }}" autocomplete="smtp_host" autofocus>
                                    @error('smtp_host')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">eg: smtp.gmail.com</small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('SMTP Port') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="smtp_port" type="text"
                                        class="form-control @error('smtp_port') is-invalid @enderror" name="smtp_port"
                                        value="{{ old('smtp_port') }}" autocomplete="smtp_port" autofocus>
                                    @error('smtp_port')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">eg: 465</small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('SMTP Password') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <input id="smtp_password" type="password"
                                        class="form-control @error('smtp_password') is-invalid @enderror"
                                        name="smtp_password" value="{{ old('smtp_password') }}"
                                        autocomplete="smtp_password" autofocus>
                                    @error('smtp_password')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="smtp_encryption"
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('SMTP Encryption') }}:*</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control form-control selectric" id="smtp_encryption"
                                        name="smtp_encryption">
                                        <option value="">{{ __('None') }}</option>
                                        <option value="SSL">{{__('SSL')}}</option>
                                        <option value="TLS">{{__('TLS')}}</option>
                                    </select>
                                </div>
                            </div>
                            @endif

                            @if (env('APP_ENV') != 'demo')
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-custom"> {{ __('Add') }}</button>
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