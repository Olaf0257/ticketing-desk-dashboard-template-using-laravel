@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('KB Article') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Edit KB Article') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <!-- <div class="col-md-8"> -->
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('Edit KB Article') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('kb_article.update', $kb_article->uuid) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <div class="form-group row mb-4">
                            <label for="smtp_encryption"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Category') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" id="category_id" name="category_id">
                                    @foreach($categories as $category)
                                    @if ($category->uuid == old('category_id', $kb_article->category_id))
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
                                    name="title" value="{{ old('title', $kb_article->title) }}" autocomplete="title"
                                    autofocus>

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
                                <textarea class="summernote @error('description') is-invalid @enderror"
                                    id="description" rows="3" name="description"
                                    value="{{ old('description', $kb_article->description) }}"
                                    autocomplete="description" autofocus>{{ old('description', $kb_article->description) }}</textarea>
                                @error('description')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="page_title"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Page Title') }}</label>

                            <div class="col-sm-12 col-md-7">
                                <input id="page_title" type="text"
                                    class="form-control @error('page_title') is-invalid @enderror" name="page_title"
                                    value="{{ old('page_title', $kb_article->page_title) }}" autocomplete="page_title"
                                    autofocus>
                                @error('page_title')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="meta_description"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Description') }}</label>

                            <div class="col-sm-12 col-md-7">
                                <input id="meta_description" type="text"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    name="meta_description"
                                    value="{{ old('meta_description', $kb_article->meta_description) }}"
                                    autocomplete="meta_description" autofocus>
                                @error('meta_description')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="meta_keyword"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Keyword') }}</label>

                            <div class="col-sm-12 col-md-7">
                                <input id="meta_keyword" type="text"
                                    class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword"
                                    value="{{ old('meta_keyword', $kb_article->meta_keyword) }}"
                                    autocomplete="meta_keyword" autofocus>
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
                                        value="Active"
                                        {{old('status', $kb_article->status) == "Active" ? "checked" : "" }}>
                                    <label class="custom-control-label" for="planEnable">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input class="custom-control-input" type="radio" name="status" id="planDisable"
                                        value="Inactive"
                                        {{ old('status', $kb_article->status) == "Inactive" ? "checked" : "" }}>
                                    <label class="custom-control-label" for="planDisable">
                                        {{ __('Inactive') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if (env('APP_ENV') != 'demo')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-custom">{{ __('Edit') }}</button>
                            </div>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- </main> -->
</div>
</div>
</div>
@endsection