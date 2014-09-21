<?php namespace NukaCode\Core\Presenters\User\Permission\Action;

use NukaCode\Core\Presenters\CorePresenter;

class RolePresenter extends CorePresenter {

    public function actionName()
    {
        return ucwords($this->action->name);
    }

    public function roleName()
    {
        return ucwords($this->role->name);
    }
}