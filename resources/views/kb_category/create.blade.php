@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('KB Category') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Add KB Category') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add KB Category') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kb_category.store') }}">
                        @csrf
                        <div class="form-group row mb-4">
                            <label for="address"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                @error('name')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="icon"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Icon') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="icon" type="text" class="form-control @error('icon') is-invalid @enderror"
                                    name="icon" value="{{ old('icon') }}" autocomplete="icon" autofocus
                                    placeholder="Eg: <i class=&ldquo;fas fa-tasks&rdquo;></i>">
                                @error('icon')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror

                                <small class="text-secondary"><i class="fa fa-exclamation-circle"
                                        aria-hidden="true"></i>
                                    {{ __('You have to add HTML code of fontawesome icons here') }}.<br>
                                    {{ __('Reference: ') }} <a href="https://fontawesome.com/"
                                        target="_blank" rel="noopener noreferrer">
                                        {{ __('fontawesome.com') }} </a>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote @error('description') is-invalid @enderror"
                                    id="description" value="{{ old('description') }}" rows="3" name="description"
                                    autocomplete="description" autofocus>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-custom">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection