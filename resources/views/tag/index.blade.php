@extends('layouts.new_theme')

@section('content')

<div class="section-header text-capitalize">
    <h1>{{ __('Tags') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('Tags') }}</div>
    </div>
</div>

<div class="section-body  text-capitalize">

    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Tags') }}
                        <small>
                            <a href="{{ route('tags.create') }}"
                                class="btn btn-custom  float-right add_button">{{__('Add')}}</a>
                        </small></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($tags))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No data found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                            <a href="{{ route('tags.create') }}"
                                class="btn btn-custom mt-4">{{ __('Create new One') }}</a>
                        </div>
                        @else
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Tag Colour') }}</th>
                                    <th>{{ __('Text Colour') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                <tr class="text-capitalize">
                                    <td>{{ $tag->name }}</td>
                                    <td><span class="badge text-white custom-shadow"
                                            style="background-color: {{ $tag->tag_color }} !important;"> </span>
                                        {{ Str::upper($tag->tag_color) }}</td>

                                    <td><span class="badge text-white custom-shadow"
                                            style="background-color: {{ $tag->text_color }} !important;"> </span>
                                        {{ Str::upper($tag->text_color) }}</td>

                                    <td class="justify-content-center form-inline">
                                        <a href="{{ route('tags.edit', [$tag->uuid]) }}"
                                            class="btn btn-sm bg-transparent"><i class="far fa-edit text-primary"
                                                aria-hidden="true" title="{{ __('Edit') }}"></i></a>
                                        <form action="{{ route('tags.destroy', [$tag->uuid]) }}" method="POST">
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