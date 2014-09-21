<div style="width: 200px;">
    {{ bForm::setType('basic')->setSizes(2,10)->open(true) }}
        {{ bForm::image('avatar') }}
        {{ bForm::submit('Upload', ['class' => 'btn btn-sm btn-primary btn-block']) }}
    {{ bForm::close() }}
</div>