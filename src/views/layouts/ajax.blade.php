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
        bootbox.setDefaults({backdrop: false});

        $("a.confirm-remove").click(function(e) {
            e.preventDefault();
            var location = $(this).attr('href');
            bootbox.dialog({
                message: "Are you sure you want to remove this item?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-primary",
                        callback: function() {
                            window.location.replace(location);
                        }
                    },
                    danger: {
                        label: "No",
                        className: "btn-primary"
                    }
                }
            });
        });
        $("a.confirm-continue").click(function(e) {
            e.preventDefault();
            var location = $(this).attr('href');
            bootbox.dialog({
                message: "Are you sure you want to continue?",
                buttons: {
                    danger: {
                        label: "No",
                        className: "btn-primary"
                    },
                    success: {
                        label: "Yes",
                        className: "btn-primary",
                        callback: function() {
                            window.location.replace(location);
                        }
                    },
                }
            });
        });
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
