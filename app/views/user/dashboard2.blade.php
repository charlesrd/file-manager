@extends('layouts.dashboard_sidebar')

@section('title', 'Recent Uploads')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Recently Uploaded</h3>
                            </div>
                            <div class="panel-body">
                                @if (!empty($data['batch']))
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Date Uploaded</th>
                                                    <th class="text-center">Files</th>
                                                    <th class="text-center">Download Status</th>
                                                    <th class="text-center">Shipping Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($data['batch'] as $batch)
                                                        {{-- If every file in the batch has been downloaded --}}
                                                        @if ($batch['total_download_status'] == "all")
                                                        <tr class="table-flag-green clickable show-tooltip" data-placement="bottom" title="Click to expand and view upload details" data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        {{-- If none of the files in the batch have been downloaded --}}
                                                        @elseif ($batch['total_download_status'] == "none")
                                                        <tr class="table-flag-red clickable show-tooltip" data-placement="bottom" title="Click to expand and view upload details." data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        {{-- If some of the files have been downloaded --}}
                                                        @elseif ($batch['total_download_status'] == "some")
                                                        <tr class="table-flag-orange clickable show-tooltip" data-placement="bottom" title="Click to expand and view upload details." data-href="{{ route('batch_detail_post') }}/{{ $batch['id'] }}" data-toggle="collapse" data-target="#collapse-batch_details_{{ $batch['id'] }}" data-id="{{ $batch['id'] }}">
                                                        @endif
                                                            <td class="text-center show-tooltip" title="{{ $batch['created_at_formatted_human'] }}">
                                                                {{ $batch['created_at_formatted'] }}
                                                            </td>
                                                            <td class="text-center show-tooltip" title="{{ $batch['filename_list'] }}">
                                                                @if ($batch['num_files'] > 1)
                                                                    {{ $batch['num_files'] }} files
                                                                @else
                                                                    {{ $batch['files'][0]['filename_original'] }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- If every file in the batch has been downloaded --}}
                                                                @if ($batch['total_download_status'] == "all")
                                                                    <a class="btn btn-success show-tooltip" title="AMS has recevied all files."><i class="icon-cloud-download"></i> Fully Downloaded</a>
                                                                {{-- If none of the files in the batch have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "none")
                                                                    <a class="btn btn-danger show-tooltip" title="AMS has recevied all files, but none have been milled."><i class="icon-cloud-download"></i> Not Yet Downloaded</a>
                                                                {{-- If some of the files have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "some")
                                                                    <a class="btn btn-warning show-tooltip" title="AMS has received all files, but some have not been milled."><i class="icon-cloud-download"></i> Partially Downloaded</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- If every file in the batch has been shipped --}}
                                                                @if ($batch['total_shipped_status'] == "all")
                                                                    <a class="btn btn-success show-tooltip" title="All cases have been shipped."><i class="icon-truck"></i> Shipped</a>
                                                                {{-- If none of the files in the batch have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "none")
                                                                    <a class="btn btn-danger show-tooltip" title="No cases have been shipped.  Click row to expand and view estimated shipping dates."><i class="icon-truck"></i> Not Yet Shipped</a>
                                                                {{-- If some of the files have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "some")
                                                                    <a class="btn btn-warning show-tooltip" title="Some cases have been shipped.  Click row to expand and view estimated shipping dates."><i class="icon-truck"></i> Partially Shipped</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr id="collapse-batch_details_{{ $batch['id'] }}" class="collapse no-transition batch-details">
                                                            <td colspan="4">
                                                                <div class="row batch-details-row">
                                                                        <div class="col-md-3">
                                                                            <h4><i class="icon-comment"></i> Message</h4>
                                                                            <hr />
                                                                            <p class="batch-message">
                                                                                @if (!empty($batch['message']))
                                                                                    <div class="alert alert-info text-center lead text-warning">
                                                                                        <strong>{{ $batch['message'] }}</strong>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="alert alert-info text-center lead">
                                                                                        No message attached.
                                                                                    </div>
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <h4><i class="icon-file"></i> Files</h4>
                                                                            <hr />
                                                                            <table class="table" id="batch-files-list">
                                                                                <thead>
                                                                                    <th class="text-center">File</th>
                                                                                    <th class="text-center">Milling<br />Type</th>
                                                                                    <th class="text-center">Shipping<br />Type</th>
                                                                                    <th class="text-center">Download<br />Status</th>
                                                                                    <th class="text-center">Shipping<br />Status</th>
                                                                                </thead>
                                                                                <tbody>
                                                                            @foreach ($batch['files'] as $file)
                                                                                <tr>
                                                                                    <td>{{ $file->filename_original }}</td>
                                                                                    <td class="text-center">
                                                                                        @if ($file->milling_type == 1)
                                                                                            Economy
                                                                                        @elseif ($file->milling_type == 2)
                                                                                            <strong class="rush-mill-text">Standard</strong>
                                                                                        @elseif ($file->milling_type == 3)
                                                                                            <strong class="rush-mill-text">Premium</strong>
                                                                                        @else
                                                                                            Economy
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($file->shipping_type == 1)
                                                                                            Regular
                                                                                        @elseif ($file->shipping_type == 2)
                                                                                            <strong class="rush-mill-text">Next Day Air Saver (3pm)</strong>
                                                                                        @elseif ($file->shipping_type == 3)
                                                                                            <strong class="rush-mill-text">Next Day Air (12pm)</strong>
                                                                                        @else
                                                                                            Regular
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($file->download_status)
                                                                                            <span class="btn btn-success show-tooltip" title="AMS has received this file."><i class="icon-cloud-download"></i></span>
                                                                                        @else
                                                                                            <span class="btn btn-danger show-tooltip" title="AMS has received this file but it has not yet been milled."><i class="icon-cloud-download"></i></span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($file->isShipped())
                                                                                            <span class="btn btn-success show-tooltip" title="This file was shipped {{ $file->formattedShipsAt(true) }}" data-file-id="{{ $file->id }}"><i class="icon-truck"></i></span>
                                                                                        @else
                                                                                            <span class="btn btn-danger show-tooltip" title="Expected to ship {{ $file->formattedShipsAt(true) }}" data-file-id="{{ $file->id }}"><i class="icon-truck"></i></span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
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
            $("form button[id^=btn-download-as-batch]").prop('disabled', true);
            $("input[type=checkbox]").on('click', function() {
                var batch_id = $(this).closest("form").data('batch-id');

                console.log(batch_id);

                if ($("form#form-batch-files-" + batch_id + " input[type=checkbox]").is(":checked")) {
                    $('button#btn-download-as-batch-' + batch_id).prop('disabled', false);
                } else {
                    $('button#btn-download-as-batch-' + batch_id).prop('disabled', true);
                }
            });

            $(".clickable").click(function(e) {
                e.preventDefault();

            }).hover( function() {
                $(this).toggleClass('hover');
            });
        });
    </script>
@stop