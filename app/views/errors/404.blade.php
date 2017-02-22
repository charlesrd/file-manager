@extends('layouts.landing')

@section('body-class')
    <body class="error-page">
@stop

@section('main-content')
<div class="error-wrapper">
	<h4>Page Not Found<span>404</span></h4>
	<p>Oops! Sorry, that page couldn't be found.</p>
	<hr/>
	<p class="clearfix">
		<a href="javascript:history.back()" class="pull-left"><i class="icon-circle-arrow-left"></i> Back to previous page</a>
		<a href="{{ route('home') }}" class="pull-right">Go to dashboard</a>
	</p>
</div>
@stop