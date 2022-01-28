@extends('layouts.public')

@section('content')

<div class="section-header col-12 col-md-10 offset-md-1">
    <h1>{{ __('knowledge Base') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Articles') }}</h4>
                </div>

                <div class="card-body ">
                    @if (!count($articles))
                    <div class="empty-state pt-3" data-height="400">
                        <div class="empty-state-icon bg-custom">
                            <i class="fas fa-question"></i>
                        </div>
                        <h2>{{ __('No data found') }} !!</h2>
                        <p class="lead">
                            {{ __('Sorry we cant find any data') }}.
                        </p>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <ul class="nav nav-pills flex-column " id="myTab4" role="tablist">
                                @foreach($articles as $article)
                                <div class="border rounded-left">
                                    <li class="nav-item">
                                        <a class="nav-link kb-custom"
                                            href="{{ route('showArticle', [$article->slug]) }}">{{$article->title}}<br>
                                            <span class="kb-custom-desc">{!!
                                                Str::limit(strip_tags($article->description),
                                                60) !!}</span><span
                                                class="kb-custom-desc-date float-right">{{ __('Updated') }}
                                                {{\Carbon\Carbon::parse($article->created_at)->diffForHumans()}}</span>
                                        </a>
                                    </li>
                                </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection