@extends('layouts.new_theme')

@section('content')

<div class="section-header">
  <h1>{{ __('Tickets') }}</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
    <div class="breadcrumb-item"><a href="{{ route('ticket.index') }}">{{ __('Tickets') }}</a>
    </div>
    <div class="breadcrumb-item">{{ __('Modify') }}</div>
  </div>
</div>

<div class="section-body">

  <div id="app1">
    <div class="row">
      <div class="col-12">
        @include('common.demo')
        @include('common.errors')

        <div class="card">
          <div class="card-header">
            <h4>{{ __('Modify Ticket') }}</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ticket.reply', [$ticket->uuid]) }}">{{ __('Reply') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{{ route('ticket.modify', [$ticket->uuid]) }}">{{ __('Modify') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ticket.note', [$ticket->uuid]) }}">{{ __('Private Notes') }}</a>
              </li>
              @if (Auth::check() && Auth::user()->role != 'user')
              <li class="nav-item">
                <a class="nav-link"
                  href="{{ route('ticket.internal_note', [$ticket->uuid]) }}">{{ __('Internal Notes') }}</a>
              </li>
              @endif
            </ul>
            <br>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <form action="{{ route('ticket.modify', [$ticket->uuid]) }}" method="post">
                  @csrf
                  <input type="hidden" name="action" value="modify_ticket" />

                  <div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="urgency">{{ __('Subject') }}</label>
                        <input type="text" class="form-control" id="ticket_title" value="{{__($ticket->title)}}"
                          name="title">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="urgency">{{ __('Priority') }}</label>
                        <select class="form-control selectric" id="urgency" name="ticket_urgency_id">
                          @foreach($ticket_urgency as $urgency)
                          @if ($urgency->id == $ticket->ticket_urgency_id)
                          <option selected value="{{$urgency->id}}">{{__($urgency->name)}}</option>
                          @else
                          <option value="{{$urgency->id}}">{{__($urgency->name)}}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>

                      @if (Auth::check() && Auth::user()->role != 'user')
                      <div class="form-group col-md-6">
                        <label for="ticket_status">{{ __('Status') }}</label>
                        <select class="form-control selectric" id="ticket_status" name="ticket_status_id">
                          @foreach($ticket_statuses as $ticket_status)
                          @if ($ticket_status->id == $ticket->ticket_status_id)
                          <option selected value="{{$ticket_status->id}}">{{__($ticket_status->title)}}</option>
                          @else
                          <option value="{{$ticket_status->id}}">{{__($ticket_status->title)}}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="assigned_to">{{ __('Assigned to') }}</label>
                        <select class="form-control selectric" id="assigned_to" name="assigned_to">
                          <option value="">{{ __('None') }}</option>
                          @foreach($staffs as $staff)
                          @if ($staff->id == $ticket->assigned_to)
                          <option selected value="{{$staff->id}}">{{__($staff->name)}}</option>
                          @else
                          <option value="{{$staff->id}}">{{__($staff->name)}}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>
                      @endif

                      <div class="form-group col-md-6">
                        <label for="department">{{ __('Department') }}</label>
                        <select class="form-control selectric" id="department" name="department_id">
                          @foreach($departments as $department)
                          @if ($department->id == $ticket->department_id)
                          <option selected value="{{$department->id}}">{{__($department->name)}}</option>
                          @else
                          <option value="{{$department->id}}">{{__($department->name)}}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-md-6" v-if="tags">
                        <label for="department">{{ __('Tags') }}</label>
                        <input type="hidden" ref="tag_ref" id="tag_ref_id" value="" name="tag_ids" />
                        <ticket-tags multiple :options="tags" taggable push-tags v-model="selected_tags"
                          :reduce="tags => tags.uuid" label="name" @input="chooseMe">
                        </ticket-tags>
                      </div>
                    </div>
                  </div>

                  @if (env('APP_ENV') != 'demo')
                  <div class="form-group m-2 row float-left">
                    <div>
                      <button type="submit" class="btn btn-custom">{{ __('Save changes') }}</button>
                    </div>
                  </div>
                  @endif
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var uuid = '<?php echo $ticket->uuid; ?>';
  var current_tags = '<?php echo json_encode($selected_tags); ?>';
</script>
<script src="{{ asset('js/ticket.js') }}"></script>
@endsection
