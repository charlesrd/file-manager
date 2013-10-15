@extends('layouts.dashboard_sidebar')

@section('title', 'Dashboard')

@section('main-content')
                <!--<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>At A Glance</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>Test</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae, rerum, magni, deserunt, veniam nemo non molestiae sed earum reiciendis velit impedit voluptatibus laboriosam amet tenetur ex commodi similique! Maxime, facilis!</p>
                                    </div>
                                    <div class="col-md-4">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia, ex, beatae, quam, aliquid aperiam qui harum laborum dicta illum quo doloremque minus rerum repellat et veritatis cumque aliquam odio possimus.
                                    </div>
                                    <div class="col-md-4">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia, ex, beatae, quam, aliquid aperiam qui harum laborum dicta illum quo doloremque minus rerum repellat et veritatis cumque aliquam odio possimus.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Recently Received</h3>
                            </div>
                            <div class="panel-body">
                                @if ($receivedFiles->count())
                                    <div class="table-responsive">
                                        <table class="table table-advance">
                                            <thead>
                                                <tr>
                                                    <th>Date Received</th>  
                                                    <th>From</th>
                                                    <th>Filename</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Expiring</th>
                                                    <th class="text-center visible-md visible-lg"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($receivedFiles as $file)
                                                        <tr class="table-flag-red">
                                                            <td>{{ $file->formattedCreatedAt() }}</td>
                                                            <td>{{ DB::table('users')->where('id', '=', $file->user_id)->pluck('email') }}</td>
                                                            <td>{{ $file->filename_original }}</td>
                                                            <td class="text-center">
                                                                @if ($file->download_status == 0)
                                                                    <a class="btn btn-danger show-tooltip" title="This file has not yet been downloaded.  Click to download."><i class="icon-cloud-download"></i> Not Downloaded</a>
                                                                @else
                                                                    <a class="btn btn-success show-tooltip" title="This file has already been downloaded.  Click to download."><i class="icon-cloud-download"></i> Downloaded</a>
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
                                                                    <a class="btn btn-primary show-tooltip" title="View file details" href="{{ route('file_detail_post') }}" data-toggle="modal" data-target="#modal-file_details" data-id="{{ $file->id }}"><i class="icon-zoom-in"></i> Detail</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        {{ $receivedFiles->links() }}
                                    </div>
                                @else
                                    <div class="alert alert-danger lead text-muted text-center">You don't seem to have any file history.  Once you've uploaded files, detailed information will be available here.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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