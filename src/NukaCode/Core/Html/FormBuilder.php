<?php namespace NukaCode\Core\Html;

use Illuminate\Foundation\Application;
use Illuminate\Html\FormBuilder as BaseFormBuilder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\Factory;

class FormBuilder {

	protected $html;

	protected $form;

	protected $request;

	protected $view;

	protected $app;

	protected $url;

	public    $labelSize       = 2;

	public    $inputSize       = 10;

	public    $iconSize        = 0;

	public    $formId          = null;

	public    $type            = 'horizontal';

	protected $customFormGroup = 0;

	public    $allowedTypes    = [
		'basic'      => null,
		'inline'     => 'form-inline',
		'horizontal' => 'form-horizontal',
	];

	public function __construct(HtmlBuilder $html, Request $request, Factory $view, Application $app, UrlGenerator $url)
	{
		$this->html    = $html;
		$this->request = $request;
		$this->view    = $view;
		$this->app     = $app;
		$this->url     = $url;

		$this->form = new BaseFormBuilder($this->html, $this->url, $this->app['session.store']->getToken());
	}

	public function get()
	{
		return $this;
	}

	public function setType($type)
	{
		if (! array_key_exists($type, $this->allowedTypes)) {
			throw new \InvalidArgumentException('Form type not allowed.');
		}

		$this->type = $type;

		return $this;
	}

	public function setSizes($labelSize, $inputSize = null, $iconSize = null)
	{
		$this->labelSize = $labelSize;

		if ($inputSize == null) {
			$inputSize = 12 - $labelSize;
		}
		$this->inputSize = $inputSize;
		$this->iconSize  = $iconSize;

		return $this;
	}

	public function open($files = true, $options = [])
	{
		$formClass = $this->allowedTypes[$this->type];

		if (! isset($options['class'])) {
			$options['class'] = $formClass;
		} elseif (strpos($options['class'], $formClass) === false) {
			$options['class'] = $options['class'] . ' ' . $formClass;
		}

		if ($this->formId != null) {
			$options['id'] = $this->formId;
		}

		if ($files == true) {
			if (! isset($options['files'])) {
				$options['files'] = true;
			}
		}

		return $this->form->open($options);
	}

	public function formGroup()
	{
		$this->customFormGroup = 1;

		return <<<EOT
<div class="form-group">
EOT;
	}

	public function endFormGroup()
	{
		$this->customFormGroup = 0;

		return <<<EOT
</div>
EOT;
	}

	public function remoteModalRouteIcon($route, $icon)
	{
		$inputOpen  = $this->getIconWrapperOpen();
		$inputClose = $this->getInputWrapperClose();

		return <<<EOT
$inputOpen
		<a role="button" href="#remoteModal" data-toggle="modal" data-remote="$route">
        <i class="$icon"></i>
    </a>
    $inputClose
EOT;

	}

	public function ajaxForm($formId, $message)
	{
		$this->formId = $formId;

		$this->setAjaxFormRequirements($message);

		return $this;
	}

	protected function addToSection($section, $data)
	{
		if (! array_key_exists($section . 'Form', $this->view->getSections())) {
			$data = "@parent " . $data;
		}

		$this->view->inject($section . 'Form', $data);
	}

	protected function setAjaxFormRequirements($message)
	{
		$this->addToSection('js', '
<script>
	$(\'#' . $this->formId . '\').AjaxSubmit({
		path:\'/' . $this->request->path() . '\',
		successMessage:\'' . $message . '\'
	});
</script>
		');
	}

	public function close()
	{
		return $this->form->close();
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
					$class = ' class="col-md-' . $this->labelSize . ' control-label"';
					break;
			}

