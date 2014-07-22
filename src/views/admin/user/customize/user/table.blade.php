@include(
    'helpers.panels.paginated',
    [
        'header'  => 'Users',
        'thead'   => ['Username', 'Email', 'Roles', 'Actions:text-right'],
        'data'    => $users,
        'view'    => 'admin.user.customize.user.row',
        'viewRow' => 'user'
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