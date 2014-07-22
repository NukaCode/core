<div class="panel panel-default">
    <div class="panel-heading" onClick="collapse('rolesTable');">
        Roles
    </div>
    <table class="table table-hover rolesTable" style="display: none;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Key Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->keyName }}</td>
            <td><a href="javascript:void(0);" class="viewDetails popover-dismiss" data-toggl="popover" title="Actions for {{ $role->name }}" data-placement="left" data-content="{{ $role->present()->actionList }}">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if ($roles->getTotal() > $roles->getPerPage())
        <div class="panel-footer rolesTable" style="display: none;">
            {{ $roles->links() }}
        </div>
    @endif
</div>