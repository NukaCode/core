{{ bForm::ajaxForm('personal', 'Your profile has been updated.')->open() }}
 <div class="panel panel-default">
    <div class="panel-heading">Personal Information</div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-md-6">
                {{ bForm::text('displayName', $activeUser->displayName, array('class' => 'input-block-level', 'placeholder' => 'How a stranger should greet you.'), 'Display Name') }}
                {{ bForm::text('firstName', $activeUser->firstName, array('class' => 'input-block-level', 'placeholder' => 'The goofy name your mom gave you.'), 'First Name') }}
                {{ bForm::text('lastName', $activeUser->lastName, array('class' => 'input-block-level', 'placeholder' => 'The name you almost never hear.'), 'Last Name') }}
                {{ bForm::jsonSubmit('Save') }}
            </div>
            <div class="col-md-6">
                {{ bForm::email('email', $activeUser->email, array('class' => 'input-block-level', 'placeholder' => 'Your email address.', 'required' => 'required'), 'Email Address') }}
                {{ bForm::text('location', $activeUser->location, array('class' => 'input-block-level', 'placeholder' => 'Where you live?'), 'Location') }}
                {{ bForm::text('url', $activeUser->url, array('class' => 'input-block-level', 'placeholder' => 'URL of your site.'), 'URL') }}
            </div>
            <br />
        </div>
    </div>
    <div class="panel-footer">
        <div id="message"></div>
    </div>
</div>
{{ bForm::close() }}