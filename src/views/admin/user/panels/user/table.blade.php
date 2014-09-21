<div class="panel panel-default">
    <div class="panel-heading" onClick="collapse('usersTable');">
        Users
    </div>
    <table class="table table-hover usersTable" style="display: none;">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Roles</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->present()->username }}</td>
            <td>{{ $user->present()->email }}</td>
            <td><a href="javascript:void(0);" class="viewDetails popover-dismiss" data-toggl="popover" title="Roles for {{ $user->present()->username }}" data-placement="left" data-content="{{ $user->present()->roleList }}">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if ($users->getTotal() > $users->getPerPage())
        <div class="panel-footer usersTable" style="display: none;">
            {{ $users->links() }}
        </div>
    @endif
</div>