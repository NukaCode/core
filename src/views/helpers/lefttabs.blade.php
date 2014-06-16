@if ($settings->header != null)
	@include($settings->header)
@endif
<div class="row">
	<div class="col-md-2">
		@foreach ($settings->panels as $title => $details)
			<div class="panel panel-default">
				@if ($details->preference == null)
					<div class="panel-heading">{{ $title }}</div>
					<ul class="list-group">
				@else
					<div class="panel-heading" onClick="collapse('{{ $details->preference }}');">{{ $title }}</div>
					<ul class="list-group" id="{{ $details->preference }}" style="{{ !Session::get('COLLAPSE_'. $details->preference) ? 'display: none;' : null }}">
				@endif
					@foreach ($details->items as $key => $item)
						<li class="list-group-item"><a href="javascript: void(0);" class="ajaxLink" id="{{ $key }}">{{ ucwords($item) }}</a></li>
					@endforeach
				</ul>
			</div>
		@endforeach
	</div>
	<div class="col-md-10">
		<div id="ajaxContent">
			<i class="fa fa-spin fa-spinner"></i>
		</div>
	</div>
</div>

<script>
	@section('onReadyJs')
		$.AjaxLeftTabs('{{ $settings->ajax->link }}', '{{ $settings->ajax->initial }}');
	@endsection
</script>

@section('js')
	<script>
		function collapse (target) {
			$('#'+ target).toggle();
			$.get('/collapse/'+ target);
		}
	</script>
@stop