@extends('layouts.dashboard_sidebar')

@section('title', 'Upload Files')

@section('main-content')
    <!-- BEGIN Main Content -->
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="icon-file"></i> Sample Box</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="icon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                {{ Form::open(array('route' => 'file_upload_post', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}
                    <div class="fallback">
                        <input name="file" type="file" multiple="multiple" />
                    </div>
                    {{ Form::token() }}
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

    <script>
    Dropzone.options.dropzone = {
        addRemoveLinks: true
    }
    </script>
@stop