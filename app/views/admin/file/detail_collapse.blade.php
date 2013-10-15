<h4>{{ $file->filename_original }}</h4>
<dl class="dl-horizontal">
	<dt><i class="icon-envelope"></i> Lab</dt>
	<dd>
		{{{ $data['from_lab_name'] }}}
	</dd>
	<dt><i class="icon-envelope"></i> Email</dt>
	<dd>
		{{{ $data['from_lab_email'] }}}
	</dd>
	<dt><i class="icon-folder-open"></i> Date Uploaded</dt>
	<dd>{{{ $file->formattedCreatedAt() }}}</dd>
	<dt><i class="icon-comment"></i> Message</dt>
	<dd>{{ $batch->message }}</dd>
	<dt><i class="icon-cloud-download"></i> Download Status</dt>
	<dd>{{ $file->download_status ? "Downloaded" : "Not Yet Downloaded" }}</dd>
	<dt><i class="icon-truck"></i> Shipping Status</dt>
	<dd>{{ $file->shipping_status ? "Shipped" : "Not Shipped" }}</dd>
	@if ($file->shipping_status && !is_null($file->tracking) && $file->tracking != '')
	<dt>Tracking #</dt>
	<dd>
			{{{ $file->tracking }}}
	</dd>
	@endif
	{{ link_to_route('file_download', 'Download This File', $file->id) }}
</dl>