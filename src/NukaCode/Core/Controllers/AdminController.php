<?php namespace NukaCode\Core\Controllers;

class AdminController extends \BaseController {
    
    public function getIndex() {}

    public function getUser()
    {
        $users       = \User::orderByNameAsc()->get();
        $roles       = \User_Permission_Role::orderByNameAsc()->get();
        $actions     = \User_Permission_Action::orderByNameAsc()->get();
        $preferences = \User_Preference::orderByNameAsc()->get();

        $this->setViewData('users', $users);
        $this->setViewData('roles', $roles);
        $this->setViewData('actions', $actions);
        $this->setViewData('preferences', $preferences);
    }
}