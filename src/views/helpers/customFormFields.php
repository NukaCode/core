<?php

Form::macro('horizontalRow', function($type = 'text', $id, $value, $attributes = array(), $labelText = null, $extra = array())
{
	if ($labelText != null) {
		$displaylabel = '<label class="col-md-2 control-label" for="'. $id .'">'. $labelText .'</label>';
	} else {
		$displaylabel = null;
	}

	$row = '
	<div class="form-group">'.
		$displaylabel
		.'<div class="col-md-10">'.
			Form::$type($id, $value, $attributes, $extra)
		.'</div>
	</div>';

	return $row;
});

Form::macro('bopen', function($parameters) {
	if (!isset($parameters['role'])) {
		$parameters['role'] = 'form';
	}

	return Form::open($parameters);
});

Form::macro('bLabel', function ($name, $text) {
	return '<label class="col-md-2 control-label" for="'. $name .'">'. $text .'</label>';
});

Form::macro('bHidden', function ($name, $value, $attributes = array()) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	return Form::hidden($name, $value, $attributes);
});

Form::macro('bText', function ($name, $value, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::text($name, $value, $attributes)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bTextarea', function ($name, $value, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::textarea($name, $value, $attributes)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bEmail', function ($name, $value, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::email($name, $value, $attributes)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bPassword', function ($name, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::password($name, $attributes)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bCheckbox', function ($name, $value, $checked = false, $label = null, $size = 10) {
	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::checkbox($name, $value, $checked)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bSelect', function ($name, $optionsArray, $selected, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">'.
			Form::select($name, $optionsArray, $selected, $attributes)
		.'</div>
	</div>';

	return $formInput;
});

Form::macro('bColor', function ($name, $value, $attributes = array(), $label = null, $size = 10) {
	if (!isset($attributes['class'])) {
		$attributes['class'] = 'colorpicker form-control';
	} elseif (strpos($attributes['class'], 'form-control') === false) {
		$attributes['class'] = $attributes['class'] .' form-control';
	}

	if (strpos($attributes['class'], 'colorpicker') === false) {
		$attributes['class'] = $attributes['class'] .' colorpicker';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">
			<div class="input-group">
				<span class="input-group-addon" id="colorPreview" style="background-color: '. $value .';">&nbsp;</span>'.
				Form::text($name, $value, $attributes)
			.'</div>
		</div>
	</div>';

	return $formInput;
});

Form::macro('bImage', function($name, $existingImage = null, $label = null, $size = 10) {

	if ($existingImage == null) {
		$existingImage = '/img/no_user.png';
	}

	if ($label != null) {
		$label = Form::bLabel($name, $label);
	}

	$formInput = '
	<div class="form-group">'.
		$label
		.'<div class="col-md-'. $size .'">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
					<img src="'. $existingImage .'" alt="...">
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
				<div>
					<span class="btn btn-sm btn-primary btn-file">
						<span class="fileinput-new">Select image</span>
						<span class="fileinput-exists">Change</span>'.
						Form::file($name)
					.'</span>
					<a href="javascript:void(0);" class="btn btn-sm btn-inverse fileinput-exists" data-dismiss="fileinput">Remove</a>
				</div>
			</div>
		</div>
	</div>';

	return $formInput;
});

Form::macro('bSubmit', function ($value = null, $parameters = array('class' => 'btn btn-sm btn-primary')) {
	return '<div class="form-group">
		<div class="col-md-offset-2 col-md-10">'.
			Form::submit($value, $parameters)
		.'</div>'.
	'</div>';
});

Form::macro('bJsonSubmit', function ($value = null, $parameters = array('class' => 'btn btn-sm btn-primary')) {
	if (!isset($parameters['id'])) {
		$parameters['id'] = 'jsonSubmit';
	}
	if (!isset($parameters['class'])) {
		$parameters['class'] = 'btn btn-sm btn-primary';
	}
	return '<div class="form-group">
		<div class="col-md-offset-2 col-md-10">'.
			Form::submit($value, $parameters)
		.'</div>'.
	'</div>';
});

Form::macro('bSubmitReset', function ($submitValue = 'Submit', $resetValue = 'Reset', $submitParameters = array('class' => 'btn btn-sm btn-primary'), $resetParameters = array('class' => 'btn btn-sm btn-inverse')) {
	return '<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<div class="btn-group">'.
				Form::submit($submitValue, $submitParameters).
				Form::reset($resetValue, $resetParameters)
			.'</div>'.
		'</div>'.
	'</div>';
});