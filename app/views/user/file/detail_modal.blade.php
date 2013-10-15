<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">File: {{ $file->filename_original }}</h4>
    </div>
    <div class="modal-body">
      <dl class="dl-horizontal">
        <dt>Message</dt>
        <dd></dd>
        <dt>File Status</dt>
        <dd>{{ $file->shipping_status ? "Shipped" : "Not Shipped" }}</dd>
        <dt>Tracking #</dt>
        <dd>
          @if ($file->shipping_status && !is_null($file->tracking) && $file->tracking != '')
             {{{ $file->tracking }}}
          @else
            N/A
          @endif
        </dd>
      </dl>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
      <button type="button" class="btn btn-success">Track Package</button>
      <button type="button" class="btn btn-primary">Download Single</button>
      <button type="button" class="btn btn-warning">Download Batch</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->