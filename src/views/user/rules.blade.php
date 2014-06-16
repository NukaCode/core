{{ Form::open(array('id' => 'submitForm', 'files' => true), 'post') }}

<div class="row">
    <div class="col-md-12">
        <div class="well" id="well">
            <div class="well-title">Add New Rules</div>
            <table class="table table-condensed" id="messageRules">
                <thead>
                    <tr>
                        <th>Condition</th>
                        <th>&nbsp;</th>
                        <th>Folder</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="baseRow">
                        <td style="width: 45%;">
                            <select name="condition" class="input-block-level">
                                <option value="0">Select a condition</option>
                                <optgroup label="Message Types">
                                    @foreach ($messageTypes as $messageType)
                                        <option value="type_{{ $messageType->id }}">{{ $messageType->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Users">
                                    @foreach ($users as $user)
                                        <option value="user_{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </td>
                        <td class="text-center"><i class="fa fa-arrow-right"></i></td>
                        <td style="width: 45%;">
                            <select name="folder" class="input-block-level">
                                <option value="{{ $inbox->id }}">{{ $inbox->name }}</option>
                                @foreach ($folders as $folder)
                                    <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width: 50px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            {{ Form::submit('Save', array('class' => 'btn btn-primary', 'id' => 'jsonSubmit')) }}
            <a href="javascript:void(0);" class="btn btn-primary" onclick="addRule()">Add Rule</a>
            <div id="message"></div>
        </div>
    </div>
</div>
{{ Form::close() }}
@section('js')
    <script>


        $('#submitForm').AjaxSubmit({
            path: '/{{ Request::path() }}',
            successMessage: 'Your password has been updated.'
        });

        function addRule() {
            var base = $('#baseRow');
            var clone = base.clone();

            clone.find('td:last').html('<a href="javascript: void(0);" onClick="removeRow(this);" style="padding-top: 150px;"><i class="fa fa-times-circle"></i></a>');

            $('#messageRules > tbody').append(clone);
        }

        function removeRow(object) {
            if ($('#messageRules > tbody tr').length > 1) {
                $(object).parent().parent().remove();
            } else {
                $(object).parent().parent().find('select').val(0);
                $(object).remove()
            }
        }
    </script>
@stop