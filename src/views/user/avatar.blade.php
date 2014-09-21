<div class="row">
    <div class="col-md-8">
        {{ bForm::ajaxForm('avatarPreferenceForm', 'Your preference has been updated.')->setType('basic')->open() }}
            <div class="panel panel-default">
                <div class="panel-heading">Customize</div>
                <div class="panel-body">
                    {{ bForm::hidden('avatar_preference_id', $avatarPreference->id) }}
                    {{ bForm::select('avatar_preference', $preferenceArray, $avatarPreference->value, array(), 'Select what to display', 2) }}
                    {{ bForm::jsonSubmit('Save') }}
                </div>
                <div class="panel-footer">
                    <div id="message"></div>
                </div>
            </div>
        {{ bForm::close() }}
    </div>
    <div class="col-md-2" style="min-width: 200px !important;">
         <div class="panel panel-default">
            <div class="panel-heading">Avatar</div>
            <div class="panel-body">
                {{ HTML::image($activeUser->present()->avatar, null, array('class'=> 'media-object', 'style' => 'width: 100px;margin: 0 auto;')) }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="min-width: 200px !important;">
         <div class="panel panel-default">
            <div class="panel-heading">Gravatar</div>
            <div class="panel-body">
                {{ HTML::image($activeUser->present()->onlyGravatar, null, array('class'=> 'media-object', 'style' => 'width: 100px;margin: 0 auto;')) }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>