<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Forgot Password</div>
			<div class="panel-body">
				{{ bForm::open() }}
					{{ bForm::email('email', null, array('id' => 'email', 'required' => 'required', 'placeholder' => 'Email'), 'Email', 4) }}
					{{ bForm::submitReset('Send new password', 'Reset Fields') }}
				{{ bForm::close() }}
			</div>
		</div>
	</div>
</div>