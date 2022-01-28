@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Ticket Statuses') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('List of Ticket Statuses') }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">{{ __('List of Ticket Statuses') }}</h4>
                    <small id='main'>
                        <a href="{{ route('ticket_status.create') }}"
                            class="btn btn-custom float-right  add_button">{{__('Add')}}</a>
                    </small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($statuses))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No data found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                            <a href="{{ route('ticket_status.create') }}"
                                class="btn btn-custom mt-4">{{ __('Create new One') }}</a>
                        </div>
                        @else
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Status title') }}</th>
                                    <th>{{ __('Status color') }}</th>
                                    <th>{{ __('Text color') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statuses as $status)
                                <tr>
                                    <td>{{ __($status->title) }}</td>
                                    <td><span class="badge text-white custom-shadow"
                                            style="background-color: {{$status->color}} !important;"> </span>
                                        {{ Str::upper($status->color) }}</td>

                                    <td><span class="badge text-white custom-shadow"
                                            style="background-color: {{$status->text_color}} !important;"> </span>
                                        {{ Str::upper($status->text_color) }}</td>

                                    <td class="justify-content-center form-inline">
                                        <a href="{{ route('ticket_status.edit', [$status->id]) }}"
                                            class="btn btn-sm bg-transparent"><i class="far fa-edit text-primary"
                                                aria-hidden="true" title="{{ __('Edit') }}"></i></a>
                                        @if ($status->id > 6)
                                        <form action="{{ route('ticket_status.destroy', [$status->id]) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm bg-transparent"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash text-danger" aria-hidden="true"
                                                    title="{{ __('Delete') }}"></i>
                                            </button>
                                        </form>
                                        @endif
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