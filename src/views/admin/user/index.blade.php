<div class="row" style="margin: 0 auto;">
    @include('admin.partials.box', ['size' => 2, 'color' => 'primary', 'header' => 'Users', 'subHeader' => $users->count(), 'icon' => 'fa-user', 'editText' => null])
    @include('admin.partials.box', ['size' => 2, 'color' => 'success', 'header' => 'Roles', 'subHeader' => $roles->count(), 'icon' => 'fa-cubes', 'editText' => null])
    @include('admin.partials.box', ['size' => 2, 'color' => 'warning', 'header' => 'Actions', 'subHeader' => $actions->count(), 'icon' => 'fa-cube', 'editText' => null])
    @include('admin.partials.box', ['size' => 2, 'color' => 'info', 'header' => 'Preferences', 'subHeader' => $preferences->count(), 'icon' => 'fa-cog', 'editText' => null])
</div>
<hr />
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('usersTable');">
                Users
            </div>
            <table class="table table-hover table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->present()->username }}</td>
                            <td>{{ $user->present()->email }}</td>
                            <td><a href="javascript:void(0);">View</a></td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a href="/admin/user-edit/{{ $user->id }}" data-toggle="modal" data-target="#remoteModal" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{ HTML::linkIcon('/', 'fa fa-trash-o', null, ['class' => 'confirm-remove btn btn-xs btn-danger']) }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-footer" id="users">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('rolesTable');">
                Roles
            </div>
            <table class="table table-hover" id="rolesTable" style="display: none;">
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
                            <td><a href="javascript:void(0);">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('actionsTable');">
                Actions
            </div>
            <table class="table table-hover" id="actionsTable" style="display: none;">
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
                            <td><a href="javascript:void(0);">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('preferencesTable');">
                Preferences
            </div>
            <table class="table table-hover" id="preferencesTable" style="display: none;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Options</th>
                        <th>Default</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($preferences as $preference)
                        <tr>
                            <td>{{ $preference->name }}</td>
                            <td>{{ $preference->value }}</td>
                            <td>{{ $preference->default }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>