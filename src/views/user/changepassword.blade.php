{{ bForm::ajaxForm('submitForm', 'Your password has been updated.')->open() }}
    <div class="panel panel-default">
        <div class="panel-heading">User Password</div>
        <div class="panel-body">
            {{ bForm::password('oldPassword', array('class' => 'input-block-level', 'placeholder' => 'Your old password'), 'Old Password', 6) }}
            {{ bForm::password('newPassword', array('class' => 'input-block-level', 'placeholder' => 'Your new password'), 'New Password', 6) }}
            {{ bForm::password('newPasswordAgain', array('class' => 'input-block-level', 'placeholder' => 'Your new password again'), 'Confirm New Password', 6) }}
            {{ bForm::jsonSubmit('Save') }}
        </div>
        <div class="panel-footer">
            <div id="message"></div>
        </div>
    </div>
{{ bForm::close() }}