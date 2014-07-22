{{ bForm::ajaxForm('actionEdit', 'Action updated.')->open() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h3 id="myModalLabel">Edit {{ $preference->present()->name }}</h3>
    </div>
    <div class="modal-body">
        {{ bForm::text('id', $preference->id, ['readonly' => 'readonly'], 'Id') }}
        {{ bForm::text('name', $preference->name, null, 'Name') }}
        {{ bForm::text('keyName', $preference->keyName, null, 'Key Name') }}
        {{ bForm::textarea('description', $preference->description, ['style' => 'height: 100px'], 'Description') }}
        {{ bForm::text('value', $preference->value, null, 'Value') }}
        {{ bForm::text('default', $preference->default, null, 'Default') }}
        {{ bForm::select('display', ['select' => 'Select', 'text' => 'Text', 'textarea' => 'Text Area', 'radio' => 'Radio'], $preference->display, null, 'Display') }}
        {{ bForm::select('hiddenFlag', ['No', 'Yes'], $preference->hiddenFlag, null, 'Hidden?') }}
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            {{ Form::submit('Submit',['class' => 'btn btn-sm btn-primary']) }}
            <a href="javascript: void(0);" class="btn btn-sm btn-inverse closeModal" data-area="preference">Close</a>
        </div>
        <div id="message"></div>
    </div>
{{ bForm::close() }}