<?php namespace NukaCode\Core\Presenters\User\Permission;

use NukaCode\Core\Presenters\CorePresenter;

class RolePresenter extends CorePresenter {

    public function fullname()
    {
        return $this->group .' - '. $this->name;
    }

    public function actionList()
    {
        if ($this->actions->count() > 0) {
            return implode('<br />', $this->actions->name->toArray());
        }

        return 'None';
    }
}