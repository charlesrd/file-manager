@extends('layouts.dashboard_sidebar')

@section('title', 'Dashboard')

@section('main-content')
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Recently Uploaded</h3>
                </div>
                <div class="panel-body">
                    @if ($files->count())
                        <div class="table-responsive">
                            <table class="table table-advance">
                                <thead>
                                    <tr>
                                        <th>Date Uploaded</th>
                                        <th>Filename</th>
                                        <th class="text-center">Download Status</th>
                                        <th class="text-center">Shipping Status</th>
                                        <th class="text-center">Expiring</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($files as $file)
                                            @if ($file->download_status)
                                            <tr class="table-flag-green clickable" title="View file details" data-href="{{ route('file_detail_post') }}/{{ $file->id }}" data-placement="bottom" data-toggle="collapse" data-target="#collapse-file_details_{{ $file->id }}" data-id="{{ $file->id }}">
                                            @else
                                            <tr class="table-flag-red clickable show-tooltip" data-placement="bottom" title="View file details" data-href="{{ route('file_detail_post') }}/{{ $file->id }}" data-toggle="collapse" data-target="#collapse-file_details_{{ $file->id }}" data-id="{{ $file->id }}">
                                            @endif
                                                <td>
                                                    {{ $file->formattedCreatedAt() }}
                                                    
                                                </td>
                                                <td>{{ $file->filename_original }}</td>
                                                <td class="text-center">
                                                    @if ($file->download_status)
                                                        <span class="btn btn-success show-tooltip" title="This file has been downloaded by the recipient."><i class="icon-cloud-download"></i> Downloaded</span>
                                                    @else
                                                        <span class="btn btn-danger show-tooltip" title="This file has not yet been downloaded by the recipient."><i class="icon-cloud-download"></i> Not Downloaded</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($file->tracking && !is_null($file->tracking) && $file->tracking != '')
                                                        {{{ $file->tracking }}}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if (strtotime($file->expiration) > strtotime(date("Y-m-d")))
                                                        {{ $file->formattedExpiration() }}
                                                    @else
                                                        Expired
                                                    @endif
                                                </td>
                                                <td class="text-center visible-md visible-lg">
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary file-view-details" title="View file details" href="{{ route('file_detail_post') }}/{{ $file->id }}"><i class="icon-zoom-in"></i> View Detail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="collapse-file_details_{{ $file->id }}" class="collapse">
                                                <td colspan="6">

                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ $files->links() }}
                        </div>
                        <div class="alert alert-info lead text-muted text-center">
                            <strong><i class="icon-cloud-download"></i> </strong> Files can be downloaded for 7 days.  Download access to files will be removed after their expiration.
                        </div>
                    @else
                        <div class="alert alert-danger lead text-muted text-center">You don't seem to have any recently uploaded files.  <br /><br />Once you've uploaded files, detailed information will be available here.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
        $(".file-view-details").remove();

        $(".clickable").click(function(e) {
            e.preventDefault();

            var post_url = $(this).data("href");
            var collapse = $(this).data("target");
            var file_id = $(this).data("id");

            if (!$(collapse).hasClass('in')) {

                $.post(
                    post_url,
                    {
                        _token: "{{ Session::token() }}",
                        file_id: file_id
                    },
                    function(response, status, xhr) {
                        $(collapse + " td").html(response);
                    }
                );

            }

            $(collapse).collapse();
        }).hover( function() {
            $(this).toggleClass('hover');
        });

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