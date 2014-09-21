@if ($settings->header != null)
	@include($settings->header)
@endif

<div class="row">
	<div class="col-md-2">
		@foreach ($settings->panels as $panel)
			<div class="panel panel-default">
				@if ($settings->collapsible == false)
					<div class="panel-heading">{{ $panel->title }}</div>
					<ul class="list-group">
				@else
					<div class="panel-heading" onClick="collapse('{{ $panel->id }}');">{{ $panel->title }}</div>
					<ul class="list-group" id="{{ $panel->id }}" style="{{ !Session::get('COLLAPSE_'. $panel->id) ? 'display: none;' : null }}">
				@endif
					@foreach ($panel->tabs as $tab)
						<li class="list-group-item">
							@if (isset($tab->options['badge']))
								<span class="badge">{{ $tab->options['badge'] }}</span>
							@endif
							<a href="javascript: void(0);" class="ajaxLink" id="{{ $tab->id }}" data-location="{{ $tab->path }}">{{ ucwords($tab->title) }}</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endforeach
	</div>
	<div class="col-md-10">
		<div id="ajaxContent">
			{{ $settings->loadingIcon }}
		</div>
	</div>
</div>

@section('js')
	<script>
		var url   = location.href;
		var parts = url.split('#');

		if (parts[1] != null) {
			$('#'+ parts[1]).parent().addClass('active');
			$('#ajaxContent').html('{{ $settings->loadingIcon }}');
			$('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
		} else {
			$('#{{ $settings->defaultTab }}').parent().addClass('active');
			$('#ajaxContent').html('{{ $settings->loadingIcon }}');
			$('#ajaxContent').load($('#{{ $settings->defaultTab }}').attr('data-location'));
		}
		$('.ajaxLink').click(function() {

			$('.ajaxLink').parent().removeClass('active');
			$(this).parent().addClass('active');

			var link = $(this).attr('id');
			$('#ajaxContent').html('{{ $settings->loadingIcon }}');
			$('#ajaxContent').load($(this).attr('data-location'));
			$("html, body").animate({ scrollTop: 0 }, "slow");
		});

		function collapse (target) {
			$('#'+ target).toggle();
			$.get('/collapse/'+ target);
		}
	</script>
@stop