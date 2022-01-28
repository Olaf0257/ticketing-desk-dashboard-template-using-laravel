@extends('layouts.public')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-3">
            {{-- <div class="login-brand">
      <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
    </div> --}}

            @include('common.errors')
            <div class="card card-custom">
                <div class="card-header">
                    <h4>{{ __('Confirm Password') }}</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted">{{ __('Please confirm your password before continuing.') }}</p>
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}*</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-custom btn-lg btn-block" tabindex="4">
                                {{ __('Confirm Password') }}
                            </button>
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection