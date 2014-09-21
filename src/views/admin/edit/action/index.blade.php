{{ bForm::ajaxForm('actionEdit', 'Action updated.')->open() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h3 id="myModalLabel">Edit {{ $action->present()->name }}</h3>
    </div>
    <div class="modal-body">
        {{ bForm::text('id', $action->id, ['readonly' => 'readonly'], 'Id') }}
        {{ bForm::text('name', $action->name, null, 'Name') }}
        {{ bForm::text('keyName', $action->keyName, null, 'Key Name') }}
        {{ bForm::textarea('description', $action->description, ['style' => 'height: 100px'], 'Description') }}
        {{ bForm::select('roles[]', $roles, $action->roles->id->toArray(), ['multiple' => 'multiple', 'class' => 'form-control', 'style' => 'height: 105px;'], 'Roles') }}
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            {{ Form::submit('Submit',['class' => 'btn btn-sm btn-primary']) }}
            <a href="javascript: void(0);" class="btn btn-sm btn-inverse closeModal" data-area="action">Close</a>
        </div>
        <div id="message"></div>
    </div>
{{ bForm::close() }}