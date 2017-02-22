@extends('layouts.dashboard_sidebar')

@section('title', 'Upload Files')

@section('main-content')
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>File Upload</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'id' => 'form-upload')) }}
                        <div class="form-group">
                            <div class="controls">
                                {{ Form::textarea('lab_message', Input::old('lab_message'), array('class' => 'form-control', 'id' => 'lab_message', 'placeholder' => 'message: shade, patient name, tooth #, etc.  if filenames include patient name, shade, and tooth #, this field is optional.')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls" id="dz-container">
                                <div id="dz-upload" class="dropzone">
                                    <div class="fallback">
                                        {{ Form::file('file[]', array('multiple' => 'true', 'accept' => '.pts, .stl, .sla, .zip, .lab, application/octet-stream, application/zip, application/sla')) }}
                                    </div>
                                </div>
                                {{ $errors->first('file.0', '<div class="alert alert-danger"> :message </div>') }}
                            </div>
                        </div>

                        
                        <!-- <div class="form-group">
                            <div class="controls">
                                <div class="alert alert-info">
                                    <h2><strong>Have a Happy Memorial Day!</strong></h2>
                                    <h3>
                                    In honor of Memorial Day, on Friday, May 23<sup>rd</sup> 2014, the hard cutoff time for files is <strong>2pm.</strong><br>
                                    Files uploaded after 2pm will be milled on <strong>Tuesday, May 27, 2014</strong>.
                                    </h3>
                                </div>
                            </div>
                        </div> -->
                        

                        <!-- <div class="form-group">
                            <div class="controls">
                                <div class="alert alert-warning">
                                <h3>
                                    <strong>Disclaimer:</strong>  Started on April 7<sup>th</sup>, a hard and soft cut off time was implemented. The soft cut off time is 3pm Central Time.
                                    The hard cut off time is 4pm Central time. If you wish to have files milled the same day between 3pm and 4pm, a $3.00 per tooth surcharge will be implemented to help persuade
                                    labs to send earlier throughout the day.
                                </h3>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <div class="controls">
                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-sm-2 col-sm-offset-4">
                                            <h3><label for="shippingType"><strong>Shipping Type:</strong></label></h3>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="shippingType" name="shippingType" class="form-control input-lg">
                                                <option value="1">Standard</option>
                                                <option value="2">Next Day Saver (3pm)</option>
                                                <option value="3">Next Day (10am)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        @if (isset($upload_cutoff))
                            @if ($upload_cutoff === 1)
                                <!-- <div class="form-group">
                                    <div class="controls">
                                        <div class="alert alert-info">
                                            <h3>
                                                <strong>Notice!</strong>  Files uploaded between {{ date("gA", mktime(Config::get('app.file_upload_soft_cutoff_hour'))) }} and {{ date("gA T", mktime(Config::get('app.file_upload_hard_cutoff_hour'))) }}  are subject to a $3.00 per tooth processing fee for same day processing.
                                                <br />
                                                <strong class="hide">Additional charges will not begin until February 1, 2014.</strong>
                                                <br />
                                                <p class="text-left">{{ Form::radio('accept_cutoff_fee', '0', true, array('required' => 'required')) }} <strong>No</strong>, please wait until the next business day to process files.</p>
                                                <p class="text-left">{{ Form::radio('accept_cutoff_fee', '1', null, array('required' => 'required')) }} <strong>Yes</strong>, please process my files today and charge a ${{ Config::get('app.file_upload_rush_processing_fee') }} per tooth processing fee.</p>
                                                {{ Form::hidden('hidAcceptFee', '0', array('id' => 'hidAcceptFee')) }} -->
                                                <!-- <input type="hidden" id="hidAcceptFee" name="hidAcceptFee" value="0" /> -->
                                            <!-- </h3>
                                        </div>
                                        {{ $errors->first('accept_cutoff_fee', '<div class="alert alert-danger"> :message </div>') }}
                                    </div>
                                </div> -->
                            @elseif ($upload_cutoff === 2)
                                <!-- <div class="form-group">
                                    <div class="controls">
                                        <div class="alert alert-info">
                                        <h3>
                                            <strong>Notice!</strong>  Files uploaded after {{ date("gA T", mktime(Config::get('app.file_upload_hard_cutoff_hour'))) }} will be processed next business day.
                                        </h3>
                                        </div>
                                    </div>
                                </div> -->
                            @endif
                        @endif

                        <div class="form-group">
                            <div class="controls">
                                 <button type="button" class="btn btn-primary btn-lg" onclick="clickDropzone()"><span class="icon-upload"></span> Upload More</button><br><br>
                                {{ Form::button('Advance to Shipping Screen', array('class' => 'btn btn-success form-control', 'type' => 'submit')) }}
                            </div>
                        </div>
                        <div class="clearfix">
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('extra-styles')
    {{ Html::style('assets/dropzone/downloads/css/dropzone.css')}}
@stop

@section('extra-scripts')
    {{ Html::script('assets/dropzone-3.10.2/downloads/dropzone.min.js') }}


    <!-- Choose Milling / Shipping Modal -->
    <div class="modal fade" id="mill-ship-modal" tabindex="-1" role="dialog" aria-labelledby="mill-ship-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="closeModal()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title text-center" id="mill-ship-modal-title"><span class="fa fa-retweet"></span> <strong>Choose Milling Type &amp; Delivery Method</strong> <span class="fa fa-truck"></span></h2>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="mill-ship-row" class="row">
                            <div class="col-xs-12">
                                <table id="mill-ship-table" class="table table-striped table-bordered table-hover text-center">
                                    <thead>
                                        <tr class="info">
                                            <td>File #</td><td>Filename</td><td>Milling Type</td><td>Delivery Method</td>
                                        </tr>
                                    </thead>
                                    <tbody id="mill-ship-table-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="mill-ship-total-row" class="row">
                            <div class="col-xs-12">
                                <table id="mill-ship-total-table" class="table table-striped table-bordered text-center">
                                    <!-- <tr><td class="text-right"><strong>Shipping &amp; Handling:</strong></td><td id="shipping-price"></td></tr> -->
                                    <!-- <tr><td class="text-right"><h2>Milling Subtotal:</h2></td><td class="success" id="milling-subtotal"></td></tr> -->
                                    <tr>
                                        <td>
                                            <a id="price-structure-link" href="#" data-toggle="modal" data-target="#price-structure-submodal">Understanding our price structure</a>
                                        </td>
                                        <td>
                                            <h2 class="text-right">Total # of files being sent:</h2>
                                        </td>
                                        <td class="success" id="total-file-count"></td>
                                    </tr>
                                </table>

                                <div id="file-sending-error" class="alert alert-md alert-warning hidden"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn btn-lg btn-danger" data-dismiss="modal"><strong>No</strong>, I've changed my mind</button>
                    <button type="button" onclick="closeModal()" id="mill-ship-done" class="btn btn-lg btn-success btn-done"><span class="glyphicon glyphicon-thumbs-up"></span> <strong>Yes</strong>, submit order</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Apply to All Files SubModal -->
    <div class="modal fade" id="apply-all-submodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Would you like to apply <span id="selected-mill-ship"></span> to all files?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><strong>No</strong>, only this one file</button>
                    <button type="button" onclick="applyAllFiles()" class="btn btn-success" data-dismiss="modal"><strong>Yes</strong>, apply to all files</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Understanding our Price Structure SubModal -->
    <div class="modal fade" id="price-structure-submodal" tabindex="-1" role="dialog" aria-labelledby="priceStructure" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title text-center" id="price-structure-modal-title"><span class="fa fa-usd"></span> <strong>Understanding Our Price Structure</strong></h2>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><strong>close</strong></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Hidden Inputs -->
    <input type="hidden" name="economy-milling-date" id="economy-milling-date" value="" />
    <input type="hidden" name="standard-milling-date" id="standard-milling-date" value="" />
    <input type="hidden" name="premium-milling-date" id="premium-milling-date" value="" />

    <input type="hidden" name="upload-filenames" id="upload-filenames" value="" />
    <input type="hidden" name="selected-milling-options" id="selected-milling-options" value="" />
    <input type="hidden" name="selected-delivery-methods" id="selected-delivery-methods" value="" />

    <?php
        // setup variables
        $now = time();
        $start_time = ["00:00:00", "08:05:00", "14:05:00", "17:05:00"];
        $end_time = ["08:04:59", "14:04:59", "17:04:59", "23:59:59"];

        // check which time period it currently is
        if ( ($now >= strtotime($start_time[0])) && ($now <= strtotime($end_time[0])) ) {$time_period = 1;}
        elseif ( ($now >= strtotime($start_time[1])) && ($now <= strtotime($end_time[1])) ) {$time_period = 2;}
        elseif ( ($now >= strtotime($start_time[2])) && ($now <= strtotime($end_time[2])) ) {$time_period = 3;}
        else {$time_period = 4;}

        // print the current time period
        print '<input type="hidden" name="current-time-period" id="current-time-period" value="'.$time_period.'" />';

        // print the current day
        print '<input type="hidden" name="current-day" id="current-day" value="'.date("d").'" />';

        // print the current month
        print '<input type="hidden" name="current-month" id="current-month" value="'.date("m").'" />';

        // print the current year
        print '<input type="hidden" name="current-year" id="current-year" value="'.date("Y").'" />';

        // check if the user is a member or a non-member
        print '<input type="hidden" name="amsmember" id="amsmember" value="0" />';
    ?>


    <script type="text/javascript">

    // setup variables
    var fileNameArray = [];
    var validFileNameArray = [];
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var days = ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"];
    var fullDays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var holidays = ['01-01', '01-02', '07-04', '12-24', '12-25', '12-26', '12-31'];
    var SHIPPING_METHOD = 0;
    var ECONOMY_MILLING_DATE = "";
    var ECONOMY_MILLING_PRICE = 30;
    var STANDARD_MILLING_PRICE = 34;
    var PREMIUM_MILLING_PRICE = 38;
    var COPING_ECONOMY_MILLING_PRICE = 25;
    var COPING_STANDARD_MILLING_PRICE = 29;
    var COPING_PREMIUM_MILLING_PRICE = 33;
    var REGULAR_SHIPPING_PRICE = 0;
    var NDAS_SHIPPING_PRICE = 5;
    var NDA_SHIPPING_PRICE = 10;
    var SELECTED_MILL_SHIP = 1;
    var SELECTED_MILL_DATE = 0;
    var SELECTED_SHIPPING_METHOD = 0;
    var MILL_SHIP = ["", "Economy Milling", "Standard Milling", "Premium Milling", "Regular Shipping", "Next Day Air Saver (3pm)", "Next Day Air (12pm)"];
    var totalFileCount = 0;
    var DUPLICATE_BATCH_FILES = 0;


    if ($("#amsmember").val() == 0)
    {
        ECONOMY_MILLING_PRICE = 35;
        STANDARD_MILLING_PRICE = 39;
        PREMIUM_MILLING_PRICE = 43;
    }

    var SHIPPING_PRICE = 0;
    var TOTAL_PRICE = 0;

    /* Javascript functions */

    // find the floating holidays for this year
    findFloatingHolidays();

    function findFloatingHolidays()
    {
        // setup variables
        var date = new Date();
        var holiday = "";


        /* Memorial Day */
        var d = new Date(date.getFullYear(), 4, 31);

        // get the last Monday in the month
        while (d.getDay() !== 1) {d.setDate(d.getDate()-1);}

        // add the holiday to the holiday array
        holiday = (format2Digit(d.getMonth()+1))+'-'+(format2Digit(d.getDate()));
        holidays.push(holiday);


        /* Labor Day */
        var d = new Date(date.getFullYear(), 8, 1);

        // get the first Monday in the month
        while (d.getDay() !== 1) {d.setDate(d.getDate()+1);}

        // add the holiday to the holiday array
        holiday = (format2Digit(d.getMonth()+1))+'-'+(format2Digit(d.getDate()));
        holidays.push(holiday);


        /* Thanksgiving Day */
        var d = new Date(date.getFullYear(), 10, 1);

        // get the first Thursday in the month
        while (d.getDay() !== 4) {d.setDate(d.getDate()+1);}

        // get the fourth Thursday in the month
        d.setDate(d.getDate()+21);

        // add the holiday to the holiday array
        holiday = (format2Digit(d.getMonth()+1))+'-'+(format2Digit(d.getDate()));
        holidays.push(holiday);


        /* Black Friday */
        var d = new Date(date.getFullYear(), 10, 1);

        // get the first Thursday in the month
        while (d.getDay() !== 4) {d.setDate(d.getDate()+1);}

        // get the day after the fourth Thursday in the month
        d.setDate(d.getDate()+22);

        // add the holiday to the holiday array
        holiday = (format2Digit(d.getMonth()+1))+'-'+(format2Digit(d.getDate()));
        holidays.push(holiday);
    }

    function format2Digit(n) {return n < 10 ? '0' + n : n;}

    function resetShippingDates(fileNumber, millingDate, shippingMethod, millingMethod)
    {
        $(".shipping-method-"+fileNumber+" p").html("Ships on: "+getShippingDate(millingDate+1,shippingMethod));

        SELECTED_MILL_DATE = millingDate;
        SELECTED_SHIPPING_METHOD = shippingMethod;

        if ($("#mill-ship-modal").is(":visible"))
        {
            showApplyAllSubModal(millingMethod);
        }

        // recalculate total price
        // calculateTotalPrice();
    }

    function calculateShippingPrice()
    {
        SHIPPING_PRICE = 0.00;

        $('input[id^="regular-shipping-"]').each(function(index)
        {
            if ($(this).is(':checked')) {SHIPPING_PRICE += REGULAR_SHIPPING_PRICE;}
        });

        $('input[id^="ndas-shipping-"]').each(function(index)
        {
            if ($(this).is(':checked')) {SHIPPING_PRICE += NDAS_SHIPPING_PRICE;}
        });

        $('input[id^="nda-shipping-"]').each(function(index)
        {
            if ($(this).is(':checked')) {SHIPPING_PRICE += NDA_SHIPPING_PRICE;}
        });

        $("#shipping-price").html("$"+SHIPPING_PRICE.toFixed(2));
    }

    function calculateTotalPrice()
    {
        TOTAL_PRICE = 0.00;

        $('input[id^="economy-milling-"]').each(function(index)
        {
            if ($(this).is(':checked')) {TOTAL_PRICE += ECONOMY_MILLING_PRICE;}
        });

        $('input[id^="standard-milling-"]').each(function(index)
        {
            if ($(this).is(':checked')) {TOTAL_PRICE += STANDARD_MILLING_PRICE;}
        });

        $('input[id^="premium-milling-"]').each(function(index)
        {
            if ($(this).is(':checked')) {TOTAL_PRICE += PREMIUM_MILLING_PRICE;}
        });

        $("#milling-subtotal").html("$"+TOTAL_PRICE.toFixed(2));
    }

    function getNextBusinessDay() {return getShippingDate(1);}
    
    function getShippingDate(businessDaysLeftForShipping, shippingMethod)
    {
        var now = new Date();
        var dayOfTheWeek = now.getDay();
        var calendarDays = businessDaysLeftForShipping;
        var daysRemaining = businessDaysLeftForShipping;
        var deliveryDay = dayOfTheWeek + businessDaysLeftForShipping;
        if (deliveryDay >= 6)
        {
            businessDaysLeftForShipping -= 6 - dayOfTheWeek;  //deduct this-week days
            calendarDays += 2;  //count this coming weekend
            deliveryWeeks = Math.floor(businessDaysLeftForShipping / 5); //how many whole weeks?
            calendarDays += deliveryWeeks * 2;  //two days per weekend per week
        }
        now.setTime(now.getTime() + calendarDays * 24 * 60 * 60 * 1000);

        var returnDate = (format2Digit(now.getMonth()+1))+'-'+(format2Digit(now.getDate()));
        var nextDate = "";

        // check if the return date is a holiday or a weekend
        if ( ($.inArray(returnDate, holidays) >= 0) || (now.getDay() == 0) || (now.getDay() == 6) )
        {
            console.log("returnDate: "+returnDate);
            console.log("daysRemaining: "+daysRemaining);

            // IF the return date is a holiday, get the next business day
            nextDate = getShippingDate(daysRemaining+1);
            if ( (shippingMethod == 1) && ($("#economy-milling-date").val() === nextDate) )
            {
                // alert("economy-milling-date: "+$("#economy-milling-date").val());
                nextDate = getShippingDate(daysRemaining+2);
                // alert("nextDate: "+nextDate);

                return nextDate;
            }
            // if ($("#standard-milling-date").val() === nextDate) {nextDate = getShippingDate(daysRemaining+1);}

            console.log("shippingMethod: "+shippingMethod);
            console.log("economy-milling-date: "+$("#economy-milling-date").val());
            console.log("nextDate: "+nextDate);

            return nextDate;
        }

        nextDate = fullDays[now.getDay()]+", "+months[now.getMonth()]+" "+now.getDate();

        if ( (shippingMethod == 1) && ($("#economy-milling-date").val() === nextDate) )
        {
            nextDate = getShippingDate(daysRemaining+1);
            return nextDate;
        }

        if ($("#standard-milling-date").val() === nextDate) {nextDate = getShippingDate(daysRemaining+1);}

        return nextDate;
    }

    function getMillingDate(businessDaysLeftForMilling, millingMethod)
    {
        var now = new Date();
        var dayOfTheWeek = now.getDay();
        var calendarDays = businessDaysLeftForMilling;
        var daysRemaining = businessDaysLeftForMilling;
        var deliveryDay = dayOfTheWeek + businessDaysLeftForMilling;
        if (deliveryDay >= 6)
        {
            businessDaysLeftForMilling -= 6 - dayOfTheWeek;  //deduct this-week days
            calendarDays += 2;  //count this coming weekend
            deliveryWeeks = Math.floor(businessDaysLeftForMilling / 5); //how many whole weeks?
            calendarDays += deliveryWeeks * 2;  //two days per weekend per week
        }
        now.setTime(now.getTime() + calendarDays * 24 * 60 * 60 * 1000);

        var returnDate = (format2Digit(now.getMonth()+1))+'-'+(format2Digit(now.getDate()));
        var nextDate = "";

        // check if the return date is a holiday or a weekend
        if ( ($.inArray(returnDate, holidays) >= 0) || (now.getDay() == 0) || (now.getDay() == 6) )
        {
            console.log("returnDate: "+returnDate);
            console.log("daysRemaining: "+daysRemaining);

            // IF the return date is a holiday, get the next business day
            nextDate = getMillingDate(daysRemaining+1);
            
            console.log("nextDate: "+nextDate);

            return nextDate;
        }

        nextDate = fullDays[now.getDay()]+", "+months[now.getMonth()]+" "+now.getDate();

        return nextDate;
    }

    function toggleRushContainer(num)
    {
        var rushContainer = $("#rush-container-"+num);
        var additionalShippingOptions = $("#additional-shipping-options-"+num);

        rushContainer.toggle();

        if ($(rushContainer).is(":visible")) {$(additionalShippingOptions).html('<span class="fa fa-minus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options');}
        else {$(additionalShippingOptions).html('<span class="fa fa-plus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options');}
    }

    function showApplyAllSubModal(selectedMillShip)
    {
        // IF the selectedMillShip == 0 OR IF the validFileNameArray.length == 1, then don't show the submodal
        if ( (selectedMillShip == 0) || (validFileNameArray.length == 1) ) {return;}

        $("#selected-mill-ship").html(MILL_SHIP[selectedMillShip]);

        SELECTED_MILL_SHIP = selectedMillShip;

        $("#apply-all-submodal").modal(
        {
            show: true
        });
    }

    function applyAllFiles()
    {
        // apply the selected milling option or delivery method to every file
        if (SELECTED_MILL_SHIP == 1) // Economy Milling
        {
            $('input[id^="economy-milling-"]').prop('checked', true);

            // apply the correct shipping date
            $("[class*=shipping-method] p").html("Ships on: "+getShippingDate(SELECTED_MILL_DATE+1,SELECTED_SHIPPING_METHOD));
        }
        else if (SELECTED_MILL_SHIP == 2) // Standard Milling
        {
            $('input[id^="standard-milling-"]').prop('checked', true);

            // apply the correct shipping date
            $("[class*=shipping-method] p").html("Ships on: "+getShippingDate(SELECTED_MILL_DATE+1,SELECTED_SHIPPING_METHOD));
        }
        else if (SELECTED_MILL_SHIP == 3) // Premium Milling
        {
            $('input[id^="premium-milling-"]').prop('checked', true);

            // apply the correct shipping date
            $("[class*=shipping-method] p").html("Ships on: "+getShippingDate(SELECTED_MILL_DATE+1,SELECTED_SHIPPING_METHOD));
        }
        else if (SELECTED_MILL_SHIP == 4) // Regular Shipping
        {
            $('input[id^="regular-shipping-"]').prop('checked', true);
        }
        else if (SELECTED_MILL_SHIP == 5) // Next Day Air Saver (3pm) Shipping
        {
            $('input[id^="ndas-shipping-"]').prop('checked', true);
        }
        else if (SELECTED_MILL_SHIP == 6) // Next Day Air AM (12pm) Shipping
        {
            $('input[id^="nda-shipping-"]').prop('checked', true);
        }
        else {return;}
    }


    function checkBatchDuplicateFiles()
    {
        validFileNameArray.sort();

        var ERROR_HTML = "";
        var current = null;
        var cnt = 0;
        var ERROR_MESSAGE = "<h4><strong><u>Warning:</u> Duplicate files are about to be uploaded. Please check the following files before sending:<br></strong></h4>";
        DUPLICATE_BATCH_FILES = 0;


        // hide the error messages
        $('#file-sending-error').addClass("hidden");


        for (var i = 0; i <= validFileNameArray.length; i++)
        {
            if (validFileNameArray[i] != current)
            {
                if (cnt > 1) 
                {
                    ERROR_HTML += "<h4>"+current+"</h4>";
                    DUPLICATE_BATCH_FILES = 1;
                }
                current = validFileNameArray[i];
                cnt = 1;
            }
            else 
            {
                cnt++;
            }
        }

        if (DUPLICATE_BATCH_FILES == 1)
        {
            $('#file-sending-error').html(ERROR_MESSAGE+ERROR_HTML);
            $('#file-sending-error').removeClass("hidden");
        }
    }


    function checkUploadedDuplicateFiles()
    {
        validFileNameArray.sort();

        var ERROR_HTML = "";
        var current = null;
        var cnt = 0;
        var ERROR_MESSAGE = "<h4><strong><u>Warning:</u> Files have already been uploaded. Please check the following files before sending:<br></strong></h4>";
        DUPLICATE_BATCH_FILES = 0;


        // hide the error messages
        $('#file-sending-uploaded-error').addClass("hidden");


        for (var i = 0; i <= validFileNameArray.length; i++)
        {
            if (validFileNameArray[i] != current)
            {
                if (cnt > 1) 
                {
                    ERROR_HTML += "<h4>"+current+"</h4>";
                    DUPLICATE_BATCH_FILES = 1;
                }
                current = validFileNameArray[i];
                cnt = 1;
            }
            else 
            {
                cnt++;
            }
        }

        if (DUPLICATE_UPLOADED_FILES == 1)
        {
            $('#file-sending-uploaded-error').html(ERROR_MESSAGE+ERROR_HTML);
            $('#file-sending-uploaded-error').removeClass("hidden");
        }
    }


    function closeModal()
    {
        var modal = $(".modal");

        // hide the modal
        modal.modal('hide');

        $("#form-upload button[type=submit]").prop("disabled", false);
    }

    function clickDropzone()
    {
        $("#dz-upload").trigger("click");
    }

    $(document).ready(function() {


        $("input[name='accept_cutoff_fee']").click(function(){
            $("#hidAcceptFee").val($("input[name='accept_cutoff_fee']:checked").val());
            console.log("AcceptFee: "+$("#hidAcceptFee").val());
        });

        $("#coping-price-btn").click(function(){

            $("#coping-price-table tbody tr td").toggle();

            if ($("#coping-price-table tbody tr td").is(":visible")) {$("#coping-price-table thead tr td").html('<span class="fa fa-minus-square-o"></span> Coping Prices/unit:');}
            else {$("#coping-price-table thead tr td").html('<span class="fa fa-plus-square-o"></span> Coping Prices/unit:');}
        });

        Dropzone.autoDiscover = false;

        $("#dz-upload").dropzone({
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFilesize: 2000, // MB
            maxFiles: 100,
            addRemoveLinks: true,
            createImageThumbnails: false,
            acceptedFiles: "application/xml,text/xml,.xml,.XML,application/x-rar-compressed,application/octet-stream,.zip,.ZIP,application/zip,.stl,.STL,application/sla,.sla,.SLA,application/lab,.lab,.LAB,application/pts,.pts,.PTS",
            url: "http://beta.amsdti.com/file/upload",

            dictRemoveFile: "Delete",

            init: function() {
                var dz = this;
                var uploadForm = $('#form-upload');
                var submitBtn = $("#form-upload button[type=submit]");
                var errorCount = 0;

                // disable submit button by default
                submitBtn.prop("disabled", true);

                dz.on("addedfile", function() {
                    if (dz.files.length !== 0 && dz.files.length <= 10) {
                        $(".dropzone").css('overflow-y', 'scroll');
                        submitBtn.prop("disabled", false);
                    }
                }).on("removedfile", function() {
                    if (dz.files.length === 0) {
                        $(".dropzone").css('overflow-y', '');
                        submitBtn.prop("disabled", true);
                    }
                    if (dz.getRejectedFiles().length === 0) {
                        $("#rejected-files").slideUp(500);
                    }
                });

                $("form#form-upload button[type=submit]").click(
                    function(e) {
                        e.preventDefault(); // prevent default action of click event
                        e.stopPropagation(); // stop DOM propagation

                        // set the variables
                        fileCount = 0;
                        uploadFileCount = 1;
                        totalFileCount = dz.files.length;
                        fileNameArray.length = 0;
                        validFileNameArray.length = 0;
                        var html = "";
                        var MILLLING_OPTIONS = "";
                        var DELIVERY_METHODS = "";

                        // insert the coping prices
                        $("#coping-economy-price").html(COPING_ECONOMY_MILLING_PRICE);
                        $("#coping-standard-price").html(COPING_STANDARD_MILLING_PRICE);
                        $("#coping-premium-price").html(COPING_PREMIUM_MILLING_PRICE);

                        // insert the total number of files being sent
                        $("#total-file-count").html(totalFileCount);
                        
                        // save the uploaded filenames to an array
                        for (var i=0; i<totalFileCount; i++)
                        {
                            currentFileName = dz.files[i].name;
                            fileNameArray.push(currentFileName);

                            var currentFileNameExt = currentFileName.split('.').pop().toLowerCase();

                            // IF the current file is a ".pts" or ".xml" file, skip showing it
                            if ( (currentFileNameExt === "pts") || (currentFileNameExt === "xml") ) {continue;}

                            // add the filename to the validFileNameArray
                            validFileNameArray.push(currentFileName);

                            $("#economy-milling-date").val(getMillingDate(1));
                            $("#standard-milling-date").val(getMillingDate(0));
                            $("#premium-milling-date").val(getMillingDate(0));

                            // create the different milling options based on the current time
                            MILLING_OPTIONS_1 = '<div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',0,0,0)" for="economy-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',1,1,0)" id="economy-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="1" checked="checked"> Economy Milling <span class="text-success">(Best Value)</span><p>Mills on: '+getMillingDate(0)+'</p></label></div>';
                            MILLING_OPTIONS_2 = '<div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',1,1,1)" for="economy-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',1,1,1)" id="economy-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="1" checked="checked"> Economy Milling <span class="text-success">(Best Value)</span><p>Mills on: '+getMillingDate(1)+'</p></label></div><div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',0,0,2)" for="standard-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',0,0,2)" id="standard-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="2"> Standard Milling <p>Mills on: '+getMillingDate(0)+'</p></label></div>';
                            MILLING_OPTIONS_3 = '<div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',1,1,1)" for="economy-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',1,1,1)" id="economy-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="1" checked="checked"> Economy Milling <span class="text-success">(Best Value)</span><p>Mills on: '+getMillingDate(1)+'</p></label></div><div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',0,0,3)" for="premium-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',0,0,3)" id="premium-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="3"> Premium Milling <p>Mills on: '+getMillingDate(0)+'</p></label></div>';
                            MILLING_OPTIONS_4 = '<div class="radio radio-milling"><label onclick="resetShippingDates('+uploadFileCount+',1,1,0)" for="economy-milling-'+uploadFileCount+'" class="label"><input onclick="resetShippingDates('+uploadFileCount+',1,1,0)" id="economy-milling-'+uploadFileCount+'" type="radio" name="milling-option-'+uploadFileCount+'" value="1" checked="checked"> Economy Milling <span class="text-success">(Best Value)</span><p>Mills on: '+getMillingDate(1)+'</p></label></div>';
                            
                            // create the different delivery methods based on the current time
                            DELIVERY_METHODS_1 = '<div class="radio radio-shipping"><label onclick="showApplyAllSubModal(4)" for="regular-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(4)" id="regular-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="1" checked="checked"> Regular Shipping (2-3 business days)<p>Ships on: '+getShippingDate(1)+'</p></label></div><button id="additional-shipping-options-'+uploadFileCount+'" class="additional-shipping-options" onclick="toggleRushContainer('+uploadFileCount+')" data-target="#rush-container-'+uploadFileCount+'"><span class="fa fa-plus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options</button><div class="rush-container" id="rush-container-'+uploadFileCount+'"><h6 class="rush">Rush Shipping (1 business day)</h6><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(5)" for="ndas-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(5)" id="ndas-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="2"> Next Day Air Saver (3pm)<p>Ships on: '+getShippingDate(1)+'</p></label></div><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(6)" for="nda-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(6)" id="nda-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="3"> Next Day Air (12pm)<p>Ships on: '+getShippingDate(1)+'</p></label></div></div>';
                            DELIVERY_METHODS_2 = '<div class="radio radio-shipping"><label onclick="showApplyAllSubModal(4)" for="regular-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(4)" id="regular-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="1" checked="checked"> Regular Shipping (2-3 business days)<p>Ships on: '+getShippingDate(2)+'</p></label></div><button id="additional-shipping-options-'+uploadFileCount+'" class="additional-shipping-options" onclick="toggleRushContainer('+uploadFileCount+')" data-target="#rush-container-'+uploadFileCount+'"><span class="fa fa-plus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options</button><div class="rush-container" id="rush-container-'+uploadFileCount+'"><h6 class="rush">Rush Shipping (1 business day)</h6><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(5)" for="ndas-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(5)" id="ndas-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="2"> Next Day Air Saver (3pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(6)" for="nda-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(6)" id="nda-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="3"> Next Day Air (12pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div></div>';
                            DELIVERY_METHODS_3 = '<div class="radio radio-shipping"><label onclick="showApplyAllSubModal(4)" for="regular-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(4)" id="regular-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="1" checked="checked"> Regular Shipping (2-3 business days)<p>Ships on: '+getShippingDate(2)+'</p></label></div><button id="additional-shipping-options-'+uploadFileCount+'" class="additional-shipping-options" onclick="toggleRushContainer('+uploadFileCount+')" data-target="#rush-container-'+uploadFileCount+'"><span class="fa fa-plus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options</button><div class="rush-container" id="rush-container-'+uploadFileCount+'"><h6 class="rush">Rush Shipping (1 business day)</h6><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(5)" for="ndas-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(5)" id="ndas-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="2"> Next Day Air Saver (3pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(6)" for="nda-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(6)" id="nda-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="3"> Next Day Air (12pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div></div>';
                            DELIVERY_METHODS_4 = '<div class="radio radio-shipping"><label onclick="showApplyAllSubModal(4)" for="regular-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(4)" id="regular-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="1" checked="checked"> Regular Shipping (2-3 business days)<p>Ships on: '+getShippingDate(2)+'</p></label></div><button id="additional-shipping-options-'+uploadFileCount+'" class="additional-shipping-options" onclick="toggleRushContainer('+uploadFileCount+')" data-target="#rush-container-'+uploadFileCount+'"><span class="fa fa-plus-square-o"></span> <span class="fa fa-truck"></span> Additional Shipping Options</button><div class="rush-container" id="rush-container-'+uploadFileCount+'"><h6 class="rush">Rush Shipping (1 business day)</h6><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(5)" for="ndas-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(5)" id="ndas-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="2"> Next Day Air Saver (3pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div><div class="radio radio-shipping"><label onclick="showApplyAllSubModal(6)" for="nda-shipping-'+uploadFileCount+'" class="label shipping-method-'+uploadFileCount+'"><input onclick="showApplyAllSubModal(6)" id="nda-shipping-'+uploadFileCount+'" type="radio" name="delivery-method-'+uploadFileCount+'" value="3"> Next Day Air (12pm)<p>Ships on: '+getShippingDate(2)+'</p></label></div></div>';

                            // determine what milling option & delivery method to use

                            // check if the current date is a holiday or a weekend
                            currentDate = $("#current-month").val()+"-"+$("#current-day").val();
                            var d = new Date($("#current-year").val(), $("#current-month").val()-1, $("#current-day").val());

                            if ( ($.inArray(currentDate, holidays) >= 0) || (d.getDay() == 0) || (d.getDay() == 6) )
                            {
                                MILLING_OPTIONS = MILLING_OPTIONS_1;
                                DELIVERY_METHODS = DELIVERY_METHODS_1;
                            }
                            else
                            {
                                eval('MILLING_OPTIONS = MILLING_OPTIONS_'+$("#current-time-period").val()+';');
                                eval('DELIVERY_METHODS = DELIVERY_METHODS_'+$("#current-time-period").val()+';');
                            }

                            // hack the milling options and delivery methods (for testing purposes only)
                            // MILLING_OPTIONS = MILLING_OPTIONS_3;
                            // DELIVERY_METHODS = DELIVERY_METHODS_3;

                            // add a row to the table for each file
                            html += "<tr><td class=\"filenumber\">"+uploadFileCount+"</td><td class=\"filename\"><span>"+currentFileName+"</span></td><td>"+MILLING_OPTIONS+"</td><td>"+DELIVERY_METHODS+"</td></tr>";

                            // update the counters
                            fileCount++;
                            uploadFileCount++;
                        }

                        // insert the new table rows
                        $("#mill-ship-table-body").html(html);

                        // calculate the shipping price
                        // calculateShippingPrice();

                        // calculate the total price
                        // calculateTotalPrice();


                        // check for duplicate files in the files that are being uploaded
                        checkBatchDuplicateFiles();


                        // IF the economy milling date AND the regular shipping date are equal, then change ALL shipping dates to the next business day
                        if ( ("Ships on: "+getMillingDate(1)) === $("[class*=shipping-method] p").html() )
                        {
                            // apply the correct shipping date
                            $("input[id^=economy-milling]").trigger("click");
                        }

                        $("#mill-ship-modal").modal(
                        {
                            backdrop: 'static',
                            show: true
                        });

                        $(this).prop('disabled', true);
                    }
                );

                $("#mill-ship-done").click(function(e){

                    // setup variables
                    var UF = validFileNameArray.join("|");
                    var MO = "";
                    var DM = "";

                    // reset the selected upload options
                    $("#upload-filenames").val('');
                    $("#selected-milling-options").val('');
                    $("#selected-delivery-methods").val('');

                    // collect all the chosen milling options and delivery methods
                    for (var i = 1; i <= validFileNameArray.length; i++)
                    {
                        // collect the chosen milling option for this file
                        MO += $('input[name="milling-option-'+i+'"]:checked').val()+"|";

                        // collect the chosen delivery method for this file
                        DM += $('input[name="delivery-method-'+i+'"]:checked').val()+"|";
                    }

                    // remove the trailing delimiter
                    MO = MO.slice(0,-1);
                    DM = DM.slice(0,-1);

                    // set the hidden input values
                    $("#upload-filenames").val(UF);
                    $("#selected-milling-options").val(MO);
                    $("#selected-delivery-methods").val(DM);

                    console.log("UF: "+UF+"\nMO: "+MO+"\nDM: "+DM);

                    // Process uploads if all validation has passed.
                    dz.processQueue();
                    
                    // dz.removeAllFiles();

                });

                dz.on('error', function(file, errorMessage) {
                    errorCount++;
                });

                dz.on("sendingmultiple", function(file, xhr, formData) {
                    formData.append('lab_message', $("#lab_message").val());
                    formData.append('_token', $("#form-upload input[name=_token]").val());
                    formData.append('upload-filenames', $("#upload-filenames").val());
                    formData.append('selected-milling-options', $("#selected-milling-options").val());
                    formData.append('selected-delivery-methods', $("#selected-delivery-methods").val());

                    console.log("sending token: "+$("#form-upload input[name=_token]").val());
                });

                dz.on("successmultiple", function(file, response) {
                    $("a.dz-remove").remove();
                });

                var count = 0;

                dz.on("errormultiple", function(files, message, xhr) {
                    console.log("Files = " + files);
                    // console.log("Message = " + JSON.stringify(JSON.parse(message), null, 4));
                    console.log("Message = " + message);
                    // console.log("XHR = " + JSON.stringify(xhr, null, 4));
                    console.log("XHR = " + xhr);
                });

                dz.on("completemultiple", function(file) {
                    if (errorCount == 0) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getRejectedFiles().length === 0) {

                            if (count == 0) {
                                $('<div class="alert alert-success lead text-muted text-center">Your files have been uploaded successfully. <br /><br /><a href="http://beta.amsdti.com/file/history">View Uploaded Files</a> or <a href="#" id="upload-more">Upload more?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                                submitBtn.prop("disabled", true);

                                $(document).on('click', '#upload-more', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();

                                    dz.removeAllFiles();

                                    $(".alert-success").slideUp(500, function() {
                                        $(this).remove();
                                    });

                                    count = 0;
                                    submitBtn.prop("disabled", true);
                                });
                            }
                            count++;
                        } else {
                            if (count == 0) {
                                
                                $(".alert-danger").remove();
                                
                                $('<div class="alert alert-danger lead text-muted text-center" id="rejected-files">Please fix errors above and <a href="#" id="try-again">Try again?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                                $(document).on('click', '#try-again', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();

                                    dz.removeAllFiles();

                                    $(".alert-danger").slideUp(500, function() {
                                        $(this).remove();
                                    });

                                    count = 0;
                                    submitBtn.prop("disabled", true);
                                });
                            }
                            count++;
                        }
                    } else {

                        $(".alert-danger").remove();

                        $('<div class="alert alert-danger lead text-muted text-center" id="rejected-files">Please fix errors above and <a href="#" id="try-again">Try again?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                        $(document).on('click', '#try-again', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            dz.removeAllFiles();

                            $(".alert-danger").slideUp(500, function() {
                                $(this).remove();
                            });

                            count = 0;
                            submitBtn.prop("disabled", true);
                        });
                    }
                });

            }
        });
    });
    </script>
@stop