@extends('layouts.landing')

@section('body-class')
    <body class="login-page">
@stop

@section('main-content')
    <div class="login-wrapper">
    
        <!-- 
        <div class="alert alert-info">
            <h2><strong>Have a Happy 4<sup>th</sup> of July!</strong></h2>
            <p>
            In honor of 4<sup>th</sup> of July, on Friday, July 4<sup>th</sup> 2014, the milling center will be closed.<br>
            Files that are sent after our cutoff times will be milled on Monday July 7<sup>th</sup>, 2014.<br>
            <span class="text-center">Have a Happy 4<sup>th</sup> of July!</span>
            </p>
        </div>
         -->
                    
        <!-- BEGIN Guest Upload Form --> 
        {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'id' => 'form-guest-upload')) }}
            <h3 class="text-center">Upload Files as Guest Lab</h3>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('guest_lab_name', Input::old('guest_lab_name'), array('class' => 'form-control', 'id' => 'guest_lab_name', 'placeholder' => 'lab name (required)')) }}
                    {{ $errors->first('guest_lab_name', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::email('guest_lab_email', Input::old('guest_lab_email'), array('class' => 'form-control', 'id' => 'guest_lab_email', 'placeholder' => 'lab email (required)')) }}
                    {{ $errors->first('guest_lab_email', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('guest_lab_phone', Input::old('guest_lab_phone'), array('class' => 'form-control', 'id' => 'guest_lab_phone', 'placeholder' => 'lab phone number (required)')) }}
                    {{ $errors->first('guest_lab_phone', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::textarea('guest_lab_message', Input::old('guest_lab_message'), array('class' => 'form-control', 'id' => 'guest_lab_message', 'placeholder' => 'message: shade, patient name, tooth #, etc.  if filenames include patient name, shade, and tooth #, this field is optional.')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls" id="dz-container">
                    <div id="dz-guest-upload" class="dropzone">
                        <div class="fallback">
                            {{ Form::file('file[]', array('multiple' => 'true', 'accept' => ".pts, .stl, .sla, .zip, .lab, application/octet-stream, application/zip, application/sla")) }}
                        </div>
                    </div>
                    {{ $errors->first('file.0', '<div class="alert alert-danger"> :message </div>') }}
                </div>
            </div>

            @if (isset($upload_cutoff))
                @if ($upload_cutoff === 1)
                    <div class="form-group">
                        <div class="controls">
                            <div class="alert alert-info">
                                <strong>Notice!</strong>  Files uploaded between {{ date("gA", mktime(Config::get('app.file_upload_soft_cutoff_hour'))) }} and {{ date("gA T", mktime(Config::get('app.file_upload_hard_cutoff_hour'))) }}  are subject to a $3.00 per tooth processing fee for same day processing.
                                <br />
                                <strong>Additional charges will not begin until February 1, 2014.</strong>
                                <br />
                                <p class="text-left">{{ Form::radio('accept_cutoff_fee', '0', true, array('required' => 'required')) }} <strong>No</strong>, please wait until the next business day to process files.</p>
                                <p class="text-left">{{ Form::radio('accept_cutoff_fee', '1', null, array('required' => 'required')) }} <strong>Yes</strong>, please process my files today and charge a ${{ Config::get('app.file_upload_rush_processing_fee') }} per tooth processing fee.</p>
                            </div>
                            {{ $errors->first('accept_cutoff_fee', '<div class="alert alert-danger"> :message </div>') }}
                        </div>
                    </div>
                @elseif ($upload_cutoff === 2)
                    <div class="form-group">
                        <div class="controls">
                            <div class="alert alert-info"><strong>Notice!</strong>  Files uploaded after {{ date("gA T", mktime(Config::get('app.file_upload_hard_cutoff_hour'))) }} will be processed next business day.
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if (Session::has('upload_limit_reached'))
                <div class="alert alert-danger text-center"> You have reached the maximum upload limit.<br /><br />Please try again in 60 minutes. </div>
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

        <span id="landing-separator">
            or
        </span>

        <!-- BEGIN Login Form -->
        {{ Form::open(array('route' => 'user_login', 'id' => 'form-login')) }}
            <h3 class="text-center">Login as Member Lab</h3>
            <hr />
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('user_username', Input::old('user_username'), array('class' => 'form-control', 'id' => 'user_username', 'placeholder' => 'email or username')) }}
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
                <div class="alert alert-danger">Invalid login credentials. </div>
            @endif

            <div class="form-group">
                <div class="controls">
                    {{ Form::button('Sign In', array('class' => 'btn btn-primary form-control', 'type' => 'submit')) }}
                </div>
            </div>
            <p class="clearfix">
                <label class="checkbox pull-left">
                    {{ Form::checkbox('remember', '1') }} Remember me
                </label>
                <a href="{{ route('user_reset_password') }}" class="goto-forgot pull-right">Forgot Password?</a>
            </p>
            <hr />
            <img src="{{ asset('img/ams_filemanager_logo.png') }}" alt="{{ Config::get('app.company_name') }} - {{ Config::get('app.site_title') }} Logo" id="logo" />
            <p class="lead text-center">
                <span class="text-info">Wondering what the benefits are?</span>
                <dl>
                    <dt><i class="icon-truck"></i> Real-Time File Updates</dt>
                        <dd>allows you to easily see which files we have processed</dd>
                    <dt><i class="icon-comment"></i> AMS Messaging Center</dt>
                        <dd>keeps you connected directly with our staff</dd>
                    <dt><i class="icon-file"></i> File History</dt>
                        <dd>keeps track of every file you've ever sent us</dd>
                </dl>
            </p>
        {{ Form::close() }}
        <!-- END Login Form -->

        <!-- BEGIN Forgot Password Form -->
        {{ Form::open(array('route' => 'user_reset_password', 'id' => 'form-forgot', 'style' => 'display: none;')) }}
            <h3>Password Recovery</h3>
            <hr/>
            <p>Enter the email address associated with your DentalLabProfile.com account to receive your password</p>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    <input type="text" name="lab_email" placeholder="email" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary form-control">Reset Password</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="#" class="goto-login pull-left"><i class="icon-circle-arrow-left"></i> Back to login form</a>
            </p>
        {{ Form::close() }}
        <!-- END Forgot Password Form -->
    <div class="clearfix"></div>
    </div>
@stop

@section('extra-styles')
    {{ Html::style('assets/dropzone/downloads/css/dropzone.css') }}
@stop

@section('extra-scripts')
    {{ Html::script('assets/jquery-validation/dist/jquery.validate.min.js') }}
    {{ Html::script('assets/jquery-validation/dist/additional-methods.min.js') }}
    {{ Html::script('assets/jquery-maskedinput/jquery.maskedinput.min.js') }}
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}

    <script type="text/javascript">
        function goToForm(form) {
            var normalWidth = $('.login-wrapper').css('width');
            if (form == "login") {
                $('.login-wrapper > form:visible').fadeOut(500, function(){
                    $('.login-wrapper').css('width', '1050px');
                    $('#form-login, #form-guest-upload, span#landing-separator').fadeIn(500);
                });
            } else {
                $('.login-wrapper > form:visible, span#landing-separator').fadeOut(500, function(){
                    $('.login-wrapper').css('width', '475px');
                    $('#form-forgot').fadeIn(500);
                });
            }
        }
        $(function() {
            $('.goto-login').click(function(e){
                e.preventDefault(); // prevent default action of click event
                e.stopPropagation(); // stop DOM propagation
                goToForm('login');
            });
            $('.goto-forgot').click(function(e){
                e.preventDefault(); // prevent default action of click event
                e.stopPropagation(); // stop DOM propagation
                goToForm('forgot');
            });
        });

        $(document).ready(function() {
            $("#guest_lab_phone").mask("(999) 999-9999");
            Dropzone.autoDiscover = false;

            $("#dz-guest-upload").dropzone({
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                addRemoveLinks: true,
                createImageThumbnails: false,
                maxFiles: 10,
                acceptedFiles: "application/x-rar-compressed,application/octet-stream,.zip,.ZIP,application/zip,.stl,.STL,application/sla,.sla,.SLA,application/lab,.lab,.LAB,application/pts,.pts,.PTS",
                url: "{{ route('file_upload_post') }}",

                dictRemoveFile: "Delete",

                init: function() {
                    var dz = this;
                    var guestUploadForm = $('#form-guest-upload');
                    var submitBtn = $("form#form-guest-upload button[type=submit]");
                    var acceptCutoffFee = $("input[type=radio][name=accept_cutoff_fee]");

                    // Set vaidation options for guest upload form
                    var validationOptions = {
                        errorElement: 'div', //default input error message container
                        errorClass: 'alert alert-danger', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input

                        rules: {
                            "file[]": {
                                required: true
                            },
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
                            "file[]": "Please select files to attach.",
                            guest_lab_name: "Please provide the name of your lab.",
                            guest_lab_email: {
                                required: "Please provide a valid email.",
                                email: "Please provide a correctly formatted email.<br /> Example: fake@example.com"
                            },
                            guest_lab_phone: {
                                required: "Please provide a valid phone number.",
                                phoneUS: "Please provide a correctly formatted U.S. phone number.<br /> Example: (800) 555-6789"
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

                    if (acceptCutoffFee.length != 0) {
                        validationOptions.rules.accept_cutoff_fee = {
                            required: true
                        }
                        validationOptions.messages.accept_cutoff_fee = {
                            required: "Please accept or reject the additional processing fee."
                        }
                    }

                    dz.on("addedfile", function() {
                        if (dz.files.length !== 0 && dz.files.length <= 10) {
                            $(".dropzone").css('overflow-y', 'scroll');
                        }
                    }).on("removedfile", function() {
                        if (dz.files.length === 0) {
                            $(".dropzone").css('overflow-y', '');
                        }
                        if (dz.getRejectedFiles().length === 0) {
                            $("#rejected-files").slideUp(500);
                        }
                    });

                    $("form#form-guest-upload button[type=submit]").click(
                        function(e) {
                            e.preventDefault(); // prevent default action of click event
                            e.stopPropagation(); // stop DOM propagation

                            guestUploadForm.validate(validationOptions);

                            if (guestUploadForm.valid()) {
                                // Process uploads if all validation has passed.
                                dz.processQueue();
                            }
                        }
                    );

                    dz.on("sendingmultiple", function(file, xhr, formData) {
                        formData.append('guest_lab_name', $("#guest_lab_name").val());
                        formData.append('guest_lab_email', $("#guest_lab_email").val());
                        formData.append('guest_lab_message', $("#guest_lab_message").val());
                        formData.append('guest_lab_phone', $("#guest_lab_phone").val());
                        formData.append('accept_cutoff_fee', $("#accept_cutoff_fee").val());
                        formData.append('_token', $("input[name=_token]").val());
                    });

                    dz.on("successmultiple", function(file, response) {
                        $("a.dz-remove").remove();
                    });

                    var count = 0;

                    dz.on("completemultiple", function(file) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getRejectedFiles().length === 0) {

                            if (count == 0) {
                                $('<div class="alert alert-success lead text-muted text-center">Your files have been uploaded successfully. <br /><br />Check your email for a confirmation.  <a href="#" id="upload-more">Upload more?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                                $(document).on('click', '#upload-more', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();

                                    dz.removeAllFiles();

                                    $(".alert-success").slideUp(500, function() {
                                        $(this).remove();
                                    });

                                    count = 0;
                                });
                            }
                            count++;
                        } else {
                            if (count == 0) {
                                $('<div class="alert alert-danger lead text-muted text-center" id="rejected-files">Please fix errors above and <a href="#" id="try-again">Try again?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                                $(document).on('click', '#try-again', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();

                                    dz.removeAllFiles();

                                    $(".alert-danger").slideUp(500, function() {
                                        $(this).remove();
                                    });

                                    count = 0;
                                });
                            }
                            count++;
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
        });
    </script>
@stop