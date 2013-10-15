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
                                                            <span class="time"><i class="icon-time"></i> {{ $message->formattedCreatedAt() }}</span>
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
                                                            <span class="time"><i class="icon-time"></i> {{ $message->formattedCreatedAt() }}</span>
                                                        </div>
                                                        <p>
                                                            {{ $message->body }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="alert alert-danger lead text-muted text-center">You have not sent or received any messages.</div>
                                    @endif
                                </ul>

                                <div class="text-center">
                                    {{ $messages->links() }}
                                </div>

                                {{ Form::open(array('route' => 'message_post', 'id' => 'form-message')) }}
                                    <div class="form-group" id="form-message-message">
                                        {{ Form::text('message', Input::old('message'), array('class' => 'form-control', 'placeholder' => 'Type your message here...')) }}
                                        {{ $errors->first('message', '<div class="alert alert-danger text-center"><strong>Error!</strong> :message </div>') }}
                                    </div>
                                    @if (Session::has('message-send-error'))
                                        <div class="alert alert-danger"><strong>Error!</strong> There was an error sending your message.  Please try again. </div>
                                    @endif

                                    <div class="form-group" id="form-message-submit">
                                        <button type="submit" class="btn btn-primary form-control"><i class="icon-share-alt"></i> Send</button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
@stop

@section('extra-scripts')
    {{ Html::script('assets/jquery-validation/dist/jquery.validate.min.js') }}
    {{ Html::script('assets/jquery-validation/dist/additional-methods.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        var messageForm = $('#form-message');
        var submitBtn = $("form#form-message button[type=submit]");

        // Set vaidation options for guest upload form
        var validationOptions = {
            errorElement: 'div', //default input error message container
            errorClass: 'alert alert-danger', // default input error message class
            focusInvalid: false, // do not focus the last invalid input

            rules: {
                message: {
                    required: true
                }
            },

            messages: {
                message: "Please provide a message.",
            },

            highlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass);
            },

            // Callback for handling actual submit when form is valid
            submitHandler: function(form) {
                form.submit();
            }
        }

        // disable submit button by default
        submitBtn.prop("disabled", true);

        // Enable or disable submit button based on form validation and dropzone queue length
        messageForm.bind('keyup', function() {
            if ($(this).validate(validationOptions).checkForm()) {
                submitBtn.prop("disabled", false);
            } else {
                submitBtn.prop("disabled", true);
            }
        });
    });
    </script>
@stop