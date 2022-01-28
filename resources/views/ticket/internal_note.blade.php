@extends('layouts.new_theme')

@section('content')

<div class="section-header">
  <h1>{{ __('Tickets') }}</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
    <div class="breadcrumb-item"><a href="{{ route('ticket.index') }}">{{ __('Tickets') }}</a>
    </div>
    <div class="breadcrumb-item">{{ __('Internal Notes') }}</div>
  </div>
</div>

<div class="section-body">

  <div>
    <div class="row">
      <div class="col-12">
        @include('common.demo')
        @include('common.errors')

        <div class="card">
          <div class="card-header">
            <h4>{{ __('Internal Notes') }}</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ticket.reply', [$ticket->uuid]) }}">{{ __('Reply') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ticket.modify', [$ticket->uuid]) }}">{{ __('Modify') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"
                  href="{{ route('ticket.note', [$ticket->uuid]) }}">{{ __('Private Notes') }}</a>
              </li>
              @if (Auth::check() && Auth::user()->role != 'user')
              <li class="nav-item">
                <a class="nav-link active"
                  href="{{ route('ticket.internal_note', [$ticket->uuid]) }}">{{ __('Internal Notes') }}</a>
              </li>
              @endif
            </ul>
            <br>
            <h2>#{{$ticket->tid}} - {{ $ticket->title }}</h2>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <form action="/{{$ticket->uuid}}/internal_ticket_note" method="post">
                  @csrf

                  <div class="form-group row">
                    <div class="col-sm-12">
                      <textarea placeholder="{{ __('Enter your note here') }}" id="internal_note"
                        class="summernote" name="internal_note"></textarea>
                      @error('internal_note')
                      <div class="text-danger pt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-custom">{{ __('Add note') }}</button>
                  </div>
                </form>

              </div>
            </div>
            @foreach($ticket_notes as $note)
            <br>
            <div class="row col-12">
              <div class="col-2 col-md-1">
                <div class="row">
                  <div class="ticket-sender-picture img-shadow">
                    <img src="/images/avatar-1.png" alt="image" height="55px" class="rounded-circle center">
                  </div>
                </div>
              </div>
              <div class="col-10 col-md-11">
                <div class="ticket-content">
                  <div class="ticket-header">
                    <div class="ticket-title">
                      <h5>{{$note->noteUser->name}}</h5>
                    </div>
                    <div class="ticket-info">
                      <div class="font-weight-600 inline-block text-capitalize">
                        {{$note->noteUser->role}}</div>
                      <div class="bullet inline-block"></div>
                      <div class="text-primary font-weight-600 inline-block">
                        {{$note->created_at->diffForHumans()}}</div>

                      <div class="float-right inline-block">
                        <form action="{{ route('delete_note', [$note->uuid]) }}" method="POST">

                          @csrf
                          @method('DELETE')
                          <button class="btn bg-transparent" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash text-danger" aria-hidden="true" title="{{ __('Delete') }}"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="ticket-divider"></div>
                  <div class="ticket-description">
                    <p>{!!$note->message!!}.</p>

                    <div class="ticket-divider"></div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            {{ $ticket_notes->links("pagination::bootstrap-4") }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection