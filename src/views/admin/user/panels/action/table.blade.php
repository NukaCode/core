<div class="panel panel-default">
    <div class="panel-heading" onClick="collapse('actionsTable');">
        Actions
    </div>
    <table class="table table-hover actionsTable" style="display: none;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Key Name</th>
            <th>Roles</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($actions as $action)
        <tr>
            <td>{{ $action->name }}</td>
            <td>{{ $action->keyName }}</td>
            <td><a href="javascript:void(0);" class="viewDetails popover-dismiss" data-toggl="popover" title="Roles for {{ $action->name }}" data-placement="left" data-content="{{ $action->present()->roleList }}">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if ($actions->getTotal() > $actions->getPerPage())
        <div class="panel-footer actionsTable" style="display: none;">
            {{ $actions->links() }}
        </div>
    @endif
</div>