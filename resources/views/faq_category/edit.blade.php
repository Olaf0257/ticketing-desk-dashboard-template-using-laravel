@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('FAQ Categories') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Edit FAQ Category') }}</div>
    </div>
</div>

<div class="section-body">
        <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <!-- <div class="col-md-8"> -->
                <div class="card">
                    <div class="card-header"><h4 class="inline-block">{{ __('Edit FAQ Category') }}</h4></div>
                    <div class="card-body">
                      <form method="POST" action="{{ route('faq_category.update', $uuid) }}">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}*</label>
                                   <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $name)}}"   autocomplete="name" autofocus>
                                    @error('name')
                                            <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                              @if (env('APP_ENV') != 'demo')
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-custom">
                                        {{ __('Edit') }}
                                    </button>
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
