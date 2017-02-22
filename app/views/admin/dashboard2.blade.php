@extends('layouts.dashboard_sidebar')

@section('title', 'Dashboard')

@section('main-content')
                <div class="row" id="dashboard-tiles">
                    <div class="col-md-4">
                        <div class="tile">
                            <div class="img">
                                <i class="icon-file"></i>
                            </div>
                            <div class="content">
                                <p class="big">{{ $data['today_filecount'] }}</p>
                                <p class="title">Today</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tile">
                            <div class="img">
                                <i class="icon-file"></i>
                            </div>
                            <div class="content">
                                <p class="big">{{ $data['weekly_filecount'] }}</p>
                                <p class="title">Week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tile">
                            <div class="img">
                                <i class="icon-file"></i>
                            </div>
                            <div class="content">
                                <p class="big">{{ $data['averageXDays_filecount'] }}</p>
                                <p class="title">{{{ Config::get('app.average_last_x_days_filecount') }}} Day Avg</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Recently Received Files</h3>
                            </div>
                            <div class="panel-body">
                                @if (!empty($data['batch']))
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Date Uploaded</th>
                                                    <th class="text-center">Lab</th>
                                                    <th class="text-center visible-lg">Email</th>
                                                    <th class="text-center">Files</th>
                                                    <th class="text-center">Download Status</th>
                                                    <th class="text-center">Shipping Status</th>
                                                    <th class="text-center visible-lg">Downloaded</th>
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
                                                            <td class="text-center visible-lg">
                                                                {{ $batch['from_lab_name'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $batch['from_lab_email'] }}
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
                                                                    <a class="btn btn-success" title="All files have been downloaded."><i class="icon-cloud-download"></i> Fully Downloaded</a>
                                                                {{-- If none of the files in the batch have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "none")
                                                                    <a class="btn btn-danger" title="No files have been downloaded."><i class="icon-cloud-download"></i> Not Downloaded</a>
                                                                {{-- If some of the files have been downloaded --}}
                                                                @elseif ($batch['total_download_status'] == "some")
                                                                    <a class="btn btn-warning" title="Some files have been downloaded."><i class="icon-cloud-download"></i> Partially Downloaded</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- If every file in the batch has been shipped --}}
                                                                @if ($batch['total_shipped_status'] == "all")
                                                                    <a class="btn btn-success" title="All cases have been shipped."><i class="icon-truck"></i> Shipped</a>
                                                                {{-- If none of the files in the batch have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "none")
                                                                    <a class="btn btn-danger" title="No cases have been shipped.  Click row to expand and view estimated shipping dates."><i class="icon-truck"></i> Not Yet Shipped</a>
                                                                {{-- If some of the files have been shipped --}}
                                                                @elseif ($batch['total_shipped_status'] == "some")
                                                                    <a class="btn btn-warning" title="Some cases have been shipped.  Click row to expand and view estimated shipping dates."><i class="icon-truck"></i> Partially Shipped</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center visible-lg show-tooltip" title="{{ $batch['expires_at_formatted_human'] }}">
                                                                {{ $batch['expires_at_formatted'] }}
                                                            </td>
                                                        </tr>
                                                        <tr id="collapse-batch_details_{{ $batch['id'] }}" class="collapse no-transition batch-details">
                                                            <td colspan="7">
                                                                <div class="row batch-details-row">
                                                                    {{ Form::open(array('route' => 'file_download_checked', 'name' => 'form-batch-files', 'id' => 'form-batch-files-' . $batch['id'], 'data-batch-id' => $batch['id'])) }}
                                                                        <div class="col-md-2">
                                                                            <h4><i class="icon-comment"></i> Message</h4>
                                                                            <hr />
                                                                            <p>
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
                                                                            <h4><i class="icon-star"></i> Rush Processing</h4>
                                                                            <hr />
                                                                            @if ($batch['accept_cutoff_fee'] == true)
                                                                                <div class="alert alert-info text-center lead text-warning">
                                                                                    <strong>RUSH MILL</strong>
                                                                                </div>
                                                                            @else
                                                                                <div class="alert alert-info text-center lead">
                                                                                    NO RUSH
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <h4><i class="icon-file"></i> Files</h4>
                                                                            <hr />
                                                                            <table class="table" id="batch-files-list">
                                                                                <thead>
                                                                                    <th>{{ Form::checkbox('check-all', '') }}</th>
                                                                                    <th class="text-center">Filename</th>
                                                                                    <th class="text-center">Uploaded</th>
                                                                                    <th class="text-center">Downloaded</th>
                                                                                    <th class="text-center">Download</th>
                                                                                    <th class="text-center">Shipping</th>
                                                                                </thead>
                                                                                <tbody>
                                                                            @foreach ($batch['files'] as $file)
                                                                                <tr>
                                                                                    <td>{{ Form::checkbox('download-file[]', $file->id) }}</td>
                                                                                    <td>{{ $file->filename_original }}</td>
                                                                                    <td class="text-center show-tooltip" title="{{ $file->formattedCreatedAt(true) }}">
                                                                                        {{ $file->formattedCreatedAt() }}
                                                                                    </td>
                                                                                    <td class="text-center show-tooltip" title="{{ $file->formattedExpiresAt(true) }}">
                                                                                        @if ($file->created_at == $file->updated_at)
                                                                                            N/A
                                                                                        @else
                                                                                            {{ $file->updated_at->format('g:ia \o\n M j, Y') }}
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($file->download_status)
                                                                                            <a href="{{ route('file_download_single', $file->id) }}" class="btn btn-success show-tooltip" title="Download {{ $file->filename_original }} again"><i class="icon-cloud-download"></i></a>
                                                                                        @else
                                                                                            <a href="{{ route('file_download_single', $file->id) }}" class="btn btn-danger show-tooltip" title="Download {{ $file->filename_original }}"><i class="icon-cloud-download"></i></a>
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
                                                                        <div class="col-md-3">
                                                                            <h4><i class="icon-cloud-download"></i> Download Center</h4>
                                                                            <hr />
                                                                            <button type="submit" class="btn btn-inverse btn-lg btn-block" id="btn-download-as-batch-{{ $batch['id'] }}">Download Checked as .ZIP</button>
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
                                        <div class="alert alert-success lead text-muted text-center">This is the test dashboard.</div>
                                    </div>
                                @else
                                    <div class="alert alert-danger lead text-muted text-center">You haven't received any files as of yet.  <br /><br />Once files have been uploaded, detailed information will be available here.</div>
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