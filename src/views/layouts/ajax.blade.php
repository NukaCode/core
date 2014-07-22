@section('ajaxCss')
@show
@section('cssForm')
@show

@if (isset($content))
	{{ $content }}
@endif

<!-- JS Include -->
@section('jsInclude')
@show

<!-- JS Include Form -->
@section('jsIncludeForm')
@show

<script>
    $(document).ready(function() {
        // On Ready Js
        @section('onReadyJs')
        @show
        // On Ready Js Form
        @section('onReadyJsForm')
        @show
    });
</script>

<!-- JS -->
@section('js')
@show

<!-- JS Form -->
@section('jsForm')
@show