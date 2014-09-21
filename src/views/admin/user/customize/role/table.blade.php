@include(
    'helpers.panels.paginated',
    [
        'header'  => 'Roles',
        'thead'   => ['Group', 'Name', 'Priority', 'Actions', 'Actions:text-right'],
        'data'    => $roles,
        'view'    => 'admin.user.customize.role.row',
        'viewRow' => 'role'
    ]
)

<script>
    @section('onReadyJs')
        $('.viewDetails').popover({
            trigger: 'hover',
            html: true
        });
    @stop
</script>