@extends('layouts.dashboard_sidebar')

@section('title', 'AMSDTI Help')

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
                                        <div class="hidden-xs col-sm-3"></div>
                                        <div class="col-xs-12 col-sm-6">
                                            <h1>AMSDTI Help</h1>
                                            <ul>
                                                <li><h2>{{ Html::linkRoute('help_upload', 'How to Upload Files?') }}</h2></li>
                                                <li><h2>{{ Html::linkRoute('help_pricing', 'Understanding Our Pricing Structure') }}<h2></li>
                                            </ul>
                                        </div>
                                        <div class="hidden-xs col-sm-3"></div>
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