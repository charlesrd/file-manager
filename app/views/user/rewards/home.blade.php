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

                                            <h2 class="text-center">AMS Star Rewards</h2>
                                            <p class="text-center">
                                            <strong>AMS Dental Technologies participation in the AmericaSmiles Network’s AMS Star Rewards<sup><small>TM</small></sup> program</strong>
                                            </p>
                                            <p>
                                            AMS Dental Technologies joined the AmericaSmiles Network’s AMS Star Rewards<sup><small>TM</small></sup> program in 2014 and recently agreed to extend through 2016.
                                            </p>
                                            <p>
                                            AMS Dental Technologies customers are rewarded points for utilizing milling services. Star Reward points are granted for purchases of Full-Contour Zirconia Crowns, Zirconia Copings, or Z-Max (cut-back) restoratives. Points can be applied to the AmericaSmiles Network products and services such as AmericaSmiles branded lab supplies, marketing services (including Direct Connect), and even Network membership fees.
                                            </p>
                                            <p>
                                            As the exclusive and certified milling center for the AmericaSmiles Network, AMS Dental Technologies is pleased to provide AmericaSmiles Network members with this new perk for utilizing the mill. Program Rules for AMS Star RewardsTM points accumulation and redemption can be found at <a target="_blank" href="http://www.americasmiles.net/ams-star-rewards-terms-and-conditions/">americasmiles.net/ams-star-rewards-terms-and-conditions</a> and accumulated point totals can be viewed on-line at <a target="_blank" href="http://amsdti.com/">www.amsdti.com</a>
                                            </p>
                                            <h2 class="text-center"><strong>When are points granted?</strong></h2>
                                            <p>
                                            One Star Reward Point shall be granted for each Full-Contour Zirconia Crown or cut-back, and for Zirconia Copings.
                                            </p>

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