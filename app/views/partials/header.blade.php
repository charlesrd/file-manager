<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <?php

        // setup variables
        $now = time();
        $start_time = ["00:00:00", "08:05:00", "14:05:00", "17:05:00"];
        $end_time = ["08:04:59", "14:04:59", "17:04:59", "23:59:59"];

        // check which time period it currently is
        if ( ($now >= strtotime($start_time[0])) && ($now <= strtotime($end_time[0])) ) {$time_period = 1;}
        elseif ( ($now >= strtotime($start_time[1])) && ($now <= strtotime($end_time[1])) ) {$time_period = 2;}
        elseif ( ($now >= strtotime($start_time[2])) && ($now <= strtotime($end_time[2])) ) {$time_period = 3;}
        else {$time_period = 0;}

        // refresh the page automatically at the new time period (server time)
        $now = new DateTime();
        
        // if the time period is the last time period, add one day to the next refresh time
        if ($time_period == 0) {$now->modify('+1 day');}

        $countdown = strtotime($now->format('Y-m-d') . ' ' . $start_time[$time_period]) - time();
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
    <!-- {{ Html::style('assets/bootstrap/css/bootstrap.min.css') }} -->
    {{ Html::style('assets/font-awesome/css/font-awesome.min.css') }}
    {{ Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
    {{ Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}

    {{-- Flaty CSS styles --}}
    {{ Html::style('css/flaty.css') }}
    {{ Html::style('css/flaty-responsive.css') }}

    @section('extra-styles')
    @show

    {{-- AMSDTI Styles --}}
    <link media="all" type="text/css" rel="stylesheet" href="http://beta.amsdti.com/css/style.css?v=<?=time();?>">

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

    <link rel="shortcut icon" href="http://beta.amsdti.com/img/favicon.png">
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

<?php

// <!-- <div class="login-wrapper">
//     <div class="alert alert-warning" role="alert">
//         <h4 class="text-center"><strong>Internet Connection:</strong> The connection to this website may be slow due to a broken link in the line to this server. Unfortunately, this is out of our control, but is normally resolved soon.</h4>
//     </div>
// </div> -->

?>

<?php
// <!-- <div class="login-wrapper">
//     <div class="alert alert-warning" role="alert">
//         <h4 class="text-center"><strong>Phone Issues:</strong> 
//             <br>Our phone line is currently having technical issues for incoming and outgoing calls. 
//             <br>If you'd like to contact us, please use the Message Center.
//         </h4>
//     </div>
// </div> -->
?>


<?php
// <!-- <div class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h4 class="text-center">
//         <u>Labor Day Schedule:</u> Economy files sent after 8am on Thursday Sept.1<sup>st</sup> will be milled on Friday, <br>
//         but will not be shipped until Tuesday, Sept. 6<sup>th</sup>. All files sent on Friday Sept. 2<sup>nd</sup> will be shipped one <br>
//         day later than usual due to Labor Day. <strong>Thank you &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div>
//  -->
?>

<?php

// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <button style="position: absolute; right: 10px; top: 5px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button>
//         <h4 class="text-center">
//         <u>Holiday Schedule:</u><br>In observance of Christmas, cases milled on Wednesday, Dec. 23rd will leave our office on Monday, Dec. 28th.<br>
//         In observance of the New Year, cases milled on Wednesday, Dec. 30th will leave our office on Monday, Jan. 4th.<br>
//         <strong>Merry Christmas &amp; Happy New Year &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->

?>


<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <button style="position: absolute; right: 10px; top: 5px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button>
//         <h4 class="text-center">
//         <u>Holiday Schedule:</u><br>In observance of Christmas, cases milled on Friday, Dec. 23rd will leave our office on Tuesday, Dec. 27th.<br>
//         Files received after noon (12pm CST) on Friday, Dec. 23rd will be milled on Tuesday, Dec. 27th.<br>
//         In observance of the New Year, cases milled on Friday, Dec. 30th will leave our office on Tuesday, Jan. 3rd.<br>
//         Files received after noon (12pm CST) on Friday, Dec. 30th will be milled on Tuesday, Jan. 3rd.<br>
//         <strong>Merry Christmas &amp; Happy New Year &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>

<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <button style="position: absolute; right: 10px; top: 5px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button>
//         <h4 class="text-center">
//         <u>Holiday Schedule:</u><br>In observance of the New Year, cases milled on Friday, Dec. 30th will leave our office on Tuesday, Jan. 3rd.<br>
//         Files received after noon (12pm CST) on Friday, Dec. 30th will be milled on Tuesday, Jan. 3rd.<br>
//         <strong>Happy New Year &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>

<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <button style="position: absolute; right: 10px; top: 5px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button>
//         <h4 class="text-center">
//         <u>Thanksgiving Day Schedule:</u><br>Cases milled on Wednesday, Nov. 25th will leave our office on Monday, Nov. 30th.<br>
//         <strong>Thank you &amp; Happy Thanksgiving &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>


<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h7 class="text-right" style="position: absolute; right: 10px;"><button style="position: absolute; right: 0px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button></h7>
//         <h4 class="text-center">
//         <u>Thanksgiving Day Schedule:</u><br>Cases milled on Wednesday, November 25th will leave our office on Monday, November 30th.<br>
//         <strong>Thank you &amp; Happy Thanksgiving &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>

<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h7 class="text-right" style="position: absolute; right: 10px;"><button style="position: absolute; right: 0px;" class="btn btn-info btn-sm" onclick="$('#top-announcement').hide();"><span class="fa fa-close"></span></button></h7>
//         <h4 class="text-center">
//         <u>Thanksgiving Day Schedule:</u><br>Cases milled on Wednesday, November 23rd will leave our office on Monday, November 28th.<br>
//         <strong>Thank you &amp; Happy Thanksgiving &ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>

<?php
// <!-- <div class="login-wrapper">
//     <div class="alert alert-warning" role="alert">
//         <h2 style="font-size: 2.0em; color: #ff0000; text-decoration: underline;"><strong>Good Friday Schedule</strong></h2>
//         <h3>
//         Files received after noon (12pm CST) will be milled on Monday, April 6<sup>th</sup>.
//         </h3>
//     </div>
// </div> -->

?>


<div class="login-wrapper">
    <div class="alert alert-info" role="alert">
        <h2 style="font-size: 2.0em; text-decoration: underline;"><strong>LabDay 2017 Schedule</strong></h2>
        <h3>
        On Friday, February 24<sup>th</sup> 2017, files received after noon (12pm CST) will be milled on Monday, February 27<sup>th</sup>. Please plan accordingly.
        </h3>
    </div>
</div>


<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h4 class="text-center">
//         In observance of Good Friday, Files received after 1:00pm (CST) on<br>
//         Friday, March 25<sup>th</sup> will be milled on Monday, March 28<sup>th</sup>.
//         <strong>&ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h4>
//     </div>
// </div> -->
?>

<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h5 class="text-center">
//         Wishing you and your family a blessed Memorial Day Weekend<br>
//         and a reminder that cases milled on Friday May 27<sup>th</sup><br>
//         will ship out Tuesday May 31<sup>st</sup>. All files sent<br>
//         on Friday May 27<sup>th</sup> after 2:00pm will be milled on<br>
//         Tuesday May 31<sup>st</sup>. Please plan accordingly.<br>
//         <strong>&ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h5>
//     </div>
// </div> -->
?>

<?php
// <!-- <div id="top-announcement" class="login-wrapper">
//     <div class="alert alert-info" role="alert">
//         <h5 class="text-center">
//         Wishing you and your family a blessed 4<sup>th</sup> of July Weekend<br>
//         and a reminder that cases milled on Friday July 1<sup>st</sup><br>
//         will ship out Tuesday July 5<sup>th</sup>. All files sent<br>
//         on Friday July 1<sup>st</sup> after 2:00pm will be milled on<br>
//         Tuesday July 5<sup>th</sup>. Please plan accordingly.<br>
//         <strong>&ndash; AMS Dental Technologies <i class="fa fa-smile-o"></i></strong>
//         </h5>
//     </div>
// </div> -->
?>

