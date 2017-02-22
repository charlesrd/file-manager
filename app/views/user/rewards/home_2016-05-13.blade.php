@extends('layouts.dashboard_sidebar')

@section('title', 'AMS Star Rewards')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>AMS Star Rewards</h3>
                            </div>
                            <div class="panel-body">
                                
                                <!-- BEGIN Rewards Container -->
                                <div id="rewards-container" class="container">
                                    <div class="row">
                                        <div id="rewards-body" class="col-xs-12">

                                        <h2 class="text-center"><strong>AMS Dental Technologies Celebrates new milling services</strong></h2>
                                        <p>
                                        AMS Dental Technologies, in conjunction with the AmericaSmiles Network has launched a rewards program called AMS 
                                        Star Rewards<sup>TM</sup>. Points accumulation began August 1<sup>st</sup>, 2014.
                                        </p>
                                        <p>
                                        As a way to celebrate the launching of our new Titanium custom abutment milling services and reward customer 
                                        loyalty, AMS Dental Technologies has established new pricing, allowing customers to secure Full-Contour 
                                        Zirconia Crowns at $30 as a standard.  Participating in the AmericaSmiles AMS Star Rewards program brings 
                                        added benefits to loyal customers.
                                        </p>
                                        <p>
                                        AMS Dental Technologies customers began accumulating points on August 1<sup>st</sup>, 2014 as they utilize the 
                                        services of the dental design and milling center. Points are earned on purchases of Titanium Custom Abutments, 
                                        Full-Contour Zirconia Crowns, Zirconia Copings, or Z-Max restoratives. Points can be applied to the AmericaSmiles 
                                        Network products and services such as AmericaSmiles branded lab supplies, marketing services (including Direct 
                                        Connect), and even Network membership fees. As the exclusive and certified milling center for the AmericaSmiles 
                                        Network, AMS Dental Technologies is pleased to provide AmericaSmiles Network members with this new perk for 
                                        utilizing the mill.
                                        </p>
                                        <p>
                                        Program Rules for AMS Star Rewards<sup>TM</sup> points accumulation and redemption can be found at 
                                        <a target="_blank" href="http://americasmiles.net/ams-star-rewards-terms-and-conditions">americasmiles.net/ams-star-rewards-terms-and-conditions</a> and 
                                        accumulated point totals can be viewed on-line at <a target="_blank" href="http://www.amsdti.com">www.amsdti.com</a>
                                        </p>
                                        <h2 class="text-center"><strong>How do I earn points?</strong></h2>
                                        <p>
                                        One Point shall be awarded for each Titanium Custom Abutment, Full-Contour Zirconia Crown or Zirconia Coping.
                                        </p>
                                        <p>
                                        <strong>Did you say $30 Zirconia Crowns?</strong>
                                        </p>
                                        <p>
                                        <strong>Yes.</strong> AMS Dental Technologies has standardized our pricing and launched new Service types to 
                                        help customers save money on Full-Contour Zirconia Crowns:<br>
                                        <strong>Economy</strong> - Electronic files received at any time for next day milling - $30.00<br>
                                        <strong>Standard</strong> - Electronic files received between 8am and 2pm for same-day milling - $34.00<br>
                                        <strong>Premium</strong> - Electronic files received between 2pm and 5pm for same-day milling - $38.00<br>
                                        All cases where a physical model is sent to AMS Dental Technologies are treated as Standard Service.
                                        </p>
                                        <!--
                                        <p>AMS Dental Technologies will launch a new rewards program in September called AMS Star Rewards 
                                        with details to follow soon. We have decided to begin counting points as of <strong>August 1<sup>st</sup>, 2014</strong>.</p>
                                        
                                        <p>AMS Dental Technologies customers will accumulate points as they utilize the services of the dental 
                                        design and milling center. Points can be applied to the AmericaSmiles Network services including 
                                        purchasing AmericaSmiles branded lab supplies, marketing services including Direct Connect, and even 
                                        a portion of membership dues. As the exclusive and certified milling center for the AmericaSmiles 
                                        Network, AMS Dental Technologies is pleased to provide AmericaSmiles Network members with this new 
                                        perk for utilizing the mill.</p>

                                        <p>Program Rules for AMS Star Rewards points accumulation and redemption will be announced in early 
                                        September. In the meantime, points will accumulate and can be viewed online at <a href="http://www.amsdti.com">www.amsdti.com</a>.</p>
                                        -->
                                        </div>
                                    </div>
                                </div>
                                <!-- END Rewards Container -->

                            </div>
                        </div>
                    </div>
                </div>
@stop

@section('extra-scripts')
    {{ Html::script('assets/jquery-validation/dist/jquery.validate.min.js') }}
    {{ Html::script('assets/jquery-validation/dist/additional-methods.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {



    });
    </script>
@stop