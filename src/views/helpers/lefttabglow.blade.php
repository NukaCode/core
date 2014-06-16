@if ($settings->header != null)
	@include($settings->header)
@endif

<div class="row">
	<div class="col-md-2">
		@foreach ($settings->panels as $panel)
			<div class="panel panel-default">
				@if ($settings->collapasable == false)
					<div class="panel-heading">{{ $panel->title }}</div>
					<div class="list-glow">
						<ul class="list-glow-group no-header">
				@else
					<div class="panel-heading" onClick="collapse('{{ $panel->id }}');">{{ $panel->title }}</div>
					<div class="list-glow">
						<ul class="list-glow-group no-header" id="{{ $panel->id }}" style="{{ !Session::get('COLLAPSE_'. $panel->id) ? 'display: none;' : null }}">
				@endif
					@foreach ($panel->tabs as $tab)
						<li id="{{ $tab->id }}_tab">
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-12">
									@if (isset($tab->options['badge']))
										<span class="badge">{{ $tab->options['badge'] }}</span>
									@endif
									<a href="javascript: void(0);" class="ajaxLink block" id="{{ $tab->id }}" data-location="{{ $tab->path }}">
										{{ ucwords($tab->title) }}
									</a>
								</div>
							</div>
						</li>
					@endforeach
					</ul>
				</div>
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
			$('#'+ parts[1] +'_tab').addClass('active');
			$('#ajaxContent').html('{{ $settings->loadingIcon }}');
			$('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
		} else {
			$('#{{ $settings->defaultTab }}_tab').addClass('active');
			$('#ajaxContent').html('{{ $settings->loadingIcon }}');
			$('#ajaxContent').load($('#{{ $settings->defaultTab }}').attr('data-location'));
		}
		$('.ajaxLink').click(function() {

			$('.ajaxLink').parent().parent().parent().removeClass('active');
			$(this).parent().parent().parent().addClass('active');

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