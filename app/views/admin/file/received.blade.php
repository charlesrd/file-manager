@extends('layouts.dashboard_sidebar')

@section('title', 'Files Received')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>File History</h3>
                            </div>
                            <div class="panel-body">
                                @if (!empty($data['batch']))
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th>Date Uploaded</th>
                                                    <th>From</th>
                                                    <th>Files</th>
                                                    <th class="text-center">Download Status</th>
                                                    <th class="text-center">Shipping Status</th>
                                                    <th class="text-center">Expiring</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($data['batch'] as $batch)
                                                        {{-- If every file in the batch has been downloaded --}}
                                                        @if ($batch['total_download_status'] == "all")
                                                        <tr class="table-flag-green clickable" title="Click to expand and view batch details" data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        {{-- If none of the files in the batch have been downloaded --}}
                                                        @elseif ($batch['total_download_status'] == "none")
                                                        <tr class="table-flag-red clickable" title="Click to expand and view batch details." data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        {{-- If some of the files have been downloaded --}}
                                                        @elseif ($batch['total_download_status'] == "some")
                                                        <tr class="table-flag-orange clickable" title="Click to expand and view batch details." data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        @endif
                                                            <td>
                                                                {{ $batch['created_at_formatted'] }}
                                                            </td>
                                                            <td>
                                                                {{ $batch['from_lab_name'] }}
                                                            </td>
                                                            <td>
                                                                @if ($batch['num_files'] > 1)
                                                                    {{ $batch['num_files'] }} files
                                                                @else
                                                                    {{ $batch['files'][0]['filename_original'] }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- If every file in the batch has been downloaded --}}
                                                                @if ($batch['total_download_status'] == "all")
                                                                    <a class="btn btn-success show-tooltip" title="All files in this batch have been downloaded."><i class="icon-cloud-download"></i> Downloaded</a>
                                                                {{-- If none of the files in the batch have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "none")
                                                                    <a class="btn btn-danger show-tooltip" title="None of the files in this batch have been downloaded."><i class="icon-cloud-download"></i> Not Downloaded</a>
                                                                {{-- If some of the files have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "some")
                                                                    <a class="btn btn-warning show-tooltip" title="Some of the files in this batch have been downloaded."><i class="icon-cloud-download"></i> Partially Downloaded</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- If every file in the batch has been shipped --}}
                                                                @if ($batch['total_shipped_status'] == "all")
                                                                    <a class="btn btn-success show-tooltip" title="All files in this batch have been shipped."><i class="icon-truck"></i> Shipped</a>
                                                                {{-- If none of the files in the batch have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "none")
                                                                    <a class="btn btn-danger show-tooltip" title="None of the files in this batch have been shipped."><i class="icon-truck"></i> Not Shipped</a>
                                                                {{-- If some of the files have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "some")
                                                                    <a class="btn btn-warning show-tooltip" title="Some of the files in this batch have been shipped."><i class="icon-truck"></i> Partially Shipped</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $batch['expiration_formatted'] }}
                                                            </td>
                                                        </tr>
                                                        <tr id="collapse-batch_details_{{ $batch['id'] }}" class="collapse no-transition batch-details">
                                                            <td colspan="6">
                                                                <div class="row batch-details-row">
                                                                    {{ Form::open(array('route' => 'file_download_checked', 'name' => 'form-batch-files')) }}
                                                                        <div class="col-md-2">
                                                                            <h4><i class="icon-comment"></i> Message</h4>
                                                                            <hr />
                                                                            <p>
                                                                                @if (!empty($batch['message']))
                                                                                    {{ $batch['message'] }}
                                                                                @else
                                                                                    No message attached.
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <h4><i class="icon-file"></i> Files</h4>
                                                                            <hr />
                                                                            <table class="table" id="batch-files-list">
                                                                                <thead>
                                                                                    <th>{{ Form::checkbox('check-all', '') }}</th>
                                                                                    <th>Filename</th>
                                                                                    <th>Date Uploaded</th>
                                                                                    <th>Expiration</th>
                                                                                    <th class="text-center">Download</th>
                                                                                </thead>
                                                                                <tbody>
                                                                            @foreach ($batch['files'] as $file)
                                                                                <tr>
                                                                                    <td>{{ Form::checkbox('download-file[]', $file->id) }}</td>
                                                                                    <td>{{ $file->filename_original }}</td>
                                                                                    <td>
                                                                                        {{ $file->formattedCreatedAt() }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ $file->formattedExpiration() }}
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <a href="{{ route('file_download_single', $file->id) }}" class="btn btn-info show-tooltip" title="Download {{ $file->filename_original }}"><i class="icon-cloud-download"></i></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <h4><i class="icon-cloud-download"></i> Download Center</h4>
                                                                            <hr />
                                                                            <button type="submit" class="btn btn-inverse btn-lg btn-block">Download Checked as .ZIP</button>
                                                                            <a href="{{ route('file_download_batch', $batch['id']) }}" class="btn btn-inverse btn-lg btn-block">Download Batch as .ZIP</a>
                                                                        </div>
                                                                        {{ Form::hidden('batch_from_lab_name', $batch['from_lab_name']) }}
                                                                        {{ Form::hidden('batch_from_lab_email', $batch['from_lab_email']) }}
                                                                        {{ Form::hidden('batch_id', $batch['id']) }}
                                                                    {{ Form::close() }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        {{ $batches->links() }}
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
                </div>
@stop

@section('extra-scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $(".clickable").click(function(e) {
                e.preventDefault();

                // var post_url = $(this).data("href");
                // var collapse = $(this).data("target");
                // var file_id = $(this).data("id");

                // if (!$(collapse).hasClass('in')) {

                //     $.post(
                //         post_url,
                //         {
                //             _token: "{{ Session::token() }}",
                //             file_id: file_id
                //         },
                //         function(response, status, xhr) {
                //             $(collapse + " td").html(response);
                //         }
                //     );

                // }

                $(collapse).collapse();
            }).hover( function() {
                $(this).toggleClass('hover');
            });
        });
    </script>
@stop