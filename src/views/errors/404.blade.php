<div class="row">
	<div class="col-md-offset-4 col-md-4">
		<div class="well text-center">
			<div class="well-title">
				404 File Not Found Error
			</div>
			Sorry, the page you are looking for could not be found. <br />
			@if (Session::has('errorMessage'))
				Error Message: {{ Session::get('errorMessage') }}
			@endif
		</div>
	</div>
</div>