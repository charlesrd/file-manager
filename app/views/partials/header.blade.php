<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>
        {{ Config::get('app.company_name') }} - {{ Config::get('app.site_title') }}
        @if (isset($title))
            &nbsp;-&nbsp; {{ $title }}
        @endif
    </title>

    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AmericaSmiles Dental Technologies, Inc - File Management System.  Easy file sending and management for dental labs.">
    <meta name="author" content="AmericaSmiles &amp; United Dental Resources">

    {{-- Base CSS styles --}}
    {{ Html::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css') }}
    {{ Html::style('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css') }}
    {{ Html::style('assets/normalize/normalize.css') }}

    {{-- Flaty CSS styles --}}
    {{ Html::style('css/flaty.css') }}
    {{ Html::style('css/flaty-responsive.css') }}

    @section('extra-styles')
    @show

    {{-- AMSDTI Styles --}}
    {{ Html::style('css/style.css') }}

    <!--[if IE 7]>
        {{ Html::style('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css') }}
    <![endif]-->

    <!--[if lt IE 9]>
        {{ Html::script('http://html5shim.googlecode.com/svn/trunk/html5.js') }}
    <![endif]-->

    <link rel="shortcut icon" href="img/favicon.png">

    {{ Html::script('assets/modernizr/modernizr-2.6.2.min.js') }}
</head>

@if (Request::is('user/login'))
    <body class="login-page">
@else
    <body>
@endif

<!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->