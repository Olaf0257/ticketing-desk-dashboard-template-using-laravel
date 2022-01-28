@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('FAQs') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Add FAQ') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add FAQ') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('faq.store') }}" enctype="multipart/form-data">
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
                                    {{ __("Select any FAQ category") }}.
                                    <br>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="address"
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Question') }}*</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="question" type="text"
                                    class="form-control @error('question') is-invalid @enderror" name="question"
                                    value="{{ old('question') }}" autocomplete="question" autofocus>
                                @error('question')
                                <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Answer') }}:*</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea id="answer" class="summernote @error('answer') is-invalid @enderror"
                                    value="{{ old('answer') }}" name="answer">{{ old('answer') }}</textarea>
                                @error('answer')
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