<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="well text-center">
			<div class="well-title">
				An error has occurred.
			</div>
			Please go back and try again. <br />
			@if (Session::has('errorMessage'))
				Error Message: {{ Session::get('errorMessage') }}
            @elseif (isset($message) && $message != null)
                <br />
                Error Message: {{ $message }}
			@endif
		</div>
	</div>
</div>