@extends('layouts.dashboard_sidebar')

@section('title', 'Upload Files')

@section('main-content')
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}
                    <div class="panel-heading">
                        <h3>Important: Upload Time is after 4pm CST</h3>
                    </div>
                    <div class="panel-body">
                        <p>By choosing to have your files processed today, you agree to pay the $x expedited charge.  If you choose this option, we will bill your card on file for a total of $x.</p>
                        <p>
                            <label class="radio">{{ Form::radio('expedited', '0') }} NO, DO NOT PROCESS MY FILES TODAY. (YOU WILL NOT BE CHARGED)</label>
                            <label class="radio">{{ Form::radio('expedited', '1') }} YES, PROCESS MY FILES TODAY.  I AGREE TO THE EXPEDITION CHARGE OF $x.</label>
                        </p>
                    </div>
                    <div class="panel-body">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple" />
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <!-- END Main Concent -->
@stop

@section('extra-styles')
    {{ Html::style('assets/dropzone/downloads/css/dropzone.css')}}
@stop

@section('extra-scripts')
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}
@stop