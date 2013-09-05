@extends('layouts.login')

@section('main-content')
    <div class="login-wrapper">
        <!-- BEGIN Login Form -->
        {{ Form::open(array('route' => 'login', 'id' => 'form-login')) }}
            <h3>Login Using DentalLabProfile Account</h3>
            <hr/>
            <div class="control-group">
                <div class="controls">
                    {{ Form::text('user_email', Input::old('user_email'), array('class' => 'input-block-level', 'id' => 'user_email', 'placeholder' => 'username')) }}
                    {{ $errors->first('user_email', '<div class="alert alert-error"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    {{ Form::password('user_password', array('class' => 'input-block-level', 'id' => 'user_password', 'placeholder' => 'password')) }}
                    {{ $errors->first('user_password', '<div class="alert alert-error"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>

            {{-- Cross-Site Request Forgery Token (hidden) --}}
            {{ Form::token() }}

            @if (Session::has('login_errors'))
                <div class="alert alert-error"><strong>Error!</strong> Invalid login credentials. </div>
            @endif
            <div class="control-group">
                <div class="controls">
                    {{ Form::button('Sign In', array('class' => 'btn btn-primary input-block-level', 'type' => 'submit')) }}
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember" /> Remember me
                </label>
                <a href="#" class="goto-forgot pull-right">Forgot Password?</a>
            </p>
        {{ Form::close() }}
        <!-- END Login Form -->

        <!-- BEGIN Forgot Password Form -->
        <form id="form-forgot" action="index.html" method="get" class="hide">
            <h3>Get back your password</h3>
            <hr/>
            <div class="control-group">
                <div class="controls">
                    <input type="text" placeholder="Email" class="input-block-level" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary input-block-level">Recover</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="#" class="goto-login pull-left">← Back to login form</a>
            </p>
        </form>
        <!-- END Forgot Password Form -->
    </div>
@stop

@section('extra-scripts')
    @parent

    <script type="text/javascript">
        function goToForm(form)
        {
            $('.login-wrapper > form:visible').fadeOut(500, function(){
                $('#form-' + form).fadeIn(500);
            });
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