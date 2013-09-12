@extends('layouts.landing')

@section('main-content')
    <div class="login-wrapper">
        <!-- BEGIN Guest Upload Form -->
        {{ Form::open(array('route' => 'file_upload_post', 'id' => 'form-guest-upload', 'files' => true)) }}
            <h3>Upload Files as Guest</h3>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    {{ Form::text('guest_lab_name', Input::old('guest_lab_name'), array('class' => 'form-control', 'id' => 'guest_lab_name', 'placeholder' => 'lab name')) }}
                    {{ $errors->first('guest_lab_name', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::email('guest_lab_email', Input::old('guest_lab_email'), array('class' => 'form-control', 'id' => 'guest_lab_email', 'placeholder' => 'lab email')) }}
                    {{ $errors->first('guest_lab_email', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::textarea('guest_lab_message', Input::old('guest_lab_message'), array('class' => 'form-control', 'id' => 'guest_lab_message', 'placeholder' => 'message to include with upload')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <div id="dz-guest-upload" class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <div class="dropzone-previews"></div>
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

        <span id="landing-separator">
            OR
        </span>

        <!-- BEGIN Login Form -->
        {{ Form::open(array('route' => 'user_login', 'id' => 'form-login')) }}
            <h3>Login using DentalLabProfile account</h3>
            <hr />
            <div class="form-group">
                <div class="controls">
                    {{ Form::email('user_email', Input::old('user_email'), array('class' => 'form-control', 'id' => 'user_email', 'placeholder' => 'username')) }}
                    {{ $errors->first('user_email', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    {{ Form::password('user_password', array('class' => 'form-control', 'id' => 'user_password', 'placeholder' => 'password')) }}
                    {{ $errors->first('user_password', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
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
        {{ Form::open(array('route' => 'user_resetpassword', 'id' => 'form-forgot', 'style' => 'display:none')) }}
            <h3>Reset your password</h3>
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

        <div class="clearfix">
        </div>
    </div>
@stop

@section('extra-styles')
    {{ Html::style('assets/dropzone/downloads/css/dropzone.css') }}
@stop

@section('extra-scripts')
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}

    <script type="text/javascript">
        $(function() {

            Dropzone.options.dzGuestUpload = {
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                url: "/file/upload",

                init: function() {
                    var dz = this;

                    $("form#form-guest-upload button[type=submit]").click(
                        function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            dz.processQueue();
                        }
                    );
                },

                sending: function(file, xhr, formData) {
                    formData.append('guest_lab_name', $("#guest_lab_name").val());
                    formData.append('guest_lab_email', $("#guest_lab_email").val());
                    formData.append('guest_lab_message', $("#guest_lab_message").val());
                    formData.append('_token', $("input[name=_token]").val());
                }
            }

        });

        function goToForm(form)
        {
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