@extends('layouts.dashboard_sidebar')

@section('title', 'Search Results for: ' . Input::get('search'))

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>File History</h3>
                            </div>
                            <div class="panel-body">
                                @if ($searchResults->count())
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
                                                    @foreach ($searchResults as $file)
                                                        @if ($file->download_status)
                                                        <tr class="table-flag-green clickable show-tooltip" data-placement="bottom" title="View file details" data-href="{{ route('file_detail_post') }}/{{ $file->id }}" data-placement="bottom" data-toggle="collapse" data-target="#collapse-file_details_{{ $file->id }}" data-id="{{ $file->id }}">
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
                                                        </tr>
                                                        <tr id="collapse-file_details_{{ $file->id }}" class="collapse">
                                                            <td colspan="7">

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        {{ $searchResults->links() }}
                                    </div>
                                    <div class="alert alert-info lead text-muted text-center">
                                        <strong><i class="icon-cloud-download"></i> </strong> Files can be downloaded for 7 days.  Download access to files will be removed after their expiration.
                                    </div>
                                @else
                                    <div class="alert alert-danger lead text-muted text-center">Sorry, your search for <code>{{ $searchPhrase }}</code> did not return any results.  Please try another search term.</div>
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
        });
    </script>
@stop