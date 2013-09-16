@extends('layouts.dashboard_sidebar')

@section('title', 'File History')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-black">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> File History</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="table-responsive">
                                    <table class="table table-advance">
                                        <thead>
                                            <tr>
                                                <th>Date Received</th>
                                                <th>Filename</th>
                                                <th class="text-center">Status</th>
                                                <th class="visible-md visible-lg" style="width:130px">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($files as $file)
                                                <tr class="table-flag-red">
                                                    <td>{{ date('g:ia \o\n F j, Y', strtotime($file->created_at)) }}</td>
                                                    <td>{{ $file->filename_original }}</td>
                                                    <td class="text-center"><span class="label label-success">Not Downloaded</span></td>
                                                    <td class="visible-md visible-lg">
                                                        <div class="btn-group">
                                                            <a class="btn btn-primary btn-sm show-tooltip" title="View file details" href="{{ route('file_history_post') }}" data-toggle="modal" data-target="#modal-file_details" data-id="{{ $file->id }}"><i class="icon-zoom-in"></i> Detail</a>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal-file_details" tabindex="-1" role="dialog" aria-hidden="true">
                </div><!-- /.modal -->
@stop

@section('extra-styles')
    {{ Html::style('assets/data-tables/DT_bootstrap.css') }}
@stop

@section('extra-scripts')
    {{ Html::script('assets/data-tables/jquery.dataTables.js') }}
    {{ Html::script('assets/data-tables/DT_bootstrap.js') }}

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