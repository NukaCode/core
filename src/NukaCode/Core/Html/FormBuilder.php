<?php namespace NukaCode\Core\Html;

use HTML;
use Form;

class FormBuilder {

	public $labelSize = 2;

	public $inputSize = 10;

	public $formId = null;

	public $type = 'horizontal';

	public $allowedTypes = [
		'basic'      => null,
		'inline'     => 'form-inline',
		'horizontal' => 'form-horizontal',
	];

	public function get()
	{
		return $this;
	}

	public function setType($type)
	{
		if (!array_key_exists($type, $this->allowedTypes)) {
			throw new Exception('Form type not allowed.');
		}

		$this->type = $type;

		return $this;
	}

	public function setSizes($labelSize, $inputSize = null)
	{
		$this->labelSize = $labelSize;

		if ($inputSize == null) {
			$inputSize = 12 - $labelSize;
		}
		$this->inputSize = $inputSize;

		return $this;
	}

	public function open($files = true, $options = array())
	{
		$formClass = $this->allowedTypes[$this->type];

		if (!isset($options['class'])) {
			$options['class'] = $formClass;
		} elseif (strpos($options['class'], $formClass) === false) {
			$options['class'] = $options['class'] .' '. $formClass;
		}

		if($this->formId != null) {
			$options['id'] = $this->formId;
		}

		if ($files == true) {
			if (!isset($options['files'])) {
				$options['files'] = true;
			}
		}

		return Form::open($options);
	}

	public function ajaxForm($formId, $message)
	{
		$this->formId = $formId;

		$this->setAjaxFormRequirements($message);

		return $this;
	}

	protected function addToSection($section, $data)
	{
		if (!array_key_exists($section .'Form', \View::getSections())) {
			$data = "@parent ". $data;
		}

		\View::inject($section .'Form', $data);
	}

	protected function setAjaxFormRequirements($message)
	{
		$this->addToSection('js', '
<script>
	$(\'#'. $this->formId .'\').AjaxSubmit({
		path:\'/'. \Request::path() .'\',
		successMessage:\''. $message .'\'
	});
</script>
		');
	}

	public function close()
	{
		return Form::close();
	}

	public function setUpLabel($name, $text)
	{
		if ($text != null) {
			switch ($this->type) {
				case 'basic':
					$class = null;
				break;
				case 'inline':
					$class = ' class="sr-only"';
				break;
				case 'horizontal':
					$class = ' class="col-md-'. $this->labelSize .' control-label"';
				break;
			}

			return '<label'. $class .'for="'. $name .'">'. $text .'</label>';
		}

		return null;
	}

	public function hidden($name, $value, $attributes = array())
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('text', $attributes);

