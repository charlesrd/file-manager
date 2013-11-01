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
                                {{ Form::textarea('lab_message', Input::old('lab_message'), array('class' => 'form-control', 'id' => 'lab_message', 'placeholder' => 'message to include with upload (optional)')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls" id="dz-container">
                                <div id="dz-upload" class="dropzone">
                                    <div class="fallback">
                                        {{ Form::file('file[]', array('multiple' => 'true', 'accept' => '.STL, .SLA, .ZIP, .LAB, application/octet-stream, application/zip, application/sla')) }}
                                    </div>
                                </div>
                                {{ $errors->first('file.0', '<div class="alert alert-danger"> :message </div>') }}
                            </div>
                        </div>

                        @if (isset($afterCutoff) && $afterCutoff == true)
                            <div class="form-group">
                                <div class="controls">
                                    <div class="alert alert-info"><strong>Notice!</strong>  Files uploaded after 4PM CST are subject to 10% processing fee for same day processing.
                                    <br />
                                    <p class="text-left">{{ Form::radio('accept_cutoff_fee', '0', true, array('required' => 'required')) }} <strong>No</strong>, please wait until the next business day to process files</p>
                                    <p class="text-left">{{ Form::radio('accept_cutoff_fee', '1', null, array('required' => 'required')) }} <strong>Yes</strong>, please process my files today and charge a 10% fee</p>
                                    </div>
                                    {{ $errors->first('accept_cutoff_fee', '<div class="alert alert-danger"> :message </div>') }}
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="controls">
                                {{ Form::button('Upload Files', array('class' => 'btn btn-primary form-control', 'type' => 'submit')) }}
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
    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        Dropzone.autoDiscover = false;

        $("#dz-upload").dropzone({
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            addRemoveLinks: true,
            createImageThumbnails: false,
            maxFiles: 10,
            acceptedFiles: "application/x-rar-compressed,application/octet-stream,.zip,application/zip,.stl,application/sla,.sla,.lab,application/lab",
            url: "{{ route('file_upload_post') }}",

            dictRemoveFile: "Delete",

            init: function() {
                var dz = this;
                var uploadForm = $('#form-upload');
                var submitBtn = $("#form-upload button[type=submit]");

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

                        // Process uploads if all validation has passed.
                        dz.processQueue();

                        $(this).prop('disabled', true);
                    }
                );

                dz.on("sendingmultiple", function(file, xhr, formData) {
                    formData.append('lab_message', $("#lab_message").val());
                    formData.append('accept_cutoff_fee', $("#accept_cutoff_fee").val());
                    formData.append('_token', $("input[name=_token]").val());
                });

                dz.on("successmultiple", function(file, response) {
                    $("a.dz-remove").remove();
                });

                var count = 0;

                dz.on("completemultiple", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getRejectedFiles().length === 0) {

                        if (count == 0) {
                            $('<div class="alert alert-success lead text-muted text-center">Your files have been uploaded successfully. <br /><br />Check your email for a confirmation.  <a href="#" id="upload-more">Upload more?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                            $(document).on('click', '#upload-more', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                dz.removeAllFiles();

                                $(".alert-success").slideUp(500, function() {
                                    $(this).remove();
                                });

                                count = 0;
                                submitBtn.prop('disabled', false)
                            });
                        }
                        count++;
                    } else {
                        if (count == 0) {
                            $('<div class="alert alert-danger lead text-muted text-center" id="rejected-files">Please fix errors above and <a href="#" id="try-again">Try again?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                            $(document).on('click', '#try-again', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                dz.removeAllFiles();

                                $(".alert-danger").slideUp(500, function() {
                                    $(this).remove();
                                });

                                count = 0;
                                submitBtn.prop('disabled', true)
                            });
                        }
                        count++;
                    }
                });

            }
        });
    });
    </script>
@stop