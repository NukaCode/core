<div class="row">
	<div class="col-md-offset-4 col-md-4">
		<div class="well text-center">
			<div class="well-title">
				401 Unauthorized Error
			</div>
			You are not authorized to view this page. <br />
			@if (Session::has('errorMessage'))
				Error Message: {{ Session::get('errorMessage') }}
			@endif
		</div>
	</div>
</div>