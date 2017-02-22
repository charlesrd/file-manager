@extends('layouts.dashboard_sidebar')

@section('title', 'Order Scan Flags')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Order Scan Flags</h3>
                            </div>
                            <div class="panel-body">
                                
                                <!-- BEGIN Order Form -->
                                <div id="order-container" class="container">
                                    <div class="row">
                                        <div id="order-body" class="col-xs-12">
                                            <img src="{{ asset('img/order-scan-flags.jpg') }}" class="img-responsive" id="sf-image" alt="Order Scan Flags from AMS Technologies to recieve your $30 Gift Certificate* today!" />
                                            <div id="sf-order-options" class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-xs-7 col-sm-12">
                                                            <h3 class="order-label">Select a Scan Flag</h3>
                                                            <select class="form-control input-lg" id="sf-type" name="sf-type">
                                                                <option value="1">1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7 col-sm-3">
                                                            <h3 class="order-label">Quantity</h3>
                                                            <select class="form-control input-lg" id="sf-qty" name="sf-qty">
                                                                <option value="1">1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-offset-3 col-sm-6">
                                                            <button id="order-submit" type="submit" class="btn btn-primary form-control"><i class="icon-shopping-cart"></i> Order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Order Form -->

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

        // disable submit button by default
        $('#order-submit').prop("disabled", true);

    });
    </script>
@stop