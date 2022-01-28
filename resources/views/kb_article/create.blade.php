@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('KB Article') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Add KB Article') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add KB Article') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kb_article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row ">
                            <label for="message"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Category') }}:*</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" id="category_id" name="category_id">
                                    @foreach($categories as $category)
                                    @if (old('category_id') == $category->uuid)
                                    <option selected value="{{$category->uuid}}">
                                        {{__($category->name)}}</option>
                                    @else
                                    <option value="{{$category->uuid}}">{{__($category->name)}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <small class="form-text text-muted"><i class="fa fa-exclamation-circle"
                                        aria-hidden="true"></i>
                                    {{ __("Select any KB category from here") }}.
                                    <br>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="title"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}" autocomplete="title" autofocus>
                                @error('title')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fa fa-exclamation-circle"
                                        aria-hidden="true"></i>
                                    {{ __("The title should be a maximum of 100 characters") }}.
                                    <br>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }}:*</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea id="description" class="summernote @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}"
                                    name="description">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="address"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Page Title') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="page_title" type="text"
                                    class="form-control @error('page_title') is-invalid @enderror" name="page_title"
                                    value="{{ old('page_title') }}" autocomplete="page_title" autofocus>
                                @error('page_title')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="address"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Description') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="meta_description" type="text"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    name="meta_description" value="{{ old('meta_description') }}"
                                    autocomplete="meta_description" autofocus>
                                @error('meta_description')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="address"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Keywords') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="meta_keyword" type="text"
                                    class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword"
                                    value="{{ old('meta_keyword') }}" autocomplete="meta_keyword" autofocus>
                                @error('meta_keyword')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}:*</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-radio custom-control">
                                    <input class="custom-control-input" type="radio" name="status" id="planEnable"
                                        value="Active" checked>
                                    <label class="custom-control-label" for="planEnable">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input class="custom-control-input" type="radio" name="status" id="planDisable"
                                        value="Inactive">
                                    <label class="custom-control-label" for="planDisable">
                                        {{ __('Inactive') }}
                                    </label>
                                </div>
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