		return Form::hidden($name, $value, $attributes);
	}

	public function date($name, $value, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('date', $attributes);

		// Create the default input
		$input = Form::input('date', $name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function text($name, $value, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('text', $attributes);

		// Create the default input
		$input = Form::text($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function textarea($name, $value, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('textarea', $attributes);

		// Create the default input
		$input = Form::textarea($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function email($name, $value, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('email', $attributes);

		// Create the default input
		$input = Form::email($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function password($name, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('password', $attributes);

		// Create the default input
		$input = Form::password($name, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	protected function createCheckbox($name, $value, $checked, $attributes, $label)
	{
		return '
		<div class="checkbox">
			<label>'.
				Form::checkbox($name, $value, $checked, $attributes) .' '. $label
			.'</label>
		</div>
		';
	}

	public function checkbox($name, $value, $checked = false, $attributes = array(), $label = null)
	{
		// Create the default input
		$input = Form::checkbox($name, $value, $checked);

		switch ($this->type) {
			case 'horizontal':
				return '
					<div class="form-group">
						<div class="col-md-offset-'. $this->labelSize .' col-md-'. $this->inputSize .'">'.
							$this->createCheckbox($name, $value, $checked, $attributes, $label)
						.'</div>
					</div>
				';
			break;
			default:
				return $this->createCheckbox($name, $value, $checked, $attributes, $label);
			break;
		}
	}

	public function select($name, $optionsArray, $selected, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('select', $attributes);

		// Create the default input
		$input = Form::select($name, $optionsArray, $selected, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function color($name, $value, $attributes = array(), $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('color', $attributes);

		// Set up the label
		$label = $this->setUpLabel($name, $label);

		// Create the default input
		$input = Form::text($name, $value, $attributes);

		$this->setColorRequirements();

		$formInput = '
		<div class="form-group">'.
			$label .
			$this->getInputWrapperOpen()
				.'<div class="input-group">
					<span class="input-group-addon" id="colorPreview'. $name .'" style="background-color: '. $value .';">&nbsp;</span>'.
					$input
				.'</div>'.
			$this->getInputWrapperClose()
		.'</div>';

		return $formInput;
	}

	public function setColorRequirements()
	{
		static $exists = false;

		if (!$exists) {
			$this->addToSection('css', HTML::style('vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css'));
			$this->addToSection('jsInclude', HTML::script('vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js'));
			$this->addToSection('onReadyJs', '
$(\'.colorpicker\').colorpicker().on(\'changeColor\', function(ev){
	$(\'#colorPreview\'+ $(this).attr(\'name\')).css(\'background-color\', ev.color.toHex());
});
			');

			$exists = true;
		}
	}

	public function image($name, $existingImage = null, $label = null)
	{
		// make sure we have an image
		if ($existingImage == null) {
			$existingImage = '/img/no_user.png';
		}

		// Set up the label
		$label = $this->setUpLabel($name, $label);

		// Create the default input
		$input = Form::file($name);

		$this->setImageRequirements();

		$formInput = '
		<div class="form-group">'.
			$label .
			$this->getInputWrapperOpen()
				.'<div>
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
							<img src="'. $existingImage .'" alt="...">
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
						<div>
							<span class="btn btn-sm btn-primary btn-file">
								<span class="fileinput-new">Select image</span>
								<span class="fileinput-exists">Change</span>'.
								$input
							.'</span>
							<a href="javascript:void(0);" class="btn btn-sm btn-inverse fileinput-exists" data-dismiss="fileinput">Remove</a>
						</div>
					</div>
				</div>'.
			$this->getInputWrapperClose()
		.'</div>';

		return $formInput;
	}

	public function setImageRequirements()
	{
		static $exists = false;

		if (!$exists) {
			$this->addToSection('jsInclude', HTML::script('vendor/jansyBootstrap/dist/extend/js/jasny-bootstrap.min.js'));
			$this->addToSection('css', HTML::style('vendor/jansyBootstrap/dist/extend/css/jasny-bootstrap.min.css'));

			$exists = true;
		}
	}

	public function submit($value = null, $parameters = array('class' => 'btn btn-sm btn-primary'))
	{
		if (!isset($parameters['class'])) {
			$parameters['class'] = 'btn btn-sm btn-primary';
		}

		return '<div class="form-group">'.
			$this->getSubmitWrapperOpen() .
				Form::submit($value, $parameters) .
			$this->getInputWrapperClose()
		.'</div>';
	}

	public function jsonSubmit($value = null, $parameters = array('class' => 'btn btn-sm btn-primary'))
	{
		if (!isset($parameters['id'])) {
			$parameters['id'] = 'jsonSubmit';
		}
		if (!isset($parameters['class'])) {
			$parameters['class'] = 'btn btn-sm btn-primary';
		}

		return '<div class="form-group">'.
			$this->getSubmitWrapperOpen() .
				Form::submit($value, $parameters) .
			$this->getInputWrapperClose()
		.'</div>';
	}

	public function submitReset($submitValue = 'Submit', $resetValue = 'Reset', $submitParameters = array('class' => 'btn btn-sm btn-primary'), $resetParameters = array('class' => 'btn btn-sm btn-inverse'))
	{
		return '<div class="form-group">'.
			$this->getSubmitWrapperOpen()
				.'<div class="btn-group">'.
					Form::submit($submitValue, $submitParameters).
					Form::reset($resetValue, $resetParameters)
				.'</div>'.
			$this->getInputWrapperClose()
		.'</div>';
	}

	protected function getSubmitWrapperOpen()
	{
		switch ($this->type) {
			case 'horizontal':
				return '<div class="col-md-offset-'. $this->labelSize .' col-md-'. $this->inputSize .'">';
			break;
		}

		return null;
	}

	protected function createOutput($name, $label, $input)
	{
		// Set up the label
		$label = $this->setUpLabel($name, $label);

		$formInput = '
		<div class="form-group">'.
			$label .
			$this->getInputWrapperOpen() .
				$input .
			$this->getInputWrapperClose()
		.'</div>';

		return $formInput;
	}

	public function verifyAttributes($input, $attributes)
	{
		// Input specific attributes
		if ($input == 'color') {
			if (!isset($attributes['class'])) {
				$attributes['class'] = 'colorpicker';
			} elseif (strpos($attributes['class'], 'colorpicker') === false) {
				$attributes['class'] = $attributes['class'] .' colorpicker';
			}
		}

		// All inputs
		if (!isset($attributes['class'])) {
			$attributes['class'] = 'form-control';
		} elseif (strpos($attributes['class'], 'form-control') === false) {
			$attributes['class'] = ' form-control '. $attributes['class'];
		}

		return $attributes;
	}

	protected function getInputWrapperOpen()
	{
		switch ($this->type) {
			case 'horizontal':
				return '<div class="col-md-'. $this->inputSize .'">';
			break;
		}

		return null;
	}

	protected function getInputWrapperClose()
	{
		switch ($this->type) {
			case 'horizontal':
				return '</div>';
			break;
		}

		return null;
	}

	public function getJsInclude()
	{
		return implode("\n", $this->jsInclude);
	}

	public function getJs()
	{
		return implode("\n", $this->js);
	}

	public function getOnReadyJs()
	{
		return implode("\n", $this->onReadyJs);
	}

	public function getCss()
	{
		return implode("\n", $this->css);
	}
}