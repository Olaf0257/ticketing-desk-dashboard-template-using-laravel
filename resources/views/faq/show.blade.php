@extends('layouts.public')
@section('content')

<div class="section-header col-10 offset-1">
    <h1>{{ __('FAQs') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-10 offset-1">
            @include('common.demo')
            @include('common.errors')
            <div class="card">
                <div class="card-body">
                    @if (!count($faq_categories))
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
                    @foreach($faq_categories as $faq_category)
                    @if (count($faqs[$faq_category->uuid]))
                    <div class="card card-custom-shadow">
                        <div class="card-header">
                            <h3 class="inline-block custom-title">{{ $faq_category->name }}</h3>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12">
                                    <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
                                        @foreach($faqs[$faq_category->uuid] as $faq)
                                        <div class="card faq-card">
                                            <div class="card-header custom-faq-card" id="{{ $faq->question }}">
                                                <h2>
                                                    <button href="#target{{ $faq->uuid }}"
                                                        class="d-flex align-items-center justify-content-between btn bg-custom-shade faq-btn"
                                                        data-parent="#accordion" data-toggle="collapse"
                                                        aria-expanded="false" aria-controls="{{ $faq->uuid }}">
                                                        <p class="mb-00 custom-p">{!! strip_tags($faq->question) !!}</p>
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                </h2>
                                            </div>
                                            <div class="collapse" id="target{{ $faq->uuid }}" role="tabpanel"
                                                aria-labelledby="{{ $faq->question }}">
                                                <div class="card-body custom-collapse">
                                                    {!! $faq->answer !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection