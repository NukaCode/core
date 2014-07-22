{{ bForm::ajaxForm('userEdit', 'User updated.')->open() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h3 id="myModalLabel">Edit {{ $user->present()->username }}</h3>
    </div>
    <div class="modal-body">
        {{ bForm::text('id', $user->id, ['readonly' => 'readonly'], 'Id') }}
        {{ bForm::text('username', $user->username, null, 'Username') }}
        {{ bForm::email('email', $user->email, null, 'Email') }}
        {{ bForm::text('firstName', $user->firstName, null, 'First Name') }}
        {{ bForm::text('lastName', $user->lastName, null, 'Last Name') }}
        {{ bForm::select('roles[]', $roles, $user->roles->id->toArray(), ['multiple' => 'multiple', 'class' => 'form-control', 'style' => 'height: 105px;'], 'Roles') }}
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            {{ Form::submit('Submit',['class' => 'btn btn-sm btn-primary']) }}
            <a href="javascript: void(0);" class="btn btn-sm btn-inverse closeModal" data-area="user" data-dismiss="modal">Close</a>
        </div>
        <div id="message"></div>
    </div>
{{ bForm::close() }}