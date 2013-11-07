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
                                {{ Form::textarea('lab_message', Input::old('lab_message'), array('class' => 'form-control', 'id' => 'lab_message', 'placeholder' => 'message: shade, patient name, tooth #, etc. (optional)')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls" id="dz-container">
                                <div id="dz-upload" class="dropzone">
                                    <div class="fallback">
                                        {{ Form::file('file[]', array('multiple' => 'true')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                url: "{{ route('file_upload_post') }}",

                dictRemoveFile: "Delete",

                init: function() {
                    var dz = this;
                    var uploadForm = $('#form-upload');
                    var submitBtn = $("form#form-upload button[type=submit]");

                    // disable submit button by default
                    submitBtn.prop("disabled", true);

                    // // Enable or disable submit button based on form validation and dropzone queue length
                    // uploadForm.bind('keyup', function() {
                    //     if ($(this).validate(validationOptions).checkForm() && dz.files.length > 0) {
                    //         submitBtn.prop("disabled", false);
                    //     } else {
                    //         submitBtn.prop("disabled", true);
                    //     }
                    // });

                    dz.on("addedfile", function() {
                        if (dz.files.length !== 0) {
                            $(".dropzone").css('overflow-y', 'scroll');
                            submitBtn.prop("disabled", false);
                        }
                    }).on("removedfile", function() {
                        if (dz.files.length === 0) {
                            $(".dropzone").css('overflow-y', '');
                            submitBtn.prop("disabled", true);
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

                    this.on("sending", function(file, xhr, formData) {
                        formData.append('_token', $("input[name=_token]").val());
                        formData.append('lab_message', $("#lab_message").val());
                    });

                    this.on("success", function(file, response) {
                        $("a.dz-remove").remove();
                    });

                    this.on("complete", function(file) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                            $('<div class="alert alert-success lead text-muted text-center">Your files have been uploaded successfully. <br /><br />Check your email for a confirmation.  <a href="#" id="upload-more">Upload more?</a></div>').hide().appendTo('#dz-container').slideDown(500);

                            $(document).on('click', '#upload-more', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                dz.removeAllFiles();

                                $(".alert-success").slideUp(500, function() {
                                    $(this).remove();
                                });

                                submitBtn.prop('disabled', false)
                            });
                        }
                    });

                }
            });
        });
    </script>
@stop