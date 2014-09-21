<tr>
    <td>{{ $preference->present()->name }}</td>
    <td>{{ $preference->present()->value }}</td>
    <td>{{ $preference->present()->default }}</td>
    <td class="text-right">
        <div class="btn-group">
            <a href="/admin/edit/preference/{{ $preference->id }}" data-toggle="modal" data-target="#remoteModal" class="btn btn-xs btn-primary">
                <i class="fa fa-edit"></i>
            </a>
            {{ HTML::linkIcon('/', 'fa fa-trash-o', null, ['class' => 'confirm-remove btn btn-xs btn-danger']) }}
        </div>
    </td>
</tr>