{{ bForm::setSizes(2,2)->ajaxForm('submitForm', 'Your theme has been updated.')->open() }}
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Customize your theme</div>
				<div class="panel-body">
					@foreach ($colors as $color => $values)
						{{ bForm::color($color, $values['hex'], array('id' => $color .'Input'), $values['title']) }}
					@endforeach
					<div class="form-group">
						<div class="col-md-offset-2 col-md-10">
							{{ Form::submit('Save', array('class' => 'btn btn-primary', 'id' => 'jsonSubmit', 'name' => 'submit')) }}
							{{ HTML::link('/user/reset-css', 'Reset CSS', array('class' => 'btn btn-primary')) }}
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}