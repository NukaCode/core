<!doctype html>
<html>
<head>
	@include('layouts.partials.header')
</head>
<body class="app">
	<div id="container">
		@include('layouts.partials.menu')
		<hr />
		<div id="content">
			{{ $content }}
		</div>
	</div>

	@include('layouts.partials.modals')

	<!-- javascript-->
	{{ HTML::script('js/all.js') }}

	@include('layouts.partials.javascript')

</body>
</html>