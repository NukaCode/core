<?php namespace NukaCode\Core\Presenters\User\Permission\Role;

use NukaCode\Core\Presenters\CorePresenter;

class UserPresenter extends CorePresenter {

	public function username()
	{
		return ucwords($this->user->username);
	}

	public function roleName()
	{
		return ucwords($this->role->name);
	}
}