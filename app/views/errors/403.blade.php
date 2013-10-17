@extends('layouts.landing')

@section('body-class')
    <body class="error-page">
@stop

@section('main-content')
<div class="error-wrapper">
	<h4>Forbidden<span>403</span></h4>
	<p>Whoa there! Sorry, but you don't have the credentials to visit this page.</p>
	<hr/>
	<p class="clearfix">
		<a href="javascript:history.back()" class="pull-left"><i class="icon-circle-arrow-left"></i> Back to previous page</a>
		<a href="{{ route('home') }}" class="pull-right">Go to dashboard</a>
	</p>
</div>
@stop