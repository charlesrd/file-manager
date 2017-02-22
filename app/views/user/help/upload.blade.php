@extends('layouts.dashboard_sidebar')

@section('title', 'How to Upload Files?')

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
                                            <h1><span class="fa fa-cloud-upload"></span> How to Upload Files?</h1>
                                            <ul class="tutorial-list">
                                                <li>
                                                    <h2>1. Click <strong>&quot;Upload Files&quot;</strong> in the top right hand corner of your screen.</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-1.jpg">
                                                </li>
                                                <li>
                                                    <h2>2. Drag and drop (Or click to select files) to upload</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-2.jpg">
                                                </li>
                                                <li>
                                                    <h2>3. Click the green <strong>&quot;Upload Files&quot;</strong> button to upload your files</h2>
                                                </li>
                                                <li>
                                                    <h2>4. Select Milling type {{ Html::linkRoute('help_pricing', 'Click here for a description of mill types, pricing, and schedule') }}</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-3.jpg">
                                                    <h2>*If you are uploading multiple files and you choose a different milling type, a dialog box will appear:</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-4.jpg">
                                                    <h2>** To apply mill type to all files click <strong>&quot;Yes, apply to all files&quot;</strong>, 
                                                    or if you would like to choose specific mill types for each individual file click 
                                                    <strong>&quot;No, only this one file&quot;</strong></h2>
                                                </li>
                                                <li>
                                                    <h2>5. Select your delivery method</h2>
                                                    <ul class="tutorial-sublist">
                                                        <li><h2>Regular Shipping is standard (2-3 business days)</h2></li>
                                                        <li>
                                                            <h2>For more options, including Next Day Air Saver and Next Day Air, 
                                                            click the &quot;Additional Shipping Options&quot; Button</h2>
                                                        </li>
                                                    </ul>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-5.jpg">
                                                    <h2>*If you are uploading multiple files and chose a different shipping type, a dialog box will appear:</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-6.jpg">
                                                    <h2>** To apply this shipping option to all files, click <strong>&quot;Yes, apply to all files&quot;</strong> or 
                                                    If you would like to choose specific shipping options for each individual file click 
                                                    <strong>&quot;No, only this one file&quot;</strong></h2>
                                                </li>
                                                <li>
                                                    <h2>6. To upload your files and complete your order click the green <strong>&quot;Yes, submit order&quot;</strong> button</h2>
                                                    <img class="img-responsive" src="http://beta.amsdti.com/img/tutorial-upload-7.jpg">
                                                </li>
                                            </ul>
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