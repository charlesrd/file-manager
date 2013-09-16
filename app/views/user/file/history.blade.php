@extends('layouts.dashboard_sidebar')

@section('title', 'File History')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><i class="icon-table"></i> File History</h3>
                            </div>
                            <div class="panel-body">
                                @if ($files->count())
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th>Date Received</th>
                                                    <th># of #</th>
                                                    <th>Filename</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Expiring</th>
                                                    <th class="text-center visible-md visible-lg" style="width:100px"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($files as $file)
                                                        <tr class="table-flag-red">
                                                            <td>{{ date('g:ia \o\n F j, Y', strtotime($file->created_at)) }}</td>
                                                            <td></td>
                                                            <td>{{ $file->filename_original }}</td>
                                                            <td class="text-center">
                                                                @if ($file->status == 0)
                                                                    <a class="btn btn-danger show-tooltip" title="This file has not yet been downloaded.  Click to download."><i class="icon-cloud-download"> Not Downloaded</i></a>
                                                                @else
                                                                    <a class="btn btn-success show-tooltip" title="This file has already been downloaded.  Click to download."><i class="icon-cloud-download"> Downloaded</i></a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (strtotime($file->expiration) > strtotime(date("Y-m-d")))
                                                                    {{ date('F j, Y', strtotime($file->expiration)) }}
                                                                @else
                                                                    Expired
                                                                @endif
                                                            </td>
                                                            <td class="text-center visible-md visible-lg">
                                                                <div class="btn-group">
                                                                    <a class="label label-default label-xlarge show-tooltip" title="View file details" href="{{ route('file_history_post') }}" data-toggle="modal" data-target="#modal-file_details" data-id="{{ $file->id }}"><i class="icon-zoom-in"></i> Detail</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        {{ $files->links() }}
                                    </div>
                                @else
                                    <div class="alert alert-danger">You don't seem to have any file history.  Once you've uploaded files, detailed information will be available here.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal-file_details" tabindex="-1" role="dialog" aria-hidden="true">
                </div><!-- /.modal -->
@stop

@section('extra-scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $("a[data-toggle=modal]").click(function(e) {
                e.preventDefault();

                var post_url = $(this).attr("href");
                var modal = $(this).attr("data-target");
                var file_id = $(this).attr("data-id");

                $.post(
                    post_url,
                    {
                        _token: "{{ Session::token() }}",
                        file_id: file_id
                    },
                    function(response, status, xhr) {
                        $(modal).html(response);
                        //console.log("response = " + response + " with status = " + status);
                    }
                );

                $(modal).modal();
            });
        });
    </script>
@stop