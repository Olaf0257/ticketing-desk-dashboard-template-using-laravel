@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Languages') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Add a Language') }}</div>
    </div>
</div>

<div class="section-body">

    @include('common.demo')
    @include('common.errors')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add a Language') }}</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('language.store') }}">
                        @method('POST')
                        @csrf
                        <div>
                            <div class="form-group row mb-4">
                                <label for="address"
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Language') }}*</label>
                                <div class="col-sm-12 col-md-8">

                                    <input id="language" type="text"
                                        class="form-control @error('language') is-invalid @enderror" name="language"
                                        value="{{ old('language') }}" autocomplete="language" autofocus>
                                    @error('language')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Code') }}</label>
                                <div class="col-sm-12 col-md-8">

                                    <input id="code" type="text"
                                        class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code') }}" autocomplete="code" autofocus>
                                    @error('code')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-secondary"><i class="fa fa-exclamation-circle"
                                            aria-hidden="true"></i>
                                        {{ __('The language code must be a two letter keyword based on ISO 2 letter (Alpha-2 code, ISO 639-1) standerd. Eg: en for English') }}.<br>
                                        {{ __('Reference: ') }} <a href="https://www.science.co.il/language/Codes.php"
                                            target="_blank" rel="noopener noreferrer">
                                            {{ __('Language codes') }} </a>
                                    </small>
                                </div>
                            </div>

                            @if (env('APP_ENV') != 'demo')

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-8">
                                    <button type="submit" class="btn btn-custom">{{ __('Add') }}</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('List of Languages') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($languages))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No data found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                        </div>
                        @else
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Language') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    @if (env('APP_ENV') != 'demo')
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $language)
                                <tr>
                                    <td>{{ __($language->language) }}</td>
                                    <td>{{ __($language->code) }}</td>
                                    <td class="form-inline">
                                        <form action="{{ route('language.destroy', [$language->id]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm bg-transparent"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash text-danger" aria-hidden="true"
                                                    title="{{ __('Delete') }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection