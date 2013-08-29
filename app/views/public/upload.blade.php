@section('title', 'Upload Files')

@section('main-content')
    <!-- BEGIN Main Content -->
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="icon-file"></i> Sample Box</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="icon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <p>Blank page</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('extra-scripts')
    @parent

    {{ Html::script('assets/dropzone/downloads/dropzone.min.js') }}
@stop