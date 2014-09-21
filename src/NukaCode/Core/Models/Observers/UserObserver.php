<?php namespace NukaCode\Core\Models\Observers;

use Session;

class UserObserver {

    public function updated($model)
    {
        if (Session::has('activeUser')) {
            // Forget the stored active user when updated
            $storedActiveUser = Session::get('activeUser');

            if ($storedActiveUser->id == $model->id) {
                Session::forget('activeUser');
            }
        }
    }
}