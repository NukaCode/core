<tr>
    <td>{{ $user->present()->username }}</td>
    <td>{{ $user->present()->email }}</td>
    <td><a href="javascript:void(0);" class="viewDetails popover-dismiss" data-toggl="popover" title="Roles for {{ $user->present()->username }}" data-content="{{ $user->present()->roleList }}">View</a></td>
    <td class="text-right">
        <div class="btn-group">
            <a href="/admin/edit/user/{{ $user->id }}" data-toggle="modal" data-target="#remoteModal" class="btn btn-xs btn-primary">
                <i class="fa fa-edit"></i>
            </a>
            {{ HTML::linkIcon('/', 'fa fa-trash-o', null, ['class' => 'confirm-remove btn btn-xs btn-danger']) }}
        </div>
    </td>
</tr>