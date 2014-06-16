	<div class="col-md-4" style="display: none;">
		<div class="panel panel-default">
			<div class="panel-heading">
				Add/Update
				<div class="panel-btn">
					<a href="javascript: void(0);" onClick="addPanel()"><i class="fa fa-times"></i></a>
				</div>
			</div>
			{{ Form::open(array('id' => 'submitForm', 'class' => 'form-horizontal', 'files' => true)) }}
				<div class="panel-body">
					<div class="form-group">
						<div class="col-md-9">
							{{ Form::text('id', null, array('id' => 'id', 'readonly' => 'readonly', 'placeholder' => 'Existing Id', 'class' => 'form-control')) }}
						</div>
						<div class="col-md-1">
							<a href="javascript:void(0);" data-target="#helpModal" data-toggle="modal" class="fa fa-white fa fa-question-circle"></a>
						</div>
					</div>
					@foreach ($settings->formFields as $key => $details)
						<?php $placeholder = (isset($details->placeholder) ? $details->placeholder : ucwords($key)); ?>
						@if ($details->field == 'image')
							<div class="fileupload fileupload-new" data-provides="fileupload" data-name="image">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									{{ HTML::image('img/noImage.gif', null, array('style' => 'width: 200px;')) }}
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
								<div>
									<span class="btn btn-file btn-primary">
										<span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<input id="image" type="file" />
									</span>
									<a href="javascript: void(0);" class="btn fileupload-exists btn-danger" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						@endif
						<div class="form-group">
							<div class="col-md-10">
								@if ($details->field == 'text')
									{{ Form::text($key, null, array('id' => 'input_'. $key, 'placeholder' => $placeholder, 'class' => 'form-control')) }}
								@elseif ($details->field == 'email')
									{{ Form::email($key, null, array('id' => 'input_'. $key, 'placeholder' => $placeholder, 'class' => 'form-control')) }}
								@elseif ($details->field == 'textarea')
									{{ Form::textarea($key, null, array('id' => 'input_'. $key, 'placeholder' => $placeholder, 'class' => 'form-control')) }}
								@elseif ($details->field == 'select')
									{{ Form::select($key, $details->selectArray, null, array('id' => 'input_'. $key, 'class' => 'form-control')) }}
								@elseif ($details->field == 'multiselect')
									{{ Form::select($key .'[]', $details->selectArray, null, array('id' => 'input_'. $key, 'multiple' => 'multiple', 'style' => 'height: 200px;', 'class' => 'form-control')) }}
								@elseif ($details->field == 'checkbox')
									<label class="col-md-2 control-label" for="{{ $key }}">{{ $placeholder }}</label>
									{{ Form::checkbox($key, 1, null, array('id' => $key, 'class' => 'form-control')) }}
								@endif
							</div>
						</div>
					@endforeach
					<div class="form-group">
						<div class="col-md-10">
							<div class="btn-group">
								{{ Form::submit('Submit', array('class' => 'btn btn-sm btn-primary', 'id' => 'jsonSubmit')) }}
								{{ Form::reset('Reset Fields', array('class' => 'btn btn-sm btn-inverse')) }}
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
				<div class="clearfix"></div>
			{{ Form::close(); }}
		</div>
	</div>