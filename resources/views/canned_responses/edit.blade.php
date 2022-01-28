@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Canned Responses') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('canned_responses.index') }}">{{ __('Canned Responses') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Update Canned Response') }}</div>
    </div>
</div>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Update Canned Response') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('canned_responses.update',$uuid) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <div>

                            <div class="form-group row mb-4">
                                <label for="address"
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}*</label>
                                <div class="col-sm-12 col-md-7">

                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $name) }}" autocomplete="name" autofocus>
                                    @error('name')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Body') }}</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="summernote @error('body') is-invalid @enderror" id="ticket_reply"
                                        rows="3" name="body" autocomplete="body" autofocus>{{ old('body', $body) }}</textarea>
                                    @error('body')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if (env('APP_ENV') != 'demo')
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-custom">{{ __('Update') }}</button>
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