@extends('layouts.dashboard_sidebar')

@section('title', 'Understanding Our Pricing Structure')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>AMSDTI Help</h3>
                            </div>
                            <div class="panel-body">
                                
                                <!-- BEGIN Help Container -->
                                <div class="container">
                                    <div class="row">
                                        <div class="hidden-xs col-sm-1"></div>
                                        <div class="col-xs-12 col-sm-10">
                                            <h1><span class="icon-usd"></span> Understanding Our Pricing Structure</h1>
                                            <div class="table-responsive">
                                                <table id="price-structure-table" class="table table-striped table-bordered text-center">
                                                    <thead>
                                                        <tr>
                                                            <td>Time:</td>
                                                            <td>Mill Type</td>
                                                            <td>Mill Time</td>
                                                            <td>Type</td>
                                                            <td>Member Price</td>
                                                            <td>Non-Member Price</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <!-- Timeframe 1 -->
                                                        <tr>
                                                            <td rowspan="2">12:00am-8:00am</td>
                                                            <td rowspan="2" class="success">Economy</td>
                                                            <td rowspan="2" class="success">Mill Today</td>
                                                            <td class="success">Full Contour</td>
                                                            <td class="success">$30</td>
                                                            <td class="success">$35</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-economy">Coping</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                        </tr>

                                                        <!-- Timeframe 2 -->
                                                        <tr>
                                                            <td rowspan="4">8:00am-2:00pm</td>
                                                            <td rowspan="2" class="info">Standard</td>
                                                            <td rowspan="2" class="info">Mill Today</td>
                                                            <td class="info">Full Contour</td>
                                                            <td class="info">$34</td>
                                                            <td class="info">$39</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-standard">Coping</td>
                                                            <td class="bg-coping-standard">$29</td>
                                                            <td class="bg-coping-standard">$29</td>
                                                        </tr>

                                                        <tr>
                                                            <td rowspan="2" class="success">Economy</td>
                                                            <td rowspan="2" class="success">Mill Tomorrow</td>
                                                            <td class="success">Full Contour</td>
                                                            <td class="success">$30</td>
                                                            <td class="success">$35</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-economy">Coping</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                        </tr>

                                                        <!-- Timeframe 3 -->
                                                        <tr>
                                                            <td rowspan="4">2:00pm-5:00pm</td>
                                                            <td rowspan="2" class="danger">Premium</td>
                                                            <td rowspan="2" class="danger">Mill Today</td>
                                                            <td class="danger">Full Contour</td>
                                                            <td class="danger">$38</td>
                                                            <td class="danger">$43</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-premium">Coping</td>
                                                            <td class="bg-coping-premium">$33</td>
                                                            <td class="bg-coping-premium">$33</td>
                                                        </tr>

                                                        <tr>
                                                            <td rowspan="2" class="success">Economy</td>
                                                            <td rowspan="2" class="success">Mill Tomorrow</td>
                                                            <td class="success">Full Contour</td>
                                                            <td class="success">$30</td>
                                                            <td class="success">$35</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-economy">Coping</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                        </tr>

                                                        <!-- Timeframe 4 -->
                                                        <tr>
                                                            <td rowspan="2">5:00pm-12:00am</td>
                                                            <td rowspan="2" class="success">Economy</td>
                                                            <td rowspan="2" class="success">Mill Tomorrow</td>
                                                            <td class="success">Full Contour</td>
                                                            <td class="success">$30</td>
                                                            <td class="success">$35</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="bg-coping-economy">Coping</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                            <td class="bg-coping-economy">$25</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <h5>* All times are Central Standard Time (CST)</h5>
                                            <h5>* Prices only reflect zirconia milled products</h5>
                                            <h5>* Standard and Premium mill types are only available on standard business days</h5>
                                        </div>
                                        <div class="hidden-xs col-sm-1"></div>
                                    </div>
                                </div>
                                <!-- END Help Container -->

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