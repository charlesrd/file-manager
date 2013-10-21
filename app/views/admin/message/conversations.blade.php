@extends('layouts.dashboard_sidebar')

@section('title', 'Message Inbox')

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Messaging Center</h3>
                </div>
                <div class="panel-body">
                    <ul class="conversations">
                        @if (isset($conversations) && $conversations->count())
                        	<div class="table-responsive">
                                <table class="table table-advance">
                                    <thead>
                                        <tr>
                                            <th width="200">Date</th>
                                            <th>Lab</th>
                                            <th>Email</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                	@foreach ($conversations as $conversation)
                                        @if ($conversation->users()->first())
                                            @if ($conversation->users()->first()->pivot->read == 0)
                                            <tr class="table-flag-red">
											@else
                                            <tr class="table-flag-green">
                                            @endif
                                                <td>
                                                    {{ $conversation->formattedCreatedAt() }}
                                                </td>
                                                <td>
                                                    {{ $conversation->users()->first()->dlp_user()->labName }}
                                                </td>
                                                <td>
                                                    {{ $conversation->users()->first()->email }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($conversation->users()->first()->pivot->read == 0)
                                                        <a href="{{ route('message_conversation', $conversation->id) }}" class="btn btn-danger show-tooltip" title="This conversation has unread messages.  Click to read."><i class="icon-comment"></i> Unread</a>
                                                    @else
                                                        <a href="{{ route('message_conversation', $conversation->id) }}" class="btn btn-success show-tooltip" title="This conversation has been read.  Click to read."><i class="icon-comment"></i> Read</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <div class="alert alert-danger lead text-muted text-center">Error:  Missing Conversation ID # {{ $conversation->id }}</div>
                                                </td>
                                            </tr>
                                        @endif
                                	@endforeach
                                	</tbody>
                                </table>
                        	</div>
                        @else
                            <div class="alert alert-danger lead text-muted text-center">You do not have any active conversations.</div>
                        @endif
                    </ul>

                    <div class="text-center">
                        @if (isset($conversations))
                            {{ $conversations->links() }}
                        @endif
                    </div>
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