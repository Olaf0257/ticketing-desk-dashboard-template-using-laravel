@if (env('APP_ENV') == 'demo')
<div class="alert alert-warning text-center" role="alert">
<strong>{{ __('Note: ') }}</strong> {{ __('This is a demo version of Ticketing Expert. Some features will not work in this version') }}
</div>
@endif