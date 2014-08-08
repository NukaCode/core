<div class="row" style="margin: 0 auto;">
    @include('admin.user.partials.box', ['size' => 2, 'color' => 'primary', 'header' => 'Users', 'subHeader' => $users->getTotal(), 'icon' => 'fa-user', 'editLink' => 'user-customize'])
    @include('admin.user.partials.box', ['size' => 2, 'color' => 'success', 'header' => 'Roles', 'subHeader' => $roles->getTotal(), 'icon' => 'fa-cubes', 'editLink' => 'role-customize'])
    @include('admin.user.partials.box', ['size' => 2, 'color' => 'warning', 'header' => 'Actions', 'subHeader' => $actions->getTotal(), 'icon' => 'fa-cube', 'editLink' => 'action-customize'])
    @include('admin.user.partials.box', ['size' => 2, 'color' => 'info', 'header' => 'Preferences', 'subHeader' => $preferences->getTotal(), 'icon' => 'fa-cog', 'editLink' => 'preference-customize'])
</div>
<hr />
<div class="row">
    <div class="col-md-8" id="customizeArea">
        @include('admin.user.customize.user.table')
    </div>
    <div class="col-md-4">
        @include('admin.user.panels.user.table')
        @include('admin.user.panels.role.table')
        @include('admin.user.panels.action.table')
        @include('admin.user.panels.preference.table')
    </div>
</div>

<script>
    @section('onReadyJs')
        $('.viewDetails').popover({
            trigger: 'hover',
            html: true
        });
    @stop
</script>

@section('js')
    <script>
        $('.customLink').click(function() {

            $('#customizeArea').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#customizeArea').load($(this).attr('data-location'), function (responseText, textStatus, req) {
                if (textStatus == "error") {
                    var details = $.parseJSON(responseText);
                    var error   = details.error;

                    var message = error.type +' '+ error.message +' in '+ error.file +' on line '+ error.line;

                    $('#customizeArea').html(message);
                }
            });
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        function collapse (target) {
            $('.'+ target).toggle();
        }
    </script>
@stop