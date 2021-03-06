<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <?php 
        // refresh the page automatically at 3pm (server time)
        $now = new DateTime();
        $countdown = strtotime($now->format('Y-m-d') . ' 15:00:00') - time();
        if ($countdown > 0)
        {
            print '<meta http-equiv="refresh" content="'.$countdown.'" />';
        }

        // refresh the page automatically at 4pm (server time)
        $now = new DateTime();
        $countdown = strtotime($now->format('Y-m-d') . ' 16:00:00') - time();
        if ($countdown > 0)
        {
            print '<meta http-equiv="refresh" content="'.$countdown.'" />';
        }
    ?>

    <title>
        {{ Config::get('app.company_name') }} - {{ Config::get('app.site_title') }}
        @if (isset($title))
            &nbsp;-&nbsp; {{ $title }}
        @endif
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AmericaSmiles Dental Technologies, Inc - File Management System.  Easy file sending and management for dental labs.">
    <meta name="author" content="AmericaSmiles &amp; United Dental Resources">

    {{-- Base CSS styles --}}
    {{ Html::style('assets/bootstrap/css/bootstrap.min.css') }}
    {{ Html::style('assets/font-awesome/css/font-awesome.min.css') }}
    {{ Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}

    {{-- Flaty CSS styles --}}
    {{ Html::style('css/flaty.css') }}
    {{ Html::style('css/flaty-responsive.css') }}

    @section('extra-styles')
    @show

    {{-- AMSDTI Styles --}}
    {{ Html::style('css/style.css') }}

    {{-- basic scripts --}}
    {{ Html::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
    <script>
        window.jQuery || document.write('<script src="{{ asset('assets/jquery/jquery-2.0.3.min.js') }}"><\/script>')

        var $buoop = {} 
        $buoop.ol = window.onload; 
        window.onload=function(){ 
            try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
            var e = document.createElement("script"); 
            e.setAttribute("type", "text/javascript"); 
            e.setAttribute("src", "http://browser-update.org/update.js"); 
            document.body.appendChild(e); 
        }
    </script>

    <link rel="shortcut icon" href="img/favicon.png">
</head>

@yield('body-class', '<body>')

<!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<noscript class="alert alert-danger noscript">
    <h3>JavaScript Not Enabled</h3>
    <hr />
    <p>This web application is currently in beta development.  JavaScript must be enabled for full functionality of this web application.  Upon final release, JavaScript support will be optional.</p>

    <p>Here are the <a href="http://www.enable-javascript.com" target="_blank"> instructions on how to enable JavaScript in your web browser.</a></p>
</noscript>