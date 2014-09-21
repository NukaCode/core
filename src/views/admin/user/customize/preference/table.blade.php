@include(
    'helpers.panels.paginated',
    [
        'header'  => 'Preferences',
        'thead'   => ['Name', 'Options', 'Default', 'Actions:text-right'],
        'data'    => $preferences,
        'view'    => 'admin.user.customize.preference.row',
        'viewRow' => 'preference'
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