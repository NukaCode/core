<?php namespace NukaCode\Core\Models\Observers\User\Preference;

class UserObserver {

    public function saving($model)
    {
        $model->validateValue();
    }
}