<?php namespace NukaCode\Core\Presenters\User;

use NukaCode\Core\Presenters\CorePresenter;

class PreferencePresenter extends CorePresenter {

	public function hidden()
	{
		return $this->hiddenFlag == 1 ? 'Hidden' : null;
	}
}