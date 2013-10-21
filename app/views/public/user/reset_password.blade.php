@extends('layouts.landing')

@section('body-class')
    <body class="error-page">
@stop

@section('main-content')
<div class="error-wrapper">
	<!-- BEGIN Forgot Password Form -->
        {{ Form::open(array('route' => 'user_reset_password_post', 'id' => 'form-forgot')) }}
            <h3>Password Recovery</h3>
            <hr/>
            <p>Enter the email address associated with your DentalLabProfile.com account to receive your password</p>
            <hr/>
            <div class="form-group">
                <div class="controls">
                    {{ Form::email('lab_email', Input::old('lab_email'), array('class' => 'form-control', 'id' => 'lab_email', 'placeholder' => 'lab email (required)')) }}
                    {{ $errors->first('lab_email', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                </div>
            </div>
            @if (!empty($formError))
                <div class="alert alert-danger text-center"><strong>Error!</strong> {{ $formError }} </div>
            @endif
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary form-control">Reset Password</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="{{ route('home') }}" class="goto-login pull-left"><i class="icon-circle-arrow-left"></i> Back to login form</a>
            </p>
        {{ Form::close() }}
</div>
@stop