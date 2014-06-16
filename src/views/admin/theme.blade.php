{{ bForm::setSizes(2, 2)->ajaxForm('submitForm', 'Site theme has been updated.')->open() }}
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Customize site theme</div>
				<div class="panel-body">
					@foreach ($colors as $color => $values)
						{{ bForm::color($color, $values['hex'], array('id' => $color .'Input'), $values['title']) }}
					@endforeach
					{{ bForm::jsonSubmit('Save') }}
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}