<?php namespace NukaCode\Core\Presenters\User\Permission;

use NukaCode\Core\Presenters\CorePresenter;

class ActionPresenter extends CorePresenter {

    public function roleList()
    {
        if ($this->roles->count() > 0) {
            return implode('<br />', $this->roles->name->toArray());
        }

        return 'None';
    }
} 