			return '<label' . $class . 'for="' . $name . '">' . $text . '</label>';
		}

		return null;
	}

	public function hidden($name, $value, $attributes = [])
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('text', $attributes);

		return $this->form->hidden($name, $value, $attributes);
	}

	public function date($name, $value, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('date', $attributes);

		// Create the default input
		$input = $this->form->input('date', $name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function text($name, $value, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('text', $attributes);

		// Create the default input
		$input = $this->form->text($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function textarea($name, $value, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('textarea', $attributes);

		// Create the default input
		$input = $this->form->textarea($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function email($name, $value, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('email', $attributes);

		// Create the default input
		$input = $this->form->email($name, $value, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function password($name, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('password', $attributes);

		// Create the default input
		$input = $this->form->password($name, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	protected function createCheckbox($name, $value, $checked, $attributes, $label)
	{
		return '
		<div class="checkbox">
			<label>' .
			   $this->form->checkbox($name, $value, $checked, $attributes) . ' ' . $label
			   . '</label>
		</div>
		';
	}

	public function checkbox($name, $value, $checked = false, $attributes = [], $label = null)
	{
		switch ($this->type) {
			case 'horizontal':
				return '
					<div class="form-group">
						<div class="col-md-offset-' . $this->labelSize . ' col-md-' . $this->inputSize . '">' .
					   $this->createCheckbox($name, $value, $checked, $attributes, $label)
					   . '</div>
					</div>
				';
				break;
			default:
				return $this->createCheckbox($name, $value, $checked, $attributes, $label);
				break;
		}
	}

	public function select($name, $optionsArray, $selected, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('select', $attributes);

		// Create the default input
		$input = $this->form->select($name, $optionsArray, $selected, $attributes);

		return $this->createOutput($name, $label, $input);
	}

	public function select2($name, $optionsArray, $selected, $attributes = [], $label = null, $placeholder = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('select2', $attributes);
		$multiple   = in_array('multiple', $attributes);

		// Create the default input
		$input = $this->form->select($name, $optionsArray, $selected, $attributes);

		// Add the jquery
		$this->setSelect2Requirements($attributes['id'], $placeholder, $multiple);

		return $this->createOutput($name, $label, $input);
	}

	protected function setSelect2Requirements($id, $placeholder, $multiple)
	{
		if ($multiple) {
			$script = <<<EOT
@parent
$('#$id').select2({placeholder: '$placeholder'});
EOT;
		} else {
			$script = <<<EOT
@parent
$('#$id')
			 .prepend('<option/>')
			 .val(function(){return $('[selected]',this).val() ;})
			 .select2({
				placeholder: '$placeholder'
			 });
EOT;
		}

		return $this->addToSection('onReadyJs', $script);
	}

	public function color($name, $value, $attributes = [], $label = null)
	{
		// Set up the attributes
		$attributes = $this->verifyAttributes('color', $attributes);

		// Set up the label
		$label = $this->setUpLabel($name, $label);

		// Create the default input
		$input = $this->form->text($name, $value, $attributes);

		$this->setColorRequirements();

		$formInput = '
		<div class="form-group">' .
					 $label .
					 $this->getInputWrapperOpen()
					 . '<div class="input-group">
					<span class="input-group-addon" id="colorPreview' . $name . '" style="background-color: ' . $value . ';">&nbsp;</span>' .
					 $input
					 . '</div>' .
					 $this->getInputWrapperClose()
					 . '</div>';

		return $formInput;
	}

	public function setColorRequirements()
	{
		static $exists = false;

		if (! $exists) {
			$this->addToSection('css', $this->html->style('vendor/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'));
			$this->addToSection('jsInclude', $this->html->script('vendor/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'));
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
		$input = $this->form->file($name);

		$this->setImageRequirements();
		$inputOpen  = $this->getInputWrapperOpen();
		$inputClose = $this->getInputWrapperClose();

		$formInput = <<<EOT
<div class="form-group">
	$label
	$inputOpen
		<div>
			<div class="fileinput fileinput-new text-center" data-provides="fileinput" style="width: 200px;">
				<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
					<img src="$existingImage" alt="..." />
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
				<div>
					<span class="btn btn-sm btn-primary btn-block btn-file">
						<span class="fileinput-new">Select image</span>
						<span class="fileinput-exists">Change</span>
						$input
					</span>
					<a href="javascript:void(0);" class="btn btn-sm btn-block btn-inverse fileinput-exists" data-dismiss="fileinput">Remove</a>
				</div>
			</div>
		</div>
	$inputClose
</div>
EOT;

		return $formInput;
	}

	public function setImageRequirements()
	{
		static $exists = false;

		if (! $exists) {
			$this->addToSection('jsInclude', $this->html->script('vendor/jasny-bootstrap/dist/js/jasny-bootstrap.min.js'));
			$this->addToSection('css', $this->html->style('vendor/jasny-bootstrap/dist/css/jasny-bootstrap.min.css'));

			$exists = true;
		}
	}

	public function submit($value = null, $parameters = array('class' => 'btn btn-sm btn-primary'))
	{
		if (! isset($parameters['class'])) {
			$parameters['class'] = 'btn btn-sm btn-primary';
		}

		return '<div class="form-group">' .
			   $this->getSubmitWrapperOpen() .
			   $this->form->submit($value, $parameters) .
			   $this->getInputWrapperClose()
			   . '</div>';
	}

	public function jsonSubmit($value = null, $parameters = array('class' => 'btn btn-sm btn-primary'))
	{
		if (! isset($parameters['id'])) {
			$parameters['id'] = 'jsonSubmit';
		}
		if (! isset($parameters['class'])) {
			$parameters['class'] = 'btn btn-sm btn-primary';
		}

		return '<div class="form-group">' .
			   $this->getSubmitWrapperOpen() .
			   $this->form->submit($value, $parameters) .
			   $this->getInputWrapperClose()
			   . '</div>';
	}

	public function submitReset($submitValue = 'Submit', $resetValue = 'Reset',
								$submitParameters = array('class' => 'btn btn-sm btn-primary'),
								$resetParameters = array('class' => 'btn btn-sm btn-inverse'))
	{
		return '<div class="form-group">' .
			   $this->getSubmitWrapperOpen()
			   . '<div class="btn-group">' .
			   $this->form->submit($submitValue, $submitParameters) .
			   $this->form->reset($resetValue, $resetParameters)
			   . '</div>' .
			   $this->getInputWrapperClose()
			   . '</div>';
	}

	/**
	 * @param string $submitValue
	 * @param string $cancelValue
	 * @param array  $submitParameters
	 * @param array  $cancelParameters
	 *
	 * @return string
	 */
	public function submitCancel($submitValue = 'Submit', $cancelValue = 'Cancel',
								 $submitParameters = array('class' => 'btn btn-sm btn-primary'),
								 $cancelParameters = array('class' => 'btn btn-sm btn-inverse'))
	{
		return '<div class="form-group">' .
			   $this->getSubmitWrapperOpen()
			   . '<div class="btn-group">' .
			   $this->form->submit($submitValue, $submitParameters) .
			   '<a href="javascript: void(0);" ' . $this->html->attributes($cancelParameters) . ' data-dismiss="modal">' . $cancelValue . '</a>'
			   . '</div>' .
			   $this->getInputWrapperClose()
			   . '</div>';
	}

	protected function getSubmitWrapperOpen()
	{
		switch ($this->type) {
			case 'horizontal':
				return '<div class="col-md-offset-' . $this->labelSize . ' col-md-' . $this->inputSize . '">';
				break;
		}

		return null;
	}

	protected function createOutput($name, $label, $input)
	{
		// Set up the label
		$label = $this->setUpLabel($name, $label);

		$formGroupOpen  = $this->customFormGroup == 0 ? '<div class="form-group">' : null;
		$formGroupClose = $this->customFormGroup == 0 ? '</div>' : null;
		$inputOpen      = $this->getInputWrapperOpen();
		$inputClose     = $this->getInputWrapperClose();

		return <<<EOT
$formGroupOpen
			$label
			$inputOpen
			$input
			$inputClose
			$formGroupClose
EOT;
	}

	public function verifyAttributes($input, $attributes)
	{
		// Input specific attributes
		if ($input == 'color') {
			if (! isset($attributes['class'])) {
				$attributes['class'] = 'colorpicker';
			} elseif (strpos($attributes['class'], 'colorpicker') === false) {
				$attributes['class'] = $attributes['class'] . ' colorpicker';
			}
		}
		if ($input == 'select2') {
			if (! isset($attributes['id'])) {
				$attributes['id'] = Str::random(10);
			}
		}

		// All inputs
		if (! isset($attributes['class'])) {
			$attributes['class'] = 'form-control';
		} elseif (strpos($attributes['class'], 'form-control') === false) {
			$attributes['class'] = ' form-control ' . $attributes['class'];
		}

		return $attributes;
	}

	protected function getInputWrapperOpen()
	{
		switch ($this->type) {
			case 'horizontal':
				return '<div class="col-md-' . $this->inputSize . '">';
				break;
		}

		return null;
	}

	protected function getIconWrapperOpen()
	{
		switch ($this->type) {
			case 'horizontal':
				return '<div class="col-md-' . $this->iconSize . '">';
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
