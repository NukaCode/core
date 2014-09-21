{{ bForm::ajaxForm('roleEdit', 'Role updated.')->open() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h3 id="myModalLabel">Edit {{ $role->present()->name }}</h3>
    </div>
    <div class="modal-body">
        {{ bForm::text('id', $role->id, ['readonly' => 'readonly'], 'Id') }}
        {{ bForm::text('group', $role->group, null, 'Group') }}
        {{ bForm::text('name', $role->name, null, 'Name') }}
        {{ bForm::text('keyName', $role->keyName, null, 'Key Name') }}
        {{ bForm::text('priority', $role->priority, null, 'Priority') }}
        {{ bForm::select('actions[]', $actions, $role->actions->id->toArray(), ['multiple' => 'multiple', 'class' => 'form-control', 'style' => 'height: 105px;'], 'Actions') }}
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            {{ Form::submit('Submit',['class' => 'btn btn-sm btn-primary']) }}
            <a href="javascript: void(0);" class="btn btn-sm btn-inverse closeModal" data-area="role">Close</a>
        </div>
        <div id="message"></div>
    </div>
{{ bForm::close() }}