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
                    {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple" />
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
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}
@stop