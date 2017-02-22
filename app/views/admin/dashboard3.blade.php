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
                                                    <th class="text-center visible-lg">Phone</th>
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
                                                            <td class="text-center visible-lg">
                                                                {{ $batch['from_lab_name'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $batch['from_lab_phone'] }}
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
                                                        </tr>
                                                        <tr id="collapse-batch_details_{{ $batch['id'] }}" class="collapse batch-details">
                                                            <td colspan="7">
                                                                {{ Form::open(array('route' => 'file_download_checked', 'name' => 'form-batch-files', 'id' => 'form-batch-files-' . $batch['id'], 'data-batch-id' => $batch['id'])) }}
                                                                    <div class="row batch-details-row">
                                                                       <div class="col-md-12">
                                                                            <h4><i class="icon-file"></i> Files</h4>
                                                                            <hr />
                                                                            <table class="table" id="batch-files-list">
                                                                                <thead>
                                                                                    <th>{{ Form::checkbox('check-all', '') }}</th>
                                                                                    <th class="text-center">Filename</th>
                                                                                    <th class="text-center">Uploaded</th>
                                                                                    <th class="text-center">Downloaded</th>
                                                                                    <th class="text-center">Milling Type</th>
                                                                                    <!-- <th class="text-center">Milling Date</th> -->
                                                                                    <th class="text-center">Shipping Type</th>
                                                                                    <!-- <th class="text-center">Shipping Date</th> -->
                                                                                </thead>
                                                                                <tbody>

                                                                            <div style="display:none;">{{ $DOWNLOADED_COUNT = 0; }}</div>

                                                                            @foreach ($batch['files'] as $file)
                                                                                <tr>
                                                                                    <td>{{ Form::checkbox('download-file[]', $file->id) }}</td>
                                                                                    <td>
                                                                                        @if ($file->created_at == $file->updated_at)
                                                                                            <a href="{{ route('file_download_single', $file->id) }}" class="show-tooltip" title="Download {{ $file->filename_original }}">{{ $file->filename_original }}</a>
                                                                                        @else
                                                                                            <a href="{{ route('file_download_single', $file->id) }}" onclick="return confirm('This file was already downloaded at {{ $file->updated_at->format('g:ia \o\n M j, Y') }}. Are you sure that you want to download it again?');" class="show-tooltip" title="Download {{ $file->filename_original }}">{{ $file->filename_original }}</a>
                                                                                            <div style="display:none;">{{ $DOWNLOADED_COUNT++; }}</div>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center show-tooltip" title="{{ $file->formattedCreatedAt(true) }}">
                                                                                        {{ $file->formattedCreatedAt() }}
                                                                                    </td>
                                                                                    @if ($file->created_at == $file->updated_at)
                                                                                        <td class="text-center show-tooltip" title="File Not Downloaded">N/A
                                                                                    @else
                                                                                        <td class="text-center show-tooltip" title="{{ $file->updated_at->diffForHumans() }}">{{ $file->updated_at->format('g:ia \o\n M j, Y') }}
                                                                                    @endif
                                                                                    </td>

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
                                                                                    <!-- <td class="text-center"></td> -->
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
                                                                                    <!-- <td class="text-center"></td> -->
                                                                                </tr>
                                                                            @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        {{ Form::hidden('batch_from_lab_name', $batch['from_lab_name']) }}
                                                                        {{ Form::hidden('batch_from_lab_email', $batch['from_lab_email']) }}
                                                                        {{ Form::hidden('batch_id', $batch['id']) }}
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-1">
                                                                            @if ($DOWNLOADED_COUNT > 0)
                                                                                <button type="submit" onclick="return confirm('Files from this batch were already downloaded. Are you sure that you want to download files from this batch again?');" class="btn btn-inverse btn-lg btn-block" style="height: 100%; width: 95%;" id="btn-download-as-batch-{{ $batch['id'] }}"><i class="fa fa-download"></i> Checked</button>
                                                                            @else
                                                                                <button type="submit" class="btn btn-inverse btn-lg btn-block" style="height: 100%; width: 95%;" id="btn-download-as-batch-{{ $batch['id'] }}"><i class="fa fa-download"></i> Checked</button>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            @if ($DOWNLOADED_COUNT > 0)
                                                                                <a href="{{ route('file_download_batch', $batch['id']) }}" onclick="return confirm('Files from this batch were already downloaded. Are you sure that you want to download files from this batch again?');" style="height: 100%; width: 95%;" class="btn btn-inverse btn-lg btn-block"><i class="fa fa-download"></i> Batch</a>
                                                                            @else
                                                                                <a href="{{ route('file_download_batch', $batch['id']) }}" style="height: 100%; width: 95%;" class="btn btn-inverse btn-lg btn-block"><i class="fa fa-download"></i> Batch</a>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            @if (!empty($batch['message']))
                                                                                <div class="alert alert-info text-center lead text-warning">
                                                                                    <strong>{{ $batch['message'] }}</strong>
                                                                                </div>
                                                                            @else
                                                                                <div class="alert alert-info text-center lead">
                                                                                    No message attached.
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                {{ Form::close() }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
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
            $("button[id^=btn-download-as-batch]").prop('disabled', true);
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

                $($(this).data("target")).slideToggle(300);

            }).hover( function() {
                $(this).toggleClass('hover');
            });
        });
    </script>
@stop