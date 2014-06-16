<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Register</div>
			<div class="panel-body">
				{{ bForm::open() }}
					{{ bForm::text('username', null, array('id' => 'username', 'required' => 'required'), 'Username', 4) }}
					{{ bForm::password('password', array('id' => 'password', 'required' => 'required'), 'Password', 4) }}
					{{ bForm::email('email', null, array('id' => 'email', 'required' => 'required'), 'Email', 4) }}
					{{ bForm::submitReset('Complete Registration', 'Reset Fields') }}
				{{ bForm::close() }}
			</div>
		</div>
	</div>
</div>