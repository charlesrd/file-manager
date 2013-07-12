<!DOCTYPE html>
<html lang="en">
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

    {{ Html::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css') }}
    {{ Html::style('css/vendor/bootstrap/theme.css') }}
    {{ Html::style('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css') }}
    {{ Html::style('css/vendor/dropzone/basic.css') }}

    <!--[if IE 7]>
        {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css') }}
    <![endif]-->

    <!--[if lt IE 9]>
        {{ HTML::script('http://html5shim.googlecode.com/svn/trunk/html5.js') }}
    <![endif]-->
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class="">
<!--<![endif]-->

@if (Sentry::check())
   @include('partials.nav')
@endif