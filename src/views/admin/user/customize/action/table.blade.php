@include(
    'helpers.panels.paginated',
    [
        'header'  => 'Actions',
        'thead'   => ['Name', 'Key Name', 'Roles', 'Actions:text-right'],
        'data'    => $actions,
        'view'    => 'admin.user.customize.action.row',
        'viewRow' => 'action'
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