<div class="row">
	<div class="col-md-offset-1 col-md-10 fuelux">
			<div id="MyWizard" class="wizard">
				<ul class="steps">
					@foreach ($settings->steps as $step => $text)
						<?php
							$step = $step + 1;
							if ($step == 1) {
								$class      = ' class="active"';
								$badgeClass = ' badge-info';
							} else {
								$class      = '';
								$badgeClass = '';
							}
						?>
						<li data-target="#step{{ $step }}"{{ $class }}><span class="badge{{ $badgeClass }}">{{ $step }}</span>{{ $text }}<span class="chevron"></span></li>
					@endforeach
				</ul>
				<div class="actions">
					<button type="button" class="btn btn-xs btn-primary btn-prev"> <i class="fa fa-arrow-left"></i>Prev</button>
					<button type="button" class="btn btn-xs btn-primary btn-next" data-last="Finish">Next<i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		<div class="step-content well">
			{{ bForm::open(true, array('id' => 'submitForm')) }}
				@foreach ($settings->steps as $step => $text)
					<?php
						$step = $step + 1;
						if ($step == 1) {
							$class = ' active';
						} else {
							$class = '';
						}
					?>
					<div class="step-pane{{ $class }}" id="step{{ $step }}">
						@include($settings->viewLocation .'.step'. $step)
					</div>
				@endforeach
				<input type="button" class="btn btn-xs btn-primary" id="btnWizardPrev" value="Prev">
				<input type="button" class="btn btn-xs btn-primary" id="btnWizardNext" value="Next">
			{{ bForm::close() }}
		</div>
	</div>
</div>
<div id="helpModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Help</h3>
	</div>
	<div class="modal-body">
		<div id="configDescription"></div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
@section('jsInclude')
	{{ HTML::script('/vendor/fuelux/dist/loader.min.js') }}
@stop
@section('js')
	<script>
		$('#MyWizard').wizard();
		$('#btnWizardPrev').on('click', function() {
			$('#MyWizard').wizard('previous');
		});
		$('#btnWizardNext').on('click', function() {
			$('#MyWizard').wizard('next');
		});
	</script>
@stop