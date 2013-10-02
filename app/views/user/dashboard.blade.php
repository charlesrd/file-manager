@extends('layouts.dashboard_sidebar')

@section('title', 'Dashboard')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Recently Uploaded</h3>
                            </div>
                            <div class="panel-body">
                                @if ($uploadedFiles->count())
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th>Date Uploaded</th>
                                                    <th>Filename</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Tracking #</th>
                                                    <th class="text-center">Expiring</th>
                                                    <th class="text-center visible-md visible-lg"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($uploadedFiles as $file)
                                                        <tr class="table-flag-red">
                                                            <td>{{ $file->formattedCreatedAt() }}</td>
                                                            <td>{{{ $file->filename_original }}}</td>
                                                            <td class="text-center">
                                                                @if ($file->status == 0)
                                                                    <a class="btn btn-danger show-tooltip" title="This file has not yet been downloaded by the recipient."><i class="icon-cloud-download"></i> Not Downloaded</a>
                                                                @else
                                                                    <a class="btn btn-success show-tooltip" title="This file has been downloaded by the recipient."><i class="icon-cloud-download"></i> Downloaded</a>
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
                                                                    <a class="btn btn-primary show-tooltip" title="View file details" href="{{ route('file_history_post') }}" data-toggle="modal" data-target="#modal-file_details" data-id="{{ $file->id }}"><i class="icon-zoom-in"></i> Detail</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        {{ $uploadedFiles->links() }}
                                    </div>
                                    <p class="lead text-muted">
                                        <strong>Note:</strong> Files will automatically be deleted once they have expired after 7 days.
                                    </p>
                                @else
                                    <div class="alert alert-danger text-center">You don't seem to have any recently uploaded files.  <br /><br />Once you've uploaded files, detailed information will be available here.</div>
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
                    }
                );

                $(modal).modal();
            });
        });
    </script>
@stop