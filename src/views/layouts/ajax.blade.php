@section('ajaxCss')
@show
@section('cssForm')
@show

@if (isset($content))
	{{ $content }}
@endif

@include('layouts.partials.javascript')