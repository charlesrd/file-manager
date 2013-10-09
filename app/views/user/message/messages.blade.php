@extends('layouts.dashboard_sidebar')

@section('title', 'Message Inbox')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Message Inbox</h3>
                            </div>
                            <div class="panel-body">
                                <ul class="messages">
                                    @if ($messages->count())
                                        @foreach ($messages as $message)
                                            @if ($message->user_id == $user->id)
                                                <li>
                                                    <div class="message-to">
                                                        <div>
                                                            <h5>
                                                            @if ($user->lab_contact)
                                                                {{ $user->lab_contact }}
                                                            @else
                                                                {{ $user->username }}
                                                            @endif
                                                            </h5>
                                                            <span class="time"><i class="icon-time"></i> 26 minutes ago</span>
                                                        </div>
                                                        <p>
                                                            {{ $message->body }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @else
                                                <li>
                                                    <div class="message-from">
                                                        <div>
                                                            <h5>
                                                                UDRC
                                                            </h5>
                                                            <span class="time"><i class="icon-time"></i> 26 minutes ago</span>
                                                        </div>
                                                        <p>
                                                            {{ $message->body }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="alert alert-danger text-center">You have not sent or received any messages.</div>
                                    @endif
                                </ul>

                                <div class="messages-input-form">
                                    {{ Form::open(array('route' => 'message_post')) }}
                                        <div class="input">
                                            {{ Form::text('message', Input::old('message'), array('class' => 'form-control')) }}
                                        </div>
                                        <div class="buttons">
                                            <button type="submit" class="btn btn-primary"><i class="icon-share-alt"></i> Send</button>
                                        </div>
                                    {{ Form::close() }}
                                </div>

                                <div class="text-center">
                                    {{ $messages->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal-file_details" tabindex="-1" role="dialog" aria-hidden="true">
                </div><!-- /.modal -->
@stop

@section('extra-scripts')

@stop