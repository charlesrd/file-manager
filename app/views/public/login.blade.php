<div class="row-fluid">
    <div class="dialog">
        <div id="login-form" class="block">
            <p class="block-heading">AMSDTI - User Sign In</p>
            <div class="block-body">
                {{ Form::open(array('route' => 'login')) }}

                    {{-- Login or Lab ID Field --}}
                    {{ Form::label('user_email', 'Email') }}
                    {{ Form::text('user_email', Input::old('user_email'), array('class' => 'span12', 'id' => 'user_email')) }}
                    {{ $errors->first('user_email', '<div class="alert alert-error"><strong>Error!</strong> :message </div>') }}

                    {{-- Password Field --}}
                    {{ Form::label('user_password', 'Password') }}
                    {{ Form::password('user_password', array('class' => 'span12', 'id' => 'user_password')) }}
                    {{ $errors->first('user_password', '<div class="alert alert-error"><strong>Error!</strong> :message </div>') }}

                    {{-- Cross-Site Request Forgery Token (hidden) --}}
                    {{ Form::token() }}

                    @if (Session::has('login_errors'))
                        <div class="alert alert-error"><strong>Error!</strong> Invalid login credentials. </div>
                    @endif

                    {{-- Log In (submit the form) --}}
                    {{ Form::submit('Log In', array('class' => 'btn btn-primary pull-right')) }}
                    <div class="clearfix"></div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>