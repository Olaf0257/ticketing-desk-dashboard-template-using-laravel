@extends('layouts.new_theme')
@section('content')
<div class="section-header">
    <h1>{{ __('KB Category') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('List of KB Categories') }}</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                 <div class="card-header">
                    <h4 class="inline-block">{{ __('List of KB Categories') }}</h4>
                    <small id='main'>
                        <a href="{{ route('kb_category.create') }}" class="btn btn-custom  float-right add_button">{{__('Add')}}</a>
                    </small>
                 </div>
                 <div class="card-body">
                    <div class="table-responsive">
                        @if (!count($kb_categories))
                        <div class="empty-state pt-3" data-height="400">
                            <div class="empty-state-icon bg-danger">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('No data found') }} !!</h2>
                            <p class="lead">
                                {{ __('Sorry we cant find any data, to get rid of this message, make at least 1 entry') }}.
                            </p>
                            <a href="{{ route('kb_category.create') }}"
                                class="btn btn-custom mt-4">{{ __('Create new One') }}</a>
                        </div>
                        @else
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center text-capitalize">
                                     <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($kb_categories as $kb_category)
                                <tr class=" ">
                                  <td>{{$kb_category->name}}</td>
                                  <td>{!! Str::limit(strip_tags($kb_category->description), 100 ) !!}</td>
                                  <td class="justify-content-center form-inline">
                                      <a href="{{ route('kb_category.edit', [$kb_category->uuid]) }}"
                                            class="btn btn-sm bg-transparent"><i class="far fa-edit text-primary"
                                                aria-hidden="true" title="{{ __('Edit') }}"></i></a>
                                                <form action="{{ route('kb_category.destroy', [$kb_category->uuid]) }}" method="POST">
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
                        {{ $kb_categories->appends($request->all())->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection