@extends('layouts.landing')

@section('body-class')
    <body class="error-page">
@stop

@section('main-content')
<div class="error-wrapper">
	<h4>Server Error<span>500</span></h4>
	<p>Something went wrong, but we are working on it!<br/>Please come back in a while.</p>
	<hr/>
	<p class="clearfix">
		<a href="javascript:history.back()" class="pull-left"><i class="icon-circle-arrow-left"></i> Back to previous page</a>
		<a href="{{ route('home') }}" class="pull-right">Go to dashboard</a>
	</p>
</div>
@stop