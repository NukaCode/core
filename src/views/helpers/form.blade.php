{{ Form::open(array('id' => $formId, 'files' => true, 'class' => 'form-horizontal')) }}
	<div class="panel panel-default">
		<div class="panel-heading">{{ $formHeader }}</div>
		<div class="panel-body">
			@section('form')
			@show
			{{ Form::bJsonSubmit('Save') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ Form::close() }}

@section('js')
	<script>
		$('#{{ $formId }}').AjaxSubmit({
			path: '/{{ Request::path() }}',
			successMessage: '{{ $successMessage }}',
		});
	</script>
@stop