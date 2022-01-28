@extends('layouts.public')

@section('content')

<div class="section-header">
    <h1>{{ __('knowledge Base') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card  cardcolor">
                                    <div class="card-header ">
                                        <h4 class="">{{__($articles->title) }}</h4>
                                        <small class="float-left mr-1">{{ __('Posted') }}
                                            {{\Carbon\Carbon::parse($articles->created_at)->diffForHumans()}}</small>|
                                        <small>{{ __('Updated') }}
                                            {{\Carbon\Carbon::parse($articles->updated_at)->diffForHumans()}}</small>
                                        <div class="card-body no-padding">
                                            {!! __($articles->description) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card ">
                <div class="card-header">
                    <h4>{{ __('Related Articles') }}</h4>
                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills flex-column " id="myTab4" role="tablist">
                                @foreach($article_titles as $title)
                                @if ($title->uuid != $articles->uuid)
                                <div class="border rounded-left">
                                    <li class="nav-item">
                                        <a class="nav-link kb-custom-related"
                                            href="{{ route('showArticle', [$title->slug]) }}">{{$title->title}}<br>
                                            <span class="kb-custom-desc">{!!
                                                Str::limit(strip_tags($title->description),
                                                60) !!}</span><span
                                                class="kb-custom-desc-date float-right">{{ __('Updated') }}
                                                {{\Carbon\Carbon::parse($title->created_at)->diffForHumans()}}</span>
                                        </a>
                                    </li>
                                </div>
                                @endif

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection