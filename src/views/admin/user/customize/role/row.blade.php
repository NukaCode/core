<tr>
    <td>{{ $role->present()->group }}</td>
    <td>{{ $role->present()->name }}</td>
    <td>{{ $role->present()->priority }}</td>
    <td><a href="javascript:void(0);" class="viewDetails popover-dismiss" data-toggl="popover" title="Actions for {{ $role->present()->name }}" data-content="{{ $role->present()->actionList }}">View</a></td>
    <td class="text-right">
        <div class="btn-group">
            <a href="/admin/edit/role/{{ $role->id }}" data-toggle="modal" data-target="#remoteModal" class="btn btn-xs btn-primary">
                <i class="fa fa-edit"></i>
            </a>
            {{ HTML::linkIcon('/', 'fa fa-trash-o', null, ['class' => 'confirm-remove btn btn-xs btn-danger']) }}
        </div>
    </td>
</tr>