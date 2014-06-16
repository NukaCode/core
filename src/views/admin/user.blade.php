<div class="row" style="margin: 0 auto;">
    @include('admin.partials.box', ['size' => 2, 'color' => 'primary', 'header' => 'Users', 'subHeader' => $users->count(), 'icon' => 'fa-user', 'editText' => 'Edit'])
    @include('admin.partials.box', ['size' => 2, 'color' => 'success', 'header' => 'Roles', 'subHeader' => $roles->count(), 'icon' => 'fa-cubes', 'editText' => 'Edit'])
    @include('admin.partials.box', ['size' => 2, 'color' => 'warning', 'header' => 'Actions', 'subHeader' => $actions->count(), 'icon' => 'fa-cube', 'editText' => 'Edit'])
    @include('admin.partials.box', ['size' => 2, 'color' => 'info', 'header' => 'Preferences', 'subHeader' => $preferences->count(), 'icon' => 'fa-cog', 'editText' => 'Edit'])
</div>
<hr />
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('usersTable');">
                Users
            </div>
            <table class="table table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->present()->username }}</td>
                            <td>{{ $user->present()->email }}</td>
                            <td><a href="javascript:void(0);">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-footer" id="usersTable">
                PAGINATION PLACEHOLDER
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
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
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading" onClick="collapse('actionsTable');">
                Actions
            </div>
            <table class="table table-hover" id="actionsTable" style="display: none;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Key Name</th>
                        <th>Actions</th>
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
    </div>
</div>