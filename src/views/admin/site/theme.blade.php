{{ bForm::setSizes(4, 8)->ajaxForm('submitForm', 'Site theme has been updated.')->open() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h3 id="myModalLabel">Customize Site Theme</h3>
    </div>
    <div class="modal-body">
    	{{ bForm::select('style', ['dark' => 'Dark', 'default' => 'Default'], Config::get('core::theme.theme.style'), null, 'Style') }}
    	{{ bForm::select('src', ['local' => 'Local', 'vendor' => 'Vendor'], Config::get('core::theme.theme.src'), null, 'Source') }}
		@foreach ($colors as $color => $values)
			{{ bForm::color($color, $values['hex'], array('id' => $color .'Input'), $values['title']) }}
		@endforeach
	</div>
	<div class="modal-footer">
		{{ bForm::jsonSubmit('Save') }}
		<div id="message"></div>
	</div>
{{ Form::close() }}