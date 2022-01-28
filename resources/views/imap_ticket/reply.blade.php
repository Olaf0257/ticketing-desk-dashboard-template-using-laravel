@extends('layouts.new_theme')

@section('content')

<div class="section-header">
    <h1>{{ __('Email Tickets') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('imap_ticket.index') }}">{{ __('Email Tickets') }}</a>
        </div>
        <div class="breadcrumb-item">{{ __('Reply') }}</div>
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
                        <h4>{{ __('Reply') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        href="{{ route('imap_ticket.reply', [$ticket->uuid]) }}">{{ __('Reply') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('imap_ticket.modify', [$ticket->uuid]) }}">{{ __('Modify') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('imap_ticket.note', [$ticket->uuid]) }}">{{ __('Private Notes') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('imap_ticket.internal_note', [$ticket->uuid]) }}">{{ __('Internal Notes') }}</a>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <h2 class="col-12">#{{$ticket->tid}} - {{ $ticket->subject }}</h2>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form action="/{{$ticket->uuid}}/imap_ticket_reply" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <editor id="editor1" v-model="reply_message" theme="snow" rows="100"
                                                placeholder="{{ __('Enter ticket reply here') }}"></editor>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="col-12">{{ __('Add Attachments') }}:</label>
                                            <div class="col-12">
                                                <input id="files" ref="files" multiple v-on:change="handleFileUploads()"
                                                    name="attachments[]" type="file" class="form-control file" multiple
                                                    data-show-upload="true" data-show-caption="true">
                                                @error('attachments.*')
                                                <div class="text-danger pt-1">{{ $message }}</div>
                                                @enderror
                                                <small class="text-success"><i class="fa fa-exclamation-circle"
                                                        aria-hidden="true"></i>
                                                    {{ __('The attachments must be a file of type: ') }}{{ $extension }}.
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6" v-if="canned_responses">
                                            <label class="col-12">{{ __('Canned responses') }}:</label>
                                            <div class="col-12">
                                                <v-select :options="canned_responses" v-model="selected_canned_response"
                                                    :reduce="country => country.body" @input="chooseMe" label="name">
                                                </v-select>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Display invalid file extension error -->
                                    <div class="form-group col-6" v-if="display_error">
                                        <div class="alert alert-danger alert-dismissible text-center" >
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>@{{ error_message }}</strong>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <button class="btn btn-custom" v-on:click="submitReply"
                                            :disabled='!reply_message || replying'>
                                                <b v-if="!replying">{{ __('Reply') }}</b>
                                                <b v-else>{{ __('Replying') }}<i class="fas fa-spinner fa-spin"></i></b>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @foreach($ticket_reply as $reply)
                        <br>
                        <div class="row col-12">
                            <div class="col-2 col-md-1">
                                <div class="row">
                                    <div class="ticket-sender-picture img-shadow">
                                        @if ($reply->replied_staff_id != null)
                                        @if ($reply->repliedUser->role == 'admin')
                                        <img src="/images/avatar-2.png" alt="image" height="55px"
                                            class="rounded-circle center">
                                        @else
                                        <img src="/images/avatar-3.png" alt="image" height="55px"
                                            class="rounded-circle center">
                                        @endif
                                        @else
                                        <img src="/images/avatar-1.png" alt="image" height="55px"
                                            class="rounded-circle center">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-10 col-md-11">
                                <div class="ticket-content">
                                    <div class="ticket-header">
                                        <div class="ticket-title">
                                            <h5>{{$reply->replied_user_name}}</h5>
                                        </div>
                                        <div class="ticket-info">
                                            <div class="font-weight-600 inline-block">
                                                @if ($reply->replied_staff_id != null)
                                                <span
                                                    class="text-capitalize">{{ $reply->repliedUser->display_role != null ? __($reply->repliedUser->display_role) : __($reply->repliedUser->role) }}</span>
                                                @else
                                                {{$ticket->from_email}}
                                                @endif
                                            </div>
                                            <div class="bullet inline-block"></div>
                                            <div class="text-primary font-weight-600 inline-block">
                                                {{$reply->created_at->diffForHumans()}}</div>

                                            @if (env('APP_ENV') != 'demo')
                                            <div class="float-right inline-block">
                                                <form action="{{ route('delete_imap_reply', [$reply->uuid]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn bg-transparent"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash text-danger" aria-hidden="true"
                                                            title="{{ __('Delete') }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ticket-divider"></div>
                                    <div class="ticket-description">
                                        <p>{!!$reply->message!!}.</p>

                                        @foreach($reply->attachments as $attachment)
                                        <div class="gallery inline-block">
                                            <a class="text-primary" href="{{route('imap_download', $attachment->name)}}"
                                                download>
                                                <div class="gallery-item" data-image="/images/img.jpg"
                                                    data-title="{{$attachment->name}}"></div>
                                            </a>
                                        </div>
                                        @endforeach

                                        <div class="ticket-divider"></div>
                                    </div>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <br>
                        <div class="row col-12">
                            <div class="col-2 col-md-1">
                                <div class="row">
                                    <div class="ticket-sender-picture img-shadow">
                                        <img src="/images/avatar-1.png" alt="image" height="55px"
                                            class="rounded-circle center">
                                    </div>
                                </div>
                            </div>
                            <div class="col-10 col-md-11">
                                <div class="ticket-content">
                                    <div class="ticket-header">
                                        <div class="ticket-title">
                                            <h5>{{$ticket->from_name}}</h5>
                                        </div>
                                        <div class="ticket-info">
                                            <div class="font-weight-600 inline-block">
                                                {{$ticket->from_email}}</div>
                                            <div class="bullet inline-block"></div>
                                            <div class="text-primary font-weight-600 inline-block">
                                                {{$ticket->created_at->diffForHumans()}}</div>
                                        </div>
                                    </div>
                                    <div class="ticket-divider"></div>
                                    <div class="ticket-description">
                                        <p>
                                            <h6>#{{$ticket->tid}} - {{ $ticket->subject }}</h6>
                                            {!!$ticket->message!!}.
                                        </p>

                                        @foreach($ticket->attachments as $attachment)
                                        <div class="gallery inline-block">
                                            <a class="text-primary" href="{{route('imap_download', $attachment->name)}}"
                                                download>
                                                <div class="gallery-item" data-image="/images/img.jpg"
                                                    data-title="{{$attachment->name}}"></div>
                                            </a>
                                        </div>
                                        @endforeach

                                        <div class="ticket-divider"></div>
                                    </div>
                                </div>
                                {{ $ticket_reply->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var api_url = '<?php echo url("/{$ticket->uuid}/imap_ticket_reply"); ?>';
    var canned_api_url = '<?php echo url("/get_canned_responses_api"); ?>';
</script>
<script src="{{ asset('js/ticket-reply.js') }}"></script>
@endsection
