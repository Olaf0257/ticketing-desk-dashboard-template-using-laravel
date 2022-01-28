@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Error Logs') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Error Logs') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('List of Error Logs') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($error_logs))
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
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Error message') }}</th>
                                    <th>{{ __('Last action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($error_logs as $error)
                                <tr>
                                    <td>{{ $error->section }}</td>
                                    <td><a href="{{ route('error_log.show', [$error->id]) }}">{{ Str::limit($error->title, 30) }}<a />
                                    </td>
                                    <td><a href="{{ route('error_log.show', [$error->id]) }}">{{ Str::limit($error->error_text, 30) }}<a />
                                    </td>
                                    <td>{{$error->created_at->diffForHumans()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $error_logs->appends($request->all())->links("pagination::bootstrap-4") }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection