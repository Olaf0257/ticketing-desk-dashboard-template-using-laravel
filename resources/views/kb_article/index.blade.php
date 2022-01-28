@extends('layouts.new_theme')
@section('content')
<div class="section-header">
    <h1>{{ __('KB Article') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('List of KB Articles') }}</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                 <div class="card-header">
                    <h4 class="inline-block">{{ __('List of KB Articles') }}</h4>
                    <small id='main'>
                        <a href="{{ route('kb_article.create') }}" class="btn btn-custom  float-right add_button">{{__('Add')}}</a>
                    </small>
                 </div>
                 <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($kb_articles))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No data found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                            <a href="{{ route('kb_article.create') }}"
                                class="btn btn-custom mt-4">{{ __('Create new One') }}</a>
                        </div>
                        @else
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Content') }}</th>
                                    <th></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($kb_articles as $kb_article)
                                <tr class=" ">
                                    <td>{{$kb_article->categories->name}}</td>
                                  <td>{{$kb_article->title}}</td>
                                  <td>{!! Str::limit(strip_tags($kb_article->description), 100) !!}</td>
                                  <td class="justify-content-center form-inline width-100">
                                      <a href="{{ route('kb_article.edit', [$kb_article->uuid]) }}"
                                            class="btn btn-sm bg-transparent"><i class="far fa-edit text-primary"
                                                aria-hidden="true" title="{{ __('Edit') }}"></i></a>
                                                <form action="{{ route('kb_article.destroy', [$kb_article->uuid]) }}" method="POST">
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
                        {{ $kb_articles->appends($request->all())->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection