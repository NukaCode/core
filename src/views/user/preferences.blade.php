{{ bForm::ajaxForm('personal', 'Your preferences have been updated.')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Preferences</div>
		<div class="panel-body">
			@foreach ($preferences as $preference)
				{{ bForm::select(
					'preference['. $preference->keyName .']',
					$preference->getPreferenceOptionsArray(),
					$activeUser->getPreferenceValueByKeyName($preference->keyName),
					array(),
					$preference->name,
					6
				) }}
			@endforeach
			{{ bForm::jsonSubmit('Save') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}