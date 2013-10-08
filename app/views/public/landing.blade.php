@extends('layouts.landing')

@section('main-content')
    <div class="login-wrapper">
        <!-- BEGIN Guest Upload Form -->
        {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'id' => 'form-guest-upload')) }}
            <h3>Upload Files as Guest Lab</h3>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('guest_lab_name', Input::old('guest_lab_name'), array('class' => 'form-control', 'id' => 'guest_lab_name', 'placeholder' => 'lab name (required)')) }}
                    {{ $errors->first('guest_lab_name', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::email('guest_lab_email', Input::old('guest_lab_email'), array('class' => 'form-control', 'id' => 'guest_lab_email', 'placeholder' => 'lab email (required)')) }}
                    {{ $errors->first('guest_lab_email', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('guest_lab_phone', Input::old('guest_lab_phone'), array('class' => 'form-control', 'id' => 'guest_lab_phone', 'placeholder' => 'lab phone number (required)')) }}
                    {{ $errors->first('guest_lab_phone', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::textarea('guest_lab_message', Input::old('guest_lab_message'), array('class' => 'form-control', 'id' => 'guest_lab_message', 'placeholder' => 'message to include with upload (optional)')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls" id="dz-container">
                    <div id="dz-guest-upload" class="dropzone">
                        <div class="fallback">
                            {{ Form::file('file[]', array('multiple' => 'true')) }}
                        </div>
                    </div>
                </div>
            </div>

            @if (Session::has('guest_upload_errors'))
                <div class="alert alert-danger"><strong>Error!</strong> There was an error with your upload.  Please try again. </div>
            @endif

            <div class="form-group">
                <div class="controls">
                    {{ Form::button('Upload Files', array('class' => 'btn btn-primary form-control', 'type' => 'submit')) }}
                </div>
            </div>

            <div class="clearfix">
            </div>
        {{ Form::close() }}
        <!-- END Guest Upload Form -->

        <span id="landing-separator" class="visible-md visible-lg">
            or
        </span>

        <!-- BEGIN Login Form -->
        {{ Form::open(array('route' => 'user_login', 'id' => 'form-login')) }}
            <h3>Login using DentalLabProfile</h3>
            <hr />
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('user_username', Input::old('user_username'), array('class' => 'form-control', 'id' => 'user_username', 'placeholder' => 'username')) }}
                    {{ $errors->first('user_username', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::password('user_password', array('class' => 'form-control', 'id' => 'user_password', 'placeholder' => 'password')) }}
                    {{ $errors->first('user_password', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>

            @if (Session::has('login_errors'))
                <div class="alert alert-danger"><strong>Error!</strong> Invalid login credentials. </div>
            @endif

            <div class="form-group">
                <div class="controls">
                    {{ Form::button('Sign In', array('class' => 'btn btn-primary form-control', 'type' => 'submit')) }}
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <label class="checkbox pull-left">
                    {{ Form::checkbox('remember', '1') }} Remember me
                </label>
                <a href="#" class="goto-forgot pull-right">Forgot Password?</a>
            </p>
            <hr />
            <p class="lead">
                <span class="text-info">Wondering what the benefits are?</span>
                <ul>
                    <li>File Tracking &amp; Updates</li>
                    <li>AMS Messaging Center</li>
                    <li>File History</li>
                    <li>&hellip;and much more!
                </ul>
            </p>
        {{ Form::close() }}
        <!-- END Login Form -->

        <!-- BEGIN Forgot Password Form -->
        {{ Form::open(array('route' => 'user_resetpassword', 'id' => 'form-forgot', 'style' => 'display: none;')) }}
            <h3>Password Recovery</h3>
            <hr/>
            <p>Enter the email address associated with your DentalLabProfile.com account to receive your password</p>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    <input type="text" placeholder="email" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary form-control">Reset Password</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="#" class="goto-login pull-left">&larr; Back to login form</a>
            </p>
        {{ Form::close() }}
        <!-- END Forgot Password Form -->

    </div>
@stop

@section('extra-styles')
    {{ Html::style('assets/dropzone/downloads/css/dropzone.css') }}
@stop

@section('extra-scripts')
    {{ Html::script('assets/jquery-validation/dist/jquery.validate.min.js') }}
    {{ Html::script('assets/jquery-validation/dist/additional-methods.min.js') }}
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            Dropzone.autoDiscover = false;

            $("#dz-guest-upload").dropzone({
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                addRemoveLinks: true,
                createImageThumbnails: false,
                url: "{{ route('file_upload_post') }}",

                dictRemoveFile: "Delete",

                init: function() {
                    var dz = this;
                    var guestUploadForm = $('#form-guest-upload');
                    var submitBtn = $("form#form-guest-upload button[type=submit]");

                    // Set vaidation options for guest upload form
                    var validationOptions = {
                        errorElement: 'div', //default input error message container
                        errorClass: 'alert alert-danger', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input

                        rules: {
                            guest_lab_name: {
                                required: true
                            },
                            guest_lab_email: {
                                required: true,
                                email: true
                            },
                            guest_lab_phone: {
                                required: true,
                                phoneUS: true
                            }
                        },

                        messages: {
                            guest_lab_name: "Please provide the name of your lab.",
                            guest_lab_email: {
                                required: "Please provide a valid email.",
                                email: "Please provide a correctly formatted email.<br /> Example: fake@example.com"
                            },
                            guest_lab_phone: {
                                required: "Please provide a valid phone number.",
                                phoneUS: "Please provide a correctly formatted U.S. phone number.<br /> Example: 8005556789 or 800-555-6789"
                            }
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
                    guestUploadForm.bind('keyup', function() {
                        if ($(this).validate(validationOptions).checkForm() && dz.files.length > 0) {
                            submitBtn.prop("disabled", false);
                        } else {
                            submitBtn.prop("disabled", true);
                        }
                    });

                    dz.on("addedfile", function() {
                        if (dz.files.length !== 0) {
                            $(".dropzone").css('overflow-y', 'scroll');
                            if (guestUploadForm.validate(validationOptions).checkForm()) {
                                submitBtn.prop("disabled", false);
                            }
                        }
                    }).on("removedfile", function() {
                        if (dz.files.length === 0) {
                            $(".dropzone").css('overflow-y', '');
                            if (!guestUploadForm.validate(validationOptions).checkForm()) {
                                submitBtn.prop("disabled", true);
                            }
                        }
                    });

                    $("form#form-guest-upload button[type=submit]").click(
                        function(e) {
                            e.preventDefault(); // prevent default action of click event
                            e.stopPropagation(); // stop DOM propagation

                            // Process uploads if all validation has passed.
                            dz.processQueue();

                            $(this).prop('disabled', true);
                        }
                    );

                    dz.on("sendingmultiple", function(file, xhr, formData) {
                        formData.append('guest_lab_name', $("#guest_lab_name").val());
                        formData.append('guest_lab_email', $("#guest_lab_email").val());
                        formData.append('guest_lab_message', $("#guest_lab_message").val());
                        formData.append('guest_lab_phone', $("#guest_lab_phone").val());
                        formData.append('_token', $("input[name=_token]").val());
                    });

                    dz.on("successmultiple", function(file, response) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('file_batch_create_post') }}',
                            data: {
                                _token: $("input[name=_token]").val(),
                                guest_lab_name: $("#guest_lab_name").val(),
                                guest_lab_email: $("#guest_lab_email").val(),
                                guest_lab_phone: $("#guest_lab_phone").val(),
                                message: $("#guest_lab_message").val()
                            }
                        })
                        .done(function(response) {
                            
                        })
                        .fail(function(xhr, status) {

                        });

                        $("a.dz-remove").remove();
                    });

                    dz.on("complete", function(file) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {



                            $('<div class="alert alert-success">Your files have been uploaded successfully. <br /><br />Check your email for a confirmation.  <a href="#" id="upload-more">Upload more?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                            $(document).on('click', '#upload-more', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                dz.removeAllFiles();

                                $(".alert-success").slideUp(500, function() {
                                    $(this).remove();
                                });

                                submitBtn.prop('disabled', false)
                            });
                        }
                    });

                }
            });

            var loginForm = $('#form-login');
            var submitBtn = $("form#form-login button[type=submit]");
            
            // Set vaidation options for guest upload form
            var validationOptions = {
                errorElement: 'div', //default input error message container
                errorClass: 'alert alert-danger', // default input error message class
                focusInvalid: false, // do not focus the last invalid input

                rules: {
                    user_username: {
                        required: true,
                    },
                    user_password: {
                        required: true
                    }
                },

                messages: {
                    user_username: "Please provide your DentalLabProfile login.",
                    user_password: "Please provide your password."
                },

                highlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass);
                },

                // Callback for handling actual submit when form is valid
                submitHandler: function(form) {
                    form.submit();
                }
            }

            submitBtn.prop("disabled", 'true');

            loginForm.bind('keyup', function() {
                if ($(this).validate(validationOptions).checkForm()) {
                    submitBtn.prop("disabled", false);
                } else {
                    submitBtn.prop("disabled", true);
                }
            });
        });

        function goToForm(form) {
            if (form == "login") {
                $('.login-wrapper > form:visible').fadeOut(500, function(){
                    $('#form-login, #form-guest-upload, span#landing-separator').fadeIn(500);
                });
            } else {
                $('.login-wrapper > form:visible, .login-wrapper span#landing-separator').fadeOut(500, function(){
                    $('#form-' + form).fadeIn(500);
                });
            }
        }
        $(function() {
            $('.goto-login').click(function(){
                goToForm('login');
            });
            $('.goto-forgot').click(function(){
                goToForm('forgot');
            });
        });
    </script>
@stop