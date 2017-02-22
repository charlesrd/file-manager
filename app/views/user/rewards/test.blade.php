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

                                <!-- Tabulous CSS -->
                                <link rel="stylesheet" type="text/css" href="../css/tabulous.css">
                                
                                <!-- BEGIN Rewards Container -->
                                <div id="rewards-container" class="container">
                                    <div class="row">
                                        <div id="rewards-body" class="col-xs-12">
                                            <div id="tabs">
                                                <ul>
                                                    <li><a href="#tabs-1" class="text-center"><span class="fa fa-question-circle"></span> How to Earn</a></li>
                                                    <li><a href="#tabs-2" class="text-center"><span class="fa fa-usd"></span> Point Values</a></li>
                                                    <li><a href="#tabs-3" class="text-center"><span class="fa fa-shopping-cart"></span> Redeem</a></li>
                                                    <li><a href="#tabs-4" class="text-center"><span class="fa fa-file-text-o"></span> Terms &amp; Conditions</a></li>
                                                    <li><a href="#tabs-5" class="text-center"><span class="fa fa-star-o"></span> My Points</a></li>
                                                </ul>
                                                <div id="tabs_container">
                                                    <div id="tabs-1" class="text-center">
                                                        <h2><strong>Earning AMS Points is easy...</strong></h2>
                                                    </div>
                                                    <div id="tabs-2" class="text-center">
                                                        <h3>Marketing (1.5 points = $1 dollar)</h3>
                                                        <ul>
                                                            <li>Direct Connect ($160/4hr session)</li>
                                                            <li>Customized marketing material (Marketing Advantage $25/hr)</li>
                                                            <li>Website customization ($25/hr)</li>
                                                        </ul>
                                                        <h3>Merchandise (2 points = $1 dollar)</h3>
                                                        <ul>
                                                            <li>Glass Beads</li>
                                                            <li>White Lab Plaster</li>
                                                            <li>Yellow Dental Stone</li>
                                                        </ul>
                                                        <h3>Membership (3 points = $1 dollar)</h3>
                                                        <ul>
                                                            <li>Members will be able to redeem points every 6 months to either get a discount on membership or pay for full membership dues</li>
                                                        </ul>
                                                    </div>
                                                    <div id="tabs-3" class="text-center tabs">
                                                        <h2><label for="choose-points">How many points would you like to redeem?</label></h2>
                                                        <input id="choose-points" class="input-lg max-number-rewards-points" type="text" />
                                                        <h2>
                                                            <label for="choose-category">Choose a Category:</label>
                                                            <select class="input-lg" id="choose-category">
                                                                <option value="1">Marketing</option>
                                                                <option value="2">Merchandise</option>
                                                                <option value="3">Memebership</option>
                                                            </select>
                                                        </h2>
                                                        <h2>
                                                            <label for="choose-category">Redeem for:</label>
                                                            <select class="input-lg" id="choose-sub-category">
                                                                <option value="1">Direct Connect</option>
                                                                <option value="2">Customized Marketing Material</option>
                                                                <option value="3">Website Customization</option>
                                                            </select>
                                                        </h2>
                                                        <button id="redeemPointsButton" type="button" onclick="redeemPoints()" class="btn btn-lg btn-success btn-done"><span class="fa fa-shopping-cart"></span> Redeem</button>
                                                    </div>
                                                    <div id="tabs-4" class="text-center">
                                                        <h2>Terms &amp; Conditions here...</h2>
                                                    </div>
                                                    <div id="tabs-5" class="text-center">
                                                        <table id="my-points-layout">
                                                            <tr>
                                                                <td id="my-points-links">
                                                                    <ul>
                                                                        <li class="active" data-target="#my-points-view-1"><span class="fa fa-star"></span> Current Points</li>
                                                                        <li data-target="#my-points-view-2"><span class="fa fa-area-chart"></span> History</li>
                                                                    </ul>
                                                                </td>
                                                                <td id="my-points-view">
                                                                    <span id="my-points-view-1" class="my-points-view">
                                                                        <h3 class="full-icon"><span class="fa fa-star"></span></h3>
                                                                        <span id="current-points"><span class="rewards-points"></span> points</span>
                                                                    </span>
                                                                    <span id="my-points-view-2" class="my-points-view">
                                                                        <h3 class="full-icon"><span class="fa fa-area-chart"></span></h3>
                                                                        <span id="current-points"><span class="rewards-points"></span> points</span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div><!--End tabs container--> 
                                            </div><!--End tabs-->
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
    <script type="text/javascript" src="../js/tabulous.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {

        $('#tabs').tabulous({
            effect: 'slideLeft'
        });

        getCurrentRewardsPoints({{ $user->lab_id }});

        $("#my-points-links ul li").click(function(){
            var hideTime = 700;
            var target = $(this).data("target");

            $("#my-points-links ul li").removeClass("active");
            $(this).addClass("active");

            $(".my-points-view").hide(hideTime);
            setTimeout(function() {$(target).show(700);}, hideTime);
        });

    });
    </script>
@stop